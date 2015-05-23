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
<div id="uf_reviews" class="uf_options">
	<div><span></span></div>
	<div class="uf_options_review">
		<input type="hidden" name="reviews[]" value="0" />
		<div class="uf_input">
			<input id="uf_review" type="checkbox" name="reviews[]" value="1" <?php if ($activeReviews) echo 'checked="checked"' ?> onclick="unijaxFilter.updateForm(this)" />
			<label class="uf_review" for="uf_review"><?php echo JText::_('MOD_JSHOPPING_UNIJAXFILTER_WITH_REVIEWS') ?></label>
		</div>
    </div>
</div>