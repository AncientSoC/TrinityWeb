<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\models\Forum;
use yii\widgets\ListView;

?>
<?= ListView::widget([
    'dataProvider'     => (new Forum())->search($category,true),
    'itemView'         => '/elements/forum/_forum',
    'summary'          => '',
    'emptyText'        => Yii::t('view', 'No forums have been added yet.'),
    'emptyTextOptions' => ['tag' => 'td', 'class' => 'text-muted', 'colspan' => 4],
    'options'          => ['tag' => 'tbody', 'class' => null],
    'itemOptions'      => ['tag' => 'tr']
]);
