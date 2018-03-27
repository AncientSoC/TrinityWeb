<?php

namespace frontend\modules\store\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\shop\ShopCategory;
use frontend\modules\store\models\SearchForm;
use frontend\modules\store\models\BasketForm;

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
                        'actions' => ['index', 'basket'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-item' => ['post']
                ]
            ]
        ];
    }
    
    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        
        $basket = new BasketForm();
        $basket->addItem();
        
        $isNoErrors = ShopCategory::buildBreadCrumbs();
        if($isNoErrors === false) {
            Yii::$app->session->setFlash('error',Yii::t('store','Данной категории не существует!'));
            return $this->redirect(['/store']);
        }
        $searchModel = new SearchForm();
        $data = $searchModel->findItems(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'searchResult' => $data['result'],
            'counter' => $data['counter'],
            'category_discount_info' => $data['category_discount_info'],
            'basket' => $basket,
        ]);
    }
    
    public function actionBasket() {
        Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('store','Корзина')];
        $this->layout = '/main_full';
        return $this->render('basket');
    }
    
}