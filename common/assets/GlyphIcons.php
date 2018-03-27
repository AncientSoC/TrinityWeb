<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:24 PM
 */

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
