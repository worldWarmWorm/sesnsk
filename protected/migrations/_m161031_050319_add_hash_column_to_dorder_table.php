<?php

class m161031_050319_add_hash_column_to_dorder_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('dorder', 'hash', 'string');
	}

	public function down()
	{
		echo "m161031_050319_add_hash_column_to_dorder_table does not support migration down.\n";
//		return false;
	}
}