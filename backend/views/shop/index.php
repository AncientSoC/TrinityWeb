<?php

use kartik\tree\TreeView;

echo TreeView::widget([
    'query' => $query->addOrderBy('root, lft'), 
    'headingOptions' => ['label' => Yii::t('backend','Список категорий')],
    'mainTemplate' => '<div>{wrapper}</div><div>{detail}</div>',
    'treeOptions' => [
        'style' => 'height: 200px;',
    ],
    'fontAwesome' => true,
    'isAdmin' => true,
    'displayValue' => 1,
    'softDelete' => false,
    'nodeAddlViews' => [
        2 => '@backend/views/shop/_form',
    ],
]);
?>