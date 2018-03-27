<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
Yii::$app->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login flat widget">
    <div class="row justify-content-sm-center">
        <div class="col-md-7">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php echo $form->field($model, 'identity')->textInput([
                    'placeholder' => $model->getAttributeLabel('identity')
                ]) ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin-bottom:1em;">
                    <small>
                        <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                            'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                        ]) ?>
                    </small>
                </div>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
