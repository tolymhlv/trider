<?php
/**
 * @package Sj Basic News
 * @version 2.5
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 * 
 */
defined('_JEXEC') or die;
defined( 'DS') or define('DS', DIRECTORY_SEPARATOR);
defined('_YTOOLS') or include_once 'core' . DS . 'sjimport.php';

// set current module for working
YTools::setModule($module);

YTools::stylesheet('style.css');

include_once   "core" . DS . 'helper.php';
$layout_name =($params->get('layout'))? $params->get('layout'):'default';
$cacheid = md5(serialize(array ($layout_name, $module->module)));
$cacheparams = new stdClass;
$cacheparams->cachemode = 'id';
$cacheparams->class = 'sj_basic_new_helper';
$cacheparams->method = 'getList';
$cacheparams->methodparams = array($params, $module);
$cacheparams->modeparams = $cacheid;
$list = JModuleHelper::moduleCache ($module, $params, $cacheparams);
include JModuleHelper::getLayoutPath($module->module, $layout_name); 