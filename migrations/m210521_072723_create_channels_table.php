<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%channels}}`.
 */
class m210521_072723_create_channels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%channels}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'image_path' => $this->string(1024),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-channel-created_by}}',
            '{{%channels}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-channel-created_by}}',
            '{{%channels}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-channel-updated_by}}',
            '{{%channels}}',
            'updated_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-channel-updated_by}}',
            '{{%channels}}',
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
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-channel-created_by}}',
            '{{%channels}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-channel-created_by}}',
            '{{%channels}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-channel-updated_by}}',
            '{{%channels}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-channel-updated_by}}',
            '{{%channels}}'
        );

        $this->dropTable('{{%channels}}');
    }
}
