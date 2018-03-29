<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\SignupForm */

$this->title = Yii::t('frontend', 'Signup');
Yii::$app->params['breadcrumbs'][] = $this->title;
\yii\widgets\Pjax::begin(['id' => 'auth-signup']);
?>
    <div class="row justify-content-sm-center">
        <div class="col-md-11">
            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
                'action' => ['/panel/sign-in/signup'],
                'options' => ['data-pjax' => true]
            ]); ?>
                <div class="text-center">
                    <h4><?=Yii::t('frontend','Регистрация')?></h4>
                </div>
                <div class="row no-gutters form-group">
                    <div class="col">
                        <?php echo $form->field($model, 'username', [
                            'template' => '<i class="glyphicon glyphicon-user input-icon"></i>{input}{hint}{error}'
                        ])->passwordInput([
                            'class' => 'form-control parent-input-icon',
                            'placeholder' => $model->getAttributeLabel('username')
                        ]) ?>
                        <?php echo $form->field($model, 'email', [
                            'template' => '<i class="glyphicon glyphicon-envelope input-icon"></i>{input}{hint}{error}',
                            'options' => [
                                'class' => 'form-group mb-0'
                            ]
                        ])->passwordInput([
                            'class' => 'form-control parent-input-icon',
                            'placeholder' => $model->getAttributeLabel('email')
                        ]) ?>
                    </div>
                    <div class="col-1 vert-split"></div>
                    <div class="col">
                        <?php echo $form->field($model, 'password', [
                            'template' => '<i class="fa fa-key input-icon"></i>{input}{hint}{error}'
                        ])->passwordInput([
                            'class' => 'form-control parent-input-icon',
                            'placeholder' => $model->getAttributeLabel('password')
                        ]) ?>
                        <?php echo $form->field($model, 'r_password', [
                            'template' => '<i class="fa fa-key input-icon"></i>{input}{hint}{error}',
                            'options' => [
                                'class' => 'form-group mb-0'
                            ]
                        ])->passwordInput([
                            'class' => 'form-control parent-input-icon',
                            'placeholder' => $model->getAttributeLabel('r_password')
                        ]) ?>
                    </div>
                </div>
                <div class="form-group text-center">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
\yii\widgets\Pjax::end();
?>