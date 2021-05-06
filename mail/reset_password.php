<?php

use app\models\User;
use yii\helpers\Html;

/* @var $user User */
?>

<p><?php echo Yii::t('app', 'Hello') ?> <?= $user->username ?>,</p>

<p>
    <?php echo Yii::t('app', 'Follow the link below to reset your password') ?>
	<br>
    <?php echo Html::a(Html::encode(Yii::t('app', 'Password Reset'))) ?>
</p>

