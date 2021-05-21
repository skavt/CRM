<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\ChannelResource;
use app\rest\ActiveController;

/**
 * Class ChannelController
 *
 * @package app\modules\api\controllers
 */
class ChannelController extends ActiveController
{
    public $modelClass = ChannelResource::class;
}