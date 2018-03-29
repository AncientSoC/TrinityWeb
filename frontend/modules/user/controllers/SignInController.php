<?php

namespace frontend\modules\user\controllers;

use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

use common\actions\OauthAction;

use common\commands\SendEmailCommand;

use common\models\User;
use common\models\UserToken;

use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'activation'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'activation'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/panel/main']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return array|string|Response
     */
    public function actionLogin()
    {
        if(!Yii::$app->request->isPjax) return $this->goHome ();
        $model = new LoginForm();
        if($post = Yii::$app->request->post()) {
            $model->load($post);
            if($model->validate() && $model->login()) {
                return $this->goBack();
            }
            if(Yii::$app->request->isPjax) {
                return $this->renderAjax('@frontend/widgets/auth/views/login', [
                    'model' => $model
                ]);
            }
        }
        return $this->renderAjax('@frontend/widgets/auth/views/login', [
            'model' => $model
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionSignup()
    {
        if(!Yii::$app->request->isPjax) return $this->goHome ();
        
        $model = new SignupForm();
        
        if($post = Yii::$app->request->post()) {
            $model->load($post);
            $user = $model->signup();
            if($user !== null) {
                if (!$user->hasErrors()) {
                    if ($model->shouldBeActivated()) {
                        Yii::$app->getSession()->setFlash('success', Yii::t(
                                'frontend',
                                'Your account has been successfully created. Check your email for further instructions.'
                            ));
                    } else {
                        Yii::$app->getUser()->login($user);
                    }
                }
            }
            return $this->renderAjax('@frontend/widgets/auth/views/signup', [
                'model' => $model
            ]);
        }
        
        return $this->renderAjax('@frontend/widgets/auth/views/signup', [
            'model' => $model
        ]);
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Your account has been successfully activated.'));

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'Check your email for further instructions.'));
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('danger', Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('frontend', 'New password was saved.'));
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        $attributes = $client->getUserAttributes();
        pre($attributes);
        return true;

        throw new Exception('OAuth error');
    }
}
