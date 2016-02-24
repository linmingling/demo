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
        $swiperContainer2 = $("#swiper-container2"),
        
        $pages = $("#wrapper").children(),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper,mySwiper2;

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
     * 向文档<!-- <head> -->底部插入css rule操作
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
        onSlideChange(); 
    };



    //滑动结束绑定
    var onSlideChangeEnd = function () {
        onSlideChange();
        
        if(mySwiper.activeIndex == 2){
            bindSwiper2();
            mySwiper2.swipeTo(0);
        }
        
    };
    //滑动开始绑定
    var onSlideChangeStart = function () {
        $("#bottomNav").css({"-moz-animation":"fadeOut 0.5s 0s forwards","-webkit-animation":"fadeOut 0.5s 0s forwards"});
    };
    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            //pagination: false,
            //paginationClickable: false,
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            onSlideChangeStart: onSlideChangeStart,
            mode: 'vertical',
            //mousewheelControl:true,
            //grabCursor: true
        });
    };
    
    //滚到下一个屏
    var bindNext = function () {
        $("#next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
       
            mySwiper.swipeTo(index);
        });
    };
    //获取地址参数
    var getParams = function () {
        var search = (window.location.search || "").replace('?', ''),
            params = search.split('&'),
           obj = {},
           len = params.length;
        if (len < 1) { return false;}
        while (len--) {
            var A=params[len].split('=');
            obj[A[0]] = A[1];
        }
        return obj;
    };
    //滚动到指定模块
    var goPageByParams = function (flag) {
        var params = getParams(),p='p';

        if(flag && window.location.search==''){
         
            return mySwiper.swipeTo(0,1);
        }
        if (!params && !params[p] && params[p] < 1 || params[p]>5) {
            return false;
        }
        //alert(params[p]);
        mySwiper.swipeTo(Math.floor(params[p])-1,1);
    };

    
    //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();
    goPageByParams();
    window.addEventListener('popstate', function (e) {
        goPageByParams(true);
    });
    
    
    //第3屏
    //绑定滑动
    var bindSwiper2 = function () {
        mySwiper2 = $swiperContainer2.swiper({
            // loop:true,
            onSlideChangeStart:onSlideChangeStart2,
           onTouchEnd: function(mySwiper2){
                            $('.containerBg').eq(mySwiper2.activeIndex).show().siblings('.containerBg').hide();
                         },
            mode: 'horizontal',
           // mousewheelControl:true,
           // grabCursor: true
        });
    };
    var onSlideChangeStart2 = function(){
        var img = $("#swiper-container2 .swiper-wrapper img").eq(mySwiper2.activeIndex);
        img.attr("src",img.attr("date-src"));
       
    };
    $("#page-3 .arrow-right").click(function(){
        if(mySwiper2.activeIndex == 4){
            mySwiper.swipeNext();
        } else{
           mySwiper2.swipeNext(); 
        }

        $('.containerBg').eq(mySwiper2.activeIndex).show().siblings('.containerBg').hide();
    });
    $("#page-3 .arrow-left").click(function(){
        mySwiper2.swipePrev();
        $('.containerBg').eq(mySwiper2.activeIndex).show().siblings('.containerBg').hide();
    });
};
//初始化
yt.init = function () {
     
    window.onload = function () {
        
        $("#loading").hide();
        $('.main').css('height',$(window).height());
        setTimeout(yt.app);

        //第4屏
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
            //礼品确定-
            $('#sure').click(function(){
                $('.cn3').hide();
                $('.cn4').show();

            })
            //信息提交
            $('#submit').click(function(){
                var name = $('#name').val();
                var tel  = $('#phone').val();
                var prov = $('#prov').val();
                var city = $('#city').val();
                if (checkForm(name,tel,prov,city)){
                    //关闭领取页
                    $.ajax({
                        async:false,
                        url: 'server.php',
                        data:{name: name, tel: tel, city: city, prov: prov},
                        type: "post",
                        dataType:'json',
                        success:function(result){
                            if (result.code == 2001)
                            {
                                //关闭领取页
                                $('.cn4').hide();
                                $('.cn5').show();
                                $('.share').show('slow');
                            } else {
                                alert(result.msg);
                            }
                        },
                        error:function(result){
                            alert("系统繁忙");
                        }
                    });
                }

            });
            //摇一摇
            function yao(){
                if(window.DeviceMotionEvent) {
                    var speed = 8;
                    var x = y = z = lastX = lastY = lastZ = 0;
                    window.addEventListener('devicemotion', function(){
                        var acceleration =event.accelerationIncludingGravity;
                        x = acceleration.x;
                        y = acceleration.y;
                        
                        if(shake && (Math.abs(x-lastX) > speed || Math.abs(y-lastY) > speed)) {
                            //振动
                            // if (navigator.vibrate) {
                            //  navigator.vibrate(2000);
                            // } else if (navigator.webkitVibrate) {
                            //  navigator.webkitVibrate(2000);
                            // }
                            //摇成功
                            var random ='20'+ Math.floor(Math.random()*100000+1);
                            $('.num').html(random);
                            $('.cn2').hide();
                            $('.cn3').show();
                            shake = false;
                        }
                        lastX = x;
                        lastY = y;
                    }, false);
                }else{
                    alert('抱歉您的手机不支持摇一摇功能！请点击摇手获取代金券');
                    disabled = true;
                }
            }
            //适应无摇一摇功能的手机
            $('.handImg').click(function(){
                if (disabled) {
                    var random ='20'+ Math.floor(Math.random()*100000+1);
                        $('.num').html(random);
                        $('.cn2').hide();
                        $('.cn3').show();
                        shake = false;
                }
            });
            //城市选择
            $("#citylist").citySelect({
                url:"js/city.js",
                prov:"广东",
                city:"广州",
                nodata:"none",
            });
            //关闭分享提示窗口
            $(".share").click(function(){
                $(this).hide();
            });
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
        
        // 验证表单
        function checkForm(name,tel,prov,city){
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
            var telp = /^0\d{2,3}-?\d{7,8}$/;
            if(city == ""){
                alert("请填写城市！");
                return false;
            }
            //判断小区
            if(prov == ""){
                alert("请填写省份！");
                return false;
            }
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
            return true;
        }
        
    };

 
};
yt.init();

