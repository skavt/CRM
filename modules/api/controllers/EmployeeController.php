<?php


namespace app\modules\api\controllers;


use app\modules\api\resources\UserResource;
use app\rest\ActiveController;

class EmployeeController extends ActiveController
{
    public $modelClass = UserResource::class;
}