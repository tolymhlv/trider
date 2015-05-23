;(function($){
	$.fn.extend({
		sj_frontpage_accordion_expand: function(options){
			if ($(this).hasClass(options.active_class)) return;
			var $content_inner = $(options.content, this);
			$content_inner.filter(':animated').stop();
			
			$height_to_fit = 0;
			$content_inner.children().each(function(){
				if ($(this).height()>$height_to_fit){
					$height_to_fit = $(this).height() + 10;
				}
			});
			
			var onComplete = function(){
				$(this).addClass(options.active_class);
			}.bind(this);
			
			$content_inner.animate({
				height: $height_to_fit		
			}, {
				duration: options.duration,
				complete: onComplete
			});
		},
		sj_frontpage_accordion_close: function(options){
			$(this).removeClass(options.active_class);
			var $content_inner = $(options.content, this);
			$content_inner.filter(':animated').stop();
			
			$content_inner.animate({
				height: 0
			}, {
				duration: options.duration
			});
		},
		sj_frontpage_accordion: function(options){
			var defaults = {};
			var options =  $.extend(defaults, options);
			
			return this.each(function(){
				var $items = $(options.items, this);
				
				$items.each(function(i, item){
					if (options.active && options.active==i+1){
						$(item).sj_frontpage_accordion_expand(options);
					}
					
					$(options.heading, item).bind(options.event, function(){
						var delay = options.event=='click'?10:options.delay;
						setTimeout(function(){
							$items.not(item).sj_frontpage_accordion_close(options);
							$(item).sj_frontpage_accordion_expand(options);
						}.bind(item), delay);
					});
				});
			});
		}
	});
})(jQuery)