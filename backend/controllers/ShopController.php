<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\models\armory\ArmoryItemTemplate;

use common\models\shop\ShopCategory;
use common\models\shop\ShopItems;
use common\models\shop\ShopPackItems;
use yii\data\ActiveDataFilter;

use yii\filters\AccessControl;
use common\models\User;

/**
 * PageController implements the CRUD actions for Page model.
 */
class ShopController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'create',
                            'update',
                            'delete',
                            'category'
                        ],
                        'allow' => true,
                        'permissions' => [User::PERM_ACCESS_TO_STORE]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex() {   
        $query = ShopCategory::find();   
        return $this->render('index',[
            'query' => $query,
        ]);
    }
    
    protected function modelForm($model) {
        if($model) {
            
            if(!$model->vCoins) $model->vCoins = 0;
            if(!$model->dCoins) $model->dCoins = 0;
            
            foreach($model->relationShopPackItems as $key => $element) {
                $model->package[$key] = [
                    'id' => $element->id,
                    'shop_item_id' => $element->shop_item_id,
                ];
            }
            
            if($post = Yii::$app->request->post()) {
                $model->load($post);
                if($model->validate()) {
                    
                    if($model->name == '') {
                        $item = ArmoryItemTemplate::find()->where(['entry' => $model->item_id])->one();
                        if($item) {
                            $model->name = $item->name;
                        }
                    }
                    
                    $model->save();
                    $model->savePackage();
                    Yii::$app->session->setFlash('success',Yii::t('app','Элемент успешно добавлен'));
                    return $this->redirect(['/shop/category', 'id' => $model->category_id]);
                }
            }
            return $this->render('_item_form',[
                'model' => $model,
            ]);
            
        } else {
            Yii::$app->session->setFlash('error',Yii::t('app','Элемент не найден'));
            return $this->redirect(['/shop/index']);
        }
    }
    
    public function actionUpdate($id) {
        return self::modelForm(ShopItems::findOne($id));
    }
    
    public function actionCreate($category) {
        return self::modelForm(new ShopItems(['category_id' => $category]));
    }
    
    public function actionCategory($id) {
        
        $searchModel = new ShopItems(['category_id' => $id]);
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('category',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id) {
        $model = ShopItems::findOne([$id]);
        $model->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

}
