<?php

class m170510_180129_create_order_customer_fields_table extends CDbMigration
{
	private function _tableName()
	{
		return 'order_customer_fields';
	}

	public function up()
	{
		$this->createTable($this->_tableName(), array(
			'id' => 'pk',
			'name' => 'varchar(25)',
			'label' => 'varchar(100)',
			'placeholder' => 'varchar(50)',
			'type' => 'varchar(25)',
			'required' => 'boolean DEFAULT 0',
			'sort' => 'tinyint(2)',
			'default_value' => 'varchar(255)',
			'values' => 'text',
			'mask' => 'varchar(50) NULL',
		));
		
		$this->insertMultiple($this->_tableName(),array(
			array('name'=>'name', 'label'=>'Ваше имя', 'type'=> 'text',	'required' => 1,'sort' =>1),
			array('name'=>'email', 'label'=>'E-mail', 'type'=> 'email',	'required' => 0,'sort' =>2),
			array('name'=>'phone', 'label'=>'Телефон', 'type'=> 'phone', 'required' => 1,'sort' =>3),
			array('name'=>'address', 'label'=>'Адрес доставки', 'type'=> 'textarea', 'required' => 0,'sort' =>4),
			array('name'=>'comment', 'label'=>'Комментарий к заказу', 'type'=> 'textarea', 'required' => 0,'sort' =>5),			
		));
		
	}

	public function down()
	{
		$this->dropTable($this->_tableName());
		return true;
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