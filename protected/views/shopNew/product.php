<?php CmsHtml::fancybox(); ?>
<h1><?=$product->getMetaH1()?></h1>

<div class="product-page">
	<div class="images">
		<?php if(!Yii::app()->user->isGuest) echo CHtml::link('редактировать', array('cp/shop/productUpdate', 'id' =>$product->id), array('class'=>'btn-product-edit', 'target' => 'blank'));?>
		<div class="js__main-photo product-main-img<?=HtmlHelper::getMarkCssClass($product, ['sale','new','hit'])?>">
			<?php if($product->mainImageBehavior->isEnabled()): ?>
				<?= CHtml::link($product->img(320,240), $product->mainImageBehavior->getSrc(), ['class'=>'image-full', 'rel'=>'group']); ?>
			<?else:?>
				<?= $product->img(320,240); ?>
			<?endif?>
		</div>

		<div class="more-images">
			<?foreach($product->moreImages as $id=>$img):?>
			<div class="more-images-item">
				<a class="image-full" rel="group" href="<?=$img->url?>" title="<?=$img->description?>"><?=CHtml::image($img->tmbUrl, $img->description)?></a>
			</div>
			<?endforeach?>
		</div>
	</div>
  <div class="options">

	<?if(!empty($product->brand_id)):?>
	<div class="product-brand">
		<strong>Бренд:</strong> <?=$product->brand->title?>
	</div>
	<?endif?>
	<?if(!empty($product->code)):?>
	<div class="product-code">
		<strong>Артикул:</strong> <?=$product->code?>
	</div>
	<?endif?>


	<?if(!empty($product->description)):?>
	<div class="description">
		<?=$product->description?>
	</div>
	<?endif?>

  <?if(D::yd()->isActive('shop') && (int)D::cms('shop_enable_attributes') && count($product->productAttributes)):?>
	  <div class="product-attributes">
		<ul>
		  <?php foreach ($product->productAttributes as $productAttribute):?>
			<li><span><?=$productAttribute->eavAttribute->name;?></span><span><?=$productAttribute->value;?></span></li>
		  <?php endforeach;?>
		</ul>
	  </div>
	<?php endif;?>

	<div class="buy">
		<p class="order__price">Цена:
            <? if(D::cms('shop_enable_old_price')): ?>
			<?php if($product->old_price > 0): ?>
				<span class="old_price"><?= HtmlHelper::priceFormat($product->old_price); ?> 
					<i class="rub">руб</i>
				</span>
			<?php endif; ?>
            <? endif; ?>
			<span class="new_price"><?= HtmlHelper::priceFormat($product->price); ?>
				<i class="rub">руб</i>
			</span>
        </p>
        
		

		<div class="to-cart-wrapper">
		    <?php $this->widget('\DCart\widgets\AddToCartButtonWidget', array(
		    	'id' => $product->id,
		    	'model' => $product,
		    	'title'=>'<span>В корзину</span>',
		    	'cssClass'=>'callback-button js__photo-in-cart open-cart',
		    	'attributes'=>[
										// ['count', '.counter_input'],
		    	]
		    	));
	    	?>
		</div>
	</div>
  </div>
  <div class="clr"></div>
</div>

<?if(D::cms('shop_enable_reviews')) $this->widget('widget.productReviews.ProductReviews', array('product_id' => $product->id))?>
