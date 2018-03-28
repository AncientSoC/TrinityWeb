<?php

namespace common\modules\bugTracker\models;

use Yii;

/**
 * This is the model class for table "bugtracker_period".
 *
 * @property integer $period_id
 * @property integer $task_id
 * @property integer $start
 * @property integer $end
 * @property integer $length
 * @property string $comment
 */
class Period extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bugtracker_period}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'start', 'end', 'length'], 'integer'],
            [['comment'], 'string', 'max' => 255],
            [['comment'], 'default', 'value' => ''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period_id' => 'Period ID',
            'task_id' => Yii::t('bugTracker','Задача'),
            'start' => Yii::t('bugTracker','Начало'),
            'end' => Yii::t('bugTracker','Конец'),
            'length' => Yii::t('bugTracker','Продолжительность'),
            'comment' => Yii::t('bugTracker','Комментарий'),
        ];
    }

    /**
     * @param $model Task
     * @param $action
     */
    public static function touch($model, $action)
    {
        /** @var Period $period */
        switch ($action) {
            case 'play':
                $model->status = 1;
                $period = new Period();
                $period->start = time();
                break;
            case 'pause':
                $model->status = 2;
                $period = Period::find()->where(['task_id'=>$model->task_id, 'end'=>null])->one();
                $period->end = time();
                break;
            case 'stop':
                $model->status = 3;
                $period = Period::find()->where(['task_id'=>$model->task_id, 'end'=>null])->one();
                $period->end = time();
                break;
            default:
                return false;
                break;
        }
        $model->save();
        $period->task_id = $model->task_id;
        if(!empty($period->end)) $period->length = $period->end - $period->start;
        $period->save();
        return $period;
    }
}
