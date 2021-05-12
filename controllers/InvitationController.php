<?php


namespace app\controllers;

use app\helpers\MailHelper;
use app\resources\InvitationResource;
use app\rest\Controller;
use Yii;

/**
 * Class InvitationController
 *
 * @package app\controllers
 */
class InvitationController extends Controller
{

    /**
     * Create user invitation action
     *
     * @return InvitationResource|array|mixed|\yii\db\ActiveRecord
     * @throws \yii\db\Exception
     */
    public function actionInviteUser()
    {
        $request = yii::$app->request;
        $email = $request->post('email');

        $model = InvitationResource::find()
            ->byEmail($email)
            ->andWhere(['status' => InvitationResource::STATUS_PENDING])
            ->one();

        if ($model) {
            MailHelper::sendInvitation($model);

            return $model;
        }

        $transaction = Yii::$app->db->beginTransaction();

        $model = new InvitationResource();
        if ($model->load($request->post(), '') && $model->save()) {
            MailHelper::sendInvitation($model);

            $transaction->commit();
            return $this->response($model, 201);
        } elseif (!$model->hasErrors()) {
            return $this->validationError('Unable to send invitation');
        }

        return $model;
    }
}