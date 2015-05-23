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

$installer = new JInstaller();
$installer->update($extractdir);
$back = $installer->getRedirectURL();
$adapter = $installer->get('_adapters');
@JFile::delete(JPATH_ROOT.'/'.$adapter['file']->element.'.xml');
$xml = JFactory::getXML(JPATH_COMPONENT_ADMINISTRATOR . '/jshopping.xml');
if (version_compare(trim($xml->version), '3.14.0', '<')) {
    @JFolder::delete($extractdir);
}
?>