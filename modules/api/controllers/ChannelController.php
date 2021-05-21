<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\ChannelResource;
use app\rest\ActiveController;
use Yii;
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
}