<?php

use yii\db\Migration;

/**
 * @author Alexander Kononenko <contact@hauntd.me>
 */
class m210806_034315_task extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'deadline_datetime' => $this->dateTime(),
            'description' => $this->text(),
            'user_id' => $this->integer(),
            'status' => $this->string(32)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('user_idx', 'task', ['user_id']);
        $this->createIndex('status_idx', 'task', ['status']);

        return true;
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->dropTable('task');

        return true;
    }
}
