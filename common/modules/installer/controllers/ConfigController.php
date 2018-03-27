<?php

namespace common\modules\installer\controllers;

use Yii;
use yii\caching\DbCache;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

use common\modules\installer\helpers\Configuration;
use common\modules\installer\helpers\enums\Configuration as Enum;
use common\modules\installer\InstallerModule;
use common\modules\installer\models\config\ConfigBasicForm;
use common\modules\installer\models\config\RecaptchaForm;

use frontend\modules\user\models\SignupForm;

/**
 * ConfigController allows initial configuration of your application.
 * E.g. Name of Network, Root User
 *
 * ConfigController can only run after SetupController wrote the initial
 * configuration.
 *
 */
class ConfigController extends Controller
{
    public $layout = 'setup';

    /**
     * Before each config controller action check if
     *  - Database Connection works
     *  - Database Migrated Up
     *  - Not already configured (e.g. update)
     *
     * @param $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        // Flush caches
        if (Yii::$app->cache) {
            Yii::$app->cache->flush();
        }

        // Check DB Connection
        if (!InstallerModule::checkDbConnection()) {
            die('No database connection');
        }

        // When not at index action, verify that database is not already configured
        if ($action->id != 'finished') {
            if(!InstallerModule::isDbInstalled()){
                die('APP not installed');
            }
            if(InstallerModule::isConfigured()) {
                return $this->redirect(Yii::$app->urlManager->createUrl('config/finished'));
            }
        }

        return true;
    }
    
    /**
     * Setup Administrative User
     *
     * This should be the last step, before the user is created also the
     * application secret will created.
     */
    public function actionAdmin()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            
            $user = $model->signup(\common\models\User::ROLE_ADMINISTRATOR, true);
            if($user !== null) {
                if (!$user->hasErrors()) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t(
                            'frontend',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ));
                    } else {
                        if(Yii::$app->keyStorage->get(Enum::APP_STATUS))
                            Yii::$app->getUser()->login($user);
                    }
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('admin', ['model' => $model]);
    }

    /**
     * Index is only called on fresh databases, when there are already settings
     * in database, the user will directly redirected to actionFinished()
     */
    public function actionIndex()
    {
        if (InstallerModule::checkDbConnection()) {
            Yii::$app->keyStorage->set(Enum::DB_FORUM_STATUS, Enum::INSTALLED);
            $this->setupInitialData();
            return $this->redirect(['forum/run']);
        }
        throw \Exception('No database Connection');
    }

    /**
     * Setup some initial database settings.
     *
     * This will be done at the first step.
     */
    private function setupInitialData()
    {
        // Application Title
        Yii::$app->keyStorage->set(Enum::APP_NAME, 'TrinityWEB');
        
        // System emails
        Yii::$app->keyStorage->set(Enum::ADMIN_EMAIL, 'admin@domain.com');
        Yii::$app->keyStorage->set(Enum::ROBOT_EMAIL, 'noreply@domain.com');
        
        Yii::$app->keyStorage->set(Enum::MODULE_FORUM, Enum::ENABLED);
        Yii::$app->keyStorage->set(Enum::MODULE_ARMORY, Enum::DISABLED);
        Yii::$app->keyStorage->set(Enum::MODULE_ARMORY_PER_PAGE, 25);
        Yii::$app->keyStorage->set(Enum::MODULE_LADDER, Enum::ENABLED);
        Yii::$app->keyStorage->set(Enum::MODULE_LADDER_PER_PAGE, 25);
        Yii::$app->keyStorage->set(Enum::MODULE_API, Enum::ENABLED);
        Yii::$app->keyStorage->set(Enum::MODULE_STORE, Enum::DISABLED);
    }

    public function actionBasic()
    {
        $form = new ConfigBasicForm();
        $form->name = Yii::$app->keyStorage->get(Enum::APP_NAME);
        $form->email = Yii::$app->keyStorage->get(Enum::ADMIN_EMAIL);
        $form->robot_email = Yii::$app->keyStorage->get(Enum::ROBOT_EMAIL);
        if ($form->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
            if ($form->validate()) {
                Yii::$app->keyStorage->setAll([
                    Enum::APP_NAME    => $form->name,
                    Enum::ADMIN_EMAIL => $form->email,
                    Enum::ROBOT_EMAIL => $form->robot_email
                ]);
                
                $config['components']['mailer']['class'] = 'yii\swiftmailer\Mailer';
                $config['components']['mailer']['htmlLayout'] = '@common/mail/layouts/html';
                $config['components']['mailer']['viewPath'] = '@common/mail';
                $config['components']['mailer']['useFileTransport'] = false;
                $config['components']['mailer']['transport'] = [
                    'class' => 'Swift_SmtpTransport',
                    'host' => $form->smtp_host,
                    'username' => $form->smtp_username,
                    'password' => $form->smtp_password,
                    'port' => $form->smtp_port,
                    'encryption' => $form->smtp_encrypt,
                ];
                
                Configuration::setConfig(Yii::getAlias('@common/config/mailer/conf.php'), $config);
                $config['components']['mailer']['transport']['host'] = $form->smtp_console_host;
                $config['components']['mailer']['transport']['encryption'] = '';
                Configuration::setConfig(Yii::getAlias('@common/config/console.php'), $config);
                
                Yii::$app->keyStorage->set(Enum::EMAIL_STATUS, Enum::ENABLED);
                
                return $this->redirect(['recaptcha']);
            }
        }
        return $this->render('basic', ['model' => $form]);
    }

    public function actionRecaptcha() {
        $model = new RecaptchaForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                Yii::$app->keyStorage->setAll([
                    Enum::RECAPTCHA_SITE_KEY => $model->siteKey,
                    Enum::RECAPTCHA_SECRET   => $model->secret,
                    Enum::RECAPTCHA_STATUS   => Enum::DISABLED
                ]);
                return $this->redirect(['finished']);
            }
        }
        return $this->render('recaptcha', ['model' => $model]);
    }

    /**
     * Last Step, finish up the installation
     */
    public function actionFinished()
    {
        // Set to installed
        InstallerModule::setInstalled();
        return $this->render('finished');
    }
}
