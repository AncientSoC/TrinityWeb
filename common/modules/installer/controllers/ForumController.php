<?php

namespace common\modules\installer\controllers;

use common\modules\forum\helpers\Helper;
use common\modules\forum\db\Query;
use common\modules\forum\maintenance\Installation;
use common\modules\forum\maintenance\Update;
use common\modules\forum\Podium;
use common\modules\forum\traits\FlashTrait;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Podium Install controller
 * All actions concerning module installation.
 *
 */
class ForumController extends Controller
{
    use FlashTrait;

    /**
     * @var string Layout name
     */
    public $layout = 'setup';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!empty(Yii::$app->log->targets['podium'])) {
                Yii::$app->log->targets['podium']->enabled = false;
            }
            return true;
        }
        return false;
    }

    /**
     * Importing the databases structures.
     * @return string
     */
    public function actionImport()
    {
        $result = ['error' => 'Error'];

        if (Yii::$app->request->isPost) {
            $installation = new Installation();
            $result = $installation->nextStep();
        }

        return Json::encode($result);
    }

    /**
     * Running the installation.
     * @return string
     */
    public function actionRun()
    {
        Yii::$app->session->set(Installation::SESSION_KEY, 0);
        return $this->render('run', ['version' => $this->module->version]);
    }

    /**
     * Updating the databases structures.
     * @return string
     */
    public function actionUpdate()
    {
        $result = ['error' => 'Error'];

        if (Yii::$app->request->isPost) {
            $result = (new Update())->nextStep();
        }
        return Json::encode($result);
    }

    /**
     * Running the upgrade.
     * @return string
     * @since 0.2
     */
    public function actionLevelUp()
    {
        Yii::$app->session->set(Update::SESSION_KEY, 0);

        $error = '';
        $info = '';
        $dbVersion = 0;
        $mdVersion = $this->module->version;
        $dbQuery = (new Query())->from('{{%forum_config}}')->select('value')->where(['name' => 'version'])->limit(1)->one();
        if (!isset($dbQuery['value'])) {
            $error = 'Error while checking current database version! Please verify your database.';
        } else {
            $dbVersion = $dbQuery['value'];
            $result = Helper::compareVersions(explode('.', $mdVersion), explode('.', $dbVersion));
            if ($result == '=') {
                $info = 'Module and database versions are the same!';
            } elseif ($result == '<') {
                $error = 'Module version appears to be older than database! Please verify your database.';
            }
        }

        Yii::$app->session->set(Update::SESSION_VERSION, $dbVersion);

        return $this->render('level-up', [
            'currentVersion' => $mdVersion,
            'dbVersion' => $dbVersion,
            'error' => $error,
            'info' => $info
        ]);
    }
}
