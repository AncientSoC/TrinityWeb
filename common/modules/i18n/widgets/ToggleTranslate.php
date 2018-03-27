<?php

namespace common\modules\i18n\widgets;

use Yii;
use yii\base\Widget;
use common\modules\i18n\Module;

/**
 * Widget that displays button for switching to translating mode.
 *
 * Simple example:
 *
 * ~~~
 * \common\modules\i18n\widgets\ToggleTranslate::widget();
 * ~~~
 *
 * Example for changing position:
 *
 * ~~~
 * \common\modules\i18n\widgets\ToggleTranslate::widget([
 *  'position' => \common\modules\i18n\widgets\ToggleTranslate::POSITION_TOP_RIGHT,
 * ]);
 * ~~~
 *
 * Example for changing skin:
 *
 * ~~~
 * \common\modules\i18n\widgets\ToggleTranslate::widget([
 *  'frontendTranslationAsset' => 'common\modules\i18n\bundles\FrontendTranslationAsset',
 * ]);
 * ~~~
 *
 * Example for changing template and skin:
 *
 * ~~~
 * \common\modules\i18n\widgets\ToggleTranslate::widget([
 *  'template' => '<a href="javascript:void(0);" id="toggle-translate" class="{position}" data-language="{language}" data-url="{url}"><i></i> {text}</a><div id="translate-manager-div"></div>',
 *  'frontendTranslationAsset' => 'common\modules\i18n\bundles\FrontendTranslationAsset',
 * ]);
 * ~~~
 *
 * @author Lajos Molnar <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class ToggleTranslate extends Widget
{
    /**
     * Url of the dialog window.
     */
    const DIALOG_URL = '/translatemanager/language/dialog';

    /**
     * Button in top left corner.
     */
    const POSITION_TOP_LEFT = 'top-left';

    /**
     * Button in top right corner.
     */
    const POSITION_TOP_RIGHT = 'top-right';

    /**
     * Button in bottom left corner.
     */
    const POSITION_BOTTOM_LEFT = 'bottom-left';

    /**
     * Button in bottom right corner.
     */
    const POSITION_BOTTOM_RIGHT = 'bottom-right';

    /**
     * @var string The position of the translate mode switch button relative to the screen.
     * Pre-defined positions: bottom-left (default), bottom-right, top-left, top-tright.
     */
    public $position = 'bottom-left';

    /**
     * @var string The template of the translate mode switch button.
     */
    public $template = '<a href="javascript:void(0);" id="toggle-translate" class="{position}" data-language="{language}" data-url="{url}"><i></i> {text}</a><div id="translate-manager-div"></div>';

    /**
     * example: http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
     *
     * @var string added StyleSheets and their dependencies
     */
    public $frontendTranslationAsset = 'common\modules\i18n\bundles\FrontendTranslationAsset';

    /**
     * example: http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
     *
     * @var string added JavaScripts and their dependencies
     */
    public $frontendTranslationPluginAsset = 'common\modules\i18n\bundles\FrontendTranslationPluginAsset';

    /**
     * @inheritdoc
     */
    public function run()
    {
        if(Yii::$app->user->isGuest) {
            return;
        } else {
            if(Yii::$app->user->identity->id !== 1) return;
        }
        
        $this->_registerAssets();
        
        echo strtr($this->template, [
            '{text}' => Yii::t('language', 'Toggle translate'),
            '{position}' => $this->position,
            '{language}' => Yii::$app->language,
            '{url}' => Yii::$app->urlManager->createUrl(self::DIALOG_URL),
        ]);
    }

    /**
     * Registering asset files
     */
    private function _registerAssets()
    {
        if ($this->frontendTranslationAsset) {
            Yii::$app->view->registerAssetBundle($this->frontendTranslationAsset);
        }

        if ($this->frontendTranslationPluginAsset) {
            Yii::$app->view->registerAssetBundle($this->frontendTranslationPluginAsset);
        }
    }
}
