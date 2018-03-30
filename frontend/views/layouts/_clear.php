<?php
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */

\common\assets\HelperAssets::register($this);
\frontend\assets\FrontendAsset::register($this);
\common\assets\GlyphIcons::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=Yii::$app->AppHelper->buildTitle($this->title)?></title>
    <meta name="robots" content="noindex,follow" />
    <meta property="og:url" content="https:/" />
    
    <link rel="shortcut icon" type="image/png" href="/img/favicon.ico" />
    <link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>
    
    <?php $this->head() ?>
    <?php echo Html::csrfMetaTags() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php echo $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
