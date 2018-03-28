<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\Task */

$this->title = Yii::t('bugTracker','Изменение: {title}',['title' => $model->title]);
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('bugTracker','Задачи'), 'url' => ['index']];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'task_id' => $model->task_id]];
Yii::$app->params['breadcrumbs'][] = Yii::t('bugTracker','Редактирование');
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
