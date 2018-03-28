<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model zabachok\vega\models\Project */

$this->title = $model->project_id;
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('bugTracker','Projects'), 'url' => ['index']];
Yii::$app->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->project_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->project_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('bugTracker','Вы уверены, что хотите удалить проект ?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'project_id',
            'name',
            'created_at:datetime',
            'color',
            'status',
        ],
    ]) ?>

</div>
