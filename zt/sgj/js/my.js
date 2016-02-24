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
        mySwiper,
        _zx = 1;

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

       /* var index = mySwiper.index;
		
        if (nowIndex == slideCount-1 && +mySwiper.touches['diff'] <-50) {
            return mySwiper.swipeTo(0);
        }*/
	   
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
		
        //console.log(mySwiper.activeIndex)
        onSlideChange();
        if(mySwiper.activeIndex == 2){
            setTimeout(function(){
                mySwiper.swipeTo(3);
            },2500)
        }
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            moveStartThreshold:10000
			//mousewheelControl:true,
            //mode: 'vertical'
			
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

    var btn1 = $('#btn1').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });

    var btn2 = $('#btn2').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });
    var btn3 = $('#btn3').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });
    var btn4 = $('#btn4').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });
    var btn5 = $('#btn5').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });
    var btn6 = $('#btn6').jRange({
        from: 0,
        to: 100,
        step: 1,
        scale: [0,25,50,75,100],
        format: '%s',
        width: "100%"
    });


    //抽选人物
    var setPerson = function () {
        var i = (Math.random()*7).toFixed(0);
        var span = $("#p3 .cy span");
        switch(i){
            case "1":$("#p4 .rw").hide().eq(0).show();
                     $("#p5 .rw").hide().eq(0).show();
                     span.eq(0).html(1);
                     span.eq(1).html(9);
                     span.eq(2).html(9);
                     span.eq(3).html(2);
                     break;
            case "2":$("#p4 .rw").hide().eq(1).show();
                     $("#p5 .rw").hide().eq(1).show();
                     span.eq(0).html(2);
                     span.eq(1).html(0);
                     span.eq(2).html(0);
                     span.eq(3).html(3);
                     break;
            case "3":$("#p4 .rw").hide().eq(2).show();
                     $("#p5 .rw").hide().eq(2).show();
                     $("#p5 .rw").hide().eq(1).show();
                     span.eq(0).html(1);
                     span.eq(1).html(9);
                     span.eq(2).html(8);
                     span.eq(3).html(6);
                     break;
            case "4":$("#p4 .rw").hide().eq(3).show();
                     $("#p5 .rw").hide().eq(3).show();
                     $("#p5 .rw").hide().eq(1).show();
                     span.eq(0).html(1);
                     span.eq(1).html(9);
                     span.eq(2).html(8);
                     span.eq(3).html(6);
                     break;
            case "5":$("#p4 .rw").hide().eq(4).show();
                     $("#p5 .rw").hide().eq(4).show();
                     $("#p5 .rw").hide().eq(1).show();
                     span.eq(0).html(1);
                     span.eq(1).html(9);
                     span.eq(2).html(9);
                     span.eq(3).html(5);
                     break;
            default:$("#p4 .rw").hide().eq(5).show();
                    $("#p5 .rw").hide().eq(5).show();
                     $("#p5 .rw").hide().eq(1).show();
                     span.eq(0).html(1);
                     span.eq(1).html(9);
                     span.eq(2).html(9);
                     span.eq(3).html(6);
                     break;

        }
    }
    //更换造型
	var setZX = function () {
        //console.log(_zx%6)
        $("#p4").removeClass("style"+(_zx%6)).addClass("style"+(_zx+1)%6);
        $("#p5").removeClass("style"+(_zx%6)).addClass("style"+(_zx+1)%6);
        _zx++;
    }

   //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();
	setPerson();
    setZX();

    //mySwiper.swipeTo(0);

    $("#in .am3 .high").click(function(){

        if($(this).next().html()>25){
            console.log("跳转页面");
           
        }
    });

    $("#in .am4 .high").click(function(){
        if($(this).next().html()<25){
            console.log("分享提示");
            $("#shareTips").fadeIn();
        }
    });

    $("#p1 .high").click(function(){
        //console.log($(this).next().html())
        if($(this).next().html()<20){
            console.log("翻页 goto2")
            mySwiper.swipeTo(1);
        }
    });

    $("#p4 .high").click(function(){
        //console.log($(this).next().html())
        if($(this).next().html()<20){
            console.log("翻页 goto5")
            mySwiper.swipeTo(4);
        }
    });
    $("#p5 .am3 .high").click(function(){
        //console.log($(this).next().html())
        if($(this).next().html()>80){
            console.log("重置");
            location.reload(false);
            /*_zx = 1;
            setPerson();
            setZX();
            $(".whiteBg").empty();
            $(".btnBox input").val(0)
            mySwiper.swipeTo(2);*/
        }
    });
    $("#p5 .am4 .high").click(function(){
        //console.log($(this).next().html())
        if($(this).next().html()<25){
            console.log("分享提示");
            $("#shareTips").fadeIn();
        }
    });
    $("#shareTips").click(function(){
        $("#shareTips").fadeOut();
   
    });

    $("#p2 .am1").click(function(){
        mySwiper.swipeTo(2);
    });

    $(".upload").click(function(){
        $("#file").click();
    });

    $("#file").on("change", function(){
        
        // Get a reference to the fileList
        var files = !!this.files ? this.files : [];
      
        // If no files were selected, or no FileReader support, return
        if (!files.length || !window.FileReader) return;
      
        // Only proceed if the selected file is an image
        if (/^image/.test( files[0].type)){
      
            // Create a new instance of the FileReader
            var reader = new FileReader();
      
            // Read the local file as a DataURL
            reader.readAsDataURL(files[0]);
      
            // When loaded, set image data as background of div
            reader.onloadend = function(){
            
                console.log(this.result)

                $(".whiteBg").empty().append("<img src='"+this.result+"'>");
         
            }
        }else{
            alert("请上传图片");
        }
      
    });
    if(window.DeviceMotionEvent) {
        var speed = 10;
        var x = y = z = lastX = lastY = lastZ = 0;
        window.addEventListener('devicemotion', function(){
            var acceleration =event.accelerationIncludingGravity;
            x = acceleration.x;
            y = acceleration.y;
            
            if((Math.abs(x-lastX) > speed || Math.abs(y-lastY) > speed)) {
                setZX();
                /*if(shake){
                    shake = false;
                    
                }
                if (navigator.vibrate) {
                    navigator.vibrate(1000);
                } else if (navigator.webkitVibrate) {
                    navigator.webkitVibrate(1000);
                }*/
            }
            lastX = x;
            lastY = y;
        }, false);
    }else{
        //不支持摇一摇
        alert("您的手机暂不支持摇一摇!");
        
    }


    //测试用
    $("#p4 .am1").click(function(){
        setZX();
    });

};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		
		
    };

 
};
yt.init();

