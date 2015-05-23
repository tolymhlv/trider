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
<div id="uf_sales" class="uf_options">
	<div><span></span></div>
	<div class="uf_options_sale">
		<input type="hidden" name="sales[]" value="0" />
		<div class="uf_input">
			<input id="uf_sale" type="checkbox" name="sales[]" value="1" <?php if ($activeSales) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_sale" for="uf_sale"><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_SALES_ONLY') ?></label>
		</div>
    </div>
</div>