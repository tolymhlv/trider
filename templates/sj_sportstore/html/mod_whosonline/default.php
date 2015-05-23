<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_whosonline
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<?php 
$class_mod = preg_match ('/online/',  $moduleclass_sfx) ? "online":"";
//print_r($class_mod);
if($class_mod =="online"){ ?>
	<div class="online">
	<i class="icon-user"></i>
	<h3 class="google-font"><?php echo JText::_('WHO_ONLINE');?></h3>
<?php if ($showmode == 0 || $showmode == 2) : ?>
	<?php 
	if($count['guest'] > 1){
		$guest = JText::_('MOD_WHOSONLINE_GUESTSS');
	}else{
	 	$guest = JText::_('MOD_WHOSONLINE_GUEST');
	 }
	?>
	<?php 
	if($count['user'] > 1){
		$member = JText::_('MOD_WHOSONLINE_MEMBERS');
	}else{
	 	$member = JText::_('MOD_WHOSONLINE_MEMBER');
	 }
	?>
	
	<?php $cn_user = $count['user'];
		if($count['user'] ==0){
			$cn_user = jText::_('NO_MEMBER');
		}
	?>
	
	<p><?php echo JText::_('MOD_WHOSONLINE_WE_HAVES').'&nbsp;<span>'.$count['guest'].'</span> '.$guest.'  and <span>'.$cn_user.'</span> '.$member.' online'; ?></p>
<?php endif; ?>

<?php if (($showmode > 0) && count($names)) : ?>
	<ul  class="whosonline<?php echo $moduleclass_sfx ?>" >
	<?php if ($params->get('filter_groups')):?>
		<p><?php echo JText::_('MOD_WHOSONLINE_SAME_GROUP_MESSAGE'); ?></p>
	<?php endif;?>
	<?php foreach($names as $name) : ?>
		<li>
			<?php echo $name->username; ?>
		</li>
	<?php endforeach;  ?>
	</ul>
<?php endif;?>
	</div>

<?php } else { ?>
	<?php if ($showmode == 0 || $showmode == 2) : ?>
		<?php $guest = JText::plural('MOD_WHOSONLINE_GUESTS', $count['guest']); ?>
		<?php $member = JText::plural('MOD_WHOSONLINE_MEMBERS', $count['user']); ?>
		<p><?php echo JText::sprintf('MOD_WHOSONLINE_WE_HAVE', $guest, $member); ?></p>
	<?php endif; ?>
	
	<?php if (($showmode > 0) && count($names)) : ?>
		<ul  class="whosonline<?php echo $moduleclass_sfx ?>" >
		<?php if ($params->get('filter_groups')):?>
			<p><?php echo JText::_('MOD_WHOSONLINE_SAME_GROUP_MESSAGE'); ?></p>
		<?php endif;?>
		<?php foreach($names as $name) : ?>
			<li>
				<?php echo $name->username; ?>
			</li>
		<?php endforeach;  ?>
		</ul>
	<?php endif;?>
<?php }?>