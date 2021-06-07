<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\PostResource;
use app\rest\ActiveController;

/**
 * Class PostController
 *
 * @package app\modules\api\controllers
 */
class PostController extends ActiveController
{
    public $modelClass = PostResource::class;
}