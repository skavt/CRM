<?php


namespace app\controllers;

use app\rest\Controller;
use yii\filters\AccessControl;

/**
 * Class InvitationController
 *
 * @package app\controllers
 */
class InvitationController extends Controller
{

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

    public function actionCreate()
    {
        return "Working";
    }
}