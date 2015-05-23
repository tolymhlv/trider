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
<div id="uf_additional_prices" class="uf_options">
	<div><span></span></div>
	<div class="uf_options_additional_price">
		<input type="hidden" name="additional_prices[]" value="0" />
		<div class="uf_input">
			<input id="uf_additional_price" type="checkbox" name="additional_prices[]" value="1" <?php if ($activeAdditionalPrices) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_additional_price" for="uf_additional_price"><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_ADDITIONAL_PRICE') ?></label>
		</div>
    </div>
</div>