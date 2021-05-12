<?php

namespace app\models\query;

use app\models\Invitation;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\app\models\Invitation]].
 *
 * @see \app\models\Invitation
 */
class InvitationQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Invitation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return array|ActiveRecord|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Find invitations by token
     *
     * @param $token
     * @return InvitationQuery
     */
    public function byToken($token)
    {
        return $this->andWhere([Invitation::tableName() . '.token' => $token]);
    }

    /**
     * Return not used invitation link
     *
     * @return InvitationQuery
     */
    public function notUsed()
    {
        return $this->andWhere([Invitation::tableName() . '.token_used_date' => null]);
    }

    /**
     * Find users by email
     *
     * @param $email
     * @return InvitationQuery
     */
    public function byEmail($email)
    {
        return $this->andWhere([Invitation::tableName() . '.email' => $email]);
    }
}
