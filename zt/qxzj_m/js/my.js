var yt = yt || {};

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
        $pages = $("#wrapper").children(),
        $as = $("#nav li a"),
        $lis = $("#nav li"),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper;

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
        //history.pushState(null, null, "index.html?p=" + (nowIndex + 1));
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
	   
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
        //alert(mySwiper.activeIndex);
        $('#num1,num2,#num3,#num4,#num5,#num6,#num7,#num8,#num9,#num10,#num11,#num12,#num13,#num14').text('');
		if(mySwiper.activeIndex == 1){
            num_change(10,0,'num1',10,2500);
            num_change(19,1,'num2',9,2500); 
        }
       if(mySwiper.activeIndex == 4){
            $('#num3,#num4,#num5').css('font-size','24px');
            num_change(90,0,'num3',10,2500);
            num_change(600,0,'num4',10,2500);
            num_change(3000,0,'num5',10,2500);
       }
       if(mySwiper.activeIndex == 5){
        $('#num6,#num7,#num8').css('font-size','24px');
            num_change(800,0,'num6',10,2500);
            num_change(200,0,'num7',10,2500);
            num_change(12,0,'num8',12,2500);  
       }
       if(mySwiper.activeIndex == 6){
            $('#num9,#num10').css('font-size','24px');
            num_change(4.5,0,'num9',10,2500);
            num_change(42.9,0,'num10',8,2500);
       }
       if(mySwiper.activeIndex == 7){
            $('#num11').css('font-size','40px');
            num_change(5,0,'num11',5,2500);
       }
       if(mySwiper.activeIndex == 8){
            $('#num13,#num14').css('font-size','30px');
            num_change(90000,0,'num12',10,2500);
            num_change(100000,0,'num13',10,2500);
            num_change(19,1,'num14',9,2500);
       }
       


        onSlideChange();
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
			//mousewheelControl:true,
            mode: 'vertical'
        });
    };
    
    //滚到下一个屏  
    var bindNext = function () {
        $(".next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
       
            mySwiper.swipeTo(index);
        });
    };

	
   //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();

    //数字动态变化
    function num_change(c_price,origin_price,id,times,waste_time){

        //每次变化数
        var i,n;
        i = 0;
        n = (c_price - origin_price) /times;
        var ycss=$('#'+id).css('font-size');
        var time = setInterval(function(){
            if (i<=times) {
                var current = (origin_price+i*n);
                $('#'+id).html(current);
                if(times<=5)
                {
                    $('#'+id).css('font-size',parseInt(ycss)+i/2+'px');
                }
                else if(times>5&&times<=10){
                    $('#'+id).css('font-size',parseInt(ycss)+i/4+'px');
                }
                else{
                    $('#'+id).css('font-size',parseInt(ycss)+i/5+'px');
                }
                i++;
            } else {
                clearInterval(time);
            }
        },waste_time/times);
    }
};
	

//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		var musicBox = document.getElementById("musicBox");
            musicBox.play();
        //音乐播放
        $("#music .musicBtn").click(function(){
            
            if($(this).hasClass("open")){
                $(this).removeClass("open").addClass("close");
                musicBox.pause();
            }else{
                $(this).removeClass("close").addClass("open");
                musicBox.play();
            }
        }); 

    };

 
};
yt.init();











