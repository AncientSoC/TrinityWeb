<?php

namespace frontend\modules\store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\shop\ShopBasket;

/**
 * SearchForm
 */
class BasketForm extends Model
{
    
    public $count = null;
    public $item_id = null;
    
    private $id = null;
    
    
    public function __construct($config = array()) {
        parent::__construct($config);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count','item_id'], 'integer', 'min' => 1]
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'count' => 'Count',
        ];
    }
    
    public function formName() {return '';}
    
    public function addItem() {
        if($post = Yii::$app->request->post()) {
            $this->load($post);
            
            
            $basket_item = ShopBasket::findOne([
                'user_id' => Yii::$app->user->getId(),
                'item_id' => $this->item_id
            ]);
            if($basket_item) {
                $basket_item->count += $this->count;
                $basket_item->save();
            } else {
                $basket_item = new ShopBasket();
                $basket_item->item_id = $this->item_id;
                $basket_item->count = $this->count;
                $basket_item->save();
            }
        }
    }
    
    public function countItems() {
        $count = 0;
        $items = ShopBasket::find()->where([
                    'user_id' => Yii::$app->user->getId(),
                ])->asArray()->all();
        foreach($items as $item) {
            $count += $item['count'];
        }
        return $count;
    }
    
}