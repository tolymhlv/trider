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
	if( (int)$params->get('big_item_image_display', 1) && $img ){ ?>
	<div class="big-item-image">
		<a href="<?php echo $item0->link; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?> >
			<?php echo NewsFrontpageHelper::imageTag($img);?>
		</a>
	</div>
<?php }?>
</div><!-- display big item end -->

<div class="small-item-list">
	<div class="small-items-container">
	<?php
	$postion_index = 0;
	$postion_class = '';
	foreach($items as $key => $item){
		$postion_index++;
		if ($postion_index==1){
			$postion_class = 'item-first';
		} else if ($postion_index==count($items)){
			$postion_class = 'item-last';
		} else {
			$postion_class = '';
		} ?>
		<?php if( $params->get('small_item_title_display') == 1 || $params->get('small_item_datetime_display', 1) ==1 || $params->get('small_show_review') ==1 || $item->_display_price && $params->get('small_show_price') ){?>
		<div class="small-item-wrap <?php echo $postion_class; ?>">
			<div class="small-item-content">
				<?php
				if( (int)$params->get('small_item_title_display', 1) ){ ?>
					<div class="small-item-title">
						<a href="<?php echo $item->link; ?>" title="<?php echo $item->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?> >
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
					<?php echo NewsFrontpageHelper::truncate($item->introtext, (int)$params->get('small_item_description_max_characters', 32));?>
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
		<?php }?>
	<?php }?>
	</div>        
</div>
<div class="clear"></div>
<div class="big-item-wrap big-item-wrap-content" style="float: none;">
<?php if( (int)$params->get('big_item_title_display', 1) ){ ?>
	<div class="big-item-title">
		<a href="<?php echo $item0->link; ?>" title="<?php echo $item0->title; ?>" <?php echo NewsFrontpageHelper::parseTarget($params->get('target')); ?>>
			<?php echo NewsFrontpageHelper::truncate($item0->title, (int)$params->get('big_item_title_max_characters'));?>
		</a>
	</div>
<?php }?>

<?php if( (int)$params->get('big_item_datetime_display') ){ ?>
	<div class="big-item-datetime">
		<?php echo JHtml::date($item0->created, 'd F Y'); ?>
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
			<?php echo $params->get('item_readmore_text', 'read more'); ?>
		</a>		
	</div>
<?php }?>
</div>
