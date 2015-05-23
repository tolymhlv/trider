<div id = "jshop_module_cart">
	<div class="des-jshop-cart">
	   <a href = "<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1)?>"><span class="ico-cart"><?php if($params->get('picture_link')) print '<img src="'.JURI::root().$params->get('picture_link').'" />';?></span><?php print JText::_('MY_CART').'&nbsp;';//print JText::_('GO_TO_CART');?></a>
	   <span class="number-pro">
      	<span id = "jshop_quantity_products">(<?php if($cart->count_product){print $cart->count_product.'&nbsp;'; }?></span><?php if($cart->count_product > 1){ print JText::_('JSHOP_ITEMS');}else if($cart->count_product > 0){print JText::_('JSHOP_ITEM');} else {print JText::_('JSHOP_EMPTY');}//print JText::_('PRODUCTS');?>)
	   </span> 
      <span id = "jshop_summ_product"><?php print formatprice($cart->getSum(0,1))?></span>
	</div>
	
	<div class="res-jshop-cart">
	   <a href = "<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1)?>"><span class="ico-cart"></span></a>
	   
	   <div class="drop-cart">
		   <a href = "<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=view', 1)?>"><?php print JText::_('MY_CART').'&nbsp;';//print JText::_('GO_TO_CART');?></a>
		   <span class="number-pro">
			<span id = "jshop_quantity_products">(<?php if($cart->count_product){print $cart->count_product.'&nbsp;'; }?></span><?php if($cart->count_product > 1){ print JText::_('JSHOP_ITEMS');}else if($cart->count_product > 0){print JText::_('JSHOP_ITEM');} else {print JText::_('JSHOP_EMPTY');}//print JText::_('PRODUCTS');?>)
	   		</span>  
		  <span id = "jshop_summ_product"><?php print formatprice($cart->getSum(0,1))?></span>
	  </div>
   </div>
	
</div>