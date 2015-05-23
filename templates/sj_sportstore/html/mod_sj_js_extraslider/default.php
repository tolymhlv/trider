<?php
/**
 * @package Sj Extra Slider for JoomShopping
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2013 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 *
 */
defined('_JEXEC') or die;
     //$reflector = new ReflectionClass('JsExtraslider');
	//echo $reflector->getFileName();

    ImageHelper::setDefault($params);
    $options=$params->toObject();
	$count_item = count($items);
	$item_of_page = $options->num_rows * $options->num_cols;
	$suffix = rand().time();
	$tag_id = 'sjextraslider_'.$suffix;	
	//$top_control = $options->imgcfg_height - 55;
	   
	if(!empty($items)){?>
    <div id="<?php echo $tag_id;?>" class="sj-extraslider <?php if( $options->effect == 'slide' ){ echo $options->effect;}?> preset02-<?php echo $options->num_cols; ?>" data-start-jcarousel='1'>
		<?php if(!empty($options->pretext)) { ?>
			<div class="pre-text"><?php echo $options->pretext; ?></div>
		<?php } ?> 
        <?php if($options->title_slider_display == 1){?>
            <div class="heading-title"><?php echo $options->title_slider;?></div><!--end heading-title-->
        <?php }?>		    
    	<div class="extraslider-control  <?php if( $options->button_page == 'under' ){echo 'button-type2';}?>" <?php //if ($options->theme == 'style2') echo ("style='top:".$top_control."px'"); ?>>
		    <a class="button-prev" href="<?php echo '#'.$tag_id;?>" data-jslide="prev"><i class="icon-circle-arrow-left"></i></a>
		    <?php if( $options->button_page == 'top' ){?>
		    <ul class="nav-page">
		    <?php $j = 0;$page = 0;
		    	foreach ($items as $item){$j ++;
				$active_class = $page == 0 ? " active" : "";
		    		if( $j%$item_of_page == 1 || $item_of_page == 1 ){$page ++;?>
		    		<li class="page">
		    			<a class="button-page <?php if( $page==1 ){echo 'sel';}?>" href="<?php echo '#'.$tag_id;?>" data-jslide="<?php echo $page-1;?>"><i class="icon-circle"></i></a>
		    		</li>
	    		<?php }}?>
		    </ul>
		    <?php }?>
		    <a class="button-next" href="<?php echo '#'.$tag_id;?>" data-jslide="next"><i class="icon-circle-arrow-right"></i></a>
	    </div>
	    <div class="extraslider-inner">
	    <?php $count = 0; $i = 0; 
	    foreach($items as $item){$count ++; $i++;?>
            <?php if($count%$item_of_page == 1 || $item_of_page == 1){?>
			
			<?php $count_line = 0; ?>
			
            <div class="item <?php if($i==1){echo "active";}?>">
            <?php }?>
				
                <?php if($count%$options->num_cols == 1 || $options->num_cols == 1 ){?>
				<?php $count_line++; ?>
                <div class="line <?php if($count_line== 1){ echo ' line-first';}?>">
                <?php }?>  
                
				    <div class="item-wrap <?php echo $options->theme; if($count%$options->num_cols == 0 || $count== $count_item && $options->num_cols !=1){echo " last";}?> ">
				    	<div class="item-image">
							<a href="<?php echo $item->link;?>" <?php echo JsExtraslider::parseTarget($options->target);?>>
                            <?php $img = JsExtraslider::getJSAImage($item, $params);
	    					echo JsExtraslider::imageTag($img);?>
							</a>
				    	</div>
			    	<?php if( $options->show_title == 1 || $options->show_desc == 1 || $options->show_read_more == 1 || $options->show_price == 1 || $options->show_review == 1 ){?>
				    	<div class="item-info">
				    	<?php if( $options->show_title == 1 ){?>
				    		<div class="item-title">
                                <a href="<?php echo $item->link;?>" <?php echo JsExtraslider::parseTarget($options->target);?>>
                                	<?php echo $item->title;?>
                                </a>    			     
				    		</div>
			    		<?php }?>
			    		<?php if( ($options->show_desc == 1 && !empty($item->short_description)) || $options->show_read_more == 1 || $options->show_price == 1 || $options->show_review == 1 ){?>
                            <div class="item-content">
							<?php if ( $item->_display_price && $options->show_price ){?>
					            <div class = "item-price">
					                <?php if ($item->show_price_from) echo _JSHOP_FROM." ";?>
					                <?php if($options->theme == 'style7'){
					                	$color_price = 'color:#333333';
					                }else{
					                	$color_price = 'color:#FFFFFF';
					                }?>
					                <span><?php echo "<span style='".$color_price."'>Price:</span> ".formatprice($item->product_price);?></span>
					            </div>
					        <?php }?>
							
							<?php if( $options->show_tax == 1 ){?>
							<div class="item-tax">
								<?php echo $item->_tax; ?>
							</div>
							<?php }?>
							
                            <?php if( $options->show_desc == 1 ){?>
                                <div class="item-description">
                                	<?php echo $item->short_description;?>
                                </div>
                            <?php }?>
					        <?php if( $options->show_review ){?>
					        	<table class="review_mark"><tr><td><?php echo showMarkStar($item->average_rating);?></td></tr></table>
					        <?php }?>		
					        	                            
                            <?php if( $options->show_read_more == 1 ){?>
                                <div class="item-readmore">
			                        <a href="<?php echo $item->link;?>" <?php echo JsExtraslider::parseTarget($options->target);?>>
		                            	<?php echo $options->read_more_text;?>
			                        </a>                                
                                </div> 
                            <?php }?>                               
                            </div>
                        <?php }?>
				    	</div>
			    	<?php }?>
				    </div>                
                 
                <?php if($count%$options->num_cols == 0 || $count== $count_item){?>    
                </div><!--line-->
                <?php } ?>		    		
            <?php if(($count%$item_of_page == 0 || $count== $count_item)){?>    
            </div><!--end item--> 
            <?php }?>
	    <?php }?>
	    </div><!--end extraslider-inner -->
	    <?php if( $options->button_page == 'under' ){?>
	    <ul class="nav-page nav-under">
	    <?php $j = 0;$page = 0;
	    	foreach ($items as $item){$j ++;
			$active_class = $page == 0 ? " active" : "";
	    		if( $j%$item_of_page == 1 || $item_of_page == 1 ){$page ++;?>
	    		<li class="page">
	    			<a class="button-page <?php if( $page==1 ){echo 'sel';}?>" href="<?php echo '#'.$tag_id;?>" data-jslide="<?php echo $page-1;?>"></a>
	    		</li>
    		<?php }}?>
	    </ul>
	    <?php }?>	    
		<?php if(!empty($options->posttext)) {  ?>
			<div class="post-text"><?php echo $options->posttext; ?></div>
		<?php }?>
    </div>
<?php }else{ echo JText::_('Has no item to show!');}?>



