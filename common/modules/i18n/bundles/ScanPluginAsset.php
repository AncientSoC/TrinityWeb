<?php

namespace common\modules\i18n\bundles;

use yii\web\AssetBundle;

/**
 * Contains javascript files necessary for message scan on the backend.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.4
 */
class ScanPluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/modules/i18n/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/scan.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'common\modules\i18n\bundles\TranslationPluginAsset',
    ];
}
