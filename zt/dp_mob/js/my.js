var yt = yt || {};

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
  if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1 
    c_end=document.cookie.indexOf(";",c_start)
    if (c_end==-1) c_end=document.cookie.length
    return unescape(document.cookie.substring(c_start,c_end))
    } 
  }
return ""
}

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
	
		$(".swiper-slide").eq(mySwiper.activeIndex).find("img").each(function(){
			if($(this).attr("date-src")){
				$(this).attr("src",$(this).attr("date-src"));
			}
		});
		$(".swiper-slide").eq(mySwiper.activeIndex+1).find("img").each(function(){
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
	
	//mySwiper.swipeTo(5);
	
	$(".icon").click(function(){
		var i = $(this).index()-1;
		var product = $(this).closest(".container").find(".product");
		product.eq(i).show();
	});
	$(".product").click(function(){
		$(this).hide();
	});
	$(".yuyue").click(function(){
		$("#yuyueBox").show();
	});
	$("#yuyueBox .close").click(function(){
		$("#yuyueBox").hide();
	});
	$("#yuyueBox .yuyueBtn").click(function(){
        if($(this).hasClass("false")){return};
        
		var name = $("#yuyueBox .name").val();
		var tel = $("#yuyueBox .tel").val();
		var sheng = $("#province").val();
		var shi = $("#yuyueBox .city").eq(currentShowCity).val();
        var address = $("#yuyueBox .address").val();
		var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
		//console.log(sheng+" , "+shi)
		if(name == "" || sheng == "省份" || shi == "城市" || !mob.test(tel) || address ==""){
			alert("请填写正确的信息");
		}else{
            $(this).addClass("false").html("正在预约...");
			var source = getCookie('source');
			$.ajax({
				async:true,
				url:'http://zt.jia360.com/dongpeng/index.php?type=yuyue&from=1&fromid=2&source='+source,
				data:"username="+name+"&phone="+tel+"&province="+sheng+"&city="+shi+"&address="+address,
				type: 'post',
				dataType:'json',
				success:function(result){
					if(result.state == 1){
						$("#yuyueBox").hide();
						$("#yuyueBox .yuyueBtn").removeClass("false").html("预约焕新");
						alert("恭喜你，预约成功！");
						$.ajax({
							url:"http://zt.jia360.com/dongpeng/index.php?type=sendmsg",
							data:"phone="+tel+"&content=尊敬的"+name+"，恭喜您预约报名成功，我们会在24小时内联系您。除了免费量尺、提供设计方案外，我们还提供抵用券、东鹏礼包。请保持手机畅通，请留意我们的客服电话【东鹏洁具】",
							type: "POST",
							dataType:'json',
							success:function(msg){}         
						});
					}
					$("#yuyueBox .yuyueBtn").removeClass("false").html("预约焕新");
				}
			});
		}
	});
	
	$(".shengou").click(function(){
		$("#shengouBox").show();
	});
	$("#shengouBox .close").click(function(){
		$("#shengouBox").hide();
	});
	$("#shengouBox .shengouBtn").click(function(){
        if($(this).hasClass("false")){return};
        
		var name = $("#shengouBox .name").val();
		var tel = $("#shengouBox .tel").val();
        var sheng = $("#province1").val();
        var shi = $("#shengouBox .city1").eq(currentShowCity2).val();
        var address = $("#shengouBox .address").val();
		var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;

        //var select = $("#shengouBox input[name='product']:checked").val();
        var select = $("#shengouBox .checkbox");
		var cb = "";
		
		for (var i = 0, j = 0; i < select.length; i++){
			if (select.eq(i).attr("checked")){
				//cb.push(select.eq(i).val());
                if(cb == ""){
                    cb = select.eq(i).val();
                }else{
                    cb = cb+","+select.eq(i).val();
                }
				//console.log(i+" , "+select.eq(i).val()+" , "+cb);
			}
		}
        //console.log(cb)
		if(name == "" || !mob.test(tel) || cb == "" || sheng == "省份" || shi == "城市" || address ==""){
			alert("请填写正确的信息");
		}else{
            $(this).addClass("false").html("正在申购...");
			var source = getCookie('source');
			$.ajax({
				async:true,
				url:'http://zt.jia360.com/dongpeng/index.php?type=shenggou&from=1&fromid=2&source='+source,
				data:"goodsname="+cb+"&username="+name+"&phone="+tel+"&province="+sheng+"&city="+shi+"&address="+address,
				type: 'post',
				dataType:'json',
				success:function(result){
					if(result.state == 1){
						$("#shengouBox").hide();
						$("#shengouBox .shengouBtn").removeClass("false").html("立即申购");
						alert("恭喜你，申购成功！");
						$.ajax({
							url:"http://zt.jia360.com/dongpeng/index.php?type=sendmsg",
							data:"phone="+tel+"&content=尊敬的"+name+"，恭喜您预约成功，您的申购码为"+result.msg+"，请凭借申购码去线下购买，亲，线下付款购买后，我们可以包邮哦【东鹏洁具】",
							type: "POST",
							dataType:'json',
							success:function(msg){}         
						});
					}
				}
			});
		}
		
	});
	
	$(".goto").click(function(){
		var page = $(this).attr("goto");
		mySwiper.swipeTo(page);
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

