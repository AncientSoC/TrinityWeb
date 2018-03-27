<?php
$config = [
    'components' => [
        'assetManager' => [
            'class' => yii\web\AssetManager::class,
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV
        ]
    ],
    'bootstrap' => ['install', 'forum'],
    'modules' => [
        'forum' => [
            'class' => 'common\modules\forum\Podium',
            'userComponent' => 'user',
            'adminId' => 1,
            'allowedIPs' => [env('FORUM_INSTALLING_IP_ACCESS'),'::1'],
            'rbacComponent' => 'authManager',
            'cacheComponent' => 'cache',
            'userNameField' => 'username',
        ],
        'install' => [
            'class' => common\modules\installer\InstallerModule::class
        ]
    ],
    'as locale' => [
        'class' => common\behaviors\LocaleBehavior::class,
        'enablePreferredLanguage' => true
    ]
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => yii\debug\Module::class,
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
    ];
}

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1', '172.17.42.1', '172.17.0.1', '192.168.99.1'],
    ];
}


return $config;
