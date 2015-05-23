<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewProduct_fields extends JViewLegacy
{
    function displayList($tpl=null){        
        JToolBarHelper::title( _JSHOP_PRODUCT_EXTRA_FIELDS, 'generic.png' ); 
        JToolBarHelper::addNew();
        JToolBarHelper::deleteList();
        JToolBarHelper::spacer();
        JToolBarHelper::custom("addgroup","new-style","new-style",_JSHOP_GROUP, false);        
        parent::display($tpl);
	}
    function displayEdit($tpl=null){
        JToolBarHelper::title( $temp=($this->row->id) ? (_JSHOP_EDIT) : (_JSHOP_NEW), 'generic.png' );
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();        
        parent::display($tpl);
    }
}
?>