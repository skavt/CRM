<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%users}}`.
 */
class m210603_121335_drop_columns_from_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'created_at');
        $this->dropColumn('{{%users}}', 'updated_at');
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users-created_by}}',
            '{{%users}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-users-created_by}}',
            '{{%users}}'
        );

        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-users-updated_by}}',
            '{{%users}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-users-updated_by}}',
            '{{%users}}'
        );
        $this->dropColumn('{{%users}}', 'created_by');
        $this->dropColumn('{{%users}}', 'updated_by');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%users}}', 'created_at', $this->integer());
        $this->addColumn('{{%users}}', 'created_by', $this->integer());
        $this->addColumn('{{%users}}', 'updated_at', $this->integer());
        $this->addColumn('{{%users}}', 'updated_by', $this->integer());
        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-users-created_by}}',
            '{{%users}}',
            'created_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users-created_by}}',
            '{{%users}}',
            'created_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-users-updated_by}}',
            '{{%users}}',
            'updated_by'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-users-updated_by}}',
            '{{%users}}',
            'updated_by',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }
}
