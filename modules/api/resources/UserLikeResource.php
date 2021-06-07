<?php


namespace app\modules\api\resources;


use app\modules\api\models\UserLike;
use yii\db\ActiveQuery;

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


    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserResource::class, ['id' => 'created_by']);
    }
}