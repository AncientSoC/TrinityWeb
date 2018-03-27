<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\ResetPasswordForm */

$this->title = Yii::t('frontend', 'Reset password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password flat widget">
    <div class="row justify-content-sm-center">
        <div class="col-md-7">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend','Save'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
