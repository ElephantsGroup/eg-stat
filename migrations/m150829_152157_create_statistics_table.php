<?php

use yii\db\Schema;
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

		$this->insert('{{%auth_item}}', [
			'name' => '/stat/admin/*',
			'type' => 2,
			'created_at' => 1467629406,
			'updated_at' => 1467629406
		]);
		$this->insert('{{%auth_item}}', [
			'name' => 'stat_management',
			'type' => 2,
			'created_at' => 1467629406,
			'updated_at' => 1467629406
		]);
		$this->insert('{{%auth_item_child}}', [
			'parent' => 'stat_management',
			'child' => '/stat/admin/*',
		]);
		$this->insert('{{%auth_item}}', [
			'name' => 'stat_manager',
			'type' => 1,
			'created_at' => 1467629406,
			'updated_at' => 1467629406
		]);
		$this->insert('{{%auth_item_child}}', [
			'parent' => 'stat_manager',
			'child' => 'stat_management',
		]);
		$this->insert('{{%auth_item_child}}', [
			'parent' => 'super_admin',
			'child' => 'stat_manager',
		]);
    }
    
    public function safeDown()
    {
		$this->delete('{{%auth_item_child}}', [
			'parent' => 'super_admin',
			'child' => 'stat_manager',
		]);
		$this->delete('{{%auth_item_child}}', [
			'parent' => 'stat_manager',
			'child' => 'stat_management',
		]);
		$this->delete('{{%auth_item}}', [
			'name' => 'stat_manager',
			'type' => 1,
		]);
		$this->delete('{{%auth_item_child}}', [
			'parent' => 'stat_management',
			'child' => '/stat/admin/*',
		]);
		$this->delete('{{%auth_item}}', [
			'name' => 'stat_management',
			'type' => 2,
		]);
		$this->delete('{{%auth_item}}', [
			'name' => '/stat/admin/*',
			'type' => 2,
		]);

		$this->dropTable('{{%eg_statistics}}');
    }
}
