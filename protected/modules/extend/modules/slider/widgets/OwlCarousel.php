<?php
/**
 * Виджет слайдера, используеющего плагин OwlCarousel.
 */
namespace extend\modules\slider\widgets;

use common\components\helpers\HYii as Y;
use common\components\helpers\HArray as A;
use common\components\helpers\HFile;

class OwlCarousel extends \extend\modules\slider\components\base\SliderWidget
{
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$options
	 */
	public $options=['default'];
	
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$cssFile
	 */
	public $cssFile=['owl.carousel.min.css', 'owl.theme.default.min.css'];	
	
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$defaultView
	 */
	public $defaultView='owl_default';
	
	/**
	 * (non-PHPdoc)
	 * @see CWidget::init()
	 */
	public function init()
	{
		parent::init();
		
		$cssFile=$this->cssFile;
		Y::publish([
			'path'=>HFile::path([__DIR__, 'assets', 'vendors','owlcarousel']),
			'js'=>$this->jsLoad ? 'owl.carousel.min.js' : '',
			'css'=>$cssFile ?: false
		]);
		
		$this->htmlOptions['class']=trim(A::get($this->htmlOptions, 'class', '') . ' owl-carousel');

		if($this->jsInit) {
			Y::js(
				$this->container, 
				'$("#'.$this->htmlOptions['id'].'").owlCarousel('.\CJavaScript::encode($this->options).');',
				\CClientScript::POS_READY
			);
		}
	}	
}