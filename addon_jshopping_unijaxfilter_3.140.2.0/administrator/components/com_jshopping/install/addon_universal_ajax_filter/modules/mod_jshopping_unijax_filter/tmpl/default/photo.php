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
<div id="uf_photos_label" class="uf_label_photos<?php if ($activePhoto) echo 'uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_FILTER_PHOTO')?></span>
</div>
<div id="uf_photos" class="uf_options">
	<select name="photo" data-placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SELECT_FILTER') ?>" class="uf_chosen" onchange="unijaxFilter.updateForm(this)">
		<option value="0"></option>
		<option value="1" <?php if ($activePhoto==1) echo 'selected="selected"' ?>><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_WITHPHOTO') ?></option>
		<option value="2" <?php if ($activePhoto==2) echo 'selected="selected"' ?>><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_WITHOUTPHOTO') ?></option>
	</select>
</div>