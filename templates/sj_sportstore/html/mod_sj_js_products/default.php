<?php
/**
 * @package Sj Products for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

$instance	= rand().time();
if(!empty($items)){
    ImageHelper::setDefault($params);
    $options=$params->toObject();?>
	<div id="products_wrap_<?php echo $instance;?>" class="products-wrap <?php echo $options->deviceclass_sfx;?>">
    	<?php if(!empty($options->pretext)){?>
    		<div class="intro_text"><?php echo $options->pretext; ?></div>
    	<?php }?>
		<?php 
			//var_dump($items);return;
		 ?>	
	<?php $i = 0; foreach($items as $i => $curr){$i++;?>
		
	    <div class="content-box <?php if($i == 1){echo ' first';} ?>">
			<div class="product"> 
			 <div class="product-inner">
			 
				<div class="title-cate"><i class="icon-th-list"></i><a href="<?php echo SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$curr->category_id,1); ?>" <?php echo SjProducts::parseTarget($params->get('link_target','_self'))?> title="<?php echo $curr->category_title;?>" >
						<?php echo $curr->category_title; ?>
					</a>
				</div>
				
				<?php if( $options->show_image || ($curr->label_id && $options->show_label)){?>
				<div class="image_block">
					<?php if ($curr->label_id && $options->show_label){?>
						<div class="item_label">
							<?php if ($curr->_label_image){?>
								<img src="<?php echo $curr->_label_image?>" alt="<?php echo htmlspecialchars($curr->_label_name)?>" />
							<?php }else {?>
								<span class="label_name"><?php echo $curr->_label_name;?></span>
							<?php }?>
						</div>
					<?php }?> 
					<?php if( $options->show_image ){?>   
						<div class="item_image">							
							<?php $img = SjProducts::getJSAImage($curr, $params);
								  echo SjProducts::imageTag($img);
							?>
							<div class="item-opacity">
								<span class="item-opacity-hover">
									<a data-rel="prettyPhoto"  href="<?php echo $img['src'];//echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>></a>
								</span>
							</div>
							
						</div>
					<?php }?>
				</div>
				<?php }?>
				
				<form name="product" method="post" action="<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=add',1) ;?>" enctype="multipart/form-data" autocomplete="off">
				<div class="inner">
				
				<?php if( $options->show_title ){?>
					<div class="item_title">
						<a href="<?php echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>><?php echo $curr->name?></a>
						<!-- span class="jshop_code_prod">(<?php //echo _JSHOP_EAN?>: <span><?php //echo $curr->product_ean;?></span>)</span-->
					</div>	
				<?php }?>
				
				<?php if ( $curr->_display_price && $options->show_price ){?>
					<div class = "item_price">
						<?php if ($curr->show_price_from) echo _JSHOP_FROM." ";?>
						<span><?php echo formatprice($curr->product_price);?></span>
					</div>
				<?php }?>
				
				<?php if( $options->show_tax ){?>
					<div class="taxinfo"><?php echo $curr->tax; //echo productTaxInfo($curr->tax);?></div>
				<?php }?>
					
				   <button class="button btn-cart" type="submit" onclick="jQuery('#to').val('cart');" title=" <?php print _JSHOP_ADD_TO_CART;?> "><i class="ico-cart"></i>
<span><?php print _JSHOP_ADD_TO_CART?></span></button> 
							   
				  <?php /*?> <input type="submit" class="button" value="<?php print _JSHOP_ADD_TO_CART?>" onclick="jQuery('#to').val('cart');" /><?php */?>	
				
				<div class="inner-hover">
					
					<?php if( $options->show_review || $options->show_comments ){?>
					<div class="item-rate-comment">
						<?php if( $options->show_review ){?>
							<div class="item-review">
								<table class="review_mark"><tr><td><?php echo showMarkStar($curr->average_rating);?></td></tr></table>
							</div>
						<?php }?>
						<?php if( $options->show_comments ){?>
							<div class="count_commentar"><i class="icon-comments-alt"></i>
								<?php $curr->reviews_count = (int)$curr->reviews_count;
									if( $curr->reviews_count > 1 ){
										echo $curr->reviews_count." ".jText::_('JSHOP_COMENTS');
									}else{
										echo $curr->reviews_count." ".jText::_('JSHOP_COMENT');
									}
								?>
							</div> 
						<?php }?>
					</div>
					<?php }?>
					
					<?php if( $options->show_hits ){?> 
						<div class="item_hits">
						<?php $curr->hits = (int)$curr->hits;?>
							<?php if( $curr->hits > 1 ){echo "Hits : ". $curr->hits;}else{
								echo "Hit : ". $curr->hits;
							}?>
						</div> 
					<?php }?>
					<?php if( $options->show_date ){?>
						<div class="item_date">
							<?php echo "Date : ".date("d F Y", strtotime($curr->date_modify));?>
						</div>  
					<?php }?> 
					<?php if( $options->show_manufacturer ) {?> 
						<div class="item_manufacturer"><span><?php print _JSHOP_MANUFACTURER;?>:&nbsp;</span><a href="<?php print SEFLink('index.php?option=com_jshopping&controller=manufacturer&task=view&manufacturer_id='.$curr->manufacturer->id, 2);?>"><?php echo $curr->manufacturer->name;?></a>
						</div>
					<?php }?>
					
					
					<?php //if ($this->enable_wishlist){?>
					    <button type="submit" class="button btn-wishlist" title=" <?php print _JSHOP_ADD_TO_WISHLIST?> " onclick="jQuery('#to').val('wishlist');"><span><?php print _JSHOP_ADD_TO_WISHLIST?></span></button>
				    <?php //}?> 
					
					
					<?php if( $options->show_desc ){?>
						<div class="item_description">
							<?php echo $curr->short_description;?>
						</div>		        
					<?php }?>  
					
					 <?php /*?><div class="productweight"><?php echo _JSHOP_WEIGHT?>: <span><?php echo formatweight($curr->product_weight)?></span></div><?php */?>
					 
					<?php if ($curr->delivery_time != ''){?>
						<div class="deliverytime"><?php echo _JSHOP_DELIVERY_TIME?>: <span><?php echo $curr->delivery_time?></span></div>
					<?php }?>
					
					<?php if (is_array($curr->extra_field)){?>
						<div class="extra_fields">
						<?php foreach($curr->extra_field as $extra_field){?>
							<div><?php echo $extra_field['name'];?>: <?php echo $extra_field['value']; ?></div>
						<?php }?>
						</div>
					<?php }?>
					<?php if( $options->show_read_more ){?>
						<div class="item_detail">
							<a href="<?php echo $curr->link?>" <?php echo SjProducts::parseTarget($options->target);?>><?php echo $options->read_more_text;?></a>
						</div>
					<?php }?>
				  </div>
				  
				</div>
				  <input type="hidden" name="to" id='to' value="cart" />
				  <input type="hidden" name="product_id" id="product_id" value="<?php print $curr->product_id;?>" />
				  <input type="hidden" name="category_id" id="category_id" value="<?php print $curr->category_id;?>" />
				</form>
			  </div>
			</div>
	    </div>  <!--End content - box-->
    	<?php
    		$clear = 'clr1';
    		if ($i % 2 == 0) $clear .= ' clr2';
    		if ($i % 3 == 0) $clear .= ' clr3';
    		if ($i % 4 == 0) $clear .= ' clr4';
    		if ($i % 5 == 0) $clear .= ' clr5';
    		if ($i % 6 == 0) $clear .= ' clr6';
    	?>
    	<div class="<?php echo $clear; ?>"></div>    
	<?php } ?>
        <?php if(!empty($options->posttext)){?>
        	<div class="footer_text"><?php echo $options->posttext; ?></div>
   		<?php }?>	
	</div>
<?php } else { echo JText::_('Has no content to show!');}?>
<?php
JHtml::stylesheet('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_js_products/mod_sj_js_products.css');
?>