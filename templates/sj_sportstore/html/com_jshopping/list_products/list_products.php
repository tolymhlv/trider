<?php defined('_JEXEC') or die(); ?>
<div id="content_listing">
	<div class="jshop list_product">
	
	<?php foreach ($this->rows as $k=>$product){?>
	<?php if ($k%$this->count_product_to_row==0) print '<div class="sj-row clearfix">';?>
		<!--<div style="float:left; width:<?php print 100/$this->count_product_to_row?>%;" class="block_product sj-column">-->
		<div class="block_product sj-column span<?php print floor(12/$this->count_product_to_row);?>">
			<?php include(dirname(__FILE__)."/".$product->template_block_product);?>
		</div>
		<?php if ($k%$this->count_product_to_row==$this->count_product_to_row-1){?>
		</div>              
		<?php }?>
	<?php }?>
	<?php if ($k%$this->count_product_to_row!=$this->count_product_to_row-1) print "</div>";?>
	
	</div>
</div>