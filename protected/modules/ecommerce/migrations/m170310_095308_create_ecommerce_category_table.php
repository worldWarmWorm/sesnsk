<?php

class m170310_095308_create_ecommerce_category_table extends CDbMigration
{
	public function up()
	{
		$sql='CREATE TABLE `ecommerce_category` (
			`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`title` VARCHAR(255),
			`sef` VARCHAR(255),
			`published` TINYINT(1) NOT NULL DEFAULT 0,
			`root` INT(11),
			`lft` INT(11),
			`rgt` INT(11),
			`level`	INT(11),
			`update_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			KEY(`root`),	
			KEY(`lft`),	
			KEY(`rgt`),	
			KEY(`level`)	
		)';
	}

	public function down()
	{
		echo "m170310_095308_create_ecommerce_category_table does not support migration down.\n";
		return false;
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