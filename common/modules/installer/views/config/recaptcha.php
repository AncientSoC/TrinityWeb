<?php
use common\modules\installer\models\config\RecaptchaForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model  RecaptchaForm */

?>

<div id="recaptcha-form" class="panel panel-default">
    <div class="panel-heading">
        <h2 class="text-center">Recaptcha Configuration!</h2>
    </div>
    <div class="panel-body">
            <?php $form = ActiveForm::begin([]) ?>
                <?= $form->field($model, 'siteKey')->textInput([
                        'class'        => 'form-control',
                        'autofocus'    => 'on',
                        'autocomplete' => 'off'
                    ])
                ?>
                <?= $form->field($model, 'secret')->textInput([
                        'class'        => 'form-control',
                        'autocomplete' => 'off'
                    ])
                ?>
                <hr>
                <?= Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
            <?php $form::end() ?>
    </div>
</div>