<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m210607_084044_add_action_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%posts}}', 'action', $this->string(255)->after('body'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%posts}}', 'action');
    }
}
