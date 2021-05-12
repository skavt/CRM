<?php

use app\models\User;
use yii\helpers\Html;

/* @var $user User */
$portalUrl = env('PORTAL_HOST')
?>

<p><?php echo 'Hello' ?> <?= $user->username ?>,</p>

<p>
    <?php echo 'Follow the link below to reset your password' ?>
	<br>
    <?php echo Html::a(Html::encode('Password Reset'), "$portalUrl/reset-password/$user->password_reset_token") ?>
</p>

