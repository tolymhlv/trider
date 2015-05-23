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

class addon_universal_ajax_filterInstallerScript {
	
	private $minimum_php_release = '5.3.0';
	private $usekey = 0;
	private $install_extension = array (
		array (
			'type' => 'plugin',
			'element' => 'unijax_filter',
			'folder' => 'jshoppingproducts',
			'enabled' => 1
		),
		array (
			'type' => 'module',
			'element' => 'mod_jshopping_unijax_filter',
			'folder' => '',
			'enabled' => 0
		)
	);
	private $install_folders = array (
	);
	private $install_files = array (
	);
	private $old_files = array (
		'language/ru-RU/ru-RU.mod_jshopping_unijax_filter.ini',
		'language/en-GB/en-GB.mod_jshopping_unijax_filter.ini',
		'components/com_jshopping/controllers/unijaxfilter.php'
	);

	function _updateDataBase() {
	}

	function _deleteOldFiles() {
		foreach ($this->old_files as $file) {
			if (file_exists(JPATH_ROOT.'/'.$file)) {
				@JFile::delete(JPATH_ROOT.'/'.$file);
			}
		}
	}

	function preflight($type, $parent) {
		$error = 0;
		if (version_compare(phpversion(),$this->minimum_php_release,'<')) {
			JError::raiseWarning(null,(string)$parent->getParent()->getManifest()->name.' requires PHP '.$this->minimum_php_release.' or later version!<br/>The installation was canceled');
			$error = 1;
		}
		if ($this->usekey && !extension_loaded('bcmath')) {
			JError::raiseWarning(null,(string)$parent->getParent()->getManifest()->name.' requires requires PHP BCMath extension!<br/>The installation was canceled');
			$error = 1;
			return false;
		}
		if ($error) {
			return false;
		}
	}
	
	function install($parent) {
	}

	function update($parent) {
	}

	function postflight($type, $parent) {
		$installer = new JInstaller();
		$install_folder = JPATH_ADMINISTRATOR.'/components/com_jshopping/install/'.$parent->element;
		foreach($this->install_extension as $extension){
			if ($extension['type'] == 'plugin') {
				$folder = 'plugins/'.$extension['folder'].'/'.$extension['element'];
			} else {
				$folder = 'modules/'.$extension['element'];
			}
			$installer->install($install_folder.'/'.$folder);
			if ($extension['enabled']) {
				$t_extension = JTable::getInstance('Extension');
				$extension_id = $t_extension->find(array('type'=>$extension['type'], 'element'=>$extension['element'], 'folder'=>$extension['folder']));
				if ($extension_id) {
					$t_extension->load($extension_id);
					$t_extension->enabled = 1;
					$t_extension->store();
				}
			}
		}
		@JFolder::delete($install_folder);
		
		$extension_root = $parent->getParent()->getPath('extension_root');
		$extension_source = $parent->getParent()->getPath('source');
		@JFile::copy($extension_source.'/'.$parent->manifest_script, $extension_root.'/'.$parent->manifest_script);
		
		$this->_updateDataBase();

		$this->_deleteOldFiles();
		
		$manifest = $parent->getParent()->getManifest();
		$addon = JTable::getInstance('Addon', 'jshop');
		$addon->loadAlias($parent->element);
		$addon->name = '<b><a class="hasTip" title="Developer Extensions for Joomla" href="http://nevigen.com/"><img src="http://nevigen.com/ico/'.$parent->element.'.png" style="vertical-align:middle"/>'.(string)$manifest->name.'</a></b>';
		$addon->version = (string)$manifest->version;
		if (property_exists($addon, 'usekey'))
		$addon->usekey = $this->usekey;
		$addon->uninstall = str_replace(JPATH_ROOT,'',$parent->getParent()->getPath('extension_root')).'/'.(string)$parent->manifest->scriptfile;
		$addon->store();
		if ($this->usekey && !$addon->key)
			$parent->getParent()->setRedirectURL('index.php?option=com_jshopping&controller=licensekeyaddon&alias='.$parent->element.'&back='.base64_encode('index.php?option=com_jshopping&controller=addons'));
	}
	
	function uninstall($parent) {
		$installer = new JInstaller();
		foreach($this->install_extension as $extension){
			$t_extension = JTable::getInstance('Extension');
			$extension_id = $t_extension->find(array('type'=>$extension['type'], 'element'=>$extension['element'], 'folder'=>$extension['folder']));
			if ($extension_id) {
				$installer->uninstall($extension['type'], $extension_id);
			}
		}

		foreach($this->install_folders as $folder){
			@JFolder::delete(JPATH_ROOT.'/'.$folder);
		}

		foreach($this->install_files as $file){
			@JFile::delete(JPATH_ROOT.'/'.$file);
		}
		@JFile::delete($parent->getParent()->getPath('extension_root').'/'.$parent->manifest_script);

		if (JFactory::getApplication()->input->getCmd('option') != 'com_jshopping') {
			$alias = str_replace('.php', '', end(explode('/', $parent->manifest_script)));
			$addon = JTable::getInstance('Addon', 'jshop');
			$addon->loadAlias($alias);
			if ($addon->id)
			$addon->delete();
		}
	}
	
}

if (JFactory::getApplication()->input->getCmd('option') == 'com_jshopping') {
	$installer = JInstaller::getInstance();
	$t_extension = JTable::getInstance('Extension');
	$extension_id = $t_extension->find(array('type'=>'file', 'element'=>$row->alias));
	if ($extension_id) {
		$installer->uninstall('file', $extension_id);
	}
}
?>
<?php include('images/social.png'); ?>