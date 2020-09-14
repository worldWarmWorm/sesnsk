<?php
/**
 * Виджет формы добавления нового отзыва
 * 
 */
namespace reviews\widgets;

use reviews\models\Review;
use common\components\helpers\HYii as Y;

class NewReviewForm extends \CWidget
{
	/**
	 * @var string ссылка на действие добавления
	 */
	public $actionUrl;
	
	/**
	 * @var boolean режим всплывающего окна
	 */
	public $popup=true;
	
	/**
	 * (non-PHPdoc)
	 * @see \CWidget::init()
	 */
	public function init()
	{
		\common\widgets\fancybox\Fancybox::publish();
		
		Y::publish([
			'path'=>dirname(__FILE__) . Y::DS . 'assets' . Y::DS . 'new_review_form',
			'js'=>'js/NewReviewFormWidget.js',
			'css'=>'css/styles.css'
		]);
		
		$t=Y::ct('ReviewsModule.widgets/new_review_form', 'reviews');
		Y::js(
			'reviews_widgets_NewReviewForm_Langs', 
			';Kontur.Lang.register("reviews_langs", {'
			. '"w_nrf_mgs_success": "'.$t('msg.success').'",' 
			. '"w_nrf_mgs_error": "'.$t('msg.error').'",'
			. '"w_nrf_mgs_error_max_try": "'.$t('msg.error.maxTry').'"});', 
			\CClientScript::POS_READY
		);
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \CWidget::run()
	 */
	public function run()
	{
		$model=new Review('frontend_insert');
		
		$this->render('new_review_form', compact('model'));
	}
}
