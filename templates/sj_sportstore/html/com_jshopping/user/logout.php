<?php defined('_JEXEC') or die(); ?>
<div class="jshop">
<div class="jshop-logout">
    <h1 class="header"><?php print _JSHOP_LOGOUT ?></h1>
    <input class="button" type="button" value="<?php print _JSHOP_LOGOUT ?>" onclick="location.href='<?php print SEFLink("index.php?option=com_jshopping&controller=user&task=logout"); ?>'" />
</div>
</div>