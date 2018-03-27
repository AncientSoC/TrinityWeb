<?php
/** @var $model \common\modules\installer\models\setup\DatabaseForm */
/** @var $success */
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\renderers\ListRenderer;

use common\models\auth\Realmlist;

?>

<div id="database-form" class="panel panel-default">
    <div class="panel-heading">
            <h2 class="text-center"><?=$model->_name?> database configuration!</h2>
    </div>
    <div class="panel-body">
            <p>Below you have to enter your databases connections details. If you’re not sure about these, please contact your administrator.</p>
            <?php
            $form = \yii\widgets\ActiveForm::begin([
                'id'                   => 'database-form',
                'enableAjaxValidation' => false,
            ]);
            ?>
            <div class="row justify-content-center">
                <div class="col-8 col-sm-4">
                    <?=$form->field($model,'host')->textInput([
                        'placeholder' => ''
                    ])->error(false)?>
                </div>
                <div class="col-4 col-sm-3">
                    <?=$form->field($model,'port')->textInput([
                        'placeholder' => ''
                    ])->error(false)?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-7">
                    <?=$form->field($model,'database')->textInput([
                        'placeholder' => 'name of database...'
                    ])->error(false)?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-5">
                    <?=$form->field($model,'login')->textInput([
                        'placeholder' => 'login...'
                    ])->error(false)?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-5">
                    <?=$form->field($model,'password')->passwordInput([
                        'placeholder' => 'password...'
                    ])->error(false)?>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-sm-5">
                    <?=$form->field($model,'table_prefix')->textInput([
                        'placeholder' => 'table prefix ("exmpl_{name}")'
                    ])->error(false)?>
                </div>
            </div>
            <hr/>
            <?php if ($success) { ?>
                <div class="alert alert-success">
                        Yes, database connection works!
                </div>
            <?php } elseif (!empty($errorMsg)) { ?>
                <div class="alert alert-danger">
                        <strong><?= $errorMsg ?></strong>
                </div>
            <?php } ?>
            <div class="text-right">
                <?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>