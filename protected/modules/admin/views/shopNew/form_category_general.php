<?php

$breadcrumbs = array();

$breadcrumbs['Препараты'] = array('shopNew/index');
$breadcrumbs = $this->getBreadcrumbs(Yii::app()->request->getQuery('parent_id',Yii::app()->request->getQuery('id', 1)), true);
if($model->isNewRecord){
  $breadcrumbs[] = 'Добавление категории';
}
else {
  $breadcrumbs[] = 'Редактирование категории';
}
$this->breadcrumbs = $breadcrumbs;
?>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'page-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'validateOnChange'=>false
        ),
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
    )); ?>

    <?=$form->errorSummary($model)?>
    
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs'=>array(
            'Основное'=>array('content'=>$this->renderPartial('_form_category', compact('model', 'form'), true), 'id'=>'tab-general'),
            'Seo'=>array('content'=>$this->renderPartial('_form_category_seo', compact('model', 'form'), true), 'id'=>'tab-seo'),
        ),
        'options'=>array()
    )); ?>

    <div class="row buttons">
        <div class="left">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', array('class'=>'btn btn-primary')); ?>
            <?=CHtml::submitButton($model->isNewRecord ? 'Создать и выйти' : 'Сохранить и выйти', array('class'=>'btn btn-info', 'name'=>'saveout'))?>
            <?php echo CHtml::link('Отмена', array('index'), array('class'=>'btn btn-default')); ?>
        </div>

        <?php if (!$model->isNewRecord && (!$model->getProductsCount() || D::role('sadmin'))): ?>
        <div class="right with-default-button">
        	<? if(!$model->getProductsCount()): ?>
            <a href="<?php echo $this->createUrl('shopNew/categoryDelete', array('id'=>$model->id)); ?>"
               onclick="return confirm('Вы действительно хотите удалить категорию?')" class="btn btn-danger">Удалить категорию</a>
            <? endif; ?>
            <? if(D::role('sadmin')): ?>
            <a href="<?php echo $this->createUrl('shopNew/categoryTotalDelete', array('id'=>$model->id, 'hash'=>md5($model->id))); ?>"
               onclick="return confirm('Вы действительно хотите удалить категорию со всеми подкатегориями и товарами?')" class="btn btn-danger">Удалить категорию<br/><span class="small">со всеми подкатегориями и товарами</span></a>
            <? endif; ?>
        </div>
        <?php endif; ?>
        <div class="clr"></div>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->
