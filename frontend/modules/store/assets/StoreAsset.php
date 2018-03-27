<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\modules\store\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\YiiAsset;

use common\assets\Html5shiv;

use frontend\assets\FrontendAsset;
use kartik\sidenav\SideNavAsset;

/**
 * Frontend application asset
 */
class StoreAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@store';

    /**
     * @var array
     */
    public $css = [
        'css/store.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'js/store.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        SideNavAsset::class,
        FrontendAsset::class,
    ];
}
