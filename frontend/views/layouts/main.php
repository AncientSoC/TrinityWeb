<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use common\widgets\Breadcrumbs;

use common\widgets\Alert;
use common\widgets\StatusServers\StatusServersWidget;
/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>
    <div id="carousel-container" class="push-header">
        <?php echo \common\widgets\DbCarousel::widget([
            'key'=>'index',
            'options' => [
                'class' => 'slide carousel-with-indicator',
            ],
        ])?>
    </div>
    <div class="container">
        
        <?php echo Breadcrumbs::widget([
            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>
        
        <div class="row">
            <div class="col-md-8 col-h-full" id="left-side">
                <?php echo $content ?>
            </div>
            <div class="col-md-4 col-h-full" id="right-side">
                <div class="right-container">
                    <?php echo StatusServersWidget::widget() ?>
                    <?php echo common\modules\forum\widgets\LatestPosts::widget() ?>
                </div>
            </div>
        </div>
    </div>
<?php $this->endContent() ?>