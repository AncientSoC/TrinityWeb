<?php
/**
 * Author: Eugine Terentev <eugine@terentev.net>
 */

namespace backend\controllers;

use probe\Factory;
use Yii;
use yii\web\Controller;
use yii\web\Response;

use yii\filters\AccessControl;
use common\models\User;

class SystemInformationController extends Controller
{
    public $layout = 'common';
    
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                        ],
                        'allow' => true,
                        'permissions' => [User::PERM_ACCESS_TO_SYS_INFORMATION]
                    ],
                ],
            ],
        ]);
    }
    
    public function actionIndex()
    {
        $provider = Factory::create();
        if ($provider) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($key = Yii::$app->request->get('data')) {
                    switch ($key) {
                        case 'cpu_usage':
                            return $provider->getCpuUsage();
                            break;
                        case 'memory_usage':
                            return ($provider->getTotalMem() - $provider->getFreeMem()) / $provider->getTotalMem();
                            break;
                    }
                }
            } else {
                return $this->render('index', ['provider' => $provider]);
            }
        } else {
            return $this->render('fail');
        }
    }
}
