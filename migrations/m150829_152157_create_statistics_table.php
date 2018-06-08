<?php

use yii\db\Migration;

class m150829_152157_create_statistics_table extends Migration
{
    public function safeUp()
    {
		$this->createTable('{{%eg_statistics}}',[
			'id' => $this->primaryKey(),
			'module' => $this->string(32)->notNull(),
			'controller' => $this->string(32)->notNull(),
			'action' => $this->string(32)->notNull(),
			'ip' => $this->string(32)->notNull(),
			'user_id' => $this->integer(11),
			'item_id' => $this->integer(11),
			'status' => $this->smallInteger()->notNull()->defaultValue(0),
			'creation_time' => $this->timestamp()->notNull(),
		]);
    }
    
    public function safeDown()
    {
		$this->dropTable('{{%eg_statistics}}');
    }
}
