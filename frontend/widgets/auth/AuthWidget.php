<?php

namespace frontend\widgets\auth;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;

use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\SignupForm;

class AuthWidget extends Widget {
    
    const AUTH = 'auth';
    const SIGNUP = 'signup';
    
    public $action = null;
    
    /**
     * Executes the widget.
     * @return string the result of widget execution to be outputted.
     */
    public function run() {
        if($this->action) {
            switch ($this->action) {
                case self::AUTH:
                    $model = new LoginForm();
                    echo $this->render('login', [
                        'model' => $model
                    ]);
                    break;
                case self::SIGNUP:
                    $model = new SignupForm();
                    echo $this->render('signup', [
                        'model' => $model
                    ]);
                    break;
            }
        } else return null;
    }
}