<?php
/*
 * ------------------------------------------------------------------------
 * Copyright (C) 2009 - 2013 The YouTech JSC. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: The YouTech JSC
 * Websites: http://www.smartaddons.com - http://www.cmsportal.net
 * ------------------------------------------------------------------------
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Body's font-size & font-family
$doc->addStyleDeclaration('body.'.$yt->template.'{font-size:'.$fontSize.'}');
if(trim($fontName)!=''){
	$doc->addStyleDeclaration('body.'.$yt->template.'{font-family:'.$fontName.',sans-serif;}');
}

// Google Font & Element use
if ($googleWebFont != "" && $googleWebFont != " " && strtolower($googleWebFont)!="none") {
	$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.str_replace(" ","+",$googleWebFont).'');
	$googleWebFontFamily = strpos($googleWebFont, ':')?substr($googleWebFont, 0, strpos($googleWebFont, ':')):$googleWebFont;
	if(trim($googleWebFontTargets)!="")
		$doc->addStyleDeclaration('  '.$googleWebFontTargets.'{font-family:'.$googleWebFontFamily.', serif !important}');
}
// Add css... config to <head>...</head>
$doc->addStyleDeclaration('
body.'.$yt->template.'{
	background-color:'.$yt->getParam('bgcolor').' ;
	color:'.$yt->getParam('textcolor').' ;
}

body a{
	color:'.$yt->getParam('linkcolor').' ;
}

#yt_header{background-color:'.$yt->getParam('header-bgcolor').' ;}

#yt_spotlight{background-color:'.$yt->getParam('spotlight-bgcolor').' ;}

#yt_spotlight9{background-color:'.$yt->getParam('spotlight9-bgcolor').' ;}

#yt_spotlight7,
#yt_footer{background-color:'.$yt->getParam('footer-bgcolor').' ;}
');

//#yt_spotlight4, #yt_spotlight5, 
//#yt_spotlight6{background-color:'.$yt->getParam('spotlight4-bgcolor').' ;}

// Add class pattern to element wrap
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		/* Begin: add class pattern for element */
		var headerbgimage = '<?php echo $yt->getParam('header-bgimage');?>';
		//var footerbgimage = '<?php echo $yt->getParam('footer-bgimage');?>';
		if(headerbgimage){
			//$('#yt_header').addClass(headerbgimage);
			//$('#yt_slideshow').addClass(headerbgimage);
		}
		/* End: add class pattern for element */
	});
</script>
<?php
// Include cpanel
if($showCpanel) {
	include_once (J_TEMPLATEDIR.J_SEPARATOR.'includes'.J_SEPARATOR.'cpanel.php');
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		miniColorsCPanel('.body-backgroud-color .color-picker', 'body', 'background-color');
		miniColorsCPanel('.link-color .color-picker', 'body a', 'color');
		miniColorsCPanel('.text-color .color-picker', 'body', 'color');
		miniColorsCPanel('.header-backgroud-color .color-picker', '#yt_header','background-color');
		miniColorsCPanel('.footer-backgroud-color .color-picker', Array('#yt_spotlight7','#yt_footer'), 'background-color');
		miniColorsCPanel('.spotlight-backgroud-color .color-picker',Array('#yt_spotlight'), 'background-color');
		miniColorsCPanel('.spotlight9-backgroud-color .color-picker',Array('#yt_spotlight9'), 'background-color');
		//patternClick('.header-backgroud-image .pattern', 'header-bgimage', Array('#yt_header'));

		var array 				= Array('bgcolor','linkcolor','textcolor','header-bgcolor','spotlight-bgcolor','spotlight9-bgcolor','footer-bgcolor');
		
		var array_green    = Array('#ffffff','#666666','#666666','#479317','#f1f1f1','#479317','#353535');		
		var array_oranges  = Array('#ffffff','#666666','#666666','#ff7d04','#f1f1f1','#ff7d04','#353535');
		var array_blue     = Array('#ffffff','#666666','#666666','#2f67a8','#f1f1f1','#2f67a8','#353535');
		var array_cyan 	   = Array('#ffffff','#666666','#666666','#24afd0','#f1f1f1','#24afd0','#353535');
		
		$('.theme-color.green').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_green);
			onCPApply();
		});		
		$('.theme-color.oranges').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_oranges);
			onCPApply();
		});
		$('.theme-color.blue').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_blue);
			onCPApply();
		});
		$('.theme-color.cyan').click(function(){
			$($(this).parent().find('.active')).removeClass('active'); $(this).addClass('active');
			createCookie(TMPL_NAME+'_'+'templateColor', $(this).html().toLowerCase(), 365);
			setCpanelValues(array_cyan);
			onCPApply();
		});
		/* miniColorsCPanel */
		function miniColorsCPanel(elC, elT, selector){
			$(elC).miniColors({
				change: function(hex, rgb) {
					if(typeof(elT)!='string'){
						for(i=0;i<elT.length;i++){
							$(elT[i]).css(selector, hex);
						}
					}else{
						$(elT).css(selector, hex); 
					}
					createCookie(TMPL_NAME+'_'+($(this).attr('name').match(/^ytcpanel_(.*)$/))[1], hex, 365);
				}
			});
		}
		/* Begin: Set click pattern */
		function patternClick(elC, paramCookie, elT){
			$(elC).click(function(){
				oldvalue = $(this).parent().find('.active').html();
				$(elC).removeClass('active');
				$(this).addClass('active');
				value = $(this).html();
				if(elT.length > 0){
					for($i=0; $i < elT.length; $i++){
						$(elT[$i]).removeClass(oldvalue);
						$(elT[$i]).addClass(value);
					}
				}
				if(paramCookie){
					$('input[name$="ytcpanel_'+paramCookie+'"]').attr('value', value);
					createCookie(TMPL_NAME+'_'+paramCookie, value, 365);
				}
			});
		}
		function setCpanelValues(array){
			if(array['0']){
				$('.body-backgroud-color input.miniColors').attr('value', array['0']);
				$('.body-backgroud-color a.miniColors-trigger').css('background-color', array['0']);
				$('input.ytcpanel_bgcolor').attr('value', array['0']);
			}
			if(array['1']){
				$('.link-color input.miniColors').attr('value', array['1']);
				$('.link-color a.miniColors-trigger').css('background-color', array['1']);
				$('input.ytcpanel_linkcolor').attr('value', array['1']);
			}
			if(array['2']){
				$('.text-color input.miniColors').attr('value', array['2']);
				$('.text-color a.miniColors-trigger').css('background-color', array['2']);
				$('input.ytcpanel_textcolor').attr('value', array['2']);
			}
			if(array['3']){
				$('.header-backgroud-color input.miniColors').attr('value', array['3']);
				$('.header-backgroud-color a.miniColors-trigger').css('background-color', array['3']);
				$('input.ytcpanel_header-bgcolor').attr('value', array['3']);
			}
			if(array['4']){
				$('.spotlight-backgroud-color input.miniColors').attr('value', array['4']);
				$('.spotlight-backgroud-color a.miniColors-trigger').css('background-color', array['4']);
				$('input.ytcpanel_spotlight-bgcolor').attr('value', array['4']);
			}
			if(array['5']){
				$('.spotlight9-backgroud-color input.miniColors').attr('value', array['5']);
				$('.spotlight9-backgroud-color a.miniColors-trigger').css('background-color', array['5']);
				$('input.ytcpanel_spotlight9-bgcolor').attr('value', array['5']);
			}
			if(array['6']){
				$('.footer-backgroud-color input.miniColors').attr('value', array['6']);
				$('.footer-backgroud-color a.miniColors-trigger').css('background-color', array['6']);
				$('input.ytcpanel_footer-bgcolor').attr('value', array['6']);
			}
		}
	});
	</script>
	<?php
}
// Show back to top
if( $yt->getParam('showBacktotop') ) { ?>
    <a id="yt-totop" class="backtotop" href="#"><i class="icon-chevron-up"></i></a>

    <script type="text/javascript">
        jQuery(".backtotop").addClass("hidden-top");
			jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() === 0) {
				jQuery(".backtotop").addClass("hidden-top")
			} else {
				jQuery(".backtotop").removeClass("hidden-top")
			}
		});

		jQuery('.backtotop').click(function () {
			jQuery('body,html').animate({
					scrollTop:0
				}, 1200);
			return false;
		});
    </script>
<?php
}
?>


<!-- Arrow for main menu-->
<script type="text/javascript">
	jQuery(document).ready(function($){
		//console.log(arrow_width_cssmenu);
		var modclass_cssmenu = "#yt_menuposition ul.navi li.level1.active:after";
		
		var arrow_width_cssmenu = $("#yt_menuposition ul.navi li.level1.active").innerWidth()/2  ;
		$("<style type='text/css'>" + modclass_cssmenu + "{ border-left-width:"+ arrow_width_cssmenu + "px; border-right-width:"+ arrow_width_cssmenu +"px; bottom:-12px; } </style>").appendTo("head");
	});
</script>