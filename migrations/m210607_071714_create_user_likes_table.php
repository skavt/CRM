<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_likes}}`.
 */
class m210607_071714_create_user_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_likes}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-user_like-post_id}}',
            '{{%user_likes}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-user_like-post_id}}',
            '{{%user_likes}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-user_like-created_by}}',
            '{{%user_likes}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_like-created_by}}',
            '{{%user_likes}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-user_like-post_id}}',
            '{{%user_likes}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-user_like-post_id}}',
            '{{%user_likes}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_like-created_by}}',
            '{{%user_likes}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-user_like-created_by}}',
            '{{%user_likes}}'
        );

        $this->dropTable('{{%user_likes}}');
    }
}
