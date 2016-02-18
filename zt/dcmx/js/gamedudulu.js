
/***************************** Game 9G 主类 *********************************/

Gamedudulu = function(gameid) {
	this.gameid = gameid;
	this.spid = null;
	this.baseurl = "";
	this.gameurl = "";
	this.homeurl = null;
	this.gzurl = null;
	this.score = null;
	this.scoreName = null;
	this.shareDomain = null;
	this.shareDomains = ["ytins.cn", "ytins.cn", "ytins.cn", "impak.cn", "impak.cn", "cneps.cn"];
	this.shareData = {
		imgurl: null,
		link: null,
		title: "多彩梦想 手绘创纪录",
		content: "多彩梦想 手绘创纪录"
	};
	this.app = null;
	this.utils = new GameduduluUtils(this);
	this.user = null;
	this.event = null;
	this.init();
}

function getRandomNUM(Min,Max) {
	var Range = Max - Min; 
	var Rand = Math.random(); 
	return(Min + Math.round(Rand * Range)); 
}

var DDL_CONFIG = {
	root_url: "http://www.bangbangu.com",
	follow_url: "http://mp.weixin.qq.com/s?__biz=MzA3MDQzNzIwNQ==&mid=200534205&idx=1&sn=bb86d0db54d0aa61857a2f5720bb9f70&scene=1#rd",
	social_url: "http://wsq.qq.com/reflow/262979949",
	redirect_url: "http://www.bangbangu.com",//'http://mp.weixin.qq.com/s?__biz=MzA3MDQzNzIwNQ==&mid=200534205&idx=1&sn=bb86d0db54d0aa61857a2f5720bb9f70#rd';

	redirect_array : [
		//"oliverqueen.duapp.com",
		//"johndiggle.duapp.com",
		//"dinahlaurellance.duapp.com",
		//"saralance.duapp.com",
		//"tommymerlyn.duapp.com",
		//"theaqueen.duapp.com",
		//"royharper.duapp.com",
		//"moiraqueen.duapp.com",
		"www.syflgw.cn",
		"www.duduluwan.com"
	],
}

function getRandomURL() {
	var num = getRandomNUM(0,DDL_CONFIG.redirect_array.length-1);
	return 'http://' + DDL_CONFIG.redirect_array[num];
}

// 初始化
Gamedudulu.prototype.init = function() {
	this.spid = this.utils.getParameter("spid");
	this.gameurl = "/gamecenter.html?gameid=" + this.gameid + (this.spid ? "&spid=" + this.spid : "") + (localStorage.myuid ? "&uid=" + localStorage.myuid : "");
	this.homeurl = this.baseurl + "/top.htm" + (this.spid ? "?spid=" + this.spid : "");
	this.gzurl = "http://www.bangbangu.com";
	this.shareData.imgurl = "http://www.bangbangu.com/games/qmzbj/img/beijing.png";
	this.shareData.link = getRandomURL() + "?target=/qmzbj/index.htm";
	switch (this.utils.getAppType()) {
		case "wx":
			this.app = new GameduduluWx(this);
			break;
		case "uc":
			this.app = new GameduduluUC(this);
			break;
	}
	
};

// 分享
Gamedudulu.prototype.share = function() {
	// 调用各自 App 的分享接口
	this.app && this.app.share();
}


Gamedudulu.prototype.isTest = function() {
	return (
		localStorage.myuid == "b1Atb251RGNNZktTeTRCdXp3NDFCMkpoNzR0OA=="
		|| localStorage.myuid == "b1Atb251Q2lza25RWFRIVnowTXczSmRjMWpDRQ=="
		|| localStorage.myuid == "b1Atb251SlZhY0JjQ25za3lmUlhuX2JiVGszcw=="
	);
}

/***************************** 实用工具类 *********************************/

GameduduluUtils = function(Gamedudulu) {
	this.Gamedudulu = Gamedudulu;
}

// 判断当前 App [微信、UC浏览器、etc]
GameduduluUtils.prototype.getAppType = function() {
	var e = navigator.userAgent.toLowerCase();
	if (e.match(/MicroMessenger/i) == "micromessenger") {
		return "wx";
	}
	else if (e.match(/UCBrowser/i) == "ucbrowser") {
		return "uc";
	}
	else {
		return "other";
	}
}

// 获取 URL 参数
GameduduluUtils.prototype.getParameter = function(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	var r = window.location.search.substr(1).match(reg);
	if (r != null) return r[2]; return null;
}

// 返回当前时间（秒值）
GameduduluUtils.prototype.now = function() {
	var dt = new Date();
	dt.setMilliseconds(0);
	return dt.getTime() / 1000;
}

// 返回今天日期（秒值）
GameduduluUtils.prototype.today = function() {
	var dt = new Date();
	dt.setHours(0, 0, 0, 0);
	return dt.getTime() / 1000;
}

// 格式化日期（参数一：日期对象或秒值；参数二：格式[可选]）
GameduduluUtils.prototype.formatDate = function() {
	var date = arguments[0];
	var format = arguments[1] || "yyyy-MM-dd HH:mm:ss";
	if (typeof date == "number") {
		date = new Date(date * 1000);
	}
	var paddNum = function(num) {
		num += "";
		return num.replace(/^(\d)$/, "0$1");
	}
	var config = {
		yyyy : date.getFullYear(),
		yy : date.getFullYear().toString().substring(2),
		M  : date.getMonth() + 1,
		MM : paddNum(date.getMonth() + 1),
		d  : date.getDate(),
		dd : paddNum(date.getDate()),
		HH : paddNum(date.getHours()),
		mm : paddNum(date.getMinutes()),
		ss : paddNum(date.getSeconds())
	}
	return format.replace(/([a-z])(\1)*/ig, function(m){return config[m];});
}

// 显示分享图片
GameduduluUtils.prototype.showShare = function() {
	var img = document.getElementById("Gamedudulushare");
	if (img) {
		img.style.display = "";
	}
	else {
		img = document.createElement("img");
		img.id = "Gamedudulushare";
		img.src = "http://game.9g.com/share.png";
		img.className = "Gamedudulushare";
		//img.addEventListener("click", this.hideShare);
		img.addEventListener("touchstart", this.hideShare);
		document.getElementsByTagName("body")[0].appendChild(img);
	}
}

// 隐藏分享图片
GameduduluUtils.prototype.hideShare = function() {
	var img = document.getElementById("Gamedudulushare");
	if (img) img.style.display = "none";
}

// 显示分享对话框
GameduduluUtils.prototype.shareConfirm = function(content, callback) {
	var _this = this;
	setTimeout(function(){
		if (_this.Gamedudulu.isTest()) {
			new GameduduluUtilsDialog(_this.Gamedudulu, {
				title: "嘟嘟噜游戏",
				content: content,
				buttons: [
					{ label: "取消", click: function(){ _this.Gamedudulu.eventFlow(); } },
					{ label: "确定", click: callback }
				]
			}).open();
		}
		else {
			new GameduduluUtilsDialog(_this.Gamedudulu, {
				title: "嘟嘟噜游戏",
				content: content,
				buttons: [
					{ label: "取消", click: null },
					{ label: "确定", click: callback }
				]
			}).open();
		}
	}, 1000);
}

// 对话框
GameduduluUtilsDialog = function(Gamedudulu, options) {
	this.Gamedudulu = Gamedudulu;
	this.title = options.title;
	this.content = options.content;
	this.buttons = options.buttons;
}

// 打开对话框
GameduduluUtilsDialog.prototype.open = function() {
	/*if (document.getElementById("Gameduduludialog")) return;
	var div = document.createElement("div");
	div.id = "Gameduduludialog";
	div.className = "Gameduduludialog";
	div.innerHTML = "<header><h2>" + this.title + "</h2></header><section>" + this.content + "</section><footer></footer>";
	for (var i=0; i<this.buttons.length; i++) {
		var btn = this.buttons[i];
		var a = document.createElement("a");
		a.innerHTML = btn.label;
		//a.addEventListener("click", this.close);
		//a.addEventListener("click", btn.click);
		a.addEventListener("touchstart", this.close);
		a.addEventListener("touchstart", btn.click);
		div.getElementsByTagName("footer")[0].appendChild(a);
	}
	document.getElementsByTagName("body")[0].appendChild(div);
	var mask = document.createElement("div");
	mask.id = "Gamedudulumask";
	mask.className="Gamedudulumask";
	document.getElementsByTagName("body")[0].appendChild(mask);*/
}

// 关闭对话框
GameduduluUtilsDialog.prototype.close = function() {
	var div = document.getElementById("Gameduduludialog");
	if (div) document.getElementsByTagName("body")[0].removeChild(div);
	var mask = document.getElementById("Gamedudulumask");
	if (mask) document.getElementsByTagName("body")[0].removeChild(mask);
}

// Ajax 请求
GameduduluUtils.prototype.ajax = function(url, success) {
	new GameduduluUtilsAjax(this.Gamedudulu, "GET", url, null, "json", success);
}

// JSONP 请求
GameduduluUtils.prototype.jsonp = function(url, data, jsonparam, success) {
	jsonparam = jsonparam || "callback";
	new GameduduluUtilsJsonp(url, data, jsonparam, success).request(); 
}

// Ajax 类
GameduduluUtilsAjax = function(Gamedudulu, method, url, data, type, success) {
	this.Gamedudulu = Gamedudulu;
	this.xmlhttp = null;
	if (window.XMLHttpRequest) {
		this.xmlhttp = new XMLHttpRequest();
	}
	else {
		this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	this.type = type;
	this.success = success;
	this.xmlhttp.open(method, url, true);
	var _this = this;
	this.xmlhttp.onreadystatechange = function() {
		_this.callback.apply(_this);
	};
	this.xmlhttp.send(data);
}

// Ajax 请求回调
GameduduluUtilsAjax.prototype.callback = function() {
	if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {
		var data = null;
		switch (this.type) {
			case "text":
				data = this.xmlhttp.responseText;
				break;
			case "json":
				try {
					data = JSON.parse(this.xmlhttp.responseText);
				}
				catch (e) {
					data = this.xmlhttp.responseText;
				}
				break;
		}
		this.success && this.success.call(this.xmlhttp, data);
	}
}

// JSONP 类
GameduduluUtilsJsonp = function(url, data, jsonparam, success, timeout) {
	var finish = false;
	var theHead = document.getElementsByTagName("head")[0] || document.documentElement;
	var scriptControll = document.createElement("script");
	var jsonpcallback = "jsonpcallback" + (Math.random() + "").substring(2);
	var collect = function() {
		if (theHead != null) {
			theHead.removeChild(scriptControll);
			try {
				delete window[jsonpcallback];
			} catch (ex) { }
			theHead = null;
		}
	};
	var init = function() {
		scriptControll.charset = "utf-8";
		theHead.insertBefore(scriptControll, theHead.firstChild);
		window[jsonpcallback] = function(responseData) {
			finish = true;
			success(responseData);
		};
		if (url.indexOf("?") > 0) {
			url = url + "&" + jsonparam + "=" + jsonpcallback;
		} else {
			url = url + "?" + jsonparam + "=" + jsonpcallback;
		}
		if (typeof data == "object" && data != null) {
			for (var p in data) {
				url = url + "&" + p + "=" + escape(data[p]);
			}
		}
	};
	var timer = function() {
		if (typeof window[jsonpcallback] == "function") {
			collect();
		}
		if (typeof timeout == "function" && finish == false) {
			timeout();
		}
	};
	this.request = function() {
		init();
		scriptControll.src = url;
		window.setTimeout(timer, 10000);
	};
}




/***************************** 微信工具类 *********************************/

GameduduluWx = function(Gamedudulu) {
	this.Gamedudulu = Gamedudulu;
	this.init();
}

// 初始化
GameduduluWx.prototype.init = function() {
	var _this = this;
	document.addEventListener("WeixinJSBridgeReady", function onBridgeReady() {
		WeixinJSBridge.on("menu:share:appmessage", function(argv) {
			WeixinJSBridge.invoke("sendAppMessage", {
				"img_url": _this.Gamedudulu.shareData.imgurl,
				"link": _this.Gamedudulu.shareData.link,
				"desc": _this.Gamedudulu.shareData.content,
				"title": _this.Gamedudulu.shareData.title
			}, function(res){
				_this.shareComplete();
			});
		});
		WeixinJSBridge.on("menu:share:timeline", function(argv) {
			WeixinJSBridge.invoke("shareTimeline", {
				"img_url": _this.Gamedudulu.shareData.imgurl,
				"img_width": "640",
				"img_height": "640",
				"link": _this.Gamedudulu.shareData.link,
				"desc": _this.Gamedudulu.shareData.content,
				"title": _this.Gamedudulu.shareData.title
			}, function(res){
				_this.shareComplete();
			});
		});
	}, false);
}

// 分享接口实现
GameduduluWx.prototype.share = function() {
	this.Gamedudulu.utils.showShare();
}

// 分享完成
GameduduluWx.prototype.shareComplete = function() {
	this.Gamedudulu.utils.hideShare();
	if (this.Gamedudulu.isTest()) {
		this.Gamedudulu.eventFlow();
	}
	else {
		this.Gamedudulu.submit();
	}
}


