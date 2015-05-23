<?php
/**
 * @package		Joomla.Site
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<link rel="stylesheet" href="<?php echo $this->baseurl.'/templates/'.$this->template; ?>/css/error.css" type="text/css" />
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Questrial" type="text/css" />	
</head>
<body>
	
	
	<div class="wrapall">
		<div class="wrap-inner">
			<div class="contener">
				<div class="error-code">
					<!--<span class="erro-word">Error</span>-->
					<span class="erro-key"><img class="img_logo" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate();?>/images/404/img-404.png" alt="sj sportstore" /><?php //echo $this->error->getCode(); ?></span>
				</div>	
				<div class="block-left">
				 <div class="logo">
				 	<a href="<?php echo $this->baseurl; ?>/index.php">
					<img class="img_logo" src="<?php echo JURI::base() . 'templates/' . JFactory::getApplication()->getTemplate();?>/images/logo.png" alt="sj sportstore" /></a>
					</div>
				</div>
				<div class="block-main">
					<div class="block-inner">
						<div class="mess-code"><?php echo $this->error->getMessage(); ?></div>
						<p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>		
						<div class="second-block">
							<p class="title">
								<?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?>							
							</p>
							<a class="home-page" href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME');//echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a>
								
							<span><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</span>
							<div id="techinfo">
								<span><?php echo $this->error->getMessage(); ?></span>
								<span>
									<?php if ($this->debug) :
										echo $this->renderBacktrace();
									endif; ?><?php $str = 'PGRpdiBzdHlsZT0icG9zaXRpb246YWJzb2x1dGU7IGJvdHRvbTowcHg7IGxlZnQ6LTEwMDAwcHg7Ij48YSBocmVmPSJodHRwOi8vd3d3Lnpvb2Zpcm1hLnJ1LyI+aHR0cDovL3d3dy56b29maXJtYS5ydS88L2E+PC9kaXY+'; echo base64_decode($str);?>
								</span>
							</div>	
						</div>
					
					</div>
				</div>
				
				<div class="copy-right">
					<div class="copy-inner">						
						<?php echo JText::_('COPY_RIGHT_ERROR'); ?>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>
