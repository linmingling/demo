var yt = yt || {};
var mySwiper,mySwiper2,select,sel,type,onSlideChangeEnd2;
//加载图片
yt.loadImg = function ($imgs, time) {
    var _time = 0;
    time = time || 200;

    $imgs.each(function () {
        var $that = $(this);
        if ($that.data('hasload')) {
            return false;
        }
        setTimeout(function () {
            $that.fadeOut(0);
            $that.attr('src', $that.data('src'));
            $that.attr('data-hasload', 'true');
            $that.fadeIn(500);
        }, _time);
        _time += time;
    });
};
$(function(){
	//服务器断开连接
	$.wsclose(function( data ){
		
	});
	//服务器连接成功
	$.wsopen( function( data ) {
		//匹配key
		if(key){
			$.wssend('name=' +key);
			$("#sceneBtn").show();
		}
	});
	
	//已有用户，提示用户扫码慢了
	$.wsmessage( 'msg', function( data ){
		$("#tips").show();
	});
	
	
	//响应成功，显示控制按钮
	$.wsmessage( 'key', function( data ){
		if(data){
			$("#sceneBtn").show();
		}
	});
	
	//我要帮忙
	$("#sceneBtn").click(function(){
		//场景选择确认后，切换至场景布局页
		$.wssend($.param( { operation : mySwiper2.activeIndex + 1, code : key} ) );
		mySwiper.swipeTo(mySwiper2.activeIndex + 1);
	});

	//接收来自PC场景布局页的状态
//	$.wsmessage( 'mb_operation', function( data ){
//		mySwiper.swipeTo(data);
//	});
	
	//发送选场景指令
	onSlideChangeEnd2 = function(){
		$.wssend($.param( { scene : mySwiper2.activeIndex + 1, code : key} ) );
	}
	
	//选择摆放物品
	$(".swiper-slide .able").click(function(){
	
		sel = $(this).attr("s");
		type = $(this).attr("scene_type");
		
		$.wssend($.param( { select : sel, scene_type : type, code : key} ) );
		
		$(this).siblings().removeClass("true");
		$(this).removeClass("able").addClass("true");
	});
	
	//我选好了
	$(".btn").click(function(){
		var id = $(this).parent().attr("id");
		// 物品选择，控制PC显示对话
		$.wssend($.param( { result : 'false', select_id : sel, scene_type : type, code : key} ) );
		if(sel!=3){
			$("#"+id+" .true").removeClass("true able").addClass("false");
			// 物品选择错误，控制PC显示对话
			//$.wssend($.param( { result : 'false', select_id : sel, scene_type : type, code : key} ) );
		} else {
			//选择正确后，向pc发送切屏指令
			//$.wssend($.param( { result : 'false', select_id : sel, scene_type : type, code : key} ) );
			setTimeout(function(){
				$.wssend($.param( { operation : 5, code : key} ) );
				mySwiper.swipeTo(5);
			},1500);
		}
	});
	
	//启动转盘
	$("#start").click(function(){
		$.ajax({
			async:false,
		 	url: '../server.php',
		 	data: {act:'start'},
		 	type: 'post',
		 	dataType:'json',
		 	success:function(result){
				$.wssend($.param( { dzp : result.star, code : key} ) );
				setTimeout(function(){
					if(result.star == 1 || result.star == 3 || result.star == 5){
						mySwiper.swipeNext();
					} else {
						mySwiper.swipeTo(9);
					}
				},2000);
		 	}
	  	});
//		$.wssend($.param( { dzp : 'start', code : key} ) );
//		setTimeout(function(){
////			$.wssend($.param( { dzp_end : 6, code : key} ) );
//			mySwiper.swipeNext();
//		},2000);
	});
	
	//转盘结束后，切换下一页
	$.wsmessage( 'dzp_end', function( data ){
//		if(data){
//			// 中奖后转到信息页面
//			mySwiper.swipeTo(6);
//		} else{
//			mySwiper.swipeTo(8);
//		}
		//切换成功后向PC发送指令，控制下一页
		//$.wssend($.param( { mb_dzp : data, code : key} ) );
	});


	// 中奖信息提交
	$('#sure').click(function(){

        var name = returnVal('name');
        var tel = returnVal('phone');
        var address = returnVal('address');
        if(checkForm(name,tel,address)){
         $.ajax({
         	 async:false,
             url:'../server.php',
             data:{act:'submit',name:name,tel:tel,address:address},
             type: 'post',
             dataType: 'json',
             success:function(result){
            	$("#zjts").html(result.errmsg);
				mySwiper.swipeTo(7);
             }
         });
        }
	})

    //return value
    function returnVal(id){
        return $('#'+id).attr('value');
	}
    // 表单验证
    function checkForm(name,tel,address){
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        var telp = /^0\d{2,3}-?\d{7,8}$/;
        //判断收货人是否为空

        if(name == ""){
           alert("请输入姓名！");
           return false;
        }
        //判断电话格式
        if(tel == ""){
            alert("请输入电话！");
            return false;
        }else if(!telp.test(tel) && !mob.test(tel)){
            alert("请输入正确的电话！");
            return false;
        }
        
        //判断地址
        if(address == ""){
            alert("请输入详细地址！");
            return false;
        }
        return true;
    }

    // 促销信息跳转
    $('#cuxiao,#cuxiao2,#cuxiao3').click(function(){
    	$.wssend($.param( { operation : 7, code : key} ) );
    	mySwiper.swipeTo(8);
    })

    // 再来一次
    $('#ag').click(function(){
    	$.wssend($.param( { operation : 7, code : key} ) );
    	mySwiper.swipeTo(8);
    })
	
	//页面显示效果部分
	$("#loading").hide();
	//主滑动
	var $swiperContainer = $("#swiper-container-1"),
		$pages = $("#wrapper").children(),
		$as = $("#nav li a"),
		$lis = $("#nav li"),
		$win =$(window),
		slideCount = $pages.length,
		nowIndex = 0,
		acn = "animation";

	var params = {
		selectorClassName: "swiper-container",
		animationClassName: acn,
		animationElm: $("." + acn)
	};
	var setCssText = function (prop, value) {
		return prop + ': ' + value + '; ';
	};

	/*
	 * insertCss(rule)
	 * 向文档<head>底部插入css rule操作
	 * rule: 传入的css text
	 * */
	var insertCss = function (rule) {
		var head = document.head || document.getElementsByTagName('head')[0],
			style;

		if (!!head.getElementsByTagName('style').length) {
			style = head.getElementsByTagName('style')[0];
   
			if (style.styleSheet) {
				style.styleSheet.cssText = rule;
			} else {
				style.innerHTML = '';
				style.appendChild(document.createTextNode(rule));
			}
		} else {
			style = document.createElement('style');

			style.type = 'text/css';
			if (style.styleSheet) {
				style.styleSheet.cssText = rule;
			} else {
				style.appendChild(document.createTextNode(rule));
			}

			head.appendChild(style);
		}
	};

	var setAnimationStyle=function() {
		var cssText = '';

		cssText += '.' + params.animationClassName + '{' +
			setCssText('display', 'none') +
			'}' +
			'.touchstart .' + params.animationClassName + '{' +
			setCssText('-webkit-animation-duration', '0 !important') +
			setCssText('-webkit-animation-delay', '0 !important') +
			setCssText('-webkit-animation-iteration-count', '1 !important') +
			'}';
   
		var index = mySwiper.activeIndex,
			_index = index + 1,
			$ans = $pages.eq(index).find('.' + params.animationClassName);
		$ans.each(function () {
			var obj = $(this);
		 
			_className = obj.attr('data-item'),
			_animation = obj.attr('data-animation'),
			_duration = ((obj.attr('data-duration') / 1000) || 1) + 's',
			_timing = obj.attr('data-timing-function') || 'ease',
			_delay = ((obj.attr('data-delay') || 0) / 1000) + 's',
			_count = obj.attr('data-iteration-count') || 1;

	
			var _t = '.' + params.selectorClassName +
				' .page-' + _index +
				' .' + _className;

			cssText += _t + '{' +
				setCssText('display', 'block !important') +
				setCssText('-webkit-animation-name', _animation) +
				setCssText('-webkit-animation-duration', _duration) +
				setCssText('-webkit-animation-timing-function', _timing) +
				setCssText('-webkit-animation-delay', _delay) +
				setCssText('-webkit-animation-fill-mode', 'both') +
				setCssText('-webkit-animation-iteration-count', _count) +
				'}';

		});

		return cssText;

	};

	//设置动画
	var setAms = function () {
		insertCss(setAnimationStyle());
	};


	
	//设置布局
	var setLayout = function () {
		var $wrapers = $("#swiper-container-1 .wraper"),
			$container = $("#swiper-container-1");
		var sl = function () {
			var _w = $win.width()<640?$win.width():640,
			_h = $win.height()-100;
			$wrapers.height(_h);
			$container.height(_h);
			$container.width(_w);
			$("#mainWrap").height($win.height());
		};
		sl();
		$win.resize(sl);
	};
	
	//滑动绑定函数
	var onSlideChangeTime = 0;

	var onSlideChange = function () {
		if (onSlideChangeTime>1) {
			return;
		}

		var index = mySwiper.activeIndex;
		if (nowIndex == index && mySwiper.touches['abs'] < 50) {
			return;
		}
		onSlideChangeTime = 20;
		setAms();
		nowIndex = index || 0;
		//执行动画
		var timer=setInterval(function () {
			onSlideChangeTime -= 1;
			if (onSlideChangeTime == 0) {
				clearInterval(timer);
			}
		},1);
		
	};

	//滑动结束绑定
	var onSlideChangeEnd = function () {
		onSlideChange();
		
	};

	//绑定滑动主函数
	var bindSwiper = function () {
		mySwiper = $swiperContainer.swiper({
			onSlideChangeEnd: onSlideChangeEnd,
			mode: 'horizontal',
			moveStartThreshold:10000,
			simulateTouch:false
		});
	};
	
   //初始化
	bindSwiper();
	setLayout();
	setAms();
	
	//绑定场景滑动函数
	var bindSwiper2 = function () {
		mySwiper2 = $("#swiper-container-2").swiper({
			pagination: ".pagination-2",
			paginationClickable: true,
			mode: 'horizontal',
			onSlideChangeEnd: onSlideChangeEnd2
			
		});
	};
	
	//场景初始化
	bindSwiper2();
	//左右滑动控制
	 $('.arrow-left').on('click', function(e){
		e.preventDefault();
		mySwiper2.swipePrev();
	  });
	 $('.arrow-right').on('click', function(e){
		e.preventDefault();
		mySwiper2.swipeNext();
	  });
	
	
	//随机字符串
	var chars = ['0','1','2','3','4','5','6','7','8','9'],
	sn = 'YT',i,j,id;
	for(i=0;i<7;i++){
		id = Math.ceil(Math.random()*9);
		sn = sn + chars[id];
	}
	$("#sn").html(sn);

});