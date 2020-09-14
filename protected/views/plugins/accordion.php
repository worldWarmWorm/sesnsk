<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>

<script>
  $(function() {
    $( ".page-accordion" ).accordion({
      heightStyle: "content",
      active: false,
      collapsible: true,
      header: ".accordion__item_title"
    });
  });
</script>

<div class="accordion-list page-accordion" id="">
	<? foreach($model as $accordion):?>

		<div class="accordion__item">
			<div class="accordion__item_title"><?=$accordion->title?></div>
			<div class="accordion__item_content content">
				<?=$accordion->description?>
			</div>
		</div>
	<?endforeach;?>
</div>