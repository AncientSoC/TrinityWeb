<?php

namespace common\modules\bugTracker\controllers;

use Yii;
use common\modules\bugTracker\models\Task;
use common\modules\bugTracker\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\bugTracker\models\Period;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'view'
                        ],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => [
                            'create',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'permissions' => [\common\models\User::PERM_ACCESS_TO_CREATE_TASK]
                    ],
                    [
                        'actions' => [
                            'update',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [
                            'timer',
                            'update-period',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'permissions' => [\common\models\User::PERM_ACCESS_TO_CHANGE_TASK]
                    ],
                    [
                        'actions' => [
                            'delete',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'permissions' => [\common\models\User::PERM_ACCESS_TO_DELETE_TASK]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($task_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($task_id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project_id = null)
    {
        $model = new Task();
        if (!empty($project_id)) {
            $model->project_id = $project_id;
        }
        $model->priority = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),\common\models\User::PERM_ACCESS_TO_EDIT_OWN_TASK, [
            'attribute' => 'author_id',
            'model' => $model
        ]) && !Yii::$app->authManager->checkAccess(Yii::$app->user->getId(),\common\models\User::PERM_ACCESS_TO_CHANGE_TASK)) {
            Yii::$app->session->setFlash('error',(Yii::t('flash', 'Sorry! You do not have the required permission to perform this action.')));
            return $this->redirect(['index']);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'task_id' => $model->task_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTimer($action, $task_id)
    {
        $model = $this->findModel($task_id);
        $period = Period::touch($model, $action);
        if ($action == 'play' || $period == null) {
            if ($action == 'stop') {
                return $this->redirect(['index',]);
            } else {
                return $this->redirect(['view', 'task_id' => $model->task_id]);
            }
        } else {
            return $this->redirect(['update-period', 'period_id' => $period->period_id]);
        }
    }

    public function actionUpdatePeriod($period_id)
    {
        if (($model = Period::findOne($period_id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'task_id' => $model->task_id]);
        } else {
            return $this->render('update-period', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
