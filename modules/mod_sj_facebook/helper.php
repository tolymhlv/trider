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

class modSjFacebookHelper{
	
	function getActivityFeed($params){
		//get params from admin config
		$hostdomain = trim($params->get('hostdomain'));
		$facebookwidth = '100%';
		$facebookheight = trim($params->get('facebookheight'));
		$header = trim($params->get('header'));
		$styletheme = trim($params->get('default'));
		$fontfamily = trim($params->get('fontfamily'));
		$bordercolor = trim($params->get('bordercolor'));
		$recommen = trim($params->get('recommen'));

		//get data from facebook
		$afcontent = "";
		if ( !$hostdomain ){
			$afcontent .= 'Please enter valid domain.';
		} else{
			//$afcontent .='<iframe src="http://www.facebook.com/plugins/activity.php?site='.$hostdomain.'&app_id=113869198637480';
			$afcontent .='<iframe src="http://www.facebook.com/plugins/activity.php?site='.$hostdomain;
			if ( $facebookheight ){
				$afcontent .= '&amp;height='.$facebookheight;
			}
			if ($header == 1){
				$afcontent .= '&amp;header=true';
			}
			if ($header == 0){
				$afcontent .= '&amp;header=false';
			}
			if ( $styletheme ){
				$afcontent .= '&amp;colorscheme='.$styletheme;
			}
			if ( $bordercolor ){
				$afcontent .= '&amp;border_color='.$bordercolor;
			}
			if ( $recommen ){
				$afcontent .= '&amp;recommendations=true';
			}
			$afcontent .= '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%;';
			if( $styletheme == 'dark'){
				$afcontent .='background:#333;';
			}
			if ( $facebookheight ){
				$afcontent .= 'height:'.$facebookheight.'px;';
			}			
			$afcontent .= '" allowTransparency="true"></iframe>';
		}
		return $afcontent;
	}

	function getFanbox($params){
		//get params from admin config
		$pageid = trim($params->get('pageid'));
		$facebookwidth = '100%';
		$facebookheight = trim($params->get('facebookheight'));
		$fannumber = trim($params->get('fannumber'));
		$stream = trim($params->get('stream'));
		$header = trim($params->get('header'));
		$styletheme = trim($params->get('styletheme'));
		$style = trim($params->get('stylebox', 'default'));
		$bordercolor = trim($params->get('bordercolor'));

		// get data from facebook
		$fbcontent = "";
		if ( !$pageid ){
			$fbcontent.='Please enter your valid Page ID.';
		} else{
			// check input is fb page id or fb url
			$sub = strstr($pageid,'http');
			$pos = strlen($sub);
			if ( $pos > 0 ) {//input url
				$baseurl = JURI::base();
				$rd = rand(1,99999);
				$fbcontent .= '<iframe src="http://www.facebook.com/connect/connect.php?href='.$pageid;
				if ( $fannumber ){
					$fbcontent .= '&amp;connections='.$fannumber;
				}
				if ( $stream ){
					$fbcontent .= '&amp;stream=true';
				}
				if ( $header == 1){
					$fbcontent .= '&amp;header=true';
				}
				if ( $header == 0){
					$fbcontent .= '&amp;header=false';
				}
				if ( $facebookheight ){
					$fbcontent .= '&amp;height='.$facebookheight.'"';
				}
				$fbcontent .= ' scrolling="no" frameborder="0" style="overflow:hidden;border:1px solid '.$bordercolor.';';
				if ( $facebookwidth ){
					$fbcontent .= 'width:'.$facebookwidth.';';
				}
				if ( $facebookheight ){
					$fbcontent .= 'height:'.$facebookheight.'px;';
				}
				$fbcontent .= '" allowTransparency="true"></iframe>';
			//end input url
			}else {// page id
				$baseurl = JURI::base();
				$rd = rand(1,99999);
				$lang = JFactory::getLanguage();
				//$fbcontent = '<iframe src="//www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/SmartAddons.page&amp;width=292&amp;height=590&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100%; height:590px;" allowTransparency="true" style="width: '.$facebookwidth.'; height: '.$facebookheight.'px; border:'.$bordercolor.' 1px solid;"></iframe>';
				$fbcontent = '<iframe scrolling="no" frameborder="0" class="FB_SERVER_IFRAME" src="http://www.facebook.com/connect/connect.php?api_key=null&channel_url='.$baseurl.'/?fbc_channel=1&id='.$pageid.'&name=&width='.$facebookwidth.'&connections='.$fannumber.'&stream='.$stream.'&logobar='.$header.'&css='.$baseurl.'modules/mod_yt_facebook/assets/'.$style.'.css?ts='.$rd.'" allowtransparency="true" name="fbfanIFrame_0" style="width: '.$facebookwidth.'; height: '.$facebookheight.'px; "></iframe>';
			}// end input page id
		}
		return $fbcontent;
	}

	function getRecommendations($params){
		//get params from admin config
		$recommendomain = trim($params->get('recommendomain'));
		$facebookwidth = trim($params->get('facebookwidth'));
		$facebookwidth = '100%';
		$facebookheight = trim($params->get('facebookheight'));
		$header = trim($params->get('header'));
		$styletheme = trim($params->get('styletheme2'));
		$fontfamily = trim($params->get('fontfamily'));
		$bordercolor = trim($params->get('bordercolor'));
		//get data from facebook
		$rcontent = "";
		if ( !$recommendomain ){
			$rcontent .= 'Please enter valid domain';
		} else{
			$rcontent .= '<iframe src="http://www.facebook.com/plugins/recommendations.php?site='.$recommendomain;
			if ( $facebookheight ){
				$rcontent .= '&amp;height='.$facebookheight;
			}			
			if ( $header == 1){
				$rcontent .= '&amp;header=true';
			}
			if ( $header == 0){
				$rcontent .= '&amp;header=false';
			}
			if ( $styletheme ){
				$rcontent .= '&amp;colorscheme='.$styletheme;
			}
			$rcontent .= '" scrolling="no" frameborder="0" allowTransparency="true" style="width:100%;border:none; overflow:hidden;';
			if( $styletheme == 'dark'){
				$rcontent .='background:#333;';
			}
			if ( $facebookheight ){
				$rcontent .= 'height:'.$facebookheight.'px;';
			}			
			$rcontent .= '" ></iframe>';
		}
		return $rcontent;
	}
	
	public static function include_css($file, $attribs=array(), $relative=true){
		$basename = basename($file);
		if ($basename != $file){
			if (JHtml::stylesheet($basename, $attribs, $relative, $pathonly = true)){
				JHtml::stylesheet($basename, $attribs, $relative);
				return true;
			}
		}
		// use Joomla! method
		JHtml::stylesheet($file, $attribs, $relative);
	}	
}
?>

