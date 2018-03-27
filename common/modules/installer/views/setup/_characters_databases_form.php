<?php
/** @var $model \common\modules\installer\models\setup\DatabaseForm */
/** @var $success */
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\renderers\ListRenderer;

use common\models\auth\Realmlist;

?>

<div id="database-form" class="panel panel-default">
    <div class="panel-heading">
            <h2 class="text-center">Database Configuration!</h2>
    </div>
    <div class="panel-body">
            <p>Below you have to enter your databases connections details. If you’re not sure about these, please contact your administrator.</p>
            <?php
                $form = \yii\widgets\ActiveForm::begin([
                    'id'                   => 'database-form',
                    'enableAjaxValidation' => FALSE,
                ]);
            ?>

                <hr/>
                
                <?php
                echo $form->field($model,'dbs')->widget(MultipleInput::class, [
                    'min' => 1,
                    'allowEmptyList'    => false,
                    'enableGuessTitle'  => true,
                    'addButtonPosition' => MultipleInput::POS_ROW,
                    'rendererClass' => ListRenderer::className(),
                    'columns' => [
                        [
                            'name'  => 'name',
                            'type'  => 'dropDownList',
                            'items' => function() {
                                $return_data = [];
                                foreach(Yii::$app->CharactersDbHelper->getServers() as $server) {
                                    $return_data['char_' . $server['id']] = $server['name'] .
                                            ' | ' .
                                            $server['address'] .
                                            ':' .
                                            $server['port'];
                                }
                                return $return_data;
                            },
                            'title' => 'Name',
                            'defaultValue' => '',
                            'options' => [
                                'placeholder' => 'Type realmname here...',
                            ]
                        ],
                        [
                            'name'  => 'host',
                            'type'  => 'textInput',
                            'title' => 'Host',
                            'defaultValue' => '',
                        ],
                        [
                            'name'  => 'port',
                            'type'  => 'textInput',
                            'title' => 'Port',
                            'defaultValue' => '',
                        ],
                        [
                            'name'  => 'db_name',
                            'type'  => 'textInput',
                            'title' => 'DB Name',
                            'defaultValue' => ''
                        ],
                        [
                            'name'  => 'login',
                            'type'  => 'textInput',
                            'title' => 'Login',
                            'defaultValue' => '',
                        ],
                        [
                            'name'  => 'password',
                            'type'  => 'passwordInput',
                            'title' => 'Password',
                            'defaultValue' => '',
                            'options' => [
                                'class' => 'input-priority'
                            ]
                        ]
                    ]
                ]);
                ?>
                
                <?php if ($success) { ?>
                        <div class="alert alert-success">
                                Yes, database connection works!
                        </div>
                <?php } elseif (!empty($errorMsg)) { ?>
                        <div class="alert alert-danger">
                                <strong><?= $errorMsg ?></strong>
                        </div>
                <?php } ?>
                <hr/>
                <div class="text-right">
                    <?= \yii\helpers\Html::submitButton('Next', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php \yii\widgets\ActiveForm::end(); ?>
    </div>
</div>