<h1>Препараты</h1>

<div id="product-list-module">
	<?php 
		$this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_products', 
		    'sorterHeader'=>'Сортировка:',
		    'itemsTagName'=>'div',
		    'emptyText' => '',
		    'itemsCssClass'=>'product-list',
		    'sortableAttributes'=>array(
		        'title',
		        'price',
		    ),
		    'afterAjaxUpdate'=>'function(){shopItemCount();}',
		    'id'=>'ajaxListView',
		    'template'=>'{items}',
		    'ajaxUpdate'=>true,
		    'enableHistory' => true,
		));
	?>	
</div>
