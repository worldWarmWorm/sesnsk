<?php
/**
 * Модуль
 */
use common\components\helpers\HYii as Y;
use common\components\base\WebModule;

class EcommerceModule extends WebModule
{
	/**
	 * (non-PHPdoc)
	 * @see CModule::init()
	 */
	public function init()
	{
		parent::init();
		
		// $this->assetsBaseUrl=Y::publish($this->getAssetsBasePath());

		$this->setImport(array(
			'ecommerce.models.*',
			'ecommerce.behaviors.*',
			'ecommerce.components.*',
		));		
	}
}