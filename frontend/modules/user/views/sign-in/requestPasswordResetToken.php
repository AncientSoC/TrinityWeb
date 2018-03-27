<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\PasswordResetRequestForm */

$this->title =  Yii::t('frontend', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset flat widget">
    <div class="row justify-content-sm-center">
        <div class="col-md-7">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?php echo $form->field($model, 'email')->textInput([
                    'placeholder' => $model->getAttributeLabel('email')
                ]) ?>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend','Send'), ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
