<?php

class m160220_085811_add_view_template_column_to_page_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('page', 'view_template', 'string');
	}

	public function down()
	{
		$this->dropColumn('page', 'view_template');
	}
}