<?php

namespace app\modules\api\resources;

use app\modules\api\models\User;
use Yii;

/**
 * Class UserResource
 *
 * @package app\modules\api\resources
 */
class UserResource extends User
{
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'first_name',
            'last_name',
            'phone',
            'birthday',
            'display_name' => function () {
                return $this->getDisplayName();
            },
            'status' => function () {
                return $this->status === 1;
            },
            'created_at' => function () {
                return Yii::$app->formatter->asDatetime($this->created_at);
            },
            'updated_at' => function () {
                return Yii::$app->formatter->asDatetime($this->updated_at);
            },
            'activeStatus' => function () {
                return $this->status === 1;
            },
        ];
    }
}