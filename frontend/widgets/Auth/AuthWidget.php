<?php

namespace frontend\widgets\Auth;

use Yii;
use yii\bootstrap\Modal as BaseModal;
use yii\helpers\Html;

class AuthWidget extends BaseModal {
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog modal-dialog-centered ' . $this->size]) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-content']) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";
    }
    
}