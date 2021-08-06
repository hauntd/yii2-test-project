<?php

use yii\db\Migration;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 */
class m210806_034515_task_history extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->createTable('task_history', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex('task_idx', 'task_history', ['task_id']);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('task_history');

        return true;
    }
}
