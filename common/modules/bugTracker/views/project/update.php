<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\Project */

$this->title = Yii::t('bugTracker','Редактирование проекта: {project}', ['project' => $model->project_id]);
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('bugTracker','Проекты'), 'url' => ['index']];
Yii::$app->params['breadcrumbs'][] = Yii::t('bugTracker','Редактирование');
?>
<div class="project-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
