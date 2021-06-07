<?php


namespace app\modules\api\resources;


use app\modules\api\models\Post;
use app\modules\api\models\UserLike;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class PostResource
 *
 * @package app\modules\api\resources
 *
 * @property UserLike[] $myLikes
 * @property UserLike[] $userLikes
 */
class PostResource extends Post
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'created_at' => function () {
                return $this->created_at * 1000;
            },
            'updated_at' => function () {
                return $this->updated_at * 1000;
            },
        ]);
    }

    /**
     * @return array|string[]
     */
    public function extraFields()
    {
        return ['createdBy', 'updatedBy', 'myLikes', 'userLikes'];
    }

    /**
     * Gets query for [[UserLikes]].
     *
     * @return ActiveQuery
     */
    public function getUserLikes()
    {
        return $this->hasMany(UserLikeResource::class, ['post_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMyLikes()
    {
        return $this->hasMany(UserLikeResource::class, ['post_id' => 'id'])
            ->andWhere(['created_by' => Yii::$app->user->id]);
    }
}