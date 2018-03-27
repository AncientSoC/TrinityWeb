<?php
namespace common\modules\installer\assets;

use Yii;
use yii\web\YiiAsset;
use yii\web\AssetBundle;
use yii\bootstrap\BootstrapAsset;

use common\assets\Html5shiv;

class AppAsset extends AssetBundle
{
        /**
        * @inheritdoc
        */
        public $sourcePath = '@installer/assets';
    
        public $css      = [
            'css/font-awesome/css/font-awesome.min.css'
        ];
        public $js       = [
        ];
        public $depends  = [
            YiiAsset::class,
            BootstrapAsset::class,
            Html5shiv::class,
        ];
}