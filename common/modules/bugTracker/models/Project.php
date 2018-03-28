<?php

namespace common\modules\bugTracker\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "bugtracker_project".
 *
 * @property integer $project_id
 * @property integer $created_at
 * @property string $name
 * @property string $color
 * @property integer $status
 */
class Project extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bugtracker_project}}';
    }

    public static function statuses() {
        return [
            0 => Yii::t('bugTracker','Открыт'),
            1 => Yii::t('bugTracker','В архиве'),
            2 => Yii::t('bugTracker','Удален'),
        ];
    }
    
    public static function colors() {
        return [
            'ff0000',
            '00ff00',
            '0000ff',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'status'], 'integer'],
            [['color'], 'string', 'max' => 6],
            [['name'], 'string', 'max' => 255],
            ['status', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'ID',
            'created_at' => Yii::t('bugTracker','Добавлен'),
            'name' => Yii::t('bugTracker','Наименование'),
            'color' => Yii::t('bugTracker','Цвет'),
            'status' => Yii::t('bugTracker','Статус'),
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
}
