<?php

class m160712_084224_create_brand_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('brand', [
			'id'=>'pk',
			'alias'=>'string',
			'title'=>'string',
			'logo'=>'string',
			'preview_text'=>'text',
			'detail_text'=>'text',
			'active'=>'boolean',
			'update_time'=>'TIMESTAMP'
		]);
	}

	public function down()
	{
		$this->dropTable('brand');
		return true;
	}
}
