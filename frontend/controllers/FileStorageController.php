<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * FileStorageController implements the CRUD actions for FileStorageItem model.
 */
class FileStorageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'upload',
                            'upload-delete',
                        ],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'upload' => [
                'class' => 'trntv\filekit\actions\UploadAction',
                'deleteRoute' => 'upload-delete'
            ],
            'upload-delete' => [
                'class' => 'trntv\filekit\actions\DeleteAction'
            ],
        ];
    }
}
