<?php

namespace common\modules\installer\controllers;

use Yii;
use yii\db\Connection;
use yii\db\Exception;
use yii\swiftmailer\Mailer;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

use vova07\console\ConsoleRunner;

use common\modules\installer\helpers\Configuration;
use common\modules\installer\helpers\enums\Configuration as Enum;
use common\modules\installer\helpers\SystemCheck;
use common\modules\installer\InstallerModule;

use common\modules\installer\models\setup\DatabaseForm;
use common\modules\installer\models\setup\CharsDatabaseForm;

class SetupController extends Controller
{
    public $layout = 'setup';

    public function actionIndex()
    {
        $this->redirect(['prerequisites']);
    }
    
    /**
     * Prerequisites action checks application requirement using the SystemCheck
     * Library
     *
     * (Step 2)
     */
    public function actionPrerequisites()
    {
        $checks = SystemCheck::getResults();

        $hasError = FALSE;
        foreach ($checks as $check) {
            if ($check['state'] == 'ERROR')
                $hasError = TRUE;
        }
        // Render template
        return $this->render('prerequisites', ['checks' => $checks, 'hasError' => $hasError]);
    }
    
    /**
     * (Step 3)
     */
    public function actionWebDatabase()
    {
        $errorMsg = '';
        $result_data = [
            'config' => null,
            'error' => null
        ];
        $success = false;
        $model = new DatabaseForm(['_name' => 'WEB']);
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->validate()) {
                $result_data = $this->buildConfigurationDatabase($model, 'db');
                if($result_data['error'] == null) {
                    
                    Configuration::setConfig(Yii::getAlias('@common/config/dbs/web.php'), $result_data['config']);
                    
                    $components_config = '<?php return [
                        "components" => [
                            "i18n" => [
                                "translations" => [
                                    "app" => [
                                        "class" => "common\components\i18n\DbMessageSource",
                                        "db" => "db",
                                        "sourceLanguage" => "ru-RU",
                                        "sourceMessageTable" => "{{%language_source}}",
                                        "messageTable" => "{{%language_translate}}",
                                        "cachingDuration" => 86400,
                                        "enableCaching" => true,
                                    ],
                                    "*" => [
                                        "class" => "common\components\i18n\DbMessageSource",
                                        "db" => "db",
                                        "sourceLanguage" => "ru-RU",
                                        "sourceMessageTable" => "{{%language_source}}",
                                        "messageTable" => "{{%language_translate}}",
                                        "cachingDuration" => 86400,
                                        "enableCaching" => true,
                                    ],
                                ],
                            ],
                            "log" => [
                                "traceLevel" => YII_DEBUG ? 3 : 0,
                                "targets" => [
                                    "db" => [
                                        "class" => "yii\log\DbTarget",
                                        "levels" => ["error", "warning"],
                                        "except" => ["yii\web\HttpException:*", "yii\i18n\I18N\*"],
                                        "prefix" => function () {
                                            $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;
                                            return sprintf("[%s][%s]", Yii::$app->id, $url);
                                        },
                                        "logVars" => [],
                                        "logTable" => "{{%system_log}}"
                                    ]
                                ],
                            ],
                        ],
                    ];';
                    
                    file_put_contents(Yii::getAlias('@common/config/components/conf.php'), $components_config);
                                        
                    Yii::$app->db->open();
                    if (Yii::$app->cache) {
                        Yii::$app->cache->flush();
                    }
                    
                    $stopSleep = false;
                    $consoleStart = false;
                    while($stopSleep !== true) {
                        if($consoleStart === false) {
                            $consoleStart = true;
                            Yii::$app->consoleRunner->run('app/setup --interactive=0');
                        }
                        if(Yii::$app->db->schema->getTableSchema(\common\models\UserToken::tableName(), true) !== null) {
                            Yii::$app->keyStorage->set(Enum::DB_LANG_STATUS, Enum::INSTALLED);
                            Yii::$app->keyStorage->set(Enum::DB_WEB_STATUS, Enum::INSTALLED);
                            Yii::$app->keyStorage->set(Enum::DB_RBAC_STATUS, Enum::INSTALLED);
                            $stopSleep = true;
                        }
                    }
                    
                    return $this->redirect(['auth-database']);
                    
                }
            }
        }
        return $this->render('_database_form', [
            'model' => $model,
            'success' => $success,
            'errorMsg' => $result_data['error']
        ]);
    }
    
    /**
     * (Step 4)
     */
    public function actionAuthDatabase()
    {
        $errorMsg = '';
        $result_data = [
            'config' => null,
            'error' => null
        ];
        $success = false;
        $model = new DatabaseForm(['_name' => 'Auth']);
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->validate()) {
                $result_data = $this->buildConfigurationDatabase($model, 'auth');
                if($result_data['error'] == null) {
                    Configuration::setConfig(Yii::getAlias('@common/config/dbs/auth.php'), $result_data['config']);
                    Yii::$app->keyStorage->set(Enum::AUTH_STATUS, Enum::INSTALLED);
                    return $this->redirect(['characters-database']);
                }
            }
        }
        return $this->render('_database_form', [
            'model' => $model,
            'success' => $success,
            'errorMsg' => $result_data['error']
        ]);
    }
    
    /**
     * (Step 5)
     */
    public function actionCharactersDatabase()
    {
        $errorMsg = '';
        $success = false;
        $form = new CharsDatabaseForm();
        $config = [];
        if ($form->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
            if ($form->validate()) {
                foreach($form->dbs as $db) {
                    $success = false;
                    
                    $key_name = $db['name'];
                    
                    $dsn = "mysql:host=" . $db['host'] . ";port=" . $db['port'] . ";dbname=" . $db['db_name'];
                    Yii::$app->set($key_name, [
                            'class'    => Connection::className(),
                            'dsn'      => $dsn,
                            'username' => $db['login'],
                            'password' => $db['password'],
                            'charset'  => 'utf8'
                    ]);
                    try {
                        Yii::$app->{$key_name}->open();
                        // Check DB Connection
                        if (InstallerModule::checkDbConnection($key_name)) {
                            // Write Config
                            $config['components'][$key_name]['class'] = Connection::className();
                            $config['components'][$key_name]['dsn'] = $dsn;
                            $config['components'][$key_name]['username'] = $db['login'];
                            $config['components'][$key_name]['password'] = $db['password'];
                            $config['components'][$key_name]['charset'] = 'utf8';
                            $config['components'][$key_name]['enableSchemaCache'] = YII_ENV_PROD;
                            
                            $success = true;
                        } else {
                            $errorMsg[$key_name] = 'Incorrect configuration';
                        }
                    } catch (Exception $e) {
                        $errorMsg[$key_name] = $e->getMessage();
                    }
                }
                if(!$errorMsg) {
                    Configuration::setConfig(Yii::getAlias('@common/config/dbs/chars.php'), $config);
                    Yii::$app->keyStorage->set(Enum::CHARS_STATUS, Enum::INSTALLED);
                    return $this->redirect(['config/admin']);
                }
            }
        }

        return $this->render('_characters_databases_form', [
            'model' => $form,
            'success' => $success,
            'errorMsg' => $errorMsg
        ]);
    }

    protected function buildConfigurationDatabase($model, $component_key) {
        $success = false;
        $errorMsg = null;
        $config = [];
        $dsn = "mysql:host=" . $model['host'] . ";port=" . $model['port'] . ";dbname=" . $model['database'];
        Yii::$app->set($component_key, [
                'class'    => Connection::className(),
                'dsn'      => $dsn,
                'username' => $model['login'],
                'password' => $model['password'],
                'tablePrefix' => $model['table_prefix'],
                'charset'  => 'utf8'
        ]);
        try {
            Yii::$app->{$component_key}->open();
            if (InstallerModule::checkDbConnection($component_key)) {
                $config['components'][$component_key]['class'] = Connection::className();
                $config['components'][$component_key]['dsn'] = $dsn;
                $config['components'][$component_key]['username'] = $model['login'];
                $config['components'][$component_key]['password'] = $model['password'];
                $config['components'][$component_key]['tablePrefix'] = $model['table_prefix'];
                $config['components'][$component_key]['charset'] = 'utf8';
                $config['components'][$component_key]['enableSchemaCache'] = YII_ENV_PROD;
                $success = true;
            } else {
                $errorMsg = 'Incorrect configuration';
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
        }
        return ['config' => $config, 'error' => $errorMsg];
    }
}