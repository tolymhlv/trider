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
<div id="uf_categorys_label" class="uf_label_categorys<?php if (count($activeCategorys)) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_CATEGORY') ?></span>
</div>
<div id="uf_categorys" class="uf_options">    
<?php if ($modHelper->params->show_categorys == 1) { ?>
	<div class="uf_select_options chzn-container-multi">
		<ul id="uf_categorys_select_options" class="chzn-choices"></ul>
	</div>
	<div class="uf_options_category<?php if ($modHelper->params->show_categorys == 1 && $modHelper->params->options_qnt && $modHelper->params->options_qnt < $count) { echo ' uf_overflow'; } ?>">
		<?php
		foreach($displayCategorys as $v) {
			if (isset($v->level)) {
				$category_level = $v->level - $modHelper->minCategoryLevel;
			} else {
				$category_level = 0;
			}
		?>
		<div class="uf_input uf_level_<?php echo $category_level ?>">
			<input id="uf_category_<?php echo $v->id ?>" type="checkbox" name="categorys[]" value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeCategorys)) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_category" for="uf_category_<?php echo $v->id ?>"><?php echo $v->name ?></label>
			<?php if ($modHelper->params->show_categorys_link){?>
			<a class="uf_link" href="<?php echo SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id='.$v->id, 1) ?>" title="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_CATEGORY_PRODUCTS').' '.htmlspecialchars($v->name) ?>"></a>
			<?php }?>    
			<?php if ($modHelper->params->show_categorys_desc && $v->short_desc){?>
			<div class="uf_tooltip" onmouseover="unijaxFilter.tip(this,'show')" onmouseout="unijaxFilter.tip(this,'hide')"></div>
			<div class="uf_preview"><?php echo $v->short_desc?></div>
			<?php }?>    
		</div>
		<?php } ?>
		<input type="hidden" name="categorys[]" value="" />
	</div>
<?php } else { ?>
	<select name="categorys[]" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER'.($modHelper->params->show_categorys == 3 ? '_MULTI' : '')) ?>" class="uf_chosen" <?php if ($modHelper->params->show_categorys == 3) { ?>multiple="multiple"<?php } ?> onchange="unijaxFilter.updateForm(this)">
		<?php if ($modHelper->params->show_categorys == 2) { ?>
		<option value=""></option>
		<?php } ?>
		<?php
		foreach($displayCategorys as $v) {
			if (isset($v->level)) {
				$category_level = $v->level;
			} else {
				$category_level = 0;
			}
		?>
		<option value="<?php echo $v->id ?>" <?php if (in_array($v->id, $activeCategorys)) echo 'selected="selected"' ?> class="uf_level_<?php echo $category_level ?>"><?php echo $v->name ?></option>
		<?php } ?>
	</select>
	<?php if ($modHelper->params->show_categorys == 3) { ?>
	<input type="hidden" name="categorys[]" value="" />
	<?php } ?>
<?php } ?>
</div>