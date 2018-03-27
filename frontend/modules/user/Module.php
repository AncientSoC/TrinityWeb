<?php

namespace frontend\modules\user;

use Yii;
use yii\filters\AccessControl;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @var bool Is users should be activated by email
     */
    public $shouldBeActivated = false;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if(!Yii::$app->user->isGuest) {
            $this->layout = 'main';
        }
        $this->setAliases(['@userPanel' => __DIR__]);
    }
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('frontend','Личный кабинет'),'url' => ['/panel/main/index']];
        return $this;
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
