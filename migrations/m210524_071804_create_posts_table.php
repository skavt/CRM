<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m210524_071804_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'channel_id' => $this->integer(),
            'title' => $this->string(1024),
            'body' => $this->text(),
            'file_path' => $this->string(1024),
            'mime' => $this->string(255),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-post-created_by}}',
            '{{%posts}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-post-created_by}}',
            '{{%posts}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-post-updated_by}}',
            '{{%posts}}',
            'updated_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-post-updated_by}}',
            '{{%posts}}',
            'updated_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `channel_id`
        $this->createIndex(
            '{{%idx-post-channel_id}}',
            '{{%posts}}',
            'channel_id'
        );

        // add foreign key for table `{{%channels}}`
        $this->addForeignKey(
            '{{%fk-post-channel_id}}',
            '{{%posts}}',
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
            '{{%fk-post-created_by}}',
            '{{%posts}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-post-created_by}}',
            '{{%posts}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-post-updated_by}}',
            '{{%posts}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-post-updated_by}}',
            '{{%posts}}'
        );

        // drops foreign key for table `{{%channels}}`
        $this->dropForeignKey(
            '{{%fk-post-channel_id}}',
            '{{%posts}}'
        );

        // drops index for column `channel_id`
        $this->dropIndex(
            '{{%idx-post-channel_id}}',
            '{{%posts}}'
        );

        $this->dropTable('{{%posts}}');
    }
}
