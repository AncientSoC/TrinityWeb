<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use yii\bootstrap\Progress;
use yii\helpers\Url;

$this->title = Yii::t('view', 'New Installation');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Podium Installation'), 'url' => ['install/run']];
Yii::$app->params['breadcrumbs'][] = $this->title;
$this->params['no-search']     = true;

$url = Url::to(['install/import']);
$this->registerJs(<<<JS
var nextStep = function(drop) {
    var label = 'success';
    var bg = '';
    jQuery.post('$url', {drop: drop}, null, 'json')
        .always(function() {
            if (drop !== true) {
                jQuery('#progressBar .progress-bar').removeClass('progress-bar-warning');
            }
        })
        .fail(function() {
            jQuery('#progressBar').addClass('hide');
            jQuery('#installationError').removeClass('hide');
        })
        .done(function(data) {
            if (data.type == 2) {
                label = 'danger';
                bg = 'list-group-item-danger';
            } else if (data.type == 1) {
                label = 'warning';
                bg = 'list-group-item-warning';
            }
            jQuery('#progressBar .progress-bar')
                .css('width', data.percent + '%')
                .attr('aria-valuenow', data.percent)
                .html(data.percent + '%');
            var row = '<li class="list-group-item ' + bg + '">'
                + '<span class="pull-right label label-' + label + '">' + data.table + '</span> '
                + data.result
                + '</li>';
            jQuery('#installationProgress .list-group').prepend(row);
            if (data.type == 2) {
                jQuery('#progressBar .progress-bar').removeClass('active progress-bar-striped');
                jQuery('#installationFinishedError').removeClass('hide');
            } else {
                if (data.percent < 100 || data.drop === true) {
                    nextStep(data.drop);
                } else {
                    jQuery('#progressBar .progress-bar').removeClass('active progress-bar-striped');
                    jQuery('#installationFinished').removeClass('hide');
                }
            }
        });
};
jQuery('#installPodium').click(function(e) {
    e.preventDefault();
    jQuery('#startInstallation').addClass('hide');
    jQuery('#installationResults').removeClass('hide');
    jQuery('#progressBar .progress-bar').css('width', '10px');
    nextStep(jQuery('#drop')[0].checked);
});
JS
);
?>
<div class="row" id="startInstallation">
    <div class="text-center col-sm-12">
        <div class="form-group">
            <em><?= Yii::t('view', 'Podium will attempt to create all database tables required by the forum along with the default configuration and the administrator account.') ?></em><br>
            <em><strong><?= Yii::t('view', 'Back up your existing database and then click the button below.') ?></strong></em>
        </div>
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span> <?= Yii::t('view', 'Seriously - back up your existing database first!') ?><br>
            <?= Yii::t('view', 'Podium does its best to make sure your data is not corrupted but make a database copy just in case.') ?><br>
            <?= Yii::t('view', 'You have been warned!') ?>*
        </div>
        <div class="alert alert-danger">
            <label><input type="checkbox" name="drop" value="1" id="drop"> <?= Yii::t('view', 'Check this box to drop all existing Podium tables first') ?> <span class="glyphicon glyphicon-alert"></span></label><br>
            <?= Yii::t('view', '(all existing Podium data will be deleted!)') ?>
        </div>
        <div class="form-group">
            <button id="installPodium" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-import"></span> <?= Yii::t('view', 'Start Podium Installation') ?></button>
        </div>
        <div class="form-group">
            <?= Yii::t('view', 'Version to install') ?> <kbd><?= $version ?></kbd>
        </div>
        <div class="form-group text-muted">
            <small>* <?= Yii::t('view', 'Podium cannot be held liable for any database damages that may result directly or indirectly from the installing process. Back up your data first!') ?></small>
        </div>
    </div>
</div>
<div class="row hide" id="installationResults">
    <div class="text-center col-sm-8 col-sm-offset-2" id="progressBar">
        <?= Progress::widget([
            'percent'    => 0,
            'label'      => '0%',
            'barOptions' => ['class' => 'progress-bar progress-bar-warning progress-bar-striped active', 'style' => 'min-width: 2em;'],
            'options'    => ['class' => 'progress']
        ]) ?>
    </div>
    <div class="col-sm-8 col-sm-offset-2 hide" id="installationError">
        <div class="alert alert-danger" role="alert"><?= Yii::t('view', 'There was a major error during installation! Check your runtime log for details.') ?></div>
    </div>
    <div class="row hide" id="installationFinished">
        <div class="text-center col-sm-12">
            <a href="<?= Url::to(['forum/index']) ?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-ok-sign"></span> <?= Yii::t('view', 'Installation finished') ?></a>
        </div>
    </div>
    <div class="row hide" id="installationFinishedError">
        <div class="text-center col-sm-12">
            <button class="btn btn-danger btn-lg"><span class="glyphicon glyphicon-alert"></span> <?= Yii::t('view', 'Errors during installation') ?></button>
        </div>
    </div><br>
    <div class="col-sm-8 col-sm-offset-2" id="installationProgress">
        <ul class="list-group"></ul>
    </div>
</div>
