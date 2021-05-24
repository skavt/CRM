<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\ChannelResource;
use app\modules\api\resources\UserChannelResource;
use app\modules\api\resources\UserResource;
use app\rest\ActiveController;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;

/**
 * Class ChannelController
 *
 * @package app\modules\api\controllers
 */
class ChannelController extends ActiveController
{
    public $modelClass = ChannelResource::class;

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

        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);

        return $actions;
    }

    public function actionIndex()
    {
        return ChannelResource::find()->byUserId(Yii::$app->user->id)->all();
    }

    /**
     * @return array|mixed
     * @throws Exception
     */
    public function actionAddNewUsers()
    {
        $request = Yii::$app->request;

        $userIds = $request->post('selectedUsers');
        $channelId = $request->post('channel_id');
        $role = $request->post('role');

        if (!$userIds) {
            return $this->validationError('Please select users');
        }

        if (!UserResource::isValidRole($role)) {
            return $this->validationError('Invalid role');
        }

        $userChannelIds = UserChannelResource::find()
            ->select(UserChannelResource::tableName() . '.user_id')
            ->byChannelId($channelId)
            ->byUserIds($userIds)
            ->column();

        $userData = [];

        foreach ($userIds as $userId) {
            if (!in_array($userId, $userChannelIds)) {
                $userData [] = [
                    'user_id' => $userId,
                    'channel_id' => $channelId,
                    'role' => $role,
                    'created_at' => time(),
                    'updated_at' => time(),
                    'created_by' => Yii::$app->user->id,
                    'updated_by' => Yii::$app->user->id,
                ];
            }
        }
        if (!$userData) {
            return $this->response(null, 200);
        }

        $dbTransaction = Yii::$app->db->beginTransaction();
        $createdData = Yii::$app->db->createCommand()
            ->batchInsert
            (
                UserChannelResource::tableName(),
                ['user_id', 'channel_id', 'role', 'created_at', 'updated_at', 'created_by', 'updated_by'],
                $userData
            )
            ->execute();

        if ($createdData !== count($userData)) {
            $dbTransaction->rollBack();
            return $this->validationError('Unable to add user(s)');
        }

        $dbTransaction->commit();
        return $this->response(null, 201);
    }
}