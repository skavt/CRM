<?php


namespace app\modules\api\resources;


use app\modules\api\models\Channel;
use app\modules\api\models\UserChannel;
use app\rest\ValidationException;
use Yii;
use yii\db\ActiveQuery;

/**
 * Class ChannelResource
 *
 * @package app\modules\api\resources
 *
 * @property UserChannel $userChannels
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
        return [
            'createdBy', 'updatedBy',
            'permissions' => function () {
                $user = Yii::$app->user;
                if ($user->can('admin')) {
                    $permissions = Yii::$app->authManager->getPermissionsByRole('admin');
                } else {
                    $permissions = Yii::$app->authManager->getPermissionsByRole($this->userChannels->role);
                }
                return array_keys($permissions);
            }];
    }

    /**
     * Gets query for [[UserChannels]].
     *
     * @return ActiveQuery
     */
    public function getUserChannels()
    {
        return $this->hasOne(UserChannelResource::class, ['channel_id' => 'id'])
            ->andWhere(['user_id' => Yii::$app->user->id]);
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