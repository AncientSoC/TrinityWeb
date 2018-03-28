<?php

namespace common\modules\bugTracker\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use trntv\filekit\behaviors\UploadBehavior;
use yii\db\Expression;
use common\models\User;
use common\modules\bugTracker\models\TaskLog;

/**
 * This is the model class for table "bugtracker_task".
 *
 * @property integer $task_id
 * @property integer $author_id
 * @property integer $project_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $closed_at
 * @property integer $status
 * @property array $attachments
 * @property integer $priority
 * @property string $title
 * @property string $description
 * @property TaskAttachments[] $taskAttachments
 */
class Task extends \yii\db\ActiveRecord
{

    public $attachments;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bugtracker_task}}';
    }

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->author_id = Yii::$app->user->getId();
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'title', 'author_id'], 'required'],
            [['project_id', 'created_at', 'updated_at', 'closed_at', 'status', 'priority', 'author_id'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 46],
            [['project_id', 'status', 'priority'], 'filter', 'filter' => 'intval'],
            ['attachments', 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => Yii::t('bugTracker','Номер'),
            'author_id' => Yii::t('bugTracker','Автор'),
            'project_id' => Yii::t('bugTracker','Проект'),
            'created_at' => Yii::t('bugTracker','Создана'),
            'updated_at' => Yii::t('bugTracker','Изменена'),
            'closed_at' => Yii::t('bugTracker','Закрыта'),
            'status' => Yii::t('bugTracker','Статус'),
            'priority' => Yii::t('bugTracker','Приоритет'),
            'title' => Yii::t('bugTracker','Заголовок'),
            'description' => Yii::t('bugTracker','Описание'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('UNIX_TIMESTAMP()'),
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'taskAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ]
        ];
    }

    public static function priorities() {
        return [
            0 => Yii::t('bugTracker','Низкий'),
            1 => Yii::t('bugTracker','Нормальный'),
            2 => Yii::t('bugTracker','Высокий'),
        ];
    }
    
    public static function statuses($show_all = false) {
        $statuses = [];
        if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),User::PERM_ACCESS_TO_CREATE_TASK) || $show_all) {
            $statuses[0] = Yii::t('bugTracker','Новая');
        }
        if(Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),User::PERM_ACCESS_TO_CHANGE_TASK) || $show_all) {
            $statuses[1] = Yii::t('bugTracker','В работе');
            $statuses[2] = Yii::t('bugTracker','Отложена/Обратная связь');
            $statuses[3] = Yii::t('bugTracker','Исправлено');
            $statuses[4] = Yii::t('bugTracker','Отклонена');
        }
        return $statuses;
    }
    public function beforeSave($insert) {
        if($this->status !== 0 && !Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),User::PERM_ACCESS_TO_CHANGE_TASK)) {
            $this->addError('status',Yii::t('bugTracker','У вас недостаточно прав, чтобы установить текущий статус'));
            return false;
        }
        return parent::beforeSave($insert);
    }
    
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if(!$insert) TaskLog::touch($this, $changedAttributes);
        
        $old_attachments = $this->taskAttachments;
        $new_attachments = $this->attachments;
        
        $deleted = [];
        if($new_attachments) {
            foreach($new_attachments as $new_attachment) {
                $finded = false;
                foreach($old_attachments as $key => $old_attachment) {
                    if($old_attachment->path == $new_attachment['path']) {
                        $finded = true;
                        unset($old_attachments[$key]);
                    }
                }
                if($finded === false) {
                    $log = new TaskLog(['user_id' => Yii::$app->user->identity->id]);
                    $log->attributes = [
                        'task_id' => $this->task_id,
                        'param' => 'attachment',
                        'from' => '',
                        'to' => $new_attachment['base_url'] . '/' . $new_attachment['path'],
                    ];
                    $log->save();
                }
            }
            foreach($old_attachments as $removed) {
                $log = new TaskLog(['user_id' => Yii::$app->user->identity->id]);
                $log->attributes = [
                    'task_id' => $this->task_id,
                    'param' => 'attachment',
                    'from' => $removed->base_url . '/' . $removed->path,
                    'to' => '',
                ];
                $log->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getLog()
    {
        return $this->hasMany(TaskLog::className(), ['task_id' => 'task_id'])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getPlayPeriod()
    {
        return $this->hasOne(Period::className(), ['task_id' => 'task_id'])
            ->where(['end' => null]);
    }

    public function getPeriods()
    {
        return $this->hasMany(Period::className(), ['task_id' => 'task_id'])->orderBy(['start' => SORT_DESC]);
    }

    public function getPeriodsLength()
    {
        return $this->getPeriods()
            ->select(new Expression('SUM(`length`)'))->scalar();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskAttachments()
    {
        return $this->hasMany(TaskAttachments::className(), ['task_id' => 'task_id']);
    }
    
}
