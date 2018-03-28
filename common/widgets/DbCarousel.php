<?php
/**
 * Eugine Terentev <eugine@terentev.net>
 */

namespace common\widgets;

use common\models\WidgetCarousel;
use common\models\WidgetCarouselItem;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Carousel;
use yii\helpers\Html;

/**
 * Class DbCarousel
 * @package common\widgets
 */
class DbCarousel extends Carousel
{
    /**
     * @var
     */
    public $key;

    /**
     * @var array
     */
    public $controls = [
        '<span class="glyphicon glyphicon-chevron-left"></span>',
        '<span class="glyphicon glyphicon-chevron-right"></span>',
    ];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->key) {
            throw new InvalidConfigException;
        }
        $cacheKey = [
            WidgetCarousel::className(),
            $this->key
        ];
        $items = Yii::$app->cache->get($cacheKey);
        if ($items === false) {
            $items = [];
            $query = WidgetCarouselItem::find()
                ->joinWith('carousel')
                ->where([
                    '{{%widget_carousel_item}}.status' => 1,
                    '{{%widget_carousel}}.status' => WidgetCarousel::STATUS_ACTIVE,
                    '{{%widget_carousel}}.key' => $this->key,
                ])
                ->orderBy(['order' => SORT_ASC]);
            foreach ($query->all() as $k => $item) {
                /** @var $item \common\models\WidgetCarouselItem */
                if ($item->path) {
                    $items[$k]['content'] = Html::img($item->getImageUrl());
                }

                if ($item->url) {
                    $items[$k]['content'] = Html::a($items[$k]['content'], $item->url, ['target' => '_blank']);
                }

                if ($item->caption) {
                    $items[$k]['caption'] = $item->caption;
                }
            }
            Yii::$app->cache->set($cacheKey, $items, 60 * 60 * 24 * 365);
        }
        $this->items = $items;
        parent::init();
    }

    public function renderProcessBar() {
        return '<hr class="transition-timer-carousel-progress-bar" />';
    }
    
    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerPlugin('carousel');
        $content = '';
        if (!empty($this->items)) {
            $content = implode("\n", [
                $this->renderIndicators(),
                $this->renderItems(),
                $this->renderControls(),
                $this->renderProcessBar(),
            ]);
        }
        return Html::tag('div', $content, $this->options);
    }
    
    /**
     * Renders previous and next control buttons.
     * @throws InvalidConfigException if [[controls]] is invalid.
     */
    public function renderControls()
    {
        if (isset($this->controls[0], $this->controls[1])) {
            return Html::a($this->controls[0], '#' . $this->options['id'], [
                'class' => 'carousel-control-prev',
                'data-slide' => 'prev',
            ]) . "\n"
            . Html::a($this->controls[1], '#' . $this->options['id'], [
                'class' => 'carousel-control-next',
                'data-slide' => 'next',
            ]);
        } elseif ($this->controls === false) {
            return '';
        } else {
            throw new InvalidConfigException('The "controls" property must be either false or an array of two elements.');
        }
    }
    
}
