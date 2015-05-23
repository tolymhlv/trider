<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewStatistic extends JViewLegacy
{
    function display($tpl=null){
        
        JToolBarHelper::title( _JSHOP_LIST_ORDER_STATUSS, 'generic.png' ); 
        //JToolBarHelper::addNew();
        //JToolBarHelper::deleteList();
        
        parent::display($tpl);
	}
}
?>