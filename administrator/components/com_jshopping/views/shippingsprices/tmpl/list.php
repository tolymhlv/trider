<?php
	defined( '_JEXEC' ) or die();
	displaySubmenuOptions("shippingsprices");
	$shipping_prices=$this->rows;
	$i=0;
?>
<form name="adminForm" id="adminForm" action="index.php?option=com_jshopping&controller=shippingsprices" method="post">

<table class="table table-striped">
<thead>
	<tr class="row<?php echo $i % 2;?>">
    	<th class="title" width ="10">
      		#
    	</th>
    	<th width="20">
	  		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
    	</th>
    	<th align="left">
      		<?php echo JHTML::_('grid.sort', _JSHOP_TITLE, 'name', $this->filter_order_Dir, $this->filter_order); ?>
    	</th>
        <th>
            <?php echo _JSHOP_COUNTRIES; ?>
        </th>
        <th width="100">
            <?php echo JHTML::_('grid.sort', _JSHOP_PRICE, 'shipping_price.shipping_stand_price', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
    	<th width="70">
	        <?php echo _JSHOP_EDIT; ?>
	    </th>
        <th width="40">
            <?php echo JHTML::_('grid.sort', _JSHOP_ID, 'shipping_price.sh_pr_method_id', $this->filter_order_Dir, $this->filter_order); ?>
        </th>
  	</tr>
</thead>
<?php foreach($shipping_prices as $row){?>
<tr>
	<td>
		<?php echo $i + 1;?>
	</td>
	<td>		
        <?php echo JHtml::_('grid.id', $i, $row->sh_pr_method_id);?>
	</td>
	<td>
		<a href="index.php?option=com_jshopping&controller=shippingsprices&task=edit&sh_pr_method_id=<?php echo $row->sh_pr_method_id?>&shipping_id_back=<?php print $this->shipping_id_back?>"><?php echo $row->name;?></a>
	</td>
    <td>
        <?php print $row->countries; ?>
    </td>
    <td>
        <?php print formatprice($row->shipping_stand_price);?>
    </td>
	<td align="center">
        <a href='index.php?option=com_jshopping&controller=shippingsprices&task=edit&sh_pr_method_id=<?php echo $row->sh_pr_method_id?>&shipping_id_back=<?php print $this->shipping_id_back?>'><img src='components/com_jshopping/images/icon-16-edit.png'></a>
   </td>
   <td align="center">
    <?php print  $row->sh_pr_method_id;?>
   </td>  
</tr>
<?php $i++;} ?>
</table>

<input type="hidden" name="filter_order" value="<?php echo $this->filter_order?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter_order_Dir?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="shipping_id_back" value="<?php echo $this->shipping_id_back;?>" />
<input type="hidden" name="hidemainmenu" value="0" />
<input type="hidden" name="boxchecked" value="0" />
</form>