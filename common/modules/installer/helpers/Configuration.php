<?php
namespace common\modules\installer\helpers;

use Yii;
use yii\caching\FileCache;

class Configuration
{
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