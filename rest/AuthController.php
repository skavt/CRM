<?php

namespace app\rest;

use Yii;
use yii\filters\Cors;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        return $behaviors;
    }

    /**
     * @param $message
     * @param $statusCode
     * @return array
     */
    public function validationError($message, $statusCode = 422)
    {
        return $this->response($message, $statusCode);
    }

    /**
     * @param     $data
     * @param int $statusCode
     * @return mixed
     */
    public function response($data, $statusCode = 200)
    {
        Yii::$app->response->statusCode = $statusCode;
        return $data;
    }
}