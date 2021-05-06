<?php

namespace app\resources;

use app\models\User;
use Yii;

class UserResource extends User
{
    public function fields()
    {
        return array_merge(parent::fields(), [
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
        ]);
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}