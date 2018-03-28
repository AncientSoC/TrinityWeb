<?php

namespace common\assets;

use yii\web\AssetBundle;

class GlyphIcons extends AssetBundle
{
    public $sourcePath = '@common/assets/glyphicons';
    public $css = [
        'css/bootstrap.css'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
