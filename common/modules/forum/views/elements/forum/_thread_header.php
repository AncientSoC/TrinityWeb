<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\Podium;
use yii\helpers\Url;

?>
<?php if (isset($category, $forum, $slug)): ?>
<tr class="no-hover">
    <td colspan="4" class="small">
        <ul class="list-inline">
            <li class="text-muted">
                <?= Yii::t('view', 'Show only') ?>
            </li>
<?php if (!Podium::getInstance()->user->isGuest): ?>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'new']) ?>" class="btn btn-info btn-xs <?= !empty($filters['new']) && $filters['new'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-leaf"></span>
                    <span class="hidden-xs hidden-sm"><?= Yii::t('view', 'New Posts') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"><?= Yii::t('view', 'New') ?></span>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'edit']) ?>" class="btn btn-info btn-xs <?= !empty($filters['edit']) && $filters['edit'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-comment"></span>
                    <span class="hidden-xs hidden-sm"><?= Yii::t('view', 'Edited Posts') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"><?= Yii::t('view', 'Edited') ?></span>
                </a>
            </li>
<?php endif; ?>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'hot']) ?>" class="btn btn-info btn-xs <?= !empty($filters['hot']) && $filters['hot'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-fire"></span>
                    <span class="hidden-xs hidden-sm"><?= Yii::t('view', 'Hot Threads') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"><?= Yii::t('view', 'Hot') ?></span>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'pin']) ?>" class="btn btn-info btn-xs <?= !empty($filters['pin']) && $filters['pin'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-pushpin"></span>
                    <span class="hidden-xs hidden-sm"> <?= Yii::t('view', 'Pinned Threads') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"> <?= Yii::t('view', 'Pinned') ?></span>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'lock']) ?>" class="btn btn-info btn-xs <?= !empty($filters['lock']) && $filters['lock'] ? 'active' : '' ?>">
                    <span class="glyphicon glyphicon-lock"></span>
                    <span class="hidden-xs hidden-sm"> <?= Yii::t('view', 'Locked Threads') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"> <?= Yii::t('view', 'Locked') ?></span>
                </a>
            </li>
            <li>
                <a href="<?= Url::to(['forum/forum', 'cid' => $category, 'id' => $forum, 'slug' => $slug, 'toggle' => 'all']) ?>" class="btn btn-info btn-xs">
                    <span class="glyphicon glyphicon-asterisk"></span>
                    <span class="hidden-xs hidden-sm"> <?= Yii::t('view', 'All Threads') ?></span>
                    <span class="hidden-xs hidden-md hidden-lg"> <?= Yii::t('view', 'All') ?></span>
                </a>
            </li>
        </ul>
    </td>
</tr>
<?php endif; ?>
<tr>
    <th class="col-sm-7"><small><?= Yii::t('view', 'Thread') ?></small></th>
    <th class="col-sm-1 text-center"><small><?= Yii::t('view', 'Replies') ?></small></th>
    <th class="col-sm-1 text-center"><small><?= Yii::t('view', 'Views') ?></small></th>
    <th class="col-sm-3"><small><?= Yii::t('view', 'Latest Post') ?></small></th>
</tr>
