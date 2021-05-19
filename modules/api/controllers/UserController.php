<?php

namespace app\modules\api\controllers;

use app\helpers\MailHelper;
use app\modules\api\models\LoginForm;
use app\modules\api\models\SignupForm;
use app\modules\api\models\User;
use app\modules\api\resources\InvitationResource;
use app\modules\api\resources\UserResource;
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
    /**
     * @return array
     */
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
        $user = User::findByPasswordResetToken($token);
        if (!$user) {
            return $this->validationError('Password reset link is invalid, expired or used');
        }
        return $this->response($user->email);
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

        $user->password_reset_token = null;
        $user->expire_date = null;

        if (!$user->save()) {
            return $this->validationError('Unable to save password');
        }
    }


    /**
     *
     *
     * @return array
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function actionRegister()
    {
        $request = Yii::$app->request;

        $invitation = InvitationResource::findByToken($request->post('token'));
        if (!$invitation) {
            return $this->validationError('Registration link is invalid, expired or used');
        }

        $model = new SignupForm();
        if (!$model->load($request->post(), '') || !$model->validate()) {
            return $this->validationError($model->getFirstErrors());
        }

        $model->register($invitation);
    }
}