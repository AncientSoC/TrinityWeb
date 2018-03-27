<?php
namespace common\modules\installer\controllers;

use common\modules\installer\helpers\enums\Configuration as Enum;
use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Install Controller shows a simple welcome page.
 *
 * @author Abhimanyu Saharan
 */
class InstallController extends Controller
{
    public $layout = 'setup';

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::className(),
            ],
        ];
    }

    /**
     * Initiates application setup
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}