<?php

namespace frontend\modules\ladder;

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
    public $controllerNamespace = 'frontend\modules\ladder\controllers';
    
    public $defaultRoute = 'main/index';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->layout = 'main';
        $this->setAliases(['@ladder' => __DIR__]);
    }
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('ladder','Ладдер'),'url' => ['/ladder']];
        if(Yii::$app->keyStorage->get(Configuration::MODULE_LADDER) !== Configuration::ENABLED) {
            return Yii::$app->response->redirect(Yii::$app->homeUrl);
        }
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
