<?php
/** 
 * YouTech menu template file.
 * 
 * @author The YouTech JSC
 * @package menusys
 * @filesource default.php
 * @license Copyright (c) 2011 The YouTech JSC. All Rights Reserved.
 * @tutorial http://www.smartaddons.com
 */
global $yt;
?>
<?php
if ( $this->canAccess() ){
	$haveChild = $this->haveChild(); ?>
	
	<?php
	if ($haveChild){
		$class_havechild ='class="havechild"';
	}
	?>
	
    <?php
    echo '<li '.$class_havechild.'>'.$this->getLinkInMobile2($this->get('level',1));
    if($haveChild){ ?>
            <ul class="nav">
        <?php
            $cidx = 0;
            foreach($this->getChild() as $child){
                ++$cidx;		
                $child->getContent('sidebar');
            }
        ?>
            </ul></li>
        <?php
    }else{ ?>
        </li>
    <?php
    } ?>
<?php
} ?>