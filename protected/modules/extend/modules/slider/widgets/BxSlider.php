<?php
/**
 * Виджет слайдера, используеющего плагин BxSlider.
 */
namespace extend\modules\slider\widgets;

use common\components\helpers\HYii as Y;
use common\components\helpers\HFile;

class BxSlider extends \extend\modules\slider\components\base\SliderWidget
{
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$tagOptions
	 */
	public $tagOptions=['class'=>'bxslider'];
	
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$cssFile
	 */
	public $cssFile='css/jquery.bxslider.min.css';
	
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$options
	 */
	public $options=['default'];
	
	/**
	 * (non-PHPdoc)
	 * @see \extend\modules\slider\components\base\SliderWidget::$defaultView
	 */
	public $defaultView='bx_default';
	
	/**
	 * (non-PHPdoc)
	 * @see \CWidget::init()
	 */
	public function init()
	{
		parent::init();
		
		Y::publish([
			'path'=>HFile::path([__DIR__, 'assets', 'vendors','bxslider-4']),
			'js'=>$this->jsLoad ? 'js/jquery.bxslider.min.js' : '',
			'css'=>$this->cssFile ?: false
		]);

		if($this->jsInit) {
			Y::js(
				$this->container, 
				'$("#'.$this->htmlOptions['id'].'").bxSlider('.\CJavaScript::encode($this->options).');',
				\CClientScript::POS_READY
			);
		}
	}	
}