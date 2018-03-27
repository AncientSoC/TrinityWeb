<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use common\widgets\Breadcrumbs;
use kartik\sidenav\SideNav;

use common\widgets\Alert;

use frontend\modules\store\assets\StoreAsset;

use common\models\shop\ShopCategory;

StoreAsset::register($this);

/* @var $content string */

$this->beginContent('@frontend/views/layouts/base.php')
?>
<div class="push-header">
    <div class="container">
        
        <?php echo Breadcrumbs::widget([
            'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>
        
        <div class="row" id="store-container">
            <div class="col-xs-12 col-md-3" id="left-side">
                <?= SideNav::widget([
                    'type' => SideNav::TYPE_DEFAULT,
                    'heading' => Yii::t('store','Категории'),
                    'items' => ShopCategory::generateShopMenu(),
                    'containerOptions' => [
                        'class' => 'store-category-list widget'
                    ]
                ]);?>
            </div>
            <div class="col-xs-12 col-md-9" id="right-side">
                <div class="flat">
                    <?php echo $content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>