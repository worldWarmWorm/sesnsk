<?php
/**
 *@var Product $model
 */
?>
    <div class="row">
        <?php echo $form->checkBox($model, 'hidden'); ?>
        <?php echo $form->labelEx($model, 'hidden', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'hidden'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
        <?php echo $form->dropDownList($model, 'category_id', \CategoryNew::model()->getCategories(), array('class'=>'form-control')); ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textArea($model, 'title', array('class'=>'form-control', 'style'=>'min-height:50px;')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
       <?$this->widget('admin.widget.Alias.AliasFieldWidget', compact('form', 'model'))?>
	   <div class="inline"><?=\CHtml::link('посмотреть на сайте', ['/shopNew/product', 'id'=>$model->id], ['target'=>'_blank'])?></div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('class'=>'form-control')); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

	<? if(D::cmsIs('shop_enable_brand')): ?>
    <div class="row">
        <?php echo $form->labelEx($model, 'brand_id'); ?>
        <?php echo $form->dropDownList($model, 'brand_id', Brand::getListData(true), array('class'=>'form-control w50', 'empty'=>'Не указан')); ?>
        <?php echo $form->error($model, 'brand_id'); ?>
    </div>
    <?php endif; ?>


    <div class="row">
    	<div class="col-md-4" style="padding-left:0;">
	        <?php echo $form->labelEx($model, 'price'); ?>
	        <?php echo $form->textField($model, 'price', array('class'=>'inline form-control')); ?> руб.
	        <?php echo $form->error($model, 'price'); ?>
    	</div>
        <? if(D::cms('shop_enable_old_price')): ?>
    	<div class="col-md-4">
        	<?php echo $form->labelEx($model, 'old_price'); ?>
        	<?php echo $form->textField($model, 'old_price', array('class'=>'inline form-control')); ?> руб.
        	<?php echo $form->error($model, 'old_price'); ?>
    	</div>
        <? endif; ?>
    </div>
    
    <div class="row">
        <?php echo $form->checkBox($model, 'notexist'); ?>
        <?php echo $form->labelEx($model, 'notexist', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'notexist'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model, 'new'); ?>
        <?php echo $form->labelEx($model, 'new', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'new'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model, 'sale'); ?>
        <?php echo $form->labelEx($model, 'sale', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'sale'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model, 'hit'); ?>
        <?php echo $form->labelEx($model, 'hit', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'hit'); ?>
    </div>

    <? /*if(D::cms('shop_enable_carousel')==1): ?>
    <div class="row">
        <?php echo $form->checkBox($model, 'in_carousel'); ?>
        <?php echo $form->labelEx($model, 'in_carousel', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'in_carousel'); ?>
    </div>
    <? endif;*/ ?>
    
    <div class="row">
        <?php echo $form->checkBox($model, 'on_shop_index'); ?>
        <?php echo $form->labelEx($model, 'on_shop_index', array('class'=>'inline')); ?>
        <?php echo $form->error($model, 'on_shop_index'); ?>
    </div>

	<? $this->widget('\common\ext\file\widgets\UploadFile', [
		'behavior'=>$model->mainImageBehavior, 
		'form'=>$form, 
		'actionDelete'=>$this->createAction('removeProductMainImage'),
	    'tmbWidth'=>200,
	    'tmbHeight'=>200,
	    'view'=>'panel_upload_image'
	]); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php 
            $this->widget('admin.widget.EditWidget.TinyMCE', array(
                'model'=>$model,
                'attribute'=>'description',
                'htmlOptions'=>array('class'=>'big')
            )); 
        ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

	<?php if($model->isNewRecord): ?>
		<div class="alert alert-info">Загрузка дополнительных изображений и файлов будет доступна после создания товара</div>
	<?php else: ?>
	    <div class="row">
	        <?php echo CHtml::link('Управление эскизами', array('shopNew/thumbsUpdate/', 'id' => $model->id)); ?>
	    </div>
	
	    <?php $this->widget('admin.widget.ajaxUploader.ajaxUploader', array(
	        'fieldName'=>'images',
	        'fieldLabel'=>'Загрузка фото',
	        'model'=>$model,
	        'tmb_height'=>100,
	        'tmb_width'=>100,
	        'fileType'=>'image'
	    )); ?>
	
	    <?php $this->widget('admin.widget.ajaxUploader.ajaxUploader', array(
	        'fieldName'=>'files',
	        'fieldLabel'=>'Загрузка файлов',
	        'model'=>$model,
	    )); ?>
	<?php endif; ?>





