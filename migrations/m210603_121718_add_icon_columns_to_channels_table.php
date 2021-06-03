<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%channels}}`.
 */
class m210603_121718_add_icon_columns_to_channels_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%channels}}', 'icon', $this->string(255)->after('description'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%channels}}', 'icon');
    }
}
