<?php
/**
 * Ajax-действие добавления отзыва
 * 
 */
namespace reviews\actions;

use reviews\models\Review;
use common\components\helpers\HAjax;
use common\components\helpers\HDb;

class AjaxAddReview extends \CAction
{
	public function run()
	{
		$model=new Review('frontend_insert');
		
		if(HDb::massiveAssignment($model)) {
			HAjax::end($model->save(), ['message'=>''], $model->getErrors());
		}
		
		HAjax::end(false);
	}
}