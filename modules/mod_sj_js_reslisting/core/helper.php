<?php
/**
 * @package Sj Responsive Listing for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

include_once dirname(__FILE__).'/helper_base.php';

class JSResponsiveListingHelper extends JSResponsiveListingBaseHelper{
	public static $total = null;
	public static function getList(&$params)
	{
		$db = JFactory::getDBO();
		$jshopConfig = JSFactory::getConfig();
		$jshopConfig->cur_lang = $jshopConfig->frontend_lang;
		JSFactory::loadCssFiles();
		JSFactory::loadLanguageFile();
		$lang = JSFactory::getLang();
		$jshopConfig = JSFactory::getConfig();
		
		$filters = array();
		$order_by = $params->get('product_order_by');
		if( $order_by == 'name' ){
			$order_by = "prod.`".$lang->get('name')."`";
		}
		$order_dir = $params->get('product_order_dir');
		
		
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$source_limit = '';
		$limitation = (int)$params->get('source_limit',6);
		$limit_start = $app->input->getInt('ajax_reslisting_start',0);
		$field_sort = $params->get('sort', 'id');
		$ordering = $params->get('ordering', 'asc');
		$count_cat= (int)$params->get('count_cat',10);
		$catids = $params->get('catids');
		$_catids = array();
		$list = array();
		$retur = array();
		if(!empty($catids)){
			$filters['categorys'] = $catids;
			$catid = implode(", ", $catids);
			$product = JTable::getInstance('product', 'jshop');
			self::$total = $product->getCountAllProducts($filters);
			$categories = self::getCategory($catid,$field_sort,$ordering,1);
			if(!empty($categories)){
				foreach($categories as $i=> $category){
					//$cat->_description = self::_cleanText($cat->description);
					//self::getJSCImages($item, $params,'imgcfgcat');
					$category->count = 0;
					$list[$category->category_id] = $category;
				}
				
				$retur['categories'] = $list;
				//var_dump($retur['categories']);return;
				$items = $product->getAllProducts(array_unique($filters), $order_by, " ".$order_dir, $limit_start, $limitation);
				foreach($items as $item){
					$category = self::getCategory($item->category_id,$field_sort,$ordering,1);
					$category = $list[$item->category_id];
					 
					if(isset($category->count)){
							$category->count ++;
					}else{
						$category->count = 1;
					}
					$item->category_title = $category->name;
					$product->load($item->product_id);
					$product->getDescription();
					$item->title = $item->name;	
					$item->product_date_added = $product->product_date_added;
					$item->date_modify = $product->date_modify;
					$item->description = $product->description;
					//self::getJSAImages($item, $params);

					$images = $product->getImages();
					foreach ( $images as $image ){
						$item->product_thumb_image = $image->image_thumb;
						$item->product_name_image = $image->image_full;
					}

					$item->short_desc = self::_cleanText($product->short_description);
					$item->_description =  self::_cleanText($item->description);
					$item->_description = ($item->_description !='')?$item->_description:$item->short_desc;
					$item->link = SEFLink('index.php?option=com_jshopping&controller=product&task=view&category_id=' . $item->category_id.'&product_id=' . $item->product_id ,1);
					
					$item->_tax = productTaxInfo($product->getTax()).' '.sprintf(_JSHOP_PLUS_SHIPPING, $product->shippinginfo) ;
					
				}
				if ($params->get('tab_all_display', 1)){
					$all = new stdClass();
					$all->category_id = '*';
					$all->count = count($items);
					$all->name = JText::_('All');
				
					array_unshift($retur['categories'], $all);
				}
				// default select
				$catidpreload = $params->get('catidpreload');
				$selected = false;
				foreach ($retur['categories'] as $cat){
					if ( $cat->category_id == 1 && $cat->count > 0 ){
						$cat->sel = 'sel';
						$selected = true;
						
					}
				}
				// first tab is active
				if (!$selected){
					foreach ($retur['categories'] as $cat){
						if ($cat->count > 0){
							$cat->sel = 'sel';
							break;
						}
					}
				}
				
				$retur['items'] = $items;
			}
			
		}
		return $retur;	
	}
	
	public static   function getCategory($catid, $order = 'id', $ordering = 'asc', $publish = 0) {
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
                   WHERE category_id IN (".$catid.") ".$add_where."
                   ORDER BY ".$orderby." ".$ordering;
        $_db->setQuery($query);
        $categories = $_db->loadObjectList();
        foreach($categories as $key=>$value){
            $categories[$key]->link = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$categories[$key]->category_id, 1);
        }        
        return $categories;
    }
	
	

}
