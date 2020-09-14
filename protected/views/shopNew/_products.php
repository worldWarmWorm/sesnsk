<?
/**
 * @var Product $data
 */
$cache=\Yii::app()->user->isGuest;
if(!$cache || $this->beginCache('shop__product_card', ['varyByParam'=>[$data->id]])): // cache begin

if(empty($category)) $categoryId=$data->category_id;
else $categoryId=$category->id;
$productUrl=Yii::app()->createUrl('shopNew/product', ['id'=>$data->id, 'category_id'=>$categoryId]);
?>
<div class="product-item">
	<? if(!\Yii::app()->user->isGuest) echo CHtml::link('редактировать', ['/cp/shopNew/productUpdate', 'id'=>$data->id], ['class'=>'btn-product-edit', 'target'=>'_blank']); ?>
	<div class="product<?=HtmlHelper::getMarkCssClass($data, array('sale','new','hit'))?>">
		<div class="flex-item-wrap">
			<div class="product_img product-block">
				<?=CHtml::link($data->img(230, 140), $productUrl); ?>
			</div>
			<div class="product_name product-block">
					<?=CHtml::link($data->title, $productUrl, array('title'=>$data->link_title)); ?>
			</div>
		</div> <!-- flex-item-wrap -end -->
		<div class="flex-item-wrap">
			<!-- 	<ul class="counter_number">
				<li class="counter_numbe_minus">-</li>
				<li class="counter_number_input">
					<input id="js-product-count-<?= $data->id ?>" type="text" name="counter" value="1" class="counter_input total-num" maxlength="4">
				</li>
				<li class="counter_number_plus">+</li>
			</ul> -->
			<div class="product_price product-block">
	        	<?php if($data->price > 0): ?>
					<p class="order__price">
                        <? if(D::cms('shop_enable_old_price')): ?>
						<?php if($data->old_price > 0): ?>
							<span class="old_price"><?= HtmlHelper::priceFormat($data->old_price); ?> 
								<i class="rub">руб .</i>
							</span>
						<?php endif; ?>
                        <? endif; ?>
						<span class="new_price"><?= HtmlHelper::priceFormat($data->price); ?>
							<i class="rub">руб .</i>
						</span>
					</p>
				<?php endif; ?>
			</div>
			<div class="to-cart-wrapper">
				<?$this->widget('\DCart\widgets\AddToCartButtonWidget', array(
					'id' => $data->id,
					'model' => $data,
					'title'=>'<span>В корзину</span>',
					'cssClass'=>'callback-button button_1 js__in-cart open-cart',
					'attributes'=>[
						// ['count', '#js-product-count-' . $data->id],
					]
				));
				?>
			</div>
		</div> <!-- flex-item-wrap -end -->
	</div>
</div>

<? if($cache) { $this->endCache(); } endif; // cache end ?>
