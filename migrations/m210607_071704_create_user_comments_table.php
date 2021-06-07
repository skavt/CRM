<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_comments}}`.
 */
class m210607_071704_create_user_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_comments}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'post_id' => $this->integer(),
            'comment' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-user_comment-parent_id}}',
            '{{%user_comments}}',
            'parent_id'
        );

        // add foreign key for table `{{%user_comments}}`
        $this->addForeignKey(
            '{{%fk-user_comment-parent_id}}',
            '{{%user_comments}}',
            'parent_id',
            '{{%user_comments}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-user_comment-post_id}}',
            '{{%user_comments}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-user_comment-post_id}}',
            '{{%user_comments}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-user_comment-created_by}}',
            '{{%user_comments}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_comment-created_by}}',
            '{{%user_comments}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-user_comment-updated_by}}',
            '{{%user_comments}}',
            'updated_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-user_comment-updated_by}}',
            '{{%user_comments}}',
            'updated_by',
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
        // drops foreign key for table `{{%user_comments}}`
        $this->dropForeignKey(
            '{{%fk-user_comment-parent_id}}',
            '{{%user_comments}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-user_comment-parent_id}}',
            '{{%user_comments}}'
        );

        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-user_comment-post_id}}',
            '{{%user_comments}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-user_comment-post_id}}',
            '{{%user_comments}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_comment-created_by}}',
            '{{%user_comments}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-user_comment-created_by}}',
            '{{%user_comments}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-user_comment-updated_by}}',
            '{{%user_comments}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-user_comment-updated_by}}',
            '{{%user_comments}}'
        );

        $this->dropTable('{{%user_comments}}');
    }
}
