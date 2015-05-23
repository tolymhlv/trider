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
<div id="uf_delivery_times_label" class="uf_label_delivery_times<?php if (count($activeDeliveryTimes)) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_DELIVERY_TIME') ?></span>
</div>
<div id="uf_delivery_times" class="uf_options">
<?php if ($modHelper->params->show_delivery_times == 1) { ?>
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_delivery_times_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_delivery_time<?php if ($modHelper->params->show_delivery_times == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<input type="hidden" name="delivery_times[]" value="0" />
		<?php foreach($displayDeliveryTimes as $v) { ?>
		<div class="uf_input">
			<input id="uf_delivery_time_<?php echo $v->id ?>" type="checkbox" name="delivery_times[]" value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeDeliveryTimes)) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_input_label" for="uf_delivery_time_<?php echo $v->id ?>"><?php echo $v->name ?></label>
		</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<select name="delivery_times[]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_delivery_times == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_delivery_times == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_delivery_times == 2) { ?>
		<option value="0"></option>
		<?php } ?>
		<?php foreach($displayDeliveryTimes as $v) { ?>
		<option value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeDeliveryTimes)) echo 'selected="selected"' ?>><?php echo $v->name ?></option>
		<?php } ?>
	</select>
	<?php if ($modHelper->params->show_delivery_times == 3) { ?>
	<input type="hidden" name="delivery_times[]" value="0" />
	<?php } ?>
<?php } ?>
</div>