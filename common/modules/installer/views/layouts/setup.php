<?php
use common\modules\installer\assets\AppAsset;
use common\modules\installer\InstallerModule;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
common\assets\GlyphIcons::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode('Setup Wizard') ?></title>
            <?php $this->head() ?>
        </head>

        <body>
            <?php $this->beginBody() ?>
            <div class="container" style="margin: 0 auto;max-width: 700px;padding-top: 80px;">
                <?= $content ?>
            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>