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
<script type="text/javascript">
//<![CDATA[
var unijaxFilter = unijaxFilter || {};
unijaxFilter.use_ajax = <?php echo $modHelper->params->use_ajax ?>;
unijaxFilter.show_immediately = <?php echo $modHelper->params->show_immediately ?>;
unijaxFilter.hide_non_active = <?php echo $modHelper->params->hide_non_active ?>;
unijaxFilter.options_qnt = <?php echo $modHelper->params->options_qnt ?>;
unijaxFilter.need_redirect = <?php echo ($modHelper->type == 'all' && $modHelper->controller != 'products') ? '1' : '0' ?>;
unijaxFilter.priceRangeFrom = <?php echo $modHelper->priceRange->from ?>;
unijaxFilter.priceRangeTo = <?php echo $modHelper->priceRange->to ?>;
unijaxFilter.priceDelay = <?php echo $modHelper->params->price_delay ?>;
//]]>
</script>