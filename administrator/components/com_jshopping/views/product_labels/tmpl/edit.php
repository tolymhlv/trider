<?php
	defined( '_JEXEC' ) or die();
	$row=$this->productLabel;
?>
<div class="jshop_edit">
<form action="index.php?option=com_jshopping&controller=productlabels" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
<div class="col100">
<fieldset class="adminform">
<table class="admintable" width="100%" >
   <tr>
     <td class="key">
       <?php echo _JSHOP_NAME;?>*
     </td>
     <td>
       <input type="text" class="inputbox" name="name" value="<?php echo $row->name;?>" />
     </td>
   </tr>
   <tr>
    <td class="key"><?php print _JSHOP_IMAGE?></td>
    <td>
    <?php if ($row->image) {?>
    <div id="image_block">
        <div><img src="<?php echo $this->config->image_labels_live_path."/".$row->image?>" alt=""/></div>
        <div style="padding-bottom:5px;" class="link_delete_foto"><a href="#" onclick="if (confirm('<?php print _JSHOP_DELETE_IMAGE;?>')) deleteFotoLabel('<?php echo $row->id?>');return false;"><img src="components/com_jshopping/images/publish_r.png"> <?php print _JSHOP_DELETE_IMAGE;?></a></div>
    </div>
    <?php }?>    
    <input type="file" name="image" />
    </td>
   </tr>
   <?php $pkey="etemplatevar";if ($this->$pkey){print $this->$pkey;}?>    
</table>
</fieldset>
</div>
<div class="clr"></div>
 
<input type="hidden" name="old_image" value="<?php print $row->image;?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="id" value="<?php echo $row->id?>" />
</form>
</div>