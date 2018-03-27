<?php
use yii\helpers\Html;
use trntv\yii\datetime\DateTimeWidget;
?>
<div class="row">
    <div class="col-md-12">
        <?php
        if(!$node->isNewRecord) {
            echo Html::a(Yii::t('backend','Просмотреть категорию'), [
                '/shop/category','id' => $node->id,
            ], ['class' => 'btn btn-default']);
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?=$form->field($node, 'discount')->textInput(['placeholder' => Yii::t('backend','% скидки')])?>
    </div>
    <div class="col-md-3">
        <?=$form->field($node,'discount_end')->widget(DateTimeWidget::className(),
            [
                'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                'options' => [
                    'placeholder' => Yii::t('backend','Дата окончания'),
                ]
            ]
        );?>
    </div>
</div>
