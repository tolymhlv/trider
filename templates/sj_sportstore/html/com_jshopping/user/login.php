<?php defined('_JEXEC') or die(); ?>
<div class="jshop"> 
	<div class="jshop-login">   
		<h1 class="header"><?php print _JSHOP_LOGIN ?></h1>
		
		<?php if ($this->config->shop_user_guest && $this->show_pay_without_reg) {?>
		  <span class="text_pay_without_reg"><?php print _JSHOP_ORDER_WITHOUT_REGISTER_CLICK?> <a href="<?php print SEFLink('index.php?option=com_jshopping&controller=checkout&task=step2',1,0, $this->config->use_ssl);?>"><?php print _JSHOP_HERE?></a></span>
		<?php } ?>
		
		<div class="sj-login-shop">
		
			<div class="login_block">
				  <?php /*?><span class="small_header"><?php print _JSHOP_HAVE_ACCOUNT ?></span>
				  <span><?php print _JSHOP_PL_LOGIN ?></span><?php */?>
				  
				  <form method = "post" action="<?php print SEFLink('index.php?option=com_jshopping&controller=user&task=loginsave', 1,0, $this->config->use_ssl)?>" name = "jlogin" class="form-horizontal">
					<div class = "sj_login_block">
						 <div class="control-group">
							<div class="control-label">
								<label><?php print _JSHOP_USERNAME ?>: </label>
							</div>
							<div class="controls">
								<input type = "text" name = "username" value = "" class = "inputbox" />
								</div>
						 </div>
						 <div class="control-group">
							<div class="control-label">
								<label><?php print _JSHOP_PASSWORT ?>: </label>
							</div>
							<div class="controls">
								<input type = "password" name = "passwd" value = "" class = "inputbox" />
							</div>
						</div>
						<div class="control-group">
							<label id="remember_me_lbl" for = "remember_me"><?php print _JSHOP_REMEMBER_ME ?></label><input type = "checkbox" name = "remember" id = "remember_me" value = "yes" />
						</div>
						<div class="control-group">	
							<input type="submit" class="button" value="<?php print _JSHOP_LOGIN ?>" />
							<?php if (!$this->config->show_registerform_in_logintemplate){?>						
								<input type="button" class="button" value="<?php print _JSHOP_REGISTRATION ?>" onclick="location.href='<?php print $this->href_register ?>';" />
						<?php }else{?>
							<?php $hideheaderh1 = 1; include(dirname(__FILE__)."/register.php"); ?>
						<?php }?>	
						</div>
						<div class="control-group">                      
							<a class="loss-pass" href = "<?php print $this->href_lost_pass ?>"><i class="icon-circle"></i><?php print _JSHOP_LOST_PASSWORD ?></a>
						</div>
					</div>
					<input type = "hidden" name = "return" value = "<?php print $this->return ?>" />
					<?php echo JHtml::_('form.token');?>
				  </form>   
			</div>
			<?php /*
			<div class="register_block">
				?><span class="small_header"><?php print _JSHOP_HAVE_NOT_ACCOUNT ?></span>
				<span><?php print _JSHOP_REGISTER ?></span><?php 
				
				<?php if (!$this->config->show_registerform_in_logintemplate){?>
					<div style="padding-top:3px;"><input type="button" class="button" value="<?php print _JSHOP_REGISTRATION ?>" onclick="location.href='<?php print $this->href_register ?>';" /></div>
				<?php }else{?>
					<?php $hideheaderh1 = 1; include(dirname(__FILE__)."/register.php"); ?>
				<?php }?>				
			</div>
			<div style="clear:both"></div>        */?>
		</div>
		</div>
	</div>
</div>    