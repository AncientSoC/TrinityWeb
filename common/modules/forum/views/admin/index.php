<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\Podium;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$this->title = Yii::t('view', 'Administration Dashboard');
Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJs("$('[data-toggle=\"tooltip\"]').tooltip();");
$this->registerJs("$('[data-toggle=\"popover\"]').popover();");

?>
<?= $this->render('/elements/admin/_navbar', ['active' => 'index']); ?>
<br>
<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-success">
            <div class="panel-heading"><?= Yii::t('view', 'Newest members') ?></div>
            <table class="table">
<?php foreach ($members as $member): ?>
                <tr>
                    <td>
                        <a href="<?= Url::to(['admin/view', 'id' => $member->id]) ?>"><?= $member->podiumName ?></a>
                        <span data-toggle="tooltip" data-placement="top" title="<?= Podium::getInstance()->formatter->asDateTime($member->created_at, 'long') ?>">
                            <?= Podium::getInstance()->formatter->asRelativeTime($member->created_at) ?>
                        </span>
                    </td>
                </tr>
<?php endforeach; ?>
            </table>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="panel panel-info table-responsive">
            <div class="panel-heading"><?= Yii::t('view', 'Newest posts') ?></div>
            <table class="table">
                <thead>
                    <tr>
                        <th><?= Yii::t('view', 'Thread') ?></th>
                        <th><?= Yii::t('view', 'Preview') ?></th>
                        <th><?= Yii::t('view', 'Author') ?></th>
                        <th><?= Yii::t('view', 'Date') ?></th>
                        <th><?= Yii::t('view', 'Thumbs') ?></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($posts as $post): ?>
                    <tr>
                        <td>
                            <a href="<?= Url::to(['forum/show', 'id' => $post->id]) ?>"><?= Html::encode($post->thread->name) ?></a>
                        </td>
                        <td>
                            <span data-toggle="popover" data-container="body" data-placement="right" data-trigger="hover focus" data-html="true" data-content="<small><?= str_replace('"', '&quote;', StringHelper::truncateWords($post->parsedContent, 20, '...', true)) ?></small>" title="<?= Yii::t('view', 'Post Preview') ?>">
                                <span class="glyphicon glyphicon-leaf"></span>
                            </span>
                        </td>
                        <td>
                            <a href="<?= Url::to(['admin/view', 'id' => $post->author->id]) ?>"><?= $post->author->podiumName ?></a>
                        </td>
                        <td>
                            <span data-toggle="tooltip" data-placement="top" title="<?= Podium::getInstance()->formatter->asDateTime($post->created_at, 'long') ?>">
                                <?= Podium::getInstance()->formatter->asRelativeTime($post->created_at) ?>
                            </span>
                        </td>
                        <td>
                            +<?= $post->likes ?> / -<?= $post->dislikes ?>
                        </td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
