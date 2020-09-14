<?php
/**
 * Модуль Extend
 */
use common\components\base\WebModule;

class ExtendModule extends WebModule
{
	/**
	 * (non-PHPdoc)
	 * @see CModule::init()
	 */
	public function init()
	{
		parent::init();

		$this->setImport(array(
			'extend.models.*',
		));		
	}
}