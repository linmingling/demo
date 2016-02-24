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




    //滑动结束绑定
    var onSlideChangeEnd = function () {
		
        //console.log(mySwiper.activeIndex)
        onSlideChange();
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            // onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
			//mousewheelControl:true,
            //mode: 'vertical'
            moveStartThreshold:10000
        });
    };

    //绑定滑动 眼见惠实

    var bindSwiper2 = function () {
        var mySwiper2 = $("#swiper2 .swiper-container").swiper({
            mode: 'horizontal',
            //mousewheelControl:true,
            //grabCursor: true,
            loop:true
        });
        setTimeout(function(){
            $("#boonTc").css({"z-index":1,"opacity":1})
            $("#boonTc").hide();
        },1000);

      
    };
    
    var notice = function(){
        $("#x2").xMarquee({speed:50,temp:-2,});
    }
  

   //初始化
    bindSwiper();
    setLayout();
    setAms();
    bindSwiper2();

    notice();
    
    //请求省
    $.ajax({
        async:false,
        type:'get',
        url : 'http://pay.yoju360.com/phone/Ext/region/1',  //对应省的地址
        dataType : 'jsonp',
        jsonp:"callback",
        success  : function(data) {
            if(data.state ==  1){
                var option = "<option value='0'>省份</option>";
                var list = data.data;
                for(var i in list){
                    option = option + '<option value="'+i+'">'+list[i]+'</option>';
                }
                $("#province").html(option);
            }
        },
        error : function() {
            alert("服务器忙，请刷新！")
        }
    });

    //请求市
    $("#province").change(function(){
        if($("#province").val() != 0){
            $.ajax({
                async:false,
                type:'get',
                url : 'http://pay.yoju360.com/phone/Ext/region/'+$("#province").val(),
                dataType : 'jsonp',
                jsonp:"callback",
                success  : function(data) { 
                    if(data.state ==  1){
                        var option = "<option value='0'>城市</option>";
                        var list = data.data;
                        for(var i in list){
                            option = option + '<option value="'+i+'">'+list[i]+'</option>';
                        }
                        $("#city").html(option);
                    }
                },
                error : function() {
                    alert("服务器忙，请重试！")
                }
            });
        }
    });

    // 打开弹层
    $(".openTc").click(function(){
        var tc = $(this).attr("tc");
        $("#"+tc).fadeIn();
        $("#"+tc+" img").each(function(){
            if($(this).attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        })
    });
    // 关闭弹层
    $(".tc .close").click(function(){
        $(this).closest(".tc").hide()
    });

  // 跳转页面
    $(".goto").click(function(){
        var page = $(this).attr("page");
        mySwiper.swipeTo(page);
    });

    // 显示奖项
    // 1：盛世金兰茶具套装 2：钥匙扣 3：装饰画 4：iphone 5:话费5 6:话费10 7:话费30 8:话费100
    var price = new Array(
            new Array("images/jp1.jpg","获得<span class='name'>盛世金兰茶具套装</span>一套","form1",""),
            new Array("images/jp2.jpg","获得<span class='name'>蒙娜丽莎彩瓷钥匙扣</span>一个","form1",""),
            new Array("images/jp3.jpg","获得<span class='name'>蒙娜丽莎陶瓷装饰画</span>一个","form1",""),
            new Array("images/jp4.jpg","获得<span class='name'>IPhone6S</span>一台","form1",""),
            new Array("images/jp5.jpg","获得<span class='name'>手机话费5元</span>一个","form2","5元"),
            new Array("images/jp5.jpg","获得<span class='name'>手机话费10元</span>一个","form2","10元"),
            new Array("images/jp5.jpg","获得<span class='name'>手机话费30元</span>一个","form2","30元"),
            new Array("images/jp5.jpg","获得<span class='name'>手机话费100元</span>一个","form2","100元")
        );
    var showPrice = function(i){

        $("#pricePage .jpImg").attr("src",price[i-1][0]);
        $("#pricePage .textBox .red").html(price[i-1][1]);
        $("#pricePage .btn").attr("tc",price[i-1][2]);
        $("#pricePage .priceInfo").html(price[i-1][3]);
        
        mySwiper.swipeTo(3);
    }
    
    // 点击第一页摇一摇
    var check = true;
    $(".page-1 .btn2").click(function(){
        if(!check) return false;
        check = false;
        $.ajax({
            async:false,
            url:'server.php',
            data:{act:'is_start'},
            type: 'post',
            dataType:'json',
            success:function(result){
                check = true;
                if(result.errcode){
                	// 木有次数啦
                    mySwiper.swipeTo(2);
                    $(".page-3 .btn1").show();
                    $(".page-3 .btn2").hide();
                    $("#over").hide();
                    $("#chance").html("今天的抽奖机会用完了");
                } else {
	                // 还有次数
                	if(result.prize_code){
                        showPrice(result.prize_code);
                    } else {
                        mySwiper.swipeTo(1);
                    }
                }
            }
        });
    });
    
    // 摇一摇
    var shake = true;
    var musicBox = document.getElementById("musicBox");
            
    var choujiang = function(){
        $(".page-2 .shake").removeClass("shakeAnim");
        if(!shake) return false;
        shake = false;
        $.ajax({
            async:false,
            url:'server.php',
            data:{act:'start'},
            type: 'post',
            dataType:'json',
            success:function(result){
                $("#over").show();
                if(!result.errcode){
                    $(".page-2 .shake").addClass("shakeAnim");
                    setTimeout(function(){
                    	shake = true;
                        if(result.prize_code){
                            showPrice(result.prize_code);
                        } else {
                        	$("#over").show();
                            mySwiper.swipeTo(2);
                        }
                        if(result.num){
                            // 如果还有抽奖次数
                            $(".page-3 .btn1").hide();
                            $(".page-3 .btn2").show();
                            $("#chance").html('今天还有 <span class="red">'+result.num+'</span> 次抽奖机会');
                        } else {
                            // 如果已经没有了抽奖次数了
                            $(".page-3 .btn1").show();
                            $(".page-3 .btn2").hide();
                            $("#chance").html("今天的抽奖机会用完了");
                        }
                    },2000);
                    
                } else if(result.errcode == 1005) {
                    mySwiper.swipeTo(2);
                    $(".page-3 .btn1").show();
                    $(".page-3 .btn2").hide();
                    $("#over").hide();
                    $("#chance").html("今天的抽奖机会用完了");
                } else {
                    alert(result.errmsg);
                    mySwiper.swipeTo(4);
                }
            }
        });
    }

    if(window.DeviceMotionEvent) {  
        var speed = 25;  
        var x = y = z = lastX = lastY = lastZ = 0;  
        window.addEventListener('devicemotion', function(){  
            var acceleration =event.accelerationIncludingGravity;  
            x = acceleration.x;  
            y = acceleration.y;  
            if(Math.abs(x-lastX) > speed || Math.abs(y-lastY) > speed) {  
                if(mySwiper.activeIndex == 1){
                    musicBox.play();
                    choujiang();
                }
            }  
            lastX = x;  
            lastY = y;  
        }, false);  
    }else{
        // 不支持摇一摇，点击图片抽奖
        $(".page-2 .shake").click(function(){
            choujiang();
        })
    }
     // 抽奖电脑测试
//    $(".page-2 .shake").click(function(){
//        musicBox.play();
//        choujiang();
//    });

    // 提交表格1
    $("#form1 .btn").click(function(){
        if($(this).hasClass("false"))return false;

        var name = $("#form1 .name").val();
        var tel = $("#form1 .tel").val();
        var province = $("#province").find("option:selected").text();
        var city = $("#city").find("option:selected").text();
        var adress = $(".adress").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        
        if(name == ""){
            alert("请填写姓名");
        }else if(!mob.test(tel)){
            alert("请填写正确的手机号码");
        }else if(province == "省份"){
            alert("请选择省份");
        }else if(city == "城市"){
            alert("请选择城市");
        }else if(adress == ""){
            alert("请填写详细地址");
        }else{
            $("#form1 .btn").addClass("false");
            // 提交表单
            $.ajax({
                async:true,
                url:'server.php',
                data:{act:'submit', name:name, phone:tel, province:province, city:city, address:adress},
                type: 'post',
                dataType:'json',
                success:function(result){
                    $("#form1 .btn").removeClass("false");
                    if(result.errcode){
                    	alert(result.errmsg);
                    } else {
                    	// 成功跳转到二维码
                    	$("#form1").hide();
                        mySwiper.swipeTo(4);
                    }
                }
            });
        }
    });

    // 提交表格2
    $("#form2 .btn").click(function(){
        if($(this).hasClass("false"))return false;

        var name = $("#form2 .name").val();
        var tel = $("#form2 .tel").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;

        if(name == ""){
            alert("请填写姓名");
        }else if(!mob.test(tel)){
            alert("请填写正确的手机号码");
        }else{
            $("#form2 .btn").addClass("false");
            // 提交表单
            $.ajax({
                async:true,
                url:'server.php',
                data:{act:'submit', name:name, phone:tel},
                type: 'post',
                dataType:'json',
                success:function(result){
                	$("#form2 .btn").removeClass("false");
                    if(result.errcode){
                    	alert(result.errmsg);
                    } else {
                    	// 成功跳转到二维码
                    	$("#form2").hide();
                        mySwiper.swipeTo(4);
                    }
                }
            });
        }
    });

    $("#shareTips").click(function(){
        $("#shareTips").hide();
    });
    $("#comTips").click(function(){
        $("#comTips").hide();
    });
};
//初始化
yt.init = function () {
    window.onload = function () {
        $("#loading").hide();
        $("#comTips").show();
        setTimeout(yt.app);
    };
};
yt.init();

