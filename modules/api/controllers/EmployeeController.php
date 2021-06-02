<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Channel;
use app\modules\api\resources\ChannelResource;
use app\modules\api\resources\UserChannelResource;
use app\modules\api\resources\UserResource;
use app\rest\ActiveController;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;

class EmployeeController extends ActiveController
{
    public $modelClass = UserResource::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'only' => ['index', 'create', 'delete', 'update'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index', 'create', 'delete', 'update'],
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

    /**
     * @return UserResource[]
     */
    public function actionIndex()
    {
        return UserResource::find()->where(['<>', 'id', Yii::$app->user->id])->all();
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function actionActiveUsers($channelId)
    {
        return UserResource::findBySql("
            SELECT u2.* FROM users u2 LEFT JOIN (
                SELECT u.* FROM users u INNER JOIN user_channels uc on uc.user_id = u.id 
                WHERE uc.channel_id = :channelId) tmp ON tmp.id = u2.id
            WHERE tmp.id IS NULL", ['channelId' => $channelId])
            ->all();
    }

    /**
     * @return UserResource[]
     */
    public function actionGetChannels($userId)
    {
        return ChannelResource::findBySql("
            SELECT * FROM channels WHERE id NOT IN ( 
            SELECT channel_id FROM channels
            INNER JOIN user_channels uc ON channels.id = uc.channel_id WHERE user_id = :userId)",
            ['userId' => $userId])
            ->all();
    }
}