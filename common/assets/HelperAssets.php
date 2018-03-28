<?php

namespace common\assets;

use yii\web\AssetBundle;

class HelperAssets extends AssetBundle
{
    public $sourcePath = '@common/assets/helper';
    public $css = [
        'css/helper.css'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
