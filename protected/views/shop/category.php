<h1><?=$category->getMetaH1()?></h1>

<div id="category-description" class="category-description">
    <?=$category->description?>
</div>

<div class="category-callback-wrapper">
	<a href="#form-callback" class="open-popup-link callback-button" data-title="<?= $category->title ?>">Заказать услугу</a>
</div>
