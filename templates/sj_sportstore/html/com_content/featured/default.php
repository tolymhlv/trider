<?php
/**
 * @version		$Id: default.php 20985 2011-03-17 18:34:35Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
if(!defined('YT_FRAMEWORK')){
	throw new Exception(JText::_('INSTALL_YT_PLUGIN'));
}
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');
$leading_or_intro = '';

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<?php 
$doc = JFactory::getDocument();
$app =& JFactory::getApplication();
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
//JLoader::register( 'TemplateParams', JPATH_THEMES . DS . $app->getTemplate() . DS . 'includes'. DS . 'params.class.php');
//$templateParams = new TemplateParams($this);
if($templateParams->get('includeLazyload')==1){
?>
	<script src="<?php echo JURI::base().'templates/'.$app->getTemplate().'/js/jquery.lazyload.js'; ?>" type="text/javascript"></script>
    <script type="text/javascript">
         jQuery(document).ready(function($){  
			 $("#yt_component img").lazyload({ 
				effect : "fadeIn",
				effect_speed: 1500,
				/*container: "#yt_component",*/
				load: function(){
					$(this).css("visibility", "visible"); 
					$(this).removeAttr("data-original");
				}
			});
        });  
    </script>
<?php }
$doc->addStyleDeclaration('
.image-content.leading img{
	width:'.$templateParams->get('leading_width', '200').'px; 
	height:'.$templateParams->get('leading_height', '200').'px;
}
.image-content.intro img{
	width:'.$templateParams->get('intro_width', '200').'px; 
	height:'.$templateParams->get('intro_height', '200').'px;
}
');
?>
<div class="blog-featured<?php echo $this->pageclass_sfx;?>">
<?php if ( $this->params->get('show_page_heading')!=0) : ?>
	<h1 class="componentheading">
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>

<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading row-fluid">
	<?php $leadingcol=(count($this->lead_items)); ?>
	<?php foreach ($this->lead_items as &$item) : ?>
		<div class="item span<?php echo round((12 / $leadingcol));?> leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
			<?php
				$this->item = &$item;
				echo $this->loadTemplate('item');
			?>
		</div>
		<?php
			$leadingcount++;
		?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php
	$introcount=(count($this->intro_items));
	$counter=0;
?>
<?php if (!empty($this->intro_items)) : ?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>

	<?php
		$key= ($key-$leadingcount)+1;
		$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
		$row = $counter / $this->columns ;

		if ($rowcount==1) : ?>

		<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row ; ?> row-fluid">
		<?php endif; ?>
		<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished"' : null; ?> span<?php echo round((12 / $this->columns));?>">
			<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
			?>
		</div>
		<?php $counter++; ?>
		<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
		</div>
		<?php endif; ?>
		
	<?php endforeach; ?>
<?php endif; ?>

<?php if (!empty($this->link_items)) : ?>
	<div class="items-more">
	<?php echo $this->loadTemplate('links'); ?>
	</div>
<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php  endif; ?>
	</div>
<?php endif; ?>

</div>
