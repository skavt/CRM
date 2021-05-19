<?php

namespace app\modules\api\models;


use app\helpers\MailHelper;
use app\rest\ValidationException;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * Class SignupForm
 *
 * @package app\models
 */
class SignupForm extends Model
{
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $password_repeat;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6],
            ['email', 'filter', 'filter' => 'trim'],
            [['email', 'first_name', 'last_name'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'Password' => 'Password',
        ];
    }

    /**
     * @param Invitation $invitation
     * @return User|null the saved model or null if saving fails
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function register(Invitation $invitation)
    {
        $dbTransaction = Yii::$app->db->beginTransaction();

        $user = new User();
        $user->username = $this->email;
        $user->email = $this->email;
        $user->status = User::STATUS_INACTIVE;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->setPassword($this->password);
        if (!$user->save()) {
            $dbTransaction->rollBack();
            throw new ValidationException("User was not saved for email $this->email");
        };

        // TODO Assign role to user

        $invitation->token_used_date = time();
        $invitation->user_id = $user->id;
        $invitation->status = Invitation::STATUS_REGISTERED;
        if (!$invitation->save()) {
            $dbTransaction->rollBack();
            throw new ValidationException("Invitation was not updated. Token: $invitation->token");
        }

        if (!MailHelper::acceptInvitation($invitation, $user)) {
            $dbTransaction->rollBack();
            throw new ValidationException('Unable to send email for inviter');
        }

        $dbTransaction->commit();
        return $user;
    }

}