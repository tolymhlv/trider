<?php
/**
 * @package Sj News Frontpage
 * @version 3.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
?>

<div class="big-item-wrap">
	<?php 
	$img = NewsFrontpageHelper::getAImage($item0, $params);
	if( $img ){ ?>
	<div class="big-item-image">
		<a href="<?php echo $item0->link; ?>" title="<?php echo $item0->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>> 
			<?php echo NewsFrontpageHelper::imageTag($img);?>
		</a>
	</div>
	<?php }?>

	<?php if( (int)$params->get('big_item_title_display', 1) ){ ?>
	<div class="big-item-title">
		<a href="<?php echo $item0->link; ?>" title="<?php echo $item0->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>>
			<?php echo NewsFrontpageHelper::truncate($item0->title, (int)$params->get('big_item_title_max_characters'));?>
		</a>
	</div>
	<?php }?>

	<?php if( (int)$params->get('big_item_datetime_display') ){ ?>
	<div class="big-item-datetime"><i class="icon-time"></i>
		<?php //echo JHtml::date($item0->created, 'd F Y'); ?>
		<?php
			  $first_date = strtotime(JHtml::date($item0->created, 'Y-m-d'));
			  $second_date = strtotime(date('Y-m-d'));
			  $datediff = abs($first_date - $second_date);
			  echo floor($datediff/(60*60*24))." ".jText::_('AGO_DAYS');
			  //echo '<br/>f:'.JHtml::date($item0->created, 'Y-m-d').'<br>'.'s'.date('Y-m-d');
		?>
	</div>
	<?php }?>

	<?php if( (int)$params->get('big_item_description_display', 1) ){ ?>
	<div class="big-item-description">
		<?php echo NewsFrontpageHelper::truncate($item0->introtext, (int)$params->get('big_item_description_max_characters')); ?>
	</div>
	<?php }?>
	<?php 
	$tags = '';
	if($params->get('big_item_tag_display') == 1 && $item0->tags != '' && !empty($item0->tags->itemTags) ) {	
		$item0->tagLayout = new JLayoutFile('joomla.content.tags');
		$tags = $item0->tagLayout->render($item0->tags->itemTags); 
	}	
	if($tags != ''){?>
	<div class="big-item-tags">
		<?php echo  $tags; ?>
	</div>
	<?php }	?>
	<?php if( (int)$params->get('item_readmore_display', 1) ){ ?>
	<div class="big-item-readmore">
		<a href="<?php echo $item0->link; ?>" title="<?php echo $item0->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>>
			<span><?php echo $params->get('item_readmore_text', 'read more'); ?></span>			
		</a>
	</div>
	<?php }?>
</div> <!-- display big item end -->

<div class="small-item-list">
	<div class="small-items-container">
	<?php
	$nb_column = (int)$params->get('number_column_t3', 4);
	$i = 0;
	foreach($items as $key => $item){$i++;?>
		<div class="small-item-wrap <?php if( $i%$nb_column == 0 ){ echo "item-last";}?> column-<?php echo $params->get('number_column_t3');?>">
			<?php
			$img_nav = NewsFrontpageHelper::getAImage($item, $params);
			if ($img_nav){ ?>
				<div class="small-item-image" >
					<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>>
						<?php 
						echo NewsFrontpageHelper::imageTag($img_nav, $small_image_config);?>
					</a>
				</div>
			<?php }?>
			
			<div class="small-item-content">
				<?php if( (int)$params->get('small_item_title_display', 1) ){ ?>
					<div class="small-item-title">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>><i class=" icon-circle"></i>
							<?php echo NewsFrontpageHelper::truncate($item->title, $params->get('small_item_title_max_characters'));?>
						</a>
					</div>
				<?php }?>

				<?php if( (int)$params->get('small_item_datetime_display', 1) ){ ?>
					<div class="small-item-datetime">
						<?php echo JHtml::date($item->created, 'd F Y'); ?>
					</div>
				<?php }?>
						
				<?php if( (int)$params->get('small_item_description_display', 1) ){ ?>
					<div class="small-item-description">
						<?php  echo NewsFrontpageHelper::truncate($item->introtext, (int)$params->get('small_item_description_max_characters', 32)); ?>						
					</div>
				<?php }?>  	
				<?php 
				$tags = '';
				if($params->get('small_item_tag_display') == 1 && $item->tags != '' && !empty($item->tags->itemTags) ) {	
					$item->tagLayout = new JLayoutFile('joomla.content.tags');
					$tags = $item->tagLayout->render($item->tags->itemTags); 
				}	
				if($tags != ''){?>
				<div class="small-item-tags">
					<?php echo  $tags; ?>
				</div>
				<?php }	?>						
			</div>
		</div>
		<?php if($i == $nb_column ) { ?>
			<div class="clear"></div>
		<?php } ?>
	<?php }?>
	</div>        
</div>

