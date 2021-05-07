<?php

namespace app\controllers;

use app\helpers\MailHelper;
use app\models\LoginForm;
use app\models\User;
use app\rest\Controller;
use Yii;
use yii\base\Exception;

/**
 * Class UserController
 *
 * @package app\controllers
 */
class UserController extends Controller
{

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $model = new LoginForm();

        if (!$model->load($request->post(), '') || !$model->validate() || !$model->login()) {
            return $this->validationError($model->getFirstErrors());
        }
        return $model->getActiveUser()->getApiData();
    }

    /**
     * Send email password reset link
     *
     * @return array
     * @throws Exception
     */
    public function actionSendPasswordResetLink()
    {
        $request = Yii::$app->request;
        $email = $request->post('email');

        $user = User::find()
            ->byEmail($email)
            ->one();

        if (!$user) {
            return $this->validationError('Unable to find user with this email');
        }

        if ($user->isInactive()) {
            return $this->validationError('User is disabled');
        }

        $user->password_reset_token = Yii::$app->security->generateRandomString(16);
        $user->expire_date = time();

        if (!$user->save()) {
            return $this->validationError('Unable to save user');
        }

        if (!MailHelper::sendResetPassword($user)) {
            return $this->validationError('Unable to send email');
        };
    }

    /**
     * Get password reset token and check validate
     *
     * @return array
     */
    public function actionCheckToken($token)
    {
        if (!User::findByPasswordResetToken($token)) {
            return $this->validationError('Password reset link is invalid or expired');
        }
    }

    /**
     * Reset password by token
     *
     * @return array
     * @throws Exception
     */
    public function actionResetPassword()
    {
        $request = Yii::$app->request;

        $token = $request->post('token');
        $user = User::findByPasswordResetToken($token);

        if (!$user) {
            return $this->validationError('Unable to find user');
        }

        $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($request->post('password'));

        if (!$user->save()) {
            return $this->validationError('Unable to save password');
        }
    }
}