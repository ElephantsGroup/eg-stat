<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Class m180608_024814_add_stat_management
 */
class m180608_024814_add_stat_management extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$db = \Yii::$app->db;
		$query = new Query();
        if ($db->schema->getTableSchema("{{%auth_item}}", true) !== null)
		{
			if (!$query->from('{{%auth_item}}')->where(['name' => '/stat/admin/*'])->exists())
				$this->insert('{{%auth_item}}', [
					'name'			=> '/stat/admin/*',
					'type'			=> 2,
					'created_at'	=> time(),
					'updated_at'	=> time()
				]);
			if (!$query->from('{{%auth_item}}')->where(['name' => 'stat_management'])->exists())
				$this->insert('{{%auth_item}}', [
					'name'			=> 'stat_management',
					'type'			=> 2,
					'created_at'	=> time(),
					'updated_at'	=> time()
				]);
			if (!$query->from('{{%auth_item}}')->where(['name' => 'stat_manager'])->exists())
				$this->insert('{{%auth_item}}', [
					'name'			=> 'stat_manager',
					'type'			=> 1,
					'created_at'	=> time(),
					'updated_at'	=> time()
				]);
			if (!$query->from('{{%auth_item}}')->where(['name' => 'administrator'])->exists())
				$this->insert('{{%auth_item}}', [
					'name'			=> 'administrator',
					'type'			=> 1,
					'created_at'	=> time(),
					'updated_at'	=> time()
				]);
		}
        if ($db->schema->getTableSchema("{{%auth_item_child}}", true) !== null)
		{
			if (!$query->from('{{%auth_item_child}}')->where(['parent' => 'stat_management', 'child' => '/stat/admin/*'])->exists())
				$this->insert('{{%auth_item_child}}', [
					'parent'	=> 'stat_management',
					'child'		=> '/stat/admin/*'
				]);
			if (!$query->from('{{%auth_item_child}}')->where(['parent' => 'stat_manager', 'child' => 'stat_management'])->exists())
				$this->insert('{{%auth_item_child}}', [
					'parent'	=> 'stat_manager',
					'child'		=> 'stat_management'
				]);
			if (!$query->from('{{%auth_item_child}}')->where(['parent' => 'administrator', 'child' => 'stat_manager'])->exists())
				$this->insert('{{%auth_item_child}}', [
					'parent'	=> 'administrator',
					'child'		=> 'stat_manager'
				]);
		}
        if ($db->schema->getTableSchema("{{%auth_assignment}}", true) !== null)
		{
			if (!$query->from('{{%auth_assignment}}')->where(['item_name' => 'administrator', 'user_id' => 1])->exists())
				$this->insert('{{%auth_assignment}}', [
					'item_name'	=> 'administrator',
					'user_id'	=> 1,
					'created_at' => time()
				]);
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		// it's not safe to remove auth data in migration down
    }
}
