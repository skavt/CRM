<?php


namespace app\modules\api\resources;


use app\modules\api\models\UserComment;
use yii\db\ActiveQuery;

/**
 * Class UserCommentResource
 *
 * @package app\modules\api\resources
 *
 * @property UserComment[] $childrenComments
 */
class UserCommentResource extends UserComment
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
        return ['createdBy', 'updatedBy', 'childrenComments', 'parent'];
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserResource::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[ChildrenComments]].
     *
     * @return ActiveQuery
     */
    public function getChildrenComments()
    {
        return $this->hasMany(UserCommentResource::class, ['parent_id' => 'id'])
            ->orderBy('created_at DESC');
    }
}