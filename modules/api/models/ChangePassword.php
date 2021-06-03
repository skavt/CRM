<?php

namespace app\modules\api\models;

use Yii;
use yii\base\Model;

/**
 * Class ChangePassword
 *
 * @package app\modules\api\models
 */
class ChangePassword extends Model
{
    public $old_password;
    public $password;
    public $confirm_password;

    /**
     * @var User
     */
    public $user;

    public function rules()
    {
        return [
            [['old_password', 'password', 'confirm_password'], 'required'],
            [
                'password',
                'match',
                'pattern' => '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$/',
                'message' => 'Should contain at least 1 lower case, 1 upper case, 1 digit and min length of 6'
            ],
            ['old_password', 'validatePassword'],
            ['password', 'compare', 'compareAttribute' => 'confirm_password']
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Password is incorrect');
            }
        }
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function changePassword()
    {
        $user = $this->getUser();
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        return $user->save();
    }
}