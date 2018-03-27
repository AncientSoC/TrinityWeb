<?php

namespace common\modules\i18n\bundles;

use yii\web\AssetBundle;

/**
 * Contains css files necessary for language list on the backend.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class LanguageAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/modules/i18n/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/helpers.css',
        'stylesheets/language.css',
    ];
}
