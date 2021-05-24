<?php

namespace app\modules\api\models\query;

use app\modules\api\models\Post;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the ActiveQuery class for [[\app\modules\api\models\Post]].
 *
 * @see \app\modules\api\models\Post
 */
class PostQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Post[]|array
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
