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

if (!JComponentHelper::isEnabled('com_jshopping')){
    return;
}

require_once JPATH_SITE.'/components/com_jshopping/lib/factory.php';
require_once JPATH_SITE.'/components/com_jshopping/lib/functions.php';
require_once dirname(__FILE__).'/helper.php';

JSFactory::loadCssFiles();
JSFactory::loadLanguageFile();

$modHelper = new modJshopping_Unijax_FilterHelper($params);

if (!$modHelper->params->output_products) {
	return;
}
if (!$modHelper->params->output_main_page && $modHelper->controller=='category' && !$modHelper->category_id) {
	return;
}
if (!$modHelper->params->output_product_page && $modHelper->controller=='product') {
	return;
}
if ($modHelper->params->output_product_list && $modHelper->type=='all' && $modHelper->controller!='products' && $modHelper->controller!='category' && $modHelper->controller!='product') {
	return;
}

$displayFilters = array();

if ($modHelper->params->show_prices) {
	$priceFrom = saveAsPrice($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'pricefrom', 'pricefrom','','int+'));
	$priceTo = saveAsPrice($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'priceto', 'priceto','','int+'));
	
	$modHelper->getDisplayPrices();
	if ($modHelper->params->once_option) {
		if ($modHelper->priceRange->from != $modHelper->priceRange->to) {
			$displayFilters['price'] = 1;
		}
	} else if ($modHelper->priceRange->from || $modHelper->priceRange->to) {
		$displayFilters['price'] = 1;
	}
}

$displayCategorys = array();
if ($modHelper->params->show_categorys || ($modHelper->params->output_product_qty && $modHelper->type == 'vendor')) {
	$displayCategorys = $modHelper->getDisplayCategorys($modHelper->params->sort_categorys);
	$count = count($displayCategorys);
	if (!$count && $modHelper->params->output_product_qty && $modHelper->type == 'vendor') {
		return;
	} else if ($modHelper->params->show_categorys && $count > $modHelper->params->once_option) {
		$activeCategorys = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'categorys', 'categorys', array()), 'int+');
		$displayFilters['category'] = $count;
	}
}

$displayManufacturers = array();
if ($modHelper->params->show_manufacturers && $modHelper->type != 'manufacturer') {
	$displayManufacturers = $modHelper->getDisplayManufacturers($modHelper->params->sort_manufacturers);
	$count = count($displayManufacturers);
	if ($count > $modHelper->params->once_option) {
		$activeManufacturers = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'manufacturers', 'manufacturers', array()), 'int+');    
		$displayFilters['manufacturer'] = $count;
	}
}

$displayVendors = array();
if ($modHelper->type != 'vendor') {
	$displayVendors = $modHelper->getDisplayVendors($modHelper->params->sort_vendors);
	$count = count($displayVendors);
	if (!$count && $modHelper->params->output_product_qty) {
		return;
	} else if ($modHelper->params->show_vendors && $count > $modHelper->params->once_option) {
		$activeVendors = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'vendors', 'vendors', array()), 'int+');
		$displayFilters['vendor'] = $count;
	}
}

$displayCharacteristics = array();
if ($modHelper->params->show_characteristics) {
	$displayCharacteristics = $modHelper->getDisplayCharacteristics();
	$count = count($displayCharacteristics);
	if ($count > 0) {
		$activeCharacteristics = $modHelper->filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'characteristics', 'characteristics', array()));
		$displayFilters['characteristic'] = $count;
	}
}

$displayAttributes = array();
if ($modHelper->params->show_attributes) {
	$displayAttributes = $modHelper->getDisplayAttributes();
	$count = count($displayAttributes);
	if ($count > 0) {
		$activeAttributes =  filterAllowValue($app->getUserStateFromRequest($contextfilter.'d_attributes', 'd_attributes', array()), "array_int_k_v+") + filterAllowValue($app->getUserStateFromRequest($contextfilter.'attributes', 'attributes', array()), "array_int_k_v+");
		$displayFilters['attribute'] = $count;
	}
}  

$displayLabels = array();
if ($modHelper->params->show_labels) {
	$displayLabels = $modHelper->getDisplayLabels();
	$count = count($displayLabels);
	if ($count > $modHelper->params->once_option) {
		$activeLabels = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'labels', 'labels', array()), 'int+');
		$displayFilters['label'] = $count;
	}
}

$displayDeliveryTimes = array();
if ($modHelper->params->show_delivery_times) {
	$displayDeliveryTimes = $modHelper->getDisplayDeliveryTimes();
	$count = count($displayDeliveryTimes);
	if ($count > $modHelper->params->once_option) {
		$activeDeliveryTimes = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'delivery_times', 'delivery_times', array()), 'int+');
		$displayFilters['delivery_time'] = $count;
	}
}

if ($modHelper->params->show_photos) {
	$activePhoto = $modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'photo', 'photo');
	$displayFilters['photo'] = 1;
}

if ($modHelper->params->show_availabilitys && !$modHelper->jshopConfig->hide_product_not_avaible_stock) {
	$activeAvailability = $modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'availability', 'availability');
	$displayFilters['availability'] = 1;
}

if ($modHelper->params->show_sales) {
	$activeSales = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'sales', 'sales'), 'int+');
	$displayFilters['sale'] = 1;
}

if ($modHelper->params->show_additional_prices) {
	$activeAdditionalPrices = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'additional_prices', 'additional_prices'), 'int+');
	$displayFilters['additional_price'] = 1;
}

if ($modHelper->params->show_reviews) {
	$activeReviews = filterAllowValue($modHelper->app->getUserStateFromRequest($modHelper->contextfilter.'reviews', 'reviews'), 'int+');
	$displayFilters['review'] = 1;
}

if (!count($displayFilters)) return;

$document = JFactory::getDocument();
$layout = $params->get('layout', 'default');
$document->addScript(JURI::base().'modules/'.$module->module.'/js/'.substr($layout, 2).'.js');
$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/css/'.substr($layout, 2).'.css');
if ($modHelper->params->load_scripts && version_compare(JVERSION,'3.0.0','>=')) {
	JHtml::_('script', 'jui/chosen.jquery.min.js', false, true, false, false, false);
	JHtml::_('stylesheet', 'jui/chosen.css', false, true);
} else {
	$document->addScript(JURI::base().'modules/'.$module->module.'/js/chosen.jquery.min.js');
	$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/css/chosen.css');
}

require JModuleHelper::getLayoutPath($module->module, $layout);
include dirname(__FILE__).'/js/'.substr($layout, 2).'.js.php';
?>