<?php

use yii\db\Migration;

/**
 * Class m200904_114621_add_demo_users
 */
class m200904_114621_add_demo_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%users}}', [
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
            'first_name' => null,
            'last_name' => null,
            'phone' => null,
            'birthday' => null,
            'image_path' => null,
            'password_reset_token' => null,
            'expire_date' => null,
            'access_token' => null,
            'access_token_expire_date' => null,
            'status' => 1,
            'created_at' => time(),
            'created_by' => 1,
            'updated_at' => time(),
            'updated_by' => 1
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%users}}', ['id' => 1]);
    }

}
