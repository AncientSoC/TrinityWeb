<?php

namespace common\modules\bugTracker\assets;

use yii\web\AssetBundle;

class BugTrackerGeneralAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/bugTracker';
    public $css = [
        'css/bugTracker.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}