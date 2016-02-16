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
            _duration = ((obj.attr('data-duration') / 1000) || 0.5) + 's',
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
        $("#swiper-container1 .swiper-slide img").each(function(){
   
            if($(this).attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        });
        
 
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





    function comTips(text){
        $("#comTips .tipsBody").html(text);
        $("#comTips").show();
    }
    

    $(".bmOpen").click(function(){
        $("#baoming").show();
        $("#succeed img").each(function(){
            if($("this").attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        })
        
        //$("#baoming .name").focus()
    });

    $("#baoming .blackBg").click(function(){
        $("#baoming").hide();
    });
    
    $("#baoming .lpForm input").keyup(function(){
        var name = $("#baoming .name").val();
        var tel = $("#baoming .tel").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;

        if(name =="" || tel =="" || !mob.test(tel)){
            $("#baoming .lpBtn").addClass("false");
            return false;
        }else{
            $("#baoming .lpBtn").removeClass("false");
            if(name != ""){
                $("#baoming .lpBtn").removeClass("false");
            }else{
                $("#baoming .lpBtn").addClass("false");
            }
        }
    });
    
    // 领票弹出
    $("#baoming .lpBtn").click(function(){
    	if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        } else {
        	$("#baoming .lpBtn").html("正在提交...").addClass("false");
        	$("#baoming .lpBtn").addClass("false2");
        	var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var btn_id = $("#btn_id").val();
            $.ajax({
    			async:true,
    			url:'/phone/heb/submit',
    			data:{name:name, phone:tel, btn_id:btn_id},
    			type: 'post',
    			dataType:'json',
    			success:function(result){
    				$("#baoming .lpBtn").html("提交领票").removeClass("false");
                    $("#baoming .lpBtn").removeClass("false2");
                    $("#baoming").hide();
	                $("#succeed").show();
	                send(tel, 0)
    				/*if(!result.errcode){
    					// 报名成功
                        $("#baoming").hide();
   		                $("#succeed").show();
   		                send(tel, 0)
    				} else {
                        // 报名失败
    					comTips(result.errmsg);
    				}*/
    			}
    		});
        }
    });

    function send(tel, j){
      $.ajax({
			async:true,
			url:'/phone/heb/send',
			data:{phone:tel, verify:j},
			type: 'post',
			dataType:'json',
			success:function(result){
			}
		});
  }
    
    //页面布点
	$('.click_btn').click(function(){
		var btn_id = $(this).attr('data-id');
		$("#btn_id").attr('value', btn_id);
		$.ajax({
			async:true,
			url:'/phone/heb/click',
			data:{btn_id:btn_id},
			type: 'post',
			dataType:'json',
			success:function(result){
			}
		});
	});
    

    $("#comTips .tipsClose").click(function(){
        $("#comTips .tipsBody").html("");
        $("#comTips").hide();
    })
	
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		
        var w = $(window).width();
        var h = $(window).height();
		console.log(w+" , "+h+" , "+h/w)
        if(h/w<1.5){
            $("#swiper-container1").addClass("fat");
        }
    };

 
};
yt.init();

