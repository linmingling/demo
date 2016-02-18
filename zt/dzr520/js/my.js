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
//加入music
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
        if(mySwiper.activeIndex==4){
            $("#sign").show(1000);
        }else{
            $("#sign").hide();
        }
		$(".swiper-slide").eq(mySwiper.activeIndex).find("img").each(function(){
			if($(this).attr("date-src")){
				$(this).attr("src",$(this).attr("date-src"));
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
	/*************第一页的交互***************/
    $('.button').click(function(){
        mySwiper.swipeTo(1);
    })
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
        
		var disabled = false;
            var musicBox = document.getElementById("musicBox");
            musicBox.play();
            var shake = false;
            $('.main').css('height',$(window).height());
            $('.click').click(function(){
				$('.cn2').show();
                $('.cn1').hide();
                shake = true;
                yao();

            });
       
	   //提交活动报名信息
        $('.sure').click(function(){
            //报名信息1
            var firm= $("#firm").val();
            var name= $("#name").val();
            var post= $("#post").val();
            var phone= $("#phone").val();
            if(checkForm(firm,name,post,phone)){
                $.ajax({
                	async:false,
                    url: 'server.php',
                    data:{act:'trial', firm:firm, name:name, post:post, phone:phone},
                    type: "post",
                    dataType:'json',
                    success:function(result){
                    	if(parseInt(result.code) == 1){
                    		alert(result.msg);
                    	}else if(parseInt(result.code) == 2001){
                    		alert(result.msg);
                    	} else {
                    		alert(result.msg);
                    	}
                    }
                });
            }
        })
        // 验证表单
        function checkForm(firm,name,post,phone){
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
            var telp = /^0\d{2,3}-?\d{7,8}$/;
            //判断收货人是否为空
            if(firm == ""){
               alert("请输入公司名称！");
               return false;
            }
            if(name == ""){
               alert("请输入姓名！");
               return false;
            }
            if(post == ""){
                alert("请输入您的职位！");
                return false;
             }
            //判断电话格式
            if(phone == ""){
                alert("请输入电话！");
                return false;
            }else if(!telp.test(phone) && !mob.test(phone)){
                alert("请输入正确的电话！");
                return false;
            }
            return true;
        }
        
		//返回关闭当前窗
        $('.s-ct-a .back').each(function(index){
            $(this).click(function(){
               $('.s-ct-a').eq(index).hide();
               $('#sign').css('z-index',10);
            })
        })
		//分享提示打开
    	$(".shareBtn").click(function(){
    		$("#fx_tips").show();
    	});
    	//分享提示关闭
    	$("#fx_tips").click(function(){
    		$("#fx_tips").hide();
    	});
        /*********************函数***************/
        
    };

 
};
yt.init();

