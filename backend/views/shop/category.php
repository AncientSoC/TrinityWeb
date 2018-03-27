<?php
use yii\grid\GridView;
use yii\helpers\Html;
use trntv\yii\datetime\DateTimeWidget;
use kartik\select2\Select2;
use common\models\shop\ShopCategory;

$this->title = Yii::t('backend', 'Упарвление категорией');
Yii::$app->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a(
        Yii::t('backend', 'Добавить элемент'),
        ['create', 'category' => $searchModel->category_id],
        ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'class' => 'grid-view table-responsive'
    ],
    'columns' => [
        'id',
        [
            'attribute' => 'category_id',
            'filter' => Select2::widget([
                'data' => \yii\helpers\ArrayHelper::map(
                    ShopCategory::find()->all(),
                    'id',
                    'name'
                ),
                'model' => $searchModel,
                'attribute' => 'category_id',
            ]),
        ],
        'name',
        [
            'attribute' => 'type',
            'filter' => $searchModel->getTypes(),
            'value' => function($model) {
                return $model->getType();
            }
        ],
        'discount',
        'dCoins',      
        'vCoins',      
        [
            'attribute' => 'realm_id',
            'filter' => Yii::$app->CharactersDbHelper::getServers(true),
            'value' => function($model) {
                if($model->realm_id !== 0) {
                    return Yii::$app->CharactersDbHelper->getServerNameById($model->realm_id);
                }
                return null;
            }
        ],
        [
            'attribute' => 'discount_end',
            'filter' => false,
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'
        ]
    ]
]); ?>