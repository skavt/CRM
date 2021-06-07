<?php


namespace app\modules\api\resources;


use app\modules\api\models\UserLike;

/**
 * Class UserLikeResource
 *
 * @package app\modules\api\resources
 */
class UserLikeResource extends UserLike
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'created_at' => function () {
                return $this->created_at * 1000;
            },
        ]);
    }

    /**
     * @return array|string[]
     */
    public function extraFields()
    {
        return ['createdBy'];
    }
}