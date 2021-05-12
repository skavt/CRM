<?php

namespace app\rest;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\Cors;

class Controller extends AuthController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        $behaviors['cors'] = [
            'class' => Cors::class
        ];
        $auth['except'] = ['options'];
        $auth['authMethods'] = [
            HttpBearerAuth::class,
            QueryParamAuth::class,
        ];

        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }
}