//common fn start  全局函数or变量请在此定义
//window.onerror = function(e) {
//	alert(e)
//}

function closeMd(id) {
	$(id).hide();
}

function openMd(id) {
	$(id).show();
}
var md = {};
//common fn end
//第1页-->首页 start
(function() {
	$("#qiangBtn").bind("tapone", function() {
		closeMd("#m_1");
		openMd("#m_2");
	});
	$("#daiBtn").bind("tapone", function() {
		closeMd("#m_1");
		openMd("#m_8")
	});
	var isone=false;
	$("#user_mod").bind("tapone", function() {
		closeMd("#m_1");
		openMd("#m_15");
		isone=true;
		if(isone){
			isone=false;
			var mySwiper = new Swiper('.swiper-container', {
				direction: 'horizontal',
				loop: false,
			});		
		}
	});
})();
//第1页-->首页 end

//第2页-->奖品说明 start
(function() {
	$("#yuBtn").bind("tapone", function() {
		closeMd("#m_2");
		openMd("#m_3");
	});
})();
//第2页-->奖品说明 end

//第3页-->活动说明 start
(function() {
	$("#nextBtn").bind("tapone", function() {
		$.ajax({
			async: false,
			url: 'server.php',
			type: "post",
			data: {
				act: 'check'
			},
			dataType: 'json',
			success: function(result) {
				if (result.errcode != 0) {
					closeMd("#m_3");
					openMd("#m_5");
				} else {
					closeMd("#m_3");
					openMd("#m_4");
				}
			}
		});

	});
})();
//第3页-->活动说明 end

//第4页-->第一个表单 start
(function() {
	$.ajax({
		async: false,
		type: 'get',
		url: 'http://pay.yoju360.com/phone/Ext/region/1', //对应省的地址
		dataType: 'jsonp',
		jsonp: "callback",
		success: function(data) {
			if (data.state == 1) {
				var option = "<option value='0'>省份</option>";
				var list = data.data;
				for (var i in list) {
					option = option + '<option value="' + i + '">' + list[i] + '</option>';
				}
				$("#province").html(option);
			}
		},
		error: function() {
			alert("服务器忙，请刷新！")
		}
	});
	$("#province").change(function() {
		if ($("#province").val() != 0) {
			$.ajax({
				async: false,
				type: 'get',
				url: 'http://pay.yoju360.com/phone/Ext/region/' + $("#province").val(),
				dataType: 'jsonp',
				jsonp: "callback",
				success: function(data) {
					if (data.state == 1) {
						var option = "<option value='0'>城市</option>";
						var list = data.data;
						for (var i in list) {
							option = option + '<option value="' + i + '">' + list[i] + '</option>';
						}
						$("#city").html(option);
					}
				},
				error: function() {
					alert("服务器忙，请重试！")
				}
			});
		}
	});
	$("#m_4_submitBtn").bind("tapone", function() {
		var name = $("#name").val();
		var phone = $("#phone").val();
		var address = $("#address").val();
		var province = $("#province").find("option:selected").text();
		var city = $("#city").find("option:selected").text();
		//	    console.log(province);
		if (name == '' || phone == '' || address == '' || province == '省份' || city == '城市') {
			alert('请填写完整的个人信息');
			return false;
		}
		//下面2行摆在ajax回调成功后
		$.ajax({
			async: false,
			url: 'server.php',
			type: "post",
			data: {
				act: 'addinfo',
				name: name,
				phone: phone,
				address: address,
				province: province,
				city: city
			},
			dataType: 'json',
			success: function(result) {
				if (result.errcode != 0) {
					alert(result.errmsg);
					return false;
				} else {
					window.location.href="http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA4NTc5MTkxNw==&shelf_id=3&showwxpaytitle=1#wechat_redirect";
					return false;
					closeMd("#m_4");
					openMd("#m_5");
					return false;
				}
			}
		});

	});
})();
//第4页-->第一个表单 end

//第5页-->抽奖页start
(function() {
	$("#chouBtn").one("tapone", function() {
		var index = 0;
		var stop = false;
		var timer = null;
		var no=[2,3,5,6,8,9]
		var arr = [
			[10, 25],
			[10, 152],
			[10, 278],
			[10, 405],
			[136, 405],
			[262, 405],
			[389, 405],
			[389, 278],
			[389, 152],
			[389, 25],
			[262, 25],
			[136, 25],
		];

		function ranNum(min, max) {
			return Math.floor(Math.random() * (max - min + 1) + min);
		};

		function stopPrice(n) {
				timer = setInterval(function() {
					if (stop) {
						index += 0.1;
					} else {
						index += 0.3;
					}
					if (index > arr.length) {
						index = 0;
						stop = true;
					}
					if (stop && parseInt(index) == n) {
						clearInterval(timer);
						if(n==0||n==2||n==3||n==5||n==6||n==8||n==9||n==11){
							setTimeout(function(){
								closeMd("#m_5");
								openMd("#m_6");								
							},800)
						}
						else{
							setTimeout(function(){
								closeMd("#m_5");
								openMd("#m_7");								
							},800)

						}
					}
					$("#pr_border").css({
						"top": arr[parseInt(index)][0],
						"left": arr[parseInt(index)][1]
					});
				}, 1000 / 40);
			}
			//下面2行摆在ajax回调成功后,不中奖用openMd("#m_6"),中奖用openMd("#m_7");
		$.ajax({
			async: false,
			url: 'server.php',
			type: "post",
			data: {
				act: 'start'
			},
			dataType: 'json',
			success: function(result) {
				if (result.prize == 1) {
					stopPrice(1);
					gotoPrice(1, result.errcode);
					
					return false;
				} else if (result.prize == 4) {
					stopPrice(4);
					gotoPrice(4, result.errcode);
					
					return false;
				} else if (result.prize == 7) {
					stopPrice(7);
					gotoPrice(7, result.errcode);
					
					return false;
				} else if (result.prize == 10) {
					stopPrice(10);
					gotoPrice(10, result.errcode);
					return false;
				} else if (result.prize >= 1000) {
					closeMd("#m_5");
					openMd("#m_16");
//					alert(result.errmsg);
					return false;
				} else {
					stopPrice(no[ranNum(0,5)]);
					gotoPrice(null,result.prize);
					return false;
				}
			}
		});
	});

	function gotoPrice(txt, code) {
		switch (txt) {
			case 10:
				$("#price_txt").html("终极大奖");
				$("#duijiangma").html(code);
				break;
			case 1:
				$("#price_txt").html("二等奖");
				$("#duijiangma").html(code);
				break;
			case 4:
				$("#price_txt").html("三等奖");
				$("#duijiangma").html(code);
				break;
			case 7:
				$("#price_txt").html("四等奖");
				$("#duijiangma").html(code);
				break;
			default:
				break;
		};
	};

})();
//第5页 -->抽奖页end

//第6页-->不中奖页 start
(function() {
	$("#m_6_ling").bind("tapone", function() {
		closeMd("#m_6");
		openMd("#m_8");
	});
})();
//第6页 -->不中奖页end

//第7页-->中奖页 start
(function() {
	$("#m_7_ling").bind("tapone", function() {
		closeMd("#m_7");
		openMd("#m_8");
	});
})();
//第7页-->中奖页 end

//第8页-->活动展示 start
(function() {
	$("#chanping").bind("tapone", function() {
		closeMd("#m_8");
		openMd("#m_9");
	});
})();
//第8页 -->活动展示end

//第9页 -->产品展示start
(function() {
	$("#yaochu").bind("tapone", function() {
		closeMd("#m_9");
		openMd("#m_10");
		var sX, sY, sZ, lX, lY, lZ, lUpdate;
sX = sY = sZ = lX = lY = lZ = lUpdate = 0;
	    if (window.DeviceMotionEvent) {
	        lUpdate=new Date().getTime();
	        window.addEventListener('devicemotion', onDeviceMotionHandler, false);
	    } 
//		if (window.DeviceMotionEvent) {
//			window.addEventListener('devicemotion', skakeFn, false);
//		}
//		var speed = 25;
//		var x = y = z = lastX = lastY = lastZ = 0;

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
        if (speed > 3000) {
        		window.removeEventListener('devicemotion',onDeviceMotionHandler, false);
				$.ajax({
					async: false,
					url: 'server.php',
					type: "post",
					data: {
						act: 'shake'
					},
					dataType: 'json',
					success: function(result) {
						if (result.errcode != 0) {
							alert(result.errmsg);
							return false;
						} else {
							showPrice(result.errmsg);
							closeMd("#m_10");
							openMd("#m_11");

							return false;
						}
					}
				});
        }
        lX = sX;
        lY = sY;
        lZ = sZ;
    }
}


	});

	//	0-->大自然地板
	//	1-->壁高墙纸
	//	2-->大自然木门
	//	3-->橱衣柜
	//	4-->厨电
	//	5-->床垫床架
	var priceArr = [
		"此券在活动现场购买大自然地板，消费满5999元即可使用500元代金券一张（特价产品除外）；此券仅限于万人疯抢现场使用，过期无效，不与大自然地板的其他优惠政策同时使用。",
		"此券在活动现场购买壁高墙纸产品，消费满5000元即可使用500元代金券（特价产品除外）；此券仅限于万人疯抢现场使用，过期无效，不与壁高墙纸的其他优惠政策同时使用，不兑换现金，每户限用一张。",
		"此券在活动现场购买3樘以上大自然木门，即可使用600元代金券一张（特价产品除外）；此券仅限于万人疯抢现场使用，过期无效，不与大自然木门的其他优惠政策同时使用，不兑换现金，每户限用一张。",
		"此券在活动现场购买大自然柯拉尼橱衣柜，消费满5000元即可使用1000元代金券一张（特价产品除外）；此券仅限于万人疯抢现场日使用，过期无效，不与大自然柯拉尼橱衣柜的其他优惠政策同时使用，不兑换现金，每户限用一张。",
		"此券在活动现场购买美的厨电，消费满5000元即可使用500元代金券一张（特价产品除外）；此券仅限于万人疯抢现场使用，过期无效，不与美的厨电的其他优惠政策同时使用，不兑换现金，每户限用一张。",
		"此券在活动现场购买雅蘭床垫+床架，实付满19999元即可使用600元代金券一张（特价产品除外）；此券仅限于万人疯抢现场使用，过期无效，不与雅蘭床垫的其他优惠政策同时使用，不兑换现金，每户限用一张。",
	];

	function showPrice(n) {
		var index = parseInt(n-1);
		var src = "img/m_11/" + index+ ".png";
		$("#price_Img").attr("src", src);
		$("#price_Txt").html(priceArr[index]);
	};
	//	传相应的值进去showPrice函数

})();
//第9页 -->产品展示end

//第10页 -->摇一摇 start
(function() {
	$("#shakeani").click(function() {

	})


})();
//第10页-->摇一摇 end




//第11页-->现金券 start
(function() {


	$("#m11_sureBtn").bind("tapone", function() {
		$.ajax({
			async: false,
			url: 'server.php',
			type: "post",
			data: {
				act: 'check'
			},
			dataType: 'json',
			success: function(result) {
				if (result.errcode != 0) {
					closeMd("#m_11");
					openMd("#m_14");
				} else {
					closeMd("#m_11");
					openMd("#m_12");
				}
			}
		});

	});
})();



//第11页-->现金券  end

//第12页 -->第二个表单 start
(function() {
	$.ajax({
		async: false,
		type: 'get',
		url: 'http://pay.yoju360.com/phone/Ext/region/1', //对应省的地址
		dataType: 'jsonp',
		jsonp: "callback",
		success: function(data) {
			if (data.state == 1) {
				var option = "<option value='0'>省份</option>";
				var list = data.data;
				for (var i in list) {
					option = option + '<option value="' + i + '">' + list[i] + '</option>';
				}
				$("#m_12_province").html(option);
			}
		},
		error: function() {
			alert("服务器忙，请刷新！")
		}
	});
	$("#m_12_province").change(function() {
		if ($("#m_12_province").val() != 0) {
			$.ajax({
				async: false,
				type: 'get',
				url: 'http://pay.yoju360.com/phone/Ext/region/' + $("#m_12_province").val(),
				dataType: 'jsonp',
				jsonp: "callback",
				success: function(data) {
					if (data.state == 1) {
						var option = "<option value='0'>城市</option>";
						var list = data.data;
						for (var i in list) {
							option = option + '<option value="' + i + '">' + list[i] + '</option>';
						}
						$("#m_12_city").html(option);
					}
				},
				error: function() {
					alert("服务器忙，请重试！")
				}
			});
		}
	});
	$("#m_12_submitBtn").bind("tapone", function() {
		//下面2行摆在ajax回调成功后
		var name = $("#_name").val();
		var phone = $("#_phone").val();
		var address = $("#_address").val();
		var province = $("#m_12_province").find("option:selected").text();
		var city = $("#m_12_city").find("option:selected").text();
		//	    console.log(province);
		if (name == '' || phone == '' || address == '' || province == '省份' || city == '城市') {
			alert('请填写完整的个人信息');
			return false;
		}
		//下面2行摆在ajax回调成功后
		$.ajax({
			async: false,
			url: 'server.php',
			type: "post",
			data: {
				act: 'addinfo',
				name: name,
				phone: phone,
				address: address,
				province: province,
				city: city
			},
			dataType: 'json',
			success: function(result) {
				if (result.errcode != 0) {
					alert(result.errmsg);
					return false;
				} else {
					closeMd("#m_12");
					openMd("#m_13");
					return false;
				}
			}
		});

	});
})();
//第12页-->第二个表单  end

//第13页-->提交成功  start
(function() {
	$("#zhuanfa").bind("tapone", function() {
		openMd("#m_14");
	});
})();
//第13页-->提交成功 end

//第14页-->分享页 start
(function() {
	$("#m_14").bind("tapone", function() {
		closeMd("#m_14")
	});
})();
//第14页-->分享页 end

//第15页-->个人信息页 start
(function() {

	$("#m_15_sure").bind("tapone", function() {
		closeMd("#m_15");
		openMd("#m_1");
	});
})();

//第15页-->个人信息页 end

//第页-->  start
(function() {
	$("#m_16_ling").bind("tapone", function() {
		closeMd("#m_16");
		openMd("#m_8");
	});
})();
//$("#user_mod").show();

//第页-->  end