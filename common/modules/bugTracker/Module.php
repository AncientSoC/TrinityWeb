<?php

namespace common\modules\bugTracker;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $controllerNamespace = 'common\modules\bugTracker\controllers';
    public $db = 'db';
    public $usernameCallback;
    public $defaultRoute = 'task';
    
    public function init()
    {
        if (is_null($this->usernameCallback))
        {
            $this->usernameCallback = function ($user_id) { return $user_id; };
        }
        if(Yii::$app->id != 'backend') {
            $this->layout = 'main';
        }
        
    }
    
    public function beforeAction($action) {
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('bugTracker','Баг-трекер'),'url' => ['/tracker/task/index']];
        return parent::beforeAction($action);
    }
    
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $this->addUrlManagerRules($app);
        }
    }
    
    protected function addUrlManagerRules($app)
    {
        $app->urlManager->addRules([new GroupUrlRule([
            'prefix' => $this->id,
            'rules' => require __DIR__ . '/url-rules.php',
        ])], true);
    }
    
}