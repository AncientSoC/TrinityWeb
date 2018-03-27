<?php

namespace frontend\modules\store\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use common\models\shop\ShopItems;
use common\models\shop\ShopCategory;

/**
 * SearchForm
 */
class SearchForm extends Model
{
    
    const PAGE_SIZE = 25;
    
    public $category;
    public $server;
    public $order;
    public $field_order;
    public $query;
    public $dCoinsFrom;
    public $dCoinsTo;
    public $vCoinsFrom;
    public $vCoinsTo;
    public $discount = false;
    public $cat_ids;
    
    private $category_model;
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->field_order = 'id';
        $this->order = SORT_DESC;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['server','field_order','category'], 'safe'],
            [['order','dCoinsFrom','dCoinsTo','vCoinsFrom','vCoinsTo'], 'integer'],
            ['query', 'string', 'min' => 2],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'server' => Yii::t('common', 'Игровой мир'),
            'query' => Yii::t('armory', 'Строка поиска'),
            'order' => Yii::t('common', 'Сортировать по...'),
            'discount' => Yii::t('store', 'Только со скидкой'),
        ];
    }
    
    public function getServers() {
        $servers = Yii::$app->CharactersDbHelper->getServers(true);
        $data = [];
        foreach($servers as $server) {
            $data[$server] = $server;
        }
        return $data;
    }
    
    public function getFieldsToSotring() {
        return [
            'id' => Yii::t('store','По номеру'),
            'name' => Yii::t('store','По имени'),
            'dCoins' => Yii::t('store','По dCoins'),
            'vCoins' => Yii::t('store','По vCoins'),
            'realm_id' => Yii::t('store','По игровому миру'),
            'discount_end' => Yii::t('store','По окончанию скидки'),
        ];
    }
    
    public function findItems($params) {
        $this->load($params);
        
        if(isset($params['cid'])) {
            $this->category = $params['cid'];
        }
        
        if($this->category && is_int((int)$this->category)) {
            $this->category_model = ShopCategory::findOne($this->category);
            $this->cat_ids = [];
            foreach($this->category_model->children()->all() as $child) {
                $this->cat_ids[] = $child->id;
            }
            $this->cat_ids[] = $this->category;
        }
        
        if(!isset($this->getFieldsToSotring()[$this->field_order])) $this->field_order = ShopItems::primaryKey();
        
        $query = ShopItems::find()
                ->where(['visible' => true])
                ->asArray()->orderBy([$this->field_order => $this->order])
                ->with(['relationItemInfo.relationIcon', 'relationCategory']);
        
        $query->andFilterWhere(['category_id' => $this->cat_ids]);
        $query->andFilterWhere(['<=', 'dCoins', $this->dCoinsTo]);
        $query->andFilterWhere(['>=', 'dCoins', $this->dCoinsFrom]);
        
        $query->andFilterWhere(['<=', 'vCoins', $this->vCoinsTo]);
        $query->andFilterWhere(['>=', 'vCoins', $this->vCoinsFrom]);
        
        $query->andFilterWhere(['like', 'name', $this->query]);
        
        if($this->discount) {
            $query->andWhere(['not', ['discount' => null]]);
        }
        if($this->server) {
            $query->andWhere(['realm_id' => $this->server]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $category_discount_info = [];
        if($this->category_model) {
            if(strtotime($this->category_model->discount_end) >= time()) {
                $category_discount_info = [
                    'value' => $this->category_model->discount
                ];
            }
        }
        
        
        $data = Yii::$app->cache->get(Yii::$app->request->url);
        $counter = Yii::$app->cache->get(Yii::$app->request->url . '_counter');
        if($data === false || $counter === false) {
            $data = $dataProvider->getModels();
            $counter = $dataProvider->getTotalCount();
            Yii::$app->cache->set(Yii::$app->request->url . '_counter',$counter,Yii::$app->keyStorage->get('frontend.cache_store_search'));
            Yii::$app->cache->set(Yii::$app->request->url,$data,Yii::$app->keyStorage->get('frontend.cache_store_search'));
        }
        return ['result' => $data, 'counter' => $counter, 'category_discount_info' => $category_discount_info];
    }
    
    public function formName() {return '';}
    
}