<?php

namespace app\modules\api\resources;

use app\modules\api\models\User;
use app\rest\ValidationException;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class UserResource
 *
 * @package app\modules\api\resources
 */
class UserResource extends User
{
    public $userChannelsData;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['userChannelsData'], 'safe']
        ]);
    }

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
            'position',
            'display_name' => function () {
                return $this->getDisplayName();
            },
            'image_url' => function () {
                return $this->getImageUrl();
            },
            'status' => function () {
                return $this->status === 1;
            },
            'activeStatus' => function () {
                return $this->status === 1;
            },
            'roles' => function () {
                $roles = Yii::$app->authManager->getRolesByUser($this->id);
                $roleNames = [];
                foreach ($roles as $key => $role) {
                    $roleNames [] = $key;
                }
                return $roleNames;
            },
        ];
    }

    /**
     * @return array|string[]
     */
    public function extraFields()
    {
        return ['userChannels'];
    }

    /**
     *
     *
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $parentSave = parent::save($runValidation, $attributeNames);
            if (!$parentSave) {
                $transaction->rollBack();
                return false;
            }
            if (isset($this->userChannelsData)) {
                $this->updateRoles($this->userChannelsData);
                $this->updateUserChannels($this->userChannelsData);
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $parentSave = false;
        }
        return $parentSave;
    }

    /**
     * Update user channels after update user
     *
     * @param $data
     * @throws ValidationException
     */
    public function updateUserChannels($userChannelsData)
    {
        $existedIds = ArrayHelper::getColumn($userChannelsData, 'id');
        $deletedIds = [];

        foreach ($this->userChannels as $userChanel) {
            if (!in_array($userChanel->id, $existedIds)) {
                $deletedIds[] = $userChanel->id;
            }
        }

        if ($deletedIds) {
            if (UserChannelResource::deleteAll(['id' => $deletedIds]) !== count($deletedIds)) {
                throw new ValidationException('Unable to delete channels');
            }
        }

        $indexById = ArrayHelper::index($this->userChannels, 'id');

        foreach ($userChannelsData as $userChannelData) {
            if (in_array($userChannelData['id'], $deletedIds)) {
                continue;
            }

            $userChannel = new UserChannelResource();
            if (isset($indexById[$userChannelData['id']])) {
                $userChannel = $indexById[$userChannelData['id']];
            }

            if (!$userChannel->load($userChannelData, '') || !$userChannel->save()) {
                throw new ValidationException('Unable to save channels');
            }
        }
    }

    /**
     * @throws Exception
     */
    public function updateRoles($data)
    {
        $auth = Yii::$app->authManager;
        $rolesToDelete = [];
        $rolesFromPost = [];
        $userRoles = array_keys(ArrayHelper::getColumn($auth->getRolesByUser($this->id), 'name'));

        // Convert roles from post to array of strings
        foreach ($data as $role) {
            $rolesFromPost[] = $role['role'];
        }

        // Check if some roles should be deleted
        foreach ($userRoles as $userRole) {
            if (!in_array($userRole, $rolesFromPost)) {
                $rolesToDelete[] = $userRole;
            }
        }

        // Delete roles
        foreach ($rolesToDelete as $roleToDelete) {
            $roleModel = $auth->getRole($roleToDelete);
            $auth->revoke($roleModel, $this->id);
        }

        // Create new role if such does not exist
        foreach ($rolesFromPost as $role) {
            if (!in_array($role, $userRoles)) {
                $roleModel = $auth->getRole($role);
                $auth->assign($roleModel, $this->id);
            }
        }
    }

    /**
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->image_path ? env('API_HOST') . $this->image_path : null;
    }
}