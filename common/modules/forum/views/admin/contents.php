<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\models\Content;
use common\modules\forum\widgets\quill\QuillFull;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('view', 'Contents');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Administration Dashboard'), 'url' => ['admin/index']];
Yii::$app->params['breadcrumbs'][] = $this->title;

echo $this->render('/elements/admin/_navbar', ['active' => 'contents']);

?>
<br>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation" class="<?= $model->name == Content::TERMS_AND_CONDS ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::TERMS_AND_CONDS]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'Forum Terms and Conditions') ?></a></li>
            <li role="presentation" class="<?= $model->name == Content::EMAIL_REGISTRATION ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::EMAIL_REGISTRATION]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'Registration e-mail') ?></a></li>
            <li role="presentation" class="<?= $model->name == Content::EMAIL_NEW ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::EMAIL_NEW]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'New address activation e-mail') ?></a></li>
            <li role="presentation" class="<?= $model->name == Content::EMAIL_REACTIVATION ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::EMAIL_REACTIVATION]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'Account reactivation e-mail') ?></a></li>
            <li role="presentation" class="<?= $model->name == Content::EMAIL_PASSWORD ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::EMAIL_PASSWORD]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'Password reset e-mail') ?></a></li>
            <li role="presentation" class="<?= $model->name == Content::EMAIL_SUBSCRIPTION ? 'active' : '' ?>"><a href="<?= Url::to(['admin/contents', 'name' => Content::EMAIL_SUBSCRIPTION]) ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= Yii::t('view', 'New post in subscribed thread') ?></a></li>
        </ul>
<?php if (substr($model->name, 0, 6) == 'email-'): ?>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Yii::t('view', 'Content variables') ?></h3>
            </div>
            <div class="panel-body">
                <strong>{forum}</strong> <?= Yii::t('view', "This forum's name") ?><br>
                <strong>{link}</strong> <?= Yii::t('view', 'The link coming with email') ?><br>
            </div>
        </div>
<?php endif; ?>
    </div>
    <div class="col-md-9 col-sm-8">
        <?php $form = ActiveForm::begin(['id' => 'content-form']); ?>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'topic')->textInput(['placeholder' => Yii::t('view', 'Topic'), 'autofocus' => true])->label(false) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'content')->label(false)->widget(QuillFull::className(), ['options' => ['style' => 'min-height:320px;']]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('view', 'Save Content'), ['class' => 'btn btn-block btn-primary', 'name' => 'save-button']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><br>
