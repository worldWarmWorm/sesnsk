<?php
/** @var \extend\modules\slider\widgets\OwlCarousel $this */ 
use common\components\helpers\HYii as Y;

$t=Y::ct('\extend\modules\slider\SliderModule.widgets/owlcarousel', 'extend.slider');

echo CHtml::openTag($this->tag, $this->tagOptions);
	echo CHtml::openTag($this->itemsTagName, $this->htmlOptions);
		foreach($this->getSlides() as $slide) {
			if($img=$slide->imageBehavior->img($this->getWidth(), $this->getHeight(), $this->getProportional())) {
				echo CHtml::openTag($this->itemTagName, $this->itemOptions);
					if($slide->url) echo CHtml::link($img, $slide->url);
					else echo $img;
				echo CHtml::closeTag($this->itemTagName);
			}
		}
	echo CHtml::closeTag($this->itemsTagName);
echo CHtml::closeTag($this->tag);

?>