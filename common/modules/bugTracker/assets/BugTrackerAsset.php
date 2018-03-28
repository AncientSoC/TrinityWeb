<?php

namespace common\modules\bugTracker\assets;

use yii\web\AssetBundle;

class BugTrackerAsset extends AssetBundle
{
    public $sourcePath = '@common/modules/bugTracker';
    public $js = [
        'js/bugTracker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}