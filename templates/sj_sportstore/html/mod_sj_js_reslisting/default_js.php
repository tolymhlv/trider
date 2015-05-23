<?php
/**
 * @package Sj Responsive Listing for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2012 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;
?>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function($){
	;(function(element){
		var $respl = $(element);
		var $container = $('.respl-items', $respl);
	    // $(window).load(function(){
	    	// $('.item-image img.respl-nophoto', $respl).parent().parent().addClass('respl-nophoto');
	    	// $('.respl-item', $respl).each(function(){
				// $(this).addClass('first-load');
					// var $that = $(this);
					// setTimeout(function(){
						// $that.removeClass('first-load');
					// },100);
			// });
		// });
		$('.item-image img.respl-nophoto', $respl).parent().parent().addClass('respl-nophoto');
	    var $loadding = $('.respl-loading',$respl);
		$respl.removeClass('pre-load');
		$loadding.remove();	 

		var sortdef = $('.sort-inner', $respl).attr('data-curr_value');
		var filterdef = $('.respl-cat', $respl).filter('.sel').children().attr('data-rl_value');
		 $('.sort-curr',$respl).attr('data-filter_value',filterdef);
		 $('.sort-curr',$respl).html($('.respl-cat', $respl).filter('.sel').children().html());
	// add randomish size classes
		$container.imagesLoaded( function(){
			$container.isotope({
				containerStyle: {
		    					position: 'relative',
		    	    			height: 'auto',
		    	    			overflow: 'visible'
		    	    		  },
				itemSelector : '.respl-item',
				filter: filterdef,
		      	sortBy : sortdef,
		      	layoutMode: 'fitRows',
				sortAscending: <?php echo ($params->get('product_order_dir') == 'asc')?'true':'false'; ?>,
		      	getSortData : {
					id : function ( $elem ) {
			        	return $elem.attr('data-id');
		        	},
		        	title : function ( $elem ) {
			        	return $elem.attr('data-title');
		        	},
		        	hits : function( $elem ) {
				    	return parseInt( $elem.attr('data-hits'), 10 );
				    },
			        average_rating : function( $elem ) {
				        return parseInt( $elem.attr('data-average_rating'), 10 );
				    },
				    dmodify : function( $elem ) {
				        return - parseInt( $elem.attr('data-dmodify'), 10 );
				    },
				    dadded : function( $elem ) {
				        return parseInt( $elem.attr('data-dadded'), 10 );
				    },
					review : function( $elem ) {
				        return parseInt( $elem.attr('data-review'), 10);
				    },
					product_price: function($elem){
						return parseInt($elem.attr('data-product_price'), 10);
					}

		      	}
			});
		 

		if ( $.browser.msie  && parseInt($.browser.version, 10) <= 8){
			//nood
		}else{
			$(window).resize(function() {
				$container.isotope('reLayout');
			});
	    }
	    
		var $optionSets = $('.respl-header .respl-option', $respl),
	    	$optionLinks = $optionSets.find('a');
	    
			$optionLinks.click(function(){
		        var $this = $(this);
		        // don't proceed if already selected
		       // if ( $this.parent().hasClass('sel') ) {
		      //    return false;
		      //  }

	      		var $optionSet = $this.parents('.respl-option');
	      
		        $this.parent().addClass('sel').siblings().removeClass('sel');
		        
		        if($this.parent().parent().parent().parent().is('.respl-categories')){
		        	$('.sort-curr',$this.parent().parent().parent()).html($this.html());
		        	$('.sort-curr',$this.parent().parent().parent()).attr('data-filter_value',$this.attr('data-rl_value'));
					if($this.parent().css('float') == 'none'){
						$this.parent().parent().parent().hover(function(){
							$('.respl-cats', $respl).removeAttr('style');
						}, function(){
							$('.respl-cats', $respl).css('display','none').removeAttr('style');
						});
						if($('.respl-cats', $respl).css('display') == 'block'){ 
							$('.respl-cats', $respl).css('display','none');
						}
					}
				}
				
				if($this.parent().parent().parent().parent().is('.respl-sort')){
		     	   $('.sort-inner',$this.parent().parent().parent()).attr('data-curr',$this.html());
		     	   $('.sort-inner',$this.parent().parent().parent()).attr('data-curr_value',$this.attr('data-rl_value'));
				}
			
				if($this.parent().parent().is('.sort-select')){
					$this.parent().parent().parent().hover(function(){
						$('.sort-select', $respl).removeAttr('style');
					}, function(){
						$('.sort-select', $respl).css('display','none');
					});
					$('.sort-select', $respl).css('display','none');
				}
		        // make option object dynamically, i.e. { filter: '.my-filter-class' }
		        var options = {},
		            key =$optionSet.attr('data-option-key'),
		            value = $this.attr('data-rl_value');
		        // parse 'false' as false boolean
		        value = value === 'false' ? false : value;
		        options[ key ] = value;
		        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
		          // changes in layout modes need extra logic
		          changeLayoutMode( $this, options )
		        } else {
		          // otherwise, apply new options
		          $container.isotope( options );
		        }
	        
	        return false;
	      });

	      // change layout
	      function changeLayoutMode( $link, options ) {
	         if(options.layoutMode == 'straightDown'){
	        	 $('.item-image img.respl-nophoto', $respl).parent().parent().addClass('respl-nophoto');
				 $('.respl-wrap',$respl).css('overflow','hidden');
	        	 $('.respl-items', $respl).removeClass('grid').addClass('list');
	        	 $container.isotope('reLayout');
	         }else{
	          	 $('.item-image img.respl-nophoto', $respl).parent().parent().removeClass('respl-nophoto');
				 $('.respl-wrap',$respl).removeAttr('style');
	        	 $('.respl-items', $respl).removeClass('list').addClass('grid');
	        	 $container.isotope('reLayout');
	         }
	      }

	   });
	   
	   		var updateCount = function(){
	   			$('.respl-loader', $respl).removeClass('loading');
	   			var countitem = $('.respl-item',$respl).length;
				var currents = $('.respl-item', $respl), countall = currents.length;
				if($('li.respl-cat a').attr('data-count') === undefined){
					//nood
				}else{
					$('[data-count]', $respl).each(function(){
						var $this = $(this), data = $this.data();
						if (data.rl_value){
							if (data.rl_value == '*'){
								$this.attr('data-count', countall);
							} else {
								$this.attr('data-count', currents.filter(data.rl_value).length);
							}
						}
					});
				}
				$('.loader-image',  $respl).css({display:'none'});
				$('a.respl-button',$respl).attr('data-rl_start', countitem);
				var rl_total = $('a.respl-button', $respl).attr('data-rl_total');
				var rl_load = $('a.respl-button', $respl).attr('data-rl_load');
				var rl_allready = $('a.respl-button', $respl).attr('data-rl_allready');
				if(countitem < rl_total){
					$('.load-number', $respl).attr('data-total', (rl_total - countitem));
	     				if((rl_total - countitem)< rl_load ){
	     					$('.load-number',  $respl).attr('data-more', (rl_total - countitem));
	     			}
				}
				if(countitem == rl_total){
					$('.respl-loader',  $respl).addClass('loaded');
					$('.loader-image',  $respl).css({display:'none'});
					$('.loader-label',  $respl).html(rl_allready);
					$('.respl-loader',  $respl ).removeClass('loading');
				}
	   		};
	   		
	   		
			$('.respl-loader', $respl).click(function(){
				var $that = this;
				if ($('.respl-loader', $respl ).hasClass('loaded') || $('.respl-loader', $respl).hasClass('loading')){
					return false;
				}else{
					$('.respl-loader', $respl).addClass('loading');
					$('.loader-image',  $respl).css({display:'inline-block'});
					var rl_start = $('a.respl-button', $respl).attr('data-rl_start');
					var rl_moduleid = $('a.respl-button', $respl).attr('data-rl_moduleid');
					var rl_ajaxurl = $('a.respl-button', $respl).attr('data-rl_ajaxurl');
					$.ajax({
						type: 'POST',
						url: rl_ajaxurl,
						data:{
							sj_module_id: rl_moduleid,
							is_ajax: 1,
							ajax_reslisting_start: rl_start
						},
						success: function(data){
							if($(data.items_markup).length > 0){
								var $newItems = $(data.items_markup).removeClass('first-load');
								$('.item-image img.respl-nophoto', $newItems).parent().parent().addClass('respl-nophoto');
								$newItems.imagesLoaded( function(){
									$container.isotope('insert',$newItems).isotope( 'reLayout');
									updateCount();
									$(document).ready(function($) {
										$("a[data-rel^='prettyPhoto']").prettyPhoto({
											autoplay: false,
											deeplinking: false,
											animation_speed: 'fast', /* fast/slow/normal */
											slideshow: 5000, /* false OR interval time in ms */
											autoplay_slideshow: false, /* true/false */
											opacity: 0.8, /* Value between 0 and 1 */
											show_title: true, /* true/false */
											allow_resize: true, /* Resize the photos bigger than viewport. true/false */
											default_width: 500,
											default_height: 344,
											counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
											theme: 'pp_default', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
											horizontal_padding: 20, /* The padding on each side of the picture */
											overlay_gallery: true, /* If set to true, a gallery will overlay the fullscreen image on mouse over */
											keyboard_shortcuts: true, /* Set to false if you open forms inside prettyPhoto */
											social_tools: false
										});
									});
								});
							}
						}, dataType:'json'
						
					});
				}
				return false;
	      });
	
	})('#<?php echo $tag_id; ?>');
});

//]]>
</script>