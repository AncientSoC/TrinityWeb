<?php

/**
 * Podium Module
 * Yii 2 Forum Module
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$this->title = Yii::t('view', 'Delete Posts');
Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('view', 'Main Forum'), 'url' => ['forum/index']];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->forum->category->name, 'url' => ['forum/category', 'id' => $model->forum->category->id, 'slug' => $model->forum->category->slug]];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->forum->name, 'url' => ['forum/forum', 'cid' => $model->forum->category->id, 'id' => $model->forum->id, 'slug' => $model->forum->slug]];
Yii::$app->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['forum/thread', 'cid' => $model->forum->category->id, 'fid' => $model->forum->id, 'id' => $model->id, 'slug' => $model->slug]];
Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <strong><?= Yii::t('view', 'Select posts to delete') ?></strong>:
            </div>
        </div>
    </div>
</div><br>

<?= Html::beginForm(); ?>
<?php Pjax::begin(); ?>
<?= ListView::widget([
    'dataProvider'     => $dataProvider,
    'itemView'         => '/elements/forum/_post_select',
    'summary'          => '',
    'emptyText'        => Yii::t('view', 'No posts have been added yet.'),
    'emptyTextOptions' => ['tag' => 'h3', 'class' => 'text-muted'],
    'pager'            => ['options' => ['class' => 'pagination pull-right']]
]); ?>
<?php Pjax::end(); ?>
    <br>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <?= Html::submitButton('<span class="glyphicon glyphicon-ok-sign"></span> ' . Yii::t('view', 'Delete Posts'), ['class' => 'btn btn-block btn-danger', 'name' => 'save-button']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
<?= Html::endForm();
