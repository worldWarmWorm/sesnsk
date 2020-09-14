<?php
/** @var \feedback\widgets\types\PhoneTypeWidget $this */
/** @var FeedbackFactory $factory */
/** @var string $name attribute name. */
use common\components\helpers\HYii as Y;
use common\components\helpers\HArray as A;

$jsClassName = $name . rand(0, 1000000);
$htmlOptions=A::m(A::m([
	'class'=>'inpt',
	'placeholder'=>$factory->getOption("attributes.{$name}.placeholder", '+7 ( ___ ) ___ - __ - __') 
], $factory->getOption("attributes.{$name}.htmlOptions", [])), A::get($this->params, 'htmlOptions', []));
$htmlOptions['class'].=" {$jsClassName}";
Y::js(false, "jQuery('.{$jsClassName}').mask('+7 ( 999 ) 999 - 99 - 99');", \CClientScript::POS_READY);
?>
<?php // echo $form->labelEx($factory->getModelFactory()->getModel(), $name); ?>
<?= \CHtml::tag('div', ['style'=>'display:none'], $form->error($factory->getModelFactory()->getModel(), $name)); ?>
<?php $this->widget('CMaskedTextField', array(
	'model' => $factory->getModelFactory()->getModel(),
    'attribute' => $name,
    'mask' => '+7 ( 999 ) 999 - 99 - 99',
	'htmlOptions' => $htmlOptions
));
?>
