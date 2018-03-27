<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

use common\models\shop\ShopCategory;
use common\models\shop\ShopItems;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories common\models\ArticleCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

$formatJs = <<< 'JS'
var formatRepo = function (repo) {
    console.log(repo);
    if (repo.loading) {
        return repo.name;
    }
    var markup =
    '<div class="row">' + 
        '<div class="col-sm-5">' +
            repo.name +
        '</div>'+
    '</div>';
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatRepoSelection = function (repo) {
    return repo.name ? repo.name : repo.text;
}
JS;
$this->registerJs($formatJs, View::POS_HEAD);

$resultsJs = <<< JS
function (data, params) {
    params.page = params.page || 1;
    return {
        results: data.items,
        pagination: {
            more: (params.page * 30) < data.total_count
        }
    };
}
JS;

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'name')->textInput([
                'placeholder' => Yii::t('backend','Оставить пустым если заполнено поле "Вещь"'),
            ]) ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($model, 'item_id')->textInput([
                'placeholder' => Yii::t('backend','Оставить пустым если заполнено поле "Наименование"'),
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'category_id')->widget(Select2::className(),[
                'data' => \yii\helpers\ArrayHelper::map(
                    ShopCategory::find()->all(),
                    'id',
                    'name'
                ),
            ])?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($model, 'type')->widget(Select2::className(),[
                'data' => ShopItems::getTypes(),
                'pluginEvents' => [
                    "select2:select" => "function() {"
                        . "if($(this).val() != '" . ShopItems::TYPE_PACK ."') { $('#hidden_package').slideUp() } else {"
                        . "$('#hidden_package').slideDown()"
                        . "}"
                    . "}",
                ],
            ]) ?>
        </div>
        
    </div>
    <div class="clearfix" id="hidden_package" <?=$model->type != ShopItems::TYPE_PACK ? 'style="display: none;"' : ''?>>
        <div class="col-md-4">
            <?php
            $callBack = ['model' => $model, 'resultJs' => $resultsJs];
            ?>
            <?= $form->field($model, 'package')->widget(MultipleInput::className(), [
                'max' => 10,
                'min' => 1,
                'columns' => [
                    [
                        'name'  => 'id',
                        'type'  => 'hiddenInput',
                    ],
                    [
                        'name'  => 'shop_item_id',
                        'title' => Yii::t('backend','Элемент магазина'),
                        'type'  => \kartik\select2\Select2::className(),
                        'enableError' => true,
                        'options' => function($model) use($callBack) {
                            return [
                                'initValueText'=> $callBack['model']->getShopItemNameById($model['shop_item_id']),
                                "class" =>  'form-control',
                                'options' => ['placeholder' => Yii::t('backend','Начните вводить для поиска...')],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'minimumInputLength' => 2,
                                    'ajax' => [
                                        'url' => Url::to(['/auto-complete/shop-item']),
                                        'dataType' => 'json',
                                        'delay' => 250,
                                        'data' => new JsExpression('function(params) { return {q:params.term, page: params.page}; }'),
                                        'processResults' => new JsExpression($callBack['resultJs']),
                                        'cache' => true
                                    ],
                                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('formatRepo'),
                                    'templateSelection' => new JsExpression('formatRepoSelection'),
                                ],
                            ];
                        },
                    ]
                ]
             ])->label(false);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"><?php echo $form->field($model, 'vCoins')->textInput() ?></div>
        <div class="col-md-4"><?php echo $form->field($model, 'dCoins')->textInput() ?></div>
        <div class="col-md-4"><?php echo $form->field($model, 'realm_id')->dropDownList(array_merge([''],Yii::$app->CharactersDbHelper::getServers(true))) ?></div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?php echo $form->field($model, 'discount')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($model, 'discount_end')->widget(
                DateTimeWidget::className(),
                [
                    'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
                ]
            ) ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>