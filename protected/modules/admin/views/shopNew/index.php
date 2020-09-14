<?php $this->pageTitle = 'Препараты'.' - '. $this->appName; ?>
<?php
    $this->breadcrumbs=array(
    	'Препараты' => array('shopNew/index')
    );
?>
<div class="left">
  <h1><?='Препараты'?></h1>
</div>
<div class="right">
  <?php /* echo CHtml::link('Очистить кеш картинок  <i class="glyphicon glyphicon-warning-sign"></i>',
  	array('shopNew/clearImageCache'),
  	array('class'=>' btn btn-danger', 'title'=>'Обновить все картинки на сайте до первоначального вида')); ?>
  <?php echo CHtml::link('Настройки <i class="glyphicon glyphicon-cog"></i>', array('settings/index', 'id'=>'shop'), array('class'=>'btn btn-warning')); */ ?>

</div>
<div class="clr"></div>

<?php $this->renderPartial('_categories', compact('categories')); ?>
<? if(count($products) > 0): ?>
    <?php $this->renderPartial('_category_controls', ['categories'=>$categories, 'model'=>new \CategoryNew]); ?>
<? endif; ?>

<?php $this->renderPartial('_products', array(
    'productDataProvider'=>$productDataProvider, 
    'category'=>$model, 
    'modeRelatedHidden'=>$modeRelatedHidden,
)); ?>
