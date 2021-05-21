<?php

namespace app\modules\api\models\query;

use app\modules\api\models\Channel;
use app\modules\api\models\UserChannel;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\app\modules\api\models\Channel]].
 *
 * @see \app\modules\api\models\Channel
 */
class ChannelQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Channel[]|array
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
     * @param $userId
     * @return ChannelQuery
     */
    public function byUserId($userId)
    {
        return $this->innerJoin(UserChannel::tableName() . ' uc', 'uc.channel_id = ' . Channel::tableName() . '.id')
            ->andWhere(['uc.user_id' => $userId]);
    }
}
