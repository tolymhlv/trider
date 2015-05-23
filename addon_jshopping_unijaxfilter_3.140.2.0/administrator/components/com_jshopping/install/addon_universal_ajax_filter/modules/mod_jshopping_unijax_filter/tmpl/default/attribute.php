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
<?php
foreach($modHelper->allAttributes as $attr) {
	if (!isset($displayAttributes[$attr->attr_id])) continue;
	$attr_id = $attr->attr_id;
	$attr_values = $displayAttributes[$attr->attr_id];
	$count = count($attr_values);
	if ($count <= $modHelper->params->once_option) {
		continue;
	}
?>
<div id="uf_attributes_<?php echo $attr->attr_id ?>_label" class="uf_label_attributes_<?php echo $attr->attr_id ?><?php if (is_array($activeAttributes[$attr->attr_id]) && count($activeAttributes[$attr->attr_id])) echo ' uf_label_selected' ?>">
	<span><?php echo $attr->name;?></span>
	<?php if ($modHelper->show_attributes_desc && $attr->description) { ?>
	<div class="uf_tooltip" onmouseover="unijaxFilter.tip(this,'show')" onmouseout="unijaxFilter.tip(this,'hide')"></div>
	<div class="uf_preview"><?php echo $attr->description?></div>
	<?php } ?>    
</div>
<div id="uf_attributes_<?php echo $attr->attr_id ?>" class="uf_options">
<?php
	if ($attr->independent) {
		$pre='';
	} else {
		$pre = 'd_';
	}
?>
<?php if ($modHelper->params->show_attributes == 1) { ?>    
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_attributes_<?php echo $attr->attr_id ?>_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_attribute_<?php echo $attr->attr_id ?><?php if ($modHelper->params->show_attributes == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<input type="hidden" name="<?php echo $pre ?>attributes[<?php echo $attr->attr_id?>][]" value="0" />
		<?php foreach($attr_values as $attr_value) { ?>
		<div class="uf_input">
			<input id="uf_attribute_<?php echo $attr->attr_id ?>_<?php echo $attr_value->value_id ?>" type="checkbox" name="<?php echo $pre ?>attributes[<?php echo $attr->attr_id ?>][]" value="<?php echo $attr_value->value_id ?>" <?php if (is_array($activeAttributes[$attr->attr_id]) && in_array($attr_value->value_id, $activeAttributes[$attr->attr_id])) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_input_label" for="uf_attribute_<?php echo $attr->attr_id ?>_<?php echo $attr_value->value_id ?>"><?php echo $attr_value->name ?></label>
			<?php if ($modHelper->show_attribute_image && $attr_value->image) {?>
			<img class="uf_attr_img" src="<?php echo $modHelper->jshopConfig->image_attributes_live_path.'/'.$attr_value->image ?>" />
			<?php } ?>
		</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<?php if ($modHelper->params->show_attributes == 3) { ?>
	<input type="hidden" name="<?php echo $pre ?>attributes[<?php echo $attr->attr_id ?>][]" value="0" />
	<?php } ?>
	<select name="<?php echo $pre ?>attributes[<?php echo $attr->attr_id ?>][]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_attributes == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_attributes == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_attributes == 2) { ?>
		<option value="0"></option>
		<?php } ?>
		<?php foreach($attr_values as $attr_value) { ?>
		<option value="<?php echo $attr_value->value_id ?>" <?php if (is_array($activeAttributes[$attr->attr_id]) && in_array($attr_value->value_id, $activeAttributes[$attr->attr_id])) echo 'selected="selected"' ?>><?php echo $attr_value->name ?></option>
		<?php } ?>
	</select>
<?php } ?>
</div>
<?php } ?>
