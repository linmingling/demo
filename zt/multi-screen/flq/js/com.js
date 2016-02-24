var yt = yt || {};
var mobile_url,mySwiper,mySwiper2,chose,dialog,star,close;
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
	//初始化
	$("#loading").hide();	
	//生成二维码
	jQuery('#qrcodeTable').qrcode({
		render:"canvas",
		width:240,
		height:240,
		text: mobile_url
		//text: "htpp://www.baidu.com"
	});	
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
			var _w = $win.width()>960?$win.width():960,_h;
			if($win.height()<730){
				//_h = 650;
				_h = $win.height();
				//$("#foot").css({position:"relative"});
			}else{
				_h = $win.height();
				$("#foot").css({position:"fixed",bottom:"0"});
			}
			$wrapers.height(_h);
			$container.height(_h);
			$container.width(_w);
			
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
			pagination: false,
			paginationClickable: false,
			onSlideChangeEnd: onSlideChangeEnd,
			mode: 'horizontal',
			//moveStartThreshold:10000,
			simulateTouch:false
		});
	};
	//选家具操作
	chose = function(dom,i){
		$(dom+" .scene_box img").stop().hide();
		$(dom+" .scene_box img").eq(i).fadeIn(500);
	}
	//对话
	dialog =function(dom,i){
		$(dom+" .person_box .dialog .dialog_box").hide(0);
		$(dom+" .person_box .dialog .dialog_box").eq(i).fadeIn(500);
	}
	//挑选成功提示弹窗打开
	var tc = function(dom){
		$(dom+" .tc").fadeIn(500);
	}

	
   //初始化
	bindSwiper();
	setLayout();
	setAms();
	
			
	//绑定场景滑动函数
	var bindSwiper2 = function () {
		mySwiper2 = $("#swiper-container-2").swiper({
			pagination: ".pagination-2",
			paginationClickable: false,
			onSlideChangeEnd: onSlideChangeEnd,
			mode: 'horizontal',
			simulateTouch:false
		});
		
	};
	
	//滑动完成
	var onSlideChangeEnd = function(){
		var i;
		i = mySwiper2.activeIndex;
		var cj = $("#swiper-container-2 .swiper-img").eq(i).attr("alt");
		$("#cj").hide().html(cj).fadeIn();
	};
	//设置场景布局
	var setLayout2 = function () {
		var $wrapers = $("#swiper-container-2 .wraper"),
			$container = $("#swiper-container-2");
		var sl = function () {
			var _w = $win.width()>1000?$win.width():1000,
				_h = $win.height()-90;
				$wrapers.height(_h);
				$container.height(_h);
				$container.width(_w);
		};
		sl();
		$win.resize(sl);
	};
	//场景初始化
	bindSwiper2();
	setLayout2();			
	$(".pagination-2 .swiper-pagination-switch").eq(0).addClass("swiper-visible-switch swiper-active-switch");
	//转盘
	star = function(){
		$("#zhuanpan .zp_bg").removeClass("on").addClass("on");
	};
	
	close = function(){
		var time = 15;
		setInterval(function(){
			if(time == 0){
				location.replace(location.href);
			}else{
				/*$("#time").html(time);*/
				time--;
			}
		},1000);

	};
	
	
});


