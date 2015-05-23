<?php
/**
 * @package Sj Products for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;

include_once dirname(__FILE__).'/helper_base.php';
if (!file_exists(JPATH_SITE.'/components/com_jshopping/jshopping.php')){
	JError::raiseError(500,"Please install component \"joomshopping\"");
}
require_once (JPATH_SITE.'/components/com_jshopping/lib/factory.php');
require_once (JPATH_SITE.'/components/com_jshopping/lib/functions.php');


class SjProducts extends BaseHelperSJProducts{


	public static function getList(&$params)
	{
		$db = JFactory::getDBO();
		$jshopConfig = JSFactory::getConfig();
		$jshopConfig->cur_lang = $jshopConfig->frontend_lang;
		JSFactory::loadCssFiles();
		JSFactory::loadLanguageFile();
		$lang = JSFactory::getLang();
		$product = JTable::getInstance('product', 'jshop');
		$cat_str = $params->get('catids', NULL);
		if( $cat_str = null || $cat_str[0]=='' ){
			$cat_ar = array();
			$query = "SELECT category_id FROM #__jshopping_categories";
			$db->setQuery($query);
			$results = $db->loadColumn();
			$cat_str = $results;
		}else{
			$cat_str = $params->get('catids', NULL);
			$cat_str = array_filter($cat_str);
			$cat_str = $cat_str;
		}
		if (is_array($cat_str)) {
			$cat_arr = array();
			foreach($cat_str as $key=>$curr){
				if (intval($curr)) $cat_arr[$key] = intval($curr);
			}
		} else {
			$cat_arr = array();
			if (intval($cat_str)) $cat_arr[] = intval($cat_str);
		}
		$filter = array();
		$filter['categorys']= $cat_arr;
		$order_by = $params->get('product_order_by');
		if( $order_by == 'name' ){
			$order_by = "prod.`".$lang->get('name')."`";
		}
		$order_dir = $params->get('product_order_dir');
		$limit = $params->get('source_limit');
		$limit_title = $params->get('limit_title');
		$limit_description = $params->get('limit_desc');	
		
		//
		$list_cate = array();
		$items = array();
		$catid = implode(", ", $cat_str);
		$categories = self::getCategory($catid,1);
		if(!empty($categories)){
			foreach($categories as $i=> $category){					
				$category->count = 0;
				$list_cate[$category->category_id] = $category;
			}
			
			$items['categories'] = $list_cate;
			//var_dump($items['categories']);return;
			
			$items = $product->getAllProducts($filter, $order_by, " ".$order_dir, 0, $limit);	
		
			foreach($items as $key=>$value){
			
				$category = self::getCategory($value->category_id,1);
				$category = $list_cate[$value->category_id];
				 
				if(isset($category->count)){
						$category->count ++;
				}else{
					$category->count = 1;
				}
				$value->category_title = $category->name;				
				
				$product->load($value->product_id);
				$images = $product->getImages();
				foreach ( $images as $image ){
					$value->product_thumb_image = $image->image_thumb;
					$value->product_name_image = $image->image_full;
				}
				$query ="SELECT prod.product_date_added, prod.date_modify, prod.`".$lang->get('description')."` as description FROM #__jshopping_products AS prod WHERE prod.product_id =".$value->product_id;
				$db->setQuery($query);
				$list = $db->loadObjectList();
				foreach ($list as $product_info){
					$value->product_date_added = $product_info->product_date_added;
					$value->date_modify = $product_info->date_modify;
					$description = SjProducts::_cleanText($product_info->description);
					$value->description = $description;					
				} 
				
				/*$query_man ="SELECT manu.`".$lang->get('name')."` as name FROM #__jshopping_manufacturers AS manu WHERE manu.manufacturer_id = ".$value->product_manufacturer_id;
				$db->setQuery($query_man);
				$manufacturer_pro = $db->loadResult();
				//$value->manufacturer_name = $manufacturer_pro['name'];
				//var_dump($manufacturer_pro['name']); return;*/
				
				$items[$key]->link = SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $value->category_id.'&product_id=' . $value->product_id ,1);
				
				$value->tax = productTaxInfo($product->getTax()).' '.sprintf(_JSHOP_PLUS_SHIPPING, $product->shippinginfo) ;			
				
				
				$value->title = SjProducts::truncate($value->name, $limit_title);
				$description_short = SjProducts::_cleanText($value->short_description);
				if(empty($description_short)){
					$value->short_description = SjProducts::truncate($description, $limit_description);
				}else{
					$value->short_description = SjProducts::truncate($description_short, $limit_description);
				}			
			}
			
		  }
		 
		 return $items;	
		}
		
		
		public static   function getCategory($catid, $publish = 0) {
			$_db = JFactory::getDBO();
			$lang = JSFactory::getLang();
			$user = JFactory::getUser();
			$add_where = ($publish)?(" AND category_publish = '1' "):("");
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$add_where .=' AND access IN ('.$groups.')';
			if ($order=="id") $orderby = "category_id";
			if ($order=="name") $orderby = "`".$lang->get('name')."`";
			if ($order=="ordering") $orderby = "ordering";
			if (!$orderby) $orderby = "ordering";
			
			$query = "SELECT `".$lang->get('name')."` as name,`".$lang->get('description')."` as description,`".$lang->get('short_description')."` as short_description, category_id, category_publish, ordering, category_image FROM `#__jshopping_categories`
					   WHERE category_id IN (".$catid.") ";
			$_db->setQuery($query);
			$categories = $_db->loadObjectList();
			foreach($categories as $key=>$value){
				$categories[$key]->link = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$categories[$key]->category_id, 1);
			}        
		return $categories;
	}
		
	
	public static function include_js($file, $framework=false, $relative=true){
		$basename = basename($file);
		if ($basename != $file){
			if (JHtml::script($basename, $framework, $relative, $pathonly = true)){
				JHtml::script($basename, $framework, $relative);
				return;
			}
		}
		// use Joomla! method
		JHtml::script($file, $framework, $relative);
	}
	
	public static function include_jquery($extension='', $framework=false, $relative=true){
		if ( version_compare(JVERSION, '3.0.0', '>=') ){
			JHtmlJquery::framework();
		} else {
			$doc = JFactory::getDocument();
			if (!isset($doc->jquery_loaded)){
				if (JHtml::script('jquery.min.js', $framework, $relative, $pathonly = true)){
					JHtml::script('jquery.min.js', $framework, $relative);
					JHtml::script('jquery.noconflict.js', $framework, $relative);
					$doc->jquery_loaded = true;
					return;
				} else if (!empty($extension)){
					$jquery   = $extension.'/jquery.min.js';
					$jqueryNC = $extension.'/jquery.noconflict.js'; // should be locate as jquery.min.js
					if (JHtml::script($jquery, $framework, $relative, $pathonly = true)){
						JHtml::script($jquery, $framework, $relative);
						JHtml::script($jqueryNC, $framework, $relative);
						$doc->jquery_loaded = true;
					}
				}
			}
		}
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

}?>
