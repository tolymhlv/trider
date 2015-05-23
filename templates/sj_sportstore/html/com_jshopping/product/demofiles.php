<?php defined('_JEXEC') or die(); ?>
<?php
if (count ($this->demofiles)){?>
<div class="list_product_demo">

    <?php foreach($this->demofiles as $demo){?>
    <div class="product_demo_item">
        <div class="descr"><?php print $demo->demo_descr?></div>            
        <?php if ($this->config->demo_type == 1) { ?>
            <div class="download"><a target="_blank" href="<?php print $this->config->demo_product_live_path."/".$demo->demo;?>" onClick="popupWin = window.open('<?php print SEFLink("index.php?option=com_jshopping&controller=product&task=showmedia&media_id=".$demo->id);?>', 'video', 'width=<?php print $this->config->video_product_width;?>,height=<?php print $this->config->video_product_height;?>,top=0,resizable=no,location=no'); popupWin.focus(); return false;"><img src = "<?php print $this->config->live_path.'images/play.gif'; ?>" alt = "play" title = "play"/></a></div>
        <?php } else { ?>
            <div class="download"><a target="_blank" href="<?php print $this->config->demo_product_live_path."/".$demo->demo;?>"><?php print _JSHOP_DOWNLOAD;?></a></div>
        <?php }?>
    </div>
    <?php }?>

</div>
<?php } ?>