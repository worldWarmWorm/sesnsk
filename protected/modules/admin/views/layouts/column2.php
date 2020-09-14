<?use YiiHelper as Y;?>
<?php $this->beginContent('/layouts/main'); ?>
    <style type="text/css">
        .right-col {
            float: right;
            width: 960px;
        }
    </style>


    <div class="right-col">
      <div id="content" class="content">
      		<? $this->widget('\common\widgets\ui\flash\Yii', ['view'=>'system']); ?>
          	<?php echo $content; ?>
      </div>
    </div>

    <div class="clr"></div>
<?php $this->endContent(); ?>
