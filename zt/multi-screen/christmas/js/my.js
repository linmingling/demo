var yt = yt || {};
var witch = 0;
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

//wap端环境
yt.isWap = function () {
    var s = navigator.userAgent.toLowerCase();
    var ipad = s.match(/ipad/i) == "ipad"
		, iphone = s.match(/iphone os/i) == "iphone os"
		, midp = s.match(/midp/i) == "midp"
		, uc7 = s.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"
		, uc = s.match(/ucweb/i) == "ucweb"
		, android = s.match(/android/i) == "android"
		, ce = s.match(/windows ce/i) == "windows ce"
		, wm = s.match(/windows mobile/i) == "windows mobile";
    if (iphone || midp || uc7 || uc || android || ce || wm || ipad) { return true; }
    return false;
};

//滑动绑定
yt.app = function () {
   
    var $swiperContainer = $("#swiper-container1"),
        $swiperContainer2 = $("#swiper-container2"),
        $pages = $("#wrapper").children(),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper,
        mySwiper2;

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
        var $wrapers = $("#swiper-container1 .wraper"),
            $wraper1 = $("#wraper1"),
       
            isWap=yt.isWap(),
            w = 720,
            h = 1135;
        var sl = function () {
            var _w = $wraper1.width(),
                h = $win.height(),
                _h = isWap && _w<h?$win.height():_w * 1135 / 720;
            $wrapers.height(_h);
			if($win.height()<300){
				$(".cn-slidetips").hide();
			}else{
				$(".cn-slidetips").show();
			}
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
        onSlideChange(); 
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
        onSlideChange();
		if(mySwiper.activeIndex == 1){
			bindSwiper2();
		}
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            pagination: false,
            paginationClickable: false,
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            mode: 'horizontal',
			mousewheelControl:false,
			moveStartThreshold:10000
        });
    };
    
    //滚到下一个屏
    var bindNext = function () {
        $("#next").on("click", function () {
            mySwiper.swipeNext();
        });
    };



	
   //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();
  
	//第一屏

	$("#page-1").one("click",function(){
		$("#page-1 .am2").css({"-moz-animation":"fadeOutDown 0.5s 1s forwards","-webkit-animation":"fadeOutDown 0.5s 1s forwards"});
		$("#page-1 .am3").css({"-moz-animation":"fadeOutDown 0.5s 0.5s forwards","-webkit-animation":"fadeOutDown 0.5s 0.5s forwards"});
		$("#page-1 .am4").css({"-moz-animation":"fadeOutDown 0.5s 0s forwards","-webkit-animation":"fadeOutDown 0.5s 0s forwards"});
		setTimeout(function(){
			$("#page-1 .am5").css({"-moz-animation":"fadeInLeft 0.5s 0s forwards","-webkit-animation":"fadeInLeft 0.5s 0s forwards","display":"block"});
			$("#page-1 .am6").css({"-moz-animation":"fadeInRight 0.5s 0s forwards","-webkit-animation":"fadeInRight 0.5s 0s forwards","display":"block"});
		},1500);
		setTimeout(function(){
			mySwiper.swipeNext();
		},3000);
	});
	
	//第二屏
	
		//绑定场景滑动函数
	var bindSwiper2 = function () {
		mySwiper2 = $swiperContainer2.swiper({
			onSlideChangeEnd: onSlideChangeEnd2
        });
	};
	$("#page-2 .arrow-left").click(function(){
		mySwiper2.swipePrev();
	});
	$("#page-2 .arrow-right").click(function(){
		mySwiper2.swipeNext();
	});
		//场景滑动结束绑定
    var onSlideChangeEnd2 = function () {
		witch = mySwiper2.activeIndex;
	
    };
	$("#btn1").click(function(){
		//alert(witch);
		$("#page-3 .am2 img").removeClass("an2");
		$("#page-3 .am2 img").eq(witch).addClass("an2");
		mySwiper.swipeNext();
	});
	//第三屏
	var touch = 0;
	var page3 = function(){
		if(touch == 0){
			$("#page-3 .am7").css({"-moz-animation":"fadeOutDown 0.5s 0s forwards","-webkit-animation":"fadeOutDown 0.5s 0s forwards"});			
			setTimeout(function(){
			$("#page-3 .am7").hide();
		},1000);
		}else if(touch == 1){
			$("#page-3 .am6").css({"-moz-animation":"fadeOutDown 0.5s 0s forwards","-webkit-animation":"fadeOutDown 0.5s 0s forwards"});
			setTimeout(function(){
			$("#page-3 .am6").hide();
		},1000);
		}else if(touch == 2){
			$("#page-3 .am2 img").css({"-moz-animation":"sepia 0.5s 0s forwards","-webkit-animation":"sepia 0.5s 0s forwards","animation":"sepia 0.5s 0s forwards"});
		}else if(touch == 3){
			$("#page-3 .bg").css({"height":$win.height()-20,"width":$win.width()-20,"margin":"10px","opacity":0,"-moz-animation":"scaleIn 0.5s 0s forwards","-webkit-animation":"scaleIn 0.5s 0s forwards"});
		
		}
		touch++;
		
	}
	$("#page-3 .am2").click(function(){
		page3();
	});
	$("#page-3 .am6").click(function(){
		page3();
	});
	$("#page-3 .am7").click(function(){
		page3();
	});
	$("#page-3 .am4 input").click(function(){
		$("#page-3 .am4 input").focus(); 
	});
	$("#page-3 .am4 input").change(function(){
		$("#page-3 .am1 span").html($("#page-3 .am4 input").val());
	});
	$("#page-3 .am5").click(function(){
		mySwiper.swipeNext();
	});
	//第四屏
	$("#page-4 .am4").click(function(){
		$("#page-4 .am3").css({"animation":"0.5s 0 plane ease-out forwards","-webkit-animation":"0.5s 0 plane ease-out forwards","-moz-animation":"0.5s 0 plane ease-out forwards"});
		setTimeout(function(){
			mySwiper.swipeNext();
		},1000);
	});
	
	//第五屏
//	$("#page-5 .am4").click(function(){
//		$("#share_tips").show();
//	});
//	$("#share_tips").click(function(){
//		$(this).hide();
//	});
	

};
//初始化
yt.init = function () {

    window.onload = function () {
		
        $("#loading").hide();
        setTimeout(yt.app);
		$("#share_tips").click(function(){
			$(this).hide();
		});
		
		//微信分享控制
		WeixinApi.ready(function(Api){
			var link = (location.href).split('&p=');
			var wxData = {
				"imgUrl":"",
				"link":link[0],
				"desc":"快来DIY专属于你的圣诞贺卡~",
				"title":"圣诞快乐!"
			};
			
			// 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
			Api.shareToFriend(wxData);
		 
			// 点击分享到朋友圈，会执行下面这个代码
			Api.shareToTimeline(wxData);
		 
			// 点击分享到腾讯微博，会执行下面这个代码
			Api.shareToWeibo(wxDat);
		});
		
    };

 
};
yt.init();

