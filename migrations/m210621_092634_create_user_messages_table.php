<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_messages}}`.
 */
class m210621_092634_create_user_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_messages}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'unread_messages' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_message-user_id}}',
            '{{%user_messages}}',
            'user_id'
        );

        // add foreign key for table `{{%user_messages}}`
        $this->addForeignKey(
            '{{%fk-user_message-user_id}}',
            '{{%user_messages}}',
            'user_id',
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
        // drops foreign key for table `{{%user_messages}}`
        $this->dropForeignKey(
            '{{%fk-user_message-user_id}}',
            '{{%user_messages}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_message-user_id}}',
            '{{%user_messages}}'
        );

        $this->dropTable('{{%user_messages}}');
    }
}
