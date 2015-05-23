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

JHtml::stylesheet('modules/'.$module->module.'/assets/css/sj-frontpage.css');
if (!defined('SMART_JQUERY') && ( int ) $params->get ( 'include_jquery', '1' )) {
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
}

if($params->get('theme') == 'theme4') {
	JHtml::script('modules/'.$module->module.'/assets/js/jquery.sj_frontpage_accordion.js');
}

ImageHelper::setDefault($params);

$uniqueid	= 'fronpage_'.rand().time();
$wrap_max_size = (int)$params->get('module_width', 560) ? 'style="width:' . (int)$params->get('module_width', 560) . 'px;"': '';
$item0 = array_shift($list);
$items = &$list;
$onstart = $params->get('onstart_t4',1);
$onstart = ($onstart >count($items) || $onstart <= 0 )?1:$onstart;
$theme = $params->get('theme','theme1');
$small_image_config=array(
		'type'			=> $params->get('imgcfgnav_type'),
		'width' 		=> $params->get('imgcfgnav_width'),
		'height' 		=> $params->get('imgcfgnav_height'),
		'quality' 		=> 90,
		'function' 		=> ($params->get('imgcfgnav_function') == 'none')?null:'resize',
		'function_mode' => ($params->get('imgcfgnav_function') == 'none')?null:substr($params->get('imgcfgnav_function'), 7),
		'transparency'  => $params->get('imgcfgnav_transparency', 1)?true:false,
		'background' 	=> $params->get('imgcfgnav_background')
);
?>

<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready(function($){
		;(function(element){
			var $element = $(element);
			var $container = $('.small-items-container', $element);
			var $children = $container.children();
			var $loadding = $('.fp-loading',$element);
			$loadding.remove();
			$element.removeClass('pre-load');
			<?php if($theme == 'theme4') { ?>
				_fpaccrodion();
			<?php } ?>
			function _fpaccrodion(){	
				$container.sj_frontpage_accordion({
					items: '.small-item-wrap',			
					heading: '.small-item-title',
					content: '.small-item-content',
					active_class: 'item-active',
					event: '<?php echo $params->get('event_t4', 'mouseenter'); ?>',
					delay: <?php echo (int)$params->get('delay_t4', 200); ?>,
					duration: <?php echo (int)$params->get('duration_t4', 200); ?>,
					active: <?php echo (int)$onstart; ?>
				});
				onRezie  = function(){
					$children.each(function(e){
						if($(this).hasClass('item-active')){
							$('.small-item-content',$(this)).css({height:'auto'});
						}
					});
				}
				$(window).load(onRezie);
				$(window).resize(onRezie);
			}
			
		})('#<?php echo $uniqueid; ?>')	
	});
//]]>
</script>

<?php 
if ($params->get('pretext') !=''){?>
	<div class="pre-text"><?php echo $params->get('pretext'); ?></div>
<?php } ?>
	<div id="<?php echo $uniqueid; ?>" class="frontpage <?php echo $theme; ?> pre-load">
		<div class="fp-loading"></div>
		<?php include JModuleHelper::getLayoutPath($module->module, $layout.'_'.$theme); ?>
	</div>
<?php 
	if ($params->get('posttext') !=''){?>
	<div class="post-text"><?php echo $params->get('posttext'); ?></div>
<?php } ?>

