<?php

namespace app\modules\api\models\query;

use app\modules\api\models\UserChannel;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\app\modules\api\models\UserChannel]].
 *
 * @see \app\modules\api\models\UserChannel
 */
class UserChannelQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return UserChannel[]|array
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
     * @param $channelId
     * @return UserChannelQuery
     */
    public function byChannelId($channelId)
    {
        return $this->andWhere([UserChannel::tableName() . '.channel_id' => $channelId]);
    }

    /**
     * @param $userIds
     * @return UserChannelQuery
     */
    public function byUserIds($userIds)
    {
        return $this->andWhere(['IN', UserChannel::tableName() . '.user_id', $userIds]);
    }
}
