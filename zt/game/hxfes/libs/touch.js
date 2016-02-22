var isPc = function() {
	if ("ontouchend" in window == false) {
		return "isPc";
	} else {
		return false;
	}
}
var isIe = function() {
	if (window.navigator.msPointerEnabled) {
		return "isIe";
	} else {
		return false;
	}
}
var isMobile = function() {
	if ("ontouchend" in window) {
		return "isMobile";
	} else {
		return false;
	}
}
var iteratorUserAgentObj = function() {
	for (var i = 0, fn; fn = arguments[i++];) {
		var gesture = fn();
		if (gesture !== false) {
			return gesture;
		}
	}
}

var initEvent = function() {
	var userAgent = iteratorUserAgentObj(isIe, isMobile, isPc);
	var _mouseEvent = {};
	var _mouseKey=["MOUSEDOWN","MOUSEMOVE","MOUSEUP"];
	switch (userAgent) {
		case "isIe":
			var _arr=["MSPointerDown", "MSPointerMove", "MSPointerUp"];
			break;
		case "isMobile":
			var _arr = ["touchstart", "touchmove", "touchend"];
			break;
		case "isPc":
			var _arr = ["mousedown", "mousemove", "mouseup"];
			break;
	}
	return (function(){
		for (var x in _arr) {
			_mouseEvent[_mouseKey[x]]=_arr[x];
			
		}
		_mouseEvent.length=parseInt(x);
		return _mouseEvent;			
	})();
}
var _fn = function(fn) {	
	return fn();
}
var Event = _fn(initEvent);

var addEvent = function(el, type, handler) {
	if (window.addEventListener) {
		addEvent = function(el, type, handler) {
			el.addEventListener(type, handler, false);
		}
	} else if (window.addEvent) {
		addEvent = function(el, type, handler) {
			el.addEvent('on' + type, handler);
		}
	}
	addEvent(el, type, handler);
}
var strategies = {
	isEmpty: function(val, errorMsg) {
		if (val === '') {
			return errorMsg;
		}
	},
	minLength: function(val, length, errorMsg) {
		if (val.length < length) {
			return errorMsg;
		}
	},
	isMoblie: function(val, errorMsg) {
		if (!/^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|18[0-9]|177)\d{8}$/.test(val)) {
			return errorMsg;
		}
	}
};
var Validator = function() {
	this.cache = [];
};
Validator.prototype.add = function(dom, rules) {
	var self = this;
	for (var i = 0, rule; rule = rules[i++];) {
		(function(rule) {
			var typeAry = rule.type.split(':');
			var errorMsg = rule.msg;
			self.cache.push(function() {
				var type = typeAry.shift();
				typeAry.unshift(dom.value);
				typeAry.push(errorMsg);
				return strategies[type].apply(dom, typeAry)
			});
		})(rule);
	}
};
Validator.prototype.start = function() {
	for (var i = 0, valtorFunc; valtorFunc = this.cache[i++];) {
		var msg = valtorFunc();
		if (msg) {
			return msg;
		}
	}
};
var Slide = {
	chose: function(el) {
		var self = this;
		this.collectXY = {};
		this.direction = null;
		this.el = el;
		this.isMove = false;
		this.collectXY.disX = null;
		this.collectXY.disY = null;
		el.addEventListener(Event.MOUSEDOWN, function(e) {
			self.isMove = false;
			self.collectXY.sy = e.pageY || e.targetTouches[0].pageY;
			self.collectXY.sx = e.pageX || e.targetTouches[0].pageX;
		},false);
		document.addEventListener(Event.MOUSEMOVE, function(e) {
			self.isMove = true;
			self.collectXY.ey = e.pageY || e.targetTouches[0].pageY;
			self.collectXY.ex = e.pageX || e.targetTouches[0].pageX;
		},false);
		return this;
	},
	listener: function(callback) {
		var self = this;
		self.el.addEventListener(Event.MOUSEUP, function() {
			var disX = Math.abs(self.collectXY.ex - self.collectXY.sx);
			var disY = Math.abs(self.collectXY.ey - self.collectXY.sy);
			if (self.collectXY.ey > self.collectXY.sy && disY > disX) {
				self.direction = 'slideDown';
				self.collectXY = {};
			}
			if (self.collectXY.ey < self.collectXY.sy && disY > disX) {
				self.direction = 'slideUp';
				self.collectXY = {};
			}
			if (self.collectXY.ex > self.collectXY.sx+30&& disY < disX) {
				self.direction = 'slideRight';
				self.collectXY = {};
			}
			if (self.collectXY.ex < self.collectXY.sx+30&& disY < disX) {
				self.direction = 'slideLeft';
				self.collectXY = {};
			}
			if (self.isMove == false) {
				self.direction = 'tap';
				self.collectXY = {};
			}
			callback();

		},false);
		return this;
	},
};
['slideUp', 'slideLeft', 'slideDown', 'slideRight', 'tap'].forEach(function(eventName) {
	Slide[eventName] = function(callback) {
		var self = this;
		this.listener(function() {
			if (eventName == self.direction) {
				callback()
			};
		})
		return this;
	}
});