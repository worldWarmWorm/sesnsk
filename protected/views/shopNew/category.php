<h1><?=$category->getMetaH1()?></h1>

<div id="category-description" class="category-description">
    <?=$category->description?>
</div>

<div id="product-list-module">
	<?$this->renderPartial('_products_listview', compact('model', 'category'))?>
</div>
