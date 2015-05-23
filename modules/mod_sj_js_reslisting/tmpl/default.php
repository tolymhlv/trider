<?php
/**
 * @package Sj Responsive Listing for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

JHtml::stylesheet('modules/'.$module->module.'/assets/css/isotope.css');
JHtml::stylesheet('modules/'.$module->module.'/assets/css/sj-reslisting.css');
if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

JHtml::script('modules/'.$module->module.'/assets/js/jquery.isotope.js');

$instance	= rand().time();
$tag_id = 'sj_responsive_listing_'.rand().time();
?>
<!--[if lt IE 9]><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing  msie lt-ie9 pre-load"><![endif]-->
<!--[if IE 9]><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing  msie pre-load"><![endif]-->
<!--[if gt IE 9]><!--><div id="<?php echo $tag_id; ?>" class="sj-responsive-listing pre-load"><!--<![endif]-->
   <?php if($params->get('pretext')!= null){ ?>
		<div class="respl-pretext">
			<?php echo $params->get('pretext');?>
		</div>
   <?php }?>
   <div class="respl-loading"></div>
	<div class="respl-wrap cf">
		<div class="respl-header">
			<?php $maxwidth = ($params->get('sort_byform_display',1)== 0 && $params->get('layout_select_display',1) == 0 )?'max-width:100%':'';?>
			<div class="respl-categories" data-label="<?php echo JText::_('CATEOGRY_LABEL') ?>" style="<?php echo $maxwidth ?>"  >
				<div class="respl-cats-wrap respl-group"  >
					<div class="cats-curr respl-btn dropdown-toggle" data-toggle="dropdown">
						<span class="sort-curr" data-filter_value=""><?php echo JText::_('ALL_LABEL')?></span>
						<span class="sort-arrow respl-arrow"></span>
					</div>
					<ul class="respl-cats respl-dropdown-menu respl-option" data-option-key="filter">
						<?php foreach($list['categories'] as $items){ ?>
							<li class="respl-cat <?php echo (isset($items->sel))?$items->sel:''; ?>" data-value="<?php echo $items->category_id; ?>">
								<a href="#<?php echo $tag_id; ?>" data-rl_value="<?php echo ($items->category_id == '*')?'*':'.category-'.$items->category_id; ?>" class="<?php echo ($params->get('count_items_display',0) == 0)?'respl-count':''; ?>" data-count="<?php echo $items->count; ?>">
									<?php echo ($items->name == JText::_('ALL_LABEL'))?JText::_('ALL_LABEL'):JSResponsiveListingHelper::truncate($items->name, $params->get('tal_max_characters')) ?>
								</a>
							</li>
						<?php }?>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div class="respl-sort-view" >
				<?php if($params->get('sort_byform_display',1) == 1){
					$value_curr ='';
					$data_curr =  '';
					$select_sort =   trim($params->get('source_order_by','title'));
					switch($select_sort){
						case 'name':
							 $value_curr = 'name';
							 $data_curr = JText::_('PRODUCT_TITLE');
							 break;	
						case 'prod.product_price':
							 $value_curr = 'product_price';
							 $data_curr = JText::_('PRODUCT_PRICE');
							 break;
						case 'prod.reviews_count':
							$value_curr = 'reviews_count';
							$data_curr = JText::_('REVIEWS_COUNT');
							break;
						case 'prod.hits':
							$value_curr = 'hits';
							$data_curr = JText::_('PRODUCT_HITS');
							break;
						case 'prod.product_id':
							$value_curr = 'product_id';
							$data_curr = JText::_('PRODUCT_ID');
							break;
						case 'prod.product_date_added':
							$value_curr = 'product_date_added';
							$data_curr = JText::_('PRODUCT_DATE_ADDED');
							break;
						case 'prod.date_modify':
							$value_curr = 'date_modify';
							$data_curr = JText::_('DATE_MODIFY');
							break;
						case 'prod.average_rating':
							$value_curr = 'average_rating';
							$data_curr = JText::_('AVERAGE_RATING');
							break;	
						case 'random':
							$value_curr = 'random';
							$data_curr = JText::_('RANDOM_LABEL');
							break;
						default:
							$value_curr = 'name';
							$data_curr = JText::_('PRODUCT_TITLE');
							break;
					}
					
					$oderbys  = $params->get('itemsOrdering_display');
					if(!empty($oderbys)) {
							$value_first = $value_curr;
							$data_first = $data_curr;
						if(in_array($value_curr,$oderbys)) {
							 $value_first = $value_curr;
							 $data_first = $data_curr;
						} else {
							$value_first = $oderbys[0];
							if($oderbys[0] == 'name'){
								$data_first = JText::_('PRODUCT_TITLE');
							}elseif($oderbys[0] == 'prod.product_price'){
								$data_first = JText::_('PRODUCT_PRICE');
							}else if($oderbys[0] == 'prod.reviews_count' ){
								$data_first = JText::_('REVIEWS_COUNT');
							}else if($oderbys[0] == 'prod.hits' ){
								$data_first = JText::_('PRODUCT_HITS');
							}else if($oderbys[0] == 'prod.product_id' ){
								$data_first = JText::_('PRODUCT_ID');
							}else if($oderbys[0] == 'prod.product_date_added' ){
								$data_first = JText::_('PRODUCT_DATE_ADDED');
							}else if($oderbys[0] == 'prod.date_modify' ){
								$data_first = JText::_('DATE_MODIFY');
							}else if($oderbys[0] == 'prod.average_rating' ){
								$data_first = JText::_('AVERAGE_RATING');
							}else if($oderbys[0] == 'random' ){
								$data_first = JText::_('RANDOM_LABEL');
							}
						}
					
						?>
							<div class="respl-sort" data-label="<?php echo JText::_('SORT_BY_LABEL')?>" >
								<div class="sort-wrap respl-group">
									<div class="sort-inner respl-btn dropdown-toggle"  data-curr_value="<?php echo  $value_first; ?>" data-curr="<?php echo $data_first ?>">
										<span class="sort-arrow respl-arrow"></span>
									</div>
									<ul class="sort-select respl-dropdown-menu respl-option" data-option-key="sortBy">
										<?php foreach($oderbys as $key => $oder){
											if($oder == 'name') { ?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="name"><?php echo JText::_('PRODUCT_TITLE')?></a></li>
											<?php } 
											elseif($oder == 'prod.product_price') { ?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="product_price"><?php echo JText::_('PRODUCT_PRICE')?></a></li>
											<?php } 
											elseif($oder == 'prod.reviews_count') {
											?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="reviews_count"><?php echo JText::_('REVIEWS_COUNT')?></a></li>
											<?php } 
											elseif($oder == 'prod.hits') {
											?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="hits"><?php echo JText::_('PRODUCT_HITS')?></a></li>
											<?php }
											elseif($oder == 'prod.product_id') {
											?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="product_id"><?php echo JText::_('PRODUCT_ID')?></a></li>
											<?php }
											elseif($oder == 'prod.product_date_added') { ?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="product_date_added"><?php echo JText::_('PRODUCT_DATE_ADDED')?></a></li>
											<?php }
											elseif($oder == 'prod.date_modify') { 
											?>
												<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="date_modify"><?php echo JText::_('DATE_MODIFY')?></a></li>
											<?php }
											elseif($oder == 'prod.average_rating') { 
											?>
											<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="average_rating"><?php echo JText::_('AVERAGE_RATING')?></a></li>
											<?php }
										}	?>	
										<li ><a href="#<?php echo $tag_id; ?>" data-rl_value="random"><?php echo JText::_('RANDOM_LABEL')?></a></li>
									</ul>
								</div>
							</div>
				<?php }
				}?>
				<?php if($params->get('layout_select_display',1) == 1) {?>
				<ul class="respl-view respl-option" data-label="<?php echo JText::_('VIEW_LABEL')?>" data-option-key="layoutMode">
					<li class="view-grid <?php echo ($params->get('default_view',1) == 1)?'sel':''?>">
						<a href="#<?php echo $tag_id; ?>" data-rl_value="fitRows">
						</a>
					</li>
					<li class="view-list <?php echo ($params->get('default_view',1) == 0)?'sel':''?>">
						<a href="#<?php echo $tag_id; ?>" data-rl_value="straightDown">
						</a>
					</li>
				</ul>
				<?php }?>
			</div>
		</div>
		
		<?php $class_respl= 'respl01-'.$params->get('nb-column1',6).' respl02-'.$params->get('nb-column2',4).' respl03-'.$params->get('nb-column3',2).' respl04-'.$params->get('nb-column4',1) ?>
		
		<div class="respl-items <?php echo $class_respl?> <?php echo ($params->get('default_view',1) == 1)?'grid':'list'?> cf  module-<?php echo $module->id?>">
			<?php require JModuleHelper::getLayoutPath($module->module, $layout.'_items'); ?>
		</div>
		
		<?php
			$classloaded = ($params->get('source_limit', 2) >= JSResponsiveListingHelper::$total || $params->get('source_limit', 2)== 0 )?'loaded':'';
		?>
		
		<div class="respl-loader respl-btn <?php echo $classloaded?>" >
			<a class="respl-button" href="#<?php echo $tag_id; ?>"  data-rl_allready="<?php echo JText::_('ALL_READY_LABEL');?>" data-rl_start="<?php echo $params->get('source_limit', 2)?>" data-rl_ajaxurl="<?php echo (string)JURI::getInstance(); ?>" data-rl_load="<?php echo $params->get('source_limit', 2)?>" data-rl_total="<?php echo JSResponsiveListingHelper::$total ?>" data-rl_moduleid="<?php echo $module->id; ?>">
				<?php if (!$classloaded){?>
				<span class="loader-image"></span>
				<?php } ?>
				<span class="loader-label" >
					<?php if ($classloaded){
						echo JText::_('ALL_READY_LABEL');
					} else { ?>
					<?php echo JText::_('LOAD_MORE_LABEL')?> (<span class="load-number" data-more="<?php echo $params->get('source_limit', 2)?>" data-total="<?php echo JSResponsiveListingHelper::$total - $params->get('source_limit', 2)?>">/</span>)
					<?php } ?>
				</span>
			</a>
		</div>
		<div class="clear"></div>
	</div>
	<?php if($params->get('posttext')!= ''){ ?>
		<div class="respl-posttext">
			<?php echo $params->get('posttext');?>
		</div>
    <?php }?>
</div>