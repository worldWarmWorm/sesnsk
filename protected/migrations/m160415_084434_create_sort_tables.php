<?php

class m160415_084434_create_sort_tables extends CDbMigration
{
	public function safeUp()
	{
		$this->execute('
			CREATE TABLE IF NOT EXISTS `sort_category` (
			`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`name` VARCHAR(32) NOT NULL,
			`key` INT(11),
			UNIQUE (`name`, `key`),
			INDEX (`name`)
		)');

		$this->execute('CREATE TABLE IF NOT EXISTS `sort_data` (
			`id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`category_id` INT(11) NOT NULL,
			`model_id` INT(11) NOT NULL,
			`order_number` INT(11) NOT NULL,
			`level` INT(11) DEFAULT 0,
			UNIQUE (`category_id`, `model_id`),
			KEY(`category_id`),
			FOREIGN KEY `category_id` (`category_id`) REFERENCES `sort_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		)');

	}
	
	public function safeDown()
	{
		echo "m160415_084434_create_sort_tables does not support migration down.\n";
		return true;
	}
}
