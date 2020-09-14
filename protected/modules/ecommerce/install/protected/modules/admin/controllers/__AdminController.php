<?php
Yii::setPathOfAlias('ecommerce', Yii::getPathOfAlias('application.modules.ecommerce'));
Yii::import('ecommerce.EcommerceModule');

class EcommerceController extends \ecommerce\modules\admin\controllers\DefaultController
{	
}