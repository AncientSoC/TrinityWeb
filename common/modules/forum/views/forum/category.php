<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use common\modules\forum\Podium;
use yii\helpers\Url;

$this->title = $model->name;
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Main Forum'), 'url' => ['forum/index']];
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<?php if (!Podium::getInstance()->user->isGuest): ?>
<div class="row">
    <div class="col-sm-3 col-sm-offset-9">
        <div class="form-group">
            <a href="<?= Url::to(['forum/unread-posts']) ?>" class="btn btn-info btn-xs btn-block"><span class="glyphicon glyphicon-flash"></span> <?= Yii::t('view', 'Unread posts') ?></a>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <?= $this->render('/elements/forum/_section', ['model' => $model]) ?>
        </div>
    </div>
</div>
<?= $this->render('/elements/main/_members');
