<?php
/**
* @package Joomla
* @subpackage JoomShopping
* @author Dmitry Stashenko
* @website http://nevigen.com/
* @email support@nevigen.com
* @copyright Copyright © Nevigen.com. All rights reserved.
* @license Proprietary. Copyrighted Commercial Software
* @license agreement http://nevigen.com/license-agreement.html
**/

defined('_JEXEC') or die;

?>
<div id="uf_vendors_label" class="uf_label_vendors<?php if (count($activeVendors)) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_VENDOR') ?></span>
</div>
<div id="uf_vendors" class="uf_options">
<?php if ($modHelper->params->show_vendors == 1) { ?>
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_vendors_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_vendor<?php if ($modHelper->params->show_vendors == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<?php foreach($displayVendors as $v) { ?>
		<div class="uf_input">
			<input id="uf_vendor_<?php echo $v->id ?>" type="checkbox" name="vendors[]" value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeVendors)) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_vendor" for="uf_vendor_<?php echo $v->id ?>"><?php echo $v->shop_name ?></label>
			<?php if ($modHelper->params->show_vendors_link){ ?>
			<a class="uf_link" href="<?php echo SEFLink('index.php?option=com_jshopping&controller=vendor&task=products&vendor_id=' . $v->id, 1) ?>" title="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_VENDOR_PRODUCTS').' '.htmlspecialchars($v->shop_name) ?>"></a>
			<?php }?>    
			<?php if ($modHelper->params->show_vendors_desc && $v->additional_information){?>
			<div class="uf_tooltip" onmouseover="unijaxFilter.tip(this,'show')" onmouseout="unijaxFilter.tip(this,'hide')"></div>
			<div class="uf_preview"><?php echo $v->additional_information?></div>
			<?php }?>    
		</div>
		<?php } ?>
		<input type="hidden" name="vendors[]" value="" />
	</div>
<?php } else { ?>
	<select name="vendors[]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_vendors == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_vendors == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_vendors == 2) { ?>
		<option value=""></option>
		<?php } ?>
		<?php foreach($displayVendors as $v) { ?>
		<option value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeVendors)) echo 'selected="selected"' ?>><?php echo $v->shop_name ?></option>
		<?php } ?>
	</select>
	<?php if ($modHelper->params->show_vendors == 3) { ?>
	<input type="hidden" name="vendors[]" value="" />
	<?php } ?>
<?php } ?>
</div>