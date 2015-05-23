<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class JshoppingViewAttributesValues extends JViewLegacy
{
    function displayList($tpl=null){        
        JToolBarHelper::title( _JSHOP_LIST_ATTRIBUT_VALUES, 'generic.png' );
        JToolBarHelper::custom( "back", 'back', 'back', _JSHOP_RETURN_TO_ATTRIBUTES, false);
        JToolBarHelper::addNew();        
        JToolBarHelper::deleteList();        
        parent::display($tpl);
	}
    function displayEdit($tpl=null){
        JToolBarHelper::title( $temp=($this->attributValue->value_id) ? (_JSHOP_EDIT_ATTRIBUT_VALUE) : (_JSHOP_NEW_ATTRIBUT_VALUE), 'generic.png' ); 
        JToolBarHelper::save();
        JToolBarHelper::spacer();
        JToolBarHelper::apply();
        JToolBarHelper::spacer();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
}
?>