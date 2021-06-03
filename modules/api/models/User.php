<?php

namespace app\modules\api\models;

use app\modules\api\models\query\UserQuery;
use Yii;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property int|null $birthday
 * @property string|null $position
 * @property string|null $image_path
 * @property string|null $password_reset_token
 * @property int|null $expire_date
 * @property string|null $access_token
 * @property int|null $access_token_expire_date
 * @property int|null $status
 *
 * @property UserChannel[] $userChannels
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_CHANNEL_ADMIN = 'channelAdmin';

    /**
     * Access Token is valid 1 day
     */
    const ACCESS_TOKEN_LIFETIME = 60 * 60 * 24;

    /**
     * Password reset link is valid 48 hours
     */
    const EXPIRE_DATE = 3600 * 48;

    public $image;
    public $imageRemoved;

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            [['birthday', 'expire_date', 'access_token_expire_date', 'status'], 'integer'],
            [['username', 'first_name', 'last_name', 'phone', 'position', 'image_path'], 'string', 'max' => 255],
            [['email', 'access_token'], 'string', 'max' => 512],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 1024],
            [['username'], 'unique'],
            [['email'], 'unique'],
            ['imageRemoved', 'boolean'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpeg, svg, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'birthday' => 'Birthday',
            'position' => 'Position',
            'image_path' => 'Image Path',
            'password_reset_token' => 'Password Reset Token',
            'expire_date' => 'Expire Date',
            'access_token' => 'Access Token',
            'access_token_expire_date' => 'Access Token Expire Date',
            'status' => 'Status',
        ];
    }

    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username)
    {
        return self::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generate Access Token
     *
     * @throws Exception
     */
    public function generateAccessToken()
    {
        if (!$this->access_token || $this->access_token_expire_date < time()) {
            $this->access_token = Yii::$app->security->generateRandomString(256);
            $this->access_token_expire_date = time() + self::ACCESS_TOKEN_LIFETIME;
        }
    }

    /**
     * Get user API data
     *
     * @return array
     */
    public function getApiData()
    {
        return $this->toArray(['id', 'username', 'email', 'access_token', 'status']);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token)
    {
        $user = static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);

        if (!$user || !$user->isPasswordResetTokenValid($user->expire_date)) {
            return null;
        }

        return $user;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param int $expireDate
     * @return bool
     */
    public function isPasswordResetTokenValid(int $expireDate)
    {
        return self::EXPIRE_DATE + $expireDate >= time();
    }

    /**
     * @return bool
     */
    public function isInactive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @param $role
     * @return bool
     */
    public static function isValidRole($role): bool
    {
        return in_array($role, [self::ROLE_ADMIN, self::ROLE_USER, self::ROLE_CHANNEL_ADMIN]);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserChannels()
    {
        return $this->hasMany(UserChannel::class, ['user_id' => 'id']);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->birthday = $this->birthday ? strtotime($this->birthday) : null;
        $oldPath = $this->image_path;

        if ($this->image) {
            $this->image_path = "/storage/user/" . Yii::$app->security->generateRandomString(25) . '/' . $this->image->name;

            // Delete old image if it exists
            if ($oldPath) {
                $oldPath = Yii::getAlias("@webroot" . $oldPath);
                if (file_exists($oldPath)) {
                    FileHelper::removeDirectory(dirname($oldPath));
                }
            }

            $path = Yii::getAlias("@webroot") . $this->image_path;
            if (!is_dir(dirname($path))) {
                FileHelper::createDirectory(dirname($path));
            }
            $this->image->saveAs($path, false);
        } else if ($this->imageRemoved && $oldPath) {
            $oldPath = Yii::getAlias("@webroot" . $oldPath);
            if (file_exists($oldPath)) {
                FileHelper::removeDirectory(dirname($oldPath));
            }
            $this->image_path = null;
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->birthday = $this->birthday ? date("Y-m-d", $this->birthday) : null;
    }
}
