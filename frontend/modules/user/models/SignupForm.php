<?php

namespace frontend\modules\user\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

use cheatsheet\Time;

use common\commands\SendEmailCommand;

use common\models\User;
use common\models\UserToken;

use frontend\modules\user\Module;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /**
     * @var
     */
    public $username;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;
    public $r_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => '\common\models\User',
                'message' => Yii::t('frontend', 'This email address has already been taken.')
            ],

            [['password', 'r_password'], 'required'],
            [['password', 'r_password'], 'string', 'min' => 6],
            ['r_password', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('frontend', "Passwords don't match") ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'E-mail'),
            'password' => Yii::t('frontend', 'Password'),
            'r_password' => Yii::t('frontend', 'Repeat password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     */
    public function signup($role = null, $no_check_forum = false)
    {
        if ($this->validate()) {
            $shouldBeActivated = $this->shouldBeActivated();
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            $user->createAccount();
            if (!$user->save()) {
                throw new Exception("User couldn't be saved");
            };
            $user->afterSignup([],$role, $no_check_forum);
            if ($shouldBeActivated) {
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_ACTIVATION,
                    Time::SECONDS_IN_A_DAY
                );
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('frontend', 'Activation email'),
                    'view' => 'activation',
                    'to' => $this->email,
                    'params' => [
                        'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
                    ]
                ]));
            }
            return $user;
        }

        return null;
    }

    /**
     * @return bool
     */
    public function shouldBeActivated()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule) {
            return false;
        } elseif ($userModule->shouldBeActivated) {
            return true;
        } else {
            return false;
        }
    }
}
