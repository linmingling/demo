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
		closeMd("#m_3");
		openMd("#m_4");

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
//					window.location.href="http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA4NTc5MTkxNw==&shelf_id=3&showwxpaytitle=1#wechat_redirect";
//					return false;
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
		var phone = $("#phone").val();
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
				act: 'start',
				phone:phone
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
		openMd("#m_14");
	});
})();
//第6页 -->不中奖页end

//第7页-->中奖页 start
(function() {
	$("#m_7_ling").bind("tapone", function() {
		closeMd("#m_7");
		openMd("#m_14");
	});
})();
//第7页-->中奖页 end

//第14页-->分享页 start
(function() {
	$("#m_14").bind("tapone", function() {
		var name = $("#name").val('');
		var phone = $("#phone").val('');
		var address = $("#address").val('');
		var province = $("#province").val('');
		var city = $("#city").val('');
		closeMd("#m_14");
		closeMd("#m_16");
		openMd("#m_1");
	});
})();
//第14页-->分享页 end
//第16页--> start
(function() {
	$("#m_16_ling").bind("tapone", function() {
		closeMd("#m_16");
		openMd("#m_14");
	});
})();
//第16页-->end
