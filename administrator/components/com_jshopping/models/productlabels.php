<?php
/**
* @version      4.1.0 03.11.2010
* @author       MAXXmarketing GmbH
* @package      Jshopping
* @copyright    Copyright (C) 2010 webdesigner-profi.de. All rights reserved.
* @license      GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.model');

class JshoppingModelProductLabels extends JModelLegacy{    

    function getList($order = null, $orderDir = null){
        $db = JFactory::getDBO();
        $ordering = "name";
        if ($order && $orderDir){
            $ordering = $order." ".$orderDir;
        }
        
        $query = "SELECT * FROM `#__jshopping_product_labels` ORDER BY ".$ordering;
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
}
?>