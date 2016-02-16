(function($) {
	$.fn.semlessNoScale = function(opt) {
		var defult = {
			"mode": "hor",
			"vis": 5,
			"normal": null,
			"scale": null,
			"margin": 10,
			"imgborder": 0,
			"spd": 680
		};
		var user = {};
		for (var x in defult) {
			user[x] = $.compareOptions(opt[x], defult[x]);
		}
		var boderWidth = parseInt(user.imgborder) * 2;
		var wrapperInfo = (function() {
			switch (user.mode) {
				case "hor":
					return {
						"width": (user.vis - 1) * user.margin + user.vis * user.normal[0] + boderWidth + user.vis * boderWidth,
						"height": user.normal[1] + boderWidth
					};
					break;
				case "ver":
					return {
						"width": user.normal[0] + boderWidth,
						"height": (user.vis - 1) * user.margin + user.vis * user.normal[1] + boderWidth + user.vis * boderWidth
					};
					break;
			}
		})();
		var index = 0;
		var active = Math.round(user.vis / 2) - 1;
		var canClick = false;
		var queueArr = [];
		var posArr = [];
		$(this).css({
			"width": wrapperInfo.width + "px",
			"height": wrapperInfo.height + "px"
		});
		$(this).find(".seamlessWrapper").css({
			"width": "100%",
			"height": "100%",
			"overflow": "hidden",
			"position": "relative"
		});
		$(this).find(".seamlessChild").css({
			"border": user.imgborder,
			"overflow": "hidden"
		});
		$(this).find(".seamlessChild img").css({
			"width": "100%"
		})
		$(this).find(".seamlessChild").eq(active).addClass("active");
		var seamlessDiv = $(this).find(".seamlessChild");
		var sumIndex = seamlessDiv.size() + 1;
		var maxIndex = seamlessDiv.size() - 1;
		seamlessDiv.each(function(i) {
			var idex = i - 1;
			if (i == 0) {
				if (user.mode == "hor") {
					var left = boderWidth / 2;
				} else {
					var top = boderWidth / 2;
				}
			} else {
				if (user.mode == "hor") {
					var left = seamlessDiv.eq(idex).position().left + seamlessDiv.eq(idex).outerWidth() + user.margin;
				} else {
					var top = seamlessDiv.eq(idex).position().top + seamlessDiv.eq(idex).outerHeight() + user.margin;
				}
			}
			$(this).attr("index", i);
			if (user.mode == "hor") {
				posArr.push(left);
				$(this).css({
					"width": (user.normal[0]),
					"height": (user.normal[1]),
					"position": "absolute",
					"left": left,
					"top": 0
				});
			} else {
				posArr.push(top);
				$(this).css({
					"width": (user.normal[0]),
					"height": (user.normal[1]),
					"position": "absolute",
					"left": 0,
					"top": top,
				});
			}
		});
		if (user.mode == "hor") {
			posArr.push(posArr[posArr.length - 1] + user.normal[0] + user.margin + boderWidth);
			posArr.splice(0, 0, posArr[0] - user.normal[0] - user.margin - boderWidth);
		} else {
			posArr.push(posArr[posArr.length - 1] + user.normal[1] + user.margin + boderWidth);
			posArr.splice(0, 0, posArr[0] - user.normal[1] - user.margin - boderWidth);
		}
		var father = $(this);
		var runPre = function(p, q) {
			switch (user.mode) {
				case "ver":
					var c = new verMode();
					return c.pre(p, q);
					runPre = function(p, q) {
						return c.pre(p, q);
					}
					break;
				case "hor":
					var c = new horMode();
					return c.pre(p, q);
					runPre = function(p, q) {
						return c.pre(p, q);
					}
					break;
			}
		};
		var runNext = function(p, q) {
			switch (user.mode) {
				case "ver":
					var c = new verMode();
					return c.next(p, q);
					runPre = function(p, q) {
						return c.next(p, q);
					};
					break;
				case "hor":
					var c = new horMode();
					return c.next(p, q);
					runPre = function(p, q) {
						return c.next(p, q);
					};
					break;
			}
		}
		var horMode = function() {};
		var verMode = function() {};
		horMode.prototype.pre = function(n, q) {
			return {
				"width": user.normal[0],
				"height": user.normal[1],
				"top": 0,
				"left": posArr[n + 1]
			}
		};
		horMode.prototype.next = function(n, q) {
			return {
				"width": user.normal[0],
				"height": user.normal[1],
				"top": 0,
				"left": posArr[n]
			}
		};
		verMode.prototype.pre = function(n, q) {
			return {
				"width": user.normal[0],
				"height": user.normal[1],
				"left": 0,
				//				"margin-left":-(user.normal[0] / 2),
				"top": posArr[n + 1]
			}
		};
		verMode.prototype.next = function(n, q) {
			return {
				"width": user.normal[0],
				"height": user.normal[1],
				"left": 0,
				//				"margin-left":-(user.normal[0] / 2),
				"top": posArr[n]
			}
		};
		if ($(this).find(".left")) {
			$(this).find(".left").bind("click", function() {
				public_api.pre();
			});
		}
		if ($(this).find(".right")) {
			$(this).find(".right").bind("click", function() {
				public_api.next();
			});
		}

		var public_api = {
			pre: function() {
				if (canClick) {
					return false;
				}
				canClick = true;
				active -= 1;
				if (active < 0) {
					active = maxIndex;
				}
				var insertDiv = (user.mode == "hor") ? father.find(".seamlessChild").last().clone().css("left", posArr[0]) : father.find(".seamlessChild").last().clone().css("top", posArr[0]);
				father.find(".seamlessWrapper").prepend(insertDiv);
				father.find(".pre").removeClass("pre");
				father.find(".active").removeClass("active").addClass("pre");
				father.find(".seamlessChild").each(function(i) {
					var index = $(this).index()
					if (parseInt($(this).attr("index")) == active) {
						var isActive = true;
						public_api.activeIndex = active;
						$(this).addClass("active");
					}
					var modeList = runPre(i, isActive);
					$(this).animate(modeList, user.spd, function() {
						queueArr.push($(this));
						if (queueArr.length == sumIndex) {
							queueArr = [];
							father.find(".seamlessChild").last().remove();
						}
						canClick = false;
					});
				});
			},
			next: function() {
				if (canClick) {
					return false;
				}
				canClick = true;
				active += 1;
				if (active > maxIndex) {
					active = 0;
				}
				var insertDiv = (user.mode == "hor") ? father.find(".seamlessChild").first().clone().css("left", posArr[posArr.length - 1]) : father.find(".seamlessChild").first().clone().css("top", posArr[posArr.length - 1]);
				father.find(".seamlessWrapper").append(insertDiv);
				father.find(".pre").removeClass("pre");
				father.find(".active").removeClass("active").addClass("pre");
				father.find(".seamlessChild").each(function(i) {
					var index = $(this).index();
					if (parseInt($(this).attr("index")) == active) {
						$(this).addClass("active");
						public_api.activeIndex = active;
						var isActive = true;
					}
					var modeList = runNext(i, isActive);
					$(this).animate(modeList, user.spd, function() {
						queueArr.push($(this));
						if (queueArr.length == sumIndex) {
							queueArr = [];
							father.find(".seamlessChild").first().remove();
						}
						canClick = false;
					});
				})
			}
		};
		return public_api;
	};
	$.fn.semless = function() {
		var obj = $(this);
		var dir = parseInt($(this).attr("dir"));
		obj.timer = null;
		var start = 0;
		obj.timer = setInterval(function() {
			start -= 2;
			obj.css("background-position-x", start)
		}, 1000 / 60);
	};
})(jQuery);
$.extend({
	ranNum: function(min, max) {
		return Math.floor(Math.random() * (max - min + 1) + min);
	},
	ranArr: function(min, max) {
		var arr = [];
		var bol = true;
		var o = 0;
		var isPush = true;
		var isCheck = true;
		while (bol) {
			if (o > max - min) {
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
	compareOptions: function(a, b) {
		var result = (a != null || a != undefined) ? a : b;
		return result;
	}
});