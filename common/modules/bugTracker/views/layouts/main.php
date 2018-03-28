<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use common\widgets\Breadcrumbs;
use common\modules\bugTracker\assets\BugTrackerGeneralAsset;
use common\widgets\Alert;

/* @var $content string */

BugTrackerGeneralAsset::register($this);

$this->beginContent('@frontend/views/layouts/base.php')
?>
<div class="push-header">
    <div class="container">
        
        <?php echo Breadcrumbs::widget([
            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>
        
        <div class="row">
            <div class="col-xs-12">
                <div class="flat" id="bugTracker_container">
                    <?php echo $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>