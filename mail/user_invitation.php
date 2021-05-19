<?php

use app\modules\api\models\Invitation;
use yii\helpers\Html;

/** @var Invitation $model */

$portalUrl = env('PORTAL_HOST');
$name = Yii::$app->name;
$inviterName = $model->createdBy->getDisplayName();
?>

<p><?php echo "Hello $model->email" ?></p>
<p>
    <?php echo "You were invited into $name by $inviterName" ?>
</p>
<p>
    <?php echo 'Click the link bellow to register' ?>
	<br>
    <?php echo Html::a(Html::encode('Registration Link'), "$portalUrl/register/$model->token") ?>
</p>



