<?php


namespace app\modules\api\resources;


use app\modules\api\models\UserChannel;

/**
 * Class UserChannelResource
 *
 * @package app\modules\api\resources
 */
class UserChannelResource extends UserChannel
{
    public function fields()
    {
        return [
            'id',
            'channel_id',
            'user_id',
            'role'
        ];
    }

    /**
     * @return array|string[]
     */
    public function extraFields()
    {
        return ['channel'];
    }
}