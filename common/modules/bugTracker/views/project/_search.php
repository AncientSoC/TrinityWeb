<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-1">
    <?= $form->field($model, 'project_id') ?>
        </div>
        <div class="col-md-2">
    <?= $form->field($model, 'status') ?>
        </div>
    </div>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'color') ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('bugTracker','Искать'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('bugTracker','Сброс'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
