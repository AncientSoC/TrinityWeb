<?php
$config = [
    'vendorPath' => __DIR__ . '/../../vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'ru-RU',
    'language' => 'ru-RU',
    'bootstrap' => ['log', 'translatemanager'],
    'modules' => [
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ],
        'translatemanager' => [
            'class' => 'common\modules\i18n\Module',
            'root' => ['@frontend','@backend','@common','@console'],               // The root directory of the project scan.
            'scanRootParentDirectory' => true, // Whether scan the defined `root` parent directory, or the folder itself.
                                               // IMPORTANT: for detailed instructions read the chapter about root configuration.
            'layout' => '/main',         // Name of the used layout. If using own layout use 'null'.
            'allowedIPs' => ['*'],  // IP addresses from which the translation interface is accessible.
            'roles' => ['admin', 'interpreter', 'i18n_access'],               // For setting access levels to the translating interface.
            'tmpDir' => '@runtime',         // Writable directory for the client-side temporary language files.
                                            // IMPORTANT: must be identical for all applications (the AssetsManager serves the JavaScript files containing language elements from this directory).
            'phpTranslators' => ['::t'],    // list of the php function for translating messages.
            'jsTranslators' => ['lajax.t'], // list of the js function for translating messages.
            'patterns' => ['*.js', '*.php'],// list of file extensions that contain language elements.
            'ignoredCategories' => ['yii'], // these categories won't be included in the language database.
            'ignoredItems' => ['config'],   // these files will not be processed.
            'scanTimeLimit' => null,        // increase to prevent "Maximum execution time" errors, if null the default max_execution_time will be used
            'searchEmptyCommand' => '!',    // the search string to enter in the 'Translation' search field to find not yet translated items, set to null to disable this feature
            'defaultExportStatus' => 1,     // the default selection of languages to export, set to 0 to select all languages by default
            'defaultExportFormat' => 'json',// the default format for export, can be 'json' or 'xml'
            'tables' => [                   // Properties of individual tables
                [
                    'connection' => 'db',   // connection identifier
                    'table' => '{{%language}}',         // table name
                    'columns' => ['name', 'name_ascii'],// names of multilingual fields
                    'category' => 'database-table-name',// the category is the database table name
                ]
            ],
            'scanners' => [ // define this if you need to override default scanners (below)
                'common\modules\i18n\services\scanners\ScannerPhpFunction',
                'common\modules\i18n\services\scanners\ScannerPhpArray',
                'common\modules\i18n\services\scanners\ScannerJavaScriptFunction',
                'common\modules\i18n\services\scanners\ScannerDatabase',
            ],
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}'
        ],
        'CharactersDbHelper' => [
            'class' => 'common\components\helpers\CharactersDbHelper'
        ],
        'AppHelper' => [
            'class' => 'common\components\helpers\AppHelper'
        ],
        'cache' => [
            'class' => yii\caching\FileCache::class,
            'cachePath' => '@common/runtime/cache'
        ],
        'commandBus' => [
            'class' => trntv\bus\CommandBus::class,
            'middlewares' => [
                [
                    'class' => trntv\bus\middlewares\BackgroundCommandMiddleware::class,
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file' => '@console/yii'
        ],
        'formatter' => [
            'class' => yii\i18n\Formatter::class
        ],
        'glide' => [
            'class' => trntv\glide\components\Glide::class,
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],
        'fileStorage' => [
            'class' => trntv\filekit\Storage::class,
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => common\components\filesystem\LocalFlysystemBuilder::class,
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => common\behaviors\FileStorageLogBehavior::class,
                'component' => 'fileStorage'
            ]
        ],
        'keyStorage' => [
            'class' => common\components\keyStorage\KeyStorage::class
        ],
        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('BACKEND_HOST_INFO'),
                'baseUrl' => env('BACKEND_BASE_URL'),
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('FRONTEND_HOST_INFO'),
                'baseUrl' => env('FRONTEND_BASE_URL'),
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => env('STORAGE_HOST_INFO'),
                'baseUrl' => env('STORAGE_BASE_URL'),
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'path' => '@common/runtime/queue',
        ],
    ],
    'params' => [
        'mdm.admin.configs' => [
            'advanced' => [
                'app-backend' => [
                    '@common/config/base.php',
                    '@common/config/web.php',
                    '@backend/config/base.php',
                    '@backend/config/web.php',
                ],
                'app-frontend' => [
                    '@common/config/base.php',
                    '@common/config/web.php',
                    '@frontend/config/base.php',
                    '@frontend/config/web.php',
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class
    ];
}

$config = \yii\helpers\ArrayHelper::merge(
    $config,
    require(__DIR__ . '/dbs/web.php'),
    require(__DIR__ . '/dbs/auth.php'),
    require(__DIR__ . '/dbs/chars.php'),
    require(__DIR__ . '/dbs/armory.php'),
    require(__DIR__ . '/mailer/conf.php'),
    require(__DIR__ . '/freeKassa/conf.php'),
    require(__DIR__ . '/components/conf.php')
);

return $config;
