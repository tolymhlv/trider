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
<div id="uf_prices_label" class="uf_label_prices<?php if ($priceFrom > 0 || $priceTo > 0) echo ' uf_label_selected' ?>">
	<span><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_PRICE') ?> (<?php echo $modHelper->jshopConfig->currency_code ?>)</span>
</div>
<div id="uf_prices" class="uf_options_price">
	<div class="uf_price input-prepend input-append">
		<input type="text" name="pricefrom" id="uf_price_from" placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_FROM')?>" value="<?php if ($priceFrom > 0) echo $priceFrom ?>" onkeyup="unijaxFilter.updateForm(this, <?php echo $modHelper->params->price_delay ?>)" />
		<span class="uf_pricereset" onclick="unijaxFilter.clearPrice()"><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_PRICE_SEPARATOR') ?></span>
		<input type="text" name="priceto" id="uf_price_to" placeholder="<?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_TO') ?>" value="<?php if ($priceTo > 0) echo $priceTo ?>" onkeyup="unijaxFilter.updateForm(this, <?php echo $modHelper->params->price_delay ?>)" />
	</div>
	<?php if ($modHelper->params->show_trackbar){ ?>
	<div id="uf_price_trackbar"></div>
	<?php } ?>    
</div>