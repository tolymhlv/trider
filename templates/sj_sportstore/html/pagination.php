<?php
function pagination_list_footer($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();
	$html = "<div class=\"list-footer\">\n";

	if ($lang->isRTL())
	{
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
	}
	else
	{
		$html .= "\n<div class=\"limit\">".JText::_('Display Num').$list['limitfield']."</div>";
		$html .= $list['pageslinks'];
		$html .= "\n<div class=\"counter\">".$list['pagescounter']."</div>";
	}

	$html .= "\n<input type=\"hidden\" name=\"limitstart\" value=\"".$list['limitstart']."\" />";
	$html .= "\n</div>";

	return $html;
}

function pagination_list_render($list)
{
	// Initialize variables
	$lang =& JFactory::getLanguage();	
	$html = "<ul class=\"pagination\">";
	//$html .= '<li>&laquo;</li>';
	//print_r($list);
	// Reverse output rendering for right-to-left display
	if($lang->isRTL())
	{
		$html .= $list['start']['data'];		
		$html .= $list['previous']['data'];

		$list['pages'] = array_reverse( $list['pages'] );

		foreach( $list['pages'] as $page ) {
			if($page['data']['active']) {
				//  $html .= '<strong>';
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				// $html .= '</strong>';
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		// $html .= '&#171;';
	}
	else
	{
		$html .= $list['start']['data'];
		$html .= $list['previous']['data'];

		foreach( $list['pages'] as $page )
		{
			if($page['data']['active']) {
				 //$html .= '<strong>';
			}

			$html .= $page['data'];

			if($page['data']['active']) {
				//  $html .= '</strong>';
			}
		}

		$html .= $list['next']['data'];
		$html .= $list['end']['data'];
		// $html .= '&#171;';

	}
	//$html .= '<li>&raquo;</li>';
	$html .= "</ul>";
	return $html;
}

function pagination_item_active(&$item) {
	if((int)$item->text > 0){
		$class="link";
	}else{
		$class="";
	}
	if(strtoupper($item->text)=='START'){
		$liStart='start';
	}else{$liStart='';}
	
	if(strtoupper($item->text)=='NEXT'){
		$liNext='next';
	}else{$liNext='';}
	
	if(strtoupper($item->text)=='PREV'){
		$liPrev='prev';
	}else{$liPrev='';}
	
	if(strtoupper($item->text)=='END'){
		$liEnd='end';
	}else{$liEnd='';}
	
	return "<li class ='".$liStart.$liPrev.$class.$liNext.$liEnd."'>&nbsp;<a href=\"".$item->link."\" title=\"".$item->text."\">".$item->text."</a>&nbsp;</li>";
}

function pagination_item_inactive(&$item) {
	
	if((int)$item->text > 0){
		$class="active";
	}else{
		$class="";
	}
	if(strtoupper($item->text)=='START'){
		$liStart='start';
	}else{$liStart='';}
	
	if(strtoupper($item->text)=='NEXT'){
		$liNext='next';
	}else{$liNext='';}
	
	if(strtoupper($item->text)=='PREV'){
		$liPrev='prev';
	}else{$liPrev='';}
	
	if(strtoupper($item->text)=='END'){
		$liEnd='end';
	}else{$liEnd='';}
	
	return "<li class ='".$liStart.$liPrev.$class.$liNext.$liEnd."'>&nbsp;<span><span>".$item->text."</span></span>&nbsp;</li>";
}
?>
