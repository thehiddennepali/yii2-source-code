<?php

/* @var $this yii\web\View */
/* @var $user user\models\User */
/* @var $token user\models\Token */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/guest/reset-password', 'token' => $token->token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
