(function($) {
	//shake
	//@author 霍宇恒  
	//@version 1.0 2015/12/02
	//@parameter
	// threshold-->类型:number 默认:3000 解释:摇动的阀值  
	// success-->类型:function 默认:null 解释:成功摇动的回调  
	// once-->类型:bool 默认:true 解释:是否只调用一次就移除事件  
	$.shake = function(options) {
		var _userOptions = options;
		var _defultOptions = {
			"threshold": 3000,
			"success": function() {},
			"once": true
		};
		var _finally = {
			"threshold": $.compareOptions(_userOptions.threshold, _defultOptions.threshold),
			"success": $.compareOptions(_userOptions.success, _defultOptions.success),
			"once": $.compareOptions(_userOptions.once, _defultOptions.once),
		};
		var sX, sY, sZ, lX, lY, lZ, lUpdate = 0;
		if (window.DeviceMotionEvent) {
			lUpdate = new Date().getTime();
			window.addEventListener('devicemotion', onDeviceMotionHandler, false);
		};

		function onDeviceMotionHandler(eventData) {
			var acceleration = eventData.accelerationIncludingGravity;
			var curTime = new Date().getTime();
			var diffTime = curTime - lUpdate;
			if (diffTime > 100) {
				lUpdate = curTime;
				sX = acceleration.x;
				sY = acceleration.y;
				sZ = acceleration.z;
				var speed = (Math.abs(sX - lX) + Math.abs(sY - lY) + Math.abs(sZ - lZ)) / diffTime * 10000;
				if (speed > _finally.threshold) {
					if (_finally.once) {
						window.removeEventListener('devicemotion', onDeviceMotionHandler, false);
					}
					_finally.success();
				}
				lX = sX;
				lY = sY;
				lZ = sZ;
			};
		};
	};
	//	shake

	//scratchCard
	//@author 霍宇恒  
	//@version 1.0 2015/12/21
	//@parameter
	// radius-->类型:number 默认:30 解释:圆的大小
	// above-->类型:string 默认:null 解释:刮刮卡上层图片
	// under-->类型:string 默认:null 解释:刮刮卡下层图片
	//percent-->类型:number 默认:0.5 解释:刮到自定义的阀值  触发success 最大值为1
	// success-->类型:function 默认:null 解释:刮刮卡达到阀值时触发的函数
	//@使用方法
	//<div class="scratchCardCon"></div> 复制以下div到html中
	//$.scratchCard({
	//		"radius":30,
	//		"above": "img/mask.jpg",
	//		"under": "img/really.jpg",
	//		"percent": 0.5,
	//		"success": function() {}
	//}); js调用格式
	$.scratchCard = function(options) {
		var _getoptions = options;
		var _defult = {
			"radius": 30,
			"above": null,
			"under": null,
			"percent": 0.5,
			"success": function() {}
		};
		var _user = {
			"radius": $.compareOptions(_getoptions.radius, _defult.radius),
			"above": $.compareOptions(_getoptions.above, _defult.above),
			"under": $.compareOptions(_getoptions.under, _defult.under),
			"percent": $.compareOptions(_getoptions.percent, _defult.percent),
			"success": $.compareOptions(_getoptions.success, _defult.success)
		};
		if (_user.above == null) {
			alert("请设置正确的正面图片路径");
		};
		if (_user.under == null) {
			alert("请设置正确的底面图片路径");
		};
		var _scratch = {
			x1: null,
			y1: null,
			isMove: false,
			isEnd: false,
			creatCanvas: function(imgSrc, zindex) {
				var canvas = document.createElement("canvas");
				var ctx = canvas.getContext("2d");
				var img = new Image();
				img.src = imgSrc;
				img.onload = function() {
					$(".scratchCardCon").append(canvas);
					$(".scratchCardCon").css({
						"width": img.width,
						"height": img.height,
						"position": "relative"
					});
					canvas.width = img.width;
					canvas.height = img.height;
					$(canvas).css({
						"position": "absolute",
						"left": 0,
						"top": 0,
						"z-index": zindex
					});
					ctx.drawImage(img, 0, 0, img.width, img.height);
					ctx.lineCap = "round";
					ctx.lineJoin = "round";
					ctx.lineWidth = _user.radius * 2;
					ctx.globalCompositeOperation = "destination-out";
				}
				return ctx;
			},
			getxy: function(x, y) {
				if (this.aboveCanvas != null) {
					var canvas = this.aboveCanvas.canvas;
				};
				var bbox = canvas.getBoundingClientRect();
				return {
					x: (x - bbox.left) * (canvas.width / bbox.width),
					y: (y - bbox.top) * (canvas.height / bbox.height)
				}
			},
			inertia: function(e) {
				if (!$.isPc()) {
					this.inertia = function(e) {
						return this.getxy(e.targetTouches[0].pageX, e.targetTouches[0].pageY);
					}
				} else {
					this.inertia = function(e) {
						return this.getxy(e.clientX, e.clientY);
					}
				}
			},
			init: function() {
				$(this.aboveCanvas.canvas).css("transition", "opacity .7s");
				$(this.aboveCanvas.canvas).one("webkitTransitionEnd", function() {
					$(this).remove();
				});
				this.inertia();
				this.aboveCanvas.canvas.addEventListener(Event.MOUSEDOWN, this.mousedownhandler.bind(this));
				this.aboveCanvas.canvas.addEventListener(Event.MOUSEMOVE, this.mousemovehandler.bind(this));
				this.aboveCanvas.canvas.addEventListener(Event.MOUSEUP, this.mouseuphandler.bind(this));
			},
			mousedownhandler: function(e) {
				if (this.isEnd) {
					return false;
				}
				this.isMove = true;
				e.preventDefault();
				var loc = this.inertia(e);
				this.x1 = loc.x;
				this.y1 = loc.y;
				this.aboveCanvas.save();
				this.aboveCanvas.beginPath();
				this.aboveCanvas.arc(this.x1, this.y1, 1, 0, 2 * Math.PI);
				this.aboveCanvas.fill();
				this.aboveCanvas.restore();
			},
			mousemovehandler: function(e) {
				if (this.isMove == false) {
					return false;
				}
				e.preventDefault();
				var loc = this.inertia(e);
				var x2 = loc.x;
				var y2 = loc.y;
				this.aboveCanvas.save();
				this.aboveCanvas.moveTo(this.x1, this.y1);
				this.aboveCanvas.lineTo(x2, y2);
				this.aboveCanvas.stroke();
				this.aboveCanvas.restore();
				this.x1 = x2;
				this.y1 = y2;
			},
			mouseuphandler: function() {
				if (this.isEnd) {
					return false;
				}
				this.isMove = false;
				var imgData = this.aboveCanvas.getImageData(0, 0, this.aboveCanvas.canvas.width, this.aboveCanvas.canvas.height);
				var imgDataLength = imgData.data.length;
				var dd = 0;
				for (var i = 0; i < imgDataLength; i++) {
					if (imgData.data[i] == 0) {
						dd++;
					}
				}
				if (dd >= imgDataLength * _user.percent) {
					this.isEnd = true;
					$(this.aboveCanvas.canvas).css("opacity", 0);
					_user.success();
				}
			}

		};
		_scratch.creatCanvas(_user.under, 1);
		_scratch.aboveCanvas = _scratch.creatCanvas(_user.above, 2);
		_scratch.init();
	};
	//	scratchCard
})(jQuery);
$.extend({
	ranNum: function(min, max) {
		return Math.floor(Math.random() * (max - min + 1) + min);
	},
	ranArr: function(min, max,l) {
		var arr = [];
		var bol = true;
		var o = 0;
		var isPush = true;
		var isCheck = true;
		while (bol) {
			if (o > l-1) {
				return arr;
				break;
			}
			bol = false;
			count = 0;
			isCheck = true
			var d = $.ranNum(min, max);
			for (var x in arr) {
				if (arr[x] == d) {
					isCheck = false;
					break;
				}
			}
			if (isCheck) {
				isPush = true;
			} else {
				isPush = false;
				bol = true;
			}
			if (isPush) {
				arr.push(d);
				o += 1;
				bol = true;
			}
		}
	},
	resizeWx: function() {
		document.documentElement.style.height = window.innerHeight + 'px';
	},
	isPc: function() {
		if ("ontouchend" in window == false) {
			return "isPc";
		} else {
			return false;
		}
	},
	isIe: function() {
		if (window.navigator.msPointerEnabled) {
			return "isIe";
		} else {
			return false;
		}
	},
	isMobile: function() {
		if ("ontouchend" in window) {
			return "isMobile";
		} else {
			return false;
		}
	},
	iteratorUserAgentObj: function() {
		for (var i = 0, fn; fn = arguments[i++];) {
			var gesture = fn();
			console.log()
			if (gesture !== false) {
				return gesture;
			}
		}
	},
	initEvent: function() {
		var userAgent = $.iteratorUserAgentObj($.isIe, $.isMobile, $.isPc);
		var _mouseEvent = {};
		var _mouseKey = ["MOUSEDOWN", "MOUSEMOVE", "MOUSEUP"];
		switch (userAgent) {
			case "isIe":
				var _arr = ["MSPointerDown", "MSPointerMove", "MSPointerUp"];
				break;
			case "isMobile":
				var _arr = ["touchstart", "touchmove", "touchend"];
				break;
			case "isPc":
				var _arr = ["mousedown", "mousemove", "mouseup"];
				break;
		}
		return (function() {
			for (var x in _arr) {
				_mouseEvent[_mouseKey[x]] = _arr[x];
			}
			_mouseEvent.length = parseInt(x);
			return _mouseEvent;
		})();
	},
	compareOptions: function(a, b) {
		var result = (a != null || a != undefined) ? a : b;
		return result;
	},
});
var Event = $.initEvent();
$.resizeWx();