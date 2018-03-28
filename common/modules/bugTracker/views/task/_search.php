<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\bugTracker\models\Task;
use common\modules\bugTracker\models\Project;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\TaskSearch */
/* @var $form yii\widgets\ActiveForm */

$projects = Project::find()->select(['name', 'project_id'])->indexBy('project_id')->column();
?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-1">
            <?= $form->field($model, 'task_id') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'project_id')->dropDownList($projects, ['prompt'=> Yii::t('bugTracker','Не выбрано')]) ?>
        </div>
        <div class="col-md-2">
            <?php echo $form->field($model, 'status')->dropDownList(Task::statuses(true), ['prompt'=>Yii::t('bugTracker','Не выбрано')]) ?>
        </div>
        <div class="col-md-2">
            <?php echo $form->field($model, 'priority')->dropDownList(Task::priorities(), ['prompt'=>Yii::t('bugTracker','Не выбрано')]) ?>
        </div>
        <div class="col-md-5">
            <?php echo $form->field($model, 'title') ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('bugTracker','Искать'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('bugTracker','Сбросить'), ['/vega/task/index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
