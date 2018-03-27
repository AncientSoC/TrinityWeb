<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\Controller;

use common\models\shop\ShopItems;

class AutoCompleteController extends Controller
{
 
    protected function _return($items) {
        return json_encode([
            'total_count' => count($items),
            'items' => $items,
        ]);
    }
    
    public function actionShopItem($q) {
        $items = ShopItems::find()->where(['like','name',$q])->asArray()->all();
        
        return self::_return($items);
    }
    
}