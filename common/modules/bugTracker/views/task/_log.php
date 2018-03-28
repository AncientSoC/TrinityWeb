<?php

use common\modules\bugTracker\models\Task;

/* @var $model common\modules\bugTracker\models\TaskLog */
/* @var $task common\modules\bugTracker\models\Task */

$attachments = false;

switch ($model->param) {
    case 'status':
        $from = Task::statuses()[$model->from];
        $to = Task::statuses()[$model->to];
        break;
    case 'priority':
        $from = Task::priorities()[$model->from];
        $to = Task::priorities()[$model->to];
        break;
    case 'description':
        $from = $model->from;
        $to = $model->to;
        break;
    case 'attachment':
        $attachments = true;
        $from = $model->from;
        $to = $model->to;
        break;
    default:
        $from = $model->from;
        $to = $model->to;
        break;
}

if($attachments) {
    echo Yii::t('bugTracker','<b>{time}</b> Вложенные файлы: {action} <i><a href="{file}">файл</a></i>', [
        'time' => Yii::$app->formatter->asTime($model->created_at),
        'action' => $to && !$from ? Yii::t('bugTracker','добавил') : Yii::t('bugTracker','удалил'),
        'file' => $to ? $to : $from,
    ]);
} else {
    echo Yii::t('bugTracker','<b>{time}</b> Изменено поле {field} c <i>{from}</i> на <i>{to}</i>', [
        'time' => Yii::$app->formatter->asTime($model->created_at),
        'field' => $task->getAttributeLabel($model->param),
        'from' => $from,
        'to' => $to,
    ]);
}


echo '<br>';