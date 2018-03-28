<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\bugTracker\models\Project;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->dropDownList(Project::colors()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('bugTracker','Создать') : Yii::t('bugTracker','Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
