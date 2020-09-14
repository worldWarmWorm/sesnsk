<?php

class m170609_052514_alter_file_tables extends CDbMigration
{
	public function up()
	{
	    $this->alterColumn('file', 'model', 'VARCHAR(255) NOT NULL');
	}

	public function down()
	{
        $this->alterColumn('file', 'model', 'VARCHAR(20) NOT NULL');
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