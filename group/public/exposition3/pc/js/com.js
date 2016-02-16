function swiper(dom){
	var mySwiper = new Swiper(dom+' .swiper-container',{
		pagination: dom+' .pagination',
		loop:true,
		// grabCursor: true,
		paginationClickable: true
	});
	$(dom+' .arrow-left').on('click', function(e){
		// e.preventDefault();
		mySwiper.swipePrev();
	});
	$(dom+' .arrow-right').on('click', function(e){
		// e.preventDefault();
		mySwiper.swipeNext();
	});
} 
function send(tel, j){
    $.ajax({
		async:true,
		url:'/pc/exposition3/send',
		data:{phone:tel, verify:j},
		type: 'post',
		dataType:'json',
		success:function(result){
		}
	});
}
// 两步报名
function bm1(dom,step){
	var btn = dom.find(".step"+step+" .bmBtn");
	if(btn.hasClass("false"))return false;
	var process = dom.hasClass("baoming3");
	console.log(process);
	if(step == 1){		
		var name = dom.find(".name").val();
		var tel = dom.find(".tel").val();
		btn.addClass("false");
		$.ajax({
			async:true,
			url:'/pc/exposition3/getVerify',
			data:{name:name, phone:tel},
			type: 'post',
			dataType:'json',
			success:function(result){
				btn.removeClass("false");
				if(result.errcode == 1002){
					if(process){
						$("#succeedTc").fadeIn()
					}else{
						dom.find(".step1").hide();
						dom.find(".step3").fadeIn()
					}					
				} else if(!result.errcode){
					dom.find(".step1").hide();
					dom.find(".step2").fadeIn();
					send(tel, result.verify);
				} else {
					alert(result.errmsg);
				}
			}
		});
	} else if(step == 2){
		var tel = dom.find(".tel").val();
		var code = dom.find(".code").val();
		var area = dom.find(".area").val();
		var address = dom.find(".address").val();
		btn.addClass("false");
		$.ajax({
			async:true,
			url:'/pc/exposition3/submit',
			data:{phone:tel, code:code, area:area, address:address},
			type: 'post',
			dataType:'json',
			success:function(result){
				btn.removeClass("false");
				if(result.errcode == 1002){
					if(process){
						$("#succeedTc").fadeIn()
					}else{
						dom.find(".step2").hide();
						dom.find(".step3").fadeIn()
					}
				} else if(!result.errcode){
					if(process){
						$("#succeedTc").fadeIn()
					}else{
						dom.find(".step2").hide();
						dom.find(".step3").fadeIn()
					}
					send(tel, 0);
				} else {
					alert(result.errmsg);
				}
			}
		});
	}
}
// 两步报名验证
function check1(dom,step){
	var flag = true;
	if(step == 1){
		var name = dom.find(".name").val();
		var tel = dom.find(".tel").val();
        var nameTips = dom.find(".nameBox .tips");
		var telTips = dom.find(".telBox .tips");
		var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
		if(name == ""){
			nameTips.addClass("red");
			flag = false;
		}else if(!mob.test(tel)){
			dom.find(".tel").val("");
			telTips.html(telTips.attr("tips")).addClass("red");
			flag = false;
		}
	}else if(step == 2){
		var code = dom.find(".code").val();
		var area = dom.find(".area").val();
		var address = dom.find(".address").val();
        var codeTips = dom.find(".codeBox .tips");
		var areaTips = dom.find(".areaBox .tips");
		var addressTips = dom.find(".addressBox .tips");
		if(code == ""){
			codeTips.addClass("red");
			flag = false;
		}else if(area == ""){
	
			flag = false;
		}else if(address == ""){
			addressTips.addClass("red");
			flag = false;
		}
	}
	return flag;
}
// 底部报名
function bm2(){
	if($("#baoming3 .bmBtn").hasClass("false"))return false;
	var name = $("#baoming3 .name").val();
	var tel = $("#baoming3 .tel").val();
	var code = $("#baoming3 .code").val();
	var area = $("#baoming3 .area").val();
	var address = $("#baoming3 .address").val();
	$("#baoming3 .bmBtn").addClass("false");
	$.ajax({
		async:true,
		url:'/pc/exposition3/submit',
		data:{phone:tel, code:code, area:area, address:address},
		type: 'post',
		dataType:'json',
		success:function(result){
			$("#baoming3 .bmBtn").removeClass("false");
			if(result.errcode){
				alert(result.errmsg);
			} else {
				openTc($("#succeedTc"));
				send(tel, 0);
			}
		}
	});
}
// 底部报名验证
function check2(){
	var flag = true;
	var name = $("#baoming3 .name").val();
	var tel = $("#baoming3 .tel").val();
	var code = $("#baoming3 .code").val();
	var area = $("#baoming3 .area").val();
	var address = $("#baoming3 .address").val();

    var nameTips = $("#baoming3 .nameBox .tips");
	var telTips = $("#baoming3 .telBox .tips");
	var codeTips = $("#baoming3 .codeBox .tips");
	var areaTips = $("#baoming3 .areaBox .tips");
	var addressTips = $("#baoming3 .addressBox .tips");

	var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
	if(name == ""){
		nameTips.addClass("red");
		flag = false;
	}else if(!mob.test(tel)){
		$("#baoming3 .tel").val("");
		telTips.html(telTips.attr("tips")).addClass("red");
		flag = false;
	}else if(code == ""){
		codeTips.addClass("red");
		flag = false;
	}else if(area == ""){

		flag = false;
	}else if(address == ""){
		addressTips.addClass("red");
		flag = false;
	}
	
	return flag;
}
// 验证码倒计时
function codeDjs(dom,i){
    //console.log(i)
    if(i<1){
        dom.find(".getCode").html("获取验证码").removeClass("false");
    }else{
        dom.find(".getCode").html(i+"s重新获取").addClass("false");
        setTimeout(function(){codeDjs(dom,i-1)},1000);
    }
}
// 获取验证码
function getCode(dom){
	if(dom.find(".getCode").hasClass("false"))return false;
	var name = dom.find(".name").val();
	var tel = dom.find(".tel").val();
	var nameTips = dom.find(".nameBox .tips");
	var telTips = dom.find(".telBox .tips");
	var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
	if(!name){
		dom.find(".name").val("");
		nameTips.html(nameTips.attr("tips")).addClass("red");
	} else if(!mob.test(tel)){
		dom.find(".tel").val("");
		telTips.html(telTips.attr("tips")).addClass("red");
	}else{
		$.ajax({
		 	async:true,
		 	url:'/pc/exposition3/getVerify',
		 	data:{name:name, phone:tel},
		 	type: 'post',
		 	dataType:'json',
		 	success:function(result){
		 		if(result.errcode){
		 			alert(result.errmsg);
		 		} else {
     			    codeDjs(dom, 60);
     			    send(tel, result.verify);
		 		}
		 	}
		 });
	}
}
function rightNav(){
	var box0 = $("#box0").offset().top;
	var box1 = $("#box1").offset().top;
	var box2 = $("#box2").offset().top;
	var box3 = $("#box3").offset().top;
	var box4 = $("#box4").offset().top;
	var box5 = $("#box5").offset().top;
	var box6 = $("#box6").offset().top;

	$(window).scroll(function(){
		box0 = $("#box0").offset().top;
		box1 = $("#box1").offset().top;
		box2 = $("#box2").offset().top;
		box3 = $("#box3").offset().top;
		box4 = $("#box4").offset().top;
		box5 = $("#box5").offset().top;
		box6 = $("#box6").offset().top;
		var win_st = $(window).scrollTop();
		//console.log(box1+" , "+box1+" , "+box3+" , "+box4+" , "+box5+" , "+box6+" , "+box7);
		//导航条
		if(win_st>box6-1){
			$("#expositionnav p").removeClass("hover").eq(5).addClass("hover");
		}else if(win_st>box5-1){
			$("#expositionnav p").removeClass("hover").eq(4).addClass("hover");
		}else if(win_st>box4-1){
			$("#expositionnav p").removeClass("hover").eq(3).addClass("hover");
		}else if(win_st>box3-1){
			$("#expositionnav p").removeClass("hover").eq(2).addClass("hover");
		}else if(win_st>box2-1){
			$("#expositionnav p").removeClass("hover").eq(1).addClass("hover");
		}else if(win_st>box1-1){
			$("#expositionnav p").removeClass("hover").eq(0).addClass("hover");
		}else{
			$("#expositionnav p").removeClass("hover");
		}	
		if(win_st > 900){
			$("#expositionnav").fadeIn();
			$("#baoming3").fadeIn();
		}else{
			$("#expositionnav").fadeOut();
			$("#baoming3").fadeOut();
		}	
		
	});
	$('#expositionnav p').click(function(){
		if($(this).hasClass("gototop")){
			$("html,body").animate({scrollTop: 0}, 300);
			return true;
		};
		index = $(this).index();
		//$(this).addClass('hover').siblings().removeClass('hover');
		//console.log(index);
		switch(index){
			case 0: $("html,body").animate({scrollTop: box1}, 300);break;
			case 1: $("html,body").animate({scrollTop: box2}, 300);break;
			case 2: $("html,body").animate({scrollTop: box3}, 300);break;
			case 3: $("html,body").animate({scrollTop: box4}, 300);break;
			case 4: $("html,body").animate({scrollTop: box5}, 300);break;
			case 5: $("html,body").animate({scrollTop: box6}, 300);break;
			case 6: $("html,body").animate({scrollTop: 0}, 300);break;
			default: $("html,body").animate({scrollTop: 0}, 300);break;
		}
	});
}
function showTime(deadline,dom) {
	var countdown = new Date(deadline) - new Date();
	// alert(new Date("02 28,2016 00:00:00"))
	var restDays = dom.find(".days");
	var restHours = dom.find(".hours");
	var restMinutes = dom.find(".minutes");
	var restSeconds = dom.find(".seconds");

	var timer = setInterval(function() {
		if(countdown<0){
			clearInterval(timer);
			return false;
		}
		var days = Math.floor(countdown / 86400000) < 0 ? 0 : Math.floor(countdown / 86400000);
		var hours = Math.floor((countdown - days * 86400000) / 3600000) < 0 ? 0 : Math.floor((countdown - days * 86400000) / 3600000);
		var minutes = Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000);
		var seconds = Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000);			
		days < 10 ? days = "0" + days : days = days;
		hours < 10 ? hou000s = "0" + hours : hours = hours;
		minutes < 10 ? minutes = "0" + minutes : minutes = minutes;
		seconds < 10 ? seconds = "0" + seconds : seconds = seconds;

		//alert(days+", "+hours+", "+minutes+", "+seconds);
		restDays.html(days);
		restHours.html(hours);
		restMinutes.html(minutes);
		restSeconds.html(seconds);
		countdown -= 1000;
	}, 1000)
	
}
// 点击打开弹层，对应商品资料填充
function productInfo(dom,type){
	var proTitle = dom.find(".proTitle").html();
	var original = dom.find(".original").html();
	var price = dom.find(".price").html();
	var describe = dom.attr("describe");
	var proImg = dom.find(".proImg").attr("src");
	var proNum = dom.find(".red").html();
	var goods_id = dom.find(".goods_id").val();
	if(type == 1){
		var ewmImg = dom.attr("ewmImg");
		$("#tcBm .tcProduct .productImg").attr("src",proImg);
		$("#tcBm .tcProduct .original").html(original);
		$("#tcBm .tcProduct .price").html(price);
		$("#tcBm .tcProduct .title").html(proTitle);
		$("#tcBm .tcProduct .describe").html(describe);
		$("#tcBm .tcProduct .red").html(proNum);
		$("#tcBm .tcProduct .ewmImg").attr("src",ewmImg);
	}else if(type == 2){
		$("#tcYy .tcProduct .productImg").attr("src",proImg);
		$("#tcYy .tcProduct .original").html(original);
		$("#tcYy .tcProduct .price").html(price);
		$("#tcYy .tcProduct .title").html(proTitle);
		$("#tcYy .tcProduct .describe").html(describe);
		$("#tcYy .tcProduct .goods_id").val(goods_id);
		$("#tcYy .tcProduct .red").html(proNum);
	}
}


function openTc(dom){
	dom.fadeIn();
	$(".blackBg").fadeIn();
	$("body").addClass("noScroll")
}
function closeTc(){
	$(".tc, .blackBg").hide();
	$("body").removeClass("noScroll")
}
$(function(){
	// 两步报名 第一步
	$(".process1 .step1 .bmBtn").click(function(){
		var dom = $(this).closest(".process1");
		// 验证是否填写信息
		if(check1(dom,1)){
			bm1(dom,1);
		}
	});
	// 两步报名 第二步
	$(".process1 .step2 .bmBtn").click(function(){
		var dom = $(this).closest(".process1");
		// 验证是否填写信息
		if(check1(dom,2)){
			bm1(dom,2);			
		}
	});

	// 底部一步报名
	// $(".process2 .bmBtn").click(function(){
	// 	var dom = $(this).closest(".process1");
	// 	// 验证是否填写信息
	// 	if(check2()){
	// 		bm2();			
	// 	}
	// });
	$(".process1 input, .process2 input, #yuyue input").keyup(function(){
		var tips = $(this).prev();
		// console.log($(this).val())
		if($(this).val() != ""){
			tips.html("").removeClass("red");
		}else{
			tips.html(tips.attr("tips")).addClass("red");
		}
	});
	// // 点击获取验证码
	// $("#baoming3 .getCode").click(function(){
	// 	getCode($("#baoming3"));
	// });
	// 点叉叉
	$(".tc .close").click(function(){
		closeTc();
	});

	// 预约
	$("#yuyue .bmBtn").click(function(){
		if($(this).hasClass("false"))return false;
		var dom = $("#yuyue");
		// 验证是否填写信息
		if(check1(dom,1)){		
			var name = $("#yuyue .name").val();
			var tel = $("#yuyue .tel").val();
			var goods_id = $("#tcYy .tcProduct .goods_id").val();
			var goods_name = $("#tcYy .tcProduct .title").html();
			$(this).addClass("false");
			$.ajax({
				async:true,
				url:'/pc/exposition3/subscribe',
				data:{name:name, phone:tel, goods_id:goods_id, goods_name:goods_name},
				type: 'post',
				dataType:'json',
				success:function(result){
					$(this).removeClass("false");
					if(result.errcode){
						alert(result.errmsg);
					} else {
						$("#yuyue .step1").hide();	
						$("#yuyue .step3").fadeIn();
					}
				}
			});
		}
	});

	$(".gotoBM").click(function(){
		box1 = $("#baoming1").offset().top-200;
		$("html,body").animate({scrollTop: box1}, 300);
		$("#baoming1 .name").focus();

	})

	// 已报名名单滚动初始化
	$("#marquee").kxbdMarquee({
		direction:"up",
		isEqual:false
	});
	// logo模块初始化
	swiper("#logoSwiper");
	// 现场抢购模块初始化
	swiper("#qiangSwiper");
	// 产品预定模块初始化
	swiper("#dingSwiper");
	// 右侧导航初始化
	rightNav();
	// 初始化倒计时
	showTime("Sun Feb 28 2016 00:00:00",$("#djs"));

	// 产品
	$("#product .productNav span").hover(function(){
		if($(this).hasClass("hover"))return false;
		$(this).addClass("hover").siblings().removeClass("hover");
		var i = $(this).index();
		$("#product .productMain .productBox").hide().eq(i).fadeIn();
	});

	// 打开弹出报名层
	$("#qiangSwiper .product").click(function(){
		productInfo($(this),1);
		openTc($("#tcBm"));
	});
	// 打开弹出预约层
	$("#dingSwiper .product").click(function(){
		productInfo($(this),2);
		openTc($("#tcYy"));
	});
	
	
	// 请求区选项
	$.ajax({
		async:false,
		type:'get',
		url : payDomain + '/phone/Ext/region/321', 
		dataType : 'jsonp',
		jsonp:"callback",
		success  : function(data) {
			if(data.state ==  1){
				var option = "";
				var list = data.data;
				for(var i in list){
					option = option + '<option value="'+list[i]+'">'+list[i]+'</option>';
				}
				$(".area").html(option);
			}
		},
		error : function() {
			alert("服务器忙，请刷新！")
		}
	});

	//调用百度地图
	var map1 = new BMap.Map("map");           // 创建Map实例
    var point1 = new BMap.Point(121.433887,31.173723);  
    map1.centerAndZoom(point1,16);               
    map1.enableScrollWheelZoom();  
    var marker1 = new BMap.Marker(point1);  // 创建标注
	map1.addOverlay(marker1);               // 将标注添加到地图中
	marker1.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
	//百度地图添加工具
	var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
	var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
	map1.addControl(top_left_control);        
	map1.addControl(top_left_navigation);
});