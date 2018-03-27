<?php

namespace common\modules\i18n\bundles;

use yii\web\AssetBundle;

/**
 * Contains javascript files necessary for modify translations on the backend.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class TranslatePluginAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/modules/i18n/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/helpers.js',
        'javascripts/translate.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'common\modules\i18n\bundles\TranslationPluginAsset',
    ];
}
