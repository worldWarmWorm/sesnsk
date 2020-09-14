<?php

/**
 * @var ShopController $this 
 */

$this->breadcrumbs = array(
	'Препараты' => array('shopNew/index'),
	'Сортировка категорий' => array('shopNew/categorySort')
);

$id=uniqid('cs');
YiiHelper::csjs("btn{$id}", '$("#btn'.$id.'").on("click", function(e) {
	e.preventDefault();
	$.post("'.$this->createUrl('shopNew/categorySort').'", {data:JSON.stringify(NestableWidget.getNestedSet("'.$id.'"))}, function(data) {
		$("#flash'.$id.'").html(data.success ? "Изменения успешно сохранены." : "Произошла ошибка на сервер. Изменения не были сохранены.");
		$("#flash'.$id.'")
			.removeClass(data.success?"error":"success")
			.addClass(data.success?"success":"error")
			.fadeIn().delay(5000).fadeOut();
	}, "json");	
	return false;
});', CClientScript::POS_READY); 
?>
<h1><?=$this->pageTitle?></h1>
<?$this->widget('admin.widget.Nestable.NestedSetWidget', array(
	'id'=>$id,
	'model'=>'CategoryNew',
	'attributeId'=>'id',
	'attributeTitle'=>'title',
	'skinDd3'=>false,
	'modelBaseUrl'=>'/cp/shopNew/categoryUpdate',
	'modelUrlText'=>'Редактировать',
));
?>
<?=CHtml::linkButton('Сохранить изменения', array('class'=>'btn btn-primary', 'id'=>"btn{$id}"));?>&nbsp;
<?=HtmlHelper::linkBack('Назад', '/cp/shopNew/index', '/cp/shop', ['class'=>'btn btn-default'])?>

<div style="display:inline-table"><div class="flash inline" id="flash<?=$id?>"></div></div>
