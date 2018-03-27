<?php

namespace frontend\modules\store;

use Yii;
use yii\filters\AccessControl;
use yii\base\BootstrapInterface;
use yii\web\GroupUrlRule;

use common\models\shop\ShopCategory;

class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string
     */
    public $controllerNamespace = 'frontend\modules\store\controllers';
    
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
        $this->setAliases(['@store' => __DIR__]);
    }
    
    public function beforeAction($action) {
        $parent = parent::beforeAction($action);
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('store','Магазин'),'url' => ['/store']];
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
