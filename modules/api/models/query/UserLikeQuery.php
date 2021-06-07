<?php

namespace app\modules\api\models\query;

use app\modules\api\models\UserLike;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\app\modules\api\models\UserLike]].
 *
 * @see \app\modules\api\models\UserLike
 */
class UserLikeQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return UserLike[]|array
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
}
