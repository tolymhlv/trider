<?php
	defined( '_JEXEC' ) or die();
	displaySubmenuOptions("attributes");
	$rows=$this->rows;
	$attr_id=$this->attr_id;
	$count=count ($rows);
	$i=0;
	$saveOrder = $this->filter_order_Dir=="asc" && $this->filter_order=="value_ordering";
?>
<form action="index.php?option=com_jshopping&controller=attributesvalues&attr_id=<?php echo $attr_id?>" method="post" name="adminForm" id="adminForm">

<table class="table table-striped">
<thead>
  <tr>
    <th class="title" width ="10">
      #
    </th>
    <th width="20">
	  <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    </th>
    <th width="200" align="left">
      <?php echo JHTML::_('grid.sort', _JSHOP_NAME_ATTRIBUT_VALUE, 'name', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
    <th align="left">
      <?php echo _JSHOP_IMAGE_ATTRIBUT_VALUE;?>
    </th>
    <th colspan="3" width="40">
    	<?php echo JHTML::_('grid.sort', _JSHOP_ORDERING, 'value_ordering', $this->filter_order_Dir, $this->filter_order); ?>
        <?php if ($saveOrder){?>
        <?php echo JHtml::_('grid.order',  $rows, 'filesave.png', 'saveorder');?>
        <?php }?>
    </th>
	<th width="50">
        <?php echo _JSHOP_EDIT;?>
    </th>
    <th width="40">
        <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'value_id', $this->filter_order_Dir, $this->filter_order); ?>
    </th>
  </tr>
</thead>
<?php foreach ($rows as $row){ ?>
  <tr class="row<?php echo $i % 2;?>">
   <td>
     <?php echo $i + 1;?>
   </td>
   <td>     
     <?php echo JHtml::_('grid.id', $i, $row->value_id);?>
   </td>
   <td>
     <a href="index.php?option=com_jshopping&controller=attributesvalues&task=edit&value_id=<?php echo $row->value_id; ?>&attr_id=<?php echo $attr_id?>"><?php echo $row->name;?></a>
   </td>
   <td>
     <?php if ($row->image) {?>
       <img src="<?php echo $this->config->image_attributes_live_path."/".$row->image?>"  alt="" width="20" height="20" />
     <?php }?>
   </td>
   <td align="right" width="20">
    <?php
      if ($i != 0 && $saveOrder) echo '<a href="index.php?option=com_jshopping&controller=attributesvalues&task=order&id=' . $row->value_id . '&order=up&number=' . $row->value_ordering . '&attr_id=' . $attr_id . '"><img alt="' . _JSHOP_UP . '" src="components/com_jshopping/images/uparrow.png"/></a>';
    ?>
   </td>
   <td align="left" width="20">
      <?php
        if ($i != $count - 1 && $saveOrder) echo '<a href="index.php?option=com_jshopping&controller=attributesvalues&task=order&id=' . $row->value_id . '&order=down&number=' . $row->value_ordering . '&attr_id=' . $attr_id . '"><img alt="' . _JSHOP_DOWN . '" src="components/com_jshopping/images/downarrow.png"/></a>';
      ?>
   </td>
   <td align="center" width="10">
    <input type="text" name="order[]" id="ord<?php echo $row->value_id;?>" size="5" value="<?php echo $row->value_ordering?>" <?php if (!$saveOrder) echo 'disabled'?> class="inputordering" style="text-align: center" />
   </td>
   <td align="center">
        <a href="index.php?option=com_jshopping&controller=attributesvalues&task=edit&value_id=<?php echo $row->value_id; ?>&attr_id=<?php echo $attr_id?>"><img src='components/com_jshopping/images/icon-16-edit.png'></a>
   </td>
   <td align="center">
    <?php print $row->value_id;?>
   </td>
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