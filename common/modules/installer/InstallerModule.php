<?php
namespace common\modules\installer;

use Yii;
use yii\base\Module as BaseModule;

use yii\db\Exception;
use yii\helpers\Html;
use yii\web\GroupUrlRule;
use yii\base\BootstrapInterface;

use common\models\UserToken;

use common\modules\installer\helpers\Configuration;
use common\modules\installer\helpers\enums\Configuration as Enum;

class InstallerModule extends BaseModule implements BootstrapInterface
{
    
    public $id = 'install';
    
    public $version = '@beta';
    
    /**
     * @var string
     */
    public $controllerNamespace = 'common\modules\installer\controllers';
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setAliases(['@installer' => __DIR__]);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(self::isDBInstalled())
            Yii::$app->session->setFlash('error',Yii::t('installer','Операция невозможна - приложение уже установлено!'));
            if(self::isConfigured()) return Yii::$app->response->redirect(Yii::$app->homeUrl);
        return parent::beforeAction($action);
    }
    
    /**
     * Checks if database connections works
     *
     * @return boolean
     */
    public static function checkDbConnection($db_component = 'db')
    {
        try {
            Yii::$app->{$db_component}->isActive;
            return true;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

        return false;
    }

    /**
     * Checks if the application is already configured.
     */
    public static function isDBInstalled() {
        if(Yii::$app->has('db')) {
            try {
                if(Yii::$app->keyStorage->get(Enum::DB_WEB_STATUS) === Enum::INSTALLED) return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }
    
    /**
     * Checks if the application is already configured.
     */
    public static function isConfigured()
    {
        if (Yii::$app->keyStorage->get(Enum::APP_STATUS) === Enum::INSTALLED) {
            return true;
        }
        return false;
    }
    
    /**
     * Checks if configuration of application is installed.
     */
    public static function isConfigurationInstalled($configration) {
        if (Yii::$app->keyStorage->get($configration) != '') {
            return true;
        }
        return false;
    }

    public static function setInstalled() {
        Yii::$app->keyStorage->set(Enum::APP_STATUS, Enum::INSTALLED);
        Yii::$app->keyStorage->set(Enum::DB_STATUS, Enum::INSTALLED);
    }
    
    /**
     * Set configuration status of application
     */
    public static function setConfigurationInstalled($configuration, $state)
    {
        Yii::$app->keyStorage->set($configuration, $state);
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