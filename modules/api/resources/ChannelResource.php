<?php


namespace app\modules\api\resources;


use app\modules\api\models\Channel;
use app\rest\ValidationException;
use Yii;

/**
 * Class ChannelResource
 *
 * @package app\modules\api\resources
 */
class ChannelResource extends Channel
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

    /**
     * After save channel create new user channel
     *
     * @param bool $insert
     * @param array $changedAttributes
     * @throws ValidationException
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $userWorkspace = new UserChannelResource();
            $userWorkspace->channel_id = $this->id;
            $userWorkspace->user_id = Yii::$app->user->id;
            $userWorkspace->role = UserResource::ROLE_ADMIN;

            if (!$userWorkspace->save()) {
                throw new ValidationException('Unable to create user channel');
            }
        }
    }
}