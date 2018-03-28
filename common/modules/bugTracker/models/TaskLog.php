<?php

namespace common\modules\bugTracker\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "bugtracker_task_log".
 *
 * @property integer $task_log_id
 * @property integer $task_id
 * @property integer $created_at
 * @property string $param
 * @property integer $from
 * @property integer $to
 */
class TaskLog extends \yii\db\ActiveRecord
{
    public static $seeAttributes = [
        'status',
        'priority',
        'project_id',
        'description',
        'title',
        'attachments',
        'closed_at',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bugtracker_task_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'created_at'], 'integer'],
            [['from', 'to'],'string'],
            [['param'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_log_id' => 'Task Log ID',
            'task_id' => Yii::t('bugTracker','Задача'),
            'user_id' => Yii::t('bugTracker','Пользователь'),
            'created_at' => Yii::t('bugTracker','Дата'),
            'param' => 'Param',
            'from' => Yii::t('bugTracker','Изменено с'),
            'to' => Yii::t('bugTracker','Изменено на'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('UNIX_TIMESTAMP()'),
            ],
        ];
    }

    public static function touch($model, $changedAttributes)
    {
        foreach ($changedAttributes as $key => $value) {
            if (!in_array($key, self::$seeAttributes)) {
                continue;
            }
            $log = new TaskLog(['user_id' => Yii::$app->user->identity->id]);
            $log->attributes = [
                'task_id' => $model->task_id,
                'param' => $key,
                'from' => $value,
                'to' => $model->getOldAttribute($key),
            ];
            $log->save();
        }
    }
}
