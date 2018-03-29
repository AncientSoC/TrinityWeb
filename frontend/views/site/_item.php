<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="article-item">
    <div class="article-head position-relative clearfix">
        <?php if ($model->thumbnail_path): ?>
            <a href="<?=Url::to(['/article/view', 'slug'=>$model->slug])?>">
                <img class="w-100" src="<?=$model->thumbnail_base_url . '/' . $model->thumbnail_path?>" alt="<?=$model->title?>"/>
            </a>
        <?php endif; ?>
        <div class="article-title">
            <h3>
                <?php echo Html::a($model->title, ['/article/view', 'slug'=>$model->slug]) ?>
            </h3>
        </div>
        <?php echo Html::a(
            $model->category->title,
            ['/category/' . $model->category_id],
            [
                'class' => 'article-category'
            ]
        )?>
    </div>
    <div class="article-body">
        <?php echo \yii\helpers\StringHelper::truncate($model->body, 350, '...', null, true) ?>
    </div>
    <div class="article-footer">
        <span class="article-date">
            <?php echo Yii::$app->formatter->asDatetime($model->created_at) ?>
        </span>
        <?php
        if($model->author) {
        ?>
            <span class="article-author float-right rf-studio-aqua">
                <i class="fa fa-user"></i>
                <?=$model->author->username?>
            </span>
        <?php
        }
        ?>
    </div>
</div>