<?php

namespace common\modules\forum\controllers;

use common\modules\forum\filters\AccessControl;
use common\modules\forum\log\Log;
use common\modules\forum\models\Content;
use common\modules\forum\models\Email;
use common\modules\forum\models\Meta;
use common\modules\forum\models\Subscription;
use common\modules\forum\models\User;
use common\modules\forum\Podium;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Podium Profile controller
 * All actions concerning member profile.
 *
 * @author Paweł Bizley Brzozowski <pawel@positive.codes>
 * @since 0.1
 */
class ProfileController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['account/login']);
                },
                'rules' => [
                    ['class' => 'common\modules\forum\filters\InstallRule'],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Updating the forum details.
     * @return string|Response
     */
    public function actionForum()
    {
        $user = User::findMe();
        $model = Meta::find()->where(['user_id' => $user->id])->limit(1)->one();
        if (empty($model)) {
            $model = new Meta();
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = $user->id;
            $uploadAvatar = false;
            $path = Yii::getAlias('@webroot/avatars');
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {
                if ($model->save(false)) {
                    Log::info('Profile updated', $model->id, __METHOD__);
                    $this->success(Yii::t('flash', 'Your profile details have been updated.'));
                    return $this->refresh();
                }
            }
        }
        return $this->render('forum', ['model' => $model, 'user' => $user]);
    }

    /**
     * Showing the profile card.
     * @return string|Response
     */
    public function actionIndex()
    {
        $model = User::findMe();
        if (empty($model)) {
            if ($this->module->userComponent === true) {
                return $this->redirect(['account/login']);
            }
            return $this->module->goPodium();
        }
        return $this->render('profile', ['model' => $model]);
    }

    /**
     * Signing out.
     * @return Response
     */
    public function actionLogout()
    {
        Podium::getInstance()->user->logout();
        return $this->module->goPodium();
    }

    /**
     * Showing the subscriptions.
     * @return string|Response
     */
    public function actionSubscriptions()
    {
        $postData = Yii::$app->request->post();
        if ($postData) {
            if (Subscription::remove(!empty($postData['selection']) ? $postData['selection'] : [])) {
                $this->success(Yii::t('flash', 'Subscription list has been updated.'));
            } else {
                $this->error(Yii::t('flash', 'Sorry! There was an error while unsubscribing the thread list.'));
            }
            return $this->refresh();
        }
        return $this->render('subscriptions', [
            'dataProvider' => (new Subscription())->search(Yii::$app->request->get())
        ]);
    }

    /**
     * Marking the subscription of given ID.
     * @param int $id
     * @return Response
     */
    public function actionMark($id = null)
    {
        $model = Subscription::find()->where(['id' => $id, 'user_id' => User::loggedId()])->limit(1)->one();
        if (empty($model)) {
            $this->error(Yii::t('flash', 'Sorry! We can not find Subscription with this ID.'));
            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->post_seen == Subscription::POST_SEEN) {
            if ($model->unseen()) {
                $this->success(Yii::t('flash', 'Thread has been marked unseen.'));
            } else {
                Log::error('Error while marking thread', $model->id, __METHOD__);
                $this->error(Yii::t('flash', 'Sorry! There was some error while marking the thread.'));
            }
            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->post_seen == Subscription::POST_NEW) {
            if ($model->seen()) {
                $this->success(Yii::t('flash', 'Thread has been marked seen.'));
            } else {
                Log::error('Error while marking thread', $model->id, __METHOD__);
                $this->error(Yii::t('flash', 'Sorry! There was some error while marking the thread.'));
            }
            return $this->redirect(['profile/subscriptions']);
        }
        $this->error(Yii::t('flash', 'Sorry! Subscription has got the wrong status.'));
        return $this->redirect(['profile/subscriptions']);
    }

    /**
     * Deleting the subscription of given ID.
     * @param int $id
     * @return Response
     */
    public function actionDelete($id = null)
    {
        $model = Subscription::find()->where(['id' => (int)$id, 'user_id' => User::loggedId()])->limit(1)->one();
        if (empty($model)) {
            $this->error(Yii::t('flash', 'Sorry! We can not find Subscription with this ID.'));
            return $this->redirect(['profile/subscriptions']);
        }
        if ($model->delete()) {
            $this->module->podiumCache->deleteElement('user.subscriptions', User::loggedId());
            $this->success(Yii::t('flash', 'Thread has been unsubscribed.'));
        } else {
            Log::error('Error while deleting subscription', $model->id, __METHOD__);
            $this->error(Yii::t('flash', 'Sorry! There was some error while deleting the subscription.'));
        }
        return $this->redirect(['profile/subscriptions']);
    }

    /**
     * Subscribing the thread of given ID.
     * @param int $id
     * @return Response
     */
    public function actionAdd($id = null)
    {
        if (!Yii::$app->request->isAjax) {
            return $this->redirect(['forum/index']);
        }

        $data = [
            'error' => 1,
            'msg' => Html::tag('span',
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                . ' ' . Yii::t('view', 'Error while adding this subscription!'),
                ['class' => 'text-danger']
            ),
        ];

        if (Podium::getInstance()->user->isGuest) {
            $data['msg'] = Html::tag('span',
                Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                . ' ' . Yii::t('view', 'Please sign in to subscribe to this thread'),
                ['class' => 'text-info']
            );
        }

        if (is_numeric($id) && $id > 0) {
            $subscription = Subscription::find()->where(['thread_id' => $id, 'user_id' => User::loggedId()])->limit(1)->one();
            if (!empty($subscription)) {
                $data['msg'] = Html::tag('span',
                    Html::tag('span', '', ['class' => 'glyphicon glyphicon-warning-sign'])
                    . ' ' . Yii::t('view', 'You are already subscribed to this thread.'),
                    ['class' => 'text-info']
                );
            } else {
                if (Subscription::add((int)$id)) {
                    $data = [
                        'error' => 0,
                        'msg'   => Html::tag('span',
                            Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok-circle'])
                            . ' ' . Yii::t('view', 'You have subscribed to this thread!'),
                            ['class' => 'text-success']
                        ),
                    ];
                }
            }
        }
        return Json::encode($data);
    }
}
