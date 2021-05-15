<?php

namespace app\modules\api\models\query;

use app\modules\api\models\User;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\modules\api\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Return active users
     *
     * @return mixed
     */
    public function active()
    {
        return $this->andWhere([User::tableName() . '.status' => User::STATUS_ACTIVE]);
    }

    /**
     * Return non active users
     *
     * @return self
     */
    public function notActive()
    {
        return $this->andWhere([User::tableName() . '.status' => User::STATUS_INACTIVE]);
    }

    /**
     * Find users by email
     *
     * @param $email
     * @return UserQuery
     */
    public function byEmail($email)
    {
        return $this->andWhere([User::tableName() . '.email' => $email]);
    }
}
