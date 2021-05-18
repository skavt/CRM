<?php


namespace app\modules\api\controllers;

use app\helpers\MailHelper;
use app\modules\api\resources\InvitationResource;
use app\rest\ActiveController;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\filters\AccessControl;

/**
 * Class InvitationController
 *
 * @package app\controllers
 */
class InvitationController extends ActiveController
{
    public $modelClass = InvitationResource::class;

    /**
     * {@inheritDoc}
     *
     * @return array|array[]
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'create', 'delete'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'delete'],
                    //TODO roles
                ]
            ]
        ];
        $behaviors['authenticator']['except'][] = 'check-invitation-token';

        return $behaviors;
    }

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

    /**
     * Get invited user's email by token
     *
     * @param $token
     * @return mixed|null
     */
    public function actionCheckInvitationToken($token)
    {
        $invitation = InvitationResource::findByToken($token);
        if (!$invitation) {
            return $this->validationError('Invitation token is invalid, expired or used');
        }

        return $this->response($invitation->email);
    }
}