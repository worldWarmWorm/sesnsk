<?php
/**
 * Модуль "Отзывы"
 *
 */
use common\components\base\WebModule;
use common\components\helpers\HYii as Y;

class ReviewsModule extends WebModule
{
	/**
	 * (non-PHPdoc)
	 * @see CModule::init()
	 */
	public function init()
	{
		Y::publish([
			'path'=>dirname(__FILE__) . Y::DS . 'assets', 
			'js'=>'js/kontur/reviews/classes/Reviews.js'
		]);
		
		// import the module-level models and components
		$this->setImport(array(
			'reviews.models.*',
			'reviews.components.*',
		));
	}
}
