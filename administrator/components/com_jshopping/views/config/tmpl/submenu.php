<?php 
	defined( '_JEXEC' ) or die();
	$menu=getItemsConfigPanelMenu(); 
?> 

<div class="jssubmenu">
    <div class="m">
        <ul id="submenu">
        <?php foreach($menu as $el){
            if (!$el[3]) continue;
            if (strpos($el[1], @$_SERVER['QUERY_STRING'] ) !== false ) {
                $class="class='active'";
            }else{
                $class="";
            }
        ?>
            <li>
                <a <?php print $class;?> href="<?php print $el[1]?>"><?php print $el[0]?></a>
            </li>
        <?php }?>        
        </ul>    
        <div class="clr"></div>
    </div>
</div>