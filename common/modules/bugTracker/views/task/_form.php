<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\bugTracker\models\Task;
use common\modules\bugTracker\models\Project;
use trntv\filekit\widget\Upload;

/* @var $this yii\web\View */
/* @var $model common\modules\bugTracker\models\Task */
/* @var $form yii\widgets\ActiveForm */
$projects = Project::find()->select(['name', 'project_id'])->indexBy('project_id')->column();
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'project_id')->dropDownList($projects, [
                'prompt' => Yii::t('bugTracker','Не выбрано')
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(Task::statuses()); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'priority')->dropDownList(Task::priorities()) ?>
        </div>
    </div>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);
    ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('bugTracker','Создать') : Yii::t('bugTracker','Сохранить'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
