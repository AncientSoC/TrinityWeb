<?php

namespace common\modules\forum\widgets\codemirror;

use common\modules\forum\widgets\codemirror\assets\CodeMirrorAsset;
use Yii;
use yii\bootstrap\Html;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * Podium CodeMirror widget.
 *
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.6
 */
class CodeMirror extends InputWidget
{
    /**
     * @var string Editor type to display
     */
    public $type = 'basic';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
        if ($this->hasModel()) {
            if (empty($this->model->{$this->attribute})) {
                $this->model->{$this->attribute} = "\n\n\n\n\n\n\n\n";
            }
            return Html::activeTextarea($this->model, $this->attribute, ['id' => 'codemirror']);
        }
        if (empty($this->value)) {
            $this->value = "\n\n\n\n\n\n\n\n";
        }
        return Html::textarea($this->name, $this->value, ['id' => 'codemirror']);
    }

    /**
     * Registers widget assets.
     * Note that CodeMirror works without jQuery.
     */
    public function registerClientScript()
    {
        $view = $this->view;
        CodeMirrorAsset::register($view);
        $js = 'var CodeMirrorLabels = {
    bold: "' . Yii::t('view', 'Bold') . '",
    italic: "' . Yii::t('view', 'Italic') . '",
    header: "' . Yii::t('view', 'Header') . '",
    inlinecode: "' . Yii::t('view', 'Inline code') . '",
    blockcode: "' . Yii::t('view', 'Block code') . '",
    quote: "' . Yii::t('view', 'Quote') . '",
    bulletedlist: "' . Yii::t('view', 'Bulleted list') . '",
    orderedlist: "' . Yii::t('view', 'Ordered list') . '",
    link: "' . Yii::t('view', 'Link') . '",
    image: "' . Yii::t('view', 'Image') . '",
    help: "' . Yii::t('view', 'Help') . '",
};var CodeMirrorSet = "' . $this->type . '";';
        $view->registerJs($js, View::POS_BEGIN);
    }
}
