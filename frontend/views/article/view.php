<?php
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = $model->title;
Yii::$app->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <article class="article-item">
        <div class="article-head position-relative clearfix">
            <?php if ($model->thumbnail_path): ?>
                <a href="<?=Url::to(['/article/view', 'slug'=>$model->slug])?>">
                    <img class="w-100" src="<?=$model->thumbnail_base_url . '/' . $model->thumbnail_path?>" alt="<?=$model->title?>"/>
                </a>
            <?php endif; ?>
            <div class="article-title">
                <h1>
                    <?php echo Html::a($model->title, ['/article/view', 'slug'=>$model->slug]) ?>
                </h1>
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
            <?=$model->body?>
            
            <?php if (!empty($model->articleAttachments)): ?>
                <h3><?php echo Yii::t('frontend', 'Attachments') ?></h3>
                <ul id="article-attachments">
                    <?php foreach ($model->articleAttachments as $attachment): ?>
                        <li>
                            <?php echo \yii\helpers\Html::a(
                                $attachment->name,
                                ['attachment-download', 'id' => $attachment->id])
                            ?>
                            (<?php echo Yii::$app->formatter->asSize($attachment->size) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
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
    </article>
</div>