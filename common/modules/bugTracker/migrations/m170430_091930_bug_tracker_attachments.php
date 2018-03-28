<?php

use yii\db\Migration;

class m170430_091930_bug_tracker_attachments extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%bugtracker_task_attachments}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'base_url' => $this->string(),
            'type' => $this->string(),
            'size' => $this->integer(),
            'name' => $this->string(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->addForeignKey('fk_bugtracker_task_attachments', '{{%bugtracker_task_attachments}}', 'task_id', '{{%bugtracker_task}}', 'task_id', 'cascade', 'cascade');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_bugtracker_task_attachments', '{{%bugtracker_task_attachments}}');

        $this->dropTable('{{%bugtracker_task_attachments}}');
    }
}
