<?php

namespace app\models;

use app\models\query\InvitationQuery;
use Yii;
use yii\base\Exception;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%invitations}}".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property int|null $status
 * @property string $token
 * @property int|null $token_expire_date
 * @property int|null $token_used_date
 * @property int|null $created_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property User $user
 */
class Invitation extends ActiveRecord
{
    const STATUS_REGISTERED = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLETED = 3;

    /**
     * Invitation token is valid 30 days
     */
    const TOKEN_LIFETIME = 3600 * 30 * 24;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%invitations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],

            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false,
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'token_expire_date', 'token_used_date', 'created_at', 'created_by'], 'integer'],
            [['email'], 'required'],
            [['email'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 1024],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['token', 'default', 'value' => Yii::$app->security->generateRandomString(16)],
            ['token_expire_date', 'default', 'value' => time() + self::TOKEN_LIFETIME],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'status' => 'Status',
            'token' => 'Token',
            'token_expire_date' => 'Token Expire Date',
            'token_used_date' => 'Token Used Date',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return InvitationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvitationQuery(get_called_class());
    }
}
