<?php

class m160414_054128_accordion_table extends CDbMigration
{
	public function up()
	{

		echo "create table: accordion\n";
		$this->createTable('accordion', array(
			'id'=>'pk',
			'title'=>'string',
		));

		echo "create table: accordion items\n";

		$this->createTable('accordion_items', array(
			'id'=>'pk',
			'title'=>'string',
			'description'=>'text',
			'accordion_id'=>'integer',
			'accordion_order'=>'integer DEFAULT 0',

		));
		
	}

	public function down()
	{
		echo "drop table: accordion\n";
		$this->dropTable('accordion');
		echo "drop table: accordion items\n";
		$this->dropTable('accordion_items');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}