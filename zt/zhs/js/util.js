/**
 * 全局定义
 * @author stuart.shi
 * @link http://www.shizuwu.cn
 * @time 2014.4
 */
(function() {
	//常量定义
	var Util = {
		"APP_URL": "http://local.zt/zhs/",
		"API_HOST": "http://local.zt/zhs/",
		"NO_AVATAR": "",
		"loading": {
			"default": [{
				"src": 'image/loading.png',
				"id": "bg"
			}, {
				"src": "image/loading_pic.png",
				"id": "loading"
			}, {
				"src": "image/team.png",
				"id": "team"
			}, {
				"src": "image/login.ogg",
				"id": "login"
			}]
		},
		"themes": {
			"default": [{
				"src": 'image/game_bg.png',
				"id": "bg"
			}, {
				"src": 'image/start.png',
				"id": "start"
			}, {
				"src": 'image/avatar.png',
				"id": "icons"
			}, {
				"src": 'image/top.png',
				"id": "top"
			}, {
				src: "image/s_disappear3.ogg",
				id: "level3"
			}, {
				src: "image/s_disappear4.ogg",
				id: "level4"
			}, {
				src: "image/s_disappear5.ogg",
				id: "level5"
			}, {
				src: "image/s_slide.ogg",
				id: "slide"
			}, {
				src: "image/s_background.ogg",
				id: "bgsound"
			}, {
				src: "image/s_readygo.ogg",
				id: "ready"
			}, {
				"src": 'image/qzone.png',
				"id": "qzone"
			}, {
				"src": 'image/sina.png',
				"id": "sina"
			}, {
				"src": 'image/myhome.png',
				"id": "myhome"
			}],
			"ai4": [{
				"src": 'image/game_bg.png',
				"id": "bg"
			}, {
				"src": 'image/avatar.png',
				"id": "icons"
			}]
		}
	}

	$.extend({
		/**
		 * 获取网页url的参数
		 * @param  {[type]} name [description]
		 * @param  {[type]} url  [description]
		 * @return {[type]}      [description]
		 */
		getVar: function(name, url) {
			var vars = [],
				hash;
			if ("undefined" == typeof url || url == "") {
				var url = window.location.href;
			}
			var hashes = url.slice(url.indexOf('?') + 1).split('&');
			for (var i = 0; i < hashes.length; i++) {
				hash = hashes[i].split('=');
				vars.push(hash[0]);
				vars[hash[0]] = hash[1];
			}
			if (typeof name != 'undefined') {
				return typeof vars[name] != 'undefined' ? vars[name] : 0;
			} else {
				return vars;
			}
		},

		/**
		 * 模板替换
		 * @param  {[type]} tpl [description]
		 * @param  {[type]} op  [description]
		 * @return {[type]}     [description]
		 */
		renderTpl: function(tpl, op) {
			return tpl.replace(/<%\=(\w+)%>/g, function(e1, e2) {
				return op[e2] != null ? op[e2] : "";
			});
		},
		/**
		 * 日志输出
		 * @param  {[type]} msg [description]
		 * @return {[type]}     [description]
		 */
		log: function(msg) {
			console.log(msg);
		},

		/**
		 * ajax get
		 * @param  {[type]}   url      [description]
		 * @param  {[type]}   data     [description]
		 * @param  {Function} callback [description]
		 * @param  {[type]}   config   [description]
		 * @return {[type]}            [description]
		 */
		ajaxGet: function(url, data, callback, config) {
			$.extend(data, {
				//自定义全局参数
			})
			var config = $.extend({
				type: "GET",
				url: url,
				data: data,
				dataType: "json",
				success: function(msg) {
					callback && callback(msg);
				}
			}, config);

			var ajaxXhr = $.ajax(config);

			ajaxXhr.error(function() {
				if (ajaxXhr.status == 404) {
					//错误处理
				}
			});

		},

		/**
		 * ajax post
		 * @param  {[type]}   url      [description]
		 * @param  {[type]}   data     [description]
		 * @param  {Function} callback [description]
		 * @return {[type]}            [description]
		 */
		ajaxPost: function(url, data, callback) {
			var ajaxXhr = $.ajax({
				type: "POST",
				url: url,
				data: data,
				dataType: "json",
				success: function(msg) {
					callback && callback(msg);
				},
				error: function() {
					if (ajaxXhr.status == 404) {
						//错误处理
					}
				}
			});
		},

		/**
		 * 格式化数字
		 * @param  {[type]} s [description]
		 * @return {[type]}   [description]
		 */
		formatNumber: function(s) {
			s = parseFloat((s + "").replace(/[^\d\.-]/g, "")) + "";
			var l = s.split(".")[0].split("").reverse();
			var t = "";
			for (i = 0; i < l.length; i++) {
				t += l[i] + ((i + 1) % 3 == 0 && (i + 1) != l.length ? "," : "");
			}
			return t.split("").reverse().join("");
		},

		/**
		 * 分享到qq空间
		 * @return {[type]} [description]
		 */
		shareSNS: function() {
			var p = {
				url: "",
				desc: "",
				summary: "",
				title: "",
				site: '',
				pics: ""
			};
			var s = [];
			for (var i in p) {
				s.push(i + '=' + encodeURIComponent(p[i] || ''));
			}
			window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?' + s.join('&'));
		}
	});

	/**
	 * 数组克隆
	 * @return {[type]} [description]
	 */
	Array.prototype.clone = function() {
		return this.slice(0);
	};

	/**
	 * 数组去重
	 * @param  {[type]} t [description]
	 * @return {[type]}   [description]
	 */
	Array.prototype.unique = function(t) {
		with(this)
		return !t ? join(",").match(/([^,]+)(?!.*\1)/ig) : reverse().join(",").match(/([^,]+)(?!.*\1)/ig).reverse();
	}

	window.Util = Util;
})();