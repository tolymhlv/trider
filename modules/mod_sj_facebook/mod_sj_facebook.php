<?php
/**
 * @package Sj Facebook
* @version 2.5
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @copyright (c) 2012 YouTech Company. All Rights Reserved.
* @author YouTech Company http://www.smartaddons.com
*
*/
defined('_JEXEC') or die;

	require_once (dirname(__FILE__).'/helper.php');
    jimport("joomla.filesystem.folder");
    jimport("joomla.filesystem.file");
    modSjFacebookHelper::include_css('sjfacebook/sjfacebook.css');    
    
/*-- Process---*/    

    $sj_option = trim($params->get('fb_options'));
    $intro = $params->get('intro_text','');
    $footer = $params->get('footer_text','');
    $styletheme = trim($params->get('styletheme', 'default'));
    
    if( $sj_option == 'fb_activity_feed' ){
        $sj_facebook_html = modSjFacebookHelper::getActivityFeed($params);
     } elseif( $sj_option == 'fb_like_box' ){
        $sj_facebook_html = modSjFacebookHelper::getFanbox($params);
     } elseif( $sj_option == 'fb_recommendations' ){
        $sj_facebook_html = modSjFacebookHelper::getRecommendations($params);
    }
    $path = JModuleHelper::getLayoutPath( 'mod_sj_facebook' );
    if ( file_exists($path) ){
    	require($path);
    }
?>
