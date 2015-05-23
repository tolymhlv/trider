<?php
/**
 * @package Sj Categories Slider for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

JHtml::stylesheet('templates/' . JFactory::getApplication()->getTemplate().'/html/mod_sj_js_categories_slider/slider.css');

if( !defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1" ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}
JHtml::script('modules/'.$module->module.'/assets/js/slider.js');

ImageHelper::setDefault($params);
$options = $params->toObject();
$tag_id ='categories_slider_'.rand().time();
$big_image_config=array(
	'type'			=> $params->get('imgcfgcat_type'),
	'width' 		=> $params->get('imgcfgcat_width'),
	'height' 		=> $params->get('imgcfgcat_height'),
	'quality' 		=> 90,
	'function' 		=> ($params->get('imgcfgcat_function') == 'none')?null:'resize',
	'function_mode' => ($params->get('imgcfgcat_function') == 'none')?null:substr($params->get('imgcfgcat_function'), 7),
	'transparency'  => $params->get('imgcfgcat_transparency', 1)?true:false,
	'background' 	=> $params->get('imgcfgcat_background') );
	
foreach($list as $item){
	//$img = JsSliderHelper::getJSCImage($item, $params,'imgcfgcat');
	//var_dump($img);
}
	
if(!empty($list)){?>
	<?php if(!empty($options->pretext)) { ?>
		<div class="pre-text"><?php echo $options->pretext; ?></div>
	<?php } ?>
	<div id="<?php echo $tag_id; ?>" class="container-slider" style=" <?php if( $options->anchor == "bottom" ){ echo "margin-bottom:40px;"; }?>">
			<div class="page-title"><?php echo $options->slider_title_text;?></div>
			<?php if($options->anchor =="top"){?>
			<?php if($options->button_display == 1){?>
			<div class="page-button <?php echo $options->anchor;?> <?php echo $options->control;?>">
				<ul class="control-button preload">
					<li class="preview">Prev</li>
					<li class="next">Next</li>
				</ul>		
			</div>
			<?php }}?>
	
		<div class="slider not-js cols-6 <?php echo $options->deviceclass_sfx; ?>">
			<div class="vpo-wrap">
				<div class="vp">
					<div class="vpi-wrap">
					<?php foreach($list as $item){ //var_dump($item); ?>
						<div class="item">
							<div class="item-wrap">
								<div class="item-img item-height">
									<div class="item-img-info">
										<a href="<?php echo $item->link;?>" title="<?php echo $item->name; ?>" <?php echo JsSliderHelper::parseTarget($params->get('target'));?>>
											<?php $img = JsSliderHelper::getJSCImage($item, $params,'imgcfgcat');
	    										echo JsSliderHelper::imageTag($img,$big_image_config);?>
										</a>
									</div>
								</div>
								<div class="item-info <?php if( $options->theme == "theme2" ){ echo "item-spotlight"; }?> ">
									<div class="item-inner">
									<?php if( (int)$params->get('cat_title_display',1) ){?>
										<div class="item-title">
											<a href="<?php echo $item->link;?>" title="<?php echo $item->name; ?>" <?php echo JsSliderHelper::parseTarget($params->get('target'));?>>
												<?php echo JsSliderHelper::truncate($item->name,$params->get('category_title_max_characs',25));?>
											</a>
										</div>
									<?php } ?>
										<div class="item-content">
											<?php 	if((int)$params->get('cat_desc_display',1)) { ?>
											<div class="item-des">
												<?php echo JsSliderHelper::truncate($item->_description,$params->get('category_desc_max_characs',100));?>									
											</div>
											<?php }?>	
											<?php if( (int)$params->get('item_readmore_display',1) ){?>
											<div class="item-read">
												<a href="<?php echo $item->link;?>" title="<?php echo $item->name; ?>" <?php echo JsSliderHelper::parseTarget($params->get('target'));?>>
													<?php echo $params->get('item_readmore_text','read more'); ?>
												</a>
											</div>	
											<?php }?>							
										</div>	
										<?php if( $options->theme == "theme2" ){
											if( (int)$params->get('cat_desc_display',1) || (int)$params->get('item_readmore_display',1) || (int)$params->get('item_readmore_display',1)  ){?>
											<div class="item-bg"></div>				
											<?php }
										}?>
									</div>
								</div>						
							</div>
						</div>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
		
		<?php if($options->anchor !="top"){?>
			<?php if($options->button_display == 1){?>
			<div class="page-button <?php echo $options->anchor;?> <?php echo $options->control;?>">
				<ul class="control-button preload">
					<li class="preview">Prev</li>
					<li class="next">Next</li>
				</ul>		
			</div>
		<?php }}?>
		
	</div>
	<?php if(!empty($options->posttext)) {  ?>
		<div class="post-text"><?php echo $options->posttext; ?></div>
	<?php } ?>
<?php }else {echo JText::_('Has no content to show!');}?>

<script type="text/javascript">
//<![CDATA[
    jQuery(document).ready(function($){
		;(function(element){
			var $element = $(element);
			 $('.slider', $element).responsiver({
				interval: <?php echo $options->delay;?>,
				speed: <?php echo $options->duration;?>,
				start: <?php echo $options->start -1;?>,
				step: <?php echo $options->scroll;?>,
				circular: true,
				preload: true,
				fx: 'slide',
				pause: 'hover',
				control:{
					prev: '#<?php echo $tag_id;?> .control-button li[class="preview"]',
					next: '#<?php echo $tag_id;?> .control-button li[class="next"]'
				},
				getColumns: function(element){
					var match = $(element).attr('class').match(/cols-(\d+)/);
					if (match[1]){
						var column = parseInt(match[1]);
					} else {
						var column = 1;
					}
					if (!column) column = 1;
					return column;
				}          
			});
			$('.control-button',$element).removeClass('preload');
		})('#<?php echo $tag_id; ?>');
    });
//]]>
</script>



