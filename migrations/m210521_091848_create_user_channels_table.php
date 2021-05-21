<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_channels}}`.
 */
class m210521_091848_create_user_channels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_channels}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'channel_id' => $this->integer(),
            'role' => $this->string(64),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-user_channel-created_by}}',
            '{{%user_channels}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_channel-created_by}}',
            '{{%user_channels}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-user_channel-updated_by}}',
            '{{%user_channels}}',
            'updated_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_channel-updated_by}}',
            '{{%user_channels}}',
            'updated_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_channel-user_id}}',
            '{{%user_channels}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_channel-user_id}}',
            '{{%user_channels}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `channel_id`
        $this->createIndex(
            '{{%idx-user_channel-channel_id}}',
            '{{%user_channels}}',
            'channel_id'
        );

        // add foreign key for table `{{%channels}}`
        $this->addForeignKey(
            '{{%fk-user_channel-channel_id}}',
            '{{%user_channels}}',
            'channel_id',
            '{{%channels}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_channel-created_by}}',
            '{{%user_channels}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-user_channel-created_by}}',
            '{{%user_channels}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_channel-updated_by}}',
            '{{%user_channels}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-user_channel-updated_by}}',
            '{{%user_channels}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_channel-user_id}}',
            '{{%user_channels}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_channel-user_id}}',
            '{{%user_channels}}'
        );

        // drops foreign key for table `{{%channels}}`
        $this->dropForeignKey(
            '{{%fk-user_channel-channel_id}}',
            '{{%user_channels}}'
        );

        // drops index for column `channel_id`
        $this->dropIndex(
            '{{%idx-user_channel-channel_id}}',
            '{{%user_channels}}'
        );

        $this->dropTable('{{%user_channels}}');
    }
}
