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

foreach($displayCharacteristics as $extraFieldId=>$extraFieldValues) {
	if (is_array($modHelper->allProductExtraFieldValueDetail[$extraFieldId])) {
		$tmpExtraFieldsValue = array();
		foreach ($modHelper->allProductExtraFieldValueDetail[$extraFieldId] as $k=>$v) {
			if (in_array($k, $extraFieldValues)) {
				$tmpExtraFieldsValue[$k] = $k;
			}
		}
		if (count($tmpExtraFieldsValue)) {
			$extraFieldValues = $tmpExtraFieldsValue;
		}
	} else {
		$extraFieldValues = array_unique($extraFieldValues);
		sort($extraFieldValues);
	}
	$count = count($extraFieldValues);
	if ($count <= $modHelper->params->once_option) {
		continue;
	}
?>
<div id="uf_characteristics_<?php echo $extraFieldId ?>_label" class="uf_label_characteristics_<?php echo $extraFieldId ?><?php if (is_array($activeCharacteristics[$extraFieldId]) && count($activeCharacteristics[$extraFieldId])) echo ' uf_label_selected' ?>">
	<span><?php echo $modHelper->allProductExtraField[$extraFieldId]->name ?></span>
	<?php if ($modHelper->params->show_characteristics_desc && $modHelper->allProductExtraField[$extraFieldId]->description) { ?>
	<div class="uf_tooltip" onmouseover="unijaxFilter.tip(this,'show')" onmouseout="unijaxFilter.tip(this,'hide')"></div>
	<div class="uf_preview"><?php echo $modHelper->allProductExtraField[$extraFieldId]->description ?></div>
	<?php } ?>    
</div>
<div id="uf_characteristics_<?php echo $extraFieldId ?>" class="uf_options">
<?php if ($modHelper->params->show_characteristics == 1) { ?>    
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_characteristics_<?php echo $extraFieldId ?>_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_characteristic_<?php echo $extraFieldId ?><?php if ($modHelper->params->show_characteristics == 1&& $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<input type="hidden" name="characteristics[<?php echo $extraFieldId ?>][]" value="" />
		<?php
		foreach($extraFieldValues as $extraFieldValue) {
			if ($modHelper->allProductExtraField[$extraFieldId]->type==0 || $modHelper->allProductExtraField[$extraFieldId]->type==2) {
				$extraFieldValueName = $modHelper->allProductExtraFieldValueDetail[$extraFieldId][$extraFieldValue];
			} else if ($modHelper->allProductExtraField[$extraFieldId]->type==3) {
				$extraFieldValueName = JText::_('JYES');
			} else {
				$extraFieldValueName = $extraFieldValue;
			}
			$extraFieldValue = urlencode($extraFieldValue);
			$extraFieldValueId = 'uf_characteristic_'.$extraFieldId.'_'.str_replace('%','-',str_replace('+','_',$extraFieldValue));
		?>
		<div class="uf_input">
			<input id="<?php echo $extraFieldValueId ?>" type="checkbox" name="characteristics[<?php echo $extraFieldId ?>][]" value="<?php echo $extraFieldValue ?>" <?php if (is_array($activeCharacteristics[$extraFieldId]) && in_array($extraFieldValue, $activeCharacteristics[$extraFieldId])) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_input_label" for="<?php echo $extraFieldValueId ?>"><?php echo $extraFieldValueName ?></label>
		</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<?php if ($modHelper->params->show_characteristics == 3) { ?>
	<input type="hidden" name="characteristics[<?php echo $extraFieldId ?>][]" value="" />
	<?php } ?>
	<select name="characteristics[<?php echo $extraFieldId ?>][]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_characteristics == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_characteristics == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
	<?php
	foreach($extraFieldValues as $extraFieldValue) {
		if ($modHelper->allProductExtraField[$extraFieldId]->type==0 || $modHelper->allProductExtraField[$extraFieldId]->type==2) {
			$extraFieldValueName = $modHelper->allProductExtraFieldValueDetail[$extraFieldId][$extraFieldValue];
		} else if ($modHelper->allProductExtraField[$extraFieldId]->type==3) {
			$extraFieldValueName = JText::_('JYES');
		} else {
			$extraFieldValueName = $extraFieldValue;
		}
		$extraFieldValue = urlencode($extraFieldValue);
		$extraFieldValueId = 'uf_characteristic_'.$extraFieldId.'_'.str_replace('%','-',str_replace('+','_',$extraFieldValue));
		if ($modHelper->params->show_characteristics == 2) {
		?>
		<option value=""></option>
		<?php } ?>
		<option value="<?php echo $extraFieldValue ?>" <?php if (is_array($activeCharacteristics[$extraFieldId]) && in_array($extraFieldValue, $activeCharacteristics[$extraFieldId])) echo 'selected="selected"' ?>><?php echo $extraFieldValueName ?></option>
	<?php } ?>
	</select>
<?php } ?>
</div>
<?php } ?>