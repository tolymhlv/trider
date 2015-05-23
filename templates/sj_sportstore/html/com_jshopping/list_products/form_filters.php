<?php defined('_JEXEC') or die(); ?>
<form action="<?php print $this->action;?>" method="post" name="sort_count" id="sort_count">
<?php if ($this->config->show_sort_product || $this->config->show_count_select_products){?>
<div class="block_sorting_count_to_page"> 
	<?php /*?><span class="layout-type">
		<?php print JText::_('JSHOP_VIEW_AS').": ";?>
		<a href="javascript: void(0)" class="sort_grid"><i class="icon-th"></i></a>
		<a href="javascript: void(0)" class="sort_listing"><i class="icon-th-list"></i></a>
	</span><?php */?>

    <?php if ($this->config->show_count_select_products){?>
        <span class="box_products_count_to_page"><span class="first"><?php print JText::_('JSHOP_SHOW_NUMBER').": </span><label class='select-mask'>".$this->product_count.'</label><span>'.JText::_('JSHOP_PER_PAGE');?></span></span>
    <?php }?>
	<?php if ($this->config->show_sort_product){?>
        <span class="box_products_sorting">
			<span class="first">
				<?php print _JSHOP_ORDER_BY.":";?>
			</span>
			<label class='select-mask'><?php print $this->sorting; ?></label>
			<span class="btn_sortting">
				<img src="<?php print $this->path_image_sorting_dir?>" alt="orderby" onclick="submitListProductFilterSortDirection()" />
			</span>
		</span>
    <?php }?>
</div>
<?php }?>

<?php if ($this->config->show_product_list_filters && $this->filter_show){?>
    <?php if ($this->config->show_sort_product || $this->config->show_count_select_products){?>
    <div class="margin_filter"></div>
    <?php }?>
    
    <div class="jshop filters">    
        <?php if ($this->filter_show_category){?>
        <span class="box_category"><?php print _JSHOP_CATEGORY.": ".$this->categorys_sel?></span>
        <?php }?>
        <?php if ($this->filter_show_manufacturer){?>
        <span class="box_manufacrurer"><?php print _JSHOP_MANUFACTURER.": ".$this->manufacuturers_sel?></span>
        <?php }?>
        <?php print $this->_tmp_ext_filter_box;?>
        
        <?php if (getDisplayPriceShop()){?>
        <span class="filter_price"><?php print _JSHOP_PRICE?>:
            <span class="box_price_from"><?php print _JSHOP_FROM?> <input type="text" class="inputbox" name="fprice_from" id="price_from" size="7" value="<?php if ($this->filters['price_from']>0) print $this->filters['price_from']?>" /></span>
            <span class="box_price_to"><?php print _JSHOP_TO?> <input type="text" class="inputbox" name="fprice_to"  id="price_to" size="7" value="<?php if ($this->filters['price_to']>0) print $this->filters['price_to']?>" /></span>
            <?php print $this->config->currency_code?>
        </span>
        <?php }?>
        
        <?php print $this->_tmp_ext_filter;?>
        <input type="button" class="button" value="<?php print _JSHOP_GO?>" onclick="submitListProductFilters();" />
        <span class="clear_filter"><a href="#" onclick="clearProductListFilter();return false;"><?php print _JSHOP_CLEAR_FILTERS?></a></span>
    </div>
<?php }?>
<input type="hidden" name="orderby" id="orderby" value="<?php print $this->orderby?>" />
<input type="hidden" name="limitstart" value="0" />
</form>