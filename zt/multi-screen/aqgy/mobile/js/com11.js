var yt = yt || {};
var mySwiper,mySwiper2,select,sel,type;
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
//初始化

$(function(){
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
			_h = $win.height()-50;
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


	//触摸结束绑定
	var onTouchEnd = function () {
		var index = mySwiper.index;
		if (nowIndex == slideCount-1 && +mySwiper.touches['diff'] <-50) {

			return mySwiper.swipeTo(0);
		}
		onSlideChange();
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
			onTouchEnd: onTouchEnd,
			onSlideChangeEnd: onSlideChangeEnd,
			mode: 'horizontal',
			mousewheelControl:true,
			grabCursor: true
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
			mode: 'horizontal'
		});
	};
	
	//场景初始化
	bindSwiper2();
	//左右滑动控制
	 $('.arrow-left').on('click', function(e){
		e.preventDefault();
//		mySwiper2.swipePrev();
	  });
	 $('.arrow-right').on('click', function(e){
		e.preventDefault();
//		mySwiper2.swipeNext();
	  });
	
	//操作
//	$(".swiper-slide .able").click(function(){
//		if($(this).hasClass("able")){
//			select = $(this).attr("s");
//		}
//		$(this).siblings().removeClass("true");
//		$(this).removeClass("able").addClass("true");
//	});
//	$(".btn").click(function(){
//		var id = $(this).parent().attr("id");
//		if(select!=3){
//			$("#"+id+" .true").removeClass("true able").addClass("false");
//		}else{
//			mySwiper.swipeTo(5);
//		}
//	});
//	$("#sceneBtn").click(function(){
//		mySwiper.swipeTo(mySwiper2.activeIndex+1);
//	});
	//随机字符串
	var chars = ['0','1','2','3','4','5','6','7','8','9'],
	sn = 'YT',i,j,id;
	for(i=0;i<7;i++){
		id = Math.ceil(Math.random()*9);
		sn = sn + chars[id];
	}
	$("#sn").html(sn);
	
});



