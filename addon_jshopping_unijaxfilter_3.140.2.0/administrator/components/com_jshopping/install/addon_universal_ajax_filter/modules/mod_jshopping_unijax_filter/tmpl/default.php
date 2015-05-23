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
<form action="<?php echo $modHelper->action ?>" id="jshop_unijax_filter" name="jshop_unijax_filter" method="post">
	<?php if ($modHelper->params->use_ajax) { ?>
	<div id="uf_finded_products">
		<?php echo JText::_( 'MOD_JSHOPPING_UNIJAXFILTER_SELECTED_PRODUCTS' ) ?>
		<span id="uf_count_product">
			<span class="uf_count_loader"></span>
		</span>
	</div>
	<?php } ?>    
	<?php if ($modHelper->params->show_top_buttons) { ?>
	<div class="uf_buttons">
		<button type="submit" class="groupbtnleft"> <?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_YES') ?></button>
		<button type="button" class="groupbtnright" onclick="unijaxFilter.clearForm()"> <?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_RESET_FILTER') ?> </button>
	</div>
	<?php 
	}
	$folder = dirname(__FILE__).'/default/';
	foreach ($modHelper->params->order_table as $filename) {
		if (isset($displayFilters[$filename])) {
			$count = $displayFilters[$filename];
			@include $folder.$filename.'.php';
		}
	}
	if ($modHelper->params->show_bottom_buttons) {
	?>
	<div class="uf_buttons">
		<button type="submit" class="groupbtnleft"> <?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_YES') ?></button>
		<button type="button" class="groupbtnright" onclick="unijaxFilter.clearForm()"> <?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_RESET_FILTER') ?> </button>
	</div>
	<?php } ?>
	<input type="hidden" name="limitstart" value="0" />
</form>