<?php
	defined( '_JEXEC' ) or die();
	displaySubmenuOptions("taxes");
	$rows=$this->rows;
	$i=0;
?>
<form action="index.php?option=com_jshopping&controller=exttaxes&back_tax_id=<?php print $this->back_tax_id;?>" method="post" name="adminForm" id="adminForm">
<table class="table table-striped">
<thead>
  <tr>
    <th class="title" width ="10">
      #
    </th>
    <th width="20">
      <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    </th>
    <th align="left">
        <?php echo _JSHOP_TITLE; ?>
    </th>
    <th>
        <?php echo _JSHOP_COUNTRY; ?>
    </th>
    <th width="60">
        <?php echo JHTML::_('grid.sort', _JSHOP_TAX, 'ET.tax', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th width="60">
        <?php 
        if ($this->config->ext_tax_rule_for==1) 
            echo JHTML::_('grid.sort', _JSHOP_USER_WITH_TAX_ID_TAX, 'ET.firma_tax', $this->filter_order_Dir, $this->filter_order);
        else
            echo JHTML::_('grid.sort', _JSHOP_FIRMA_TAX, 'ET.firma_tax', $this->filter_order_Dir, $this->filter_order);
        ?>
    </th>
    <th width="50">
        <?php echo _JSHOP_EDIT; ?>
    </th>
    <th width="40">
        <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'ET.id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
</thead>  
<?php foreach($rows as $row){?>
  <tr class="row<?php echo $i % 2;?>">
   <td>
     <?php echo $i+1;?>
   </td>
   <td>     
     <?php echo JHtml::_('grid.id', $i, $row->id);?>
   </td>
   <td>
     <?php echo $row->tax_name;?>
   </td>
   <td>
    <?php echo $row->countries;?>
   </td>
   <td>
    <?php echo $row->tax;?> %
   </td>
   <td>
    <?php echo $row->firma_tax;?> %
   </td>
   <td align="center">
        <?php print "<a href='index.php?option=com_jshopping&controller=exttaxes&task=edit&id=".$row->id."&back_tax_id=".$this->back_tax_id."'><img src='components/com_jshopping/images/icon-16-edit.png'></a>"?>
   </td>
   <td align="center">
        <?php print $row->id;?>
   </td>
  </tr>
<?php
$i++;
}
?>
</table>

<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
</form>