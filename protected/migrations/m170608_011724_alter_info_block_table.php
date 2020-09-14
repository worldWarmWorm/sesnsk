<?php

class m170608_011724_alter_info_block_table extends CDbMigration
{
	public function up()
	{
	    $this->addColumn('info_block', 'use_preview', 'TINYINT(1) NULL DEFAULT 1');
        $this->addColumn('info_block', 'use_description', 'TINYINT(1) NULL DEFAULT 1');
	}

	public function down()
    {
        $this->dropColumn('info_block', 'use_preview');
        $this->dropColumn('info_block', 'use_description');
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