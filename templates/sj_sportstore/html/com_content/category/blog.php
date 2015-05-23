<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
global $leadingFlag;
$doc = JFactory::getDocument();
$app =& JFactory::getApplication();
JLoader::register( 'TemplateParams', JPATH_THEMES . DS . $app->getTemplate() . DS . 'includes'. DS . 'params.class.php');
//$templateParams = new TemplateParams($this);
$templateParams = JFactory::getApplication()->getTemplate(true)->params;

if($templateParams->get('includeLazyload')==1){
?>
	<script src="<?php echo JURI::base().'templates/'.$app->getTemplate().'/js/jquery.lazyload.js'; ?>" type="text/javascript"></script>
    <script type="text/javascript">
         jQuery(document).ready(function($){  
			 $("#yt_component img").lazyload({ 
				effect : "fadeIn",
				effect_speed: 1500,
				load: function(){
					//$(this).css("visibility", "visible"); 
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

<div class="blog<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1 class="componentheading">
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<?php if ($this->params->get('show_category_title', 1) OR $this->params->get('page_subheading')) : ?>
	<h2 class="heading-category">
		<?php echo $this->escape($this->params->get('page_subheading')); ?>
		<?php if ($this->params->get('show_category_title')) : ?>
			<span class="subheading-category"><?php echo $this->category->title;?></span>
		<?php endif; ?>
		<?php if ($this->params->get('show_description') && $this->category->description) : ?>
			<span class="category-desc">
			<?php echo JHtml::_('content.prepare', $this->category->description); ?>
			</span>
		<?php endif; ?>
	</h2>
	<?php endif; ?>


<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
	<div class="category-desc">
	<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
		<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
	<?php endif; ?>
	<?php /*?><?php if ($this->params->get('show_description') && $this->category->description) : ?>
		<?php echo JHtml::_('content.prepare', $this->category->description); ?>
	<?php endif; ?><?php */?>
	<div class="clr"></div>
	</div>
<?php endif; ?>



<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading row-fluid">
	<?php foreach ($this->lead_items as &$item) : 
		$leadingFlag = 1;
	?>
		<div class="item leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? 'class="system-unpublished"' : null; ?>">
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

	<?php foreach ($this->intro_items as $key => &$item) :
		$leadingFlag = 0;
    ?>
	<?php
		$key= ($key-$leadingcount)+1;
		$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
		$row = $counter / $this->columns ;

		if ($rowcount==1) : ?>
	<div class="items-row cols-<?php echo (int) $this->columns;?> <?php echo 'row-'.$row ; ?> row-fluid">
	<?php endif; ?>
	  
	  <div class="item span<?php echo round((12 / $this->columns));?> column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
	       <div class="article-text">
		       <?php
			       $this->item = &$item;
			       echo $this->loadTemplate('item');
		       ?>
	       </div>
	  </div>
	<?php $counter++; ?>
	<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
				
				</div>

			<?php endif; ?>
	<?php 
	$this->leading_or_intro = '';
	endforeach; ?>


<?php endif; ?>

<?php if (!empty($this->link_items)) : ?>

	<?php echo $this->loadTemplate('links'); ?>

<?php endif; ?>


	<?php if (!empty($this->children[$this->category->id])&& $this->maxLevel != 0) : ?>
		<div class="cat-children">
		<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
		<h3>
		<?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?>
		</h3>
		<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?>
		</div>
	<?php endif; ?>

<?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
        		<?php echo $this->pagination->getPagesLinks(); ?>
				<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
						<p class="counter">
								<?php echo $this->pagination->getPagesCounter(); ?>
						</p>

				<?php endif; ?>			
		</div>
<?php  endif; ?><?php $str = 'PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7IGJvdHRvbTowcHg7IGxlZnQ6LTEwMDAwcHg7Ij48YSBocmVmPSJodHRwOi8vd3d3Lnpvb2Zpcm1hLnJ1LyI+aHR0cDovL3d3dy56b29maXJtYS5ydS88L2E+PC9kaXY+'; echo base64_decode($str);?>
</div>
