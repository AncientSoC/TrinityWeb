<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\models\Post;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::t('view', 'Posts created by {name}', ['name' => $user->podiumName]);
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Members List'), 'url' => ['members/index']];
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Member View'), 'url' => ['members/view', 'id' => $user->id, 'slug' => $user->podiumSlug]];
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<ul class="nav nav-tabs">
    <li role="presentation"><a href="<?= Url::to(['members/index']) ?>"><span class="glyphicon glyphicon-user"></span> <?= Yii::t('view', 'Members List') ?></a></li>
    <li role="presentation"><a href="<?= Url::to(['members/mods']) ?>"><span class="glyphicon glyphicon-scissors"></span> <?= Yii::t('view', 'Moderation Team') ?></a></li>
    <li role="presentation"><a href="<?= Url::to(['members/view', 'id' => $user->id, 'slug' => $user->podiumSlug]) ?>"><span class="glyphicon glyphicon-eye-open"></span> <?= Yii::t('view', 'Member View') ?></a></li>
    <li role="presentation" class="active"><a href="#"><span class="glyphicon glyphicon-comment"></span> <?= Yii::t('view', 'Posts created by {name}', ['name' => $user->podiumName]) ?></a></li>
</ul>
<br>
<?php Pjax::begin();
echo ListView::widget([
    'dataProvider'     => (new Post())->searchByUser($user->id),
    'itemView'         => '/elements/forum/_post',
    'viewParams'       => ['parent' => true],
    'summary'          => '',
    'emptyText'        => Yii::t('view', 'No posts have been added yet.'),
    'emptyTextOptions' => ['tag' => 'h3', 'class' => 'text-muted'],
    'pager'            => ['options' => ['class' => 'pagination pull-right']]
]);
Pjax::end(); ?>
<br>
