<?php

namespace app\modules\api\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * Remember me during 30 day
     */
    const REMEMBER_ME_DURATION_TIME = 3600 * 24 * 30;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Username or email',
            'password' => 'Password',
            'rememberMe' => 'Remember Me',
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
            $user = $this->getActiveUser();

            if (User::find()->byEmail($this->email)->notActive()->one()) {
                $this->addError('password', 'Your account must be activated by admin');
            }

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $isLogin = Yii::$app->user->login($this->getActiveUser(), $this->rememberMe ? self::REMEMBER_ME_DURATION_TIME : 0);
        if (!$isLogin) {
            return false;
        }
        $user = Yii::$app->user->identity;
        $user->generateAccessToken();

        return $user->save();
    }

    /**
     * Finds active user by [[username]] or [[email]]
     *
     * @return User|null
     */
    public function getActiveUser()
    {
        if ($this->_user === false) {
            $this->_user = User::find()
                ->byEmail($this->email)
                ->active()
                ->one();
        }

        return $this->_user;
    }
}
