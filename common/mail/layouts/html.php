<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message bing composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo Yii::$app->charset ?>"/>
    <title><?php echo Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        h1,h2,h3,h4,h5,h6 {margin: 0px; padding: 0px;}
        
        h1{font-size: 34px;}
        h2{font-size: 30px;}
        h3{font-size: 28px;}
        h4{font-size: 24px;}
        h5{font-size: 20px;}
        h6{font-size: 16px;}
        
        #letter {background-color: #23262D;color:#C5C0C0; width: auto; position:relative; min-height: 200px; padding: 50px;}
        #letter-header {border-bottom: 1px solid #36BBA6; padding: 0px 15px;}
        #letter-footer {border-top: 1px solid #36BBA6; padding: 7px 15px;}
        .font-size-14 {font-size: 14px;}
        .font-size-16 {font-size: 16px;}
        .font-size-18 {font-size: 18px;}
        .font-size-20 {font-size: 20px;}
        .font-size-22 {font-size: 22px;}
        .font-size-24 {font-size: 24px;}
        .font-size-26 {font-size: 26px;}
        .font-weight-normal {font-weight: normal;}
        .rf-studio-black {color: #333;}
        .rf-studio-white {color: #C5C0C0;}
        .rf-studio-orange {color: #e84d3b;}
        .rf-studio-green {color: #5cb85c;}
        .rf-studio-aqua {color: #36BBA6;}
        .rf-studio-999 {color: #999;}
        .mail-row {margin: 7px 0px;}
        .btn {
            padding: 8px 10px;
            border-radius: 0px;
            border: 1px solid #32343B;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.43);
            display: inline-block;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
        }
        .btn.btn-primary, .btn.btn-default {color:#36BBA6;}
        .btn.btn-success {color:#5cb85c;}
        .btn.btn-danger {color:#d9534f;}
        .btn.btn-warning {color:#f0ad4e;}
        .btn.btn-info {color:#5bc0de;}
        .btn.btn-default,.btn.btn-primary,.btn.btn-danger,.btn.btn-warning,.btn.btn-info,.btn.btn-link,.btn.btn-success {
            background-color: #30353B;
        }
        .badge {padding: 3px 7px;color: #36BBA6;background-color: #C5C0C0;border-radius: 10px;}
    </style>
</head>
<body>
<?php $this->beginBody() ?>
    <div id="letter">
        <div id="letter-header">
            <span class="font-size-20 rf-studio-orange">RF</span>
            <span class="font-size-20 rf-studio-white"> - studio</span>
        </div>
        <?php echo $content ?>
        <div id="letter-footer">
            <h6 class="rf-studio-aqua font-weight-normal">
                <?=Yii::t('mail','С уважением администрация проекта')?>
            </h6>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
