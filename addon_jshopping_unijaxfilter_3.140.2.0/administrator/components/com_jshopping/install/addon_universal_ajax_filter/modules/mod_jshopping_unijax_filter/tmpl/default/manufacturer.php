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
<div id="uf_manufacturers_label" class="uf_label_manufacturers<?php if (count($activeManufacturers)) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_MANUFACTURER') ?></span>
</div>
<div id="uf_manufacturers" class="uf_options">
<?php if ($modHelper->params->show_manufacturers == 1) { ?>
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_manufacturers_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_manufacturer<?php if ($modHelper->params->show_manufacturers == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<?php foreach($displayManufacturers as $v){ ?>
		<div class="uf_input">
			<input id="uf_manufacturer_<?php echo $v->id ?>" type="checkbox" name="manufacturers[]" value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeManufacturers)) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_manufacturer" for="uf_manufacturer_<?php echo $v->id ?>"><?php echo $v->name ?></label>
			<?php if ($modHelper->params->show_manufacturers_link){ ?>
			<a class="uf_link" href="<?php echo SEFLink('index.php?option=com_jshopping&controller=manufacturer&task=view&manufacturer_id=' . $v->id, 1) ?>" title="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_MANUFACTURER_PRODUCTS').' '.htmlspecialchars($v->name) ?>"></a>
			<?php }?>    
			<?php if ($modHelper->params->show_manufacturers_desc && $v->short_desc){ ?>
			<div class="uf_tooltip" onmouseover="unijaxFilter.tip(this,'show')" onmouseout="unijaxFilter.tip(this,'hide')"></div>
			<div class="uf_preview"><?php echo $v->short_desc?></div>
			<?php }?>    
		</div>
		<?php }?>
		<input type="hidden" name="manufacturers[]" value="" />
	</div>
<?php } else { ?>
	<select name="manufacturers[]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_manufacturers == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_manufacturers == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_manufacturers == 2) { ?>
		<option value=""></option>
		<?php } ?>
		<?php foreach($displayManufacturers as $v) { ?>
		<option value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeManufacturers)) echo 'selected="selected"' ?>><?php echo $v->name ?></option>
		<?php } ?>
	</select>
	<?php if ($modHelper->params->show_manufacturers == 3) { ?>
	<input type="hidden" name="manufacturers[]" value="" />
	<?php } ?>
<?php } ?>
</div>
