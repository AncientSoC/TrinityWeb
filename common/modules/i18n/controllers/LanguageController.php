<?php

namespace common\modules\i18n\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use common\modules\i18n\models\Language;

/**
 * Controller for managing multilinguality.
 *
 * @author Lajos Molnár <lajax.m@gmail.com>
 *
 * @since 1.0
 */
class LanguageController extends Controller
{
    /**
     * @var \common\modules\i18n\Module TranslateManager module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'list';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                        'roles' => $this->module->roles,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'list' => [
                'class' => 'common\modules\i18n\controllers\actions\ListAction',
            ],
            'change-status' => [
                'class' => 'common\modules\i18n\controllers\actions\ChangeStatusAction',
            ],
            'optimizer' => [
                'class' => 'common\modules\i18n\controllers\actions\OptimizerAction',
            ],
            'scan' => [
                'class' => 'common\modules\i18n\controllers\actions\ScanAction',
            ],
            'translate' => [
                'class' => 'common\modules\i18n\controllers\actions\TranslateAction',
            ],
            'save' => [
                'class' => 'common\modules\i18n\controllers\actions\SaveAction',
            ],
            'dialog' => [
                'class' => 'common\modules\i18n\controllers\actions\DialogAction',
            ],
            'message' => [
                'class' => 'common\modules\i18n\controllers\actions\MessageAction',
            ],
            'view' => [
                'class' => 'common\modules\i18n\controllers\actions\ViewAction',
            ],
            'create' => [
                'class' => 'common\modules\i18n\controllers\actions\CreateAction',
            ],
            'update' => [
                'class' => 'common\modules\i18n\controllers\actions\UpdateAction',
            ],
            'delete' => [
                'class' => 'common\modules\i18n\controllers\actions\DeleteAction',
            ],
            'delete-source' => [
                'class' => 'common\modules\i18n\controllers\actions\DeleteSourceAction',
            ],
            'import' => [
                'class' => 'common\modules\i18n\controllers\actions\ImportAction',
            ],
            'export' => [
                'class' => 'common\modules\i18n\controllers\actions\ExportAction',
            ],
        ];
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return Language the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns an ArrayDataProvider consisting of language elements.
     *
     * @param array $languageSources
     *
     * @return ArrayDataProvider
     */
    public function createLanguageSourceDataProvider($languageSources)
    {
        $data = [];
        foreach ($languageSources as $category => $messages) {
            foreach ($messages as $message => $boolean) {
                $data[] = [
                    'category' => $category,
                    'message' => $message,
                ];
            }
        }

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);
    }
}
