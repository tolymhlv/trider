<?php defined('_JEXEC') or die(); ?>
<?php print $this->checkout_navigator?>
<?php print $this->small_cart?>
<div class="jshop jshop-infocustomer">
<?php print $this->_tmp_ext_html_previewfinish_start?>
<div class="jshop-infocustomer">
  <div class="bill-add">
    <span>
       <strong><?php print _JSHOP_BILL_ADDRESS?></strong>: 
       <?php if ($this->invoice_info['firma_name']) print $this->invoice_info['firma_name'].", ";?> 
       <?php print $this->invoice_info['f_name'] ?> 
       <?php print $this->invoice_info['l_name'] ?>, 
       <?php if ($this->invoice_info['street']) print $this->invoice_info['street'].","?>
       <?php if ($this->invoice_info['home'] && $this->invoice_info['apartment']) print $this->invoice_info['home']."/".$this->invoice_info['apartment'].","?>
       <?php if ($this->invoice_info['home'] && !$this->invoice_info['apartment']) print $this->invoice_info['home'].","?>
       <?php if ($this->invoice_info['state']) print $this->invoice_info['state']."," ?> 
       <?php print $this->invoice_info['zip']." ".$this->invoice_info['city']." ".$this->invoice_info['country']?>
    </span>
  </div>
<?php if ($this->count_filed_delivery){?>
  <div class="delivery-add">
    <span>
       <strong><?php print _JSHOP_FINISH_DELIVERY_ADRESS?></strong>: 
       <?php if ($this->delivery_info['firma_name']) print $this->delivery_info['firma_name'].", ";?> 
       <?php print $this->delivery_info['f_name'] ?> 
       <?php print $this->delivery_info['l_name'] ?>, 
       <?php if ($this->delivery_info['street']) print $this->delivery_info['street'].","?>
       <?php if ($this->delivery_info['home'] && $this->delivery_info['apartment']) print $this->delivery_info['home']."/".$this->delivery_info['apartment'].","?>
       <?php if ($this->delivery_info['home'] && !$this->delivery_info['apartment']) print $this->delivery_info['home'].","?>
       <?php if ($this->delivery_info['state']) print $this->delivery_info['state']."," ?> 
       <?php print $this->delivery_info['zip']." ".$this->delivery_info['city']." ".$this->delivery_info['country']?>
    </span>
  </div>
<?php }?>
<?php if (!$this->config->without_shipping){?>  
  <div class="shipping-method">
    <span>
       <strong><?php print _JSHOP_FINISH_SHIPPING_METHOD?></strong>: <?php print $this->sh_method->name?>
       <?php if ($this->delivery_time){?>
       <div class="delivery_time"><strong><?php print _JSHOP_DELIVERY_TIME?></strong>: <?php print $this->delivery_time?></div>
       <?php }?>
       <?php if ($this->delivery_date){?>
       <div class="delivery_date"><strong><?php print _JSHOP_DELIVERY_DATE?></strong>: <?php print $this->delivery_date?></div>
       <?php }?>
    </span>
  </div>
<?php } ?>
<?php if (!$this->config->without_payment){?>  
  <div class="payment-method">
    <span>
       <strong><?php print _JSHOP_FINISH_PAYMENT_METHOD ?></strong>: <?php print $this->payment_name ?>
    </span>
  </div>
<?php } ?> 
</div>
<br />
<br />

<form name = "form_finish" action = "<?php print $this->action ?>" method = "post">
   <div class = "jshop" align="center" style="width:auto;margin-left:auto;margin-right:auto;">
     <div class="add-info">
		   <?php print _JSHOP_ADD_INFO ?><br />
		   <textarea class = "inputbox" id = "order_add_info" name = "order_add_info"></textarea>
     </div>
     <?php if ($this->config->display_agb){?>
     <div class="row_agb">            
            <input type = "checkbox" name="agb" id="agb" />        
            <a class = "policy" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=agb&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print _JSHOP_AGB;?></a>
            <?php print _JSHOP_AND;?>
            <a class = "policy" href="#" onclick="window.open('<?php print SEFLink('index.php?option=com_jshopping&controller=content&task=view&page=return_policy&tmpl=component', 1);?>','window','width=800, height=600, scrollbars=yes, status=no, toolbar=no, menubar=no, resizable=yes, location=no');return false;"><?php print _JSHOP_RETURN_POLICY?></a>
            <?php print _JSHOP_CONFIRM;?>        
     </div>     
     <?php }?>
	 
      <div style="text-align:center;padding-top:3px;">
		   <input class="button" type="submit" name="finish_registration" value="<?php print _JSHOP_ORDER_FINISH?>" <?php if ($this->config->display_agb){?>onclick="return checkAGB()"<?php }?> />
      </div>
   </div>
<?php print $this->_tmp_ext_html_previewfinish_end?>
</form>
</div>