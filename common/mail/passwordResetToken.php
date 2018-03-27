<?php

use Yii;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $token string */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/sign-in/reset-password', 'token' => $token]);
?>
<div class="mail-row">
    <?=Yii::t('mail','Вы получили это письмо, поскольку кто-то начал процесс смены пароля на {project}',[
        'project' => Yii::$app->name,
    ])?>
</div>
<div class="mail-row">
    <?=Yii::t('mail','Если это были вы, перейдите по ссылке и следуйте указаниям на экране.')?>
    <div class="mail-row">
        <?php echo Html::a(Yii::t('mail','Ваша ссылка для сброса'), $resetLink, [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>
</div>
<div class="mail-row">
    <?=Yii::t('mail','Если это были не вы, просто проигнорируйте данное письмо.<br/>Спасибо!')?>
</div>