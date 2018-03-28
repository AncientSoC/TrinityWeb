<?php

use yii\db\Migration;

class m170430_091929_bug_tracker_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%bugtracker_project}}', [
            'project_id'=>$this->primaryKey(),
            'created_at'=>$this->integer(),
            'name'=>$this->string(),
            'color'=>$this->string(6),
            'status'=>$this->integer(),
        ]);

        $this->createTable('{{%bugtracker_task}}', [
            'task_id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'closed_at' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
        ]);
        $this->createIndex('project', '{{%bugtracker_task}}', [
            'project_id',
            'status',
            'updated_at',
        ]);

        $this->createTable('{{%bugtracker_task_log}}', [
            'task_log_id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'param' => $this->string(15),
            'from' => $this->text(),
            'to' => $this->text(),
        ]);
        $this->createIndex('task', '{{%bugtracker_task_log}}', [
            'task_id',
            'created_at',
        ]);

        $this->createTable('{{%bugtracker_period}}', [
            'period_id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'start' => $this->integer(),
            'end' => $this->integer(),
            'length' => $this->integer(),
            'comment' => $this->string(),
        ]);
        $this->createIndex('task', '{{%bugtracker_period}}', [
            'task_id',
            'start',
        ]);
        
        $this->addForeignKey('fk_bugtracker_task_log_user_edit', '{{%bugtracker_task_log}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_bugtracker_task_author', '{{%bugtracker_task}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_bugtracker_project', '{{%bugtracker_task}}', 'project_id', '{{%bugtracker_project}}', 'project_id', 'cascade', 'cascade');
        $this->addForeignKey('fk_bugtracker_task_log', '{{%bugtracker_task_log}}', 'task_id', '{{%bugtracker_task}}', 'task_id', 'cascade', 'cascade');
        $this->addForeignKey('fk_bugtracker_period', '{{%bugtracker_period}}', 'task_id', '{{%bugtracker_task}}', 'task_id', 'cascade', 'cascade');
        
    }

    public function down()
    {
        
        $this->dropForeignKey('fk_bugtracker_task_log_user_edit', '{{%bugtracker_task_log}}');
        $this->dropForeignKey('fk_bugtracker_task_author', '{{%bugtracker_task}}');
        $this->dropForeignKey('fk_bugtracker_project', '{{%bugtracker_task}}');
        $this->dropForeignKey('fk_bugtracker_task_log', '{{%bugtracker_task_log}}');
        $this->dropForeignKey('fk_bugtracker_period', '{{%bugtracker_period}}');
        
        $this->dropTable('{{%bugtracker_project}}');
        $this->dropTable('{{%bugtracker_period}}');
        $this->dropTable('{{%bugtracker_task}}');
        $this->dropTable('{{%bugtracker_task_log}}');
    }
}
