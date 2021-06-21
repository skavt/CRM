<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m210621_085334_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text(),
            'sender_id' => $this->integer()->notNull(),
            'receiver_id' => $this->integer(),
            'send_date' => $this->bigInteger(),
            'action' => $this->string(255),
            'action_user_id' => $this->integer(),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            '{{%idx-message-sender_id}}',
            '{{%messages}}',
            'sender_id'
        );

        // add foreign key for table `{{%messages}}`
        $this->addForeignKey(
            '{{%fk-message-sender_id}}',
            '{{%messages}}',
            'sender_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `receiver_id`
        $this->createIndex(
            '{{%idx-message-receiver_id}}',
            '{{%messages}}',
            'receiver_id'
        );

        // add foreign key for table `{{%messages}}`
        $this->addForeignKey(
            '{{%fk-message-receiver_id}}',
            '{{%messages}}',
            'receiver_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `action_user_id`
        $this->createIndex(
            '{{%idx-message-action_user_id}}',
            '{{%messages}}',
            'action_user_id'
        );

        // add foreign key for table `{{%messages}}`
        $this->addForeignKey(
            '{{%fk-message-action_user_id}}',
            '{{%messages}}',
            'action_user_id',
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
        // drops foreign key for table `{{%messages}}`
        $this->dropForeignKey(
            '{{%fk-message-sender_id}}',
            '{{%messages}}'
        );

        // drops index for column `sender_id`
        $this->dropIndex(
            '{{%idx-message-sender_id}}',
            '{{%messages}}'
        );

        // drops foreign key for table `{{%messages}}`
        $this->dropForeignKey(
            '{{%fk-message-receiver_id}}',
            '{{%messages}}'
        );

        // drops index for column `receiver_id`
        $this->dropIndex(
            '{{%idx-message-receiver_id}}',
            '{{%messages}}'
        );

        // drops foreign key for table `{{%messages}}`
        $this->dropForeignKey(
            '{{%fk-message-action_user_id}}',
            '{{%messages}}'
        );

        // drops index for column `action_user_id`
        $this->dropIndex(
            '{{%idx-message-action_user_id}}',
            '{{%messages}}'
        );

        $this->dropTable('{{%messages}}');
    }
}
