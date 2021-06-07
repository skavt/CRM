<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\UserLikeResource;
use app\rest\ActiveController;

/**
 * Class UserLikeController
 *
 * @package app\modules\api\controllers
 */
class UserLikeController extends ActiveController
{
    public $modelClass = UserLikeResource::class;
}