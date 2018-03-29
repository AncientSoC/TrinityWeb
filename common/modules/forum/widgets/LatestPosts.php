<?php

namespace common\modules\forum\widgets;

use common\modules\forum\models\Post;
use common\modules\forum\Podium;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Podium Latest Posts widget
 * Renders list of latest posts.
 *
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */
class LatestPosts extends Widget
{
    /**
     * @var int number of latest posts
     */
    public $posts = 5;

    /**
     * Renders the list of posts.
     * @return string
     */
    public function run()
    {
        $out = Html::beginTag('div', ['class' => 'card widget']) . "\n";
        $out .= Html::tag('div', Yii::t('view', 'Latest posts'), ['class' => 'card-header']) . "\n";

        $latest = Post::getLatest(is_numeric($this->posts) && $this->posts > 0 ? $this->posts : 5);

        if ($latest) {
            $out .= Html::beginTag('table', ['class' => 'table table-hover']) . "\n";
            foreach ($latest as $post) {
                $out .= Html::beginTag('tr');
                $out .= Html::beginTag('td');
                $out .= Html::a($post['title'], ['/forum/forum/show', 'id' => $post['id']], ['class' => 'center-block']) . "\n";
                $out .= Html::tag('small', Podium::getInstance()->formatter->asRelativeTime($post['created']) . "\n" . $post['author']) . "\n";
                $out .= Html::endTag('td');
                $out .= Html::endTag('tr');
            }
            $out .= Html::endTag('table') . "\n";
        } else {
            $out .= Html::beginTag('div', ['class' => 'card-body']) . "\n";
            $out .= Html::tag('small', Yii::t('view', 'No posts have been added yet.')) . "\n";
            $out .= Html::endTag('div') . "\n";
        }

        $out .= Html::endTag('div') . "\n";

        return $out;
    }
}
