<?php


namespace app\modules\api\controllers;

use app\helpers\MailHelper;
use app\modules\api\resources\InvitationResource;
use app\rest\Controller;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\filters\AccessControl;

/**
 * Class InvitationController
 *
 * @package app\controllers
 */
class InvitationController extends Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['update'], $actions['view']);

        return $actions;
    }

    /**
     * Create user invitation action
     *
     * @return InvitationResource|array|mixed|ActiveRecord
     * @throws Exception
     */
    public function actionCreate()
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
            return $this->validationError('Unable to send invitation.');
        }

        return $model;
    }

    public function actionInvitedUsers()
    {
        return InvitationResource::find()->all();
    }
}