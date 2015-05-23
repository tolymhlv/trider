<?php
/**
 * @package Sj Responsive Listing for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

if(isset($list['items'])) {
ImageHelper::setDefault($params);
$i = 0;
foreach($list['items']  as $item){  
	$i++;?>
	
	<div class="respl-item <?php if($i==1){ echo ' first';}?>  category-<?php echo $item->category_id ?>" data-average_rating="<?php echo $item->average_rating; ?>"  data-dmodify="<?php echo strtotime($item->date_modify) ?>" data-dadded="<?php echo strtotime($item->product_date_added); ?>" data-review="<?php echo (strtotime($item->reviews_count) != '');?>" data-product_price="<?php echo $item->product_price; ?>" data-hits="<?php echo $item->hits; ?>" data-title="<?php echo trim(strtoupper($item->title)); ?>" data-id="<?php echo $item->product_id; ?>" data-catid="<?php echo $item->category_id ?>">
		<div class="item-inner">
			<div class="item-intro">
				<?php if($params->get('item_cat_display', 1) == 1){?>
					<div class="item-public"><i class="icon-th-list"></i>
						<a href="<?php echo $item->catlink ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->category_title?>" >
							<?php echo $item->category_title ?>
						</a>
					</div>
				<?php }?>
				<?php $img = JSResponsiveListingHelper::getJSAImage($item, $params);  ?>
				<?php //var_dump($img);return; ?>
				<div class="item-image cf">	
					<?php echo JSResponsiveListingHelper::imageTag($img); 
					$img = JSResponsiveListingHelper::getJSAImage($item, $params); //var_dump($img); die();
					?>
					<div class="item-opacity">
						<span class="item-opacity-hover">
							<a data-rel="prettyPhoto" href="<?php echo $img['src']; ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" ></a>
						</span>
					</div>
				</div>
				
				<form name="product" method="post" action="<?php print SEFLink('index.php?option=com_jshopping&controller=cart&task=add',1) ;?>" enctype="multipart/form-data" autocomplete="off">
				<div class="item-intro-inner">
				
					<?php if($params->get('item_title_display',1) == 1){?>
					<div class="item-title ">
						<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
							<?php echo JSResponsiveListingHelper::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
						</a>
					</div>
					<?php }?>
					
					<?php if((int)$params->get('item_price_display',1)){?>
					<div class="item-price" data-label="<?php //echo JText::_('PRICE_LABEL'); ?>">
						<?php echo formatprice($item->product_price); ?>
					</div>
					<?php } ?>
					
					<div class="item-tax">
						<?php echo $item->_tax; ?>
					</div>
										   
				   <button class="button btn-cart" type="submit" onclick="jQuery('#to').val('cart');" title=" <?php print _JSHOP_ADD_TO_CART;?> "><i class="ico-cart"></i>
<span><?php print _JSHOP_ADD_TO_CART?></span></button> 
				   <?php /*?><input type="submit" class="button" value="<?php print _JSHOP_ADD_TO_CART?>" onclick="jQuery('#to').val('cart');" /><?php */?>
					
					<div class="item-intro-hover">
					
						<?php //if ($this->allow_review){?>
						<div class="item-rate-comment">
							<?php if((int)$params->get('item_review_display',1)){?>
							<div class="item-review">	
								<table class="review_mark"><tr><td><?php echo showMarkStar($item->average_rating);?></td></tr></table>
							</div>
							<?php }?>
							<div class="item_count_commentar"><i class="icon-comments-alt"></i>
								<?php print $item->reviews_count." "; if($item->reviews_count > 1){ echo jText::_('JSHOP_COMENTS');} else{ echo jText::_('JSHOP_COMENT');} ?>						
							</div>
						</div>
						<?php //}?>			
				
						<?php //if ($product->manufacturer->name){?>
							<div class="manufacturer_name"><span><?php print _JSHOP_MANUFACTURER;?>:&nbsp;</span><a href="<?php print SEFLink('index.php?option=com_jshopping&controller=manufacturer&task=view&manufacturer_id='.$item->manufacturer->id, 2);?>"><?php print $item->manufacturer->name?></a></div>								
						<?php //}?>
						
						<?php //if ($this->enable_wishlist){?>
					    <button type="submit" class="button btn-wishlist" title=" <?php print _JSHOP_ADD_TO_WISHLIST?> " onclick="jQuery('#to').val('wishlist');"><span><?php print _JSHOP_ADD_TO_WISHLIST?></span></button>
				    <?php //}?> 
						
						<?php if($params->get('item_created_display', 1)== 1 || $params->get('item_hits_display',1) == 1 ) {?>
						<div class="item-post-read">
							<?php if($params->get('item_created_display',1) == 1) {?>
							<div class="item-post" data-value="<?php echo JText::_('POST_LABEL')?>">&nbsp;<?php echo  JHTML::_('date', $item->created,JText::_('DATE_FORMAT_LC3')) ?></div>
							<?php }?>
							<?php if($params->get('item_hits_display',1) == 1) {?>
							<div class="item-read" data-read="<?php echo JText::_('READ_LABEL')?>" data-times="<?php echo  ((int)$item->hits>1)?JText::_('TIMES_LABEL'):JText::_('TIME_LABEL')?>">&nbsp; <?php echo $item->hits ?> &nbsp;</div>
							<?php } ?>
						</div>
						<?php } ?>
						<?php if($params->get('item_description_display', 1) == 1 && $item->_description != '') {?>
						<div class="item-desc">
							<?php
								echo JSResponsiveListingHelper::truncate($item->_description,$params->get('item_des_maxlength_layout_list',200));
							?>
						</div>
						<?php }?>
						
						<?php if($params->get('item_readmore_display', 1) == 1){?>
						<div class="item-readmore">
							<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" data-arrow="&#187;" >
								<?php echo JText::_('READ_MORE_LIST_LABEL') ?>
							</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<input type="hidden" name="to" id='to' value="cart" />
			   <input type="hidden" name="product_id" id="product_id" value="<?php print $item->product_id;?>" />
			   <input type="hidden" name="category_id" id="category_id" value="<?php print $item->category_id;?>" />
			</form>
				
			</div>
				
			<div class="item-more">
			
				<?php if($params->get('item_cat_display', 1) == 1){?>
				<div class="more-public"><i class="icon-th-list"></i>
					<a href="<?php echo $item->catlink ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->category_title?>" >
						<?php echo $item->category_title ?>
					</a>
				</div>
			<?php }?>
			
				<div class="more-image cf">
					<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
						<?php echo JSResponsiveListingHelper::imageTag($img); ?>
					</a>
				</div>
				<div class="more-desc">
					<div class ="more-opacity"></div>
					<div class="more-inner">
						<?php if($params->get('item_title_display',1) == 1){?>
						<div class="more-title">
							<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
								<?php echo JSResponsiveListingHelper::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
							 </a>
							
						</div>
						<?php }?>
						<?php if($params->get('item_hits_display', 1) == 1){?>
						<div class="more-read" data-read="<?php echo JText::_('READ_LABEL')?>" data-times="<?php echo ((int)$item->hits>1)?JText::_('TIMES_LABEL'):JText::_('TIME_LABEL')?>">&nbsp;<?php echo $item->hits ?>&nbsp;</div>
						<?php }?>
						
						<?php if($params->get('item_description_display', 1) == 1 && $item->_description !='' ) {?>
						<div class="more-content">
							<?php
								echo JSResponsiveListingHelper::truncate($item->_description,$params->get('item_des_maxlength_layout_grid',200));
							?>
					 	</div>
					 	<?php } 
						if((int)$params->get('item_review_display',1)){?>
						<div class="more-review ">	
							<table class="review_mark"><tr><td><?php echo showMarkStar($item->average_rating);?></td></tr></table>
						</div>
						<?php }
						if((int)$params->get('item_price_display',1)){?>
						<div class="more-price" data-label="<?php echo JText::_('PRICE_LABEL'); ?>">
							<?php echo formatprice($item->product_price); ?>
						</div>
						<?php }
						if($params->get('item_created_display',1) == 1) {?>
					 	<div class="more-post" data-value="<?php echo JText::_('POST_LABEL')?>"><?php echo  JHTML::_('date', $item->created,JText::_('DATE_FORMAT_LC3')) ?></div>
					 	<?php }?>
					 	<?php if($params->get('item_readmore_display', 1) == 1){?>
					 	<div class="more-readmore">
					 		<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
					 			<?php echo JText::_('READ_MORE_GRID_LABEL') ?>
					 		</a>
					 	</div>
					 	<?php }?>
				 	</div>
				 </div>
			</div>
		</div>
	</div>
	
	<?php //var_dump($item); echo  ('--------------<br/>');?>
	
<?php } 
} ?>
