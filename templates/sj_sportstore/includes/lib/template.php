<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2012 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

/**** For each template, if there are special cases you can override the function here ***/
class YtTemplate extends YtFrameworkTemplate {

	// Get Copyright Template
	/* Render as mod_footer */
	function getCopyright(){
		$app		= JFactory::getApplication();
		$date		= JFactory::getDate();
		$cur_year	= $date->format('Y');
		$csite_name	= $app->getCfg('sitename');
		
		if (JString::strpos(JText :: _('MOD_FOOTER_LINE1'), '%date%')) {
			$line1 = str_replace('%date%', $cur_year, JText :: _('MOD_FOOTER_LINE1'));
		}
		else {
			$line1 = JText :: _('MOD_FOOTER_LINE1');
		}
		
		if (JString::strpos($line1, '%sitename%')) {
			$lineone = str_replace('%sitename%', $csite_name, $line1);
		}
		else {
			$lineone = $line1;
		}
		?>
        <div class="footer1"><?php echo $lineone; ?></div>
        <div class="footer2"></div>
        <?php
	}
}

?>