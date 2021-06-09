<?php


namespace app\modules\api\controllers;


use app\modules\api\models\Channel;
use app\modules\api\models\UserChannel;
use app\modules\api\resources\PostResource;
use app\rest\ActiveController;
use Yii;

/**
 * Class PostController
 *
 * @package app\modules\api\controllers
 */
class PostController extends ActiveController
{
    public $modelClass = PostResource::class;

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
        $channelId = Yii::$app->request->get('channel_id');
        return PostResource::find()
            ->alias('p')
            ->innerJoin(Channel::tableName() . ' c', 'c.id = p.channel_id')
            ->innerJoin(UserChannel::tableName() . ' uc', 'uc.channel_id = c.id')
            ->andWhere(['uc.user_id' => Yii::$app->user->id])
            ->andWhere(['p.channel_id' => $channelId])
            ->orderBy('created_at DESC')
            ->all();
    }
}