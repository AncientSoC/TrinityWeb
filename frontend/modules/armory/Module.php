<?php

namespace frontend\modules\armory;

use Yii;
use yii\filters\AccessControl;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;
use common\components\helpers\Configuration;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string
     */
    public $controllerNamespace = 'frontend\modules\armory\controllers';
    
    /**
     * @inheritdoc
     */
    public $layout = 'main';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setAliases(['@armory' => __DIR__]);
    }
    
    public function beforeAction($action) {
        $parent = parent::beforeAction($action);
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('armory','Армори'),'url' => ['/armory']];
        if(Yii::$app->keyStorage->get(Configuration::MODULE_ARMORY) !== Configuration::ENABLED) {
            return Yii::$app->response->redirect(Yii::$app->homeUrl);
        }
        return $parent;
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
        ])]);   
    }
    
}
