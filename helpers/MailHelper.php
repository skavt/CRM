<?php

namespace app\helpers;

use app\modules\api\models\Invitation;
use app\modules\api\models\User;
use Yii;
use yii\mail\MessageInterface;

/**
 * Class MailHelper
 *
 * @package app\helpers
 */
class MailHelper
{
    /**
     * @param MessageInterface $message
     * @return bool
     */
    private static function sendMail(MessageInterface $message)
    {
        $message->setFrom([env('EMAIL_FROM') => Yii::$app->name]);
        if (env('EMAIL_CC')) {
            $message->setCc(env('EMAIL_CC'));
        }
        if (env('EMAIL_BCC')) {
            $message->setBcc(env('EMAIL_BCC'));
        }

        return $message->send();
    }

    /**
     * Send mail user about reset password
     *
     * @param $user
     * @return bool
     */
    public static function sendResetPassword($user)
    {
        $message = Yii::$app->mailer->compose('reset_password', ['user' => $user])
            ->setSubject('Your new password')
            ->setTo($user->email);

        return self::sendMail($message);
    }

    /**
     * @param $invitation
     * @return bool
     */
    public static function sendInvitation($invitation)
    {
        $name = Yii::$app->name;
        $message = Yii::$app->mailer->compose('user_invitation', ['model' => $invitation])
            ->setSubject("You are invited to $name")
            ->setTo($invitation->email);

        return self::sendMail($message);
    }

    /**
     *
     *
     * @param Invitation $invitation
     * @param User $user
     * @return bool
     */
    public static function acceptInvitation(Invitation $invitation, User $user)
    {
        $name = Yii::$app->name;
        $message = Yii::$app->mailer->compose('invitation_accepted', [
            'model' => $invitation,
            'user' => $user
        ])
            ->setSubject("Your invitation to join to $name was accepted")
            ->setTo($invitation->createdBy->email);

        return self::sendMail($message);
    }
}