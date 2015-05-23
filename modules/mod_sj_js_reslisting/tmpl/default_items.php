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
foreach($list['items']  as $item){  ?>
	<div class="respl-item  category-<?php echo $item->category_id ?>" data-average_rating="<?php echo $item->average_rating; ?>"  data-dmodify="<?php echo strtotime($item->date_modify) ?>" data-dadded="<?php echo strtotime($item->product_date_added); ?>" data-review="<?php echo (strtotime($item->reviews_count) != '');?>" data-product_price="<?php echo $item->product_price; ?>" data-hits="<?php echo $item->hits; ?>" data-title="<?php echo trim(strtoupper($item->title)); ?>" data-id="<?php echo $item->product_id; ?>" data-catid="<?php echo $item->category_id ?>">
		<div class="item-inner">
			<?php $img = JSResponsiveListingHelper::getJSAImage($item, $params);  ?>
			<div class="item-image cf">
				<?php if($params->get('item_cat_display', 1) == 1){?>
				<div class="item-public" data-value="<?php echo JText::_('PUBLISHED_LABEL')?>">&nbsp;
					<a href="<?php echo $item->catlink ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->category_title?>" >
						<?php echo $item->category_title?>
					</a>
				</div>
				<?php }?>
					<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
					<?php echo JSResponsiveListingHelper::imageTag($img); ?>
					<?php if($params->get('item_cat_display', 1) == 1){?>
					<span class="item-opacity"></span>
					<?php }?>
					</a>
			</div>
			<?php if($params->get('item_title_display',1) == 1){?>
			<div class="item-title ">
				<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" >
					<?php echo JSResponsiveListingHelper::truncate($item->title, $params->get('item_title_max_characters',25)); ?>
				</a>
			</div>
			<?php }?>
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
			<?php if((int)$params->get('item_review_display',1)){?>
			<div class="item-review ">	
				<table class="review_mark"><tr><td><?php echo showMarkStar($item->average_rating);?></td></tr></table>
			</div>
			<?php }
			if((int)$params->get('item_price_display',1)){?>
			<div class="item-price" data-label="<?php echo JText::_('PRICE_LABEL'); ?>">
				<?php echo formatprice($item->product_price); ?>
			</div>
			<?php } ?>
			<?php if($params->get('item_readmore_display', 1) == 1){?>
			<div class="item-readmore">
				<a href="<?php echo $item->link ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->title?>" data-arrow="&#187;" >
					<?php echo JText::_('READ_MORE_LIST_LABEL') ?>
				</a>
			</div>
			<?php } ?>
			<div class="item-more">
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
						<?php if($params->get('item_cat_display', 1) == 1){?>
						<div class="more-public" data-value="<?php echo JText::_('PUBLISHED_LABEL')?>">&nbsp;
							<a href="<?php echo $item->catlink ?>" <?php echo JSResponsiveListingHelper::parseTarget($params->get('link_target','_self'))?> title="<?php echo $item->category_title?>" >
								<?php echo $item->category_title ?>
							</a>
						</div>
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
<?php } 
} ?>
