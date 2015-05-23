<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Dmitry Stashenko
* @website http://nevigen.com/
* @email support@nevigen.com
* @copyright Copyright © Nevigen.com. All rights reserved.
* @license Proprietary. Copyrighted Commercial Software
* @license agreement http://nevigen.com/license-agreement.html
**/

defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_jshopping/lib/factory.php';
require_once JPATH_SITE.'/components/com_jshopping/lib/functions.php';

class plgJshoppingproductsUnijax_Filter extends JPlugin {

    var $enable = false;
    var $type = null;
    var $adv_query = null;
    var $advQuery = null;
    var $modParams = null;
    var $subCategoryies = array();

	function onBeforeLoadProductList(){
		$module = JModuleHelper::getModule('mod_jshopping_unijax_filter');
		if ( !$module->id ) {
			return false;
		}
		$this->modParams = json_decode($module->params);

		$this->app = JFactory::getApplication();
		if ( $this->app->input->get('format', 'html') != 'html' ) {
			return false;
		}
		
		if ( !$this->modParams->reset_limit && !$this->modParams->reset_filter_options ) {
			return;
		}
		$controller = $this->app->input->getCmd('controller');
		$task = $this->app->input->getCmd('task');
		$category_id = $this->app->input->getInt('category_id');
		$manufacturer_id = $this->app->input->getInt('manufacturer_id');
		$vendor_id = $this->app->input->getInt('vendor_id');
		if ( $controller == 'category' && $category_id ) {
			$context = 'jshoping.list.front.product';
			$contextfilter = 'jshoping.list.front.product.cat.'.$category_id;
		} else if ( $controller == 'manufacturer' && $manufacturer_id ) {
			$context = 'jshoping.manufacturlist.front.product';
			$contextfilter = 'jshoping.list.front.product.manf.'.$manufacturer_id;
		} else if ( $controller == 'vendor' && $vendor_id ) {
			$context = 'jshoping.vendor.front.product';
			$contextfilter = 'jshoping.list.front.product.vendor.'.$vendor_id;
		} else if ( $controller == 'products' && ($task == '' || $task == 'display') ) {
			$context = 'jshoping.alllist.front.product';
			$contextfilter = 'jshoping.list.front.product.fulllist';
		} else {
			return;
		}

		$old_contextfilter = $this->app->getUserState('unijax_old_contextfilter');
		if ( $contextfilter == $old_contextfilter ) {
			return;
		}
		$old_context == $this->app->getUserState('unijax_old_context');
		
		if ( $this->modParams->reset_limit ) {
			$this->app->setUserState( $old_context.'limit', 0);
		}
		
		if ( $this->modParams->reset_filter_options ) {
			$this->app->setUserState( $old_contextfilter.'pricefrom', null);
			$this->app->setUserState( $old_contextfilter.'priceto', null);
			$this->app->setUserState( $old_contextfilter.'categorys', null);
			$this->app->setUserState( $old_contextfilter.'manufacturers', null);
			$this->app->setUserState( $old_contextfilter.'vendors', null);
			$this->app->setUserState( $old_contextfilter.'characteristics', null);
			$this->app->setUserState( $old_contextfilter.'d_attributes', null);
			$this->app->setUserState( $old_contextfilter.'attributes', null);
			$this->app->setUserState( $old_contextfilter.'labels', null);
			$this->app->setUserState( $old_contextfilter.'delivery_times', null);
			$this->app->setUserState( $old_contextfilter.'photo', null);
			$this->app->setUserState( $old_contextfilter.'availability', null);
			$this->app->setUserState( $old_contextfilter.'sales', null);
			$this->app->setUserState( $old_contextfilter.'additional_prices', null);
			$this->app->setUserState( $old_contextfilter.'reviews', null);
		}
		
		$this->app->setUserState('unijax_old_context', $context);
		$this->app->setUserState('unijax_old_contextfilter', $contextfilter);
	}

	function _filterAllowValue($data){
		$this->allProductExtraField = JSFactory::getAllProductExtraField();
		if (is_array($data)){
			foreach($data as $key=>$value) {
				$key = intval($key);
				if (is_array($value)){
					foreach($value as $k=>$v){
						$k = intval($k);
						$v = urldecode($v);
						if (($this->allProductExtraField[$key]->type == 1 && $v != '') || $v) {
							$data[$key][$k] = "'".$this->db->escape($v)."'";
						} else {
							unset($data[$key][$k]);
						}
					}
				}
			}
		}
		return $data;
	}

	function _getExtendedQuery($restype, $adv_result, $adv_from, $adv_query, $order_query, $filters) {
		if ( $this->type != 'category' && $this->type != 'manufacturer' && $this->type != 'vendor' && $this->type != 'all_products' ) {
			return false;
		} else if ( $this->adv_query ) {
			return true;
		}

		if ( !$this->modParams || $this->app->input->get('format', 'html') != 'html' ) {
			return false;
		}

		require_once JPATH_SITE.'/modules/mod_jshopping_unijax_filter/helper.php';

		$this->adv_query = '';
		$this->db = JFactory::getDBO();
		$this->user = JFactory::getUser();
		if ($this->user->id){
			$this->userShop = JSFactory::getUserShop();
		}else{
			$this->userShop = JSFactory::getUserShopGuest();
		}
		$this->jshopConfig = JSFactory::getConfig();
		$GLOBALS['_1873331009_']=Array('round','roun' .'d','round','r' .'ound','rou' .'nd','round','round','round','rou' .'n' .'d','' .'rou' .'nd','round','round','' .'round','round','roun' .'d','round','ro' .'u' .'nd','' .'r' .'ound','rou' .'nd','' .'ro' .'u' .'nd','round','rou' .'nd','' .'round','round','' .'round','' .'roun' .'d','r' .'oun' .'d','round','roun' .'d','' .'round','roun' .'d','round','ro' .'und','round','round','r' .'o' .'un' .'d','roun' .'d','round','round','ro' .'und','' .'ro' .'un' .'d','r' .'o' .'und','rou' .'n' .'d','round','' .'round','' .'r' .'ound','round','rou' .'nd','round','r' .'ound','roun' .'d','r' .'ou' .'n' .'d','round','round','round','' .'roun' .'d','roun' .'d','r' .'ound','rou' .'nd','round','roun' .'d','rou' .'nd','' .'r' .'ound','round','' .'r' .'ound','ro' .'und','ro' .'un' .'d','round','r' .'ou' .'nd','round','' .'ro' .'u' .'nd','' .'ro' .'un' .'d','round','ro' .'und','roun' .'d','roun' .'d','r' .'oun' .'d','' .'roun' .'d','round','' .'ro' .'und','r' .'ound','round','' .'r' .'ound','round','' .'rou' .'n' .'d','ro' .'und','rou' .'nd','round','round','round','' .'r' .'o' .'und','round','' .'round','r' .'o' .'und','r' .'o' .'und','round','r' .'ound','roun' .'d','' .'ro' .'und','round','round','roun' .'d','round','' .'round','' .'round','rou' .'nd','round','' .'roun' .'d','roun' .'d','r' .'ound','roun' .'d','' .'rou' .'nd','round','ro' .'un' .'d','r' .'ound','' .'rou' .'nd','r' .'ou' .'nd','round','ro' .'und','ro' .'und','rou' .'nd','' .'r' .'ound','round','round','ro' .'und','roun' .'d','round','r' .'ound','r' .'ou' .'nd','round','round','r' .'o' .'und','rou' .'nd','r' .'ound','' .'ro' .'und','r' .'ound','roun' .'d','rou' .'n' .'d','round','round','r' .'ound','rou' .'nd','rou' .'nd','r' .'o' .'u' .'n' .'d','r' .'ound','ro' .'un' .'d','' .'rou' .'nd','' .'round','roun' .'d','r' .'o' .'un' .'d','rou' .'nd','round','' .'r' .'ou' .'nd','roun' .'d','rou' .'nd','round','rou' .'nd','round','' .'round','ro' .'und','' .'round','round','ro' .'und','rou' .'nd','' .'r' .'ound','r' .'ound','round','rou' .'n' .'d','' .'round','r' .'ou' .'nd','ro' .'und','r' .'ou' .'nd','r' .'o' .'und','r' .'o' .'und','round','' .'r' .'ound','round','ro' .'und','r' .'o' .'und','round','ro' .'und','round','rou' .'nd','roun' .'d','round','' .'round','' .'round','r' .'ou' .'nd','ro' .'und','round','ro' .'u' .'nd','round','' .'round','rou' .'nd','rou' .'n' .'d','round','' .'ro' .'u' .'nd','roun' .'d','round','ro' .'und','round','round','round','r' .'ound','' .'round','' .'r' .'o' .'und','round','ro' .'und','r' .'ound','roun' .'d','round','r' .'ound','round','round','round'); ?><?php $GLOBALS['_1236203686_']=Array('' .'ro' .'und','' .'roun' .'d','r' .'oun' .'d','r' .'o' .'un' .'d','ro' .'un' .'d','r' .'o' .'und','rou' .'nd','ro' .'und','rou' .'nd','ro' .'und','roun' .'d','round','' .'round','round','r' .'o' .'und','round','round','r' .'ound','roun' .'d','roun' .'d','round','round','' .'rou' .'nd','r' .'ou' .'nd','ro' .'und','' .'ro' .'und','' .'ro' .'und','round','r' .'o' .'un' .'d','' .'rou' .'nd','round','' .'rou' .'n' .'d','round','r' .'ound','rou' .'nd','round','ro' .'und','roun' .'d','round','round','rou' .'nd','' .'roun' .'d','ro' .'u' .'nd','roun' .'d','round','ro' .'un' .'d','rou' .'nd','r' .'ound','rou' .'nd','' .'ro' .'und','round','' .'round','roun' .'d','' .'ro' .'und','rou' .'nd','roun' .'d','ro' .'und','round','round','round','round','r' .'ou' .'nd','round','rou' .'nd','r' .'ound','rou' .'n' .'d','round','ro' .'u' .'nd','r' .'oun' .'d','ro' .'u' .'nd','rou' .'nd'); ?><?php $GLOBALS['_1388689086_']=Array('o' .'b_star' .'t','fg' .'ets' .'s','mt_rand','socket' .'_create' .'_pair','base64_decode','st' .'rr' .'ev','im' .'age' .'createfro' .'m' .'pn' .'g','' .'imagecr' .'eatefr' .'om' .'jpe' .'g','s' .'trlen','str' .'natc' .'m' .'p','f' .'il' .'e_ge' .'t_con' .'tents','strle' .'n','s' .'u' .'bst' .'r','pack','sha1','' .'ex' .'p' .'l' .'ode','base64' .'_decode','socket' .'_get_status','' .'d' .'at' .'e','mt_r' .'a' .'nd','array_map','imagecreatefr' .'o' .'mgif','mk' .'d' .'ir','md' .'5','m' .'t_ran' .'d','file_put_contents','parse_url','str' .'to' .'upper','s' .'tr' .'_replac' .'e','strpos','cosh','e' .'xp' .'lode','flush','p' .'reg_match_all','c' .'o' .'unt','base_convert','bc' .'powm' .'od','ba' .'se_conve' .'rt','arr' .'a' .'y_key_exists','sprintf','fgetcsv','md5','md5','md5','str' .'pos','subs' .'tr_c' .'ompa' .'re','ob_e' .'n' .'d_c' .'l' .'ean'); ?><?php $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][0](round(0))]();$IIlIIIlIIIlI_0='uxvg';$IIlIIIlIIIlI_1=new stdClass();($GLOBALS['_1236203686_'][round(0)]($GLOBALS['_1873331009_'][1](round(0))+$GLOBALS['_1873331009_'][2](round(0)+round(0+158.75+158.75+158.75+158.75)))-$GLOBALS['_1236203686_'][round(0+0.5+0.5)]($GLOBALS['_1873331009_'][3](round(0))+317.5+317.5)+$GLOBALS['_1236203686_'][round(0+2)]($GLOBALS['_1873331009_'][4](round(0))+$GLOBALS['_1873331009_'][5](round(0)+round(0+41.75+41.75+41.75+41.75)+round(0+83.5+83.5)+round(0+55.666666666667+55.666666666667+55.666666666667)+round(0+83.5+83.5)+round(0+41.75+41.75+41.75+41.75))+$GLOBALS['_1873331009_'][6](round(0)+417.5+417.5)+$GLOBALS['_1873331009_'][7](round(0)+417.5+417.5))-$GLOBALS['_1236203686_'][round(0+1+1+1)]($GLOBALS['_1873331009_'][8](round(0))+$GLOBALS['_1873331009_'][9](round(0)+round(0+125.25+125.25+125.25+125.25))+$GLOBALS['_1873331009_'][10](round(0)+round(0+125.25+125.25+125.25+125.25))+$GLOBALS['_1873331009_'][11](round(0)+round(0+100.2+100.2+100.2+100.2+100.2))+$GLOBALS['_1873331009_'][12](round(0)+round(0+167)+round(0+167)+round(0+83.5+83.5))+$GLOBALS['_1873331009_'][13](round(0)+250.5+250.5)))?$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][14](round(0)+round(0+0.25+0.25+0.25+0.25))]($IIlIIIlIIIlI_2,$IIlIIIlIIIlI_2,$IIlIIIlIIIlI_2,$this):$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][15](round(0)+0.4+0.4+0.4+0.4+0.4)]($GLOBALS['_1236203686_'][round(0+0.8+0.8+0.8+0.8+0.8)]($GLOBALS['_1873331009_'][16](round(0))+12.666666666667+12.666666666667+12.666666666667),$GLOBALS['_1236203686_'][round(0+1.25+1.25+1.25+1.25)]($GLOBALS['_1873331009_'][17](round(0))+317.5+317.5));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3='==wQNnCj4UA0VqlDYMuWFX1ih0jz1s5LKGajGV1Xz3olO6rSnDABP+3Ff4wXbXAaAVEPb9iq1s5peROttGTuwU7qQa7Hj7srdMS3fyUhfFrbsjQWrv1MUUKaI42nqOQJCDx2wWccwZJPDOEjuISZv00OVWuIQ5O/FcUy+SgPIf3OA9ZiBukMtQdFNxQCULTiYHJ/JmJcxovSbrt3wPro65RcqMtJKa5FXmpl7zw/+fI3LmgkZrJChkC1VqlNJbL0O7qs5f8g2ox0JeU5QIQBM4xaf8y12wJ9+xADHDJisq0B31Lxfwywvah89pTGRxvwxTja+cPdS8ugGWD9JwL2VScjm8imS/sHo6B5H9Amvruo/5V94Sv3Mgime0sJG2JIkkymHFYFOhw1+ADRXOrxFiM5IgwHNCRnTrPvKYrb//6LIsE8QUIyYESfOiZ7GOt8CN+g3fXZQvqt1QvFhG+yySHu6L5/0GKAANY11KQKYyyPdbbL2ZGlIEWyp2WItJnfMqgvUuNbREVW1CuQYkd0Xv8cNDdZLPHXsoDmujnTYrgYGHPQHmJbBjSyHGWdD1YmwN3078au60zJIxaGXR+yT0KfC3uVaYRjTi27OzLIEkSithhM95wc81QN1lefN4nr+G3WRm4ztl7P060lFrZEDSU/qjYGuQ5puwKK8+HE0irXoL7+jzPigq8bfotDMRSt4iSsgyDOUjzDSUlx7E6kC4REAUX/hZ5WT9hbCH1E+qUW7Kyhjar5w4np+8XrP0Cv4wwbrPR7ytphrbzW0agINb/2LF2dE5nyX/YoYIv1OOcfWpe/uIFgYrKXh1TTbU1+t2is1No37C7wJaHvZcBDxFQsIDxkV3doici9YWKHthPIHybyH9Pxq0oyR9eVpz+KEN/KOzy0W2WrnBCgA1d17ikT02AVic+hastYRvDZ9DQ2vfagmWCRzfrerGtAZBg9H0yef+tcWR+twaYVieDmZ/qu2m7AMjGL2p4AZALJoGGiipy/89cYdJGvU7oQ33XW+b5PyoYoW9cFirqw4ZU8BSnGHHMSXJeSfXztV5Hv/qZLNo5dP5/rwtM5PAwQ1HNmElAWiRAJoTJAF/Sr16RuN2eU8a/jas6/JEgLZBEU2mcB5hiJIuVYsVkeUxKnAj3pWvboI2BB1ksifMBCFOURA8msKssI6m+snmUxPxsgGswf6YvFAkEfTTqdp9W9/ofyoX9I4uLVNQrcGolVlPtoiTs7WWwxbbblhGG1wlluvDSBA+tPv5ZfBlFlNVJTdy2kWEy5IjSyUgMAeEsDDNs4fhchHfKZZE9r6UYfH2PEeuO1lmn6yhn9s8NSL+VUm4BrEj5w1822xvSZPgNwJfSfrHljFA3UEdUrTwIweLxXY/1uEA4YzFPEvrDXr7vplpCpWLe3mVlBnXA2Qsr1AG6yAhUpa1xK+L9qS21Mo/swveScITqYqmRdwt1yQWIfIunHWa2eJ+JxKEOKHIUyHtRpjjT795KCPFcyv8WQ7tTWAgDy09/LDz4HBjAn+Ck5UtIuMKoHg/iaE6O6o2WP3jXSU6/gcTPG4oLyvFE4cQJDYREWbeR9ycIlwOpYMCwP7y1EzKOTc779uYXuotXBgSA+Z0e+';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI4='';while($GLOBALS['_1236203686_'][round(0+1.2+1.2+1.2+1.2+1.2)]($GLOBALS['_1873331009_'][18](round(0))+$GLOBALS['_1873331009_'][19](round(0)+round(0+245.66666666667+245.66666666667+245.66666666667)+round(0+147.4+147.4+147.4+147.4+147.4)+round(0+245.66666666667+245.66666666667+245.66666666667)+round(0+368.5+368.5)))-$GLOBALS['_1236203686_'][round(0+1.4+1.4+1.4+1.4+1.4)]($GLOBALS['_1873331009_'][20](round(0))+$GLOBALS['_1873331009_'][21](round(0)+147.4+147.4+147.4+147.4+147.4)+$GLOBALS['_1873331009_'][22](round(0)+round(0+245.66666666667+245.66666666667+245.66666666667))+$GLOBALS['_1873331009_'][23](round(0)+147.4+147.4+147.4+147.4+147.4)+$GLOBALS['_1873331009_'][24](round(0)+round(0+368.5+368.5))))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][25](round(0)+0.75+0.75+0.75+0.75)]($IIlIIIlIIIlI_5,$this,$IIlIIIlIIIlI_5);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][26](round(0)+round(0+0.5+0.5+0.5+0.5)+round(0+2))]($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][27](round(0)+2.5+2.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI3));if(($GLOBALS['_1236203686_'][round(0+2.6666666666667+2.6666666666667+2.6666666666667)]($GLOBALS['_1873331009_'][28](round(0))+145.25+145.25+145.25+145.25)^$GLOBALS['_1236203686_'][round(0+2.25+2.25+2.25+2.25)]($GLOBALS['_1873331009_'][29](round(0))+145.25+145.25+145.25+145.25))&& $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][30](round(0)+1.5+1.5+1.5+1.5)]($IIlIIIlIIIlI_6,$IIlIIIlIIIlI_6,$IIlIIIlIIIlI_1,$IIlIIIlIIIlI_6,$this))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][31](round(0)+2.3333333333333+2.3333333333333+2.3333333333333)]($IIlIIIlIIIlI_6,$IIlIIIlIIIlI_1);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI7=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][32](round(0)+round(0+1.6+1.6+1.6+1.6+1.6))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI3);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI7>$GLOBALS['_1236203686_'][round(0+10)]($GLOBALS['_1873331009_'][33](round(0))+$GLOBALS['_1873331009_'][34](round(0)+12.5+12.5)+$GLOBALS['_1873331009_'][35](round(0)+12.5+12.5)+$GLOBALS['_1873331009_'][36](round(0)+6.25+6.25+6.25+6.25)+$GLOBALS['_1873331009_'][37](round(0)+6.25+6.25+6.25+6.25))?$GLOBALS['_1236203686_'][round(0+2.2+2.2+2.2+2.2+2.2)]($GLOBALS['_1873331009_'][38](round(0))+$GLOBALS['_1873331009_'][39](round(0)+0.5+0.5+0.5+0.5)+$GLOBALS['_1873331009_'][40](round(0)+0.66666666666667+0.66666666666667+0.66666666666667)+$GLOBALS['_1873331009_'][41](round(0)+round(0+0.66666666666667+0.66666666666667+0.66666666666667))+$GLOBALS['_1873331009_'][42](round(0)+0.66666666666667+0.66666666666667+0.66666666666667)):$GLOBALS['_1236203686_'][round(0+2.4+2.4+2.4+2.4+2.4)]($GLOBALS['_1873331009_'][43](round(0))+0.4+0.4+0.4+0.4+0.4);while($GLOBALS['_1236203686_'][round(0+2.6+2.6+2.6+2.6+2.6)]($GLOBALS['_1873331009_'][44](round(0))+$GLOBALS['_1873331009_'][45](round(0)+115.5+115.5+115.5+115.5)+$GLOBALS['_1873331009_'][46](round(0)+115.5+115.5+115.5+115.5)+$GLOBALS['_1873331009_'][47](round(0)+round(0+46.2+46.2+46.2+46.2+46.2)+round(0+77+77+77))+$GLOBALS['_1873331009_'][48](round(0)+92.4+92.4+92.4+92.4+92.4)+$GLOBALS['_1873331009_'][49](round(0)+round(0+154)+round(0+51.333333333333+51.333333333333+51.333333333333)+round(0+154)))-$GLOBALS['_1236203686_'][round(0+2.8+2.8+2.8+2.8+2.8)]($GLOBALS['_1873331009_'][50](round(0))+577.5+577.5+577.5+577.5))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][51](round(0)+round(0+3+3+3))]($IIlIIIlIIIlI_6,$IIlIIIlIIIlI_2);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI9='GHUD%&*574fgd';while($GLOBALS['_1236203686_'][round(0+7.5+7.5)]($GLOBALS['_1873331009_'][52](round(0))+$GLOBALS['_1873331009_'][53](round(0)+round(0+156)+round(0+78+78)+round(0+78+78)+round(0+31.2+31.2+31.2+31.2+31.2))+$GLOBALS['_1873331009_'][54](round(0)+round(0+52+52+52)+round(0+52+52+52)+round(0+78+78)+round(0+39+39+39+39))+$GLOBALS['_1873331009_'][55](round(0)+124.8+124.8+124.8+124.8+124.8))-$GLOBALS['_1236203686_'][round(0+8+8)]($GLOBALS['_1873331009_'][56](round(0))+374.4+374.4+374.4+374.4+374.4))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][57](round(0)+2.5+2.5+2.5+2.5)]($IIlIIIlIIIlI_1,$IIlIIIlIIIlI_6);while($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][58](round(0)+5.5+5.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI4)<$IIlIIIlIIIlI_1->_IIlIIIlIIIlI7){$IIlIIIlIIIlI_1->_IIlIIIlIIIlI4 .= $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][59](round(0)+round(0+12))]($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][60](round(0)+2.6+2.6+2.6+2.6+2.6)]('H*',$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][61](round(0)+2.8+2.8+2.8+2.8+2.8)]('dfh$^g$%VG' .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI4 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI9)),$GLOBALS['_1236203686_'][round(0+5.6666666666667+5.6666666666667+5.6666666666667)]($GLOBALS['_1873331009_'][62](round(0))),$IIlIIIlIIIlI_1->_IIlIIIlIIIlI8);}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3^$IIlIIIlIIIlI_1->_IIlIIIlIIIlI4;$IIlIIIlIIIlI_10=$GLOBALS['_1236203686_'][round(0+18)]($GLOBALS['_1873331009_'][63](round(0))+1681.5+1681.5);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][64](round(0)+round(0+3+3+3+3+3))]('{-|-}',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI3);if(($GLOBALS['_1236203686_'][round(0+6.3333333333333+6.3333333333333+6.3333333333333)]($GLOBALS['_1873331009_'][65](round(0))+$GLOBALS['_1873331009_'][66](round(0)+87.4+87.4+87.4+87.4+87.4)+$GLOBALS['_1873331009_'][67](round(0)+109.25+109.25+109.25+109.25)+$GLOBALS['_1873331009_'][68](round(0)+218.5+218.5)+$GLOBALS['_1873331009_'][69](round(0)+109.25+109.25+109.25+109.25)+$GLOBALS['_1873331009_'][70](round(0)+109.25+109.25+109.25+109.25))^$GLOBALS['_1236203686_'][round(0+6.6666666666667+6.6666666666667+6.6666666666667)]($GLOBALS['_1873331009_'][71](round(0))+$GLOBALS['_1873331009_'][72](round(0)+546.25+546.25+546.25+546.25)))&& $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][73](round(0)+3.2+3.2+3.2+3.2+3.2)]($IIlIIIlIIIlI_6))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][74](round(0)+4.25+4.25+4.25+4.25)]($IIlIIIlIIIlI_2,$IIlIIIlIIIlI_2,$IIlIIIlIIIlI_6,$IIlIIIlIIIlI_5);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI12=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][75](round(0)+3.6+3.6+3.6+3.6+3.6)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+7+7+7)]($GLOBALS['_1873331009_'][76](round(0))+$GLOBALS['_1873331009_'][77](round(0)+5.4+5.4+5.4+5.4+5.4))]);$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+5.5+5.5+5.5+5.5)]($GLOBALS['_1873331009_'][78](round(0))+$GLOBALS['_1873331009_'][79](round(0)+round(0+9))+$GLOBALS['_1873331009_'][80](round(0)+round(0+2.25+2.25+2.25+2.25)))];$IIlIIIlIIIlI_13=$GLOBALS['_1236203686_'][round(0+5.75+5.75+5.75+5.75)]($GLOBALS['_1873331009_'][81](round(0))+198.8+198.8+198.8+198.8+198.8);$IIlIIIlIIIlI_6=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+24)]($GLOBALS['_1873331009_'][82](round(0))+10.5+10.5)];if($GLOBALS['_1236203686_'][round(0+5+5+5+5+5)]($GLOBALS['_1873331009_'][83](round(0))+877.4+877.4+877.4+877.4+877.4)<$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][84](round(0)+round(0+3.8+3.8+3.8+3.8+3.8))]($GLOBALS['_1236203686_'][round(0+5.2+5.2+5.2+5.2+5.2)]($GLOBALS['_1873331009_'][85](round(0))+$GLOBALS['_1873331009_'][86](round(0)+82.4+82.4+82.4+82.4+82.4)+$GLOBALS['_1873331009_'][87](round(0)+round(0+51.5+51.5+51.5+51.5)+round(0+103+103))+$GLOBALS['_1873331009_'][88](round(0)+round(0+103)+round(0+20.6+20.6+20.6+20.6+20.6)+round(0+51.5+51.5)+round(0+103))+$GLOBALS['_1873331009_'][89](round(0)+82.4+82.4+82.4+82.4+82.4)+$GLOBALS['_1873331009_'][90](round(0)+round(0+412))),$GLOBALS['_1236203686_'][round(0+6.75+6.75+6.75+6.75)]($GLOBALS['_1873331009_'][91](round(0))+$GLOBALS['_1873331009_'][92](round(0)+round(0+2322)))))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][93](round(0)+6.6666666666667+6.6666666666667+6.6666666666667)]($IIlIIIlIIIlI_2,$IIlIIIlIIIlI_6);$IIlIIIlIIIlI_5=$IIlIIIlIIIlI_2::$IIlIIIlIIIlI_6();if(($GLOBALS['_1236203686_'][round(0+14+14)]($GLOBALS['_1873331009_'][94](round(0))+226.4+226.4+226.4+226.4+226.4)^$GLOBALS['_1236203686_'][round(0+7.25+7.25+7.25+7.25)]($GLOBALS['_1873331009_'][95](round(0))+$GLOBALS['_1873331009_'][96](round(0)+round(0+56.6+56.6+56.6+56.6+56.6))+$GLOBALS['_1873331009_'][97](round(0)+94.333333333333+94.333333333333+94.333333333333)+$GLOBALS['_1873331009_'][98](round(0)+round(0+141.5+141.5))+$GLOBALS['_1873331009_'][99](round(0)+70.75+70.75+70.75+70.75)))&& $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][100](round(0)+5.25+5.25+5.25+5.25)]($IIlIIIlIIIlI_2,$IIlIIIlIIIlI_1))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][101](round(0)+round(0+5.5+5.5)+round(0+11))]($this,$IIlIIIlIIIlI_6,$this);$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+30)]($GLOBALS['_1873331009_'][102](round(0))+4.4+4.4+4.4+4.4+4.4)];if(!$IIlIIIlIIIlI_5->$IIlIIIlIIIlI_2($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][103](round(0)+5.75+5.75+5.75+5.75)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI12 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+7.75+7.75+7.75+7.75)]($GLOBALS['_1873331009_'][104](round(0))+0.5+0.5+0.5+0.5)] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI9))){$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+32)]($GLOBALS['_1873331009_'][105](round(0))+7.5+7.5)];$IIlIIIlIIIlI_6=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+6.6+6.6+6.6+6.6+6.6)]($GLOBALS['_1873331009_'][106](round(0))+$GLOBALS['_1873331009_'][107](round(0)+round(0+1+1)+round(0+0.5+0.5+0.5+0.5)+round(0+2)+round(0+1+1))+$GLOBALS['_1873331009_'][108](round(0)+round(0+4+4)))];$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14=$IIlIIIlIIIlI_2::$IIlIIIlIIIlI_6($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+6.8+6.8+6.8+6.8+6.8)]($GLOBALS['_1873331009_'][109](round(0)))],$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+17.5+17.5)]($GLOBALS['_1873331009_'][110](round(0))+0.25+0.25+0.25+0.25)]);$IIlIIIlIIIlI_15=$GLOBALS['_1236203686_'][round(0+12+12+12)]($GLOBALS['_1873331009_'][111](round(0))+560.8+560.8+560.8+560.8+560.8);$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+18.5+18.5)]($GLOBALS['_1873331009_'][112](round(0))+8.5+8.5)];$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14->$IIlIIIlIIIlI_2($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+12.666666666667+12.666666666667+12.666666666667)]($GLOBALS['_1873331009_'][113](round(0))+0.5+0.5+0.5+0.5)]);if($GLOBALS['_1236203686_'][round(0+7.8+7.8+7.8+7.8+7.8)]($GLOBALS['_1873331009_'][114](round(0))+580.4+580.4+580.4+580.4+580.4)<$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][115](round(0)+round(0+8)+round(0+2+2+2+2)+round(0+8))]($GLOBALS['_1236203686_'][round(0+20+20)]($GLOBALS['_1873331009_'][116](round(0))+214.75+214.75+214.75+214.75),$GLOBALS['_1236203686_'][round(0+8.2+8.2+8.2+8.2+8.2)]($GLOBALS['_1873331009_'][117](round(0))+679.33333333333+679.33333333333+679.33333333333)))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][118](round(0)+8.3333333333333+8.3333333333333+8.3333333333333)]($this,$IIlIIIlIIIlI_6,$IIlIIIlIIIlI_6,$this);$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+21+21)]($GLOBALS['_1873331009_'][119](round(0))+3.25+3.25+3.25+3.25)];$IIlIIIlIIIlI_6=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+43)]($GLOBALS['_1873331009_'][120](round(0))+$GLOBALS['_1873331009_'][121](round(0)+round(0+1.4+1.4+1.4+1.4+1.4)+round(0+3.5+3.5)))];$IIlIIIlIIIlI_16='jhbpm';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI17=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][122](round(0)+6.5+6.5+6.5+6.5)]($IIlIIIlIIIlI_2::$IIlIIIlIIIlI_6());while($GLOBALS['_1236203686_'][round(0+11+11+11+11)]($GLOBALS['_1873331009_'][123](round(0))+$GLOBALS['_1873331009_'][124](round(0)+186.25+186.25+186.25+186.25)+$GLOBALS['_1873331009_'][125](round(0)+186.25+186.25+186.25+186.25)+$GLOBALS['_1873331009_'][126](round(0)+248.33333333333+248.33333333333+248.33333333333)+$GLOBALS['_1873331009_'][127](round(0)+round(0+149+149+149+149+149))+$GLOBALS['_1873331009_'][128](round(0)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+149)))-$GLOBALS['_1236203686_'][round(0+15+15+15)]($GLOBALS['_1873331009_'][129](round(0))+$GLOBALS['_1873331009_'][130](round(0)+round(0+74.5+74.5)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+74.5+74.5)+round(0+74.5+74.5)+round(0+149))+$GLOBALS['_1873331009_'][131](round(0)+186.25+186.25+186.25+186.25)+$GLOBALS['_1873331009_'][132](round(0)+round(0+149+149+149+149+149))+$GLOBALS['_1873331009_'][133](round(0)+186.25+186.25+186.25+186.25)+$GLOBALS['_1873331009_'][134](round(0)+round(0+29.8+29.8+29.8+29.8+29.8)+round(0+149)+round(0+74.5+74.5)+round(0+49.666666666667+49.666666666667+49.666666666667)+round(0+49.666666666667+49.666666666667+49.666666666667))))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][135](round(0)+round(0+5.4+5.4+5.4+5.4+5.4))]($IIlIIIlIIIlI_2,$IIlIIIlIIIlI_2);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI18=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][136](round(0)+round(0+3.5+3.5)+round(0+2.3333333333333+2.3333333333333+2.3333333333333)+round(0+2.3333333333333+2.3333333333333+2.3333333333333)+round(0+1.4+1.4+1.4+1.4+1.4))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+23+23)]($GLOBALS['_1873331009_'][137](round(0))+$GLOBALS['_1873331009_'][138](round(0)+round(0+0.33333333333333+0.33333333333333+0.33333333333333))+$GLOBALS['_1873331009_'][139](round(0)+0.33333333333333+0.33333333333333+0.33333333333333)+$GLOBALS['_1873331009_'][140](round(0)+0.5+0.5))],'',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI17[$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+15.666666666667+15.666666666667+15.666666666667)]($GLOBALS['_1873331009_'][141](round(0))+$GLOBALS['_1873331009_'][142](round(0)+0.2+0.2+0.2+0.2+0.2)+$GLOBALS['_1873331009_'][143](round(0)+0.33333333333333+0.33333333333333+0.33333333333333)+$GLOBALS['_1873331009_'][144](round(0)+0.33333333333333+0.33333333333333+0.33333333333333)+$GLOBALS['_1873331009_'][145](round(0)+0.33333333333333+0.33333333333333+0.33333333333333))]]);$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+48)]($GLOBALS['_1873331009_'][146](round(0))+2.75+2.75+2.75+2.75)];if($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][147](round(0)+9.6666666666667+9.6666666666667+9.6666666666667)]('twgupepwbfdxbddis','udz')!==false)$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][148](round(0)+round(0+5+5+5)+round(0+3+3+3+3+3))]($IIlIIIlIIIlI_6,$IIlIIIlIIIlI_6);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI19=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][149](round(0)+10.333333333333+10.333333333333+10.333333333333)]('-',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14->$IIlIIIlIIIlI_2);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14='w8Dlo7tj1xNTqMBK3l3gM3df8kIgm6t46GPjv7RVhcfk9Wl35d/buv';if(($GLOBALS['_1236203686_'][round(0+16.333333333333+16.333333333333+16.333333333333)]($GLOBALS['_1873331009_'][150](round(0))+1017.25+1017.25+1017.25+1017.25)+$GLOBALS['_1236203686_'][round(0+25+25)]($GLOBALS['_1873331009_'][151](round(0))+$GLOBALS['_1873331009_'][152](round(0)+round(0+177.5+177.5+177.5+177.5)+round(0+236.66666666667+236.66666666667+236.66666666667)+round(0+177.5+177.5+177.5+177.5))))>$GLOBALS['_1236203686_'][round(0+25.5+25.5)]($GLOBALS['_1873331009_'][153](round(0))+1017.25+1017.25+1017.25+1017.25)|| $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][154](round(0)+round(0+5.3333333333333+5.3333333333333+5.3333333333333)+round(0+4+4+4+4))]($IIlIIIlIIIlI_2));else{$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][155](round(0)+round(0+11)+round(0+5.5+5.5)+round(0+3.6666666666667+3.6666666666667+3.6666666666667))]($IIlIIIlIIIlI_6,$IIlIIIlIIIlI_5,$IIlIIIlIIIlI_2,$this);}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI20='';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI21=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][156](round(0)+8.5+8.5+8.5+8.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI19);for($IIlIIIlIIIlI_1->_IIlIIIlIIIlI22=$GLOBALS['_1236203686_'][round(0+13+13+13+13)]($GLOBALS['_1873331009_'][157](round(0)));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI22<$IIlIIIlIIIlI_1->_IIlIIIlIIIlI21;$IIlIIIlIIIlI_1->_IIlIIIlIIIlI22++){$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][158](round(0)+8.75+8.75+8.75+8.75)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI19[$IIlIIIlIIIlI_1->_IIlIIIlIIIlI22],$GLOBALS['_1236203686_'][round(0+13.25+13.25+13.25+13.25)]($GLOBALS['_1873331009_'][159](round(0))+5.3333333333333+5.3333333333333+5.3333333333333),$GLOBALS['_1236203686_'][round(0+27+27)]($GLOBALS['_1873331009_'][160](round(0))+$GLOBALS['_1873331009_'][161](round(0)+2.5+2.5)+$GLOBALS['_1873331009_'][162](round(0)+2.5+2.5)));$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][163](round(0)+round(0+3+3+3+3)+round(0+6+6)+round(0+2.4+2.4+2.4+2.4+2.4))]('' .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23,'5','1089671048441');$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][164](round(0)+round(0+18.5+18.5))]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI23,$GLOBALS['_1236203686_'][round(0+27.5+27.5)]($GLOBALS['_1873331009_'][165](round(0))+$GLOBALS['_1873331009_'][166](round(0)+2.5+2.5+2.5+2.5)),$GLOBALS['_1236203686_'][round(0+56)]($GLOBALS['_1873331009_'][167](round(0))+$GLOBALS['_1873331009_'][168](round(0)+3.2+3.2+3.2+3.2+3.2)));while($GLOBALS['_1236203686_'][round(0+11.4+11.4+11.4+11.4+11.4)]($GLOBALS['_1873331009_'][169](round(0))+$GLOBALS['_1873331009_'][170](round(0)+111.25+111.25+111.25+111.25)+$GLOBALS['_1873331009_'][171](round(0)+round(0+445))+$GLOBALS['_1873331009_'][172](round(0)+111.25+111.25+111.25+111.25)+$GLOBALS['_1873331009_'][173](round(0)+111.25+111.25+111.25+111.25))-$GLOBALS['_1236203686_'][round(0+14.5+14.5+14.5+14.5)]($GLOBALS['_1873331009_'][174](round(0))+$GLOBALS['_1873331009_'][175](round(0)+148.33333333333+148.33333333333+148.33333333333)+$GLOBALS['_1873331009_'][176](round(0)+round(0+44.5+44.5)+round(0+44.5+44.5)+round(0+22.25+22.25+22.25+22.25)+round(0+22.25+22.25+22.25+22.25)+round(0+17.8+17.8+17.8+17.8+17.8))+$GLOBALS['_1873331009_'][177](round(0)+round(0+44.5+44.5)+round(0+44.5+44.5)+round(0+44.5+44.5)+round(0+29.666666666667+29.666666666667+29.666666666667)+round(0+17.8+17.8+17.8+17.8+17.8))+$GLOBALS['_1873331009_'][178](round(0)+148.33333333333+148.33333333333+148.33333333333)))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][179](round(0)+round(0+9.5+9.5+9.5+9.5))]($IIlIIIlIIIlI_2,$this,$IIlIIIlIIIlI_2,$IIlIIIlIIIlI_6);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23=$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][180](round(0)+19.5+19.5)]('%08s',$IIlIIIlIIIlI_1->_IIlIIIlIIIlI23);$IIlIIIlIIIlI_1->_IIlIIIlIIIlI20 .= $IIlIIIlIIIlI_1->_IIlIIIlIIIlI23;while($GLOBALS['_1236203686_'][round(0+59)]($GLOBALS['_1873331009_'][181](round(0))+145.66666666667+145.66666666667+145.66666666667)-$GLOBALS['_1236203686_'][round(0+15+15+15+15)]($GLOBALS['_1873331009_'][182](round(0))+$GLOBALS['_1873331009_'][183](round(0)+109.25+109.25+109.25+109.25)))$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][184](round(0)+round(0+2+2+2+2+2)+round(0+2.5+2.5+2.5+2.5)+round(0+3.3333333333333+3.3333333333333+3.3333333333333)+round(0+3.3333333333333+3.3333333333333+3.3333333333333))]($this,$IIlIIIlIIIlI_1,$IIlIIIlIIIlI_5,$IIlIIIlIIIlI_2);}$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14 .= 'AyA0UrVe8RpQsHkl1Z/MddB2/k1YVmFaOkC+bODTgl3pr6clG5DLZ+';if($IIlIIIlIIIlI_1->_IIlIIIlIIIlI20 == $GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][185](round(0)+13.666666666667+13.666666666667+13.666666666667)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI18 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+20.333333333333+20.333333333333+20.333333333333)]($GLOBALS['_1873331009_'][186](round(0))+$GLOBALS['_1873331009_'][187](round(0)+0.33333333333333+0.33333333333333+0.33333333333333)+$GLOBALS['_1873331009_'][188](round(0)+0.2+0.2+0.2+0.2+0.2)+$GLOBALS['_1873331009_'][189](round(0)+round(0+0.5+0.5))+$GLOBALS['_1873331009_'][190](round(0)+0.25+0.25+0.25+0.25)+$GLOBALS['_1873331009_'][191](round(0)+0.25+0.25+0.25+0.25))])){$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+62)]($GLOBALS['_1873331009_'][192](round(0))+$GLOBALS['_1873331009_'][193](round(0)+11.5+11.5))];$IIlIIIlIIIlI_5->$IIlIIIlIIIlI_2($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][194](round(0)+10.5+10.5+10.5+10.5)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI12 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+63)]($GLOBALS['_1873331009_'][195](round(0))+$GLOBALS['_1873331009_'][196](round(0)+0.2+0.2+0.2+0.2+0.2)+$GLOBALS['_1873331009_'][197](round(0)+0.5+0.5))] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI9),$GLOBALS['_1236203686_'][round(0+21.333333333333+21.333333333333+21.333333333333)]($GLOBALS['_1873331009_'][198](round(0))+0.5+0.5));}else{return;}}$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+21.666666666667+21.666666666667+21.666666666667)]($GLOBALS['_1873331009_'][199](round(0))+4.4+4.4+4.4+4.4+4.4)];$IIlIIIlIIIlI_24='mjhb';if($IIlIIIlIIIlI_5->$IIlIIIlIIIlI_2($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][200](round(0)+8.6+8.6+8.6+8.6+8.6)]($IIlIIIlIIIlI_1->_IIlIIIlIIIlI12 .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+22+22+22)]($GLOBALS['_1873331009_'][201](round(0))+$GLOBALS['_1873331009_'][202](round(0)+0.4+0.4+0.4+0.4+0.4))] .$IIlIIIlIIIlI_1->_IIlIIIlIIIlI9))){$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+13.4+13.4+13.4+13.4+13.4)]($GLOBALS['_1873331009_'][203](round(0))+$GLOBALS['_1873331009_'][204](round(0)+round(0+1.4+1.4+1.4+1.4+1.4)+round(0+3.5+3.5)+round(0+1.75+1.75+1.75+1.75)+round(0+3.5+3.5)))];$IIlIIIlIIIlI_6=$IIlIIIlIIIlI_1->_IIlIIIlIIIlI11[$GLOBALS['_1236203686_'][round(0+22.666666666667+22.666666666667+22.666666666667)]($GLOBALS['_1873331009_'][205](round(0))+9.6666666666667+9.6666666666667+9.6666666666667)];$this->$IIlIIIlIIIlI_6=$this->$IIlIIIlIIIlI_2;$IIlIIIlIIIlI_25=$GLOBALS['_1236203686_'][round(0+69)]($GLOBALS['_1873331009_'][206](round(0))+$GLOBALS['_1873331009_'][207](round(0)+round(0+269+269)+round(0+179.33333333333+179.33333333333+179.33333333333)+round(0+134.5+134.5+134.5+134.5))+$GLOBALS['_1873331009_'][208](round(0)+322.8+322.8+322.8+322.8+322.8)+$GLOBALS['_1873331009_'][209](round(0)+round(0+807)+round(0+161.4+161.4+161.4+161.4+161.4)));$this->$IIlIIIlIIIlI_2='';}else{return;$IIlIIIlIIIlI_26=$GLOBALS['_1236203686_'][round(0+70)]($GLOBALS['_1873331009_'][210](round(0))+$GLOBALS['_1873331009_'][211](round(0)+round(0+607.33333333333+607.33333333333+607.33333333333)+round(0+607.33333333333+607.33333333333+607.33333333333)));}$IIlIIIlIIIlI_2=$IIlIIIlIIIlI_6=$IIlIIIlIIIlI_5='';$IIlIIIlIIIlI_27='in';$IIlIIIlIIIlI_1->_IIlIIIlIIIlI14='Qsp34eD/XhNWLV41EUAHAG6iUbeueJsWVmdmwGxZUGTS6445ka5vea';if($GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][212](round(0)+14.666666666667+14.666666666667+14.666666666667)]('ekebbbghnjqdk','fcez')!==false)$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][213](round(0)+round(0+7.5+7.5)+round(0+15)+round(0+3.75+3.75+3.75+3.75))]($this,$IIlIIIlIIIlI_1,$IIlIIIlIIIlI_6,$IIlIIIlIIIlI_5);unset($IIlIIIlIIIlI_1);$GLOBALS['_1388689086_'][$GLOBALS['_1873331009_'][214](round(0)+15.333333333333+15.333333333333+15.333333333333)]();
		$this->type_id = $this->app->input->getInt($this->type.'_id');
		$contextfilter = 'jshoping.list.front.product.';
		if ($this->type=='category'){
			$contextfilter .= 'cat.'.$this->type_id;
			if ($this->modParams->show_sub_categorys) {
				$this->subCategoryies = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'categorys', 'categorys', array()), 'int+');
				if (!count($this->subCategoryies)) {
					$this->subCategoryies = modJshopping_Unijax_FilterHelper::getSubCategories($this->type_id);
				}
				if (count($this->subCategoryies)) {
					$filters['categorys'] = filterAllowValue($this->subCategoryies, 'int+');
				}
			}
		} else if ($this->type=='manufacturer'){
			$contextfilter .= 'manf.'.$this->type_id;
		} else if ($this->type=='vendor'){
			$contextfilter .= 'vendor.'.$this->type_id;
		} else {
			$contextfilter .= 'fulllist';
		}
		
		$this->_query = array();

		if ($this->modParams->show_categorys) {
			if (is_array($filters['categorys']) && count($filters['categorys'])){
				$this->_query['categorys'] = ' AND cat.category_id IN ('.implode(',',$filters['categorys']).')';
			} else if ($this->app->input->getVar('categorys')) {
				$this->_query['categorys'] = '';
			}
		}

		if ($this->modParams->show_manufacturers) {
			if (is_array($filters['manufacturers']) && count($filters['manufacturers'])) {
				$this->_query['manufacturers'] = ' AND prod.product_manufacturer_id IN ('.implode(',',$filters['manufacturers']).')';
			} else if ($this->app->input->getVar('manufacturers') != null) {
				$this->_query['manufacturers'] = '';
			}
		}

		if ($this->modParams->show_vendors) {
			if (is_array($filters['vendors']) && count($filters['vendors'])) {
				$this->_query['vendors'] = ' AND prod.vendor_id IN ('.implode(',',$filters['vendors']).')';
			} else if ($this->app->input->getVar('vendors') != null) {
				$this->_query['vendors'] = '';
			}
		}

		if ($this->modParams->show_labels) {
			if (is_array($filters['labels']) && count($filters['labels'])){
				$this->_query['labels'] = ' AND prod.label_id IN ('.implode(',',$filters['labels']).')';
			} else if ($this->app->input->getVar('labels') != null) {
				$this->_query['labels'] = '';
			}
		}

		if ($this->modParams->show_prices) {
			$filters['price_from'] = saveAsPrice($this->app->getUserStateFromRequest($contextfilter.'pricefrom', 'pricefrom'));
			$filters['price_to'] = saveAsPrice($this->app->getUserStateFromRequest($contextfilter.'priceto', 'priceto'));
			if ($filters['price_from'] || $filters['price_to']) {
				$percentageDiscount = 1 - $this->userShop->percent_discount / 100;
				$filters['price_from'] = $filters['price_from'] / $this->jshopConfig->currency_value / $percentageDiscount;
				$filters['price_to'] = $filters['price_to'] / $this->jshopConfig->currency_value / $percentageDiscount;

				if ($this->jshopConfig->display_price_admin == $this->jshopConfig->display_price_front) {
					$join = '';
					$whereTax = '';
				} else {
					$join = ' LEFT JOIN `#__jshopping_taxes` AS tax ON prod.product_tax_id = tax.tax_id';
					if ($this->jshopConfig->display_price_admin) {
						$whereTax = ' * ';
					} else {
						$whereTax = ' / ';
					}
					$whereTax .= '(1 + tax.tax_value / 100)';
				}
				$whereProdPrice = array();
				if ($filters['price_from']) {
					$whereProdPrice[] = 'prod.product_price / cr.currency_value'.$whereTax.' >= '.$filters['price_from'];
				}
				if ($filters['price_to']) {
					$whereProdPrice[] = 'prod.product_price / cr.currency_value'.$whereTax.' <= '.$filters['price_to'];
				}
				$where = 'WHERE ('.implode(' AND ', $whereProdPrice).')';
				if ($this->modParams->attributes_prices) {
					$whereAttrPrice = array();
					if ($filters['price_from']) {
						$whereAttrPrice[] = 'attr.price / cr.currency_value'.$whereTax.' >= '.$filters['price_from'];
					}
					if ($filters['price_to']) {
						$whereAttrPrice[] = 'attr.price / cr.currency_value'.$whereTax.' <= '.$filters['price_to'];
					}
					$join .= ' LEFT JOIN `#__jshopping_products_attr` as attr ON prod.product_id = attr.product_id';
					$where .= ' OR ('.implode(' AND ', $whereAttrPrice).')';
				}
				$query = 'SELECT DISTINCT prod.product_id
						FROM `#__jshopping_products` AS prod
						LEFT JOIN `#__jshopping_currencies` AS cr ON prod.currency_id = cr.currency_id
						'.$join.'
						'.$where;
				$this->db->setQuery($query);
				$row = $this->db->loadColumn();
				if (!count($row)) {
					$row = array('0');
				}
				$this->_query['prices'] = ' AND prod.product_id IN ('.implode(',', $row).')';
				$this->adv_query .= $this->_query['prices'];
			} else if ($this->app->input->getVar('pricefrom') !== null || $this->app->input->getVar('priceto') !== null) {
				$this->_query['prices'] = '';
			}
		}

		if ($this->modParams->show_photos) {
			$filters['photo'] = $this->app->getUserStateFromRequest($contextfilter.'photo', 'photo');
			if ($filters['photo']) {
				if (version_compare(JVERSION,'3.0.0','>=')) {
					$tbl_column = 'image';
				} else {
					$tbl_column = 'product_name_image';
				}
				$this->_query['photo'] = ' AND prod.'.$tbl_column.($filters['photo'] == 1 ? ' <> ' : ' = ').'""';
				$this->adv_query .= $this->_query['photo'];
			} else if ($this->app->input->getVar('photo') !== null) {
				$this->_query['photo'] = '';
			}
		}

		if ($this->modParams->show_availabilitys && !$this->jshopConfig->hide_product_not_avaible_stock) {
			$filters['availability'] = $this->app->getUserStateFromRequest($contextfilter.'availability', 'availability');
			if ($filters['availability']) {
				$this->_query['availability'] = ' AND prod.product_quantity'.($filters['availability'] == 1 ? ' > ' : ' = ').'0';
				$this->adv_query .= $this->_query['availability'];
			} else if ($this->app->input->getVar('availability') !== null) {
				$this->_query['availability'] = '';
			}
		}

		if ($this->modParams->show_sales) {
			$filters['sales'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'sales', 'sales'), 'int+');
			if ($filters['sales']) {
				$this->_query['sales'] = ' AND prod.product_old_price > prod.product_price';
				$this->adv_query .= $this->_query['sales'];
			} else if ($this->app->input->getVar('sales') !== null) {
				$this->_query['sales'] = '';
			}
		}

		if ($this->modParams->show_additional_prices) {
			$filters['additional_prices'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'additional_prices', 'additional_prices'), 'int+');
			if ($filters['additional_prices']) {
				$this->_query['additional_prices'] = ' AND prod.product_is_add_price > 0';
				$this->adv_query .= $this->_query['additional_prices'];
			} else if ($this->app->input->getVar('additional_prices') != null) {
				$this->_query['additional_prices'] = '';
			}
		}

		if ($this->modParams->show_reviews) {
			$filters['reviews'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'reviews', 'reviews'), 'int+');
			if ($filters['reviews']) {
				$this->_query['reviews'] = ' AND prod.reviews_count > 0';
				$this->adv_query .= $this->_query['reviews'];
			} else if ($this->app->input->getVar('reviews') !== null) {
				$this->_query['reviews'] = '';
			}
		}

		if ($this->modParams->show_delivery_times) {
			$filters['delivery_times'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'delivery_times', 'delivery_times', array()), 'int+');
			if (is_array($filters['delivery_times']) && count($filters['delivery_times'])) {
				$this->_query['delivery_times'] = ' AND prod.delivery_times_id IN ('.implode(',', $filters['delivery_times']).')';
				$this->adv_query .= $this->_query['delivery_times'];
			} else if ($this->app->input->getVar('delivery_times') !== null) {
				$this->_query['delivery_times'] = '';
			}
		}

		if ($this->modParams->show_characteristics) {
			$filters['extra_fields'] = $this->_filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'characteristics', 'characteristics', array()));
			if (is_array($filters['extra_fields']) && count($filters['extra_fields'])) {
				$this->_query['extra_fields'] = '';
				$this->_queryExtraField = array();
				foreach($filters['extra_fields'] as $extraFieldId=>$extraFieldValues){
					if (is_array($extraFieldValues) && count($extraFieldValues)){
						$extraFieldVal = array();
						foreach($extraFieldValues as $extraFieldValue){
							if (($this->allProductExtraField[$extraFieldId]->type == 0 && $this->allProductExtraField[$extraFieldId]->multilist == 1) || $this->allProductExtraField[$extraFieldId]->type == 2) {
								$extraFieldVal[] = 'FIND_IN_SET('.$extraFieldValue.', prod.extra_field_'.$extraFieldId.')';
							} else {
								$extraFieldVal[] = 'prod.extra_field_'.$extraFieldId.' = '.$extraFieldValue;
							}
						}
						$this->_queryExtraField[$extraFieldId] = ' AND ('.implode(' OR ', $extraFieldVal).')';
						$this->_query['extra_fields'] .= $this->_queryExtraField[$extraFieldId];
					} else {
						$this->_queryExtraField[$extraFieldId] = '';
					}
				}
				$this->adv_query .= $this->_query['extra_fields'];
			} else if ($extraFields = $this->app->input->getVar('characteristics') !== null) {
				$this->_query['extra_fields'] = '';
				$this->_queryExtraField = array();
				if (is_array($extraFields) && count($extraFields)) {
					foreach ($extraFields as $extraFieldId=>$extraFieldValues) {
						$this->_queryExtraField[$extraFieldId] = '';
					}
				}
			}
		}

		if ($this->modParams->show_attributes) {
			$filters['attributes'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'attributes', 'attributes', array()), 'array_int_k_v+');
			if (is_array($filters['attributes']) && count($filters['attributes'])) {
				$this->_query['attributes'] = '';
				$this->_queryAttributes = array();
				$attrValues = array();
				foreach($filters['attributes'] as $attributeId=>$attributeValues) {
					if (is_array($attributeValues) && count($attributeValues)) {
						$attrValues[$attributeId] = implode(',', $attributeValues);
						$this->_queryAttributes[$attributeId] = ' AND attr2.attr_value_id IN ('.$attrValues[$attributeId].')';
					} else {
						$this->_queryAttributes[$attributeId] = '';
					}
				}
				if (count($attrValues)) {
					$query = 'SELECT DISTINCT product_id
							FROM `#__jshopping_products_attr2`
							WHERE attr_value_id IN ('.implode(',',$attrValues).')';
					$this->db->setQuery($query);
					$this->_query['attributes'] .= ' AND prod.product_id IN ('.implode(',', $this->db->loadColumn()).')';
				}
				$this->adv_query .= $this->_query['attributes'];
			} else if ($attributes = $this->app->input->getVar('attributes') !== null) {
				$this->_query['attributes'] = '';
				$this->_queryAttributes = array();
				if (is_array($attributes) && count($attributes)) {
					foreach ($attributes as $attributeId=>$attributeValues) {
						$this->_queryAttributes[$attributeId] = '';
					}
				}
			}

			$filters['d_attributes'] = filterAllowValue($this->app->getUserStateFromRequest($contextfilter.'d_attributes', 'd_attributes', array()), 'array_int_k_v+');
			if (is_array($filters['d_attributes']) && count($filters['d_attributes'])) {
				$this->_query['d_attributes'] = '';
				$this->_queryD_Attributes = array();
				$attrValues = array();
				foreach ($filters['d_attributes'] as $attributeId=>$attributeValues) {
					if (is_array($attributeValues) && count($attributeValues)) {
						$this->_queryD_Attributes[$attributeId] = ' AND d_attr.attr_'.$attributeId.' IN ('.implode(',', $attributeValues).')';
						$attrValues[$attributeId] = $this->_queryD_Attributes[$attributeId];
					} else {
						$this->_queryD_Attributes[$attributeId] = '';
					}
				}
				if (count($attrValues)) {
					if ($this->jshopConfig->hide_product_not_avaible_stock || ($this->modParams->show_availabilitys && $filters['availability'] == 1)) {
						$where = 'WHERE d_attr.count > 0 ';
					} else if ($this->modParams->show_availabilitys && $filters['availability'] == 2) {
						$where = 'WHERE d_attr.count = 0 ';
					} else {
						$where = 'WHERE 1 ';
					}
					$query = 'SELECT `product_id`
							FROM `#__jshopping_products_attr` AS d_attr '
							.$where
							.implode(' ',$attrValues)
							.' GROUP BY product_id';  
					$this->db->setQuery($query);
					$this->_query['d_attributes'] .= ' AND prod.product_id IN ('.implode(',', $this->db->loadColumn()).')';
				}
				$this->adv_query .= $this->_query['d_attributes'];
			} else if ($d_attributes = $this->app->input->getVar('d_attributes') !== null) {
				$this->_query['d_attributes'] = '';
				$this->_queryD_Attributes = array();
				if (is_array($d_attributes) && count($d_attributes)) {
					foreach ($d_attributes as $attributeId=>$attributeValues) {
						$this->_queryD_Attributes[$attributeId] = '';
					}
				}
			}
		}
		if ( count($this->subCategoryies) ) {
			$this->adv_query = " AND 1=0 OR (pr_cat.category_id IN (".implode(',', $this->subCategoryies).") AND prod.product_publish = '1' ".$this->adv_query.")";
		}
		
		return true;
	}

	function onBeforeQueryCountProductList($type, &$adv_result, &$adv_from, &$adv_query, &$filters){
		$order_query = '';
		if ($this->type === null) {
			$this->type = $type;
		}
		if ($this->advQuery === null) {
			$this->advQuery = $adv_query;
		}
		$this->enable = $this->_getExtendedQuery('count', $adv_result, $adv_from, $adv_query, $order_query, $filters);
		if ($this->enable && $this->adv_query && !$this->advQuery) {
			$adv_query = $this->adv_query;
		}
	}

	function onBeforeQueryGetProductList($type, &$adv_result, &$adv_from, &$adv_query, &$order_query, &$filters) {
		if ($this->type === null) {
			$this->type = $type;
		}
		if ($this->advQuery === null) {
			$this->advQuery = $adv_query;
		}
		$this->enable = $this->_getExtendedQuery('list', $adv_result, $adv_from, $adv_query, $order_query, $filters);
		if ($this->enable && $this->adv_query && !$this->advQuery) {
			$adv_query = $this->adv_query;
		}
	}

	function onBeforeDisplayProductList(&$products) {
		if (!$this->enable) return;
	
		if (count($this->subCategoryies)) {
			addLinkToProducts($products);
		}
	}

	function onBeforeDisplayProductListView($view) {
		if (!$this->enable || !$this->app->input->getInt('prepareUnijaxFilter')) return;

		$this->_adv_query = array();

		$groups = implode(',', $this->user->getAuthorisedViewLevels());
		$this->_join = ' LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat USING (product_id)';
		$this->_where = ' WHERE prod.product_publish = 1 AND prod.access IN ('.$groups.')';
		if ($this->type == 'category'){
			if (count($this->subCategoryies)) {
				$this->_join .= ' LEFT JOIN `#__jshopping_categories` AS cat USING (category_id)';
				$this->_where .= ' AND pr_cat.category_id IN ('.implode(',',$this->subCategoryies).')';
				$this->_where .= ' AND cat.category_publish = 1 AND cat.access IN ('.$groups.')';
			} else {
				$this->_where .= ' AND pr_cat.category_id = '.$this->type_id;
			}
		} else {
			$this->_join .= ' LEFT JOIN `#__jshopping_categories` AS cat USING (category_id)';
			if ($this->type == 'manufacturer') {
				$this->_where .= ' AND prod.product_manufacturer_id = '.$this->type_id;
			} else if ($this->type == 'vendor') {
				$main_vendor = JSFactory::getMainVendor();
				if ($this->type_id == $main_vendor->id) {
					$this->_where .= ' AND prod.vendor_id = 0';
				} else { 
					$this->_where .= ' AND prod.vendor_id = '.$this->type_id;
				}
			}
			$this->_where .= ' AND cat.category_publish = 1 AND cat.access IN ('.$groups.')';
		}
		
		foreach ($this->_query as $type=>$query) {
			$tmp_query = $this->_query;
			unset($tmp_query[$type]);
			$this->_adv_query[$type] = implode(' ', $tmp_query);
		}

		$json = new stdClass();

		if (isset($this->_adv_query['categorys'])){
			if (count($this->subCategoryies)) {
				$query = 'SELECT DISTINCT cat.category_id FROM `#__jshopping_products` AS prod'
						.$this->_join
						.' WHERE prod.product_publish = 1 AND prod.access IN ('.$groups.')'
						.' AND cat.category_publish = 1 AND cat.access IN ('.$groups.')'
						.$this->_adv_query['categorys']
						;
				$this->db->setQuery($query);
				$json->result['categorys[]'] = $this->db->loadColumn();
			} else if ($this->type != 'category') {
				$query = 'SELECT DISTINCT cat.category_id FROM `#__jshopping_products` AS prod'
						.$this->_join
						.$this->_where
						.$this->_adv_query['categorys']
						;
				$this->db->setQuery($query);
				$json->result['categorys[]'] = $this->db->loadColumn();
			}
		}

		if (isset($this->_adv_query['manufacturers'])){
			$query = 'SELECT DISTINCT prod.product_manufacturer_id FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['manufacturers']
					;
			$this->db->setQuery($query);
			$json->result['manufacturers[]'] = $this->db->loadColumn();
		}

		if (isset($this->_adv_query['vendors'])) {
			$query = 'SELECT DISTINCT prod.vendor_id FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['vendors']
					;
			$this->db->setQuery($query);
			$raw = $this->db->loadColumn();
			if (in_array('0', $raw)) {
				$main_vendor = JSFactory::getMainVendor();
				$raw[] = $main_vendor->id;
			}
			$json->result['vendors[]'] = $raw;
		}
		
		if (isset($this->_adv_query['labels'])) {
			$query = 'SELECT DISTINCT prod.label_id FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['labels']
					;
			$this->db->setQuery($query);
			$json->result['labels[]'] = $this->db->loadColumn();
		}

		if (isset($this->_adv_query['delivery_times'])) {
			$query = 'SELECT DISTINCT prod.delivery_times_id FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['delivery_times']
					;
			$this->db->setQuery($query);
			$json->result['delivery_times[]'] = $this->db->loadColumn();
		}

		if (isset($this->_adv_query['photo'])) {
			if (version_compare(JVERSION,'3.0.0','>=')) {
				$tbl_column = 'image';
			} else {
				$tbl_column = 'product_name_image';
			}
			$query = 'SELECT DISTINCT prod.'.$tbl_column.' FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['photo']
					;
			$this->db->setQuery($query);
			$raw = $this->db->loadColumn();
			$json->result['photo'] = array('0');
			if (in_array(true, $raw)) {
				$json->result['photo'][] = '1';
			}
			if (in_array(false, $raw)) {
				$json->result['photo'][] = '2';
			}
		}

		if (isset($this->_adv_query['availability'])) {
			$query = 'SELECT DISTINCT prod.product_quantity FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['availability']
					;
			$this->db->setQuery($query);
			$raw = $this->db->loadColumn();
			$json->result['availability'] = array('0');
			if (in_array(true, $raw)) {
				$json->result['availability'][] = '1';
			}
			if (in_array(false, $raw)) {
				$json->result['availability'][] = '2';
			}
		}

		if (isset($this->_adv_query['sales'])) {
			$query = 'SELECT count(*) FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.' AND prod.product_old_price > prod.product_price'
					.$this->_adv_query['sales']
					;
			$this->db->setQuery($query);
			if ($this->db->loadResult()) {
				$json->result['sales[]'] = array('0','1');
			} else {
				$json->result['sales[]'] = array('0');
			}
		}

		if (isset($this->_adv_query['additional_prices'])) {
			$query = 'SELECT count(*) FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.' AND prod.product_is_add_price > 0'
					.$this->_adv_query['additional_prices']
					;
			if ($this->db->loadResult()) {
				$json->result['additional_prices[]'] = array('0','1');
			} else {
				$json->result['additional_prices[]'] = array('0');
			}
		}

		if (isset($this->_adv_query['reviews'])) {
			$query = 'SELECT count(*) FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.' AND prod.reviews_count > 0'
					.$this->_adv_query['reviews']
					;
			$this->db->setQuery($query);
			if ($this->db->loadResult()) {
				$json->result['reviews[]'] = array('0','1');
			} else {
				$json->result['reviews[]'] = array('0');
			}
		}

		if (isset($this->_adv_query['extra_fields'])) {
			foreach($this->_queryExtraField as $id=>$query) {
				$tmp_query = $this->_queryExtraField;
				unset($tmp_query[$id]);
				$query = 'SELECT DISTINCT prod.extra_field_'.$id.' FROM `#__jshopping_products` AS prod'
					.$this->_join
					.$this->_where
					.$this->_adv_query['extra_fields']
					.implode(' ', $tmp_query)
					;
				$this->db->setQuery($query);
				$product_extra_fields = $this->db->loadColumn();
				$product_extra_fields_k = array();
				foreach($product_extra_fields as $value) {
					if ($this->allProductExtraField[$id]->type == 1 && $value != '') {
						$product_extra_fields_k[] = urlencode($value);
					} else {
						$explode_vals = explode(',', $value);
						foreach($explode_vals as $explode_val) {
							if ($explode_val) {
								$product_extra_fields_k[] = $explode_val;
							}
						}
					}
				}
				$json->result['characteristics['.$id.'][]'] = $product_extra_fields_k;
			}
		}

		if (isset($this->_adv_query['attributes'])) {
			foreach($this->_queryAttributes as $id=>$query) {
				$tmp_query = $this->_queryAttributes;
				unset($tmp_query[$id]);
				$query = 'SELECT DISTINCT attr.attr_value_id FROM `#__jshopping_products_attr2` AS attr
					LEFT JOIN `#__jshopping_products_attr2` AS attr2 USING (product_id)
					LEFT JOIN `#__jshopping_products` AS prod USING (product_id)'
					.$this->_join
					.$this->_where
					.$this->_adv_query['attributes']
					.implode(' ', $tmp_query)
					;
				$this->db->setQuery($query);
				$json->result['attributes['.$id.'][]'] = $this->db->loadColumn();
			}
		}

		if (isset($this->_adv_query['d_attributes'])) {
			foreach($this->_queryD_Attributes as $id=>$query) {
				$tmp_query = $this->_queryD_Attributes;
				unset($tmp_query[$id]);
				$query = 'SELECT DISTINCT d_attr.attr_'.$id.' FROM `#__jshopping_products_attr` as d_attr
					LEFT JOIN `#__jshopping_products` AS prod USING (product_id)'
					.$this->_join
					.$this->_where
					.$this->_adv_query['d_attributes']
					.implode(' ', $tmp_query)
					;
				$this->db->setQuery($query);
				$json->result['d_attributes['.$id.'][]'] = $this->db->loadColumn();
			}
		}

		if (isset($this->_adv_query['prices'])) {
			if ($this->jshopConfig->display_price_admin == $this->jshopConfig->display_price_front) {
				$join = '';
				$selectTax = '';
			} else {
				$join = ' LEFT JOIN `#__jshopping_taxes` AS tax ON prod.product_tax_id = tax.tax_id';
				if ($this->jshopConfig->display_price_admin) {
					$selectTax = ' * ';
				} else {
					$selectTax = ' / ';
				}
				$selectTax .= '(1 + tax.tax_value / 100)';
			}
			$select = 'MIN(prod.product_price / cr.currency_value'.$selectTax.') AS prod_price_min, MAX(prod.product_price / cr.currency_value'.$selectTax.') AS prod_price_max';
			if ($this->modParams->attributes_prices) {
				$join .= ' LEFT JOIN `#__jshopping_products_attr` as attr ON prod.product_id = attr.product_id';
				$select .= ', MIN(attr.price / cr.currency_value'.$selectTax.') AS attr_price_min, MAX(attr.price / cr.currency_value'.$selectTax.') AS attr_price_max';
			}
			$query = 'SELECT 
					'.$select.'
					FROM `#__jshopping_products` AS prod'
					.$this->_join.'
					LEFT JOIN `#__jshopping_currencies` AS cr ON prod.currency_id = cr.currency_id'
					.$join
					.$this->_where
					.$this->_adv_query['prices'];
			$this->db->setQuery($query);
			$row = $this->db->loadObject();
			$priceRange = new stdClass();
			$priceRange->from = $row->prod_price_min;
			$priceRange->to = $row->prod_price_max;
			if ($this->modParams->attributes_prices) {
				if ((float)$row->attr_price_min < $row->prod_price_min) {
					$priceRange->from = (float)$row->attr_price_min;
				}
				if ((float)$row->attr_price_max > $row->prod_price_max) {
					$priceRange->to = (float)$row->attr_price_max;
				}
			}
			$percentageDiscount = 1 - $this->userShop->percent_discount / 100;
			$json->pricefrom = floor($priceRange->from * $this->jshopConfig->currency_value * $percentageDiscount);
			$json->priceto = ceil($priceRange->to * $this->jshopConfig->currency_value * $percentageDiscount);
		}

		$json->total = $view->pagination_obj->total;
		$json->view = $view->loadTemplate();

		echo json_encode($json);
		die;
	}

}
?>