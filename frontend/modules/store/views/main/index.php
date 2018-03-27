<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use frontend\modules\store\models\BasketForm;
use frontend\modules\store\models\SearchForm;

$this->registerJsFile('https://cdn.cavernoftime.com/api/tooltip.js');

if($counter) {
    $pages = new Pagination(['totalCount' => $counter, 'defaultPageSize' => SearchForm::PAGE_SIZE]);
}
$form = ActiveForm::begin([
    'id' => 'store-form',
    'method' => 'get',
    'action' => $cid = Yii::$app->request->get('cid') ? '/store/' . Yii::$app->request->get('cid') : '/store',
]); ?>
    <div class="row">
        <div class="col-xs-12 col-md-8">
            <?php echo $form->field($searchModel, 'query')->textInput([
                'placeholder' => Yii::t('store','Введите текст для поиска...')
            ])->label(false) ?>
        </div>
        <div class="col-xs-12 col-md-4">
            <?php echo $form->field($searchModel, 'server')->dropDownList($searchModel->getServers(),[
                    'prompt' => Yii::t('cp','Выберите сервер'),
                    'name' => 'server',
                ])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'dCoinsFrom')->textInput([
                        'placeholder' => Yii::t('store','от')
                    ])->label(false) ?>
                </div>
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'dCoinsTo')->textInput([
                        'placeholder' => Yii::t('store','до')
                    ])->label(false) ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="row">
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'vCoinsFrom')->textInput([
                        'placeholder' => Yii::t('store','от')
                    ])->label(false) ?>
                </div>
                <div class="col-xs-6">
                    <?php echo $form->field($searchModel, 'vCoinsTo')->textInput([
                        'placeholder' => Yii::t('store','до')
                    ])->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-md-3">
            <?php echo $form->field($searchModel, 'field_order')->dropDownList($searchModel->getFieldsToSotring(),[
                'placeholder' => Yii::t('store','Сортировка по...')
            ])->label(false) ?>
        </div>
        <div class="col-xs-6 col-md-3">
            <?php echo $form->field($searchModel, 'order')->dropDownList([
                SORT_DESC => Yii::t('common','По убыванию'),
                SORT_ASC => Yii::t('common','По возрастанию'),
            ])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="form-group text-center-sm text-center-xs">
                <?php echo Html::submitButton(Yii::t('common', 'Поиск'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<div id="store-list">
    <?php
    if($category_discount_info) {
        ?>
        <h4 class="text-center">
            <?=Yii::t('store','На эту категорию действует скидка в размере {discount}%.<br/>Скидки суммируются!', [
                'discount' => $category_discount_info['value'],
            ])?>
        </h4>
        <?php
    }
    ?>
    <hr/>
    <?php Pjax::begin(['id' => 'basket'])?>
        <div id="basket-block">
            <a href="<?=Url::to(['basket'])?>" data-pjax="0">
                <div style="font-size:20px;" class="text-center">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <?=$basket->countItems()?>
                </div>
            </a>
        </div>
    <?php Pjax::end(); ?>
    <?php
    if($searchResult) {
        ?>
        <div class="row">
            <?php
            foreach($searchResult as $item) {
                if($item['relationItemInfo']) {
                    $data_item = [
                        'item_url' => Yii::$app->AppHelper->buildDBUrl($item['item_id'], Yii::$app->AppHelper::$TYPE_ITEM),
                        'icon_url' => Yii::$app->AppHelper->buildItemIconUrl(null, $item['relationItemInfo']['relationIcon']['icon']),
                        'rel_item' => null,
                    ];
                } else {
                    $data_item = [
                        'item_url' => 'self',
                        'icon_url' => '',
                        'rel_item' => null,
                    ];
                }
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="panel panel-default widget store-item">
                    <div class="panel-heading">
                        <div class="row display-flex items-middle">
                            <div class="col-xs-1 col-sm-3 text-center">
                                <img src="<?=$data_item['icon_url']?>" class="store-item-icon" />
                            </div>
                            <div class="col-xs-11 col-sm-9">
                                <a href="<?=$data_item['item_url']?>" class="store-item-name" target="_blank">
                                    <?=$item['name']?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row text-center">
                            <div class="col-xs-6">
                                <?php
                                if(!$item['discount']) {
                                ?>
                                    <span class="rf-studio-gold"><?=$item['dCoins']?></span>
                                <?php
                                } else {
                                    $cost = $item['dCoins'] * ($item['discount'] / 100);
                                    if($item['relationCategory']) {
                                        if($item['relationCategory']['discount']) {
                                            $cost = $cost * ($item['relationCategory']['discount'] / 100);
                                        }
                                    }
                                ?>
                                    <span class="rf-studio-gray text-line-through"><?=$item['dCoins']?></span>
                                    <span class="rf-studio-gold"><?=(int)$cost?></span>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <?php
                                if(!$item['discount']) {
                                ?>
                                    <span class="rf-studio-silver"><?=$item['vCoins']?></span>
                                <?php
                                } else {
                                    $cost = $item['vCoins'] * ($item['discount'] / 100);
                                    if($item['relationCategory']) {
                                        if($item['relationCategory']['discount']) {
                                            $cost = $cost * ($item['relationCategory']['discount'] / 100);
                                        }
                                    }
                                ?>
                                    <span class="rf-studio-gray text-line-through"><?=$item['vCoins']?></span>
                                    <span class="rf-studio-silver"><?=(int)$cost?></span>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <?php Pjax::begin([
                            'id' => 'pjax_container_' . $item['id'],
                            'options' => [
                                'class' => 'store_pjax_item'
                            ]
                        ])?>
                            <?php $form = ActiveForm::begin([
                                'id' => 'store_form_' . $item['id'],
                                'options' => ['data-pjax' => true],
                            ]);
                                $model_form = new BasketForm(['item_id' => $item['id']]);
                                echo $form->field($model_form, 'item_id')->hiddenInput()->label(false);
                                ?>
                                <div class="row">
                                    <div class="col-xs-7 col-md-5 col-lg-6">
                                        <?php
                                        echo $form->field($model_form,'count')
                                                ->textInput([
                                                    'placeholder' => Yii::t('store','количество')
                                                ])->label(false)->error(false);
                                        ?>
                                    </div>
                                    <div class="col-xs-5 col-md-7 col-lg-6">
                                        <?php
                                        echo Html::submitButton(Yii::t('store', 'Добавить'), [
                                            'class' => 'btn btn-primary',
                                            'name' => 'add-button',
                                        ]) ?>
                                    </div>
                                </div>
                            <?php $form::end();?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    <div class="col-xs-push-3 col-xs-6 col-sm-push-4 col-sm-4 col-md-push-5 col-md-4">
    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
    ?>
    </div>
    <?php
    }
    ?>
</div>
