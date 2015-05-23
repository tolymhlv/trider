<?php defined('_JEXEC') or die(); ?>
<?php $in_row = $this->config->product_count_related_in_row;?>
<?php if (count($this->related_prod)){?> 
<div class="product-related-inner">   
    <div class="related_header"><?php print _JSHOP_RELATED_PRODUCTS?></div>
    <div class="jshop_list_product">
    <div class = "jshop list_related">
        <?php foreach($this->related_prod as $k=>$product){?>  
            <?php if ($k%$in_row==0) print "<div class='sj-row clearfix'>";?>
            <?php /*?><td width="<?php print 100/$in_row?>%" class="jshop_related"><?php */?>
			<div class="jshop_related sj-column span<?php print floor(12/$in_row)?>">
                <?php include(dirname(__FILE__)."/../".$this->folder_list_products."/".$product->template_block_product);?>				 
            </div>
            <?php if ($k%$in_row==$in_row-1) print "</div>";?>   
        <?php }?>
        <?php if ($k%$in_row!=$in_row-1) print "</div>";?>
    </div>
    </div>
</div> 
<?php }?>