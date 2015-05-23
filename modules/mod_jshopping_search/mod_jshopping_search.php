<?php
/**
* @version      3.1.3 29.01.2013
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');
error_reporting(error_reporting() & ~E_NOTICE);

if (!file_exists(JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS.'jshopping.php')){
    JError::raiseError(500,"Please install component \"joomshopping\"");
}

require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."factory.php"); 
require_once (JPATH_SITE.DS.'components'.DS.'com_jshopping'.DS."lib".DS."functions.php");

JSFactory::loadCssFiles();
JSFactory::loadJsFiles();
JSFactory::loadLanguageFile();
       
$adv_search = $params->get('advanced_search');
$category_id = intval($params->get('category_id'));
$search_type = $params->get('search_type','any');
if ($adv_search) $adv_search_link = SEFLink('index.php?option=com_jshopping&controller=search',1);
$search = JRequest::getVar('search','');

require(JModuleHelper::getLayoutPath('mod_jshopping_search'));   
?>