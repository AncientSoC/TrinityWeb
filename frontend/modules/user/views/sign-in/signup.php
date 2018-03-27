<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Signup');
Yii::$app->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup flat widget">
    <div class="row justify-content-sm-center">
        <div class="col-md-10">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $form->field($model, 'username')->textInput([
                            'placeholder' => $model->getAttributeLabel('username')
                        ]) ?>
                        <?php echo $form->field($model, 'email')->textInput([
                            'placeholder' => $model->getAttributeLabel('email')
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $form->field($model, 'password')->passwordInput() ?>
                        <?php echo $form->field($model, 'r_password')->passwordInput() ?>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
