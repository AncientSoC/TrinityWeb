<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use common\widgets\Breadcrumbs;

use common\widgets\Alert;

/* @var $content string */

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
                <?php echo $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endContent() ?>