<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

Yii::$app->params['breadcrumbs'][] = $this->title;
\yii\widgets\Pjax::begin(['id' => 'auth-login']);
?>
    <div class="row justify-content-sm-center">
        <div class="col-md-10">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => ['/panel/sign-in/login'],
                'options' => ['data-pjax' => true]
            ]); ?>
                <?php echo $form->field($model, 'identity', [
                    'template' => '<i class="glyphicon glyphicon-user input-icon"></i>{input}{hint}{error}'
                ])->textInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('identity')
                ]) ?>
                <?php echo $form->field($model, 'password', [
                    'template' => '<i class="fa fa-key input-icon"></i>{input}{hint}{error}',
                    'options' => [
                        'class' => 'form-group'
                    ]
                ])->passwordInput([
                    'class' => 'form-control parent-input-icon',
                    'placeholder' => $model->getAttributeLabel('password')
                ]) ?>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <?php
                        $field = $form->field($model, 'rememberMe', ['options' => [
                            'class' => 'position-relative'
                        ]]);
                        $field->template = '{input} {label}';
                        echo $field->checkbox([], false)->label($model->getAttributeLabel('rememberMe'),[
                            'class' => 'checkbox-label'
                        ])?>
                    </div>
                </div>
                <div class="text-center">
                    <small>
                        <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}" data-pjax="0">here</a>', [
                            'link'=>yii\helpers\Url::to(['/panel/sign-in/request-password-reset'])
                        ]) ?>
                    </small>
                </div>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
\yii\widgets\Pjax::end();
?>
