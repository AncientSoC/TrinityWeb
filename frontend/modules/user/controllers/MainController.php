<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class MainController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function () {
                            Yii::$app->session->setFlash('error',Yii::t('cp','Для данного действия требуется авторизация!'));
                            return Yii::$app->controller->redirect(['sign-in/login']);
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }
    
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        Yii::$app->params['breadcrumbs'][] = [
            'label' => Yii::t('cp','Общая информация')
        ];
        
        return $this->render('index');
    }
}
