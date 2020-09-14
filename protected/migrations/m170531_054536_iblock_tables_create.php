<?php

class m170531_054536_iblock_tables_create extends CDbMigration
{
    public function safeUp()
    {
        $this->createTable('info_block', array(
                'id' => 'pk',
                'title' => 'VARCHAR(255) NOT NULL',
                'code' => 'VARCHAR(255) NULL DEFAULT NULL',
                'sort' => 'INT(11) NOT NULL DEFAULT 500',
                'active' => 'TINYINT(1) NULL DEFAULT 1',
            )
        );
        $this->createIndex('uniq', 'info_block', 'title', true);

        $this->createTable('info_block_prop', array(
                'id' => 'pk',
                'title' => 'VARCHAR(255) NOT NULL',
                'active' => 'TINYINT(1) NULL DEFAULT 1',
                'type' => 'CHAR(1) NOT NULL',
                'multiple' => 'TINYINT(1) NULL',
                'code' => 'VARCHAR(255) NOT NULL',
                'sort' => 'INT(11) NOT NULL DEFAULT 500',
                'info_block_id' => 'INT NOT NULL',
                'default' => 'VARCHAR(255) NULL',
                'options' => 'TEXT NOT NULL',
                'required' => 'TINYINT(1) NULL',
            )
        );
        $this->createIndex('uniq', 'info_block_prop', array('info_block_id', 'code'), true);

        $this->createTable('info_block_prop_value', array(
                'id' => 'pk',
                'prop_id' => 'INT(11) NOT NULL',
                'value_key' => 'VARCHAR(255) NOT NULL',
                'value_text' => 'VARCHAR(255) NOT NULL',
            )
        );
        $this->createIndex('uniq', 'info_block_prop_value', array('prop_id', 'value_key'), true);

        $this->createTable('info_block_element', array(
                'id' => 'pk',
                'code' => 'VARCHAR(255) NULL DEFAULT NULL',
                'active' => 'TINYINT(1) NULL DEFAULT 1',
                'title' => 'VARCHAR(255) NOT NULL',
                'preview' => 'VARCHAR(255) NULL',
                'description' => 'TEXT NULL',
                'created_at' => 'TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP',
                'updated_at' => 'TIMESTAMP NULL DEFAULT NULL',
                'sort' => 'INT(11) NOT NULL DEFAULT 500',
                'info_block_id' => 'INT(11) NOT NULL',
            )
        );

        $this->createTable('info_block_element_prop', array(
                'id' => 'pk',
                'element_id' => 'INT(11) NOT NULL',
                'prop_id' => 'INT(11) NOT NULL',
                'value' => 'TEXT NOT NULL',
            )
        );

        $this->addForeignKey(
            'block_property',
            'info_block_prop',
            'info_block_id',
            'info_block',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'block_element',
            'info_block_element',
            'info_block_id',
            'info_block',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'element_property_property',
            'info_block_element_prop',
            'prop_id',
            'info_block_prop',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'element_property_element',
            'info_block_element_prop',
            'element_id',
            'info_block_element',
            'id',
            'CASCADE',
            'CASCADE'
        );


    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'block_property',
            'info_block_prop'
        );

        $this->dropForeignKey(
            'block_element',
            'info_block_element'
        );

        $this->dropForeignKey(
            'element_property_property',
            'info_block_element_prop'
        );

        $this->dropForeignKey(
            'element_property_element',
            'info_block_element_prop'
        );

        $this->dropTable('info_block');
        $this->dropTable('info_block_prop');
        $this->dropTable('info_block_element');
        $this->dropTable('info_block_element_prop');
        $this->dropTable('info_block_prop_value');

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