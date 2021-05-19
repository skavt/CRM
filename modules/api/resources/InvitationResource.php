<?php


namespace app\modules\api\resources;


use app\modules\api\models\Invitation;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class InvitationResource
 *
 * @package app\resources
 */
class InvitationResource extends Invitation
{
    public function fields()
    {
        return array_merge(parent::fields(), [
            'created_at' => function () {
                return $this->created_at * 1000;
            },
            'token_used_date' => function () {
                return $this->token_used_date ? Yii::$app->formatter->asDatetime($this->token_used_date) : null;
            },
            'statusLabel' => function () {
                return $this->getStatusLabel();
            },
            'activeStatus' => function () {
                return $this->user ? $this->user->status === 1 : null;
            },
        ]);
    }

    /**
     * Extra fields with relation
     *
     * @return array|string[]
     */
    public function extraFields()
    {
        return ['createdBy', 'user'];
    }

    /**
     * @return []|UserResource[]|array|\string[][]
     * @throws Exception
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                'email', 'unique', 'targetClass' => UserResource::class,
                'when' => function ($model) {
                    /** @var $model self */
                    return $model->isNewRecord;
                },
                'message' => 'User with this email already exists.'
            ],
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(UserResource::class, ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserResource::class, ['id' => 'user_id']);
    }

    /**
     * Find invitation by valid token
     *
     * @param $token
     * @return ActiveRecord|array|null
     */
    public static function findByToken($token)
    {
        return static::find()
            ->byToken($token)
            ->notUsed()
            ->andWhere(['>', 'token_expire_date', time()])
            ->one();
    }

    /**
     * @return array
     */
    public function getStatusLabels()
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'Pending'),
            self::STATUS_REGISTERED => Yii::t('app', 'Registered'),
            self::STATUS_COMPLETED => Yii::t('app', 'Completed'),
        ];
    }

    /**
     * @return mixed
     */
    public function getStatusLabel()
    {
        return self::getStatusLabels()[$this->status];
    }
}