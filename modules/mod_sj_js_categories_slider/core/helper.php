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

include_once dirname(__FILE__).'/helper_base.php';

class JsSliderHelper extends JsSliderBaseHelper{

	public static function getList(&$params)
	{
		$db = JFactory::getDBO();
		$jshopConfig = JSFactory::getConfig();
		$jshopConfig->cur_lang = $jshopConfig->frontend_lang;
		JSFactory::loadCssFiles();
		JSFactory::loadLanguageFile();
		$lang = JSFactory::getLang();
		$jshopConfig = JSFactory::getConfig();
		$field_sort = $params->get('sort', 'id');
		$ordering = $params->get('ordering', 'asc');
		$count_cat= (int)$params->get('count_cat',10);
		$catids = $params->get('catids',0);
		$_catids = array();
		$list = array();
		settype($catids,'array');
		for($i = 0 ; $i< count($catids) ; $i++){
			if($catids[$i] == ''){
				$catids[$i] = 0;
			}
			if(count($catids) > 1 && in_array(0, $catids)){
				if($catids[$i] == 0){
					unset($catids[$i]);
				}
			}
		}
		$category = JTable::getInstance('category', 'jshop');
		$categories = $category->getAllCategories();
		foreach($categories as $cat_id){
			$_catids[] = $cat_id->category_id;
		}
		
		foreach($_catids as $i=> $_cat_id){
		
			if(isset($catids[0]) && $catids[0] == 0){
				$_catid = implode(",", $_catids);
				
			}else{
				$_catid = implode(",", $catids);
				
			}	
		}
		
		$list = self::getCategory($_catid,$field_sort,$ordering,1);
		
		if(!empty($list)){
			$list = ($count_cat > 0)?array_slice($list, 0 , $count_cat ):$list;
			foreach($list as $i=> $item){
				$item->_description = self::_cleanText($item->description);
				self::getJSCImages($item, $params,'imgcfgcat');
			}
		}
		return $list;	
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
