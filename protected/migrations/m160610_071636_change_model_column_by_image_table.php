<?php

class m160610_071636_change_model_column_by_image_table extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('image', 'model', 'string');
	}

	public function down()
	{
		echo "m160610_071636_change_model_column_by_image_table does not support migration down.\n";
		return true;
	}
}