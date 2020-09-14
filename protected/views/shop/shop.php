<?
use settings\components\helpers\HSettings;
$settings=HSettings::getById('shop');

if(D::role('admin')) CmsHtml::editPricePlugin();?>
<h1><?=$settings->meta_h1 ?: D::cms('shop_title',Yii::t('shop','shop_title'))?></h1>

<div id="product-list-module">
	<?php 
		$this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_products', 
		    'sorterHeader'=>'Сортировка:',
		    'itemsTagName'=>'div',
		    'emptyText' => '',
		    'itemsCssClass'=>'product-list',
		    'sortableAttributes'=>array(
		        'title',
		        'price',
		    ),
		    'afterAjaxUpdate'=>'function(){shopItemCount();}',
		    'id'=>'ajaxListView',
		    'template'=>'{items}',
		    'ajaxUpdate'=>true,
		    'enableHistory' => true,
		));
	?>	
</div>

<?if($settings->main_text):?>
<div id="category-description" class="category-description"><?=$settings->main_text?></div>
<?endif?>
