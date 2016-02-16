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
        // 加载图片
        $("#swiper-container1 .swiper-slide img").each(function(){
            if($(this).attr("data-src")){
                $(this).attr("src",$(this).attr("data-src"));
            }
        });

        // 百度统计
        var page = mySwiper.activeIndex+1;
        var hmID = "mlg_PV_" + page;
        // console.log(hmID)
        _hmt.push(['_trackEvent', '美力格', 'mlg_滑屏PV', hmID]);

        onSlideChange();
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            mode: 'vertical',
            // loop:true,
            pagination :"#pagination1"
			
        });
    };
    //滑动2 绑定内页滑动函数
    var bindSwiper2 = function () {
        mySwiper2 = $("#swiper2 .swiper-container").swiper({
            mode: 'horizontal',
            loop:true,
            pagination :"#swiper2 .pagination"
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
    bindSwiper2();
    bindNext();
    setLayout();
    setAms();


    // 倒计时
    function djs(i){
        //console.log(i)
        if(i<1){
            $("#baoming .getCode").html("获取验证码").removeClass("false2");
        }else{
            $("#baoming .getCode").html(i+"s重新获取").addClass("false2");
            setTimeout(function(){djs(i-1)},1000);
        }
    }

    // 发短信
    function send(tel, j){
        $.ajax({
			async:true,
			url:'/phone/meilige/send',
			data:{phone:tel, verify:j},
			type: 'post',
			dataType:'json',
			success:function(result){
			}
		});
    }

    // 打开关闭通用提示
    function comTips(text){
        $("#comTips .tipsBody").html(text);
        $("#comTips").show();
    }
    
    $("#comTips .tipsClose").click(function(){
        $("#comTips .tipsBody").html("");
        $("#comTips").hide();
    });

    //获取验证码
    function getVerify(tel){
    	$.ajax({
			async:true,
			url:'/phone/meilige/getVerify',
			data:{phone:tel},
			type: 'post',
			dataType:'json',
			success:function(result){
				if(result.errcode){
                    $("#baoming .getCode").removeClass("false2");
					comTips(result.errmsg);
				} else {
    			    djs(60);
    			    send(tel, result.verify);   
			        $("#baoming .lpForm").hide();
			        $("#baoming .bmForm").show();
				}
			}
		});
    }
    
   
    // 打开报名层
    $(".click_btn").click(function(){
        $("#baoming").show();
        
        // 百度统计
        var page = mySwiper.activeIndex+1;
        var hmID = "mlg_Page_" + page;
        // console.log(hmID);
        _hmt.push(['_trackEvent', '美力格', 'mlg_0元领票按钮', hmID]);

        //后台页面布点
        var btn_id = $(this).attr('data-id');
        $("#btn_id").attr('value', btn_id);
        $.ajax({
            async:true,
            url:'/phone/meilige/click',
            data:{btn_id:btn_id},
            type: 'post',
            dataType:'json',
            success:function(result){
            }
        });
   
    });
    // 关闭报名层
    $("#baoming .bmClose").click(function(){
        if($("#baoming .bmForm").css("display") != "block"){
            $("#baoming").hide();
        }else{
            // alert("请完善您的收件地址，我们会免费为您寄送门票。");
            $("#baoming .bmForm .address").val("请完善您的收件地址").addClass("errTips");
            $("#baoming .bmForm .bmBtn").addClass("false");
        }
    });
    $("#baoming .bmForm .address").focus(function(){
        var address = $("#baoming .address").val();
        if(address == "请完善您的收件地址"){
            $("#baoming .address").val("").removeClass("errTips");
        }
    });

    // 检测是否填写姓名电话
    $("#baoming .lpForm input").keyup(function(){
        var name = $("#baoming .name").val();
        var tel = $("#baoming .tel").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;

        if(name =="" || tel =="" || !mob.test(tel)){
            $("#baoming .lpBtn").addClass("false");
            return false;
        }else{
            $("#baoming .lpBtn").removeClass("false");
        }
    });

  // 领票弹出
    $("#baoming .lpBtn").click(function(){
        // 百度统计
        var hmID = "mlg_Page_lpBtn";
        // console.log(hmID);
        _hmt.push(['_trackEvent', '美力格', 'mlg_提交用户信息', hmID]);

    	if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        } else {
        	$("#baoming .lpBtn").html("正在提交...").addClass("false");
        	$("#baoming .lpBtn").addClass("false2");
        	var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var btn_id = $("#baoming #btn_id").val();
            //发短信
        	$.ajax({
    			async:true,
    			url:'/phone/meilige/submit',
    			data:{btn_id:btn_id, name:name, phone:tel},
    			type: 'post',
    			dataType:'json',
    			success:function(result){
    				$("#baoming .lpBtn").html("提交领票").removeClass("false");
    				if(result.errcode == 1002){
    					$("#baoming").hide();
   		                $("#again").show();
    				} else if (result.errcode){
    					comTips(result.errmsg);
    				} else {
    					getVerify(tel);
    				}
    			}
    		});
        }
    });

    // 检测是否填写地址验证码
    function check2(){
        var code = $("#baoming .code").val();
        var address = $("#baoming .address").val();
        var area = $("#baoming .area").val();
        if(code =="" || address == "" || address == "请完善您的收件地址" || area == "--请选择--"){
            $("#baoming .bmBtn").addClass("false");
            return false;
        }else{
            $("#baoming .bmBtn").removeClass("false");
        }
    }
    
    $("#baoming .bmForm input").keyup(function(){
        check2();
    });
    $("#baoming .bmForm select").change(function(){
        check2();
    });
    
    // 重新获取验证码
    $("#baoming .getCode").click(function(){
        // 百度统计
        var hmID = "mlg_Page_getCode";
        // console.log(hmID);
        _hmt.push(['_trackEvent', '美力格', 'mlg_重新获取验证码', hmID]);

        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            $("#baoming .getCode").addClass("false2");
            var tel = $("#baoming .tel").val();
            //发短信
        	$.ajax({
    			async:true,
    			url:'/phone/meilige/getVerify',
    			data:{phone:tel},
    			type: 'post',
    			dataType:'json',
    			success:function(result){
                    $("#baoming .getCode").removeClass("false2");
    				if(result.errcode){
    					comTips(result.errmsg);
    				} else {
	    			    djs(60);
	    			    send(tel, result.verify);
    				}
    			}
    		});
        }
    });
    
    // 提交验证码及详细地址
    $("#baoming .bmBtn").click(function(){
        // 百度统计
        var hmID = "mlg_Page_bmBtn";
        // console.log(hmID);
        _hmt.push(['_trackEvent', '美力格', 'mlg_提交地址信息', hmID]);

        if($(this).hasClass("false") || $(this).hasClass("false2")){
            return false;
        }else{
            //报名
        	$("#baoming .bmBtn").html("正在报名...").addClass("false2");
        	var tel = $("#baoming .tel").val();
        	var code = $("#baoming .code").val();
            var address = $("#baoming .address").val();  //详细地址
            var area = $("#baoming .area").val();   //区
        	$.ajax({
    			async:true,
    			url:'/phone/meilige/submit_code',
    			data:{code:code, phone:tel, address:address, area:area},
    			type: 'post',
    			dataType:'json',
    			success:function(result){
    				$("#baoming .bmBtn").html("立即报名").removeClass("false2");
    				if(!result.errcode){
    				    $("#baoming").hide();
   		                $("#succeed").show();
    		            send(tel, 0);
    				} else if(result.errcode == 1004){
                        //验证码错误
                        $("#baoming .code").val("").attr("placeholder","验证码错误").addClass("redPlaceholder");
    				    $("#baoming .bmBtn").addClass("false");
                    } else {
    					//其他错误
	    				comTips(result.errmsg);
    				}
    			}
    		});
        }
    });
    
    $("#baoming .code").focus(function(){
        $("#baoming .code").val("").attr("placeholder","请输入验证码").removeClass("redPlaceholder");
    });


    // 个城市 区选项
    $.ajax({
        async:false,
        type:'get',
        url : payDomain + '/phone/Ext/region/77',
        dataType : 'jsonp',
        jsonp:"callback",
        success  : function(data) { 
            if(data.state ==  1){
                var option = "";
                var list = data.data;
                for(var i in list){
                    option = option + '<option value="'+list[i]+'">'+list[i]+'</option>';
                }
                $("#area").html(option);
            }
        },
        error : function() {
            alert("服务器忙，请重试！")
        }
    });

    // 打开即算第一页pv
    var hmID = "mlg_PV_" + 1;
    _hmt.push(['_trackEvent', '美力格', 'mlg_滑屏PV', hmID]);
    
	
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		
        var w = $(window).width();
        var h = $(window).height();
		// console.log(w+" , "+h+" , "+h/w)
        if(h/w<1.41){
            $("#swiper-container1").addClass("fat");
        }
    };

 
};
yt.init();

