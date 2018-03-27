<?php
namespace common\components\i18n;

use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;
use yii\db\Connection;
use yii\db\Expression;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;
use yii\i18n\DbMessageSource as YiiDbMessageSource;

class DbMessageSource extends YiiDbMessageSource {
    
    public function translate($category, $message, $language)
    {
        return $this->translateMessage($category, $message, $language);
    }
}