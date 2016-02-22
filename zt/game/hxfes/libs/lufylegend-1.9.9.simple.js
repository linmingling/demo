/**	
* lufylegend	
* @version 1.9.9	
* @Explain lufylegend是一个HTML5开源引擎，利用它可以快速方便的进行HTML5的开发	
* @author lufy(lufy_legend)	
* @blog http://blog.csdn.net/lufy_Legend	
* @email lufy.legend@gmail.com	
* @homepage http://lufylegend.com/lufylegend	
* @github https://github.com/lufylegend/lufylegend.js	
*/	
var OS_PC = "pc",	
OS_IPHONE = "iPhone",	
OS_IPOD = "iPod",	
OS_IPAD = "iPad",	
OS_ANDROID = "Android",	
OS_WINDOWS_PHONE = "Windows Phone",	
OS_BLACK_BERRY = "BlackBerry",	
NONE = "none",	
UNDEFINED = "undefined",	
LANDSCAPE = "landscape",	
PORTRAIT = "portrait",	
mouseX,	
mouseY;	
function LEvent(type){	
	this.eventType = type;	
	this._ll_preventDefault = false;	
}	
LEvent.prototype.preventDefault = function () {	
	this._ll_preventDefault = true;	
};	
LEvent.INIT = "init";	
LEvent.COMPLETE = "complete";	
LEvent.ENTER_FRAME = "enter_frame";	
LEvent.WINDOW_RESIZE = "resize";	
LEvent.SOUND_COMPLETE = "sound_complete";	
LEvent.END_CONTACT = "endContact";	
LEvent.PRE_SOLVE = "preSolve";	
LEvent.POST_SOLVE = "postSolve";	
LEvent.BEGIN_CONTACT = "beginContact";	
LEvent.addEventListener = function (n, t, f, b) {	
	if (b == null) {	
		b = false;	
	}	
	if (n.addEventListener) {	
		n.addEventListener(t, f, b);	
	} else if (n.attachEvent) {	
		n["e" + t + f] = f;	
		n[t + f] = function () {	
			n["e" + t + f]();	
		};	
		n.attachEvent("on" + t, n[t + f]);	
	}	
};	
LEvent.removeEventListener = function (n, t, f, b) {	
	if (b == null) {	
		b = false;	
	}	
	if (n.removeEventListener) {	
		n.removeEventListener(t, f, b);	
	} else if (n.detachEvent) {	
		n["e" + t + f] = f;	
		n[t + f] = function () {	
			n["e" + t + f]();	
		};	
		n.detachEvent("on" + t, n[t + f]);	
	}	
};	
var LMouseEvent = function (){throw "LMouseEvent cannot be instantiated";};	
LMouseEvent.MOUSE_DOWN = "mousedown";	
LMouseEvent.MOUSE_UP = "mouseup";	
LMouseEvent.TOUCH_START = "touchstart";	
LMouseEvent.TOUCH_MOVE = "touchmove";	
LMouseEvent.TOUCH_END = "touchend";	
LMouseEvent.MOUSE_MOVE = "mousemove";	
LMouseEvent.MOUSE_OVER = "mouseover";	
LMouseEvent.MOUSE_OUT = "mouseout";	
LMouseEvent.DOUBLE_CLICK = "dblclick";	
var LMultitouchInputMode = function () {throw "LMultitouchInputMode cannot be instantiated";};	
LMultitouchInputMode.NONE = "none";	
LMultitouchInputMode.GESTURE = "gesture";	
LMultitouchInputMode.TOUCH_POINT = "touchPoint";	
var LMultitouch = function () {throw "LMultitouch cannot be instantiated";};	
LMultitouch.inputMode = "none";	
LMultitouch.touchs = [];	
var LTextEvent = function () {throw "LTextEvent cannot be instantiated";};	
LTextEvent.TEXT_INPUT = "textInput";	
LTextEvent.WIND_COMPLETE = "windComplete";	
var LFocusEvent = function (){throw "LFocusEvent cannot be instantiated";};	
LFocusEvent.FOCUS_IN = "focusIn";	
LFocusEvent.FOCUS_OUT = "focusOut";	
var LMouseEventContainer = (function () {	
	function MouseEventContainer(){	
		var s = this;	
		s.container = {};	
		s.dispatchAllEvent = false;	
		s.mouseDownContainer = [];	
		s.mouseUpContainer = [];	
		s.mouseMoveContainer = [];	
		s.mouseOverContainer = [];	
		s.mouseOutContainer = [];	
		s.mouseDblContainer = [];	
		s.textFieldInputContainer = [];	
		s.buttonContainer = [];	
	};	
	MouseEventContainer.prototype = {	
		pushInputBox : function (d) {	
			var s  = this, c = s.textFieldInputContainer, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (d.objectIndex == c[i].objectIndex) {	
					return;	
				}	
			}	
			s.textFieldInputContainer.push(d);	
		},	
		removeInputBox : function (d) {	
			var s  = this, c = s.textFieldInputContainer, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (d.objectIndex == c[i].objectIndex) {	
					s.textFieldInputContainer.splice(i, 1);	
					break;	
				}	
			}	
		},	
		pushButton : function (d) {	
			var s  = this, c = s.buttonContainer, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (d.objectIndex == c[i].objectIndex) {	
					return;	
				}	
			}	
			s.buttonContainer.push(d);	
		},	
		removeButton : function (d) {	
			var s  = this, c = s.buttonContainer, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (d.objectIndex == c[i].objectIndex) {	
					s.buttonContainer.splice(i, 1);	
					break;	
				}	
			}	
		},	
		dispatchEventButton : function (e) {	
			var s  = this, c = s.buttonContainer, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (typeof s.buttonContainer[i].ll_button_mode == "function") {	
					s.buttonContainer[i].ll_button_mode(e);	
				}	
			}	
		},	
		addEvent : function (o, list, f) {	
			var s = this;	
			list.push({container : o, listener : f});	
		},	
		removeEvent : function (o, list, f) {	
			var s = this, i, l;	
			for (i = 0, l = list.length; i < l; i++) {	
				if (list[i].container.objectIndex === o.objectIndex && (!f || list[i].listener == f)) {	
					list.splice(i, 1);	
					break;	
				}	
			}	
		},	
		addMouseDownEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseDownContainer, f);	
		},	
		addMouseUpEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseUpContainer, f);	
		},	
		addMouseMoveEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseMoveContainer, f);	
		},	
		addMouseOverEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseOverContainer, f);	
		},	
		addMouseOutEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseOutContainer, f);	
		},	
		addMouseDblEvent : function (o, f) {	
			var s = this;	
			s.addEvent(o, s.mouseDblContainer, f);	
		},	
		addMouseEvent : function (o, t, f) {	
			var s = this;	
			if (t == LMouseEvent.MOUSE_DOWN) {	
				s.addMouseDownEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_UP) {	
				s.addMouseUpEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_OVER) {	
				s.addMouseOverEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_OUT) {	
				s.addMouseOutEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_MOVE) {	
				s.addMouseMoveEvent(o, f);	
			} else {	
				s.addMouseDblEvent(o, f);	
			}	
		},	
		hasEvent : function (o, list) {	
			for (var i = 0, l = list.length; i < l; i++) {	
				if (list[i].container.objectIndex === o.objectIndex) {	
					return true;	
				}	
			}	
			return false;	
		},	
		removeMouseDownEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseDownContainer, f);	
		},	
		removeMouseUpEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseUpContainer, f);	
		},	
		removeMouseMoveEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseMoveContainer, f);	
		},	
		removeMouseOverEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseOverContainer, f);	
		},	
		removeMouseOutEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseOutContainer, f);	
		},	
		removeMouseDblEvent : function (o, f) {	
			var s = this;	
			s.removeEvent(o, s.mouseDblContainer, f);	
		},	
		removeMouseEvent : function (o, t, f) {	
			var s = this;	
			if (t == LMouseEvent.MOUSE_DOWN) {	
				s.removeMouseDownEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_UP) {	
				s.removeMouseUpEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_OVER) {	
				s.removeMouseOverEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_OUT) {	
				s.removeMouseOutEvent(o, f);	
			} else if (t == LMouseEvent.MOUSE_MOVE) {	
				s.removeMouseMoveEvent(o, f);	
			} else {	
				s.removeMouseDblEvent(o, f);	
			}	
		},	
		dispatchMouseEvent : function (event, type) {	
			var s = this;	
			if (type == LMouseEvent.MOUSE_DOWN) {	
				s.dispatchEvent(event, s.mouseDownContainer, LMouseEvent.MOUSE_DOWN);	
				s.dispatchEvent(event, s.textFieldInputContainer);	
			} else if (type == LMouseEvent.MOUSE_UP) {	
				s.dispatchEvent(event, s.mouseUpContainer, LMouseEvent.MOUSE_UP);	
			} else if (type == LMouseEvent.DOUBLE_CLICK) {	
				s.dispatchEvent(event, s.mouseDblContainer, LMouseEvent.DOUBLE_CLICK);	
			} else {	
				s.dispatchEventButton(event);	
				s.dispatchEvent(event, s.mouseOutContainer, LMouseEvent.MOUSE_OUT);	
				s.dispatchEvent(event, s.mouseOverContainer, LMouseEvent.MOUSE_OVER);	
				s.dispatchEvent(event, s.mouseMoveContainer, LMouseEvent.MOUSE_MOVE);	
			}	
		},	
		getRootParams : function (s) {	
			var p = s.parent, r = {x : 0, y : 0, scaleX : 1, scaleY : 1};	
			while (p && p != "root") {	
				r.x *= p.scaleX;	
				r.y *= p.scaleY;	
				r.x += p.x;	
				r.y += p.y;	
				r.scaleX *= p.scaleX;	
				r.scaleY *= p.scaleY;	
				p = p.parent;	
			}	
			return r;	
		},	
		_mouseEnabled : function (sp) {	
			var self = this;	
			if (!sp || !sp.parent) {	
				return false;	
			}	
			if (!sp.visible || (typeof sp.mouseEnabled != UNDEFINED && !sp.mouseEnabled)) {	
				return false;	
			}	
			var p = sp.parent;	
			while (p && p != "root") {	
				if (!p.mouseEnabled || !p.mouseChildren || !p.visible) {	
					return false;	
				}	
				p = p.parent;	
				if (!p) {	
					return false;	
				}	
			}	
			return true;	
		},	
		_dispatchEvent : function(event, type, st, index, fromIndex, endIndex) {	
			var self = this, i, j, l = st.length;	
			for (i = fromIndex; i <= endIndex && i < l; i++) {	
				o = st[i];	
				if (o.sp.objectIndex != index) {	
					continue;	
				}	
				event.currentTarget = event.clickTarget = o.sp;	
				if (!event.target) {	
					event.target = o.sp;	
				}	
				event.event_type = type;	
				event.selfX = (event.offsetX - o.co.x - o.sp.x) / (o.co.scaleX * o.sp.scaleX);	
				event.selfY = (event.offsetY - o.co.y - o.sp.y) / (o.co.scaleY * o.sp.scaleY);	
				o.listener(event, o.sp);	
			}	
		},	
		dispatchEvent : function (event, list, type) {	
			var self = this, sp, co, st = [], o, i, l;	
			for (i = 0, l = list.length; i < l; i++) {	
				sp = list[i].container || list[i];	
				if (!self._mouseEnabled(sp)) {	
					continue;	
				}	
				co = self.getRootParams(sp);	
				if (!type && sp.mouseEvent) {	
					sp.mouseEvent(event, LMouseEvent.MOUSE_DOWN, co);	
					continue;	
				}	
				if (sp.ismouseon(event, co)) {	
					if (type == LMouseEvent.MOUSE_OUT) {	
						continue;	
					}	
					if (type == LMouseEvent.MOUSE_OVER) {	
						if (sp.ll_mousein) {	
							continue;	
						}	
					}	
					if (type != LMouseEvent.MOUSE_UP) {	
						sp.ll_mousein = true;	
					}	
					st.push({sp : sp, co : co, listener : list[i].listener});	
				} else {	
					if (type != LMouseEvent.MOUSE_OUT && type != LMouseEvent.MOUSE_OVER) {	
						continue;	
					}	
					if (!sp.ll_mousein) {	
						continue;	
					}	
					sp.ll_mousein = false;	
					st.push({sp : sp, co : co, listener : list[i].listener});	
				}	
			}	
			if (st.length == 0) {	
				return;	
			}	
			if (st.length > 1) {	
				st = st.sort(self._sort.bind(self));	
			}	
			l = st.length;	
			for (i = 0; i < l; i++) {	
				o = st[i];	
				self._dispatchEvent(event, type, st, o.sp.objectIndex, i, self.dispatchAllEvent ? l - 1 : i);	
				if (i < st.length - 1 && o.sp.objectIndex == st[i+1].sp.objectIndex){	
					st.splice(i, 1);	
					i--;	
					continue;	
				}	
				var p;	
				while (true) {	
					if (!p) {	
						p = o.sp.parent;	
						event.target = o.sp;	
					}	
					if (!p || p == "root") {	
						break;	
					}	
					self._dispatchEvent(event, type, st, p.objectIndex, i + 1, l);	
					event.target = p;	
					p = p.parent;	
					if (!p || p == "root") {	
						break;	
					}	
				}	
				if (!self.dispatchAllEvent) {	
					break;	
				} else {	
					continue;	
				}	
			}	
		},	
		set : function (t, v) {	
			this.container[t] = v;	
		},	
		_sort : function (a, b) {	
			var s = this, o1, o2, al = s._getSort(a.sp), bl = s._getSort(b.sp), i, l1, l2;	
			for (i = 0, l1 = al.length, l2 = bl.length; i < l1 && i < l2; i++) {	
				o1 = al[i];	
				o2 = bl[i];	
				if (o1.objectIndex == o2.objectIndex) {	
					continue;	
				}	
				return o2.parent.getChildIndex(o2) - o1.parent.getChildIndex(o1);	
			}	
			return bl.length - al.length;	
		},	
		_getSort : function (layer) {	
			var p = layer.parent, list = [layer];	
			while (p && p != "root") {	
				list.unshift(p);	
				p = p.parent;	
			}	
			return list;	
		}	
	};	
	return new MouseEventContainer();	
})();	
var LKeyboardEvent = function () {throw "LKeyboardEvent cannot be instantiated";};	
LKeyboardEvent.KEY_DOWN = "keydown";	
LKeyboardEvent.KEY_UP = "keyup";	
LKeyboardEvent.KEY_PRESS = "keypress";	
var LAccelerometerEvent = function (){throw "LAccelerometerEvent cannot be instantiated";};	
LAccelerometerEvent.DEVICEMOTION = "devicemotion";	
function LStageAlign(){throw "LStageAlign cannot be instantiated";}	
LStageAlign.TOP = "T";	
LStageAlign.BOTTOM = "B";	
LStageAlign.LEFT = "L";	
LStageAlign.RIGHT = "Re";	
LStageAlign.TOP_LEFT = "TL";	
LStageAlign.TOP_RIGHT = "TR";	
LStageAlign.TOP_MIDDLE = "TM";	
LStageAlign.BOTTOM_LEFT = "BL";	
LStageAlign.BOTTOM_RIGHT = "BR";	
LStageAlign.BOTTOM_MIDDLE = "BM";	
LStageAlign.MIDDLE = "M";	
function LStageScaleMode () {throw "LStageScaleMode cannot be instantiated";}	
LStageScaleMode.EXACT_FIT = "exactFit";	
LStageScaleMode.SHOW_ALL = "showAll";	
LStageScaleMode.NO_BORDER = "noBorder";	
LStageScaleMode.NO_SCALE = "noScale";	
var LGlobal = ( function () {	
	function LGlobal () {	
		throw "LGlobal cannot be instantiated";	
	}	
	LGlobal.FULL_SCREEN = "full_screen";	
	LGlobal.traceDebug = false;	
	LGlobal.displayState = NONE;	
	LGlobal.aspectRatio = NONE;	
	LGlobal.canvasObj = null;	
	LGlobal.canvas = null;	
	LGlobal.webAudio = true;	
	LGlobal.objectIndex = 1;	
	LGlobal.stage = null;	
	LGlobal.width = 0;	
	LGlobal.height = 0;	
	LGlobal.box2d = null;	
	LGlobal.speed = 50;	
	LGlobal.IS_MOUSE_DOWN = false;	
	LGlobal.stopPropagation = false;	
	LGlobal.preventDefault = true;	
	LGlobal.childList = new Array();	
	LGlobal.dragList = new Array();	
	LGlobal.excludingContainer = new Array();	
	LGlobal.fpsStatus = null;	
	LGlobal.stageScale = "noScale";	
	LGlobal.align = "M";	
	LGlobal.mobile = false;	
	LGlobal.canTouch = false;	
	LGlobal.os = OS_PC;	
	LGlobal.ios = false;	
	LGlobal.android = false;	
	LGlobal.android_new = false;	
	LGlobal.backgroundColor = null;	
	LGlobal.destroy = true;	
	LGlobal.forceRefresh = false;	
	LGlobal.devicePixelRatio = window.devicePixelRatio || 1;	
	LGlobal.startTimer = 0;	
	LGlobal.keepClear = true;	
	LGlobal.top = 0;	
	LGlobal.left = 0;	
	LGlobal.window = window;	
	(function (n) {	
		LGlobal.isFirefox = (n.toLowerCase().indexOf('firefox') >= 0);	
		if (n.indexOf(OS_IPHONE) > 0) {	
			LGlobal.os = OS_IPHONE;	
			LGlobal.canTouch = true;	
			LGlobal.ios = true;	
		} else if (n.indexOf(OS_IPOD) > 0) {	
			LGlobal.os = OS_IPOD;	
			LGlobal.canTouch = true;	
			LGlobal.ios = true;	
		} else if (n.indexOf(OS_IPAD) > 0) {	
			LGlobal.os = OS_IPAD;	
			LGlobal.ios = true;	
			LGlobal.canTouch = true;	
		} else if (n.indexOf(OS_ANDROID) > 0) {	
			LGlobal.os = OS_ANDROID;	
			LGlobal.canTouch = true;	
			LGlobal.android = true;	
			var i = n.indexOf(OS_ANDROID);	
			if(parseInt(n.substr(i + 8, 1)) > 3){	
				LGlobal.android_new = true;	
			}	
		} else if (n.indexOf(OS_WINDOWS_PHONE) > 0) {	
			LGlobal.os = OS_WINDOWS_PHONE;	
			LGlobal.canTouch = true;	
		} else if (n.indexOf(OS_BLACK_BERRY) > 0) {	
			LGlobal.os = OS_BLACK_BERRY;	
			LGlobal.canTouch = true;	
		}	
		LGlobal.mobile = LGlobal.canTouch;	
	})(navigator.userAgent);	
	LGlobal.setDebug = function (v) {	
		LGlobal.traceDebug = v; 	
	};	
	LGlobal.setCanvas = function (id, w, h) {	
		LGlobal.ll_createCanvas(id, w, h);	
		LGlobal.ll_createStage();	
		if(LGlobal.displayState == LStage.FULL_SCREEN){	
			LGlobal.resize();	
		}else if(typeof LGlobal.displayState == "number"){	
			LGlobal.resize(LGlobal.width * LGlobal.displayState, LGlobal.height * LGlobal.displayState);	
		}	
		if (LGlobal.canTouch) {	
			LGlobal.ll_clicks = 0;	
			LGlobal.ll_prev_clickTime = 0;	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.TOUCH_START, LGlobal.ll_touchStart);	
			LEvent.addEventListener(document, LMouseEvent.TOUCH_END, LGlobal.ll_touchEnd);	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.TOUCH_MOVE, LGlobal.ll_touchMove);	
		} else {	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.DOUBLE_CLICK, LGlobal.ll_mouseDbclick);	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.MOUSE_DOWN, LGlobal.ll_mouseDown);	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.MOUSE_MOVE, LGlobal.ll_mouseMove);	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.MOUSE_UP, LGlobal.ll_mouseUp);	
			LEvent.addEventListener(LGlobal.canvasObj,LMouseEvent.MOUSE_OUT, LGlobal.ll_mouseOut);	
		}	
	};	
	LGlobal.ll_createCanvas = function (id, w, h) {	
		LGlobal.id = id;	
		LGlobal.object = document.getElementById(id);	
		LGlobal.object.innerHTML = '<div style="position:absolute;margin:0;padding:0;overflow:visible;-webkit-transform: translateZ(0);z-index:0;">' +	
		'<canvas id="' + LGlobal.id + '_canvas" style="margin:0;padding:0;width:' + w + 'px;height:' + h + 'px;">' +	
		'<div id="noCanvas">' +	
		"<p>Hey there, it looks like you're using Microsoft's Internet Explorer. Microsoft hates the Web and doesn't support HTML5 :(</p>" + 	
		'</div>' +  	
		'</canvas></div>' +	
		'<div id="' + LGlobal.id + '_InputText" style="position:absolute;margin:0;padding:0;z-index:10;display:none;">' +	
		'<textarea rows="1" id="' + LGlobal.id + '_InputTextareaBox" style="resize:none;background:transparent;border:0px;"></textarea>' +	
		'<input type="text" id="' + LGlobal.id + '_InputTextBox"  style="background:transparent;border:0px;" />' +	
		'<input type="password" id="' + LGlobal.id + '_passwordBox"  style="background:transparent;border:0px;" /></div>';	
		LGlobal.canvasObj = document.getElementById(LGlobal.id + "_canvas");	
		LGlobal._canvas = document.createElement("canvas");	
		LGlobal._context = LGlobal._canvas.getContext("2d");	
		if (LGlobal._context) {	
			LGlobal.canvasObj.innerHTML="";	
		}	
		LGlobal.inputBox = document.getElementById(LGlobal.id + '_InputText');	
		LGlobal.inputTextareaBoxObj = document.getElementById(LGlobal.id + '_InputTextareaBox');	
		LGlobal.inputTextBoxObj = document.getElementById(LGlobal.id + '_InputTextBox');	
		LGlobal.passwordBoxObj = document.getElementById(LGlobal.id + '_passwordBox');	
		LGlobal.inputTextField = null;	
		if (w) {	
			LGlobal.canvasObj.width = w;	
		}	
		if (h) {	
			LGlobal.canvasObj.height = h;	
		}	
		LGlobal.width = LGlobal.canvasObj.width;	
		LGlobal.height = LGlobal.canvasObj.height;	
		LGlobal.canvasStyleWidth = LGlobal.width;	
		LGlobal.canvasStyleHeight = LGlobal.height;	
		LGlobal.canvas = LGlobal.canvasObj.getContext("2d");	
		LGlobal.offsetX = mouseX = 0;	
		LGlobal.offsetY = mouseY = 0;	
	};	
	LGlobal.ll_createStage = function () {	
		LGlobal.stage = new LSprite();	
		LGlobal.stage.parent = "root";	
		LGlobal.childList.push(LGlobal.stage);	
		LGlobal.stage.baseAddEvent = LGlobal.stage.addEventListener;	
		LGlobal.stage.baseRemoveEvent = LGlobal.stage.removeEventListener;	
		LGlobal.stage.addEventListener = function (type, listener) {	
			if (type == LEvent.WINDOW_RESIZE) {	
				LGlobal.stage.onresizeListener = listener;	
				LGlobal.stage.onresize = function (e) {	
					LGlobal.stage.onresizeEvent = e;	
				};	
				LEvent.addEventListener(LGlobal.window, type,LGlobal.stage.onresize);	
			} else if (type == LKeyboardEvent.KEY_DOWN || type == LKeyboardEvent.KEY_UP || type == LKeyboardEvent.KEY_PRESS) {	
				LEvent.addEventListener(LGlobal.window, type, listener);	
			} else {	
				LGlobal.stage.baseAddEvent(type, listener);	
			}	
		};	
		LGlobal.stage.removeEventListener = function (type, listener) {	
			if (type == LEvent.WINDOW_RESIZE) {	
				LEvent.removeEventListener(LGlobal.window, LEvent.WINDOW_RESIZE, LGlobal.stage.onresize);	
				delete LGlobal.stage.onresize;	
				delete LGlobal.stage.onresizeListener;	
			} else if (type == LKeyboardEvent.KEY_DOWN || type == LKeyboardEvent.KEY_UP || type == LKeyboardEvent.KEY_PRESS) {	
				LEvent.removeEventListener(LGlobal.window, type, listener);	
			} else {	
				LGlobal.stage.baseRemoveEvent(type, listener);	
			}	
		};	
	};	
	LGlobal.ll_touchStart = function (event) {	
		if (LGlobal.inputBox.style.display != NONE) {	
			LGlobal.inputTextField._ll_getValue();	
		}	
		var canvasX, canvasY, eve, k, i;	
		canvasX = parseInt(0 + LGlobal.object.style.left) + parseInt(LGlobal.canvasObj.style.marginLeft);	
		canvasY = parseInt(0 + LGlobal.object.style.top) + parseInt(LGlobal.canvasObj.style.marginTop);	
		if (LMultitouch.inputMode == LMultitouchInputMode.NONE) {	
			eve = LGlobal.ll_touchStartEvent(event, 0, canvasX, canvasY);	
		} else if (LMultitouch.inputMode == LMultitouchInputMode.TOUCH_POINT) {	
			for (var i = 0,l = event.touches.length; i < l; i++) {	
				if(!LMultitouch.touchs["touch" + event.touches[i].identifier]){	
					eve = LGlobal.ll_touchStartEvent(event, i, canvasX, canvasY);	
				}	
			}	
		}	
		var date = new Date();	
		var clickTime = date.getTime();	
		LGlobal.ll_clicks = (clickTime <= (LGlobal.ll_prev_clickTime + 500)) ? (LGlobal.ll_clicks + 1) : 1;	
		LGlobal.ll_prev_clickTime = clickTime;	
		if (LGlobal.ll_clicks === 2) {	
			LGlobal.mouseEvent(eve, LMouseEvent.DOUBLE_CLICK);	
			LGlobal.ll_clicks = 0;	
		}	
		LGlobal.IS_MOUSE_DOWN = true;	
		if (LGlobal.mouseJoint_start) {	
			LGlobal.mouseJoint_start(eve);	
		}	
		LGlobal.touchHandler(event);	
	};	
	LGlobal.ll_touchStartEvent = function (event,eveIndex,canvasX,canvasY) {	
		var eve = {offsetX : (event.touches[eveIndex].pageX - canvasX),	
		offsetY : (event.touches[eveIndex].pageY - canvasY),	
		touchPointID : event.touches[eveIndex].identifier};	
		eve.offsetX = LGlobal.ll_scaleX(eve.offsetX);	
		eve.offsetY = LGlobal.ll_scaleY(eve.offsetY);	
		mouseX = LGlobal.offsetX = eve.offsetX;	
		mouseY = LGlobal.offsetY = eve.offsetY;	
		LMultitouch.touchs["touch" + eve.touchPointID] = eve;	
		LGlobal.mouseEvent(eve, LMouseEvent.MOUSE_DOWN);	
		LGlobal.buttonStatusEvent = eve;	
		return eve;	
	};	
	LGlobal.ll_touchEnd = function (event) {	
		var e, eve, k, i, l, h;	
		if (LMultitouch.inputMode == LMultitouchInputMode.TOUCH_POINT) {	
			for (k in LMultitouch.touchs) {	
				e = LMultitouch.touchs[k];	
				h = false;	
				for (i = 0,l = event.touches.length; i < l; i++) {	
					if (event.touches[i].identifier == e.touchPointID) {	
						h = true;	
						break;	
					}	
				}	
				if (!h) {	
					eve = e;	
					delete LMultitouch.touchs[k];	
					LGlobal.mouseEvent(eve, LMouseEvent.MOUSE_UP);	
				}	
			}	
		}	
		if (!eve) {	
			eve = {offsetX : LGlobal.offsetX, offsetY : LGlobal.offsetY};	
		}	
		LGlobal.mouseEvent(eve, LMouseEvent.MOUSE_UP);	
		LGlobal.touchHandler(event);	
		LGlobal.IS_MOUSE_DOWN = false;	
		LGlobal.buttonStatusEvent = null;	
		if (LGlobal.mouseJoint_end) {	
			LGlobal.mouseJoint_end();	
		}	
	};	
	LGlobal.ll_touchMove = function (e) {	
		var cX, cY, eve, l, ll = e.touches.length;	
		cX = parseInt(0 + LGlobal.object.style.left) + parseInt(LGlobal.canvasObj.style.marginLeft);	
		cY = parseInt(0 + LGlobal.object.style.top) + parseInt(LGlobal.canvasObj.style.marginTop);	
		if (LMultitouch.inputMode == LMultitouchInputMode.NONE) {	
			ll = 1;	
		}	
		for (i = 0, l = e.touches.length; i < l && i < ll; i++) {	
			eve = {offsetX : (e.touches[i].pageX - cX), offsetY : (e.touches[i].pageY - cY), touchPointID : e.touches[i].identifier};	
			eve.offsetX = LGlobal.ll_scaleX(eve.offsetX);	
			eve.offsetY = LGlobal.ll_scaleY(eve.offsetY);	
			mouseX = LGlobal.offsetX = eve.offsetX;	
			mouseY = LGlobal.offsetY = eve.offsetY;	
			if (LMultitouch.touchs["touch" + eve.touchPointID] && 	
				LMultitouch.touchs["touch" + eve.touchPointID].offsetX == eve.offsetX && 	
				LMultitouch.touchs["touch" + eve.touchPointID].offsetY == eve.offsetY){	
				continue;		
			}	
			LGlobal.buttonStatusEvent = eve;	
			LMultitouch.touchs["touch" + eve.touchPointID] = eve;	
			LGlobal.mouseEvent(eve, LMouseEvent.MOUSE_MOVE);	
		}	
		LGlobal.touchHandler(e);	
		if (LGlobal.mouseJoint_move) {	
			LGlobal.mouseJoint_move(eve);	
		}	
	};	
	LGlobal.ll_mouseDbclick = function (e) {	
		if (e.offsetX == null && e.layerX != null) {	
			e.offsetX = e.layerX;	
			e.offsetY = e.layerY;	
		}	
		var event = {button : e.button};	
		event.offsetX = LGlobal.ll_scaleX(e.offsetX);	
		event.offsetY = LGlobal.ll_scaleY(e.offsetY);	
		LGlobal.mouseEvent(event, LMouseEvent.DOUBLE_CLICK);	
	};	
	LGlobal.ll_mouseDown = function (e) {	
		if (e.offsetX == null && e.layerX != null) {	
			e.offsetX = e.layerX;	
			e.offsetY = e.layerY;	
		}	
		if (LGlobal.inputBox.style.display != NONE) {	
			LGlobal.inputTextField._ll_getValue();	
		}	
		var event = {button : e.button};	
		event.offsetX = LGlobal.ll_scaleX(e.offsetX);	
		event.offsetY = LGlobal.ll_scaleY(e.offsetY);	
		LGlobal.mouseEvent(event, LMouseEvent.MOUSE_DOWN);	
		LGlobal.IS_MOUSE_DOWN = true;	
		if (LGlobal.mouseJoint_start) {	
			LGlobal.mouseJoint_start(event);	
		}	
	};	
	LGlobal.ll_mouseMove = function (e) {	
		if (e.offsetX == null && e.layerX != null) {	
			e.offsetX = e.layerX;	
			e.offsetY = e.layerY;	
		}	
		var event = {};	
		event.offsetX = LGlobal.ll_scaleX(e.offsetX);	
		event.offsetY = LGlobal.ll_scaleY(e.offsetY);	
		LGlobal.buttonStatusEvent = event;	
		mouseX = LGlobal.offsetX = event.offsetX;	
		mouseY = LGlobal.offsetY = event.offsetY;	
		LGlobal.cursor = "default";	
		LGlobal.mouseEvent(event, LMouseEvent.MOUSE_MOVE);	
		document.body.style.cursor = LGlobal.cursor;	
		if (LGlobal.mouseJoint_move) {	
			LGlobal.mouseJoint_move(event);	
		}	
	};	
	LGlobal.ll_mouseUp = function (e) {	
		if (e.offsetX == null && e.layerX != null) {	
			e.offsetX = e.layerX;	
			e.offsetY = e.layerY;	
		}	
		var event = {button : e.button};	
		event.offsetX = LGlobal.ll_scaleX(e.offsetX);	
		event.offsetY = LGlobal.ll_scaleY(e.offsetY);	
		LGlobal.mouseEvent(event, LMouseEvent.MOUSE_UP);	
		LGlobal.IS_MOUSE_DOWN = false;	
		if (LGlobal.mouseJoint_end) {	
			LGlobal.mouseJoint_end();	
		}	
	};	
	LGlobal.ll_mouseOut = function (e) {	
		if (e.offsetX == null && e.layerX != null) {	
			e.offsetX = e.layerX;	
			e.offsetY = e.layerY;	
		}	
		var event = {};	
		event.offsetX = LGlobal.ll_scaleX(e.offsetX);	
		event.offsetY = LGlobal.ll_scaleY(e.offsetY);	
		LGlobal.mouseEvent(event, LMouseEvent.MOUSE_OUT);	
		LGlobal.IS_MOUSE_DOWN = false;	
	};	
	LGlobal.touchHandler = function (e) {	
		if (LGlobal.stopPropagation) {	
			e.stopPropagation();	
		}	
		if (LGlobal.preventDefault) {	
			e.preventDefault();	
		}	
		if (e.stopImmediatePropagation) {	
			e.stopImmediatePropagation();	
		}	
		return e;	
	};	
	LGlobal.mouseEvent = function (e, t) {	
		if (t == LMouseEvent.MOUSE_MOVE) {	
			LGlobal.dragHandler(e);	
		}	
		if (LMouseEventContainer.container[t]) {	
			LMouseEventContainer.dispatchMouseEvent(e, t);	
			return;	
		}	
		for (var k = LGlobal.childList.length - 1; k >= 0; k--) {	
			if (LGlobal.childList[k].mouseEvent && LGlobal.childList[k].mouseEvent(e, t)) {	
				break;	
			}	
		}	
	};	
	LGlobal.dragHandler = function (e) {	
		var i, s, c, d = LGlobal.dragList;	
		for(i = d.length - 1; i >= 0; i--) {	
			s = d[i];	
			if (LGlobal.canTouch && s.ll_touchPointID != e.touchPointID) {	
				continue;	
			}	
			c = s.getAbsoluteScale();	
			s.x = s.ll_dragStartX + (e.offsetX - s.ll_dragMX) * s.scaleX / c.scaleX;	
			s.y = s.ll_dragStartY + (e.offsetY - s.ll_dragMY) * s.scaleY / c.scaleY;	
			if (s.dragRange) {	
				if (s.x < s.dragRange.left) {	
					s.x = s.dragRange.left;	
				} else if(s.x > s.dragRange.right){	
					s.x = s.dragRange.right;	
				}	
				if (s.y < s.dragRange.top) {	
					s.y = s.dragRange.top;	
				} else if(s.y > s.dragRange.bottom){	
					s.y = s.dragRange.bottom;	
				}	
			}	
			break;	
		}	
	};	
	LGlobal._ll_mobile = function () {	
		var w1 = LGlobal.width * 0.3, h1 = w1 * 1.5, s = LGlobal.width * 0.05, ss = w1 * 0.05, sm = w1 * 0.15, 	
		sx = w1 * 0.3, sh = h1 * 0.20, c = '#cccccc', d = '#000000', f = '#ffffff', h = '#ff0000', b, w1, h1, m, m1, n, v;	
		b = new LSprite();	
		addChild(b);	
		w1 = LGlobal.width * 0.3, h1 = w1 * 1.5;	
		b.graphics.drawRoundRect(1, d, [s, s, w1, h1, s],true,c);	
		b.graphics.drawRoundRect(1, d, [s + ss, s + ss, w1 - ss * 2, h1 - ss * 2, s], true, d);	
		b.graphics.drawRect(1, f, [s + sm, s + sh, w1 - sm * 2, h1 - sh * 2], true, f);	
		b.graphics.drawArc(1, f, [s + w1 * 0.5, s + h1 - ss * 3.5, ss * 1.5, 0, 2 * Math.PI]);	
		b.graphics.drawRoundRect(1, f, [s + sx, s + sm, w1 - sx * 2, ss, ss * 0.5]);	
		m = new LSprite();	
		m.x = -(w1 - sm * 2) * 0.5;	
		m.y = -ss * 0.5;	
		m.graphics.drawRect(1, h, [0, 0, w1 - sm * 2, ss], true, h);	
		m1 = new LSprite();	
		m1.y = -(w1 - sm * 2) * 0.5;	
		m1.x = -ss * 0.5;	
		m1.graphics.drawRect(1, h, [0, 0, ss, w1 - sm * 2], true, h);	
		n = new LSprite();	
		n.x = s + sx + (w1 - sx * 2) * 0.5;	
		n.y = s + sh + (h1 - sh * 2) * 0.5;	
		n.rotate = 45;	
		n.addChild(m);	
		n.addChild(m1);	
		b.addChild(n);	
		v = new LSprite();	
		v.graphics.drawVertices(2, d, [[0, 0], [sm, sm ], [0, sm * 2]], true, c);	
		v.x = s * 1.5 + h1;	
		v.y = s * 1.5 + h1 * 0.5;	
		addChild(v);	
		b.arrow = v;	
		var fn = function () {	
			setTimeout(function () {	
				location.href = location.href;	
			}, 100);	
		};	
		window.onorientationchange = fn;	
		return b;	
	};	
	LGlobal.verticalError = function () {	
		var w1 = LGlobal.width * 0.3, s = LGlobal.width * 0.05;	
		var b = LGlobal._ll_mobile();	
		var d = b.clone();	
		d.getChildAt(0).visible = false;	
		d.x = LGlobal.width * 0.5 + s;	
		addChild(d);	
		b.rotate = 90;	
		b.x = LGlobal.width * 0.5 + s;	
		b.y = w1 * 0.5;	
	};	
	LGlobal.horizontalError = function () {	
		var w1 = LGlobal.width * 0.3, s = LGlobal.width * 0.05;	
		var b = LGlobal._ll_mobile();	
		var d = b.clone();	
		d.getChildAt(0).visible = false;	
		d.rotate = 90;	
		d.x = LGlobal.width - s;	
		d.y = w1 * 0.5;	
		addChild(d);	
		b.arrow.x = s * 1.5 + w1;	
	};	
	LGlobal.onShow = function () {	
		if (LGlobal.canvas == null) {	
			return;	
		}	
		if (LGlobal.fpsStatus) {	
			LGlobal.fpsStatus.reset();	
		}	
		if (LGlobal.stage.onresizeEvent) {	
			LGlobal.stage.onresizeListener(LGlobal.stage.onresizeEvent);	
			delete LGlobal.stage.onresizeEvent;	
		}	
		if (LGlobal.forceRefresh) {	
			LGlobal.canvasObj.width = LGlobal.canvasObj.width;	
			LGlobal.forceRefresh = false;	
		}	
		LGlobal.canvas.beginPath();	
		if (LGlobal.box2d != null) {	
			LGlobal.box2d.ll_show();	
			if (!LGlobal.traceDebug && LGlobal.keepClear) {	
				LGlobal.canvas.clearRect(0, 0, LGlobal.width + 1, LGlobal.height + 1);	
			}	
		} else {	
			if (LGlobal.keepClear) {	
				LGlobal.canvas.clearRect(0, 0, LGlobal.width + 1, LGlobal.height + 1);	
			}	
			if (LGlobal.backgroundColor !== null) {	
				LGlobal.canvas.fillStyle = LGlobal.backgroundColor;	
				LGlobal.canvas.fillRect(0, 0, LGlobal.width, LGlobal.height);	
			}	
		}	
		LGlobal.show(LGlobal.childList);	
	};	
	LGlobal.show = function (s) {	
		for (var i = 0, l = s.length, c; i < l; i++) {	
			c = s[i];	
			if (c && c.ll_show) {	
				c.ll_show();	
				if(c._ll_removeFromSelf){	
					i--;	
					l--;	
				}	
			}	
		}	
	};	
	LGlobal.divideCoordinate = function (w, h, row, col) {	
		var i, j, cw = w / col, ch = h / row, r = [], c;	
		for (i = 0; i < row; i++) {	
			c = [];	
			for (j = 0; j < col; j++) {	
				c.push({x : cw * j, y : ch * i, width : cw, height : ch});	
			}	
			r.push(c);	
		}	
		return r;	
	};	
	LGlobal._create_loading_color = function () {	
		var co = LGlobal.canvas.createRadialGradient(LGlobal.width / 2, LGlobal.height, 0, LGlobal.width / 2, 0, LGlobal.height);  	
		co.addColorStop(0, "red");  	
		co.addColorStop(0.3, "orange");  	
		co.addColorStop(0.4, "yellow");  	
		co.addColorStop(0.5, "green");  	
		co.addColorStop(0.8, "blue");  	
		co.addColorStop(1, "violet");  	
		return co;	
	};	
	LGlobal.hitPolygon = function (list, x, y) {	
		var c = 0, p0 = list[0], b0x = (x <= p0[0]), b0y = (y <= p0[1]), i, l, p1, b1x, b1y;	
		for (i = 1, l = list.length; i < l + 1; i++) {	
			p1 = list[i % l];	
			b1x = (x <= p1[0]);	
			b1y = (y <= p1[1]);	
			if (b0y != b1y) {	
				if (b0x == b1x) {	
					if (b0x) {	
						c += (b0y ? -1 : 1);	
					}	
				} else {	
					if (x <= (p0[0] + (p1[0] - p0[0]) * (y - p0[1] ) / (p1[1] - p0[1]))) {	
						c += (b0y ? -1 : 1);	
					}	
				}	
			}	
			p0 = p1;	
			b0x = b1x;	
			b0y = b1y;	
		}	
		return 0 != c;	
	};	
	LGlobal.hitTestPolygon = function (p1, p2) {	
		var i, j, l, listA, normals, vecs, list = [[p1, [], []], [p2, [], []]];	
		for (j = 0; j < list.length; j++) {	
			listA = list[j][0], normals = list[j][1];	
			for (i = 0, l = listA.length; i < l; i++) {	
				list[j][2].push(new LVec2(listA[i][0], listA[i][1]));	
				if (i < l - 1) {	
					normals.push((new LVec2(listA[i + 1][0] - listA[i][0], listA[i + 1][1] - listA[i][1])).normL());	
				}	
			}	
			normals.push((new LVec2(listA[0][0] - listA[l - 1][0], listA[0][1] - listA[l - 1][1])).normL());	
		}	
		for (j = 0; j < list.length; j++) {	
			normals = list[j][1];	
			for (i = 0, l = normals.length; i < l; i++) {	
				var r1 = LVec2.getMinMax(list[0][2], normals[i]);	
				var r2 = LVec2.getMinMax(list[1][2], normals[i]);	
				if (r1.max_o < r2.min_o || r1.min_o > r2.max_o) {	
					return false;	
				}	
			}	
		}	
		return true;	
	};	
	LGlobal.hitTestPolygonArc = function (vs, arc) {	
		if (LGlobal.hitPolygon(vs, arc[0], arc[1])) {	
			return true;	
		}	
		var i, j, l, p1, p2, v1, v2, ext, inn, l2;	
		for (i = 0, l = vs.length; i < l; i++) {	
			j = i < l - 1 ? i + 1 : 0;	
			p1 = vs[i], p2 = vs[j];	
			v1 = new LVec2(arc[0] - p1[0], arc[1] - p1[1]), v2 = new LVec2(p2[0] - p1[0], p2[1] - p1[1]);	
			l2 = v2.normalize();	
			inn = LVec2.dot(v1, l2);	
			if (inn <= 0) {	
				if (v1.x * v1.x + v1.y * v1.y < arc[3]) {	
					return true;	
				}	
			} else if (inn * inn < v2.x * v2.x + v2.y * v2.y) {	
				ext = LVec2.cross(v1, l2);	
				if (ext * ext < arc[3]) {	
					return true;	
				}	
			}	
		}	
		return false;	
	};	
	LGlobal.hitTestArc = function (objA, objB, objAR, objBR) {	
		var rA = objA.getWidth() * 0.5	
		,rB = objB.getWidth() * 0.5	
		,xA = objA._startX ? objA._startX() : objA.startX()	
		,xB = objB._startX ? objB._startX() : objB.startX()	
		,yA = objA._startY ? objA._startY() : objA.startY()	
		,yB = objB._startY ? objB._startY() : objB.startY();	
		if (typeof objAR != UNDEFINED) {	
			xA += (rA - objAR);	
			yA += (rA - objAR);	
			rA = objAR;	
		}	
		if (typeof objBR != UNDEFINED) {	
			xB += (rB - objBR);	
			yB += (rB - objBR);	
			rB = objBR;	
		}	
		var disx = xA + rA - xB - rB	
		,disy = yA + rA - yB - rB;	
		return disx * disx + disy * disy < (rA + rB) * (rA + rB);	
	};	
	LGlobal.hitTestRect = function (objA, objB, vecA, vecB) {	
		var wA = objA.getWidth()	
		,wB = objB.getWidth()	
		,hA = objA.getHeight()	
		,hB = objB.getHeight()	
		,xA = objA._startX ? objA._startX() : objA.startX()	
		,xB = objB._startX ? objB._startX() : objB.startX()	
		,yA = objA._startY ? objA._startY() : objA.startY()	
		,yB = objB._startY ? objB._startY() : objB.startY();	
		if (typeof vecA != UNDEFINED) {	
			xA += (wA - vecA[0]) * 0.5;	
			yA += (hA - vecA[1]) * 0.5;	
			wA = vecA[0];	
			hA = vecA[1];	
		}	
		if (typeof vecB != UNDEFINED) {	
			xB += (wB - vecB[0]) * 0.5;	
			yB += (hB - vecB[1]) * 0.5;	
			wB = vecB[0];	
			hB = vecB[1];	
		}	
		var minx = xA > xB ? xA : xB	
		,miny = yA > yB ? yA : yB	
		,maxx = (xA + wA) > (xB + wB) ? (xB + wB) : (xA + wA)	
		,maxy = (yA + hA) > (yB + hB) ? (yB + hB) : (yA + hA);	
		return minx <= maxx && miny <= maxy;	
	};	
	LGlobal.hitTest = LGlobal.hitTestRect;	
	LGlobal.setFrameRate = function (s) {	
		if (LGlobal.frameRate) {	
			clearInterval(LGlobal.frameRate);	
		}	
		LGlobal.speed = s;	
		LGlobal.frameRate = setInterval(function () {	
			LGlobal.onShow();	
		}, s);	
	};	
	LGlobal.ll_scaleX = function (v) {	
		return (v - LGlobal.left) * LGlobal.width/LGlobal.canvasStyleWidth;	
	};	
	LGlobal.ll_scaleY = function (v) {	
		return (v - LGlobal.top) * LGlobal.height / LGlobal.canvasStyleHeight;	
	};	
	LGlobal.ll_setStageSize = function (w, h) {	
		w =  Math.ceil(w);	
		h =  Math.ceil(h);	
		LGlobal.canvasObj.style.width = w + "px";	
		LGlobal.canvasObj.style.height = h + "px";	
		LGlobal.canvasStyleWidth = w;	
		LGlobal.canvasStyleHeight = h;	
	};	
	LGlobal.resize = function (canvasW, canvasH) {	
		var w, h, t = 0, l = 0, ww = window.innerWidth, wh = window.innerHeight;	
		if (canvasW) {	
			w = canvasW;	
		}	
		if (canvasH) {	
			h = canvasH;	
		}	
		if (LGlobal.stageScale == "noScale") {	
			w = canvasW || LGlobal.width;	
			h = canvasH || LGlobal.height;	
		}	
		switch (LGlobal.stageScale) {	
		case "exactFit":	
			w = canvasW || ww;	
			h = canvasH || wh;	
			break;	
		case "noBorder":	
			w = canvasW || ww;	
			h = canvasH || LGlobal.height*ww/LGlobal.width;	
			switch (LGlobal.align) {	
			case LStageAlign.BOTTOM:	
			case LStageAlign.BOTTOM_LEFT:	
			case LStageAlign.BOTTOM_RIGHT:	
			case LStageAlign.BOTTOM_MIDDLE:	
				t = wh - h;	
				break;	
			}	
		break;	
		case "showAll":	
			if (ww / wh > LGlobal.width / LGlobal.height) {	
				h = canvasH || wh;	
				w = canvasW || LGlobal.width * wh / LGlobal.height;	
			} else {	
				w = canvasW || ww;	
				h = canvasH || LGlobal.height * ww / LGlobal.width;	
			}	
		case "noScale":	
		default:	
			switch (LGlobal.align) {	
			case LStageAlign.BOTTOM:	
			case LStageAlign.BOTTOM_LEFT:	
				t = wh - h;	
				break;	
			case LStageAlign.RIGHT:	
			case LStageAlign.TOP_RIGHT:	
				l = ww - w;	
				break;	
			case LStageAlign.TOP_MIDDLE:	
				l = (ww - w) * 0.5;	
				break;	
			case LStageAlign.BOTTOM_RIGHT:	
				t = wh - h;	
				l = ww - w;	
				break;	
			case LStageAlign.BOTTOM_MIDDLE:	
				t = wh - h;	
				l = (ww - w) * 0.5;	
				break;	
			case LStageAlign.MIDDLE:	
				t = (wh - h) * 0.5;	
				l = (ww - w) * 0.5;	
				break;	
			case LStageAlign.TOP:	
			case LStageAlign.LEFT:	
			case LStageAlign.TOP_LEFT:	
			default:	
			}	
		}	
		LGlobal.canvasObj.style.marginTop = t + "px";	
		LGlobal.canvasObj.style.marginLeft = l + "px";	
		if (LGlobal.isFirefox) {	
			LGlobal.left = parseInt(LGlobal.canvasObj.style.marginLeft);	
			LGlobal.top = parseInt(LGlobal.canvasObj.style.marginTop);	
		}	
		LGlobal.ll_setStageSize(w, h);	
	};	
	LGlobal.sleep = function (s) {	
		var d = new Date();   	
		while ((new Date().getTime() - d.getTime()) < s) {}	
	};	
	LGlobal.screen = function (a) {	
		LGlobal.displayState = a;	
		if (LGlobal.stage) {	
			if (typeof LGlobal.displayState == "number") {	
				LGlobal.resize(LGlobal.width * LGlobal.displayState, LGlobal.height * LGlobal.displayState);	
			} else {	
				LGlobal.resize();	
			}	
		}	
	};	
	return LGlobal;	
})();	
var LSystem = LGlobal;	
var LStage = LGlobal;	
if (!Array.prototype.indexOf) {	
	Array.prototype.indexOf = function (elt) {	
		var len = this.length >>> 0;	
		var from = Number(arguments[1]) || 0;	
		from = (from < 0) ? Math.ceil(from) : Math.floor(from);	
		if (from < 0) {	
			from += len;	
		}	
		for (; from < len; from++){	
			if (from in this && this[from] === elt) {	
				return from;	
			}	
		}	
		return -1;	
	};	
}	
if (!Array.isArray){	
	Array.isArray = function(value){	
		return Object.prototype.toString.apply(value) == '[object Array]';	
	};	
}	
if (!Function.prototype.bind) {	
	Function.prototype.bind = function (oThis) {	
		if (typeof this !== "function") {	
			throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");	
		}	
		var aArgs = Array.prototype.slice.call(arguments, 1), 	
			fToBind = this, 	
			fNOP = function () {},	
			fBound = function () {	
			return fToBind.apply(this instanceof fNOP && oThis ? this : oThis, aArgs.concat(Array.prototype.slice.call(arguments)));	
        };	
		fNOP.prototype = this.prototype;	
		fBound.prototype = new fNOP();	
		return fBound;	
	};	
}	
if (!Array.prototype.find) {	
	Array.prototype.find = function (predicate) {	
		if (this == null) {	
			throw new TypeError('Array.prototype.find called on null or undefined');	
		}	
		if (typeof predicate !== 'function') {	
			throw new TypeError('predicate must be a function');	
		}	
		var list = Object(this);	
		var length = list.length >>> 0;	
		var thisArg = arguments[1];	
		var value;	
		for (var i = 0; i < length; i++) {	
			value = list[i];	
			if (predicate.call(thisArg, value, i, list)) {	
				return value;	
			}	
		}	
		return undefined;	
	};	
}	
if (!Array.prototype.findIndex) {	
	Array.prototype.findIndex = function (predicate) {	
		if (this == null) {	
			throw new TypeError('Array.prototype.find called on null or undefined');	
		}	
		if ( typeof predicate !== 'function') {	
			throw new TypeError('predicate must be a function');	
		}	
		var list = Object(this);	
		var length = list.length >>> 0;	
		var thisArg = arguments[1];	
		var value;	
		for (var i = 0; i < length; i++) {	
			value = list[i];	
			if (predicate.call(thisArg, value, i, list)) {	
				return i;	
			}	
		}	
		return -1;	
	};	
}	
if (!Array.prototype.forEach) {	
	Array.prototype.forEach = function (callback, thisArg) {	
		var T, k;	
		if (this == null) {	
			throw new TypeError(' this is null or not defined');	
		}	
		var O = Object(this);	
		var len = O.length >>> 0;	
		if ( typeof callback !== "function") {	
			throw new TypeError(callback + ' is not a function');	
		}	
		if (arguments.length > 1) {	
			T = thisArg;	
		}	
		k = 0;	
		while (k < len) {	
			var kValue;	
			if ( k in O) {	
				kValue = O[k];	
				callback.call(T, kValue, k, O);	
			}	
			k++;	
		}	
	};	
}	
if (!Array.prototype.every) {	
	Array.prototype.every = function(callbackfn, thisArg) {	
		'use strict';	
		var T, k;	
		if (this == null) {	
			throw new TypeError('this is null or not defined');	
		}	
		var O = Object(this);	
		var len = O.length >>> 0;	
		if ( typeof callbackfn !== 'function') {	
			throw new TypeError();	
		}	
		if (arguments.length > 1) {	
			T = thisArg;	
		}	
		k = 0;	
		while (k < len) {	
			var kValue;	
			if ( k in O) {	
				kValue = O[k];	
				var testResult = callbackfn.call(T, kValue, k, O);	
				if (!testResult) {	
					return false;	
				}	
			}	
			k++;	
		}	
		return true;	
	};	
}	
if (!Array.prototype.some) {	
	Array.prototype.some = function(fun) {	
		'use strict';	
		if (this == null) {	
			throw new TypeError('Array.prototype.some called on null or undefined');	
		}	
		if ( typeof fun !== 'function') {	
			throw new TypeError();	
		}	
		var t = Object(this);	
		var len = t.length >>> 0;	
		var thisArg = arguments.length >= 2 ? arguments[1] :	
		void 0;	
		for (var i = 0; i < len; i++) {	
			if ( i in t && fun.call(thisArg, t[i], i, t)) {	
				return true;	
			}	
		}	
		return false;	
	};	
}	
function trace() {	
	if (!LGlobal.traceDebug) return;	
	var t = document.getElementById("traceObject"), i;	
	if (trace.arguments.length > 0 && t == null) {	
		t = document.createElement("TEXTAREA");	
		t.id = "traceObject";	
		t.style.position = "absolute";	
		t.style.top = (LGlobal.height + 20) + "px";	
		t.style.width = LGlobal.width + "px";	
		t.style.height = "200px";	
		document.body.appendChild(t);	
	}	
	for (i = 0; i < trace.arguments.length; i++) {	
		t.value = t.value + trace.arguments[i] + "\r\n";	
		t.scrollTop = t.scrollHeight;	
	}	
}	
if (!window.console) {	
	window.console = {	
		log : trace,	
		warn : trace	
	};	
}	
function addChild (o) {	
	LGlobal.stage.addChild(o);	
}	
function removeChild (o) {	
	LGlobal.stage.removeChild(o);	
}	
function init (s, c, w, h, f, t) {	
	LGlobal.speed = s;	
	var _f = function () {	
		if (LGlobal.canTouch && LGlobal.aspectRatio == LANDSCAPE && window.innerWidth < window.innerHeight) {	
			LGlobal.horizontalError();	
		} else if (LGlobal.canTouch && LGlobal.aspectRatio == PORTRAIT && window.innerWidth > window.innerHeight) {	
			LGlobal.verticalError();	
		} else {	
			setTimeout(f, 100);	
		}	
		LGlobal.startTimer = (new Date()).getTime();	
	};	
	if (t != null && t == LEvent.INIT) {	
		LGlobal.frameRate = setInterval(function () {	
			LGlobal.onShow();	
		}, s);	
		LGlobal.setCanvas(c, w, h);	
		_f();	
	}else{	
		LEvent.addEventListener(window, "load", function () {	
			LGlobal.frameRate = setInterval(function () {	
				LGlobal.onShow();	
			}, s);	
			LGlobal.setCanvas(c, w, h);	
			_f();	
		});	
	}	
}	
var LInit = init;	
function base (d, b, a) {	
	var p = null, o = d.constructor.prototype, h = {};	
	if(d.constructor.name == "Object"){	
		console.warn( "When you use the extends. You must make a method like 'XX.prototype.xxx=function(){}'. but not 'XX.prototype={xxx:function(){}}'.");	
	}	
	if (typeof d.__ll__parent__ == UNDEFINED) {	
		d.__ll__parent__ = [];	
		d.__ll__parent__ = [];	
	}	
	d.__ll__parent__.push(b.prototype);	
	for (p in o) {	
		h[p] = 1;	
	}	
	for (p in b.prototype) {	
		if (!h[p]) {	
			o[p] = b.prototype[p];	
		}	
	}	
	if (o.toString == Object.prototype.toString) {	
		o.toString = LObject.prototype.toString;	
	}	
	b.apply(d, a);	
}	
var LExtends = base;	
function getTimer () {	
	return (new Date()).getTime() - LGlobal.startTimer;	
}	
function getExtension (path) {	
	var r, pattern = /([^#?]+\.)([^.#?]+)/;	
	r = path.match(pattern);	
	if (r.length >= 3) {	
		return r[2].toLowerCase();	
	}	
	return null;	
}	
var LObject = (function () {	
	function LObject () {	
		this.type = "LObject";	
		this.objectIndex = ++LGlobal.objectIndex;	
		this.objectindex = this.objectIndex;	
	}	
	LObject.prototype = {	
		callParent : function (f_n, args) {	
			if (!f_n || !args) {	
				return;	
			}	
			var s = this, init = false, r, k = "__ll__parent_call" + f_n;	
			if (typeof s[k] == "undefined") {	
				init = true;	
				s[k] = 0;	
			} else {	
				s[k]++;	
			}	
			if (s[k] >= s.__ll__parent__.length) {	
				return false;	
			}	
			if (!s.__ll__parent__[s[k]][f_n]) {	
				r = s.callParent(f_n, args);	
			} else {	
				r = s.__ll__parent__[s[k]][f_n].apply(s, args);	
			}	
			if (init) {	
				delete s[k];	
			}	
			return r;	
		},	
		copyProperty : function (a) {	
			var s = this, k;	
			for (k in a) {	
				if (typeof a[k] == "number" || typeof a[k] == "string" || typeof a[k] == "boolean") {	
					if (k == "objectindex" || k == "objectIndex") {	
						continue;	
					}	
					s[k] = a[k];	
				} else if (Array.isArray(a[k])) {	
					s[k] = a[k].slice();	
				} 	
			}	
			if (a.mask) {	
				s.mask = a.mask.clone();	
			}	
		},	
		toString : function () {	
			return "[object " + this.constructor.name + "]";	
		}	
	};	
	return LObject;	
})();	
var LColorTransform = (function () {	
	function LColorTransform (redMultiplier, greenMultiplier, blueMultiplier, alphaMultiplier, redOffset, greenOffset, blueOffset, alphaOffset) {	
		var s = this;	
		LExtends (s, LObject, []);	
		s.redMultiplier = redMultiplier;	
		s.greenMultiplier = greenMultiplier;	
		s.blueMultiplier = blueMultiplier;	
		s.alphaMultiplier = alphaMultiplier;	
		s.redOffset = redOffset;	
		s.greenOffset = greenOffset;	
		s.blueOffset = blueOffset;	
		s.alphaOffset = alphaOffset;	
	}	
	return LColorTransform;	
})();	
var LTransform = (function () {	
	function LTransform () {	
		var s = this;	
		LExtends (s, LObject, []);	
		s.matrix = null;	
	}	
	return LTransform;	
})();	
var LMatrix = (function () {	
	function LMatrix (a, b, c, d, tx, ty, u, v, w) {	
		var s = this;	
		LExtends (s, LObject, []);	
		s.a = 1;	
		s.b = 0;	
		s.u = 0;	
		s.c = 0;	
		s.d = 1;	
		s.v = 0;	
		s.tx = 0;	
		s.ty = 0;	
		s.w = 1;	
		if (typeof a != UNDEFINED) {	
			s.a = a;	
		}	
		if (typeof b != UNDEFINED) {	
			s.b = b;	
		}	
		if (typeof c != UNDEFINED) {	
			s.c = c;	
		}	
		if (typeof d != UNDEFINED) {	
			s.d = d;	
		}	
		if (typeof tx != UNDEFINED) {	
			s.tx = tx;	
		}	
		if (typeof ty != UNDEFINED) {	
			s.ty = ty;	
		}	
		if (typeof u != UNDEFINED) {	
			s.u = u;	
		}	
		if (typeof v != UNDEFINED) {	
			s.v = v;	
		}	
		if (typeof w != UNDEFINED) {	
			s.w = w;	
		}	
	}	
	var p = {	
		setTo : function (a, b, c, d, tx, ty, u, v, w) {	
			var s = this;	
			if (typeof a != UNDEFINED) {	
				s.a = a;	
			}	
			if (typeof b != UNDEFINED) {	
				s.b = b;	
			}	
			if (typeof c != UNDEFINED) {	
				s.c = c;	
			}	
			if (typeof d != UNDEFINED) {	
				s.d = d;	
			}	
			if (typeof tx != UNDEFINED) {	
				s.tx = tx;	
			}	
			if (typeof ty != UNDEFINED) {	
				s.ty = ty;	
			}	
			if (typeof u != UNDEFINED) {	
				s.u = u;	
			}	
			if (typeof v != UNDEFINED) {	
				s.v = v;	
			}	
			if (typeof w != UNDEFINED) {	
				s.w = w;	
			}	
			return s;	
		},	
		isIdentity : function () {	
			var s = this;	
			return (s.a == 1 && s.b == 0 && s.c == 0 && s.d == 1 && s.tx == 0 && s.ty == 0 && u == 0 && v == 0 && w == 1);	
		},	
		transform : function (c) {	
			var s = this;	
			c.transform(s.a, s.b, s.c, s.d, s.tx, s.ty);	
			return s;	
		},	
		identity : function () {	
			this.setTo(1, 0, 0, 1, 0, 0, 0, 0, 1);	
		},	
		rotate : function (q) {	
			var s = this,	
			radian = q * Math.PI / 180,	
			cos = Math.cos(radian),	
			sin = Math.sin(radian),	
			mtx = new LMatrix(cos, sin, -sin, cos, 0, 0, 0, 0, 1);	
			s.add(mtx);	
			return s;	
		},	
		scale : function (sx, sy) {	
			var s = this,	
			mtx = new LMatrix(sx, 0, 0, sy, 0, 0, 0, 0, 1);	
			s.add(mtx);	
			return s;	
		},	
		translate : function (tx, ty) {	
			var s = this,	
			mtx = new LMatrix(1, 0, 0, 1, tx, ty, 0, 0, 1);	
			s.add(mtx);	
			return s;	
		},	
		skew : function (kx, ky) {	
			var s = this,	
			mtx = new LMatrix(1, ky, kx, 1, 0, 0, 0, 0, 1);	
			s.add(mtx);	
			return s;	
		},	
		add : function (mtx) {	
			var s = this, a, b, c, d, tx, ty, u, v, w;	
			a = s.a * mtx.a + s.b * mtx.c + s.u * mtx.tx;	
			b = s.a * mtx.b + s.b * mtx.d + s.u * mtx.ty;	
			u = s.a * mtx.u + s.b * mtx.v + s.u * mtx.w;	
			c = s.c * mtx.a + s.d * mtx.c + s.v * mtx.tx;	
			d = s.c * mtx.b + s.d * mtx.d + s.v * mtx.ty;	
			v = s.c * mtx.u + s.d * mtx.v + s.v * mtx.w;	
			tx = s.tx * mtx.a + s.ty * mtx.c + s.w * mtx.tx;	
			ty = s.tx * mtx.b + s.ty * mtx.d + s.w * mtx.ty;	
			w = s.tx * mtx.u + s.ty * mtx.v + s.w * mtx.w;	
			s.setTo(a, b, c, d, tx, ty, u, v, w);	
		},	
		toArray : function (mtx) {	
			var s = this;	
			if (Array.isArray(mtx) && mtx.length == 3) {	
				var m = mtx[0] * s.a + mtx[1] * s.c + mtx[2] * s.tx,	
				n = mtx[0] * s.b + mtx[1] * s.d + mtx[2] * s.ty,	
				k = mtx[0] * s.u + mtx[1] * s.v + mtx[2] * s.w;	
				return [m, n, k];	
			} else {	
				var a = s.a * mtx.a + s.b * mtx.c + s.u * mtx.tx,	
				b = s.a * mtx.b + s.b * mtx.d + s.u * mtx.ty,	
				u = s.a * mtx.u + s.b * mtx.v + s.u * mtx.w,	
				c = s.c * mtx.a + s.d * mtx.c + s.v * mtx.tx,	
				d = s.c * mtx.b + s.d * mtx.d + s.v * mtx.ty,	
				v = s.c * mtx.u + s.d * mtx.v + s.v * mtx.w,	
				tx = s.tx * mtx.a + s.ty * mtx.c + s.w * mtx.tx,	
				ty = s.tx * mtx.b + s.ty * mtx.d + s.w * mtx.ty,	
				w = s.tx * mtx.u + s.ty * mtx.v + s.w * mtx.w;	
				return [a, b, c, d, tx, ty, u, v, w];	
			}	
		},	
		clone : function () {	
			var s = this;	
			return new LMatrix(s.a, s.b, s.c, s.d, s.tx, s.ty, s.u, s.v, s.w);	
		}	
	};	
	for (var k in p) {	
		LMatrix.prototype[k] = p[k];	
	}	
	return LMatrix;	
})();	
var LVec2 = (function () {	
	function LVec2 (x, y) {	
		this.x = x || 0;	
		this.y = y || 0;	
	}	
	LVec2.dot = function (a, b) {	
		return a.x * b.x + a.y * b.y;	
	};	
	LVec2.cross = function (a, b) {	
		return a.x * b.y - a.y * b.x;	
	};	
	LVec2.distance = function (a, b) {	
		var x = a.x - b.x;	
		var y = a.y - b.y;	
		return Math.sqrt(x * x + y * y);	
	};	
	LVec2.getMinMax = function (vecs, axis) {	
		var min_o = LVec2.dot(vecs[0], axis);	
		var max_o = LVec2.dot(vecs[0], axis);	
		var min_i = 0;	
		var max_i = 0;	
		for (var i = 1; i < vecs.length; i++) {	
			var this_o = LVec2.dot(vecs[i], axis);	
			if (min_o > this_o) {	
				min_o = this_o;	
				min_i = i;	
			}	
			if (max_o < this_o) {	
				max_o = this_o;	
				max_i = i;	
			}	
		}	
		var r = {"min_o" : min_o, "min_i" : min_i, "max_o" : max_o, "max_i" : max_i};	
		return r;	
	};	
	LVec2.prototype = {	
		length : function () {	
			var s = this;	
			return Math.sqrt(s.x * s.x + s.y * s.y);	
		},	
		normalize : function () {	
			var s = this, l = s.length();	
			return new LVec2(s.x / l, s.y / l);	
		},	
		normR : function () {	
			return new LVec2(-this.y, this.x);	
		},	
		normL : function () {	
			return new LVec2(this.y, -this.x);	
		}	
	};	
	return LVec2;	
})();	
var LEventDispatcher = (function () {	
	function LEventDispatcher () {	
		var s = this;	
		LExtends(s, LObject, []);	
		s._eventList = new Array();	
	}	
	var p = {	
		addEventListener : function (type, listener) {	
			this._eventList.push({listener : listener, type : type});	
		},	
		removeEventListener : function (type, listener) {	
			var s = this, i, length;	
			length = s._eventList.length;	
			for (i = 0; i < length; i++) {	
				if (!s._eventList[i]) {	
					continue;	
				}	
				if (type == s._eventList[i].type && s._eventList[i].listener == listener) {	
					s._eventList.splice(i, 1);	
					return;	
				}	
			}	
		},	
		removeAllEventListener : function () {	
			this._eventList = [];	
		},	
		dispatchEvent : function (event) {	
			var s = this, i, length = s._eventList.length, ctype = (typeof event == "string") ? event : event.eventType;	
			for (i = 0; i < length; i++) {	
				if (!s._eventList[i]) {	
					continue;	
				}	
				if (ctype == s._eventList[i].type) {	
					if (typeof event == "string") {	
						s.currentTarget = s.target = s;	
						s.eventType = s.event_type = ctype;	
						s._eventList[i].listener(s);	
						delete s.currentTarget;	
						delete s.target;	
						delete s.eventType;	
					}else{	
						if (!event.target) {	
							event.target = s;	
						}	
						if (!event.currentTarget) {	
							event.currentTarget = event.target;	
						}	
						event._ll_preventDefault = false;	
						s._eventList[i].listener(event);	
						if (event._ll_preventDefault) {	
							return false;	
						}	
					}	
					return true;	
				}	
			}	
			return false;	
		},	
		hasEventListener : function (type, listener) {	
			var s = this, i, length = s._eventList.length;	
			for (i = 0; i < length; i++) {	
				if (!s._eventList[i]) {	
					continue;	
				}	
				if (type == s._eventList[i].type) {	
					if (typeof listener == UNDEFINED || listener == s._eventList[i].listener) {	
						return true;	
					}	
				}	
			}	
			return false;	
		}	
	};	
	for (var k in p) {	
		LEventDispatcher.prototype[k] = p[k];	
	}	
	return LEventDispatcher;	
})();	
var LDisplayObject = (function () {	
	function LDisplayObject () {	
		var s = this;	
		LExtends(s, LEventDispatcher, []);	
		s.name = "instance" + s.objectIndex;	
		s.x = 0;	
		s.y = 0;	
		s.width = 0;	
		s.height = 0;	
		s.scaleX = 1;	
		s.scaleY = 1;	
		s.alpha = 1;	
		s.visible = true;	
		s.rotate = 0;	
		s.mask = null;	
		s.blendMode = null;	
		s.filters = null;	
		s.transform = new LTransform();	
	}	
	var p = {	
		_createCanvas:function(){	
			var s = this;	
			if (!s._canvas) {	
				s._canvas = document.createElement("canvas");	
				s._context = s._canvas.getContext("2d");	
			}	
		},	
		ll_show : function () {	
			var s = this, c = LGlobal.canvas;	
			if (!s._canShow()) {	
				return;	
			}	
			s._ll_trans = false;	
			if (!LGlobal.box2d && typeof s._ll_loopframe == "function") {	
				s._ll_loopframe();	
			}	
			c.save();	
			s._showReady(c);	
			if (s.blendMode) {	
				c.globalCompositeOperation = s.blendMode;	
			}	
			if (s.filters) {	
				s._ll_setShadow();	
			}	
			s._rotateReady();	
			if (s.mask != null && s.mask.ll_show) {	
				s.mask.ll_show();	
				c.clip();	
			}	
			s._transformRotate();	
			s._transformScale();	
			s._coordinate(c);	
			if (s.transform.matrix) {	
				s.transform.matrix.transform(c);	
			}	
			if (s.alpha < 1) {	
				s._ll_trans = true;	
				c.globalAlpha = s.alpha;	
			}	
			if (LGlobal.fpsStatus) {	
				LGlobal.fpsStatus.display++;	
				if (s._ll_trans) {	
					LGlobal.fpsStatus.transform++;	
				}	
			}	
			s._ll_show(c);	
			c.restore();	
			if (LGlobal.box2d != null && typeof s._ll_loopframe == "function") {	
				s._ll_loopframe();	
			}	
		},	
		_canShow : function () {	
			return this.visible;	
		},	
		_coordinate : function (c) {	
			var s = this;	
			if (s.x != 0 || s.y != 0) {	
				s._ll_trans = true;	
				c.transform(1, 0, 0, 1, s.x, s.y);	
			}	
		},	
		_rotateReady : function () {},	
		_showReady : function (c) {},	
		_ll_show : function (c) {},	
		_ll_setShadow : function () {	
			var s = this, f = s.filters, i, l;	
			if (!f) {	
				return;	
			}	
			for (i = 0, l = f.length; i < l; i++) {	
				f[i].ll_show();	
			}	
		},	
		_transformRotate : function () {	
			var s = this, c;	
			if (s.rotate == 0) {	
				return;	
			}	
			s._ll_trans = true;	
			c = LGlobal.canvas, rotateFlag = Math.PI / 180, rotateObj = new LMatrix();	
			if ((typeof s.rotatex) == UNDEFINED) {	
				s.rotatex = 0;	
				s.rotatey = 0;	
			}	
			if (s.box2dBody) {	
				rotateFlag = 1;	
			}	
			rotateObj.a = Math.cos(s.rotate * rotateFlag);	
			rotateObj.b = Math.sin(s.rotate * rotateFlag);	
			rotateObj.c = -rotateObj.b;	
			rotateObj.d = rotateObj.a;	
			rotateObj.tx = s.x + s.rotatex;	
			rotateObj.ty = s.y + s.rotatey;	
			rotateObj.transform(c).setTo(1, 0, 0, 1, -rotateObj.tx, -rotateObj.ty).transform(c);	
		},	
		_transformScale : function () {	
			var s = this,c = LGlobal.canvas, scaleObj;	
			if (s.scaleX == 1 && s.scaleY == 1) {	
				return;	
			}	
			s._ll_trans = true;	
			scaleObj = new LMatrix();	
			if (s.scaleX != 1) {	
				scaleObj.tx = s.x;	
			}	
			if (s.scaleY != 1) {	
				scaleObj.ty = s.y;	
			}	
			scaleObj.a = s.scaleX;	
			scaleObj.d = s.scaleY;	
			scaleObj.transform(c).setTo(1, 0, 0, 1, -scaleObj.tx, -scaleObj.ty).transform(c);	
		},	
		getAbsoluteScale : function () {	
			var s = this, sX, sY, p;	
			sX = s.scaleX;	
			sY = s.scaleY;	
			p = s.parent;	
			while (p && p != "root") {	
				sX *= p.scaleX;	
				sY *= p.scaleY;	
				p = p.parent;	
			}	
			return {scaleX : sX, scaleY : sY};	
		},	
		getRootCoordinate : function () {	
			var s = this, sx, sy, p;	
			sx=s.x;	
			sy=s.y;	
			p = s.parent;	
			while (p && p != "root") {	
				sx *= p.scaleX;	
				sy *= p.scaleY;	
				sx += p.x;	
				sy += p.y;	
				p = p.parent;	
			}	
			return new LPoint(sx,sy);	
		},	
		getBounds : function (d) {	
			if (typeof d == UNDEFINED) {	
				return new LRectangle(0, 0, 0, 0);	
			}	
			var s = this, x = 0, y = 0, w = 0, h = 0, sp, dp;	
			if (s.objectIndex != d.objectIndex) {	
				sp = s.getRootCoordinate();	
				dp = d.getRootCoordinate();	
				x = sp.x - dp.x;	
				y = sp.y - dp.y;	
			}	
			if (d.getWidth) {	
				w = d.getWidth();	
			}	
			if (d.getHeight) {	
				h = d.getHeight();	
			}	
			return new LRectangle(x, y, w, h);	
		},	
		getDataCanvas : function () {	
			var s = this, _o, o, _c, c, _x, _y;	
			s._createCanvas();	
			o = LGlobal.canvasObj;	
			c = LGlobal.canvas;	
			_o = s._canvas;	
			_c = s._context;	
			s.width = s.getWidth();	
			s.height = s.getHeight();	
			_o.width = s.width;	
			_o.height = s.height;	
			_c.clearRect(0, 0, s.width, s.height);	
			LGlobal.canvasObj = s._canvas;	
			LGlobal.canvas = s._context;	
			_x = s.x;	
			_y = s.y;	
			s.x = s.y = 0;	
			s.ll_show();	
			s.x = _x;	
			s.y = _y;	
			s._canvas = _o;	
			s._context = _c;	
			LGlobal.canvasObj = o;	
			LGlobal.canvas = c;	
			return s._canvas;	
		},	
		getDataURL : function () {	
			var s = this, r = s.getDataCanvas();	
			return r.toDataURL.apply(r, arguments);	
		},	
		ismouseonShapes : function (shapes, mx, my) {	
			var s = this, parent = s, m, child, j, v, arg;	
			if (typeof shapes == UNDEFINED) {	
				shapes = s.shapes;	
			}	
			m = s.getRootMatrix();	
			for (j = shapes.length - 1; j >= 0; j--) {	
				child = shapes[j];	
				arg = child.arg;	
				v = s._changeShape(child.type, arg, m);	
				if (child.type == LShape.VERTICES) {	
					if (LGlobal.hitPolygon(v, mx, my)) {	
						return true;	
					}	
				} else if (child.type == LShape.RECT) {	
					if (LGlobal.hitPolygon(v, mx, my)) {	
						return true;	
					}	
				} else if (child.type == LShape.ARC) {	
					if ((v[0] - mx) * (v[0] - mx) + (v[1] - my) * (v[1] - my) < v[3]) {	
						return true;	
					}	
				}	
			}	
			return false;	
		},	
		_changeShape : function (type, arg, m) {	
			var v, arg = arg, r2, i, l, v1, v2;	
			if (type == LShape.VERTICES) {	
				v = [];	
				for (i = 0, l = arg.length; i < l; i++) {	
					v[i] = m.toArray([arg[i][0], arg[i][1], 1]);	
				}	
			} else if (type == LShape.RECT) {	
				v = [[arg[0], arg[1]], [arg[0] + arg[2], arg[1]], [arg[0] + arg[2], arg[1] + arg[3]], [arg[0], arg[1] + arg[3]]];	
				for (i = 0, l = v.length; i < l; i++) {	
					v[i] = m.toArray([v[i][0], v[i][1],1]);	
				}	
			} else if (type == LShape.ARC) {	
				v1 = m.toArray([arg[0], arg[1], 1]);	
				v2 = m.toArray([arg[0] + arg[2], arg[1], 1]);	
				r2 = (v1[0] - v2[0]) * (v1[0] - v2[0]) + (v1[1] - v2[1]) * (v1[1] - v2[1]);	
				v = [v1[0], v1[1], Math.sqrt(r2), r2];	
			}	
			return v;	
		},	
		getRootMatrix : function () {	
			var parent = this, m = new LMatrix();	
			while (parent && parent != "root") {	
				if (parent.scaleX != 1 || parent.scaleY != 1) {	
					m.scale(parent.scaleX, parent.scaleY);	
				}	
				if (parent.rotate != 0) {	
					m.rotate(parent.rotate);	
				}	
				if (parent.x != 0 || parent.y != 0) {	
					m.translate(parent.x, parent.y);	
				}	
				parent = parent.parent;	
			}	
			return m;	
		},	
		remove : function () {	
			var s = this, p = s.parent;	
			if (!p || p == "root") {	
				return;	
			}	
			p.removeChild(s);	
			s._ll_removeFromSelf = true;	
		}	
	};	
	for (var k in p) {	
		LDisplayObject.prototype[k] = p[k];	
	}	
	return LDisplayObject;	
})();	
var LInteractiveObject = (function() {	
	function LInteractiveObject() {	
		var s = this;	
		LExtends(s, LDisplayObject, []);	
		s.type = "LInteractiveObject";	
		s.mouseEnabled = true;	
		s.mouseList = new Array();	
	}	
	var p = {	
		addEventListener : function(type, listener) {	
			var s = this;	
			if (type.indexOf("mouse") >= 0 || type.indexOf("touch") >= 0 || type == LMouseEvent.DOUBLE_CLICK) {	
				if (LMouseEventContainer.container[type] || ((type == LMouseEvent.MOUSE_OVER || type == LMouseEvent.MOUSE_OUT) && LMouseEventContainer.container[LMouseEvent.MOUSE_MOVE])) {	
					LMouseEventContainer.addMouseEvent(s, type, listener);	
					return;	
				}	
				s.mouseList.push({	
					listener : listener,	
					type : type	
				});	
			} else {	
				s._eventList.push({	
					listener : listener,	
					type : type	
				});	
			}	
		},	
		removeEventListener : function(type, listener) {	
			var s = this, i, length;	
			if (type.indexOf("mouse") >= 0 || type.indexOf("touch") >= 0 || type == LMouseEvent.DOUBLE_CLICK) {	
				if (LMouseEventContainer.container[type] || ((type == LMouseEvent.MOUSE_OVER || type == LMouseEvent.MOUSE_OUT) && LMouseEventContainer.container[LMouseEvent.MOUSE_MOVE])) {	
					LMouseEventContainer.removeMouseEvent(s, type, listener);	
					return;	
				}	
				length = s.mouseList.length;	
				for ( i = 0; i < length; i++) {	
					if (!s.mouseList[i]) {	
						continue;	
					}	
					if (type == s.mouseList[i].type && s.mouseList[i].listener == listener) {	
						s.mouseList.splice(i, 1);	
						return;	
					}	
				}	
			} else {	
				return s.callParent("removeEventListener", arguments);	
			}	
		},	
		removeAllEventListener : function() {	
			var s = this;	
			s.mouseList.length = 0;	
			s._eventList.length = 0;	
			if (LMouseEventContainer.container[LMouseEvent.MOUSE_DOWN]) {	
				LMouseEventContainer.removeMouseEvent(s, LMouseEvent.MOUSE_DOWN);	
			}	
			if (LMouseEventContainer.container[LMouseEvent.MOUSE_UP]) {	
				LMouseEventContainer.removeMouseEvent(s, LMouseEvent.MOUSE_UP);	
			}	
			if (LMouseEventContainer.container[LMouseEvent.MOUSE_MOVE]) {	
				LMouseEventContainer.removeMouseEvent(s, LMouseEvent.MOUSE_MOVE);	
				LMouseEventContainer.removeMouseEvent(s, LMouseEvent.MOUSE_OVER);	
				LMouseEventContainer.removeMouseEvent(s, LMouseEvent.MOUSE_OUT);	
			}	
		},	
		hasEventListener : function(type) {	
			var s = this, i, length;	
			if (type.indexOf("mouse") >= 0 || type.indexOf("touch") >= 0 || type == LMouseEvent.DOUBLE_CLICK) {	
				length = s.mouseList.length;	
				for ( i = 0; i < length; i++) {	
					if (!s.mouseList[i]) {	
						continue;	
					}	
					if (type == s.mouseList[i].type) {	
						return true;	
					}	
				}	
			} else {	
				return s.callParent("hasEventListener", arguments);	
			}	
			return false;	
		}	
	};	
	for (var k in p) {	
		LInteractiveObject.prototype[k] = p[k];	
	}	
	return LInteractiveObject;	
})(); 	
var LDisplayObjectContainer = (function () {	
	function LDisplayObjectContainer () {	
		var s = this;	
		LExtends(s, LInteractiveObject, []);	
		s.childList = new Array();	
		s.numChildren = 0;	
		s.mouseChildren = true;	
	}	
	var p = {	
		addChild : function (d) {	
			var s  = this,t;	
			if (d.parent) {	
				t = LGlobal.destroy;	
				LGlobal.destroy = false;	
				d.parent.removeChild(d);	
				LGlobal.destroy = t;	
			}	
			d.parent = s;	
			s.childList.push(d);	
			s.numChildren = s.childList.length;	
			s._ll_removeFromSelf = false;	
			return d;	
		},	
		addChildAt : function (d, i) {	
			var s = this,t;	
			if (i < 0 || i > s.childList.length) {	
				return;	
			}	
			if (typeof d.remove == "function") {	
				t = LGlobal.destroy;	
				LGlobal.destroy = false;	
				d.remove();	
				LGlobal.destroy = t;	
			}	
			d.parent = s;	
			s.childList.splice(i, 0, d);	
			s.numChildren = s.childList.length;	
			s._ll_removeFromSelf = false;	
			return d;	
		},	
		removeChild : function (d) {	
			var s  = this, c = s.childList, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (d.objectIndex == c[i].objectIndex) {	
					if (LGlobal.destroy && d.die) {	
						d.die();	
					}	
					s.childList.splice(i, 1);	
					break;	
				}	
			}	
			s.numChildren = s.childList.length;	
			delete d.parent;	
		},	
		getChildAt : function (i) {	
			var s  = this, c = s.childList;	
			if (c.length == 0 || c.length <= i) {	
				return null;	
			}	
			return c[i];	
		},	
		getChildByName : function (n) {	
			var s  = this, c = s.childList;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (!c[i]) {	
					continue;	
				}	
				if (c[i].name == n) {	
					return c[i];	
				}	
			}	
			return null;	
		},	
		removeChildAt : function (i) {	
			var s  = this, c = s.childList;	
			if (c.length <= i) {	
				return;	
			}	
			if (LGlobal.destroy && c[i].die) {	
				c[i].die();	
			}	
			var d = s.childList.splice(i, 1);	
			s.numChildren = s.childList.length;	
			return d;	
		},	
		getChildIndex : function (child) {	
			if (!child) {	
				return -1;	
			}	
			var s = this, c = s.childList, i, l = c.length;	
			for (i = 0; i < l; i++) {	
				if (c[i].objectIndex == child.objectIndex) {	
					return i;	
				}	
			}	
			return -1;	
		},	
		setChildIndex : function (child, index) {	
			var s = this, c = s.childList, i, l = c.length;	
			if (child.parent == "root" || child.parent.objectIndex != s.objectIndex || index < 0 || index >= l) {	
				return -1;	
			}	
			for (i = 0; i < l; i++) {	
				if(c[i].objectIndex == child.objectIndex){	
					break;	
				}	
			}	
			s.childList.splice(i,1);	
			s.childList.splice(index, 0, child);	
			return index;	
		},	
		resize : function () {	
			var s  = this;	
			s.width = s.getWidth();	
			s.height = s.getHeight();	
		},	
		removeAllChild : function () {	
			var s  = this, c = s.childList, i, l;	
			for (i = 0, l = c.length; i < l; i++) {	
				if (LGlobal.destroy && c[i].die) {	
					c[i].die();	
				}	
			}	
			s.childList.length = 0;	
			s.width = 0;	
			s.height = 0;	
			s.numChildren = 0;	
		}	
	};	
	for (var k in p) {	
		LDisplayObjectContainer.prototype[k] = p[k];	
	}	
	return LDisplayObjectContainer;	
})();	
var LLoader = (function () {	
	function LLoader () {	
		var s = this;	
		LExtends(s, LEventDispatcher, []);	
		s.type = "LLoader";	
	}	
	LLoader.TYPE_BITMAPDATE = "bitmapData";	
	LLoader.prototype.load = function (u, t) {	
		var s = this;	
		if (!t) {	
			t = LLoader.TYPE_BITMAPDATE;	
		}	
		s.loadtype = t;	
		if (t == LLoader.TYPE_BITMAPDATE) {	
			s.content = new Image();	
			s.content.onload = function () {	
				s.content.onload = null;	
				var event = new LEvent(LEvent.COMPLETE);	
				event.currentTarget = s;	
				event.target = s.content;	
				s.dispatchEvent(event);	
				delete s.content;	
			};	
			s.content.src = u; 	
		}	
	};	
	return LLoader;	
})();	
var LURLLoader = (function () {	
	function LURLLoader () {	
		var s = this;	
		LExtends(s, LEventDispatcher, []);	
		s.type = "LURLLoader";	
		s.loadtype = "";	
		s.content = null;	
		s.event = {};	
	}	
	LURLLoader.TYPE_TEXT = "text";	
	LURLLoader.TYPE_JS = "js";	
	LURLLoader.prototype.load = function (u, t) {	
		var s = this, event, ext;	
		if (!t) {	
			ext = getExtension(u);	
			if (ext == "txt") {	
				t = LURLLoader.TYPE_TEXT;	
			} else if (ext == "js") {	
				t = LURLLoader.TYPE_JS;	
			}	
		}	
		s.loadtype = t;	
		if (t == LURLLoader.TYPE_TEXT) {	
			LAjax.get(u, {}, function (data) {	
				event = new LEvent(LEvent.COMPLETE);	
				s.data = data;	
				event.currentTarget = s;	
				event.target = data;	
				s.dispatchEvent(event);	
				delete s.content;	
				delete s.data;	
			});	
		} else if (t == LURLLoader.TYPE_JS) {	
			var script = document.createElement("script");	
			script.onload = function () {	
				event = new LEvent(LEvent.COMPLETE);	
				event.currentTarget = s;	
				event.target = s;	
				s.dispatchEvent(event);	
				delete s.content;	
			};	
			script.src = u;	
			script.type = "text/javascript";	
			document.querySelector('head').appendChild(script);	
		}	
	};	
	return LURLLoader;	
})();	
var LWebAudio = (function () {	
	function LWebAudio () {	
		var s = this;	
		LExtends(s, LEventDispatcher, []);	
		s.currentTime = 0;	
		s.currentStart = 0;	
		s.currentSave = 0;	
		s.length = 0;	
		s.loopStart = 0;	
		s.loopEnd = 0;	
		s.loopIndex = 0;	
		s.loopLength = 1;	
		s.playing = false;	
		s.volume = 1;	
		LSound.Container.add(s);	
	}	
	LWebAudio.container = [];	
	LWebAudio.containerCount = 0;	
	LWebAudio.audioTag = new Audio();	
	LWebAudio._context = null;	
	var p = {	
		getWebAudio : function () {	
			var data;	
			if(LWebAudio.containerCount > 0){	
				data = LWebAudio.container.shift();	
			} else {	
				if (typeof AudioContext !== UNDEFINED) {	
					try {	
						data = new AudioContext();	
					} catch (e) {	
						LWebAudio.containerCount = LWebAudio.container.length;	
						data = LWebAudio.container.shift();	
					}	
				} else if (typeof webkitAudioContext !== UNDEFINED) {	
					try {	
						data = new webkitAudioContext();	
					} catch (e) {	
						LWebAudio.containerCount = LWebAudio.container.length;	
						data = LWebAudio.container.shift();	
					}	
				} else {	
					throw "AudioContext not supported. :(";	
				}	
			}	
			if(!data.createGainNode){	
				data.createGainNode = data.createGain;	
			}	
			LWebAudio.container.push(data);	
			return data;	
		},	
		onload : function (data) {	
			var s = this;	
			if (Object.prototype.toString.apply(data) !== '[object AudioBuffer]') {	
				s.load(data);	
				return;	
			};	
			if(!s.data){	
				s.data = s.getWebAudio();	
			}	
			s.buffer = data;	
			s.length = s.buffer.duration;	
			var e = new LEvent(LEvent.COMPLETE);	
			e.currentTarget = s;	
			e.target = s.buffer;	
			s.dispatchEvent(e);	
		},	
		_onended : function () {	
			var s = this;	
			s.dispatchEvent(LEvent.SOUND_COMPLETE);	
			s.close();	
			if (++s.loopIndex < s.loopLength) {	
				s.play(s.currentStart, undefined, s.currentTimeTo);	
			}	
		},	
		load : function (u) {	
			var s = this;	
			if (typeof u !== "string") {	
				if (Object.prototype.toString.apply(u) == '[object AudioBuffer]') {	
					s.onload(u);	
				} else if (Object.prototype.toString.apply(u) == '[object ArrayBuffer]') {	
					if(!s.data){	
						s.data = s.getWebAudio();	
					}	
					s.data.decodeAudioData(u, s.onload.bind(s), function (error) {	
						throw "AudioContext decodeAudioData error : " + error.toString();	
					});	
				}	
				return;	
			}	
			var a, b, c, k, d, q = {"mov" : ["quicktime"], "3gp" : ["3gpp"], "midi" : ["midi"], "mid" : ["midi"], "ogv" : ["ogg"], "m4a" : ["acc"], "mp3" : ["mpeg"], "wav" : ["wav", "x-wav", "wave"], "wave" : ["wav", "x-wav", "wave"], "aac" : ["mp4", "aac"]};	
			a = u.split(',');	
			for (k = 0; k < a.length; k++) {	
				b = a[k].split('.');	
				d = b[b.length - 1];	
				if (q[d]) {	
					d = q[d];	
				} else {	
					d = [d];	
				}	
				c = d.some(function (element, index, array) {	
					return LWebAudio.audioTag.canPlayType(s._type + "/" + element);	
				});	
				if (c) {	
					LAjax.responseType = LAjax.ARRAY_BUFFER;	
					LAjax.get(a[k], {}, s.onload.bind(s));	
					return;	
				} else {	
					console.warn( "Not support " + b[b.length - 1] + " : " + a[k]);	
					var e = new LEvent(LEvent.COMPLETE);	
					e.currentTarget = e.target = s;	
					s.dispatchEvent(e);	
				}	
			}	
		},	
		getCurrentTime : function () {	
			var s = this;	
			if (s.playing) {	
				return s.data.currentTime - s.currentSave + s.currentTime;	
			} else {	
				return s.currentSave;	
			}	
		},	
		setVolume : function (v) {	
			var s = this;	
			s.volume = v;	
			if (s.playing) {	
				s.volumeNode.gain.value = v;	
			}	
		},	
		getVolume : function () {	
			return this.volume;	
		},	
		play : function (c, l, to) {	
			var s = this;	
			if (s.length == 0) {	
				return;	
			}	
			if (typeof l !== UNDEFINED) {	
				s.loopIndex = 0;	
				s.loopLength = l;	
			}	
			if (typeof c !== UNDEFINED) {	
				s.currentTime = c;	
				s.currentStart = c;	
			}	
			if (typeof to !== UNDEFINED) {	
				s.currentTimeTo = to > s.length ? s.length : to;	
			} else {	
				s.currentTimeTo = s.length;	
			}	
			s.data.loop = false;	
			s.playing = true;	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			s.timeout = setTimeout(s._onended.bind(s), (s.currentTimeTo - s.currentTime) * 1000);	
			s.bufferSource = s.data.createBufferSource();	
			s.bufferSource.buffer = s.buffer;	
			s.volumeNode = s.data.createGainNode();	
			s.volumeNode.gain.value = s.volume;	
			s.volumeNode.connect(s.data.destination);	
			s.bufferSource.connect(s.volumeNode);	
			s.currentSave = s.data.currentTime;	
			if (s.bufferSource.start) {	
				s.bufferSource.start(0, s.currentTime, s.length - s.currentTime);	
			} else {	
				s.bufferSource.noteGrainOn(0, s.currentTime, s.length - s.currentTime);	
			}	
		},	
		playSegment : function (c, seg, l) {	
			this.playTo(c, c + seg, l);	
		},	
		playTo : function (c, to, l) {	
			this.play(c, l, to);	
		},	
		stop : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			if (s.bufferSource.stop) {	
				s.bufferSource.stop(0);	
			} else {	
				s.bufferSource.noteOff(0);	
			}	
			s.currentSave = s.getCurrentTime();	
			s.currentTime = s.currentSave;	
			s.playing = false;	
		},	
		close : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			if (s.bufferSource.stop) {	
				s.bufferSource.stop(0);	
			} else {	
				s.bufferSource.noteOff(0);	
			}	
			s.playing = false;	
			s.currentTime = 0;	
			s.currentSave = 0;	
		},	
		ll_check : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if (s.currentTimeTo < s.data.currentTime - s.currentSave + LSound.Container.time * 0.001) {	
				s._onended();	
			}	
		},	
		die : function () {	
			LSound.Container.remove(this);	
		}	
	};	
	for (var k in p) {	
		LWebAudio.prototype[k] = p[k];	
	}	
	return LWebAudio;	
})();	
var LMedia = (function () {	
	function LMedia () {	
		var s = this;	
		LExtends(s, LDisplayObject, []);	
		s.length = 0;	
		s.loopIndex = 0;	
		s.loopLength = 1;	
		s.playing = false;	
		s.oncomplete = null;	
		s.onsoundcomplete = null;	
		s.currentStart = 0;	
		LSound.Container.add(this);	
	}	
	var p = {	
		onload : function () {	
			var s = this;	
			if (s.data.readyState) {	
				s.length = s.data.duration - (LGlobal.android ? 0.1 : 0);	
				var e = new LEvent(LEvent.COMPLETE);	
				e.currentTarget = s;	
				e.target = s.data;	
				s.dispatchEvent(e);	
				return;	
			}	
			s.data.addEventListener("canplaythrough", function () {	
				s.onload();	
			}, false);	
		},	
		_onended : function () {	
			var s = this, i, l;	
			s.dispatchEvent(LEvent.SOUND_COMPLETE);	
			if (++s.loopIndex < s.loopLength) {	
				i = s.loopIndex;	
				l = s.loopLength;	
				s.close();	
				s.play(s.currentStart, s.loopLength, s.currentTimeTo);	
				s.loopIndex = i;	
			} else {	
				s.close();	
			}	
		},	
		load : function (u) {	
			var s = this;	
			if (Object.prototype.toString.apply(u) == "[object HTMLAudioElement]") {	
				s.data = u;	
				s.onload();	
				return;	
			}	
			var a, b, c, k, d, q = {"mov" : ["quicktime"], "3gp" : ["3gpp"], "midi" : ["midi"], "mid" : ["midi"], "ogv" : ["ogg"], "m4a" : ["acc"], "mp3" : ["mpeg"], "wav" : ["wav", "x-wav", "wave"], "wave" : ["wav", "x-wav", "wave"], "aac" : ["mp4", "aac"]};	
			a = u.split(',');	
			for (k = 0; k < a.length; k++) {	
				b = a[k].split('.');	
				d = b[b.length - 1];	
				if (q[d]) {	
					d = q[d];	
				} else {	
					d = [d];	
				}	
				c = d.some(function (element, index, array) {	
					return s.data.canPlayType(s._type + "/" + element);	
				});	
				if (c) {	
					s.data.src = a[k];	
					s.onload();	
					s.data.load();	
					return;	
				} else {	
					console.warn( "Not support " + b[b.length - 1] + " : " + a[k]);	
					var e = new LEvent(LEvent.COMPLETE);	
					e.currentTarget = e.target = s;	
					s.dispatchEvent(e);	
				}	
			}	
			if (s.oncomplete) {	
				s.oncomplete({});	
			}	
		},	
		getCurrentTime : function () {	
			return this.data.currentTime;	
		},	
		setVolume : function (v) {	
			this.data.volume = v;	
		},	
		getVolume : function () {	
			return this.data.volume;	
		},	
		play : function (c, l, to) {	
			var s = this;	
			if (s.length == 0) {	
				return;	
			}	
			if (LGlobal.android) {	
				LSound.Container.stopOther(this);	
			}	
			if (typeof c != UNDEFINED) {	
				s.data.currentTime = c;	
				s.currentStart = c;	
			}	
			if (typeof l != UNDEFINED) {	
				s.loopLength = l;	
			}	
			if (typeof to !== UNDEFINED) {	
				s.currentTimeTo = to > s.length ? s.length : to;	
			} else {	
				s.currentTimeTo = s.length;	
			}	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			s.timeout = setTimeout(function(){	
				s._onended();	
			}, (s.currentTimeTo - s.data.currentTime) * 1000);	
			s.data.loop = false;	
			s.loopIndex = 0;	
			s.playing = true;	
			s.data.play();	
		},	
		playSegment : function (c, seg, l) {	
			this.playTo(c, c + seg, l);	
		},	
		playTo : function (c, to, l) {	
			this.play(c, l, to);	
		},	
		stop : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			s.playing = false;	
			s.data.pause();	
		},	
		close : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if (s.timeout) {	
				clearTimeout(s.timeout);	
				delete s.timeout;	
			}	
			s.playing = false;	
			s.data.pause();	
			s.data.currentTime = 0;	
			s.currentSave = 0;	
		},	
		ll_check : function () {	
			var s = this;	
			if (!s.playing) {	
				return;	
			}	
			if(s.data.duration != s._ll_duration){	
				s._ll_duration = s.data.duration;	
				s.length = s.data.duration - (LGlobal.android ? 0.1 : 0);	
			}	
			if (s.currentTimeTo < s.data.currentTime + LSound.Container.time * 0.005) {	
				s._onended();	
			}	
		},	
		die : function () {	
			LSound.Container.remove(this);	
		}	
	};	
	for (var k in p) {	
		LMedia.prototype[k] = p[k];	
	}	
	return LMedia;	
})();	
var LSound = (function () {	
	function LSound (u) {	
		var s = this;	
		s.type = "LSound";	
		s._type="audio";	
		if (LSound.webAudioEnabled && LGlobal.webAudio) {	
			LExtends(s, LWebAudio, []);	
		} else {	
			LExtends(s, LMedia, []);	
			s.data = new Audio();	
			s.data.loop = false;	
			s.data.autoplay = false;	
		}	
		if (u) {	
			s.load(u);	
		}	
	}	
	LSound.TYPE_SOUND = "sound";	
	LSound.webAudioEnabled = false;	
	var protocol = location.protocol;	
	if (protocol == "http:" || protocol == "https:") {	
		if (typeof AudioContext !== UNDEFINED) {	
			try {	
				LWebAudio._context = new AudioContext();	
			} catch (e) {	
			}	
		} else if (typeof webkitAudioContext !== UNDEFINED) {	
			try {	
				LWebAudio._context = new webkitAudioContext();	
			} catch (e) {	
			}	
		}	
		if (LWebAudio._context) {	
			LWebAudio.container.push(LWebAudio._context);	
			LSound.webAudioEnabled = true;	
		}	
	}	
	LSound.Container = {	
		ll_save : 0,	
		time : 0,	
		list : [],	
		ll_show : function () {	
			var c = LSound.Container;	
			var t = (new Date()).getTime();	
			c.time = t - (c.ll_save ? c.ll_save : t);	
			c.ll_save = t;	
			var l = c.list;	
			for (var i = l.length - 1; i >= 0; i--) {	
				if (l[i]) {	
					l[i].ll_check();	
				}	
			}	
		},	
		add : function (obj) {	
			if (LSound.Container.list.indexOf(obj) >= 0) {	
				return;	
			} 	
			LSound.Container.list.push(obj);	
		},	
		remove : function (obj) {	
			var l = LSound.Container.list;	
			for (var i = l.length -1; i >= 0; i--) {	
				if (l[i].objectIndex == obj.objectIndex) {	
					l.splice(i,1);	
					break;	
				}	
			}	
		},	
		stopOther : function (obj) {	
			var l = LSound.Container.list;	
			for (var i = l.length - 1; i >= 0; i--) {	
				if (l[i].objectIndex != obj.objectIndex) {	
					l[i].stop();	
				}	
			}	
		}	
	};	
	LGlobal.childList.push(LSound.Container);	
	return LSound;	
})();	
var LVideo = (function () {	
	function LVideo (u) {	
		var s = this;	
		LExtends(s, LMedia, []);	
		s.type = "LVideo";	
		s._type = "video";	
		s.rotatex = 0;	
		s.rotatey = 0;	
		s.data = document.createElement("video");	
		s.data.style.display = "none";	
		document.body.appendChild(s.data);	
		s.data.id = "video_" + s.objectIndex;	
		s.data.loop = false;	
		s.data.autoplay = false;	
		if (u) {	
			s.load(u);	
		}	
	}	
	var p = {	
		_ll_show : function (c) {	
			var s = this;	
			c.drawImage(s.data, s.x, s.y);	
		},	
		die : function () {	
			var s = this;	
			document.body.removeChild(s.data);	
			delete s.data;	
		},	
		getWidth : function () {	
			return this.data.width;	
		},	
		getHeight : function () {	
			return this.data.height;	
		}	
	};	
	for (var k in p) {	
		LVideo.prototype[k] = p[k];	
	}	
	return LVideo;	
})();	
var LPoint = (function () {	
	function LPoint (x, y) {	
		var s = this;	
		s.x = x;	
		s.y = y;	
	}	
	LPoint.distance = function (p1, p2) {	
		return LPoint.distance2(p1.x, p1.y, p2.x, p2.y);	
	};	
	LPoint.distance2 = function (x1, y1, x2, y2) {	
		var x = x1 - x2, y = y1 - y2;	
		return Math.sqrt(x * x + y * y);	
	};	
	LPoint.interpolate = function (p1, p2, f) {	
		return new LPoint(p1.x + (p2.x - p1.x) * (1 - f), p1.y + (p2.y - p1.y) * (1 - f));	
	};	
	LPoint.polar = function (l, a) {	
		return new LPoint(l * Math.cos(a), l * Math.sin(a));	
	};	
	LPoint.prototype = {	
		toString : function () {	
			return '[object LPoint(' + this.x + ',' + this.y + ')]';	
		},	
		length : function () {	
			return LPoint.distance2(this.x, this.y, 0, 0);	
		},	
		add : function (v) {	
			return LPoint(this.x + v.x, this.y + v.y);	
		},	
		clone : function () {	
			return new LPoint(this.x, this.y);	
		},	
		setTo : function (x, y) {	
			this.x = x, this.y = y;	
		},	
		copyFrom : function (s) {	
			this.setTo(s.x, s.y);	
		},	
		equals : function (t) {	
			return this.x == t.x && this.y == t.y;	
		},	
		normalize : function (t) {	
			var s = this, scale = t / s.length();	
			s.x *= scale, s.y *= scale;	
		},	
		offset : function (dx, dy) {	
			this.x += dx;	
			this.y += dy;	
		},	
		subtract : function (v) {	
			return new LPoint(this.x  - v.x, this.y - v.y);	
		}	
	};	
	return LPoint;	
})();	
var LRectangle = (function () {	
	function LRectangle (x, y, w, h) {	
		var s = this;	
		s.x = x;	
		s.y = y;	
		s.width = w;	
		s.height = h;	
		s.setRectangle();	
	}	
	LRectangle.prototype = {	
		setRectangle : function () {	
			var s = this;	
			s.bottom = s.y + s.height;	
			s.right = s.x + s.width;	
			s.left = s.x;	
			s.top = s.y;	
		},	
		clone : function () {	
			var s = this;	
			return new LRectangle(s.x, s.y, s.width, s.height);	
		},	
		contains : function (x, y) {	
			var s = this;	
			return x >= s.x && x <= s.right && y >= s.y && y <= s.bottom;	
		},	
		containsRect : function (rect) {	
			var s = this;	
			return rect.x >= s.x && rect.right <= s.right && rect.y >= s.y && rect.bottom <= s.bottom;	
		},	
		equals : function (v) {	
			var s = this;	
			return v.x == s.x && v.width == s.width && v.y == s.y && v.height == s.height;	
		},	
		inflate : function (dx, dy) {	
			var s = this;	
			s.width += dx;	
			s.height += dy;	
			s.setRectangle();	
		},	
		intersection : function (t) {	
			var s = this;	
			var ix = s.x > t.x ? s.x : t.x;	
			var iy = s.y > t.y ? s.y : t.y;	
			var ax = s.right > t.right ? t.right : s.right;	
			var ay = s.bottom > t.bottom ? t.bottom : s.bottom;	
			if (ix <= ax && iy <= ay) {	
				return new LRectangle(ix, iy, ax, ay);	
			}else{	
				return new LRectangle(0, 0, 0, 0);	
			}	
		},	
		intersects : function (t) {	
			var s = this;	
			var ix = s.x > t.x ? s.x : t.x;	
			var iy = s.y > t.y ? s.y : t.y;	
			var ax = s.right > t.right ? t.right : s.right;	
			var ay = s.bottom > t.bottom ? t.bottom : s.bottom;	
			return ix <= ax && iy <= ay;	
		},	
		isEmpty : function () {	
			var s = this;	
			return s.x == 0 && s.y == 0 && s.width == 0 && s.height == 0;	
		},	
		offset : function (dx, dy) {	
			var s = this;	
			s.x += dx;	
			s.y += dy;	
			s.setRectangle();	
		},	
		setEmpty : function () {	
			var s = this;	
			s.x = 0;	
			s.y = 0;	
			s.width = 0;	
			s.height = 0;	
			s.setRectangle();	
		},	
		setTo : function (xa, ya, w, h) {	
			var s = this;	
			s.x = xa;	
			s.y = ya;	
			s.width = w;	
			s.height = h;	
			s.setRectangle();	
		},	
		toString : function () {	
			var s = this;	
			return "[object LRectangle(" + s.x + "," + s.y + "," + s.width + "," + s.height + ")]";	
		},	
		union : function (t) {	
			var s = this;	
			return new LRectangle(s.x > t.x ? t.x : s.x, s.y > t.y ? t.y : s.y, s.right > t.right ? s.right : t.right, s.bottom > t.bottom ? s.bottom : t.bottom);	
		}	
	};	
	return LRectangle;	
})();	
var LGraphics = (function () {	
	function LGraphics(){	
		var s = this;	
		LExtends(s, LObject, []);	
		s.type = "LGraphics";	
		s.color = "#000000";	
		s.alpha = 1;	
		s.bitmap = null;	
		s.setList = new Array();	
		s.showList = new Array();	
	}	
	var p = {	
		ll_show : function () {	
			var s = this, k, l = s.setList.length;	
			if (l == 0) {	
				return;	
			}	
			for (k = 0; k < l; k++) {	
				s.setList[k]();	
				if (LGlobal.fpsStatus) {	
					LGlobal.fpsStatus.graphics++;	
				}	
			}	
		},	
		clone : function () {	
			var s = this, a = new LGraphics(), i, l, c;	
			a.color = s.color;	
			a.alpha = s.alpha;	
			a.bitmap = s.bitmap;	
			for (i = 0, l = s.setList.length; i < l; i++) {	
				c = s.setList[i];	
				a.setList.push(c);	
			}	
			for (i = 0, l = s.showList.length; i < l; i++) {	
				c = s.showList[i];	
				a.showList.push(c);	
			}	
			return a;	
		},	
		lineCap : function (t) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.lineCap = t;	
			});	
		},	
		lineJoin : function (t) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.lineJoin = t;	
			});	
		},	
		lineWidth : function (t) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.lineWidth = t;	
			});	
		},	
		strokeStyle : function (co) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.strokeStyle = co;	
			});	
		},	
		stroke : function () {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.stroke();	
			});	
		},	
		beginPath : function () {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.beginPath();	
			});	
		},	
		closePath : function () {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.closePath();	
			});	
		},	
		moveTo : function (x, y) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.moveTo(x, y);	
			});	
			s.showList.push({type : LShape.POINT, arg : [x, y]});	
		},	
		lineTo : function (x, y) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.lineTo(x, y);	
			});	
			s.showList.push({type : LShape.POINT, arg : [x, y]});	
		},	
		rect : function (x, y, w, h) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.rect(x, y, w, h);	
			});	
			s.showList.push({type : LShape.RECT, arg : [x, y, w, h]});	
		},	
		fillStyle : function (co) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.fillStyle = co;	
			});	
		},	
		fill : function () {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.fill();	
			});	
		},	
		arc : function (x, y, r, sa, ea, aw) {	
			var s = this;	
			s.setList.push(function () {	
				LGlobal.canvas.arc(x, y, r, sa, ea, aw);	
			});	
			s.showList.push({type : LShape.ARC, arg : sa});	
		},	
		lineStyle : function (tn, co) {	
			var s = this, c;	
			if (co == null) {	
				co = s.color;	
			}	
			s.color = co;	
			s.setList.push(function () {	
				c = LGlobal.canvas;	
				c.lineWidth = tn;	
				c.strokeStyle = co;	
			});	
		},	
		clear : function () {	
			var s = this;	
			s.bitmap = null;	
			s.setList.length = 0;	
			s.showList.length = 0;	
		},	
		beginBitmapFill : function (b) {	
			var s = this;	
			s.setList.push(function () {	
				s.bitmap = b;	
			});	
		},	
		drawEllipse : function (tn, lco, pa, isf, co) {	
			var s = this;	
			s.setList.push(function () {	
				var c, x, y, w, h, k, ox, oy, xe, ye, xm, ym;	
				c = LGlobal.canvas;	
				c.beginPath();	
				k = 0.5522848;	
				x = pa[0];	
				y = pa[1];	
				w = pa[2];	
				h = pa[3];	
				ox = (w / 2) * k;	
				oy = (h / 2) * k;	
				xe = x + w;	
				ye = y + h;	
				xm = x + w / 2;	
				ym = y + h / 2;	
				c.moveTo(x, ym);	
				c.bezierCurveTo(x, ym - oy, xm - ox, y, xm, y);	
				c.bezierCurveTo(xm + ox, y, xe, ym - oy, xe, ym);	
				c.bezierCurveTo(xe, ym + oy, xm + ox, ye, xm, ye);	
				c.bezierCurveTo(xm - ox, ye, x, ym + oy, x, ym);	
				if (s.bitmap) {	
					c.save();	
					c.clip();	
					c.drawImage(s.bitmap.image,	
							s.bitmap.x, s.bitmap.y, s.bitmap.width, s.bitmap.height,	
							0, 0, s.bitmap.width, s.bitmap.height);	
					c.restore(); 	
					s.bitmap = null;	
					return;	
				}	
				if (isf) {	
					c.fillStyle = co;	
					c.fill();	
				}	
				if (tn > 0) {	
					c.lineWidth = tn;	
					c.strokeStyle = lco;	
					c.stroke();	
				}	
			});	
			s.showList.push({type : LShape.RECT, arg : pa});	
		},	
		drawArc : function (tn, lco, pa, isf, co) {	
			var s = this;	
			s.setList.push(function () {	
				var c = LGlobal.canvas;	
				c.beginPath();	
				if (pa.length > 6 && pa[6]) {	
					c.moveTo(pa[0], pa[1]);	
				}	
				c.arc(pa[0], pa[1], pa[2], pa[3], pa[4], pa[5]);	
				if (pa.length > 6 && pa[6]) {	
					c.lineTo(pa[0], pa[1]);	
				}	
				if (s.bitmap) {	
					c.save();	
					c.clip();	
					c.drawImage(s.bitmap.image,	
							s.bitmap.x, s.bitmap.y, s.bitmap.width, s.bitmap.height,	
							0, 0, s.bitmap.width, s.bitmap.height);	
					c.restore(); 	
					s.bitmap = null;	
					return;	
				}	
				if (isf) {	
					c.fillStyle = co;	
					c.fill();	
				}	
				if (tn > 0) {	
					c.lineWidth = tn;	
					c.strokeStyle = lco;	
					c.stroke();	
				}	
			});	
			s.showList.push({type : LShape.ARC, arg : pa});	
		},	
		drawRect : function (tn, lco, pa, isf, co) {	
			var s = this;	
			s.setList.push(function () {	
				var c = LGlobal.canvas;	
				c.beginPath();	
				c.rect(pa[0], pa[1], pa[2], pa[3]);	
				c.closePath();	
				if (s.bitmap) {	
					c.save();	
					c.clip();	
					c.drawImage(s.bitmap.image,	
							s.bitmap.x, s.bitmap.y,	
							s.bitmap.width, s.bitmap.height,	
							0, 0,	
							s.bitmap.width, s.bitmap.height);	
					c.restore(); 	
					s.bitmap = null;	
					return;	
				}	
				if (isf) {	
					c.fillStyle = co;	
					c.fill();	
				}	
				if (tn > 0) {	
					c.lineWidth = tn;	
					c.strokeStyle = lco;	
					c.stroke();	
				}	
			});	
			s.showList.push({type : LShape.RECT, arg : pa});	
		},	
		drawRoundRect : function (tn, lco, pa, isf, co) {	
			var s = this;	
			s.setList.push(function () {	
				var c = LGlobal.canvas;	
				c.beginPath();	
				c.moveTo(pa[0] + pa[4], pa[1]);	
				c.lineTo(pa[0] + pa[2] - pa[4], pa[1]);	
				c.arcTo(pa[0] + pa[2], pa[1], pa[0] + pa[2], pa[1] + pa[4], pa[4]);	
				c.lineTo(pa[0] + pa[2], pa[1] + pa[3] - pa[4]);	
				c.arcTo(pa[0] + pa[2], pa[1] + pa[3], pa[0] + pa[2] - pa[4], pa[1] + pa[3], pa[4]);	
				c.lineTo(pa[0] + pa[4], pa[1] + pa[3]);	
				c.arcTo(pa[0], pa[1] + pa[3], pa[0], pa[1] + pa[3] - pa[4], pa[4]);	
				c.lineTo(pa[0], pa[1] + pa[4]);	
				c.arcTo(pa[0], pa[1], pa[0] + pa[4], pa[1], pa[4]);	
				c.closePath();	
				if (s.bitmap) {	
					c.save();	
					c.clip();	
					c.drawImage(s.bitmap.image,	
							0, 0,	
							s.bitmap.width, s.bitmap.height,	
							0, 0,	
							s.bitmap.width, s.bitmap.height);	
					c.restore(); 	
					s.bitmap = null;	
					return;	
				}	
				if (isf) {	
					c.fillStyle = co;	
					c.fill();	
				}	
				if (tn > 0) {	
					c.lineWidth = tn;	
					c.strokeStyle = lco;	
					c.stroke();	
				}	
			});	
			s.showList.push({type : LShape.RECT, arg : pa});	
		},	
		drawVertices : function (tn, lco, v, isf, co) {	
			var s = this;	
			if (v.length < 3) {	
				return;	
			}	
			s.setList.push(function () {	
				var c = LGlobal.canvas;	
				c.beginPath();	
				c.moveTo(v[0][0], v[0][1]);	
				var i, l = v.length, pa;	
				for (i = 1; i < l; i++) {	
					pa = v[i];	
					c.lineTo(pa[0], pa[1]);	
				}	
				c.lineTo(v[0][0], v[0][1]);	
				c.closePath();	
				if (s.bitmap) {	
					c.save();	
					c.clip();	
					c.drawImage(s.bitmap.image,	
							s.bitmap.x, s.bitmap.y, s.bitmap.width, s.bitmap.height,	
							0, 0, s.bitmap.width, s.bitmap.height);	
					c.restore(); 	
					s.bitmap = null;	
					return;	
				}	
				if (isf) {	
					c.fillStyle = co;	
					c.fill();	
				}	
				if (tn > 0) {	
					c.lineWidth = tn;	
					c.strokeStyle = lco;	
					c.closePath();	
					c.stroke();	
				}	
			});	
			s.showList.push({type : LShape.VERTICES, arg : v});	
		},	
		drawTriangles : function (ve, ind, u, tn, lco) {	
			var s = this;	
			var i, j, l = ind.length, c;	
			s.setList.push(function () {	
				c = LGlobal.canvas;	
				var v = ve, a, k, sw;	
				for (i = 0, j = 0; i < l; i += 3) {	
					a = 0;	
					c.save();	
					c.beginPath();	
					c.moveTo(v[ind[i] * 2], v[ind[i] * 2 + 1]);	
					c.lineTo(v[ind[i + 1] * 2], v[ind[i + 1] * 2 + 1]);	
					c.lineTo(v[ind[i + 2] * 2], v[ind[i + 2] * 2 + 1]);	
					c.lineTo(v[ind[i] * 2], v[ind[i] * 2 + 1]);	
					c.closePath();	
					if (tn) {	
						c.lineWidth = tn;	
						c.strokeStyle = lco;	
						c.stroke();	
					}	
					c.clip();	
					if (i % 6 == 0) {	
						sw = -1;	
						var w = (u[ind[i + 1 + j] * 2] - u[ind[i + j] * 2]) * s.bitmap.width;	
						var h = (u[ind[i + 2] * 2 + 1] - u[ind[i] * 2 + 1]) * s.bitmap.height;	
						if (j == 0 && w < 0) {	
							for (k = i + 9; k < l; k += 3) {	
								if (u[ind[i + 2] * 2 + 1] == u[ind[k + 2] * 2 + 1]) {	
									j = k - i;	
									break;	
								}	
							}	
							if (j == 0) {	
								j = l - i;	
							}	
							w = (u[ind[i + 1 + j] * 2] - u[ind[i + j] * 2]) * s.bitmap.width;	
						}	
						if (i + j >= l) {	
							w = (u[ind[i + j - l] * 2] - u[ind[i + 1] * 2]) * s.bitmap.width;	
							sw = u[ind[i] * 2] == 1 ? 0 : s.bitmap.width * u[ind[i] * 2] + w;	
							if (sw > s.bitmap.width) {	
								sw -= s.bitmap.width;	
							}	
						} else {	
							sw = s.bitmap.width * u[ind[i + j] * 2];	
						}	
						sh = s.bitmap.height * u[ind[i] * 2 + 1];	
						if (h < 0) {	
							h = (u[ind[i + 2 - (i > 0 ? 6 : -6)] * 2 + 1] - u[ind[i - (i > 0 ? 6 : -6)] * 2 + 1]) * s.bitmap.height;	
							sh = 0;	
						}	
						var t1 = (v[ind[i + 1] * 2] - v[ind[i] * 2]) / w;	
						var t2 = (v[ind[i + 1] * 2 + 1] - v[ind[i] * 2 + 1]) / w;	
						var t3 = (v[ind[i + 2] * 2] - v[ind[i] * 2]) / h;	
						var t4 = (v[ind[i + 2] * 2 + 1] - v[ind[i] * 2 + 1]) / h;	
						c.transform(t1, t2, t3, t4, v[ind[i] * 2], v[ind[i] * 2 + 1]);	
						c.drawImage(s.bitmap.image,	
									s.bitmap.x + sw,	
									s.bitmap.y + sh,	
									w, h,	
									0, 0,	
									w, h);	
					} else {	
						var w = (u[ind[i + 2 + j] * 2] - u[ind[i + 1 + j] * 2]) * s.bitmap.width;	
						var h = (u[ind[i + 2] * 2 + 1] - u[ind[i] * 2 + 1]) * s.bitmap.height;	
						if (j == 0 && w < 0) {	
							for (k = i + 9; k < l; k += 3) {	
								if (u[ind[i + 2] * 2 + 1] == u[ind[k + 2] * 2 + 1]) {	
									j = k - i;	
									break;	
								}	
							}	
							if (j == 0) {	
								j = l - i;	
							}	
							w = (u[ind[i + 2 + j] * 2] - u[ind[i + 1 + j] * 2]) * s.bitmap.width;	
						}	
						if (i + 1 + j >= l) {	
							w = (u[ind[i + 1 + j - l] * 2] - u[ind[i + 2] * 2]) * s.bitmap.width;	
							sw = u[ind[i + 1] * 2] == 1 ? 0 : s.bitmap.width * u[ind[i + 1] * 2] + w;	
							if (sw > s.bitmap.width) {	
								sw -= s.bitmap.width;	
							}	
						} else {	
							sw = s.bitmap.width * u[ind[i + 1 + j] * 2];	
						}	
						sh = s.bitmap.height * u[ind[i] * 2 + 1];	
						if (h < 0) {	
							h = (u[ind[i + 2 - (i > 0 ? 6 : -6)] * 2 + 1] - u[ind[i - (i > 0 ? 6 : -6)] * 2 + 1]) * s.bitmap.height;	
							sh = 0;	
						}	
						var t1 = (v[ind[i + 2] * 2] - v[ind[i + 1] * 2]) / w;	
						var t2 = (v[ind[i + 2] * 2 + 1] - v[ind[i + 1] * 2 + 1]) / w;	
						var t3 = (v[ind[i + 2] * 2] - v[ind[i] * 2]) / h;	
						var t4 = (v[ind[i + 2] * 2 + 1] - v[ind[i] * 2 + 1]) / h;	
						c.transform(t1, t2, t3, t4, v[ind[i + 1] * 2], v[ind[i + 1] * 2 + 1]);	
						c.drawImage(s.bitmap.image,	
								s.bitmap.x + sw,	
								s.bitmap.y + sh,	
								w, h,	
								0, -h,	
								w, h);	
					}	
					c.restore();	
				}	
			});	
		},	
		drawLine : function (tn, lco, pa) {	
			var s = this;	
			s.setList.push(function () {	
				var c = LGlobal.canvas;	
				c.beginPath();	
				c.moveTo(pa[0], pa[1]);	
				c.lineTo(pa[2], pa[3]);	
				c.lineWidth = tn;	
				c.strokeStyle = lco;	
				c.closePath();	
				c.stroke();	
			});	
			s.showList.push({type : LShape.LINE, arg : pa});	
		},	
		add : function (f) {	
			this.setList.push(f);	
		},	
		ismouseon : function (e, co) {	
			var s = this;	
			if (e == null || e == UNDEFINED || s.showList.length == 0 || !s.parent) {	
				return false;	
			}	
			return s.parent.ismouseonShapes(s.showList, e.offsetX, e.offsetY);	
		},	
		getWidth : function () {	
			var s = this, k, k1, min, max, v, l, l1;	
			for (k = 0, l = s.showList.length; k < l; k++) {	
				if (s.showList[k].type == LShape.RECT) {	
					if (min > s.showList[k].arg[0] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[0];	
					}	
					if (max < s.showList[k].arg[0] + s.showList[k].arg[2] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[0] + s.showList[k].arg[2];	
					}	
				} else if (s.showList[k].type == LShape.ARC) {	
					if (min > s.showList[k].arg[0] - s.showList[k].arg[2] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[0] - s.showList[k].arg[2];	
					}	
					if (max < s.showList[k].arg[0] + s.showList[k].arg[2] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[0] + s.showList[k].arg[2];	
					}	
				} else if (s.showList[k].type == LShape.VERTICES) {	
					for (k1 = 0, l1 = s.showList[k].arg.length; k1 < l1; k1++) {	
						v = s.showList[k].arg[k1];	
						if (min > v[0] || typeof min == UNDEFINED) {	
							min = v[0];	
						}	
						if (max < v[0] || typeof max == UNDEFINED) {	
							max = v[0];	
						}	
					}	
				} else if (s.showList[k].type == LShape.LINE) {	
					if (min > s.showList[k].arg[0] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[0];	
					}	
					if (min > s.showList[k].arg[2] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[2];	
					}	
					if (max < s.showList[k].arg[0] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[0];	
					}	
					if (max < s.showList[k].arg[2] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[2];	
					}	
				} else if (s.showList[k].type == LShape.POINT) {	
					if (min > s.showList[k].arg[0] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[0];	
					}	
					if (max < s.showList[k].arg[0] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[0];	
					}	
				}	
			}	
			if (typeof min == UNDEFINED) {	
				min = max = 0;	
			}	
			s.left = min;	
			if (l > 0 && max == min) {	
				max = min + 1;	
			}	
			return max - min;	
		},	
		getHeight : function () {	
			var s = this, k = null, k1 = null, l, l1, min, max, v;	
			for (k = 0, l = s.showList.length; k < l; k++) {	
				if (s.showList[k].type == LShape.RECT) {	
					if (min > s.showList[k].arg[1] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[1];	
					}	
					if (max < s.showList[k].arg[1] + s.showList[k].arg[3] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[1] + s.showList[k].arg[3];	
					}	
				} else if (s.showList[k].type == LShape.ARC) {	
					if (min > s.showList[k].arg[1] - s.showList[k].arg[2] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[1] - s.showList[k].arg[2];	
					}	
					if (max < s.showList[k].arg[1] + s.showList[k].arg[2] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[1] + s.showList[k].arg[2];	
					}	
				} else if (s.showList[k].type == LShape.VERTICES) {	
					for (k1 = 0, l1 = s.showList[k].arg.length; k1 < l1; k1++) {	
						v = s.showList[k].arg[k1];	
						if (min > v[1] || typeof min == UNDEFINED) {	
							min = v[1];	
						}	
						if (max < v[1] || typeof max == UNDEFINED) {	
							max = v[1];	
						}	
					}	
				} else if (s.showList[k].type == LShape.LINE) {	
					if (min > s.showList[k].arg[1] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[1];	
					}	
					if (min > s.showList[k].arg[3] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[3];	
					}	
					if (max < s.showList[k].arg[1] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[1];	
					}	
					if (max < s.showList[k].arg[3] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[3];	
					}	
				} else if (s.showList[k].type == LShape.POINT) {	
					if (min > s.showList[k].arg[1] || typeof min == UNDEFINED) {	
						min = s.showList[k].arg[1];	
					}	
					if (max < s.showList[k].arg[1] || typeof max == UNDEFINED) {	
						max = s.showList[k].arg[1];	
					}	
				}	
			}	
			if (typeof min == UNDEFINED) {	
				min = max = 0;	
			}	
			s.top = min;	
			if (l > 0 && max == min) {	
				max = min + 1;	
			}	
			return max - min;	
		},	
		startX : function () {	
			var s = this;	
			s.getWidth();	
			return s.left;	
		},	
		startY : function () {	
			var s = this;	
			s.getHeight();	
			return s.top;	
		}	
	};	
	for (var k in p) {	
		LGraphics.prototype[k] = p[k];	
	}	
	return LGraphics;	
})();	
var LShape = (function () {	
	function LShape () {	
		var s = this;	
		LExtends(s, LInteractiveObject, []);	
		s.type = "LShape";	
		s.graphics = new LGraphics();	
		s.graphics.parent = s;	
	}	
	LShape.POINT = "point";	
	LShape.LINE = "line";	
	LShape.ARC = "arc";	
	LShape.RECT = "rect";	
	LShape.VERTICES = "vertices";	
	var p = {	
		_ll_show : function (c) {	
			var s = this;	
			s.graphics.ll_show();	
		},	
		getWidth : function (maskSize) {	
			var s = this, mx, mw,	
			left = s.graphics.startX(), right = left + s.graphics.getWidth();	
			if (maskSize && s.mask) {	
				mx = s.mask._startX ? s.mask._startX() : s.mask.startX();	
				mw = s.mask.getWidth();	
				if (left < mx) {	
					left = mx;	
				}	
				if (right > mx + mw) {	
					right = mx + mw;	
				}	
			}	
			s.ll_left = s.x + left;	
			s.ll_right = s.x + right;	
			return (right - left) * s.scaleX;	
		},	
		getHeight : function (maskSize) {	
			var s = this, my, mh,	
			top = s.graphics.startY(), bottom = top + s.graphics.getHeight();	
			if (maskSize && s.mask) {	
				my = s.mask._startY ? s.mask._startY() : s.mask.startY();	
				mh = s.mask.getHeight();	
				if (top < my) {	
					top = my;	
				}	
				if (bottom > my + mh) {	
					bottom = my + mh;	
				}	
			}	
			s.ll_top = s.y + top;	
			s.ll_bottom = s.y + bottom;	
			return (bottom - top) * s.scaleY;	
		},	
		_startX : function () {	
			var s = this;	
			s.getWidth();	
			return s.ll_left;	
		},	
		startX : function () {	
			var s = this;	
			return s._startX() * s.scaleX;	
		},	
		_startY : function () {	
			var s = this;	
			s.getHeight();	
			return s.ll_top;	
		},	
		startY : function () {	
			var s = this;	
			return s._startY() * s.scaleY;	
		},	
		clone : function () {	
			var s = this, a = new LShape(), c, o;	
			a.copyProperty(s);	
			a.graphics = s.graphics.clone();	
			a.graphics.parent = a;	
			return a;	
		},	
		ismouseon : function (e, cd) {	
			var s = this, i = false, sc;	
			if (!s.visible || e == null) {	
				return false;	
			}	
			if (s.mask) {	
				if (!s.mask.parent) {	
					s.mask.parent = s.parent;	
				}	
				if (!s.mask.ismouseon(e, cd)) {	
					return false;	
				}	
			}	
			sc = {x : s.x * cd.scaleX + cd.x, y : s.y * cd.scaleY + cd.y, scaleX : cd.scaleX * s.scaleX, scaleY : cd.scaleY * s.scaleY};	
			if (s.graphics) {	
				i = s.graphics.ismouseon(e, sc);	
			}	
			return i;	
		},	
		die : function () {	
			var s = this;	
			s.graphics.clear();	
		}	
	};	
	for (var k in p) {	
		LShape.prototype[k] = p[k];	
	}	
	return LShape;	
})();	
var LSprite = (function () {	
	function LSprite () {	
		var s = this;	
		LExtends(s, LDisplayObjectContainer, []);	
		s.type = "LSprite";	
		s.rotatex;	
		s.rotatey;	
		s.graphics = new LGraphics();	
		s.graphics.parent = s;	
		s.box2dBody = null;	
		s.shapes = new Array();	
		s.dragRange = null;	
	}	
	var p = {	
		setRotate : function (angle) {	
			var s = this;	
			if (s.box2dBody) {	
				s.box2dBody.SetAngle(angle);	
			} else {	
				s.rotate = angle;	
			}	
		},	
		_rotateReady : function () {	
			var s = this;	
			if (s.box2dBody) {	
				if ((typeof s.rotatex) == UNDEFINED) {	
					s.getRotateXY();	
				}	
				s.x = s.box2dBody.GetPosition().x * LGlobal.box2d.drawScale - s.parent.x - s.rotatex;	
				s.y = s.box2dBody.GetPosition().y * LGlobal.box2d.drawScale - s.parent.y - s.rotatey;	
				s.rotate = s.box2dBody.GetAngle();	
			}	
		},	
		_ll_show : function (c) {	
			var s = this;	
			s.graphics.ll_show();	
			LGlobal.show(s.childList);	
			s._ll_debugShape();	
		},	
		startDrag : function (touchPointID) {	
			var s = this, r, c;	
			if (s.ll_dragStart) {	
				return;	
			}	
			s.ll_touchPointID = touchPointID;	
			s.ll_dragStartX = s.x;	
			s.ll_dragStartY = s.y;	
			s.ll_dragMX = mouseX;	
			s.ll_dragMY = mouseY;	
			s.ll_dragStart = true;	
			LGlobal.dragList.push(s);	
		},	
		stopDrag : function () {	
			var s = this, i, l;	
			for (i = 0, l = LGlobal.dragList.length; i < l; i++) {	
				if (s.objectIndex == LGlobal.dragList[i].objectIndex) {	
					s.ll_dragStart = false;	
					LGlobal.dragList.splice(i, 1);	
					break;	
				}	
			}	
		},	
		getRotateXY : function (w, h) {	
			var s = this;	
			if (!w || !h) {	
				w = s.getWidth();	
				h = s.getHeight();	
			}	
			s.rotatex = w / 2;	
			s.rotatey = h / 2;	
		},	
		getWidth : function (maskSize) {	
			var s = this, i, l, o, a, b, mx, mw,	
			left = s.graphics.startX(), right = left + s.graphics.getWidth();	
			for (i = 0, l = s.childList.length; i < l; i++) {	
				o = s.childList[i];	
				if (typeof o.visible == UNDEFINED || !o.visible) {	
					continue;	
				}	
				a = o.x;	
				if (typeof o._startX == "function") {	
					a=o._startX();	
				}	
				b = a + o.getWidth(maskSize);	
				if (a < left) {	
					left = a;	
				}	
				if (b > right) {	
					right = b;	
				}	
			}	
			if (maskSize && s.mask) {	
				mx = s.mask._startX ? s.mask._startX() : s.mask.startX();	
				mw = s.mask.getWidth();	
				if (left < mx) {	
					left = mx;	
				}	
				if (right > mx + mw) {	
					right = mx + mw;	
				}	
			}	
			s.ll_left = s.x + left;	
			s.ll_right = s.x + right;	
			return (right - left) * s.scaleX;	
		},	
		getHeight : function (maskSize) {	
			var s = this, i, l, o, a, b, my, mh,	
			top = s.graphics.startY(), bottom = top + s.graphics.getHeight();	
			for (i = 0, l = s.childList.length; i < l; i++) {	
				o = s.childList[i];	
				if (typeof o.visible == UNDEFINED || !o.visible) {	
					continue;	
				}	
				a = o.y;	
				if (typeof o._startY == "function") {	
					a=o._startY();	
				}	
				b = a + o.getHeight(maskSize);	
				if (a < top) {	
					top = a;	
				}	
				if (b > bottom) {	
					bottom = b;	
				}	
			}	
			if (maskSize && s.mask) {	
				my = s.mask._startY ? s.mask._startY() : s.mask.startY();	
				mh = s.mask.getHeight();	
				if (top < my) {	
					top = my;	
				}	
				if (bottom > my + mh) {	
					bottom = my + mh;	
				}	
			}	
			s.ll_top = s.y + top;	
			s.ll_bottom = s.y + bottom;	
			return (bottom - top) * s.scaleY;	
		},	
		_startX : function () {	
			var s = this;	
			s.getWidth();	
			return s.ll_left;	
		},	
		startX : function () {	
			var s = this;	
			return s._startX() * s.scaleX;	
		},	
		_startY : function () {	
			var s = this;	
			s.getHeight();	
			return s.ll_top;	
		},	
		startY : function () {	
			var s = this;	
			return s._startY() * s.scaleY;	
		},	
		_ll_loopframe : function () {	
			this.dispatchEvent(LEvent.ENTER_FRAME);	
		},	
		clone : function () {	
			var s = this, a = new LSprite(), c, o, i, l;	
			a.copyProperty(s);	
			a.graphics = s.graphics.clone();	
			a.graphics.parent = a;	
			a.childList.length = 0;	
			for (i = 0, l = s.childList.length; i < l; i++) {	
				c = s.childList[i];	
				if (c.clone) {	
					o = c.clone();	
					o.parent = a;	
					a.childList.push(o);	
				}	
			}	
			return a;	
		},	
		_mevent : function (type) {	
			var s = this, k;	
			for (k = 0; k < s.mouseList.length; k++) {	
				var o = s.mouseList[k];	
				if (o.type == type) {	
					return true;	
				}	
			}	
			return false;	
		},	
		ll_dispatchMouseEvent : function (type, e, cd, ox, oy) {	
			var s = this;	
			if (!s.mouseEnabled) {	
				return;	
			}	
			for (k = 0; k < s.mouseList.length; k++) {	
				var o = s.mouseList[k];	
				if (o.type == type) {	
					e.selfX = (ox - (s.x * cd.scaleX + cd.x)) / (cd.scaleX * s.scaleX);	
					e.selfY = (oy - (s.y * cd.scaleY + cd.y)) / (cd.scaleY * s.scaleY);	
					e.currentTarget = e.clickTarget = s;	
					if (!e.target) {	
						e.target = s;	
					}	
					o.listener(e, s);	
				}	
			}	
		},	
		ll_mouseout : function (e, type, cd, ox, oy) {	
			var s = this;	
			if (type == LMouseEvent.MOUSE_MOVE && s.ll_mousein) {	
				s.ll_mousein = false;	
				if (s._mevent(LMouseEvent.MOUSE_OUT)) {	
					s.ll_dispatchMouseEvent(LMouseEvent.MOUSE_OUT, e, cd, ox, oy);	
				}	
				if (s.mouseChildren) {	
					for (var k = s.childList.length - 1; k >= 0; k--) {	
						if (s.childList[k].mouseEvent && s.childList[k].ll_mouseout) {	
							s.childList[k].ll_mouseout(e, type, cd, ox, oy);	
						}	
					}	
				}	
			}	
		},	
		mouseEvent : function (e, type, cd) {	
			if (!e) {	
				return false;	
			}	
			var s = this, i, k, ox = e.offsetX, oy = e.offsetY, on, mc;	
			if (!s.visible) {	
				return false;	
			}	
			if (cd == null) {	
				cd = {x : 0, y : 0, scaleX : 1, scaleY : 1};	
			}	
			on = s.ismouseon(e, cd);	
			if (on) {	
				if (type == LMouseEvent.MOUSE_MOVE && !s.ll_mousein) {	
					s.ll_mousein = true;	
					if (s._mevent(LMouseEvent.MOUSE_OVER)) {	
						s.ll_dispatchMouseEvent(LMouseEvent.MOUSE_OVER, e, cd, ox, oy);	
					}	
				}	
				if (s.mouseChildren) {	
					mc = {x : s.x * cd.scaleX + cd.x, y : s.y * cd.scaleY + cd.y, scaleX : cd.scaleX * s.scaleX, scaleY : cd.scaleY * s.scaleY};	
					for (k = s.childList.length - 1; k >= 0; k--) {	
						if (s.childList[k].mouseEvent) {	
							i = s.childList[k].mouseEvent(e, type, mc);	
							if (i) {	
								e.target = s.childList[k];	
								if (type != LMouseEvent.MOUSE_MOVE) {	
									break;	
								}	
							}	
						}	
					}	
					if (s._mevent(type)) {	
						s.ll_dispatchMouseEvent(type, e, cd, ox, oy);	
					}	
				}	
				return true;	
			} else {	
				s.ll_mouseout(e, type, cd, ox, oy);	
			}	
			return false;	
		},	
		hitTestPoint : function (x, y) {	
			var s = this, shapes = s.shapes;	
			if (!shapes || shapes.length == 0) {	
				s.getWidth();	
				s.getHeight();	
				shapes = [{"type" : LShape.RECT, "arg" : [s.ll_left - s.x, s.ll_top - s.y, s.ll_right - s.ll_left, s.ll_bottom - s.ll_top]}];	
			}	
			return s.ismouseonShapes(shapes, x, y);	
		},	
		hitTestObject : function (obj) {	
			var s = this, shapes = s.shapes, shapes1 = obj.shapes, m, m1, j, child, j1, child1, vo1, v1;	
			if (!shapes || shapes.length == 0) {	
				s.getWidth();	
				s.getHeight();	
				shapes = [{"type" : LShape.RECT, "arg" : [s.ll_left - s.x, s.ll_top - s.y, s.ll_right - s.ll_left, s.ll_bottom - s.ll_top]}];	
			}	
			if (!shapes1 || shapes1.length == 0) {	
				obj.getWidth();	
				obj.getHeight();	
				shapes1 = [{"type" : LShape.RECT, "arg" : [obj.ll_left - obj.x, obj.ll_top - obj.y, obj.ll_right - obj.ll_left, obj.ll_bottom - obj.ll_top]}];	
			}	
			m = s.getRootMatrix();	
			m1 = obj.getRootMatrix();	
			for (j = shapes.length - 1; j >= 0; j--) {	
				child = shapes[j];	
				v1 = s._changeShape(child.type, child.arg, m);	
				for (j1 = shapes1.length - 1; j1 >= 0; j1--) {	
					child1 = shapes1[j1];	
					vo1 = obj._changeShape(child1.type, child1.arg, m1);	
					if (child.type == LShape.VERTICES || child.type == LShape.RECT) {	
						if (child1.type == LShape.VERTICES || child1.type == LShape.RECT) {	
							if (LGlobal.hitTestPolygon(v1, vo1)) {	
								return true;	
							}	
						} else if (child1.type == LShape.ARC) {	
							if(LGlobal.hitTestPolygonArc(v1, vo1)) {	
								return true;	
							}	
						}	
					} else {	
						if (child1.type == LShape.VERTICES || child1.type == LShape.RECT) {	
							if (LGlobal.hitTestPolygonArc(vo1, v1)) {	
								return true;	
							}	
						} else if (child1.type == LShape.ARC) {	
							if (Math.sqrt((v1[0] - vo1[0]) * (v1[0] - vo1[0]) + (v1[1] - vo1[1]) * (v1[1] - vo1[1])) < v1[2] + vo1[2]) {	
								return true;	
							}	
						}	
					}	
				}	
			}	
			return false;	
		},	
		addShape : function (type, arg) {	
			var s = this;	
			if (type == LShape.VERTICES && arg.length < 3) {	
				return;	
			}	
			s.shapes.push({"type" : type, "arg" : arg});	
			return s.shapes;	
		},	
		addShapes : function (shapes) {	
			var s = this;	
			if(s.shapes.length == 0){	
				s.shapes = shapes;	
			}else{	
				s.shapes = s.shapes.concat(shapes);	
			}	
		},	
		clearShape : function () {	
			this.shapes = [];	
		},	
		_ll_debugShape : function () {	
			var s = this, i, l, child, c, arg, j, ll;	
			if (!LGlobal.traceDebug || s.shapes.length == 0) {	
				return;	
			}	
			for (i = 0, l = s.shapes.length; i < l; i++) {	
				child = s.shapes[i];	
				c = LGlobal.canvas;	
				arg = child.arg;	
				c.beginPath();	
				if (child.type == LShape.RECT) {	
					c.rect(arg[0], arg[1], arg[2], arg[3]);	
				}else if (child.type == LShape.ARC) {	
					c.arc(arg[0], arg[1], arg[2], 0, 2*Math.PI);	
				}else if (child.type == LShape.VERTICES) {	
					c.moveTo(arg[0][0], arg[0][1]);	
					for (j = 1, ll = arg.length; j < ll; j++) {	
						c.lineTo(arg[j][0], arg[j][1]);	
					};	
					c.lineTo(arg[0][0], arg[0][1]);	
				}	
				c.closePath();	
				c.strokeStyle = "#00FF00";	
				c.stroke();	
			}	
		},	
		ismouseon : function (e, cd) {	
			var s = this;	
			if (!s.visible || e==null) {	
				return false;	
			}	
			if (s.mask) {	
				if (!s.mask.parent) {	
					s.mask.parent = s.parent;	
				}	
				if (!s.mask.ismouseon(e, cd)) {	
					return false;	
				}	
			}	
			if(s.shapes && s.shapes.length > 0){	
				return s.ismouseonShapes(s.shapes, e.offsetX, e.offsetY);	
			}	
			var k, i = false, l = s.childList, sc = {x : s.x * cd.scaleX + cd.x, y : s.y * cd.scaleY + cd.y, scaleX : cd.scaleX * s.scaleX, scaleY : cd.scaleY * s.scaleY};	
			for (k = l.length - 1; k >= 0; k--) {	
				if (l[k].ismouseon) {	
					i = l[k].ismouseon(e, sc);	
				}	
				if (i) {	
					e.target = s.childList[k];	
					break;	
				}	
			}	
			if (!i) {	
				i = s.graphics.ismouseon(e, sc);	
			}	
			return i;	
		},	
		die : function () {	
			var s = this, i, c, l;	
			s.graphics.clear();	
			s.removeAllEventListener();	
			s.stopDrag();	
			if (s.box2dBody) {	
				s.clearBody();	
			}	
			for (i = 0, c = s.childList, l = c.length; i < l; i++) {	
				if (c[i].die) {	
					c[i].die();	
				}	
			}	
		}	
	};	
	for (var k in p) {	
		LSprite.prototype[k] = p[k];	
	}	
	return LSprite;	
})();	
var LButton = (function () {	
	function LButton (upState, overState, downState, disableState) {	
		var s = this;	
		LExtends(s, LSprite, []);	
		s.type = "LButton";	
		s.addChild(upState);	
		if (!overState) {	
			overState = upState;	
		} else {	
			s.addChild(overState);	
		}	
		if (!downState) {	
			downState = overState;	
		} else {	
			s.addChild(downState);	
		}	
		if (!disableState) {	
			disableState = upState;	
		} else {	
			s.addChild(disableState);	
		}	
		s.upState = s.bitmap_up = upState;	
		s.overState = s.bitmap_over = overState;	
		s.downState = downState;	
		s.disableState = disableState;	
		s._ll_down_sx = s.downState.scaleX;	
		s._ll_down_sy = s.downState.scaleY;	
		s.overState.visible = false;	
		s.downState.visible = false;	
		s.upState.visible = true;	
		s.buttonMode = true;	
		s.staticMode = false;	
		s._ll_cursorEnabled = true;	
		s.setState(LButton.STATE_ENABLE);	
		if (LMouseEventContainer.container[LMouseEvent.MOUSE_MOVE]) {	
			LMouseEventContainer.pushButton(s);	
		}	
		s.addEventListener(LMouseEvent.MOUSE_DOWN, s.ll_modeDown);	
	}	
	LButton.STATE_DISABLE = "disable";	
	LButton.STATE_ENABLE = "enable";	
	var p = {	
		setState : function (state) {	
			var s = this;	
			if (state == LButton.STATE_DISABLE) {	
				s.upState.visible = false;	
				s.overState.visible = false;	
				s.downState.visible = false;	
				s.disableState.visible = true;	
				s.mouseEnabled = false;	
			} else if (state == LButton.STATE_ENABLE) {	
				s.overState.visible = false;	
				s.downState.visible = false;	
				s.disableState.visible = false;	
				s.upState.visible = true;	
				s.mouseEnabled = true;	
			} else {	
				return;	
			}	
			s.state = state;	
		},	
		ll_mouseout : function (e, type, cd, ox, oy) {	
			var s = this;	
			if (!s.ll_mousein) {	
				return;	
			}	
			e.clickTarget=s;	
			s.ll_modeOut(e);	
			s.ll_mousein = false;	
		},	
		mouseEvent : function (e, type, cd) {	
			if (!e) {	
				return false;	
			}	
			var s = this;	
			if (type == LMouseEvent.MOUSE_MOVE && s.ll_button_mode) {	
				s.ll_button_mode(e);	
			}	
			return this.callParent("mouseEvent",arguments);	
		},	
		ll_button_mode : function(e){	
			var s = this;	
			if (!s.visible) {	
				return;	
			}	
			e.clickTarget=s;	
			if(s.hitTestPoint(e.offsetX,e.offsetY)){	
				s.ll_modeOver(e);	
			}else{	
				s.ll_modeOut(e);	
			}	
		},	
		ll_modeDown : function (e) {	
			var s = e.clickTarget, w, h, tw, th, x, y, tx, ty, onComplete;	
			if (!s.buttonMode || s.tween) {	
				return;	
			}	
			if (s.state == LButton.STATE_DISABLE) {	
				s.upState.visible = false;	
				s.overState.visible = false;	
				s.downState.visible = false;	
				s.disableState.visible = true;	
				return;	
			}	
			s.upState.visible = false;	
			s.overState.visible = false;	
			s.downState.visible = true;		
			s._tweenOver = s.ll_modeOver;	
			onComplete = function(obj){	
				var s = obj.parent;	
				delete s.tween;	
				s._tweenOver({clickTarget : s});	
				delete s._tweenOver;	
			};	
			if (s.staticMode) {	
				s.tween = LTweenLiteTimeline.to(s.downState, 0.3, {}).to(s.downState, 0.1, {onComplete : onComplete});	
			} else {	
				w = s.downState.getWidth();	
				h = s.downState.getHeight();	
				tw = w * 1.1;	
				th = h * 1.1;	
				x = s.downState.x;	
				y = s.downState.y;	
				tx = x + (w - tw) * 0.5;	
				ty = y + (h - th) * 0.5;	
				s.tween = LTweenLiteTimeline.to(s.downState, 0.3, {x : tx, y : ty, scaleX : s._ll_down_sx*1.1, scaleY : s._ll_down_sy*1.1, ease : Quart.easeOut})	
				.to(s.downState, 0.1, {x : x, y : y, scaleX : s._ll_down_sx, scaleY : s._ll_down_sy, ease : Quart.easeOut,onComplete : onComplete});	
			}	
		},	
		ll_modeOver : function (e) {	
			var s = e.clickTarget;	
			if (!s.buttonMode) {	
				return;	
			}	
			if (s.tween) {	
				s._tweenOver = s.ll_modeOver;	
				return;	
			}	
			if (s.state == LButton.STATE_DISABLE) {	
				s.upState.visible = false;	
				s.overState.visible = false;	
				s.downState.visible = false;	
				s.disableState.visible = true;	
				return;	
			}	
			s.upState.visible = false;	
			s.downState.visible = false;	
			s.overState.visible = true;	
			if (LGlobal.os == OS_PC && s._ll_cursorEnabled && s.parent) {	
				LGlobal.cursor = "pointer";	
			}	
		},	
		ll_modeOut : function (e){	
			var s = e.clickTarget;	
			if (!s.buttonMode) {	
				return;	
			}	
			if (s.tween) {	
				s._tweenOver = s.ll_modeOut;	
				return;	
			}	
			if (s.state == LButton.STATE_DISABLE) {	
				s.upState.visible = false;	
				s.overState.visible = false;	
				s.downState.visible = false;	
				s.disableState.visible = true;	
				return;	
			}	
			s.overState.visible = false;	
			s.downState.visible = false;	
			s.upState.visible = true;	
		},	
		setCursorEnabled : function (value) {	
			this._ll_cursorEnabled = value;	
		},	
		clone : function () {	
			var s = this;	
			return new LButton(s.upState.clone(),s.overState.clone(),s.downState.clone(),s.disableState.clone());	
		},	
		die : function () {	
			var s = this;	
			if (LMouseEventContainer.container[LMouseEvent.MOUSE_MOVE]) {	
				LMouseEventContainer.removeButton(s);	
			}	
			s.callParent("die",arguments);	
		}	
	};	
	for (var k in p) {	
		LButton.prototype[k] = p[k];	
	}	
	return LButton;	
})();	
function LBlendMode () {throw "LBlendMode cannot be instantiated";}	
LBlendMode.SOURCE_OVER = "source-over";	
LBlendMode.SOURCE_ATOP = "source-atop";	
LBlendMode.SOURCE_IN = "source-in";	
LBlendMode.SOURCE_OUT = "source-out";	
LBlendMode.DESTINATION_OVER = "destination-over";	
LBlendMode.DESTINATION_ATOP = "destination-atop";	
LBlendMode.DESTINATION_IN = "destination-in";	
LBlendMode.DESTINATION_OUT = "destination-out";	
LBlendMode.LIGHTER = "lighter";	
LBlendMode.COPY = "copy";	
LBlendMode.XOR = "xor";	
LBlendMode.NONE = null;	
LBlendMode.NORMAL = null;	
var LTextFieldType = function (){throw "LTextFieldType cannot be instantiated";};	
LTextFieldType.INPUT = "input";	
LTextFieldType.DYNAMIC = null;	
LStyleSheet = (function() {	
	function LStyleSheet() {	
		var s = this;	
		LExtends(s, LObject, []);	
		s.styleIndex = 0;	
		s.styleNames  = {};	
	}	
	LStyleSheet.prototype.clone = function() {	
		var s = this, a = new s.constructor();	
		a.copyProperty(s);	
		return a;	
	};	
	LStyleSheet.prototype.setStyle = function(styleName, styleObject) {	
		this.styleIndex++;	
		if (styleObject === null) {	
			if (this.styleNames[styleName]) {	
				delete this.styleNames[styleName];	
			}	
			return;	
		}	
		var arr = styleObject.replace(/(^\{)|(\}$)/g, "").split(";"), i, styleObjects;	
		styleObject = {};	
		for ( i = 0; i < arr.length; i++) {	
			if (!arr[i]) {	
				continue;	
			}	
			var styleObjects = arr[i].split(":");	
			if (!styleObjects[0]) {	
				continue;	
			}	
			styleObject[styleObjects[0]] = styleObjects[1];	
		}	
		this.styleNames[styleName] = styleObject;	
	};	
	LStyleSheet.prototype.getStyle = function(styleName) {	
		return this.styleNames[styleName];	
	};	
	return LStyleSheet;	
})();	
LTextFormat = (function() {	
	function LTextFormat(font, size, color, bold, italic, underline) {	
		var s = this;	
		LExtends(s, LObject, []);	
		s.font = font ? font : "Arial";	
		s.size = size ? size : 15;	
		s.color = color ? color : "#000000";	
		s.bold = bold ? bold : false;	
		s.italic = italic ? italic : false;	
		s.underline = underline ? underline : false;	
	}	
	LTextFormat.prototype.clone = function() {	
		var s = this, a = new s.constructor();	
		a.copyProperty(s);	
		return a;	
	};	
	LTextFormat.prototype.getFontText = function() {	
		var s = this;	
		return (s.italic ? "italic " : "") + (s.bold ? "bold " : "") + s.size + "px " + s.font;	
	};	
	LTextFormat.prototype.setCss = function(css) {	
		var s = this, k;	
		for (k in css) {	
			switch (k) {	
				case "color":	
					s.color = css[k];	
					break;	
				case "font-family":	
					s.font = css[k];	
					break;	
				case "font-size":	
					s.size = css[k];	
					break;	
				case "font-style":	
					s.italic = (css[k] == "italic");	
					break;	
				case "font-weight":	
					s.bold = (css[k] == "bold");	
					break;	
				case "text-decoration":	
					s.color = (css[k] == "underline");	
					break;	
			}	
		}	
	};	
	return LTextFormat;	
})();	
var LTextField = (function () {	
	function LTextField () {	
		var s = this;	
		LExtends(s, LInteractiveObject, []);	
		s.type = "LTextField";	
		s.texttype = null;	
		s.text = "";	
		s.htmlText = "";	
		s.styleSheet = "";	
		s.font = "Arial";	
		s.size = 15;	
		s.color = "#000000";	
		s.weight = "normal";	
		s.textAlign = "left";	
		s.textBaseline = "top";	
		s.heightMode = LTextField.HEIGHT_MODE_BOTTOM;	
		s.stroke = false;	
		s.lineWidth = 1;	
		s.lineColor = "#000000";	
		s.width = 150;	
		s.height = s.size;	
		s.displayAsPassword = false;	
		s.wordWrap = false;	
		s.multiline = false;	
		s.numLines = 1;	
		s.speed = 0;	
		s._speedIndex = 100;	
	}	
	LTextField.HEIGHT_MODE_BOTTOM = "bottom";	
	LTextField.HEIGHT_MODE_BASELINE = "baseline";	
	var p = {	
		_showReady : function (c) {	
			var s = this;	
			c.font = s.weight + " " + s.size + "px " + s.font;  	
			c.textAlign = s.textAlign;	
			c.textBaseline = s.textBaseline;	
		},	
		ll_getStyleSheet : function (textFormat, tabName, attribute, text) {	
			var s = this, pattern, tf = textFormat.clone();	
			if (tabName == "font") {	
				var i = 0;	
				while (attribute) {	
					if (i++ > 4)	
						break;	
					pattern = /(([^\s]*?)(\s*)=(\s*)("|')(.*?)\5)*/g;	
					var arr = pattern.exec(attribute);	
					if (!arr || !arr[0]) {	
						break;	
					}	
					switch(arr[2]) {	
						case "face":	
							tf.font = arr[6];	
							break;	
						case "color":	
							tf.color = arr[6];	
							break;	
						case "size":	
							tf.size = arr[6];	
							break;	
					}	
					attribute = attribute.replace(arr[0], "").replace(/(^\s*)|(\s*$)|(\n)/g, "");	
				}	
			} else if (tabName == "b") {	
				tf.bold = true;	
			} else if (tabName == "u") {	
				tf.underline = true;	
			} else if (tabName == "i") {	
				tf.italic = true;	
			} else if (tabName == "p" && s.wordWrap) {	
				text = "\n" + text + "\n";	
			} else if(s.styleSheet){	
				var sheetObj;	
				if (tabName == "span"){	
					pattern = /(([^\s]*?)(\s*)=(\s*)("|')(.*?)\5)*/g;	
					var arr = pattern.exec(attribute);	
					if (arr && arr[0]) {	
						switch(arr[2]) {	
							case "class":	
								sheetObj = s.styleSheet.getStyle("." + arr[6]);	
								break;	
						}	
					}	
				}else if(s.styleSheet.getStyle(tabName)){	
					sheetObj = s.styleSheet.getStyle(tabName);	
				}	
				if(sheetObj){	
					tf.setCss(sheetObj);	
				}	
			}	
			s.ll_getHtmlText(tf, text); 	
		},	
		ll_getHtmlText : function (tf, text) {	
			if (!text) {	
				return;	
			}	
			var s = this, tabName, content, start, end, pattern = /<(.*?)(\s*)(.*?)>(.*?)<\/\1>/g, arr = pattern.exec(text);	
			if (!arr || !arr[0]) {	
				s.ll_htmlTexts.push({	
					textFormat : tf.clone(),	
					text : text	
				});	
				return;	
			}	
			if (arr.index > 0) {	
				s.ll_htmlTexts.push({	
					textFormat : tf.clone(),	
					text : text.substring(0, arr.index)	
				});	
			}	
			tabName = arr[1];	
			start = arr.index;	
			end = start;	
			do {	
				end = text.indexOf("</" + tabName, end + 1);	
				start = text.indexOf("<" + tabName, start + 1);	
			} while(start > 0 && start < end);	
			content = text.substring(text.indexOf(">", arr.index) + 1, end);	
			s.ll_getStyleSheet(tf, tabName, arr[3], content);	
			s.ll_getHtmlText(tf, text.substring(end + tabName.length + 3));	
		},	
		_ll_show : function (c) {	
			var s = this, d, lbl, i, rc, j, l, k, m, b, h, enter, tf, underlineY;	
			if (s.texttype == LTextFieldType.INPUT) {	
				s.inputBackLayer.ll_show();	
				rc = s.getRootCoordinate();	
				if (LGlobal.inputBox.name == "input" + s.objectIndex) {	
					LGlobal.inputBox.style.marginTop = (parseInt(LGlobal.canvasObj.style.marginTop) + (((rc.y + s.inputBackLayer.startY()) * parseInt(LGlobal.canvasObj.style.height) / LGlobal.canvasObj.height) >>> 0)) + "px";	
					LGlobal.inputBox.style.marginLeft = (parseInt(LGlobal.canvasObj.style.marginLeft) + (((rc.x + s.inputBackLayer.startX()) * parseInt(LGlobal.canvasObj.style.width) / LGlobal.canvasObj.width) >>> 0)) + "px";	
				}	
				if (LGlobal.inputTextField && LGlobal.inputTextField.objectIndex == s.objectIndex) {	
					return;	
				}	
			}	
			if (LGlobal.fpsStatus) {	
				LGlobal.fpsStatus.text++;	
			}	
			c.fillStyle = s.color;	
			if (s.stroke) {	
				c.strokeStyle = s.lineColor;	
				c.lineWidth = s.lineWidth + 1;  	
			}	
			if (s.htmlText) {	
				if (s.ll_htmlText != s.htmlText || (s.styleSheet && (s.ll_style_objectIndex != s.styleSheet.objectIndex || s.ll_styleIndex == s.styleSheet.styleIndex))) {	
					tf = new LTextFormat();	
					s.ll_htmlTexts = [];	
					s.ll_htmlText = s.htmlText;	
					if(s.styleSheet){	
						s.ll_style_objectIndex = s.styleSheet.objectIndex;	
						s.ll_styleIndex = s.styleSheet.styleIndex;	
					}	
					s.ll_getHtmlText(tf, s.htmlText);	
				}	
				j = 0, k = 0, m = 0, b = 0;	
				s._wordHeight = s.wordHeight || 30;	
				if(!LTextField.underlineY){	
					LTextField.underlineY = {"alphabetic" : 0, "top" : 1, "bottom" : -0.2, "middle" : 0.4, "hanging" : 0.8};	
				}	
				s.ll_htmlTexts.forEach(function(element){	
					var textFormat = element.textFormat, text = element.text;	
					c.font = textFormat.getFontText();	
					c.fillStyle = textFormat.color;	
					for (i = 0, l = text.length; i < l; i++) {	
						enter = /(?:\r\n|\r|\n|¥n)/.exec(text.substr(i, 1));	
						if (enter) {	
							j = 0;	
							k = i + 1;	
							m++;	
						} else {	
							h = c.measureText("O").width * 1.2;	
							if (s.stroke) {	
								c.strokeText(text.substr(i, 1), j, m * s._wordHeight);	
							}	
							c.fillText(text.substr(i, 1), j, m * s._wordHeight);	
							if(textFormat.underline){	
								c.beginPath();	
								underlineY = m * s._wordHeight + h * LTextField.underlineY[s.textBaseline];	
								c.moveTo(j, underlineY);	
								c.lineTo(j + c.measureText(text.substr(i, 1)).width, underlineY);	
								c.stroke();	
							}	
						}	
						j += c.measureText(text.substr(i, 1)).width;	
						if (s.wordWrap && j + c.measureText(text.substr(i + 1, 1)).width > s.width) {	
							j = 0;	
							k = i + 1;	
							m++;	
						}	
					}	
					s.height = (m + 1) * s._wordHeight;	
				});	
				return;	
			}	
			lbl = s.text;	
			if (s.displayAsPassword) {	
				lbl = '';	
				for (i=0, l = s.text.length; i < l; i++) {	
					lbl += '*';	
				}	
			}	
			if (s.wordWrap || s.multiline) {	
				j = 0, k = 0, m = 0, b = 0;	
				for (i = 0, l = s.text.length; i < l; i++) {	
					enter = /(?:\r\n|\r|\n|¥n)/.exec(lbl.substr(i, 1));	
					if (enter) {	
						j = 0;	
						k = i + 1;	
						m++;	
					} else {	
						if (s.stroke) {	
							c.strokeText(lbl.substr(i, 1), j, m * s.wordHeight);	
						}	
						c.fillText(lbl.substr(i, 1), j, m * s.wordHeight);	
					}	
					s.numLines = m;	
					j = c.measureText(s.text.substr(k, i + 1 - k)).width;	
					if (s.wordWrap && j + c.measureText(lbl.substr(i, 1)).width > s.width) {	
						j = 0;	
						k = i + 1;	
						m++;	
					}	
				}	
				s.height = (m + 1) * s.wordHeight;	
			} else {	
				s.numLines = 1;	
				if (s.stroke) {	
					c.strokeText(lbl, 0, 0, c.measureText(lbl).width);	
				}	
				c.fillText(lbl, 0, 0, c.measureText(lbl).width);	
			}	
			if (s.windRunning) {	
				s._ll_windRun();	
			}	
		},	
		_wordHeight : function (h) {	
			var s = this;	
			if (h > 0) {	
				s.wordHeight = h;	
			} else {	
				s.wordWrap = false;	
				s.wordHeight = s.getHeight();	
			}	
			s.height = 0;	
		},	
		setMultiline : function (v, h) {	
			var s = this;	
			if (v) {	
				s._wordHeight(h);	
			}	
			s.multiline = v;	
		},	
		setWordWrap : function (v, h) {	
			var s = this;	
			if (v) {	
				s._wordHeight(h);	
			}	
			s.wordWrap = v;	
		},	
		setType : function (type, inputBackLayer) {	
			var s = this;	
			if (s.texttype != type && type == LTextFieldType.INPUT) {	
				if (inputBackLayer == null || inputBackLayer.type != "LSprite") {	
					s.inputBackLayer = new LSprite();	
					s.inputBackLayer.graphics.drawRect(1, "#000000", [0, -s.getHeight() * 0.4, s.width, s.getHeight() * 1.5]);	
				} else {	
					s.inputBackLayer = inputBackLayer;	
				}	
				s.inputBackLayer.parent = s;	
				if (LMouseEventContainer.container[LMouseEvent.MOUSE_DOWN]) {	
					LMouseEventContainer.pushInputBox(s);	
				}	
			} else {	
				s.inputBackLayer = null;	
				LMouseEventContainer.removeInputBox(s);	
			}	
			s.texttype = type;	
		},	
		ismouseon : function (e, cood) {	
			var s = this;	
			if (!e) {	
				return false;	
			}	
			if (!s.visible) {	
				return false;	
			}	
			if (!cood) {	
				cood = {x : 0, y : 0, scaleX : 1, scaleY : 1};	
			}	
			if (s.mask) {	
				if (!s.mask.parent) {	
					s.mask.parent = s.parent;	
				}	
				if (!s.mask.ismouseon(e, cood)) {	
					return false;	
				}	
			}	
			if (s.inputBackLayer) {	
				return s.inputBackLayer.ismouseon(e, {x : s.x * cood.scaleX + cood.x, y : s.y * cood.scaleY + cood.y, scaleX : cood.scaleX * s.scaleX, scaleY : cood.scaleY * s.scaleY});	
			}	
			return s.ismouseonShapes([{type : LShape.RECT, arg : [0, 0, s._getWidth(), s._getHeight()]}], e.offsetX, e.offsetY);	
		},	
		clone : function () {	
			var s = this, a = new s.constructor();	
			a.copyProperty(s);	
			a.texttype = null;	
			if (s.texttype ==  LTextFieldType.INPUT) {	
				a.setType( LTextFieldType.INPUT);	
			}	
			return a;	
		},	
		mouseEvent : function (event, type, cood) {	
			var s = this, on;	
			if (s.inputBackLayer == null || type != LMouseEvent.MOUSE_DOWN) {	
				return;	
			}	
			on = s.ismouseon(event, cood);	
			if (!on) {	
				return;	
			}	
			s.focus();	
		},	
		_ll_getValue : function () {	
			if (LGlobal.inputBox.style.display != NONE) {	
				LGlobal.inputTextField.text = LGlobal.inputTextBox.value;	
				LEvent.removeEventListener(LGlobal.inputTextBox, LKeyboardEvent.KEY_DOWN, LGlobal.inputTextField._ll_input);	
				LGlobal.inputBox.style.display = NONE;	
				LGlobal.inputTextField.dispatchEvent(LFocusEvent.FOCUS_OUT);	
				LGlobal.inputTextField = null;	
			}	
		},	
		updateInput : function () {	
			var s = this;	
			if (s.texttype == LTextFieldType.INPUT && LGlobal.inputTextField.objectIndex == s.objectIndex) {	
				LGlobal.inputTextBox.value = LGlobal.inputTextField.text;	
			}	
		},	
		_ll_input : function (e) {	
			var event = new LEvent(LTextEvent.TEXT_INPUT);	
			event.keyCode = e.keyCode;	
			LGlobal.inputTextField.text = LGlobal.inputTextBox.value;	
			if (LGlobal.inputTextField.hasEventListener(LTextEvent.TEXT_INPUT)) {	
				e.returnValue = LGlobal.inputTextField.dispatchEvent(event);	
			} else {	
				e.returnValue = true;	
			}	
		},	
		focus : function () {	
			var s = this, sc, sx;	
			if (!s.parent) {	
				return;	
			}	
			if (s.texttype != LTextFieldType.INPUT) {	
				return;	
			}	
			if (LGlobal.inputTextField && LGlobal.inputTextField.objectIndex != s.objectIndex) {	
				s._ll_getValue();	
			}	
			s.dispatchEvent(LFocusEvent.FOCUS_IN);	
			sc = s.getAbsoluteScale();	
			LGlobal.inputBox.style.display = "";	
			LGlobal.inputBox.name = "input" + s.objectIndex;	
			LGlobal.inputTextField = s;	
			LGlobal.inputTextareaBoxObj.style.display = NONE;	
			LGlobal.inputTextBoxObj.style.display = NONE;	
			LGlobal.passwordBoxObj.style.display = NONE;	
			if (s.displayAsPassword) {	
				LGlobal.inputTextBox = LGlobal.passwordBoxObj;	
			} else if (s.multiline) {	
				LGlobal.inputTextBox = LGlobal.inputTextareaBoxObj;	
			} else {	
				LGlobal.inputTextBox = LGlobal.inputTextBoxObj;	
			}	
			sx = parseInt(LGlobal.canvasObj.style.width) / LGlobal.canvasObj.width;	
			sy = parseInt(LGlobal.canvasObj.style.height) / LGlobal.canvasObj.height;	
			LGlobal.inputTextBox.style.display = "";	
			LGlobal.inputTextBox.value = s.text;	
			LGlobal.inputTextBox.style.height = s.inputBackLayer.getHeight() * sc.scaleY * s.scaleY * sy + "px";	
			LGlobal.inputTextBox.style.width = s.inputBackLayer.getWidth() * sc.scaleX * s.scaleX * sx + "px";	
			LGlobal.inputTextBox.style.color = s.color;	
			LGlobal.inputTextBox.style.fontSize = ((s.size * parseFloat(LGlobal.canvasObj.style.height) / LGlobal.canvasObj.height) >> 0) + "px";	
			LGlobal.inputTextBox.style.fontFamily = s.font;	
			LEvent.addEventListener(LGlobal.inputTextBox, LKeyboardEvent.KEY_DOWN, LGlobal.inputTextField._ll_input);	
			if (s.texttype == LTextFieldType.INPUT) {	
				rc = s.getRootCoordinate();	
				if (LGlobal.inputBox.name == "input" + s.objectIndex) {	
					LGlobal.inputBox.style.marginTop = (parseInt(LGlobal.canvasObj.style.marginTop) + (((rc.y + s.inputBackLayer.startY()) * parseInt(LGlobal.canvasObj.style.height) / LGlobal.canvasObj.height) >>> 0)) + "px";	
					LGlobal.inputBox.style.marginLeft = (parseInt(LGlobal.canvasObj.style.marginLeft) + (((rc.x + s.inputBackLayer.startX()) * parseInt(LGlobal.canvasObj.style.width) / LGlobal.canvasObj.width) >>> 0)) + "px";	
				}	
			}	
			setTimeout(function () {	
				LGlobal.inputTextBox.focus();	
			}, 0);	
		},	
		_getWidth : function () {	
			var s = this;	
			if (s.wordWrap) {	
				return s.width;	
			}	
			LGlobal.canvas.font = s.size + "px " + s.font;	
			return LGlobal.canvas.measureText(s.text).width;	
		},	
		getWidth : function (maskSize) {	
			var s = this, w, mx, mw;	
			w = s._getWidth() * s.scaleX;	
			if (maskSize && s.mask) {	
				mx = s.mask._startX ? s.mask._startX() : s.mask.startX();	
				if (mx > w) {	
					return 0;	
				}	
				mw = s.mask.getWidth();	
				if (mx + mw > w) {	
					return w - mx;	
				} else {	
					return mw;	
				}	
			}	
			return w;	
		},	
		_getHeight : function () {	
			var s = this, c = LGlobal.canvas, i, l, j, k, m, enter;	
			if (s.wordWrap) {	
				c.font = s.weight + " " + s.size + "px " + s.font;	
				if (s.height == 0) {	
					j = 0, k = 0, m = 0;	
					for (i = 0, l = s.text.length; i < l; i++) {	
						j = c.measureText(s.text.substr(k, i - k)).width;	
						enter = /(?:\r\n|\r|\n|¥n)/.exec(s.text.substr(i, 1));	
						if ((s.wordWrap && j > s.width) || enter) {	
							j = 0;	
							k = i;	
							m++;	
							if (enter) {	
								k++;	
							}	
						}	
					}	
					s.height = (m + 1) * s.wordHeight;	
				}	
				return s.height;	
			}	
			c.font = s.weight + " " + s.size + "px " + s.font; 	
			l = c.measureText("O").width * 1.2;	
			if (s.heightMode == LTextField.HEIGHT_MODE_BASELINE) {	
				l = l * 1.2;	
			}	
			return l;	
		},	
		getHeight : function (maskSize) {	
			var s = this, h, my, mh;	
			h = s._getHeight() * s.scaleY;	
			if (maskSize && s.mask) {	
				my = s.mask._startY ? s.mask._startY() : s.mask.startY();	
				if (my > h) {	
					return 0;	
				}	
				mh = s.mask.getHeight();	
				if (my + mh > h) {	
					return h - my;	
				} else {	
					return mh;	
				}	
			}	
			return h;	
		},	
		wind : function (listener) {	
			var s = this;	
			s.wind_over_function = listener;	
			s.windRunning = true;	
			s._ll_wind_text = s.text;	
			s.text = "";	
			s._ll_wind_length = 0;	
		},	
		_ll_windRun : function () {	
			var s = this;	
			if (s._speedIndex++ < s.speed) {	
				return;	
			}	
			s._speedIndex = 0;	
			if (s._ll_wind_length > s._ll_wind_text.length) {	
				s.windRunning = false;	
				if (s.wind_over_function) {	
					s.wind_over_function();	
				}	
				s.dispatchEvent(new LEvent(LTextEvent.WIND_COMPLETE));	
				return;	
			}	
			s.text = s._ll_wind_text.substring(0, s._ll_wind_length);	
			s._ll_wind_length++;	
		},	
		die : function () {	
			LMouseEventContainer.removeInputBox(this);	
		}	
	};	
	for (var k in p) {	
		LTextField.prototype[k] = p[k];	
	}	
	return LTextField;	
})();	
var LBitmap = (function () {	
	function LBitmap (bitmapdata) {	
		var s = this;	
		LExtends(s, LDisplayObject, []);	
		s.type = "LBitmap";	
		s.rotateCenter = true;	
		s.bitmapData = bitmapdata; 	
		if (s.bitmapData) {	
			s.width = s.bitmapData.width;	
			s.height = s.bitmapData.height;	
		}	
	}	
	var p = {	
		_canShow : function () {	
			return (this.visible && this.bitmapData);	
		},	
		_rotateReady : function () {	
			var s = this;	
			if (s.rotate != 0 && s.rotateCenter) {	
				s.rotatex = s.getWidth() * 0.5;	
				s.rotatey = s.getHeight() * 0.5;	
			} else {	
				s.rotatex = s.rotatey = 0;	
			}	
		},	
		_coordinate : function (c) {},	
		_ll_show : function () {	
			this.ll_draw();	
		},	
		ll_draw : function () {	
			var s = this;	
			if (LGlobal.fpsStatus) {	
				LGlobal.fpsStatus.bitmapData++;	
			}	
			LGlobal.canvas.drawImage(s.bitmapData.image,	
				s.bitmapData.x,	
				s.bitmapData.y,	
				s.bitmapData.width,	
				s.bitmapData.height,	
				s.x,	
				s.y,	
				s.bitmapData.width,	
				s.bitmapData.height	
			);	
		},	
		clone : function () {	
			var s = this, a = new LBitmap(s.bitmapData.clone());	
			a.copyProperty(s);	
			a.rotateCenter = s.rotateCenter;	
			return a;	
		},	
		ismouseon : function (e, cood) {	
			var s = this;	
			if (!e) {	
				return false;	
			}	
			if (!s.visible || !s.bitmapData) {	
				return false;	
			}	
			if (s.mask) {	
				if (!s.mask.parent) {	
					s.mask.parent = s.parent;	
				}	
				if (!s.mask.ismouseon(e, cood)) {	
					return false;	
				}	
			}	
			return s.ismouseonShapes([{type : LShape.RECT, arg : [0, 0, s.bitmapData.width, s.bitmapData.height]}], e.offsetX, e.offsetY);	
		},	
		getWidth : function (maskSize) {	
			var s = this, w, mx, mw;	
			w = s.bitmapData != null ? s.bitmapData.width * (s.scaleX > 0 ? s.scaleX : -s.scaleX) : 0;	
			if (maskSize && s.mask) {	
				mx = s.mask._startX ? s.mask._startX() : s.mask.startX();	
				if (mx > w) {	
					return 0;	
				}	
				mw = s.mask.getWidth();	
				if (mx + mw > w) {	
					return w - mx;	
				}else{	
					return mw;	
				}	
			}	
			return w;	
		},	
		getHeight : function (maskSize) {	
			var s = this, h, my, mh;	
			h = s.bitmapData != null ? s.bitmapData.height * (s.scaleY > 0 ? s.scaleY : -s.scaleY) : 0;	
			if (maskSize && s.mask) {	
				my = s.mask._startY ? s.mask._startY() : s.mask.startY();	
				if (my > h) {	
					return 0;	
				}	
				mh = s.mask.getHeight();	
				if (my + mh > h) {	
					return h - my;	
				}else{	
					return mh;	
				}	
			}	
			return h;	
		},	
		startX : function () {	
			return this.x;	
		},	
		startY : function () {	
			return this.y;	
		},	
		die : function () {}	
	};	
	for (var k in p) {	
		LBitmap.prototype[k] = p[k];	
	}	
	return LBitmap;	
})();	
var LBitmapData = (function() {	
	function LBitmapData(image, x, y, width, height, dataType) {	
		var s = this;	
		LExtends(s, LObject, []);	
		s.type = "LBitmapData";	
		if ( typeof dataType == UNDEFINED) {	
			dataType = LBitmapData.DATA_IMAGE;	
		}	
		s.oncomplete = null;	
		s._locked = false;	
		s._setPixel = false;	
		s.x = (x == null ? 0 : x);	
		s.y = (y == null ? 0 : y);	
		s.width = 0;	
		s.height = 0;	
		s.dataType = null;	
		if (image && typeof image == "object") {	
			s.image = image;	
			s.dataType = LBitmapData.DATA_IMAGE;	
			s.width = (width == null ? s.image.width : width);	
			s.height = (height == null ? s.image.height : height);	
			s._setDataType(dataType);	
		} else {	
			s._createCanvas();	
			s.dataType = LBitmapData.DATA_CANVAS;	
			s._canvas.width = s.width = (width == null ? 1 : width);	
			s._canvas.height = s.height = (height == null ? 1 : height);	
			if ( typeof image == "string") {	
				image = parseInt(image.replace("#", "0x"));	
			}	
			if ( typeof image == "number") {	
				var d = s._context.createImageData(s.width, s.height);	
				for (var i = 0; i < d.data.length; i += 4) {	
					d.data[i + 0] = image >> 16 & 0xFF;	
					d.data[i + 1] = image >> 8 & 0xFF;	
					d.data[i + 2] = image & 0xFF;	
					d.data[i + 3] = 255;	
				}	
				s._context.putImageData(d, 0, 0);	
			}	
			s.image = s._canvas;	
			if (dataType == LBitmapData.DATA_IMAGE) {	
				s._setDataType(dataType);	
			}	
		}	
		s.resize();	
	}	
	LBitmapData.DATA_IMAGE = "data_image";	
	LBitmapData.DATA_CANVAS = "data_canvas";	
	var p = {	
		_setDataType : function(dataType) {	
			var s = this;	
			if (s.dataType == dataType) {	
				return;	
			}	
			if (dataType == LBitmapData.DATA_CANVAS) {	
				s._createCanvas();	
				s._canvas.width = s.image.width;	
				s._canvas.height = s.image.height;	
				s._context.clearRect(0, 0, s._canvas.width, s._canvas.height);	
				s._context.drawImage(s.image, 0, 0);	
				s.image = s._canvas;	
			} else if (dataType == LBitmapData.DATA_IMAGE) {	
				s.image = new Image();	
				s.image.width = s._canvas.width;	
				s.image.height = s._canvas.height;	
				s.image.src = s._canvas.toDataURL();	
			}	
			s.dataType = dataType;	
		},	
		_createCanvas : function() {	
			var s = this;	
			if (!s._canvas) {	
				s._canvas = document.createElement("canvas");	
				s._context = s._canvas.getContext("2d");	
			}	
		},	
		clear : function() {	
			var s = this;	
			s._createCanvas();	
			s._canvas.width = s.image.width;	
			if (s.dataType == LBitmapData.DATA_IMAGE) {	
				s.image.src = s._canvas.toDataURL();	
			}	
		},	
		setProperties : function(x, y, width, height) {	
			var s = this;	
			s.x = x;	
			s.y = y;	
			s.width = width;	
			s.height = height;	
			s.resize();	
		},	
		setCoordinate : function(x, y) {	
			var s = this;	
			s.x = x;	
			s.y = y;	
			s.resize();	
		},	
		clone : function() {	
			var s = this;	
			return new LBitmapData(s.image, s.x, s.y, s.width, s.height, s.dataType);	
		},	
		_ready : function() {	
			var s = this;	
			s._dataType = s.dataType;	
			s._setDataType(LBitmapData.DATA_CANVAS);	
			s._data = s._context.getImageData(s.x, s.y, s.width, s.height);	
		},	
		_update : function() {	
			var s = this;	
			s._context.putImageData(s._data, s.x, s.y, 0, 0, s.width, s.height);	
			s._setDataType(s._dataType);	
			s._data = null;	
		},	
		getPixel : function(x, y, colorType) {	
			var s = this, i, d;	
			x = x >> 0;	
			y = y >> 0;	
			if (!s._locked) {	
				s._ready();	
			}	
			i = s.width * 4 * y + x * 4;	
			d = s._data.data;	
			if (!s._locked) {	
				s._update();	
			}	
			if (colorType == "number") {	
				return d[i] << 16 | d[i + 1] << 8 | d[i + 2];	
			} else {	
				return [d[i], d[i + 1], d[i + 2], d[i + 3]];	
			}	
		},	
		setPixel : function(x, y, data) {	
			var s = this;	
			x = x >> 0;	
			y = y >> 0;	
			if (!s._locked) {	
				s._ready();	
			}	
			var d = s._data, i = s.width * 4 * y + x * 4;	
			if ( typeof data == "object") {	
				d.data[i + 0] = data[0];	
				d.data[i + 1] = data[1];	
				d.data[i + 2] = data[2];	
				d.data[i + 3] = data[3];	
			} else {	
				if ( typeof data == "string") {	
					data = parseInt(data.replace("#", "0x"));	
				}	
				d.data[i + 0] = data >> 16 & 0xFF;	
				d.data[i + 1] = data >> 8 & 0xFF;	
				d.data[i + 2] = data & 0xFF;	
				d.data[i + 3] = 255;	
			}	
			if (!s._locked) {	
				s._update();	
			}	
		},	
		getPixels : function(rect) {	
			var s = this, r;	
			if (!s._locked) {	
				s._ready();	
			}	
			r = s._context.getImageData(s.x + rect.x, s.y + rect.y, rect.width, rect.height);	
			if (!s._locked) {	
				s._update();	
			}	
			return r;	
		},	
		setPixels : function(rect, data) {	
			var s = this, i, j, d, w, sd, x, y;	
			if (!s._locked) {	
				s._ready();	
			}	
			d = s._data;	
			if ( typeof data == "object") {	
				w = s._canvas.width;	
				for ( x = rect.x; x < rect.right; x++) {	
					for ( y = rect.y; y < rect.bottom; y++) {	
						i = w * 4 * (s.y + y) + (s.x + x) * 4;	
						j = data.width * 4 * (y - rect.y) + (x - rect.x) * 4;	
						d.data[i + 0] = data.data[j + 0];	
						d.data[i + 1] = data.data[j + 1];	
						d.data[i + 2] = data.data[j + 2];	
						d.data[i + 3] = data.data[j + 3];	
					}	
				}	
			} else {	
				if ( typeof data == "string") {	
					data = parseInt(data.replace("#", "0x"));	
				}	
				data = [data >> 16 & 0xFF, data >> 8 & 0xFF, data & 0xFF];	
				w = s._canvas.width;	
				for ( x = rect.x; x < rect.right; x++) {	
					for ( y = rect.y; y < rect.bottom; y++) {	
						i = w * 4 * (s.y + y) + (s.x + x) * 4;	
						d.data[i + 0] = data[0];	
						d.data[i + 1] = data[1];	
						d.data[i + 2] = data[2];	
						d.data[i + 3] = 255;	
					}	
				}	
			}	
			if (!s._locked) {	
				s._update();	
			}	
		},	
		putPixels : function(rect, data) {	
			var s = this;	
			if (s.dataType != LBitmapData.DATA_CANVAS || typeof data != "object") {	
				return;	
			}	
			s._context.putImageData(data, s.x + rect.x, s.y + rect.y, 0, 0, rect.width, rect.height);	
		},	
		lock : function() {	
			var s = this;	
			s._locked = true;	
			s._ready();	
		},	
		unlock : function() {	
			var s = this;	
			s._locked = false;	
			s._update();	
		},	
		draw : function(source, matrix, colorTransform, blendMode, clipRect) {	
			var s = this, c, bd = source, x, y, w, h, save = false;	
			var _dataType = s.dataType;	
			s._setDataType(LBitmapData.DATA_CANVAS);	
			if (matrix || colorTransform || blendMode || clipRect) {	
				s._context.save();	
				save = true;	
			}	
			if (clipRect) {	
				if (!( bd instanceof LBitmapData)) {	
					x = y = 0;	
				} else {	
					x = bd.x;	
					y = bd.y;	
				}	
				bd = new LBitmapData(bd.getDataCanvas(), x + clipRect.x, y + clipRect.y, clipRect.width, clipRect.height, LBitmapData.DATA_CANVAS);	
			}	
			w = bd.getWidth() >>> 0;	
			h = bd.getHeight() >>> 0;	
			if (w == 0 || h == 0) {	
				s._setDataType(_dataType);	
				return;	
			}	
			c = bd.getDataCanvas();	
			if (colorTransform) {	
				bd.colorTransform(new LRectangle(0, 0, w, h), colorTransform);	
				c = bd.image;	
			}	
			if (matrix) {	
				s._context.setTransform(matrix.a, matrix.b, matrix.c, matrix.d, matrix.tx, matrix.ty);	
			}	
			if (blendMode) {	
				s._context.globalCompositeOperation = blendMode;	
			}	
			s._context.drawImage(c, bd.x, bd.y, w, h, 0, 0, w, h);	
			if (save) {	
				s._context.restore();	
			}	
			s._setDataType(_dataType);	
			s.resize();	
		},	
		getDataCanvas : function() {	
			var s = this;	
			var _dataType = s.dataType;	
			s._setDataType(LBitmapData.DATA_CANVAS);	
			s._setDataType(_dataType);	
			return s._canvas;	
		},	
		getWidth : function() {	
			return this.width;	
		},	
		getHeight : function() {	
			return this.height;	
		},	
		resize : function() {	
			var s = this, w = s.image.width - s.x, h = s.image.height - s.y;	
			s.width = s.width < w ? s.width : w;	
			s.height = s.height < h ? s.height : h;	
		},	
		colorTransform : function(rect, colorTransform) {	
			var s = this;	
			if (s.dataType != LBitmapData.DATA_CANVAS) {	
				return;	
			}	
			var x = rect.x >> 0, y = rect.y >> 0, w = rect.width >> 0, h = rect.height >> 0;	
			var img = s._context.getImageData(s.x + rect.x, s.y + rect.y, rect.width, rect.height);	
			var data = img.data;	
			for (var i = 0, l = data.length; i < l; i += 4) {	
				var r = i, g = i + 1, b = i + 2, a = i + 3;	
				data[r] = data[r] * colorTransform.redMultiplier + colorTransform.redOffset;	
				data[g] = data[g] * colorTransform.greenMultiplier + colorTransform.greenOffset;	
				data[b] = data[b] * colorTransform.blueMultiplier + colorTransform.blueOffset;	
				data[a] = data[a] * colorTransform.alphaMultiplier + colorTransform.alphaOffset;	
			}	
			s._context.putImageData(img, s.x + rect.x, s.y + rect.y, 0, 0, rect.width, rect.height);	
		},	
		copyPixels : function(sourceBitmapData, sourceRect, destPoint) {	
			var s = this, left, top, width, height, bd = sourceBitmapData;	
			if (s.dataType != LBitmapData.DATA_CANVAS) {	
				return;	
			}	
			left = bd.x;	
			top = bd.y;	
			width = bd.width;	
			height = bd.height;	
			bd.setProperties(sourceRect.x + bd.x, sourceRect.y + bd.y, sourceRect.width, sourceRect.height);	
			s._context.drawImage(bd.image, bd.x, bd.y, bd.width, bd.height, destPoint.x, destPoint.y, bd.width, bd.height);	
			bd.x = left;	
			bd.y = top;	
			bd.width = width;	
			bd.height = height;	
		}	
	};	
	for (var k in p) {	
		LBitmapData.prototype[k] = p[k];	
	}	
	return LBitmapData;	
})(); 	
var LDropShadowFilter = (function () {	
	function LDropShadowFilter (distance, angle, color, blur) {	
		var s = this;	
		LExtends(s, LObject, []);	
		s.type = "LDropShadowFilter";	
		s.distance = distance ? distance : 0;	
		s.angle = angle ? angle : 0;	
		s.shadowColor = color ? color : "#000000";	
		s.shadowBlur = blur ? blur : 20;	
		s.setShadowOffset();	
	}	
	var p = {	
		setShadowOffset : function () {	
			var s = this;	
			var a = s.angle * Math.PI / 180;	
			s.shadowOffsetX = s.distance * Math.cos(a);	
			s.shadowOffsetY = s.distance * Math.sin(a);	
		},	
		ll_show : function () {	
			var s = this, c = LGlobal.canvas;	
			c.shadowColor = s.shadowColor;	
			c.shadowBlur = s.shadowBlur;	
			c.shadowOffsetX = s.shadowOffsetX;	
			c.shadowOffsetY = s.shadowOffsetY;	
		},	
		setDistance : function (distance) {	
			this.distance = distance;	
			this.setShadowOffset();	
		},	
		setAngle : function (angle) {	
			this.angle = angle;	
			this.setShadowOffset();	
		},	
		setColor : function (color) {	
			this.shadowColor = color;	
		},	
		setBlur : function (blur) {	
			this.shadowBlur = blur;	
		}	
	};	
	for (var k in p) {	
		LDropShadowFilter.prototype[k] = p[k];	
	}	
	return LDropShadowFilter;	
})();	
var LAnimation = (function() {	
	function LAnimation(layer, data, list) {	
		var s = this;	
		LExtends(s, LSprite, []);	
		s.type = "LAnimation";	
		s.rowIndex = 0;	
		s.colIndex = 0;	
		s._ll_stepIndex = 0;	
		s._ll_stepArray = [];	
		s.mode = 1;	
		s.isMirror = false;	
		if (Array.isArray(data)) {	
			s.bitmapList = data;	
		} else {	
			s.bitmapList = [data];	
		}	
		s.bitmap = new LBitmap(s.bitmapList[0]);	
		s.imageArray = list;	
		s.addChild(s.bitmap);	
		if (layer != null) {	
			layer.addChild(s);	
		}	
		s.onframe();	
		s.colIndex = 0;	
	}	
	var p = {	
		setAction : function(rowIndex, colIndex, mode, isMirror) {	
			var s = this, changed = false;	
			if (rowIndex != null && rowIndex >= 0 && rowIndex < s.imageArray.length) {	
				s.rowIndex = rowIndex;	
				changed = true;	
			}	
			if (colIndex != null && colIndex >= 0 && colIndex < s.imageArray[rowIndex].length) {	
				s.colIndex = colIndex;	
				changed = true;	
			}	
			if (mode != null) {	
				s.mode = mode;	
				changed = true;	
			}	
			if (isMirror != null) {	
				s.isMirror = isMirror;	
				if (s.isMirror) {	
					s.bitmap.x = s.bitmap.getWidth();	
					s.bitmap.scaleX = -1 * Math.abs(s.bitmap.scaleX);	
				} else {	
					s.bitmap.x = 0;	
					s.bitmap.scaleX = Math.abs(s.bitmap.scaleX);	
				}	
				changed = true;	
			}	
			if (changed) {	
				s._ll_stepIndex = 0;	
			}	
		},	
		getAction : function() {	
			var s = this;	
			return [s.rowIndex, s.colIndex, s.mode, s.isMirror];	
		},	
		onframe : function() {	
			var s = this, arr, sx = 0, stepFrame = null;	
			if (s.colIndex >= s.imageArray[s.rowIndex].length) {	
				s.colIndex = 0;	
			}	
			arr = s.imageArray[s.rowIndex][s.colIndex];	
			if (s._ll_stepArray[s.rowIndex] && s._ll_stepArray[s.rowIndex][s.colIndex]) {	
				stepFrame = s._ll_stepArray[s.rowIndex][s.colIndex];	
			} else {	
				stepFrame = 0;	
			}	
			if (s._ll_stepIndex == 0) {	
				if ( typeof arr.dataIndex == "number" && Array.isArray(s.bitmapList) && arr.dataIndex < s.bitmapList.length) {	
					s.bitmap.bitmapData = s.bitmapList[arr.dataIndex];	
				}	
				if (arr.script) {	
					for(i = 0; i < arr.script.length; i++){	
						obj = arr.script[i];	
						l = s.ll_labelList[obj.name];	
						if(l && l.rowIndex == s.rowIndex && l.colIndex == s.colIndex && l.mode == s.mode && l.isMirror == (s.bitmap.scaleX == -1)){	
							obj.func(s, obj.params);	
						}	
					}	
				}	
				if ( typeof arr.width != UNDEFINED && typeof arr.height != UNDEFINED) {	
					s.bitmap.bitmapData.setProperties(arr.x, arr.y, arr.width, arr.height);	
				} else {	
					s.bitmap.bitmapData.setCoordinate(arr.x, arr.y);	
				}	
				if ( typeof arr.sx != UNDEFINED) {	
					sx = arr.sx;	
				}	
				if ( typeof arr.sy != UNDEFINED) {	
					s.bitmap.y = arr.sy;	
				}	
				if ( typeof arr.mirror != UNDEFINED) {	
					s.bitmap.rotateCenter = false;	
					s.bitmap.scaleX = arr.mirror ? -1 : 1;	
				}	
				s.bitmap.x = sx + (s.bitmap.scaleX == 1 ? 0 : s.bitmap.getWidth());	
			}	
			if (s._ll_stepIndex++ < stepFrame) {	
				return;	
			}	
			s._ll_stepIndex = 0;	
			s.colIndex += s.mode;	
			if (s.colIndex >= s.imageArray[s.rowIndex].length || s.colIndex < 0) {	
				s.colIndex = s.mode > 0 ? 0 : s.imageArray[s.rowIndex].length - 1;	
				if (s.constructor.name == "LAnimationTimeline") {	
					s._send_complete = true;	
				} else {	
					s.dispatchEvent(LEvent.COMPLETE);	
				}	
			}	
		},	
		clone : function() {	
			var s = this, a = new s.constructor(null, s.bitmapList, s.imageArray.slice(0));	
			a.copyProperty(s);	
			a.childList.length = 0;	
			a.bitmap = s.bitmap.clone();	
			a.addChild(a.bitmap);	
			return a;	
		}	
	};	
	for (var k in p) {	
		LAnimation.prototype[k] = p[k];	
	}	
	return LAnimation;	
})();	
var LAnimationTimeline = (function() {	
	function LAnimationTimeline(data, list) {	
		var s = this;	
		LExtends(s, LAnimation, [null, data, list]);	
		s.type = "LAnimationTimeline";	
		s.speed = 0;	
		s._speedIndex = 0;	
		s.ll_labelList = {};	
		for (var i = 0, sublist, j, child; i < list.length; i++) {	
			sublist = list[i];	
			for ( j = 0; j < sublist.length; j++) {	
				child = sublist[j];	
				if (child.label) {	
					s.setLabel(child.label, i, j, 1, child.isMirror ? true : false);	
				}	
			}	
		}	
		s.addEventListener(LEvent.ENTER_FRAME, s._ll_onframe);	
	};	
	var p = {	
		clone : function() {	
			var s = this, k, o, a = new s.constructor(s.bitmapList, s.imageArray.slice(0));	
			a.copyProperty(s);	
			a.childList.length = 0;	
			a.bitmap = s.bitmap.clone();	
			a.addChild(a.bitmap);	
			for (k in s.ll_labelList) {	
				o = s.ll_labelList[k];	
				a.ll_labelList[k] = {	
					rowIndex : o.rowIndex,	
					colIndex : o.colIndex,	
					mode : o.mode,	
					isMirror : o.isMirror	
				};	
			}	
			return a;	
		},	
		setFrameSpeedAt : function(rowIndex, colIndex, speed) {	
			var s = this;	
			if (!s._ll_stepArray[rowIndex]) {	
				s._ll_stepArray[rowIndex] = [];	
			}	
			s._ll_stepArray[rowIndex][colIndex] = speed;	
		},	
		_ll_onframe : function(event) {	
			var self = event.target;	
			if (self._ll_stop) {	
				return;	
			}	
			if (self._speedIndex++ < self.speed) {	
				return;	
			}	
			if(self._send_complete){	
				self.dispatchEvent(LEvent.COMPLETE);	
				self._send_complete = false;	
				if (self._ll_stop) {	
					return;	
				}	
			}	
			self._speedIndex = 0;	
			self.onframe();	
		},	
		setLabel : function(name, _rowIndex, _colIndex, _mode, _isMirror) {	
			this.ll_labelList[name] = {	
				rowIndex : _rowIndex,	
				colIndex : _colIndex,	
				mode : (typeof _mode == UNDEFINED ? 1 : _mode),	
				isMirror : (typeof _isMirror == UNDEFINED ? false : _isMirror)	
			};	
		},	
		play : function() {	
			this._ll_stop = false;	
		},	
		stop : function() {	
			this._ll_stop = true;	
		},	
		gotoAndPlay : function(name) {	
			var s = this, l = s.ll_labelList[name];	
			s.setAction(l.rowIndex, l.colIndex, l.mode, l.isMirror);	
			s.onframe();	
			s.play();	
		},	
		gotoAndStop : function(name) {	
			var s = this, l = s.ll_labelList[name];	
			s.setAction(l.rowIndex, l.colIndex, l.mode, l.isMirror);	
			s.onframe();	
			s.stop();	
		},	
		addFrameScript : function(name, func, params) {	
			var l = this.ll_labelList[name];	
			var arr = this.imageArray[l.rowIndex][l.colIndex];	
			if (!arr.script) {	
				arr.script = [];	
			}	
			arr.script.push({func : func, params : params, name : name});	
		},	
		removeFrameScript : function(name) {	
			var l = this.ll_labelList[name], obj, script, i;	
			script = this.imageArray[l.rowIndex][l.colIndex].script;	
			if (!script) {	
				return;	
			}	
			for(i = 0; i < script.length; i++){	
				obj = script[i];	
				if(obj.name == name){	
					script.splice(i, 1);	
					break;	
				}	
			}	
		}	
	};	
	for (var k in p) {	
		LAnimationTimeline.prototype[k] = p[k];	
	}	
	return LAnimationTimeline;	
})(); 	
var LLoadManage = (function () {	
	function LoadManage(){	
		this.llname="ll.file.";	
		this.llload="ll.load.";	
	}	
	LoadManage.prototype = {	
		load : function (l, u, c) {	
			var s = this;	
			if (!l || l.length == 0) {	
				c([]);	
				return;	
			}	
			s.list = l, s.onupdate = u, s.oncomplete = c;	
			s.loader = s, s.index = 0, s.loadIndex = 0, s.result = [], s.lresult = [];	
			s.loadInit();	
		},	
		loadInit : function () {	
			var s = this;	
			if(s.index >= s.list.length){	
				return;	
			}	
			s.loadIndex = 0;	
			s.loadStart();	
			s.reloadtime = setTimeout(s.loadInit.bind(s), 10000);	
		},	
		loadStart : function () {	
			var s = this, d, ph, phs, ext;	
			if (s.loadIndex >= s.list.length) {	
				return;	
			}	
			d = s.list[s.loadIndex];	
			if (!d.name) {	
				d.name = s.llname + s.loadIndex;	
			}	
			if (!s.lresult[s.llload + d.name]) {	
				if (!d["type"]) {	
					ext = getExtension(d.path);	
					if (ext == "txt") {	
						d["type"] = LURLLoader.TYPE_TEXT;	
					} else if (ext == "js") {	
						d["type"] = LURLLoader.TYPE_JS;	
					} else if ((new Array("mp3", "ogg", "wav", "m4a")).indexOf(ext) >= 0) {	
						d["type"] = LSound.TYPE_SOUND;	
					}	
				}	
				if (d["type"] == LURLLoader.TYPE_TEXT || d["type"] == LURLLoader.TYPE_JS) {	
					s.loader = new LURLLoader();	
					s.loader.name = d.name;	
					s.loader.addEventListener(LEvent.COMPLETE, s.loadComplete.bind(s));	
					s.loader.load(s.url(d.path), d["type"]);	
				} else if (d["type"] == LSound.TYPE_SOUND) {	
					s.loader = new LSound();	
					s.loader.name = d.name;	
					s.loader.addEventListener(LEvent.COMPLETE, s.loadComplete.bind(s));	
					s.loader.load(d.path);	
				} else {	
					s.loader = new LLoader();	
					s.loader.name = d.name;	
					s.loader.addEventListener(LEvent.COMPLETE, s.loadComplete.bind(s));	
					s.loader.load(s.url(d.path), LLoader.TYPE_BITMAPDATE);	
				}	
			}	
			s.loadIndex++;	
			s.loadStart();	
		},	
		loadComplete : function (e) {	
			var s = this;	
			if (e  && e.currentTarget && e.currentTarget.name) {	
				e.currentTarget.removeEventListener(LEvent.COMPLETE, s.loadComplete);	
				if (e.currentTarget.name.indexOf(s.llname) >= 0) {	
					e.target = 1;	
				}	
				if (s.lresult[s.llload + e.currentTarget.name]) {	
					return;	
				}	
				s.result[e.currentTarget.name] = e.target;	
				s.lresult[s.llload + e.currentTarget.name] = 1;	
			}	
			s.index++;	
			if (s.onupdate) {	
				s.onupdate(Math.floor(s.index * 100 / s.list.length));	
			}	
			if (s.index >= s.list.length) {	
				if (s.reloadtime) {	
					clearTimeout(s.reloadtime);	
				}	
				s.loader = null;	
				var r = s.result;	
				LGlobal.forceRefresh = true;	
				s.oncomplete(r);	
			}	
		},	
		url : function (u) {	
			if (!LGlobal.traceDebug) {	
				return u;	
			}	
			return u + (u.indexOf('?') >= 0 ? '&' : '?') + 't=' + (new Date()).getTime();	
		}	
	};	
	return new LoadManage();	
})();	
var LEasing = {	
	None : {	
		easeIn : function (t, b, c, d) {	
			return b + t * c / d;	
		},	
		easeOut : function (t, b, c, d) {	
			return b + t * c / d;	
		},	
		easeInOut : function (t, b, c, d) {	
			return b + t * c / d;	
		}	
	},	
	Quad : {	
		easeIn : function (t, b, c, d) {	
			return c * (t /= d) * t + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return -c * (t /= d) * (t - 2) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return c / 2 * t * t + b;	
			}	
			return -c / 2 * ((--t) * (t - 2) - 1) + b;	
		}	
	},	
	Cubic : {	
		easeIn : function (t, b, c, d) {	
			return c * (t /= d) * t * t + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return c * ((t = t / d - 1) * t * t + 1) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return c / 2 * t * t * t + b;	
			}	
			return c / 2 * ((t -= 2) * t * t + 2) + b;	
		}	
	},	
	Quart : {	
		easeIn : function (t, b, c, d) {	
			return c * (t /= d) * t * t * t + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return -c * ((t = t / d - 1) * t * t * t - 1) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return c / 2 * t * t * t * t + b;	
			}	
			return -c / 2 * ((t -= 2) * t * t * t - 2) + b;	
		}	
	},	
	Quint : {	
		easeIn : function (t, b, c, d) {	
			return c * (t /= d) * t * t * t * t + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return c * ((t = t / d - 1) * t * t * t * t + 1) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return c / 2 * t * t * t * t * t + b;	
			}	
			return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;	
		}	
	},	
	Sine : {	
		easeIn : function (t, b, c, d) {	
			return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return c * Math.sin(t / d * (Math.PI / 2)) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;	
		}	
	},	
	Strong : {	
		easeIn : function (t, b, c, d) {	
			return c * (t /= d) * t * t * t * t + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return c * ((t = t / d - 1) * t * t * t * t + 1) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return c / 2 * t * t * t * t * t + b;	
			}	
			return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;	
		}	
	},	
	Expo : {	
		easeIn : function (t, b, c, d) {	
			return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if (t == 0) {	
				return b;	
			}	
			if (t == d) {	
				return b + c;	
			}	
			if ((t /= d / 2) < 1) {	
				return c / 2 * Math.pow(2, 10 * (t - 1)) + b;	
			}	
			return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;	
		}	
	},	
	Circ : {	
		easeIn : function (t, b, c, d) {	
			return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;	
		},	
		easeOut : function (t, b, c, d) {	
			return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;	
		},	
		easeInOut : function (t, b, c, d) {	
			if ((t /= d / 2) < 1) {	
				return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;	
			}	
			return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;	
		}	
	},	
	Elastic : {	
		easeIn : function (t, b, c, d, a, p) {	
			var s;	
			if (t == 0) {	
				return b;	
			}	
			if ((t /= d) == 1) {	
				return b + c;	
			}	
			if (!p) {	
				p = d * .3;	
			}	
			if (!a || a < Math.abs(c)) {	
				a = c;	
				s = p / 4;	
			} else {	
				s = p / (2 * Math.PI) * Math.asin(c / a);	
			}	
			return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;	
		},	
		easeOut : function (t, b, c, d, a, p) {	
			var s;	
			if (t == 0) {	
				return b;	
			}	
			if ((t /= d) == 1) {	
				return b + c;	
			}	
			if (!p) {	
				p = d * .3;	
			}	
			if (!a || a < Math.abs(c)) {	
				a = c;	
				s = p / 4;	
			} else {	
				s = p / (2 * Math.PI) * Math.asin(c / a);	
			}	
			return (a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b);	
		},	
		easeInOut : function (t, b, c, d, a, p) {	
			var s;	
			if (t == 0) {	
				return b;	
			}	
			if ((t /= d / 2) == 2) {	
				return b + c;	
			}	
			if (!p) {	
				p = d * (.3 * 1.5);	
			}	
			if (!a || a < Math.abs(c)) {	
				a = c;	
				s = p / 4;	
			} else {	
				s = p / (2 * Math.PI) * Math.asin(c / a);	
			}	
			if (t < 1) {	
				return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;	
			}	
			return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;	
		}	
	},	
	Back : {	
		easeIn : function (t, b, c, d, s) {	
			if (typeof s == UNDEFINED) {	
				s = 1.70158;	
			}	
			return c * (t /= d) * t * ((s + 1) * t - s) + b;	
		},	
		easeOut : function (t, b, c, d, s) {	
			if (typeof s == UNDEFINED) {	
				s = 1.70158;	
			}	
			return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;	
		},	
		easeInOut : function (t, b, c, d, s) {	
			if (typeof s == UNDEFINED) {	
				s = 1.70158;	
			} 	
			if ((t /= d / 2) < 1) {	
				return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;	
			}	
			return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;	
		}	
	},	
	Bounce : {	
		easeIn : function (t, b, c, d) {	
			return c - LEasing.Bounce.easeOut(d - t, 0, c, d) + b;	
		},	
		easeOut : function (t, b, c, d) {	
			if ((t /= d) < (1 / 2.75)) {	
				return c * (7.5625 * t * t) + b;	
			} else if (t < (2 / 2.75)) {	
				return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;	
			} else if (t < (2.5 / 2.75)) {	
				return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;	
			} else {	
				return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;	
			}	
		},	
		easeInOut : function (t, b, c, d) {	
			if (t < d / 2) {	
				return LEasing.Bounce.easeIn(t * 2, 0, c, d) * .5 + b;	
			}	
			return LEasing.Bounce.easeOut(t * 2 - d, 0, c, d) * .5 + c * .5 + b;	
		}	
	}	
};	
var Quad = LEasing.Quad,	
Cubic = LEasing.Cubic,	
Quart = LEasing.Quart,	
Quint = LEasing.Quint,	
Sine = LEasing.Sine,	
Strong = LEasing.Strong,	
Expo = LEasing.Expo,	
Circ = LEasing.Circ,	
Elastic = LEasing.Elastic,	
Back = LEasing.Back,	
Bounce = LEasing.Bounce;	
var LTweenLiteTimeline;	
var LTweenLite = (function () {	
	function LTweenLiteChild ($target, $duration, $vars) {	
		var s = this;	
		LExtends (s, LObject, []);	
		s.type = "LTweenLiteChild";	
		s.toNew = [];	
		s.init($target, $duration, $vars);	
	}	
	var p = {	
		init : function($target, $duration, $vars) {	
			var s = this, k = null;	
			if (typeof $vars["tweenTimeline"] == UNDEFINED) {	
				$vars["tweenTimeline"] = LTweenLite.TYPE_FRAME;	
			}	
			s.target = $target;	
			s.duration = $duration || 0.001;	
			s.vars = $vars;	
			s.delay = s.vars.delay || 0;	
			if(s.vars["tweenTimeline"] == LTweenLite.TYPE_TIMER){	
				s.currentTime = (new Date()).getTime() / 1000;	
				s.initTime = s.currentTime;	
				s.startTime = s.initTime + s.delay;	
			}else{	
				s.currentTime = 0;	
				s.duration *= 1000;	
				s.currentTime -= s.delay * 1000;	
			}	
			s.combinedTimeScale = s.vars.timeScale || 1;	
			s.active = s.duration == 0 && s.delay == 0;	
			s.varsto = {};	
			s.varsfrom = {};	
			s.stop = false;	
			if (typeof(s.vars.ease) != "function") {	
				s.vars.ease = LEasing.None.easeIn;	
			}	
			s.ease = s.vars.ease;	
			delete s.vars.ease;	
			if (s.vars.onComplete) {	
				s.onComplete = s.vars.onComplete;	
				delete s.vars.onComplete;	
			}	
			if (s.vars.onUpdate) {	
				s.onUpdate = s.vars.onUpdate;	
				delete s.vars.onUpdate;	
			}	
			if (s.vars.onStart) {	
				s.onStart = s.vars.onStart;	
				delete s.vars.onStart;	
			}	
			for (k in s.vars) {	
				s.varsto[k] = s.vars[k];	
				s.varsfrom[k] = s.target[k];	
			}	
		},	
		pause : function () {	
			this.stop = true;	
		},	
		resume : function () {	
			this.stop = false;	
		},	
		tween : function () {	
			var s = this, tweentype;	
			var type_timer = (s.vars["tweenTimeline"] == LTweenLite.TYPE_TIMER);	
			if (type_timer) {	
				var time = (new Date()).getTime() / 1000, etime = time - s.startTime;	
				if (etime < 0) {	
					return;	
				}	
			} else {	
				if (s.stop) {	
					return;	
				}	
				s.currentTime += LGlobal.speed;	
				if (s.currentTime < 0) {	
					return;	
				}	
			}	
			for (tweentype in s.varsto) {	
				if (tweentype == "tweenTimeline") {	
					continue;	
				}	
				if (type_timer) {	
					s.target[tweentype] = s.ease(etime, s.varsfrom[tweentype], s.varsto[tweentype] - s.varsfrom[tweentype], s.duration);	
				} else {	
					s.target[tweentype] = s.ease(s.currentTime, s.varsfrom[tweentype], s.varsto[tweentype] - s.varsfrom[tweentype], s.duration);	
				}	
			}	
			if (s.onStart) {	
				s._dispatchEvent(s.onStart);	
				delete s.onStart;	
			}	
			var e;	
			if (type_timer) {	
				e = (etime >= s.duration);	
			} else {	
				e = (s.currentTime >= s.duration);	
			}	
			if (e) {	
				for (tweentype in s.varsto) {	
					s.target[tweentype] = s.varsto[tweentype];	
				}	
				if (s.onComplete) {	
					s._dispatchEvent(s.onComplete);	
				}	
				return true;	
			} else if (s.onUpdate) {	
				s._dispatchEvent(s.onUpdate);	
			}	
			return false;	
		},	
		_dispatchEvent : function (f) {	
			var s = this;	
			s.target.target = s.target;	
			s.target.currentTarget = s;	
			f(s.target);	
			delete s.target.currentTarget;	
			delete s.target.target;	
		},	
		to : function ($target, $duration, $vars) {	
			var s = this;	
			s.toNew.push({target : $target, duration : $duration, vars : $vars});	
			return s;	
		},	
		keep : function () {	
			var s = this, t, vs, k;	
			if (s.toNew.length > 0) {	
				t = s.toNew.shift();	
				if (t.vars.loop) {	
					s.loop = true;	
				}	
				if (s.loop) {	
					vs = {};	
					for (k in t.vars) {	
						vs[k] = t.vars[k];	
					}	
					s.to(t.target, t.duration, vs);	
				}	
				s.init(t.target, t.duration, t.vars);	
				return true;	
			}	
			return false;	
		}	
	};	
	for (var k in p) {	
		LTweenLiteChild.prototype[k] = p[k];	
	}	
	function LTweenLite () {	
		var s = this;	
		LExtends (s, LObject, []);	
		s.type = "LTweenLite";	
		s.tweens = [];	
	}	
	LTweenLite.TYPE_FRAME = "type_frame";	
	LTweenLite.TYPE_TIMER = "type_timer";	
	p = {	
		count : function(){	
			return this.tweens.length;	
		},	
		ll_show : function(){	
			var s = this;	
			var i, length = s.tweens.length, t;	
			for (i = 0; i < length; i++) {	
				t = s.tweens[i];	
				if (t && t.tween && t.tween()) {	
					s.tweens.splice(i, 1);	
					i--;	
					length = s.tweens.length;	
					if (t.keep()) {	
						s.add(t);	
					}	
				}	
			}	
		},	
		to : function ($target, $duration, $vars) {	
			if (!$target) {	
				return;	
			}	
			var s = this;	
			var tween = new LTweenLiteChild({}, 0, {});	
			s.tweens.push(tween);	
			tween.to($target, $duration, $vars);	
			return tween;	
		},	
		add : function (tween) {	
			this.tweens.push(tween);	
		},	
		remove : function (tween) {	
			var s = this;	
			if (typeof tween == UNDEFINED) {	
				return;	
			}	
			for (var i = 0, l = s.tweens.length; i < l; i++) {	
				if (tween.objectIndex == s.tweens[i].objectIndex) {	
					s.tweens.splice(i, 1);	
					break;	
				}	
			}	
		},	
		removeAll : function () {	
			this.tweens.splice(0, this.tweens.length);	
		},	
		pauseAll : function () {	
			for(var i = 0, l = this.tweens.length; i < l; i++){	
				this.tweens[i].pause();	
			}	
		},	
		resumeAll : function () {	
			for(var i = 0, l = this.tweens.length; i < l; i++){	
				this.tweens[i].resume();	
			}	
		}	
	};	
	for (var k in p) {	
		LTweenLite.prototype[k] = p[k];	
	}	
	LTweenLiteTimeline = new LTweenLite();	
	LGlobal.childList.push(LTweenLiteTimeline);	
	var tween = new LTweenLite();	
	tween.TYPE_FRAME = LTweenLite.TYPE_FRAME;	
	tween.TYPE_TIMER = LTweenLite.TYPE_TIMER;	
	LGlobal.childList.push(tween);	
	return tween;	
})();	
var LAjax = (function () {	
	function LAjax () {	
		this.responseType = null;	
	}	
	LAjax.prototype = {	
		TEXT : "text",	
		JSON : "json",	
		ARRAY_BUFFER : "arraybuffer",	
		BLOB : "blob",	
		get : function (url, data, oncomplete, onerror) {	
			this.getRequest("GET", url, data, oncomplete, onerror);	
		},	
		post : function (url, data, oncomplete, onerror) {	
			this.getRequest("POST", url, data, oncomplete, onerror);	
		},	
		getRequest : function (t, url, d, oncomplete, err) {	
			var s = this, k, data = "", a = "";	
			s.err = err;	
			var ajax = s.getHttp();	
			if (!ajax) {	
				return;	
			}	
			if (d) {	
				for (k in d) {	
					data += (a + k + "=" + d[k]);	
					a = "&";		
				}	
			}	
			if (t.toLowerCase() == "get" && data.length > 0) {	
				url += ((url.indexOf('?') >= 0 ? '&' : '?') + data);	
				data = null;	
			}	
			ajax.open(t, url, true);	
			if (s.responseType) {	
				if(s.responseType == s.JSON){	
					try{	
						ajax.responseType = s.responseType;	
					}catch(e){	
						ajax.responseType = s.TEXT;	
						ajax._responseType = "json";	
					}	
				}else{	
					ajax.responseType = s.responseType;	
				}	
				s.responseType = s.TEXT;	
			}	
			ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");	
			ajax.onreadystatechange = function () {	
				if (ajax.readyState == 4) {	
					if (ajax.status >= 200 && ajax.status < 300 || ajax.status === 304) {	
						if (oncomplete) {	
							if(ajax._responseType == s.JSON){	
								ajax._responseType = s.TEXT;	
								oncomplete(JSON.parse(ajax.responseText));	
							}else if (ajax.responseType == s.ARRAY_BUFFER || ajax.responseType == s.BLOB || ajax.responseType == s.JSON) {	
								oncomplete(ajax.response);	
							} else if (ajax.responseText.length > 0) {	
								oncomplete(ajax.responseText);	
							} else {	
								oncomplete(null);	
							}	
						}	
					} else {	
						if (err) {	
							err(ajax);	
						}	
					}	
		 		}	
			};	
			ajax.send(data);	
		},	
		getHttp : function () {	
			if (typeof XMLHttpRequest != UNDEFINED) {	
				return new XMLHttpRequest();	
			}  	
			try {	
				return new ActiveXObject("Msxml2.XMLHTTP");	
			} catch (e) {	
				try {	
					return new ActiveXObject("Microsoft.XMLHTTP");	
				} catch (e) {	
					if (!this.err) {	
						this.err(e);	
					}	
				}	
			}	
			return false;	
		}	
	};	
	return new LAjax();	
})();	
var LStageWebView = (function () {	
	function LStageWebView () {	
		var s = this;	
		LExtends(s, LEventDispatcher, []);	
		s.display = document.createElement("div");	
		s.iframe = document.createElement("iframe");	
		s.display.style.position = "absolute";	
		s.display.style.marginTop = "0px";	
		s.display.style.marginLeft = "0px";	
		s.display.style.zIndex = 11;	
		if(LGlobal.ios){	
			s.display.style.overflow = "auto";	
			s.display.style.webkitOverflowScrolling = "touch";	
		}	
		s.display.appendChild(s.iframe);	
		s.idAdded = false;	
	}	
	var p = {	
		loadURL : function (u) {	
			var s = this;	
			s.iframe.src = u;	
			s.iframe.onload = function () {	
				s.dispatchEvent(LEvent.COMPLETE);	
			};	
		},	
		show : function () {	
			var s = this;	
			if (!s.idAdded) {	
				LGlobal.object.appendChild(s.display);	
				s.idAdded = true;	
			}	
			if (s.display.style.display == "none") {	
				s.display.style.display = "";	
			}	
		},	
		die : function () {	
			LGlobal.object.removeChild(this.display);	
			this.idAdded = false;	
		},	
		hide : function () {	
			this.display.style.display = "none";	
		},	
		setViewPort : function (r) {	
			var s = this, sx = parseInt(LGlobal.canvasObj.style.width) / LGlobal.canvasObj.width, sy = parseInt(LGlobal.canvasObj.style.height) / LGlobal.canvasObj.height;	
			s.display.style.marginTop = (parseInt(LGlobal.canvasObj.style.marginTop) + ((r.y * sy) >>> 0)) + "px";	
			s.display.style.marginLeft = (parseInt(LGlobal.canvasObj.style.marginLeft) + ((r.x * sx) >>> 0)) + "px";	
			s.iframe.style.width = s.display.style.width = (r.width * sx >>> 0) + "px";	
			s.iframe.style.height = s.display.style.height = (r.height * sy >>> 0) + "px";	
		}	
	};	
	for (var k in p) {	
		LStageWebView.prototype[k] = p[k];	
	}	
	return LStageWebView;	
})();	
var FPS = (function () {	
	function FPS(){	
		var s = this;	
		LExtends(s,LSprite,[]);	
		if (!LGlobal.fpsStatus) {	
			LGlobal.fpsStatus = {	
				a : 0,	
				b : 0,	
				c : 0,	
				d : 0,	
				e : 0,	
				bitmapData : 0,	
				display : 0,	
				transform : 0,	
				graphics : 0,	
				text : 0,	
				reset : function () {	
					this.a = this.bitmapData;	
					this.b = this.display - 1;	
					this.c = this.transform - 1;	
					this.d = this.graphics - 1;	
					this.e = this.text - 5;	
					this.bitmapData = 0;	
					this.display = 0;	
					this.transform = 0;	
					this.graphics = 0;	
					this.text = 0;	
				}	
			};	
		}	
		s.fps = [];	
		s.back = new LShape();	
		s.back.alpha = 0.5;	
		s.addChild(s.back);	
		for(var i=0;i<5;i++){	
			var f = new LTextField();	
			f.color = "#ffffff";	
			f.y = i * 20;	
			s.addChild(f);	
			s.fps.push(f);	
		}	
		s.fpsCount = 0;	
		s.fpsTime = (new Date()).getTime();	
		s.addEventListener(LEvent.ENTER_FRAME,s.showFPS);	
	}	
	FPS.prototype.showFPS = function(e){	
		var s = e.currentTarget, t, f;	
		s.fpsCount++;	
		t = (new Date()).getTime();	
		if(t - s.fpsTime < 1000)return;	
		s.fps[0].text = "FPS : " + Math.round(s.fpsCount*10000 / (t-s.fpsTime))/10; 	
		f = LGlobal.fpsStatus;	
		s.fps[1].text = "DisplayObject : " + f.c + "/" + f.b; 	
		s.fps[2].text = "Draw image : " + f.a; 	
		s.fps[3].text = "Drwa graphics : " + f.d; 	
		s.fps[4].text = "Draw text : " + f.e; 	
		s.fpsTime = t;	
		s.fpsCount = 0;	
		s.back.graphics.clear();	
		s.back.graphics.drawRect(0,"#000000",[0,0,s.fps[1].getWidth(),100],true,"#000000");	
	};	
	FPS.prototype.die = function(){	
		var s = this;	
		LGlobal.fpsStatus = null;	
		s.callParent("die",arguments);	
	};	
	return FPS;	
})();	
