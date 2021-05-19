<?php

use app\modules\api\models\Invitation;
use app\modules\api\models\User;

/**
 * @var Invitation $model
 * @var User $user
 */
?>

<p>
    <?php echo "Hello {$model->createdBy->email}" ?>
</p>
<p>
    <?php echo "The email: $model->email has accepted your invitation and joined to intranet." ?>
</p>
<p>
    <?php echo 'Now you can activate the user to be able to login.' ?>
</p>
