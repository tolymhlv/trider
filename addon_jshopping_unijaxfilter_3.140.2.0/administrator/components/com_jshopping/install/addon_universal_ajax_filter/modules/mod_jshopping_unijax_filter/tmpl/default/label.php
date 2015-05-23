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
<div id="uf_labels_label" class="uf_label_labels<?php if (count($activeLabels)) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_LABELS') ?></span>
</div>
<div id="uf_labels" class="uf_options">
<?php if ($modHelper->params->show_labels == 1) { ?>
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_labels_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_label<?php if ($modHelper->params->show_labels == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<input type="hidden" name="labels[]" value="0" />
		<?php foreach($displayLabels as $v) { ?>
		<div class="uf_input">
			<input id="uf_label_<?php echo $v->id ?>" type="checkbox" name="labels[]" value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeLabels)) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_label" for="uf_label_<?php echo $v->id ?>"><?php echo $v->name ?></label>
		</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<select name="labels[]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_labels == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_labels == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_labels == 2) { ?>
		<option value="0"></option>
		<?php } ?>
		<?php foreach($displayLabels as $v) { ?>
		<option value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeLabels)) echo 'selected="selected"' ?>><?php echo $v->name ?></option>
		<?php } ?>
	</select>
	<?php if ($modHelper->params->show_labels == 3) { ?>
	<input type="hidden" name="labels[]" value="0" />
	<?php } ?>
<?php } ?>
</div>