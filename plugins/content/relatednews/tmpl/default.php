<?php
/**
 * @package Content - Related News
 * @version 1.7.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
ImageHelper::setDefault($_params);
//var_dump($article_id); die("abc");
if (count($items)){
	if ((int)$this->params->get('usecss', 1)){
		$css_url = JURI::root() . 'plugins/content/relatednews/assets/css/relatednews.css';
		$document = &JFactory::getDocument();
		$document->addStyleSheet($css_url);
	}
	if ($this->params->get('title')){
		echo '<h3 class="related-title">';
		echo $this->params->get('title');
		echo '</h3>';
	}
	echo '<ul class="related-items row-fluid">';
	$cnn = 1;
	$class_item = 'item-odd';
	foreach ($items as $id => $item) { 
		//print_r($item);
		
		if($item->id != $article_id){?>			
			<?php if($cnn%2 == 0){ $class_item ='item-even';} else { $class_item = 'item-odd';} ?>
			<?php if($cnn > (count($items)- $this->params->get('columns'))){
				$class_item.=" line-none";
			} ?>
			<li class="<?php echo $class_item; ?>" style="width:<?php echo round((100/$this->params->get('columns'))); ?>%; float:left;">
			<div class="relate-item">
			<?php
			$cnn ++;						
			if ((int)$this->params->get('item_image_display', 1)){ ?>
				<div class="related-item-img">
					<a href="<?php echo $item->link; ?>">				
					<?php $img = BaseHelper::getArticleImage($item, $_params);
	    				  echo BaseHelper::imageTag($img);?>
					</a>
				<?php //Hover item images ?>
					<div class="hover-zoom">
						<a class="img-zoom" data-rel="prettyPhoto"  title="<?php echo $item->title; ?>" href="<?php echo $img['src']; ?>"><i class="icon-plus-sign-alt"></i></a>				
					</div>				
				</div>
			<?php }?>
			
			<?php
			if ((int)$_params->get('item_category_display', 1) == 1): ?>
				<div class="related-item-category"><?php echo $item->category_title; ?></div>
			<?php
			endif;
			?>
				<h3 class="related-item-title">
					<a href="<?php echo $item->link; ?>" <?php echo BaseHelper::parseTarget($_params->get('item_link_target'));?> >
					<?php echo str_replace("...","", $item->title); ?>
					</a>
				</h3>
				
			<?php
			if ((int)$_params->get('item_date_display', 1) == 2): ?>
				<span class="related-item-date"><?php echo JHtml::date($item->created, 'Y-m-d'); ?></span>
			<?php
			endif;
			?>
			<?php
			if ((int)$_params->get('item_introtext_display', 1) == 1): ?>
				<div class="related-item-introtext"><?php //echo substr($item->introtext,0,(int)$_params->get('item_introtext_max_characs'));
				echo str_replace("...","",JHtml::_('string.truncate', $item->introtext, (int)trim($_params->get('item_introtext_max_characs'))));
				 ?></div>
			<?php
			endif;
			?>
			</div>
			</li>
	<?php
	}}
	echo '</ul>';
}

?>