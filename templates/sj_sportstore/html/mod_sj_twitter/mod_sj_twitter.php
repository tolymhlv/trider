<?php
/**
 * @package Sj Twitter
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');
$mainframe	= &JFactory::getApplication();
$document	= &JFactory::getDocument();

// Assign paths
$sitePath	= JPATH_SITE;
$siteUrl  	= substr(JURI::base(), 0, -1);
$document->addStyleSheet($siteUrl.'/modules/mod_sj_twitter/assets/css/twitter.css');

// Module parameters
	$theme = $params->get( 'theme' );
	//$width     = $params->get( 'width' );
	//$height       = $params->get( 'height' );
	$pretext         = $params->get( 'pretext' );
	$posttext        = $params->get( 'posttext' );
	$type            = $params->get( 'type' );
	$limit         = $params->get( 'limit' );
	$href           = $params->get( 'href' );
	$widgets_id         = $params->get( 'widgets_id' );
	//$keys_earch       = $params->get( 'key_search' );
	$footer_text       = $params->get( 'footer_text' );
if( $pretext != null ){ ?>
	<div class="sj-twitter-pre">
		<?php echo $pretext;?>			
	</div>
<?php }?>

	<a class="twitter-timeline" href="<?php echo $href;?>" data-widget-id="<?php echo $widgets_id;?>" data-tweet-limit="<?php echo $limit;?>" width="<?php //echo $width;?>" height="<?php //echo $height;?>" data-chrome="noscrollbar transparent" data-border-color="#cc0000" data-theme="<?php echo $theme;?>"></a>
	
	<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>
	
<?php if( $posttext != null ){?>
	<div class="sj-twitter-pos">
		<?php echo $posttext;?>			
	</div>
<?php }?>

