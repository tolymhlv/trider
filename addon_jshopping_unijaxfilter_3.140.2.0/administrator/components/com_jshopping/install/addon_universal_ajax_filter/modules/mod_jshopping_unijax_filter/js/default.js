/**
* @package Joomla
* @subpackage JoomShopping
* @author Dmitry Stashenko
* @website http://nevigen.com/
* @email support@nevigen.com
* @copyright Copyright © Nevigen.com. All rights reserved.
* @license Proprietary. Copyrighted Commercial Software
* @license agreement http://nevigen.com/license-agreement.html
**/

var unijaxFilter = unijaxFilter || {};

unijaxFilter.clearForm = function() {
	$=jQuery;
    $('form[name=jshop_unijax_filter] input[type=checkbox]:checked').prop('checked',false);
    $('form[name=jshop_unijax_filter] select option:selected').prop('selected',false);
    $('form[name=jshop_unijax_filter] input[type=radio][value=0]').prop('checked',true);
    $('form[name=jshop_unijax_filter] input[type=text]').val('');
	$('#jshop_unijax_filter').submit();
}

unijaxFilter.getSelectInputHtml = function(elem) {
	return '<li class="search-choice"><span>' + jQuery(elem).next('label').text() + '</span><a href="javascript:void(0)" class="search-choice-close" onclick="unijaxFilter.removeSelectInput(\''+elem.id+'\', this)"></a></li>';
}

unijaxFilter.hideSelectInput = function(elem) {
	if (elem.type == 'checkbox' && elem.checked && elem.id != 'uf_sale' && elem.id != 'uf_review' && elem.id != 'uf_additional_price') {
		jQuery(elem.parentNode).addClass('uf_hide');
		return elem.parentNode.parentNode.parentNode.id;
	} else {
		return false;
	}
}

unijaxFilter.setSelectInputHtml = function(elem) {
	var parentId = unijaxFilter.hideSelectInput(elem);
	if (parentId) {
		jQuery('#'+parentId+'_select_options').append(unijaxFilter.getSelectInputHtml(elem));
	}
}

unijaxFilter._updateForm = function(elem) {
	$=jQuery;
	var options_id, form = $('#jshop_unijax_filter');
	if (typeof(elem) == 'object') {
		if (elem.type == 'select-multiple') {
			$(elem).next().removeClass('chzn-container-active');
			options_id = elem.parentNode.id;
		} else if (elem.type == 'checkbox' && elem.checked) {
			unijaxFilter.setSelectInputHtml(elem);
			options_id = elem.parentNode.parentNode.parentNode.id;
		} else if (elem.type == 'text') {
			options_id = elem.parentNode.parentNode.id;
		} else {
			options_id = elem.parentNode.id;
		}
		$('#'+options_id+'_label').addClass('uf_label_selected');
		if (unijaxFilter.show_immediately && (!unijaxFilter.use_ajax || unijaxFilter.need_redirect)) {
			form.submit();
			return false;
		} else if (!unijaxFilter.use_ajax) {
			return false;
		}
	} else if (!unijaxFilter.use_ajax) {
		return false;
	}
	var count = $('#uf_count_product');
	count.html('<span class="uf_count_loader"></span>');
	unijaxFilter.xhr = $.ajax({
		type: 'POST',
		dataType: 'json',
		url: form.prop('action'), 
		data : form.serialize()+'&prepareUnijaxFilter=1',
		cache: false,  
		success: function(json){
			count.html(json['total']);
			if (typeof(elem) == 'object' && unijaxFilter.show_immediately) {
				var viewTarget, viewTargetAttr, viewJson = $(json['view']);
				if (viewTargetAttr = viewJson.prop('id')) {
					viewTarget = $(viewJson.prop('tagName')+'#'+viewTargetAttr);
				} else if (viewTargetAttr = viewJson.prop('class')) {
					viewTarget = $(viewJson.prop('tagName')+'.'+viewTargetAttr+':first');
				}
				if (typeof(viewTarget) == 'object' && viewTarget[0] !== undefined) {
					viewTarget.replaceWith(json['view']);
					$('body').trigger('onAfterUnijaxFilterUpdateProductList');
				} else {
					form.submit();
					return false;
				}
			}
			if (json['priceto'] > 0) {
				var priceFrom = $('#uf_price_from');
				var priceTo = $('#uf_price_to');
				var priceFromValue = priceFrom.val();
				var priceToValue = priceTo.val();
				if (priceFromValue != '' || priceToValue != '') {
					$('#uf_prices_label').addClass('uf_label_selected');
				} else {
					$('#uf_prices_label').removeClass('uf_label_selected');
				}
				if (priceFromValue == '') {
					priceFromValue = json['pricefrom'];
				} else if (priceFromValue < json['pricefrom']) {
					priceFromValue = json['pricefrom'];
					priceFrom.val(priceFromValue);
				}
				if (priceToValue == '') {
					priceToValue = json['priceto'];
				} else if (priceToValue > json['priceto']) {
					priceToValue = json['priceto'];
					priceTo.val(priceToValue);
				}
				unijaxFilter.trackbar(priceFromValue,json['pricefrom'],priceToValue,json['priceto']);
			}
			var uf_options, selectedObj = {}, options_select = [], options_enabled = [];
			$('#jshop_unijax_filter input[type=checkbox], #jshop_unijax_filter select').each(function(i,el) {
				if (el.type == 'checkbox') {
					uf_options = el.parentNode.parentNode.parentNode;
					if ($.inArray(el.value, json['result'][el.name] ) < 0) {
						el.disabled = true;
						el.checked = false;
						if (unijaxFilter.hide_non_active == 0) {
							$(el.parentNode).addClass('uf_hide');
						}
					} else if (!el.checked) {
						el.disabled = false;
						if (unijaxFilter.hide_non_active == 0) {
							$(el.parentNode).removeClass('uf_hide');
						}
						options_enabled[uf_options.id] = 1;
					} else {
						options_select[uf_options.id] = 1;
					}
					var parentId = unijaxFilter.hideSelectInput(el);
					if (parentId) {
						if (typeof(selectedObj[parentId]) === 'undefined') {
							selectedObj[parentId] = unijaxFilter.getSelectInputHtml(el);
						} else {
							selectedObj[parentId] += unijaxFilter.getSelectInputHtml(el);
						}
					}
				} else {
					uf_options = el.parentNode;
					$('#'+el.id+' option[value!=""]').each(function() {
						if ($.inArray(this.value, json['result'][el.name] )<0) {
							this.disabled = true;
							this.selected = false;
							if (unijaxFilter.hide_non_active == 0) {
								$(this).addClass('uf_hide');
							}
						} else if (!this.selected) {
							this.disabled = false;
							if (unijaxFilter.hide_non_active == 0) {
								$(this).removeClass('uf_hide');
							}
							options_enabled[uf_options.id] = 1;
						} else if ((uf_options.id != 'uf_photos' && uf_options.id != 'uf_availabilitys') || this.value != 0) {
							options_select[uf_options.id] = 1;
						}
					});
				}
			});
			$('.uf_options').each(function() {
				var label = $('#'+this.id+'_label');
				var options = $(this);
				if (this.id in options_select) {
					label.addClass('uf_label_selected');
					if (unijaxFilter.hide_non_active == 0) {
						label.removeClass('uf_hide');
						options.removeClass('uf_hide');
					}
				} else if (this.id in options_enabled) {
					label.removeClass('uf_label_selected');
					if (unijaxFilter.hide_non_active == 0) {
						label.removeClass('uf_hide');
						options.removeClass('uf_hide');
					}
				} else {
					label.removeClass('uf_label_selected');
					if (unijaxFilter.hide_non_active == 0) {
						label.addClass('uf_hide');
						options.addClass('uf_hide');
					}
				}
			});
			for (var id in selectedObj) {
				$('#'+id+'_select_options').html(selectedObj[id]);
			}
			unijaxFilter.setOverflowHeight();
			$('.uf_chosen').trigger('liszt:updated');
		}  
	});  
}

unijaxFilter.updateForm = function(el, timeout) {
	clearTimeout(unijaxFilter.timeout);
	if (unijaxFilter.xhr) {
		unijaxFilter.xhr.abort();
	}
	if (parseInt(timeout) > 0) {
		unijaxFilter.timeout = setTimeout(function() {
			unijaxFilter._updateForm(el);
		}, timeout);
	} else {
		unijaxFilter._updateForm(el);
	}
}		

unijaxFilter.clearPrice = function() {
	var uf_price_from = document.getElementById('uf_price_from');
	var uf_price_to = document.getElementById('uf_price_to');
	if (uf_price_from.value != '' || uf_price_to.value != '') {
		uf_price_from.value = '';
		uf_price_to.value = '';
		unijaxFilter._updateForm(uf_price_from);
	}
}

unijaxFilter.removeSelectInput = function(id, el) {
	$=jQuery;
	var input = document.getElementById(id);
	$(input).prop('checked',false).parent().removeClass('uf_hide');
	$(el.parentNode).remove();
	unijaxFilter._updateForm(input);
}

unijaxFilter.setOverflowHeight = function() {
	$=jQuery;
	$('.uf_overflow').each(function() {
		var el = $(this), overflow = 0, el_height = 0;
		el.children('.uf_input:not(.uf_hide)').each(function(i) {
			if (unijaxFilter.options_qnt < i+1) {
				overflow = 1;
				return false;
			}
			el_height += $(this).outerHeight(true);
		});
		if (overflow) {
			el.removeClass('uf_no_overflow');
			el.height(el_height);
		} else {
			el.addClass('uf_no_overflow');
			el.css('height','');
		}
	});
}		

unijaxFilter.tip = function(elem, mode) {
	$=jQuery;
	if (mode=='show') {
		$('#uf_tooltip').remove();
		$('body').append('<div id="uf_tooltip">'+$(elem).next().html()+'</div>');
		$('#uf_tooltip')
			.css('top',($(elem).offset().top - 5) + 'px')
			.css('left',($(elem).offset().left + 20) + 'px')
			.fadeIn('fast');
    } else {
		$('#uf_tooltip').remove();
    }
}

unijaxFilter.trackbar = function(leftValue, leftValueLimit, rightValue, rightValueLimit) {
	$ = jQuery;
	var leftLimit = Math.floor(leftValueLimit / 1.1);
	var rightLimit = Math.ceil(rightValueLimit * 1.1);
	if (leftLimit < unijaxFilter.priceRangeFrom) {
		leftLimit = unijaxFilter.priceRangeFrom;
	}
	if (rightLimit > unijaxFilter.priceRangeTo) {
		rightLimit = unijaxFilter.priceRangeTo;
	}
	$('#uf_price_trackbar').trackbar({
		'onMove' : function() {
			$('#uf_price_from').val(this.leftValue);
			$('#uf_price_to').val(this.rightValue);
			unijaxFilter.updateForm(document.getElementById('uf_price_from'), unijaxFilter.priceDelay);
		},
		'onMoveLeft' : function() {
			$('#uf_price_from').val(this.leftValue);
			unijaxFilter.updateForm(document.getElementById('uf_price_from'), unijaxFilter.priceDelay);
		},
		'onMoveRight' : function() {
			$('#uf_price_to').val(this.rightValue);
			unijaxFilter.updateForm(document.getElementById('uf_price_from'), unijaxFilter.priceDelay);
		},
		'leftLimit' : leftLimit,
		'leftValue' : leftValue,
		'leftValueLimit' : leftValueLimit,
		'rightLimit' : rightLimit,
		'rightValue' : rightValue,
		'rightValueLimit' :rightValueLimit,
		'clearValues' : true
	});
}

jQuery(function($) {
	unijaxFilter.trackbar($('#uf_price_from').val(),unijaxFilter.priceRangeFrom,$('#uf_price_to').val(),unijaxFilter.priceRangeTo);
	$('#jshop_unijax_filter input[type=checkbox]:checked').each(function() {
		unijaxFilter.setSelectInputHtml(this);
	});
	unijaxFilter.setOverflowHeight();
	$('.uf_chosen').chosen({
		disable_search_threshold : 10,
		allow_single_deselect : true
	});
	unijaxFilter.updateForm();
});

(function($) {
$.fn.trackbar = function(op, id){
	op = $.extend({
		onMove: function(){},
		onMoveLeft: function(leftOut){},
		onMoveRight: function(rightOut){},
		width: this.outerWidth(true),
		leftLimit: 0,
		leftValue: 0,
		leftValueLimit: 0,
		rightLimit: 100,
		rightValue: 100,
		rightValueLimit: 100,
		jq: this
	},op);
	$.trackbar.getObject(id).init(op);
}
$.trackbar = {
	archive : [],
	getObject : function(id) {
		if(typeof id == 'undefined')id = this.archive.length;
		if(typeof this.archive[id] == "undefined"){
			this.archive[id] = new this.hotSearch(id);
		}
		return this.archive[id];
	}
};
$.trackbar.hotSearch = function(id) {
	this.id = id;
	this.leftWidth = 0;
	this.leftLimitWidth = 0;
	this.rightWidth = 0;
	this.rightLimitWidth = 0;
	this.width = 0;
	this.intervalWidth = 0;
	this.leftLimit = 0;
	this.leftValue = 0;
	this.leftValueLimit = 0;
	this.rightLimit = 0;
	this.rightValue = 0;
	this.rightValueLimit = 0;
	this.valueInterval = 0;
	this.widthRem = 10;
	this.valueWidth = 0;
	this.roundUp = 0;
	this.x0 = 0; this.y0 = 0;
	this.blockX0 = 0; 
	this.rightX0 = 0; 
	this.leftX0 = 0;
	this.moveState = false;
	this.moveIntervalState = false;
	this.debugMode = false;
	this.clearLimits = false;
	this.clearValues = true;
	this.onMove = null;
	this.onMoveLeft = null;
	this.onMoveRight = null;
	this.leftBlock = null;
	this.leftLimitBlock = null;
	this.rightBlock = null;
	this.rightLimitBlock = null;
	this.leftBegun = null;
	this.rightBegun = null;
	this.centerBlock = null;
	this.itWasMove = false;
}
$.trackbar.hotSearch.prototype = {
	ERRORS : {
		1 : "Ошибка при инициализации объекта",
		2 : "Левый бегунок не найден",
		3 : "Правый бегунок не найден",
		4 : "Левая область ресайза не найдена",
		5 : "Правая область ресайза не найдена",
		6 : "Не задана ширина области бегунка",
		7 : "Не указано максимальное изменяемое значение",
		8 : "Не указана функция-обработчик значений",
		9 : "Не указана область клика"
	},
	LEFT_BLOCK_PREFIX : "leftBlock",
	RIGHT_BLOCK_PREFIX : "rightBlock",
	LEFT_BEGUN_PREFIX : "leftBegun",
	RIGHT_BEGUN_PREFIX : "rightBegun",
	CENTER_BLOCK_PREFIX : "centerBlock",

	gebi : function(id) {
		return this.jq.find('#'+id)[0];
	},
	addHandler : function(object, event, handler, useCapture) {
		if (object.addEventListener) {
			object.addEventListener(event, handler, useCapture ? useCapture : false);
		} else if (object.attachEvent) {
			object.attachEvent('on' + event, handler);
		} else alert(this.errorArray[9]);
	},
	defPosition : function(event) { 
		var x = y = 0; 
		if (document.attachEvent != null) {
			x = window.event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft; 
			y = window.event.clientY + document.documentElement.scrollTop + document.body.scrollTop; 
		} 
		if (!document.attachEvent && document.addEventListener) {
			x = event.clientX + window.scrollX; 
			y = event.clientY + window.scrollY; 
		} 
		return {x:x, y:y}; 
	},
	absPosition : function(obj) { 
		var x = y = 0; 
		while(obj) { 
			x += obj.offsetLeft; 
			y += obj.offsetTop; 
			obj = obj.offsetParent; 
		} 
		return {x:x, y:y}; 
	},

	debug : function(keys) {
		if (!this.debugMode) return;
		var mes = "";
		for (var i = 0; i < keys.length; i++) mes += this.ERRORS[keys[i]] + " : ";
		mes = mes.substring(0, mes.length - 3);
		alert(mes);
	},
	init : function(hash) {
		this.leftLimit = hash.leftLimit || this.leftLimit;
		this.rightLimit = hash.rightLimit || this.rightLimit;
		this.width = hash.width || this.width;
		this.onMove = hash.onMove || this.onMove;
		this.onMoveLeft = hash.onMoveLeft || this.onMoveLeft;
		this.onMoveRight = hash.onMoveRight || this.onMoveRight;
		this.clearLimits = hash.clearLimits || this.clearLimits;
		this.clearValues = hash.clearValues || this.clearValues;
		this.roundUp = hash.roundUp || this.roundUp;
		this.jq = hash.jq;

		this.jq.html('<table' + (this.width ? ' style="width:'+this.width+'px;"' : '') + 'class="trackbar" onSelectStart="return false">\
			<tr>\
				<td class="l"><div id="leftBlock"><span></span><span class="limit"></span><span class="inactive"></span><img id="leftBegun" ondragstart="return false" src="/modules/mod_jshopping_unijax_filter/images/b_l.gif" width="9" height="17" /></div></td>\
				<td class="c" id="centerBlock"></td>\
				<td class="r"><div id="rightBlock"><span></span><span class="limit"></span><img id="rightBegun" ondragstart="return false" src="/modules/mod_jshopping_unijax_filter/images/b_r.gif" width="9" height="17" /><span class="inactive"></span></div></td>\
			</tr>\
		</table>');

		if (this.onMove == null || this.onMoveLeft == null || this.onMoveRight == null) {
			this.debug([1,8]);
				return;
		}
		this.leftBegun = this.gebi(this.LEFT_BEGUN_PREFIX);
		if (this.leftBegun == null) {
			this.debug([1,2]);
				return;
		}
		this.rightBegun = this.gebi(this.RIGHT_BEGUN_PREFIX);
		if (this.rightBegun == null) {
			this.debug([1,3]);
				return;
		}
		this.leftBlock = this.gebi(this.LEFT_BLOCK_PREFIX);
		if (this.leftBlock == null) {
			this.debug([1,4]);
				return;
		}
		this.rightBlock = this.gebi(this.RIGHT_BLOCK_PREFIX);
		if (this.rightBlock == null) {
			this.debug([1,5]);
				return;
		}
		this.centerBlock = this.gebi(this.CENTER_BLOCK_PREFIX);
		if (this.centerBlock == null) {
			this.debug([1,9]);
				return;
		}
		if (!this.width) {
			this.debug([1,6]);
				return;
		}
		if (!this.rightLimit) {
			this.debug([1,7]);
				return;
		}

		this.valueWidth = this.width - 2 * this.widthRem;
		this.rightValue = hash.rightValue || this.rightLimit;
		this.rightValueLimit = hash.rightValueLimit || this.rightLimit;
		this.rightValue = this.rightValue > this.rightValueLimit ? this.rightValueLimit : this.rightValue;
		this.leftValue = hash.leftValue || this.leftLimit;
		this.leftValueLimit = hash.leftValueLimit || this.leftLimit;
		this.leftValue = this.leftValue < this.leftValueLimit ? this.leftValueLimit : this.leftValue;
		this.valueInterval = this.rightLimit - this.leftLimit;
		this.leftWidth = parseInt((this.leftValue - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
		this.leftWidthLimit = parseInt((this.leftValueLimit - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
		this.rightWidth = this.valueWidth - parseInt((this.rightValue - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
		this.rightWidthLimit = this.valueWidth - parseInt((this.rightValueLimit - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
		$('div#leftBlock .inactive').css('margin-left', this.leftWidthLimit-this.widthRem+'px');
		$('div#rightBlock .inactive').css('margin-right', this.rightWidthLimit+'px');

		if (!this.clearLimits) {
			this.leftBlock.firstChild.nextSibling.innerHTML = unijaxFilter.priceRangeFrom;
			this.rightBlock.firstChild.nextSibling.innerHTML = unijaxFilter.priceRangeTo;
		}

		this.setCurrentState();

		var _this = this;
		this.addHandler (
			document,
			"mousemove",
			function(evt) {
				if (_this.moveState) {
					if (parent.xhr) {
						parent.xhr.abort();
						parent.xhr = null;
					}
					_this.moveHandler(evt);
				}
				if (_this.moveIntervalState) _this.moveIntervalHandler(evt);
			}
		);
		this.addHandler (
			document,
			'mouseup',
			function() {
				_this.moveState = false;
				_this.moveIntervalState = false;
			}
		);
		this.addHandler (
			this.leftBegun,
			'mousedown',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				evt = evt || window.event;
				if (evt.preventDefault) evt.preventDefault();
				evt.returnValue = false;
				_this.moveState = "left";
				_this.x0 = _this.defPosition(evt).x;
				_this.blockX0 = _this.leftWidth;
				_this.moveHandler(evt);
			}
		);
		this.addHandler (
			this.rightBegun,
			'mousedown',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				evt = evt || window.event;
				if (evt.preventDefault) evt.preventDefault();
				evt.returnValue = false;
				_this.moveState = "right";
				_this.x0 = _this.defPosition(evt).x;
				_this.blockX0 = _this.rightWidth;
				_this.moveHandler(evt);
			}
		);
		this.addHandler (
			this.centerBlock,
			'mousedown',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				evt = evt || window.event;
				if (evt.preventDefault) evt.preventDefault();
				evt.returnValue = false;
				_this.moveIntervalState = true;
				_this.moveState = "center";
				_this.intervalWidth = _this.width - _this.rightWidth - _this.leftWidth;
				_this.x0 = _this.defPosition(evt).x;
				_this.rightX0 = _this.rightWidth; 
				_this.leftX0 = _this.leftWidth;
			}
		),
		this.addHandler (
			this.centerBlock,
			'click',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				if (!_this.itWasMove) _this.clickMove(evt);
				_this.itWasMove = false;
			}
		);
		this.addHandler (
			this.leftBlock,
			'click',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				if (!_this.itWasMove)_this.clickMoveLeft(evt);
				_this.itWasMove = false;
			}
		);
		this.addHandler (
			this.rightBlock,
			'click',
			function(evt) {
				if (parent.xhr) {
					parent.xhr.abort();
					parent.xhr = null;
				}
				if (!_this.itWasMove)_this.clickMoveRight(evt);
				_this.itWasMove = false;
			}
		);
	},
	clickMoveRight : function(evt) {
		evt = evt || window.event;
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		var x = this.defPosition(evt).x - this.absPosition(this.rightBlock).x;
		var w = this.rightBlock.offsetWidth;
		if (x <= 0 || w <= 0 || w < x || (w - x) < this.widthRem) return;
		this.rightWidth = (w - x);
		this.rightCounter();

		this.setCurrentState();
		this.onMoveRight();
	},
	clickMoveLeft : function(evt) {
		evt = evt || window.event;
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		var x = this.defPosition(evt).x - this.absPosition(this.leftBlock).x;
		var w = this.leftBlock.offsetWidth;
		if (x <= 0 || w <= 0 || w < x || x < this.widthRem) return;
		this.leftWidth = x;
		this.leftCounter();

		this.setCurrentState();
		this.onMoveLeft();
	},
	clickMove : function(evt) {
		evt = evt || window.event;
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		var x = this.defPosition(evt).x - this.absPosition(this.centerBlock).x;
		var w = this.centerBlock.offsetWidth;
		if (x <= 0 || w <= 0 || w < x) return;
		if (x >= w / 2) {
			this.rightWidth += (w - x);
			this.rightCounter();
			this.setCurrentState();
			this.onMoveRight();
		} else {
			this.leftWidth += x;
			this.leftCounter();
			this.setCurrentState();
			this.onMoveLeft();
		}
	},
	setCurrentState : function() {
		this.leftBlock.style.width = this.leftWidth + 'px';
		$('div#leftBlock .inactive').width(this.leftWidth-this.leftWidthLimit);
		$('div#rightBlock .inactive').width(this.rightWidth-this.rightWidthLimit);
		if (!this.clearValues) this.leftBlock.firstChild.innerHTML = this.leftValue;
		this.rightBlock.style.width = this.rightWidth + 'px';
		if (!this.clearValues) this.rightBlock.firstChild.innerHTML = this.rightValue;
	},
	moveHandler : function(evt) {
		this.itWasMove = true;
		evt = evt || window.event;
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		if (this.moveState == 'left') {
			this.leftWidth = this.blockX0 + this.defPosition(evt).x - this.x0;
			this.leftCounter();
			this.setCurrentState();
			this.onMoveLeft(this.leftOut);
		}
		if (this.moveState == 'right') {
			this.rightWidth = this.blockX0 + this.x0 - this.defPosition(evt).x;
			this.rightCounter();
			this.setCurrentState();
			this.onMoveRight(this.rightOut);
		}
	},
	moveIntervalHandler : function(evt) {
		this.itWasMove = true;
		evt = evt || window.event;
		if (evt.preventDefault) evt.preventDefault();
		evt.returnValue = false;
		var dX = this.defPosition(evt).x - this.x0;
		if (dX > 0) {
			this.rightWidth = this.rightX0 - dX > this.rightWidthLimit ? this.rightX0 - dX : this.rightWidthLimit;
			this.leftWidth = this.width - this.rightWidth - this.intervalWidth;
		} else {
			this.leftWidth = this.leftX0 + dX > this.leftWidthLimit ? this.leftX0 + dX : this.leftWidthLimit;
			this.rightWidth = this.width - this.leftWidth - this.intervalWidth;
		}
		this.rightCounter();
		this.leftCounter();
		this.setCurrentState();
		this.onMove();
	},
	updateRightValue : function(rightValue) {
		try {
			this.rightValue = parseInt(rightValue);
			this.rightValue = this.rightValue < this.leftLimit ? this.leftLimit : this.rightValue;
			this.rightValue = this.rightValue > this.rightLimit ? this.rightLimit : this.rightValue;
			this.rightValue = this.rightValue < this.leftValue ? this.leftValue : this.rightValue;
			this.rightWidth = this.valueWidth - parseInt((this.rightValue - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
			this.rightWidth = isNaN(this.rightWidth) ? this.widthRem : this.rightWidth;
			this.setCurrentState();
		} catch(e) {}
	},
	rightCounter : function() {
		this.rightWidth = this.rightWidth > this.width - this.leftWidth ? this.width - this.leftWidth : this.rightWidth;
		if (this.rightWidth < this.rightWidthLimit) {
			this.rightWidth = this.rightWidthLimit;
			this.rightValue = this.rightValueLimit;
			this.rightOut = true;
		} else {
			this.rightValue = this.leftLimit + this.valueInterval - parseInt((this.rightWidth - this.widthRem) / this.valueWidth * this.valueInterval);
			this.rightOut = false;
		}
		if (this.roundUp) this.rightValue = parseInt(this.rightValue / this.roundUp) * this.roundUp;
		if (this.leftWidth + this.rightWidth >= this.width) this.rightValue = this.leftValue+1;
		if (this.rightValue > this.rightLimit) this.rightValue = this.rightLimit;
	},
	updateLeftValue : function(leftValue) {
		try {
			this.leftValue = parseInt(leftValue);
			this.leftValue = this.leftValue < this.leftLimit ? this.leftLimit : this.leftValue;
			this.leftValue = this.leftValue > this.rightLimit ? this.rightLimit : this.leftValue;
			this.leftValue = this.rightValue < this.leftValue ? this.rightValue : this.leftValue;
			this.leftWidth = parseInt((this.leftValue - this.leftLimit) / this.valueInterval * this.valueWidth) + this.widthRem;
			this.leftWidth = isNaN(this.leftWidth) ? this.widthRem : this.leftWidth;
			this.setCurrentState();
		} catch(e) {}
	},
	leftCounter : function() {
		this.leftWidth = this.leftWidth > this.width - this.rightWidth ? this.width - this.rightWidth : this.leftWidth;
		if (this.leftWidth < this.leftWidthLimit) {
			this.leftWidth = this.leftWidthLimit;
			this.leftValue = this.leftValueLimit;
			this.leftOut = true;
		} else {
			this.leftValue = this.leftLimit + parseInt((this.leftWidth - this.widthRem) / this.valueWidth * this.valueInterval);
			this.leftOut = false;
		}
		if (this.roundUp) this.leftValue = parseInt(this.leftValue / this.roundUp) * this.roundUp;
		if (this.leftWidth + this.rightWidth >= this.width) this.leftValue = this.rightValue-1;
		if (this.leftValue < this.leftLimit) this.leftValue = this.leftLimit;
	}
}

})(jQuery);