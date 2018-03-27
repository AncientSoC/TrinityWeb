<?php
namespace common\modules\installer\helpers;

use common\modules\installer\helpers\enums\Configuration as Enum;
use Yii;
use yii\caching\FileCache;

class Configuration
{
    /**
     * Returns the dynamic params file as array
     *
     * @return array|mixed Params file
     */
    public static function getDbsCharacters()
    {
        $paramFile = Yii::getAlias('@common/config/base_characters.php');
        $param = require($paramFile);

        if (!is_array($param)) return [];

        return $param;
    }

    /**
     * Sets params into the file
     *
     * @param array $config
     */
    public static function setConfig($file, $config = [])
    {
        $content = "<" . "?php return ";
        $content .= var_export($config, TRUE);
        $content .= "; ?" . ">";

        file_put_contents($file, $content);

        if (function_exists('opcache_reset')) {
            opcache_invalidate($file);
        }
    }
}