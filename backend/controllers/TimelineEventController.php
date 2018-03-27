<?php

namespace backend\controllers;

use backend\models\search\TimelineEventSearch;
use Yii;
use yii\web\Controller;

use yii\filters\AccessControl;
use common\models\User;

/**
 * Application timeline controller
 */
class TimelineEventController extends Controller
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
                        'permissions' => [User::PERM_ACCESS_TO_TIMELINE]
                    ],
                ],
            ],
        ]);
    }
    
    /**
     * Lists all TimelineEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TimelineEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
