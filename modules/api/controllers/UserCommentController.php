<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\UserCommentResource;
use app\rest\ActiveController;

/**
 * Class UserCommentController
 *
 * @package app\modules\api\controllers
 */
class UserCommentController extends ActiveController
{
    public $modelClass = UserCommentResource::class;
}