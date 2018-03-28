<?php

use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/_clear.php')
?>
<div id="wrap">
    <nav id="header-nav" class="navbar navbar-expand-md navbar-dark fixed-top bg-nav-rf-studio">
        <div class="container">
            <?=Html::a('RF-studio',['/site/index'],[
                'class' => 'navbar-brand'
            ])?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="header-menu">
                <?php echo Nav::widget([
                    'options' => ['class' => 'navbar-nav mr-auto'],
                    'activateParents' => true,
                    'items' => [
                        [
                            'label' => Yii::t('frontend', 'Home'),
                            'url' => ['/site/index'],
                        ],
                        [
                            'label' => Yii::t('frontend', 'About'),
                            'url' => ['/page/view', 'slug'=>'about'],
                        ],
                        [
                            'label' => Yii::t('frontend', 'Community'),
                            'items'=> [
                                [
                                    'label' => Yii::t('view', 'Forum'),
                                    'url' => ['/forum/forum/index'],
                                ],
                                [
                                    'label' => Yii::t('armory', 'Армори'),
                                    'url' => ['/armory/main/index'],
                                ],
                                [
                                    'label' => Yii::t('ladder', 'Ладдер'),
                                    'url' => ['/ladder/main/index'],
                                ],
                            ]
                        ],
                        [
                            'label' => Yii::t('frontend', 'More'),
                            'items' => [
                                [
                                    'label' => Yii::t('view', 'Bugtracker'),
                                    'url' => ['/tracker/project/index'],
                                ],
                            ]
                        ],
                    ]
                ]); ?>
                <?php echo Nav::widget([
                    'options' => ['class' => 'navbar-nav ml-auto'],
                    'activateParents' => true,
                    'items' => [
                        
                        //not auth start
                        
                        [
                            'label' => Yii::t('frontend', 'Login'),
                            'url' => ['/panel/sign-in/login'],
                            'visible' => Yii::$app->user->isGuest,
                        ],
                        [
                            'label' => Yii::t('frontend', 'Signup'),
                            'url' => ['/panel/sign-in/signup'],
                            'visible' => Yii::$app->user->isGuest,
                        ],
                        
                        //not auth end
                        
                        //authed start
                        [
                            'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
                            'visible' => !Yii::$app->user->isGuest,
                            'items'=> [
                                [
                                    'label' => Yii::t('frontend', 'Личный кабинет'),
                                    'url' => ['/panel/main/index']
                                ],
                                [
                                    'label' => Yii::t('frontend', 'Настройки форума'),
                                    'url' => ['/forum/profile']
                                ],
                                [
                                    'label' => Yii::t('frontend', 'Backend'),
                                    'url' => Yii::getAlias('@backendUrl'),
                                    'visible'=> Yii::$app->user->can('moderator')
                                ]
                            ]
                        ],
                        [
                            'label' => Yii::t('frontend', 'Logout'),
                            'url' => ['/panel/sign-in/logout'],
                            'visible' => !Yii::$app->user->isGuest,
                            'linkOptions' => [
                                'data-method' => 'post',
                                'data-hover' => Yii::t('frontend', 'Logout')
                            ],
                        ],
                        //authed end
                        [
                            'label'=>Yii::t('frontend', 'Language'),
                            'active' => false,
                            'items' => array_map(function ($lang) {
                                return [
                                    'label' => $lang['name_ascii'],
                                    'url' => ['/site/set-locale', 'locale' => $lang['language_id']],
                                    'active' => false
                                ];
                            }, Yii::$app->AppHelper::getLangs())
                        ]
                    ]
                ]); ?>
            </div>
        </div>
    </nav>
    <?php echo $content ?>

</div>
<footer id="footer">
    <div class="container">
        <p class="float-left rf-studio-aqua">
            &copy; RF-studio <?php echo date('Y') ?>
        </p>
        <p class="float-right" id="free-kassa-container">
            <a href="//www.free-kassa.ru/">
                <img src="//www.free-kassa.ru/img/fk_btn/14.png">
            </a>
        </p>
    </div>
</footer>
<?php $this->endContent() ?>