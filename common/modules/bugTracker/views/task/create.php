<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\Task */

$this->title = Yii::t('bugTracker','Создать задачу');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('bugTracker','Задачи'), 'url' => ['index']];
Yii::$app->params['breadcrumbs'][] = $this->title;
?>
<div class="task-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
