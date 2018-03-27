<?php
	/** @var $model \common\modules\installer\models\config\ConfigBasicForm */
?>
<div id="name-form" class="panel panel-default">
    <div class="panel-heading">
        <h2 class="text-center">Application settings</h2>
    </div>
    <div class="panel-body">
        <p>Of course, your new application need a name. Please change the default name with one you like.</p>
        <?php
        $form = \yii\widgets\ActiveForm::begin([
            'id'                   => 'basic-form',
            'enableAjaxValidation' => TRUE,
        ]);
        ?>
            <?=$form->field($model, 'name')->textInput([
                'autofocus'    => 'on',
                'autocomplete' => 'off',
                'class'        => 'form-control'])
            ?>
            <div class="row">
                <div class="col-md-6">
                    <?=$form->field($model, 'email')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
                <div class="col-md-6">
                    <?=$form->field($model, 'robot_email')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-7">
                    <?=$form->field($model, 'smtp_host')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
                <div class="col-3">
                    <?=$form->field($model, 'smtp_port')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
                <div class="col-2">
                    <?=$form->field($model, 'smtp_encrypt')->dropDownList([
                        '' => 'None',
                        'tls' => 'TLS',
                        'ssl' => 'SSL'
                    ],[
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->label('Encrypt')->error(false)
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <?=$form->field($model, 'smtp_console_host')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <?=$form->field($model, 'smtp_username')->textInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
                <div class="col-6">
                    <?=$form->field($model, 'smtp_password')->passwordInput([
                        'autocomplete' => 'off',
                        'class'        => 'form-control'])->error(false)
                    ?>
                </div>
            </div>
            <hr/>
            <div class="text-right">
                <?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php $form::end(); ?>
    </div>
</div>