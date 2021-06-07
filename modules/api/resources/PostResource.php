<?php


namespace app\modules\api\resources;


use app\modules\api\models\Post;

/**
 * Class PostResource
 *
 * @package app\modules\api\resources
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
        return ['createdBy', 'updatedBy'];
    }
}