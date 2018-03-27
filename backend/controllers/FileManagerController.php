<?php

namespace backend\controllers;

use common\models\User;
use yii\filters\AccessControl;

class FileManagerController extends \yii\web\Controller
{
    
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
                        'permissions' => [User::PERM_ACCESS_TO_FILE_MANAGER]
                    ],
                ],
            ],
        ]);
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
