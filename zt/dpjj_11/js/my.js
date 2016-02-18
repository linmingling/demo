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

    $("#gopage2").bind('click',function(){
        mySwiper.swipeTo(1);
    });

    $("#gopage3").bind('click',function(){
        mySwiper.swipeTo(2);
    });

    $("#gopage5").bind('click',function(){
        mySwiper.swipeTo(4);
    });
    $("#gopage6").bind('click',function(){
        mySwiper.swipeTo(5);
    });
    $("#gopage7").bind('click',function(){
        mySwiper.swipeTo(6);
    });
    $("#gopage8").bind('click',function(){
        mySwiper.swipeTo(7);
    });

    $("#gopage9").bind('click',function(){
        mySwiper.swipeTo(8);
    });



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
        onSlideChange();

    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
			//mousewheelControl:true,
            mode: 'vertical',
            noSwiping : true
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

//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);	
    };

 
};
yt.init();


//产品特点
function td(type){
    $('.bg').fadeIn();
    $('#td').fadeIn();
    var _tdcon=$("#tdcon");
    var _tdfont=$("#tdfont");
    switch(type)
    {
        case 1:
          _tdcon.removeClass().addClass('td-content');
          _tdfont.removeClass().addClass('td-font');
          _tdfont.html('<p>☆日韩进口原件</p><p>☆一键式智能控制</p><p>☆纳米抑菌座圈</p><p>☆银离子抗菌喷头</p><p>☆易洁釉面</p>');
          break;
        case 2:
          _tdcon.removeClass().addClass('td-content');
          _tdfont.removeClass().addClass('td-font');
          _tdfont.html('<p>☆冲得干净用水少</p><p>☆超大管径不堵塞</p><p>☆使用静音无干扰</p><p>☆美式外观坐感好</p>');
          break;
        case 3:
          _tdcon.removeClass().addClass('td-content2');
          _tdfont.removeClass().addClass('td-font2');
          _tdfont.html('<p>☆采用高硬度铝镁合金材质，防潮耐用永不生锈；</p><p>☆表层真空镀膜，花色时尚，经久不脱落；</p><p>☆大型储物空间，可满足日常储物需求；</p><p>☆1250°高温瓷化陶瓷盆，光滑且易清洁；</p><p>☆经济适用，满足更多家庭需求；</p><p>☆款式设计新颖，时尚家居百搭。</p>');
          break;
        case 4:
          _tdcon.removeClass().addClass('td-content3');
          _tdfont.removeClass().addClass('td-font2');
          _tdfont.html('<p>☆花洒主体为全铜材质；</p><p>☆陶瓷阀芯，抑菌更耐用；</p><p>☆不锈钢软管，防爆裂不漏水；</p><p>☆升降杆可自由调节高度；</p><p>☆可随心调节水温，左热右冷；</p><p>☆三功能手持花洒；</p><p>☆ABS材质大顶喷；</p><p>☆自带置物层架，大面板更易收纳。</p><p>☆自带蓝牙音乐盒，具备播放音乐、接听电话等功能。</p><p>☆音乐盒可谁心取出，充电便捷。</p>');
          break;
        default:
          alert('未知错误');
          
    }
}
$('#tdclose').bind('click',function(){
    $('.bg').fadeOut();
    $('#td').fadeOut();
})

//产品参数
function cs(type){
    $('.bg').fadeIn();
    $('#cs').fadeIn();
    var _cscon=$("#cscon");
    var _csfont=$("#csfont");
    switch(type)
    {
        case 1:
          _cscon.removeClass().addClass('cs-content');
          _csfont.removeClass().addClass('cs-font');
          _csfont.html('<p>产品规格：780X410X560mm </p><p>产品墙距：305/400mm</p><p>进水要求：0.07Mpa-0.75Mpa</p><p>排水方式：地排冲 </p><p>水 量：6L</p><p>电 源：220V</p><p>产品功率：（最大）900W</p><p>水箱容积： 900ml</p><p>操作方式：遥控器及侧面感应按键两种方式</p>');
          break;
        case 2:
          _cscon.removeClass().addClass('cs-content2');
          _csfont.removeClass().addClass('cs-font2');
          _csfont.html('<p>产品规格：730x390x790mm</p><p>坑 距：305/400mm</p><p>进水要求：0.07-0.75Mpa</p><p>排水方式：喷射虹吸式底排水</p><p>用水量：4.8L </p>');
          break;
        case 3:
          _cscon.removeClass().addClass('cs-content2');
          _csfont.removeClass().addClass('cs-font2');
          _csfont.html('<p>产品材质：铝镁合金 </p><p>主柜规格：880*455*530mm</p><p>镜子规格：520*700*20mm </p><p>副柜规格：250*145*700mm </p><p>层架规格：520*120*40mm </p>');
          break;
        case 4:
          _cscon.removeClass().addClass('cs-content2');
          _csfont.removeClass().addClass('cs-font2');
          _csfont.html('<p>进水要求：0.07～0.75Mpa </p><p>花洒功能：三功能手持花洒</p><p>（配蓝牙音乐盒）</p><p>软管长度：1.5米花洒管 </p><p>顶喷尺寸： 8寸  </p>');
          break;
        default:
          alert('未知错误');
          
    }
}

$('#csclose').bind('click',function(){
    $('.bg').fadeOut();
    $('#cs').fadeOut();
})

//产品细节
function xj(type){
    
    $('.bg').fadeIn();
    
    // var _xjcontent=$("#xjcontent");
    // var _xjdian=$("#xjdian");
    

    switch(type)
    {
        case 1:
            $('#xj1').css('visibility','visible');
          // _xjcontent.html('<div class="swiper-slide"><div class="xj-content-1"><img src="images/prd1-1.png" /></div><div class="xj-content-2"><p>☆</p><p>盖板缓冲效果</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd1-2.png" /></div><div class="xj-content-2"><p>☆</p><p>一键式智能操控</p></div></div>');
          // _xjdian.html('<img src="images/icon-3.png" /><img src="images/icon-4.png" />');
          break;
        case 2:
            $('#xj2').css('visibility','visible');
          // _xjcontent.html('<div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-1.png" /></div><div class="xj-content-2"><p>☆</p><p>经典侧按</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-2.png" /></div><div class="xj-content-2"><p>☆</p><p>4寸超大排水阀，闪电急冲</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-3.png" /></div><div class="xj-content-2"><p>☆</p><p>48mm超大管径，</p><p>C型专利管道，绝不堵塞</p></div></div>');
          // _xjdian.html('<img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />');
          break;
        case 3:
            $('#xj3').css('visibility','visible');
          // _xjcontent.html('<div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-1.png" /></div><div class="xj-content-2"><p>☆</p><p>表层真空镀膜，时尚美观</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-2.png" /></div><div class="xj-content-2"><p>☆</p><p>铝镁合金材质，防潮耐用</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-3.png" /></div><div class="xj-content-2"><p>☆</p><p>十级电镀五金配件，经久耐用</p></div></div>');
          // _xjdian.html('<img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />');
          break;
        case 4:
            $('#xj4').css('visibility','visible');
          // _xjcontent.html('<div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-1.png" /></div><div class="xj-content-2"><p>☆</p><p>超薄豪华大顶喷</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-2.png" /></div><div class="xj-content-2"><p>☆</p><p>三功能手持花洒</p></div></div><div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-3.png" /></div><div class="xj-content-2"><p>☆</p><p>精致蓝牙音乐盒</p><p>航空级玻璃置物面板</p></div></div>');
          // _xjdian.html('<img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />');
          break;
        default:
          alert('未知错误');
          
    }
    
}

//六大优势
function ys(type){
    $('.bg').fadeIn();
    $('#ys').fadeIn();
}

$("#ysclose").bind('click',function(){
    $('.bg').fadeOut();
    $('#ys').fadeOut();
})

//预约升级
$("#yysj").bind('click',function(){
    $(".yysjtil,.chb-ly").removeClass('hide');
    $(".chb-ly").addClass('hide');
    $("#btn").text('预约升级');
    $('.bg').fadeIn();
    $('#buy1').fadeIn();
})
//立即预购
$("#ljyg").bind('click',function(){
    $(".yysjtil,.chb-ly").removeClass('hide');
    $(".yysjtil").addClass('hide');
    $("#btn").text('立即预购');
    $('.bg').fadeIn();
    $('#buy1').fadeIn();
})
$("#buyclose").bind('click',function(){
    $('.bg').fadeOut();
    $('#buy1').fadeOut();
})
$("#xjclose1").bind('click',function(){
    $('.bg').fadeOut();
    $('#xj1').css('visibility','hidden');
})
$("#xjclose2").bind('click',function(){
    $('.bg').fadeOut();
    $('#xj2').css('visibility','hidden');
})
$("#xjclose3").bind('click',function(){
    $('.bg').fadeOut();
    $('#xj3').css('visibility','hidden');
})
$("#xjclose4").bind('click',function(){
    $('.bg').fadeOut();
    $('#xj4').css('visibility','hidden');
})
//表单提交
$("#btn").bind('click',function(){
    //名字
    var name=$("#name").val();
    //联系电话
    var phone=$("#phone").val();
    //省
    var prov=$("#prov").val();
    //市
    var city=$("#city").val();
    //区
    var dist=$("#dist").val();
	var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;

    //立即预购提交
    if($(this).text().trim()=='立即预购')
    {
        var prd='';
        if($("#checkbox-1-1").is(':checked'))
        {
            prd+='奥斯卡马桶,';
        }
        if($("#checkbox-1-2").is(':checked'))
        {
            prd+='雅克浴室柜,';
        }
        if($("#checkbox-1-3").is(':checked'))
        {
            prd+='音乐花洒,';
        }
        if($("#checkbox-1-4").is(':checked'))
        {
            prd+='智能马桶,';
        }
        // //奥斯卡马桶
        // var prd1=$("#checkbox-1-1").is(':checked');
        // //雅克浴室柜
        // var prd2=$("#checkbox-1-2").is(':checked');
        // //音乐花洒
        // var prd3=$("#checkbox-1-3").is(':checked');
        // //智能马桶
        // var prd4=$("#checkbox-1-4").is(':checked');
        if(prd==''){
            alert('请选择产品!');
            return;
        }
        prd=prd.substring(0,prd.length-1);
		
		if(name == "" || !mob.test(phone) || prov == "请选择" || city == "" || dist ==""||prov==""){
			alert("请填写正确的信息");
			return;
		}else{
			var source = getCookie('source');
			$.ajax({
				async:true,
				url:'index.php?type=shenggou&from=1&fromid=2&source='+source,
				data:"goodsname="+prd+"&username="+name+"&phone="+phone+"&province="+prov+"&city="+city+"&address="+dist,
				type: 'post',
				dataType:'json',
				success:function(result){
					if(result.state == 1){
						//提交成功,清空数据
						$("#name").val('');
						$("#phone").val('');
						$("#prov").val('');
						// $("#city").val('');
						// $("#dist").val('');
						$("#city").empty();
						$("#dist").empty();
						$("#checkbox-1-1").attr("checked", false);
						$("#checkbox-1-2").attr("checked", false);
						$("#checkbox-1-3").attr("checked", false);
						$("#checkbox-1-4").attr("checked", false);
						alert("恭喜你，预购成功！");
						$.ajax({
							url:"index.php?type=sendmsg",
							data:"phone="+phone+"&content=【腾讯家居·优居网】"+name+"先生/小姐，恭喜您预购成功，您的预购码为"+result.msg+"，请凭预购码去东鹏洁具当地门店看样购买。请保持手机畅通，以便客服及时联系您，祝生活愉快。",
							type: "POST",
							dataType:'json',
							success:function(msg){
//							console.log(msg);
							}         
						});
					}


				}
			});
		}

        
    }
    else{
        //立即预约升级
        if(name == "" || !mob.test(phone) || prov == "请选择" || city == "" || dist ==""||prov==""){
			alert("请填写正确的信息");
			return;
		}else{
			var source = getCookie('source');
			$.ajax({
				async:true,
				url:'index.php?type=yuyue&from=1&fromid=2&source='+source,
				data:"username="+name+"&phone="+phone+"&province="+prov+"&city="+city+"&address="+dist,
				type: 'post',
				dataType:'json',
				success:function(result){
					if(result.state == 1){
						//提交成功,清空数据
						$("#name").val('');
						$("#phone").val('');
						$("#prov").val('');
						// $("#city").val('');
						// $("#dist").val('');
						$("#city").empty();
						$("#dist").empty();
						alert("恭喜你，预约成功！");
						$.ajax({
							url:"index.php?type=sendmsg",
							data:"phone="+phone+"&content=【腾讯家居·优居网】"+name+"先生/小姐，恭喜您预约浴室升级成功，除享受4项免费服务外，我们还将提供价值110元浴室升级现金供抵用券。请保持手机畅通，以便客服及时联系您，祝生活愉快。",
							type: "POST",
							dataType:'json',
							success:function(msg){}         
						});
					}
					else
					{
						alert(result.msg);
					}
				}
			});
		}
        

    }
    $('.bg').fadeOut();
    $('#buy1').fadeOut();
})


//省市区初始化
$(function(){ 
    var _prov=document.getElementById("prov"); 
    for(var e in list){ 
    var opt_1=new Option(list[e].province,list[e].province); 
    _prov.add(opt_1); 
    } 
    var mySwiper1;
     mySwiper1 = $("#swiper1 .swiper2-container").swiper({
        mode: 'horizontal',
        
        onSlideChangeEnd: function () {
            var index=mySwiper1.activeIndex;
            $("#xjdian1 img").attr('src','images/icon-4.png');
            $("#xjdian1 img").eq(index).attr('src','images/icon-3.png');
        },
    }); 
     var mySwiper2;
     mySwiper2 = $("#swiper2 .swiper2-container").swiper({
        mode: 'horizontal',
        
        onSlideChangeEnd: function () {
            var index=mySwiper2.activeIndex;
            $("#xjdian2 img").attr('src','images/icon-4.png');
            $("#xjdian2 img").eq(index).attr('src','images/icon-3.png');
        },
    }); 

     var mySwiper3;
     mySwiper3 = $("#swiper3 .swiper2-container").swiper({
        mode: 'horizontal',
        
        onSlideChangeEnd: function () {
            var index=mySwiper3.activeIndex;
            $("#xjdian3 img").attr('src','images/icon-4.png');
            $("#xjdian3 img").eq(index).attr('src','images/icon-3.png');
        },
    }); 

     var mySwiper4;
     mySwiper4 = $("#swiper4 .swiper2-container").swiper({
        mode: 'horizontal',
        
        onSlideChangeEnd: function () {
            var index=mySwiper4.activeIndex;
            $("#xjdian4 img").attr('src','images/icon-4.png');
            $("#xjdian4 img").eq(index).attr('src','images/icon-3.png');
        },
    }); 
    
} );



function toProvince(){ 
var _prov=document.getElementById("prov"); 
var _city=document.getElementById("city"); 
var _dist=document.getElementById("dist"); 
var v_prov=_prov.value; 

_city.options.length=1; 
_dist.options.length=1; 

    for(var e in list){ 

        if(list[e].province==v_prov){   
            for( var p in list[e].city){ 
            // console.log(list[e].province);   
            var opt_2=new Option(list[e].city[p].name,list[e].city[p].name); 
            _city.add(opt_2); 

            } 
            break; 
        } 
    } 
} 


function toCity(){ 
var _prov=document.getElementById("prov"); 
var _city=document.getElementById("city"); 
var _dist=document.getElementById("dist"); 

var v_prov=_prov.value; 
var v_city=_city.value; 

//_city.options.length=1; 
_dist.options.length=1; 


    for(var e in list){ 
        if(list[e].province==v_prov){ 
            for( var p in list[e].city){ 
                if(list[e].city[p].name==v_city){ 
                     
                     if(list[e].city[p].dist==null){
                        //console.log(list[e].city[p].dist); 全市不限区
                        _dist.add(new Option('全市','全市')); 
                     }
                     else{
                        for(var cc in list[e].city[p].dist){ 
                            var opt_3=new Option(list[e].city[p].dist[cc].name,list[e].city[p].dist[cc].name); 
                            _dist.add(opt_3); 
                        } 
                    }

                    return; 
                } 


            } 
            break; 
        } 
    } 
} 


//坑爹省市区数据
var list=[{"province":"广东", 
"city":[
{"name":"深圳市"}, 

{"name":"东莞市",
"dist":[{"name":"寮步镇"}, 
{"name":"石碣镇"}, 
{"name":"龙石镇"}]}, 

{"name":"珠海市", 
"dist":[{"name":"香洲区"}, 
{"name":"三乡区"}, 
{"name":"前山区"}]},

{"name":"中山市", 
"dist":[{"name":"石岐区"}, 
{"name":"小榄镇"}, 
{"name":"东升镇"}]},

{"name":"惠州市", 
"dist":[{"name":"惠阳区"}, 
{"name":"惠东县"}, 
{"name":"博罗县"},
{"name":"仲恺高新区"},
{"name":"龙门县"}]},

{"name":"揭阳市", 
"dist":[{"name":"惠来县"}, 
{"name":"普宁市"}]},

{"name":"汕头市", 
"dist":[{"name":"潮阳区"}]},

{"name":"梅州市", 
"dist":[{"name":"大埔县"}, 
{"name":"蕉岭县"}, 
{"name":"梅县"}]},

{"name":"汕尾市", 
"dist":[{"name":"陆丰市"}]},

{"name":"河源市", 
"dist":[{"name":"龙川县"}, 
{"name":"和平县"}, 
{"name":"连平县"},
{"name":"紫金县"}]},

{"name":"韶关市", 
"dist":[{"name":"武江区"}, 
{"name":"乐昌"}, 
{"name":"仁化"},
{"name":"翁源县"}]},

{"name":"清远市", 
"dist":[{"name":"佛冈县"}, 
{"name":"清城区"}]},

{"name":"肇庆市", 
"dist":[{"name":"端州区"}, 
{"name":"四会市"}]},

{"name":"湛江市"}, 

{"name":"江门市", 
"dist":[{"name":"新会区"}, 
{"name":"台山市"}, 
{"name":"鹤山市"}]},

{"name":"阳江市", 
"dist":[{"name":"江城区"}]},

{"name":"茂名市", 
"dist":[{"name":"电白县"}]},

{"name":"广州市", 
"dist":[{"name":"海珠区"}, 
{"name":"天河区"}, 
{"name":"黄埔区"},
{"name":"荔湾区"},
{"name":"从化市"},
{"name":"增城荔城镇"},
{"name":"增城新塘镇"},
{"name":"番禺区"}]},

{"name":"佛山市", 
"dist":[{"name":"三水区"}, 
{"name":"禅城区"}]}

]
}, 

{"province":"海南", 
"city":[
{"name":"海口市"},

{"name":"琼海市"},

{"name":"三亚市"}

] 
},

{"province":"江苏", 
"city":[
{"name":"宜兴市"},

{"name":"镇江市"},

{"name":"苏州市", 
"dist":[{"name":"苏州市市区"}, 
{"name":"昆山"}, 
{"name":"常熟"}]},

{"name":"无锡市", 
"dist":[{"name":"无锡市市区"}, 
{"name":"江阴市"}]},

{"name":"如皋市"},

{"name":"扬州市"},

{"name":"连云港市", 
"dist":[{"name":"新浦区"}, 
{"name":"东海县"}]},

{"name":"宿迁市", 
"dist":[{"name":"义乌市"}]},

{"name":"泰州市", 
"dist":[{"name":"海陵区"},
{"name":"高港区"},
{"name":"姜堰区"},
{"name":"靖江市"},
{"name":"泰兴市"},
{"name":"兴化市"}]},

{"name":"徐州市", 
"dist":[{"name":"徐州市市区"}, 
{"name":"新沂县"}, 
{"name":"睢宁县"}]},

{"name":"淮安市"},

{"name":"张家港市"},

{"name":"盐城市", 
"dist":[{"name":"大丰市"}, 
{"name":"亭湖区"}, 
{"name":"滨海县"},
{"name":"盐都区"},
{"name":"响水"},
{"name":"阜宁"},
{"name":"射阳"},
{"name":"建湖"},
{"name":"东台"}]},

{"name":"常州市"},

{"name":"南通市", 
"dist":[{"name":"南通市市区"}, 
{"name":"祁东县"}]},

{"name":"南京市", 
"dist":[{"name":"南京市市区"}, 
{"name":"溧水县"}]}

] 
},

{"province":"浙江", 
"city":[
{"name":"温州市"},

{"name":"衢州市"},

{"name":"金华市", 
"dist":[{"name":"东阳市"},
{"name":"金东区"}]},

{"name":"杭州市", 
"dist":[{"name":"拱墅区"},
{"name":"上城区"},
{"name":"下城区"},
{"name":"江干区"},
{"name":"西湖区"},
{"name":"滨江区"},
{"name":"萧山"},
{"name":"余杭"},
{"name":"富阳"},
{"name":"桐庐"},
{"name":"建德"},
{"name":"淳安"},
{"name":"临安"}]},

{"name":"嘉兴市"},

{"name":"湖州市", 
"dist":[{"name":"长兴县"}, {"name":"德清县"}, 
{"name":"南浔区"}]},

{"name":"宁波市", 
"dist":[{"name":"象山县"}]}

] 
},

{"province":"山东", 
"city":[
{"name":"青岛市"},

{"name":"威海市", 
"dist":[{"name":"环翠区"},
{"name":"荣成市"},
{"name":"文登市"}]},

{"name":"莱阳市"},

{"name":"烟台市", 
"dist":[{"name":"烟台市市区"}, 
{"name":"栖霞市"}]},

{"name":"临沂市", 
"dist":[{"name":"临沂市市区"},
{"name":"临沭县"}, 
{"name":"沂南县"}, 
{"name":"沂水县"}]},

{"name":"潍坊市", 
"dist":[{"name":"青州市"}, 
{"name":"寿光市"}]},

{"name":"济宁市"},

{"name":"泰安市", 
"dist":[{"name":"泰安市市区"}, 
{"name":"肥城市"}]},

{"name":"菏泽市", 
"dist":[{"name":"郓城县"}]},

{"name":"淄博市", 
"dist":[{"name":"淄川区"}]},

{"name":"滨州市", 
"dist":[{"name":"滨州市市区"}, 
{"name":"邹平市"}]},

{"name":"聊城市", 
"dist":[{"name":"冠县"}]},

{"name":"德州市"},

{"name":"东营市", 
"dist":[{"name":"东营市市区"}, 
{"name":"广饶县"}]},

{"name":"莱芜市"},

{"name":"济南市"},

{"name":"枣庄市", 
"dist":[{"name":"枣庄市市区"}]}

] 
},

{"province":"安徽", 
"city":[
{"name":"蚌埠市", 
"dist":[{"name":"蚌山区"}]},

{"name":"安庆市"},

{"name":"阜阳市"},

{"name":"亳州市", 
"dist":[{"name":"谯城区"}]},

{"name":"芜湖市", 
"dist":[{"name":"无为县"}]},

{"name":"六安市", 
"dist":[{"name":"舒城县"},
{"name":"六安市市区"}]},

{"name":"淮南市", 
"dist":[{"name":"凤台县"}]},

{"name":"滁州市"},

{"name":"合肥市"},

{"name":"宿州市"}

] 
},

{"province":"上海", 
"city":[
{"name":"上海市"}

] 
},

{"province":"黑龙江", 
"city":[
{"name":"大庆市"},

{"name":"哈尔滨市"}

] 
},

{"province":"吉林", 
"city":[
{"name":"长春市", 
"dist":[{"name":"全市"}]},

{"name":"吉林市"},

{"name":"松原市"},

{"name":"四平市"}

] 
},

{"province":"内蒙古（东）", 
"city":[
{"name":"兴安盟"},

{"name":"满洲里市"}

] 
},

{"province":"辽宁", 
"city":[
{"name":"沈阳市"},

{"name":"大连市"},

{"name":"盘锦市"},

{"name":"鞍山市"},

{"name":"葫芦岛市", 
"dist":[{"name":"龙港区"},
{"name":"绥中县"}]},

{"name":"阜新市"},

{"name":"锦州市", 
"dist":[{"name":"义县"}]},

{"name":"铁岭市"}

] 
},

{"province":"北京", 
"city":[
{"name":"北京市", 
"dist":[{"name":"东城区"},
{"name":"西城区"},
{"name":"海淀区"},
{"name":"朝阳区"},
{"name":"丰台区"},
{"name":"宣武区"},
{"name":"崇文区"},
{"name":"门头沟区"},
{"name":"石景山区"},
{"name":"房山区"},
{"name":"通州区"},
{"name":"顺义区"},
{"name":"昌平区"},
{"name":"大兴区"},
{"name":"怀柔区"},
{"name":"平谷区"},
{"name":"延庆县"},
{"name":"密云县"}]}

] 
},

{"province":"天津", 
"city":[
{"name":"天津市", 
"dist":[{"name":"河西区"},
{"name":"南开区"},
{"name":"东丽区"},
{"name":"红桥区"}]}

] 
},

{"province":"山西", 
"city":[
{"name":"运城市"},

{"name":"长治市"},

{"name":"临汾市", 
"dist":[{"name":"尧都区"},
{"name":"侯马市"}]},

{"name":"吕梁市", 
"dist":[{"name":"文水县"},
{"name":"孝义市"},{"name":"交城县"},
{"name":"汾阳县"}]},

{"name":"忻州市", 
"dist":[{"name":"代县"},
{"name":"忻府区"}]},

{"name":"太原市", 
"dist":[{"name":"太原市区"},
{"name":"清徐县"}]},





{"name":"阳泉市"},

{"name":"大同市"},


{"name":"晋中市", 
"dist":[{"name":"榆次区"},{"name":"平遥县"},{"name":"寿阳县"},{"name":"昔阳县"},{"name":"和顺县"},{"name":"东阳县"}]}

] 
},

{"province":"河北", 
"city":[
{"name":"石家庄市"},

{"name":"唐山市"},

{"name":"秦皇岛市"},

{"name":"保定市"},

{"name":"承德市"},

{"name":"沧州市", 
"dist":[{"name":"沧州市"},
{"name":"泊头市"}]},

{"name":"衡水市"},

{"name":"廊坊市", 
"dist":[{"name":"香河县"}]},

{"name":"邢台市"},

{"name":"张家口市"},

{"name":"邯郸市"},

{"name":"任丘市"},

{"name":"霸州市"}

] 
},

{"province":"湖南", 
"city":[
{"name":"常德市", 
"dist":[{"name":"武陵区"},
{"name":"澧县"},
{"name":"石门县"},
{"name":"汉寿县"}]},

{"name":"娄底市", 
"dist":[{"name":"娄底市"},
{"name":"双峰县"}]},

{"name":"郴州市", 
"dist":[{"name":"郴州市"},
{"name":"安仁县"},
{"name":"永兴县"},
{"name":"嘉禾县"},
{"name":"桂阳县"}]},

{"name":"邵阳市", 
"dist":[{"name":"隆回县"},
{"name":"邵东县"},
{"name":"邵阳市区"}]},

{"name":"衡阳市"},

{"name":"长沙市"},

{"name":"株洲市"},

{"name":"怀化市", 
"dist":[{"name":"全市"}]},

{"name":"永州市", 
"dist":[{"name":"冷水滩区"}]},

{"name":"湘西州", 
"dist":[{"name":"古丈县"},{"name":"吉首"},{"name":"龙山"}]},

{"name":"岳阳市"},

{"name":"益阳市"},

{"name":"湘潭市", 
"dist":[{"name":"岳塘区"}]},

{"name":"张家界市"}

] 
},

{"province":"江西", 
"city":[
{"name":"九江市", 
"dist":[{"name":"浔阳区"},
{"name":"修水县"},
{"name":"湖口县"},
{"name":"德安县"},
{"name":"都昌县"}]},

{"name":"吉安市", 
"dist":[{"name":"新干峡江"}]},

{"name":"抚州市"},

{"name":"萍乡市"},

{"name":"南昌市"},

{"name":"景德镇市", 
"dist":[{"name":"景德镇市市区"},
{"name":"乐平市"}]},

{"name":"新余市", 
"dist":[{"name":"新余市"},
{"name":"分宜县"}]},

{"name":"宜春市", 
"dist":[{"name":"袁州区"},
{"name":"上高县"},
{"name":"高安县"},
{"name":"宜丰县"}]},

{"name":"丰城市", 
"dist":[{"name":"丰城市市区"}]},

{"name":"赣州市", 
"dist":[{"name":"宁都县"},
{"name":"瑞金市"},
{"name":"章贡区"},
{"name":"兴国县"},
{"name":"于都县"}]},

{"name":"鄱阳县", 
"dist":[{"name":"鄱阳县"}]},

{"name":"上饶市", 
"dist":[{"name":"信州区"},
{"name":"横峰县"},
{"name":"婺源县"}]}

] 
},

{"province":"福建", 
"city":[
{"name":"龙岩市", 
"dist":[{"name":"上杭县"},{"name":"新罗区"},
{"name":"永定区"}]},

{"name":"莆田市", 
"dist":[{"name":"荔城区"},
{"name":"仙游县"},
{"name":"秀屿区"},
{"name":"涵江区"}]},

{"name":"宁德市", 
"dist":[{"name":"福鼎市"},
{"name":"柘荣县"},
{"name":"东侨经济开发区"},
{"name":"福安市"},
{"name":"霞浦县"}]},

{"name":"福州市", 
"dist":[{"name":"福州市"},
{"name":"闽侯县"},
{"name":"光泽县"}]},

{"name":"厦门市"},

{"name":"南平市", 
"dist":[{"name":"邵武市"}]},

{"name":"三明市", 
"dist":[{"name":"永安市"}]},

{"name":"泉州市"}

] 
},

{"province":"河南", 
"city":[
{"name":"信阳市", 
"dist":[{"name":"羊山新区"},
{"name":"固始县"}]},

{"name":"濮阳市", 
"dist":[{"name":"范县"}]},

{"name":"三门峡市"},

{"name":"平顶山"},

{"name":"郑州市"},

{"name":"周口市"},

{"name":"南阳市", 
"dist":[{"name":"南阳市区"},
{"name":"新野县"}]},

{"name":"邓州市"},

{"name":"开封市", 
"dist":[{"name":"开封市"}]},

{"name":"兰考县"},

{"name":"济源市"},

{"name":"许昌市"},

{"name":"驻马店", 
"dist":[{"name":"遂平县"}]},

{"name":"新乡市", 
"dist":[{"name":"卫辉市"}]},

{"name":"安阳市", 
"dist":[{"name":"林州市"}]}

] 
},

{"province":"湖北", 
"city":[
{"name":"襄阳市", 
"dist":[{"name":"襄阳市区"},{"name":"樊城区"},{"name":"南漳县"},
{"name":"枣阳市"}]},

{"name":"随州市", 
"dist":[{"name":"广水市"}]},

{"name":"十堰市"},

{"name":"荆门市", 
"dist":[{"name":"钟祥市"},
{"name":"荆门市区"}]},

{"name":"仙桃市"},

{"name":"孝感市",
"dist":[{"name":"孝南区"},]},

{"name":"天门市"},

{"name":"武汉市", 
"dist":[{"name":"江夏区"},
{"name":"硚口区"},{"name":"武昌"},{"name":"汉口"},
{"name":"洪山区"}]},

{"name":"黄石市", 
"dist":[{"name":"黄石市"},
{"name":"大冶市"}]},

{"name":"咸宁市", 
"dist":[{"name":"赤壁市"},
{"name":"嘉鱼县"},
{"name":"崇阳县"},
{"name":"通山县"}]},

{"name":"黄冈市", 
"dist":[{"name":"麻城市"},
{"name":"黄州"},
{"name":"英山县"}]},

{"name":"潜江市"},

{"name":"宜昌市"},

{"name":"荆州市", 
"dist":[{"name":"沙市区"},
{"name":"公安县"},
{"name":"洪湖市"}]},

{"name":"丹江口市", 
"dist":[{"name":"全市"}]},

{"name":"恩施市", 
"dist":[{"name":"咸丰县"},
{"name":"利川市"}]}

] 
},

{"province":"广西", 
"city":[
{"name":"玉林市", 
"dist":[{"name":"容县"},
{"name":"北流市"},{"name":"玉州区"},{"name":"福绵区"},{"name":"陆川县"},{"name":"博白县"},{"name":"兴业县"}]},

{"name":"钦州市"},

{"name":"百色市", 
"dist":[{"name":"平果县"},{"name":"右江区"},{"name":"田东县"}]},

{"name":"北海市", 
"dist":[{"name":"海城区"},
{"name":"合浦县"}]},

{"name":"柳州市"},

{"name":"南宁市"},

{"name":"梧州市", 
"dist":[{"name":"岑溪市"},{"name":"蝶山区"},{"name":"长洲区"},{"name":"龙圩区"},{"name":"藤县"},{"name":"苍梧县"}]},

{"name":"贵港市", 
"dist":[{"name":"贵港市"},
{"name":"桂平市"}]},

{"name":"来宾市", 
"dist":[{"name":"象州县"}]},

{"name":"桂林市", 
"dist":[{"name":"叠彩区"},
{"name":"平乐县"},{"name":"秀峰区"},{"name":"象山区"},{"name":"七星区"},{"name":"雁山区"},{"name":"临桂区"},{"name":"阳朔县"},{"name":"全州县"},{"name":"兴安县"},{"name":"灌阳县"},{"name":"龙胜县"},{"name":"荔浦县"},{"name":"恭城县"}]},

{"name":"贺州市", 
"dist":[{"name":"八步区"}]}

] 
},

{"province":"云南", 
"city":[
{"name":"昆明市", 
"dist":[{"name":"昆明市区"},{"name":"晋宁县"},{"name":"石林县"},{"name":"寻甸县"}]},

{"name":"蒙自市"},

{"name":"保山市", 
"dist":[{"name":"龙陵县"},{"name":"施甸县"},{"name":"腾冲县"}]},

{"name":"楚雄州", 
"dist":[{"name":"武定县"}]},
{"name":"大理州", 
"dist":[{"name":"大理市"},{"name":"宾川县"},{"name":"鹤庆县"},{"name":"南涧县"},{"name":"祥云县"}]},
{"name":"德宏州", 
"dist":[{"name":"陇川县"},{"name":"芒市"},{"name":"瑞丽市"},{"name":"盈江县"}]},
{"name":"红河州", 
"dist":[{"name":"开远市"},{"name":"泸西县"},{"name":"弥勒市"}]},
{"name":"景洪市", 
"dist":[{"name":"勐腊县"}]},
{"name":"德宏州", 
"dist":[{"name":"陇川县"},{"name":"芒市"},{"name":"瑞丽市"},{"name":"盈江县"}]},
{"name":"临沧市", 
"dist":[{"name":"临沧市区"},{"name":"耿马县"},{"name":"永德县"}]},
{"name":"普洱市", 
"dist":[{"name":"普洱市区"},{"name":"景东县"},{"name":"孟连县"}]},
{"name":"曲靖市", 
"dist":[{"name":"陆良县"},{"name":"罗平县"},{"name":"沾益县"},{"name":"宣威市"}]},
{"name":"玉溪市", 
"dist":[{"name":"峨山县"},{"name":"新平县"},{"name":"元江县"},{"name":"易门县"}]},
{"name":"昭通市", 
"dist":[{"name":"昭通市区"},{"name":"鲁甸县"}]},
{"name":"香格里拉市", 
"dist":[{"name":"全市"}]},
] 
},

{"province":"贵州", 
"city":[
{"name":"黔西南州", 
"dist":[{"name":"兴义市"},
{"name":"兴仁县"},
{"name":"安龙县"}
]},

{"name":"遵义市", 
"dist":[{"name":"仁怀市"},{"name":"汇川区"},{"name":"红花岗区"}]},

{"name":"贵阳市",
"dist":[{"name":"贵阳市区"},{"name":"开阳县"}]},

{"name":"黔东南州", 
"dist":[{"name":"凯里市"},{"name":"锦屏县"}]},

{"name":"安顺市",
"dist":[{"name":"安顺市区"},{"name":"平坝县"}]},

{"name":"黔南州市",
"dist":[{"name":"都匀市"},
		{"name":"福泉市"}
		]},
] 
},

{"province":"四川", 
"city":[
{"name":"攀枝花市"},

{"name":"都江堰市"},

{"name":"成都市", 
"dist":[{"name":"彭州市"},
{"name":"成华区"},
{"name":"温江区"}]},

{"name":"南充市", 
"dist":[{"name":"南充市"},
{"name":"阆中市"},{"name":"营山县"},{"name":"南部县"}]},
{"name":"西昌市", 
"dist":[{"name":"会理县"}]},

{"name":"宜宾市"},

{"name":"遂宁市", 
"dist":[{"name":"射洪县"}]},

{"name":"眉山市", 
"dist":[{"name":"彭山县"},{"name":"洪雅县"}]},

{"name":"德阳市"},

{"name":"内江市", 
"dist":[{"name":"东兴区"},
{"name":"隆昌县"}]},

{"name":"广安市", 
"dist":[{"name":"广安区"}]},

{"name":"峨眉山市", 
"dist":[{"name":"峨眉山市市区"}]},

{"name":"泸州市", 
"dist":[{"name":"叙永县"},
{"name":"合江县"},{"name":"龙马潭区"},{"name":"纳溪区"},{"name":"古蔺县"}]},

{"name":"绵阳市"}

] 
},

{"province":"重庆", 
"city":[
{"name":"重庆市", 
"dist":[{"name":"酉阳县"},
{"name":"石柱县"},
{"name":"梁平县"},
{"name":"垫江县"},
{"name":"江津区"},
{"name":"永川区"},
{"name":"九龙坡区"},
{"name":"璧山区"},
{"name":"南川区"},
{"name":"巫山县"},
{"name":"丰都县"},
{"name":"大足区"}]}

] 
},

{"province":"陕西", 
"city":[
{"name":"榆林市", 
"dist":[{"name":"榆林市区"},
{"name":"神木县"},
{"name":"靖边县"}]},

{"name":"西安市", 
"dist":[{"name":"西安市区"},
{"name":"渭南"},
{"name":"临潼"},
{"name":"富平"},
{"name":"蒲城"},
{"name":"咸阳"},
{"name":"阎良"},
{"name":"大荔"},
{"name":"铜川"},
{"name":"泾阳"},
{"name":"眉县"},
{"name":"汉中"},
{"name":"仁德"}]}

] 
},

{"province":"甘肃", 
"city":[
{"name":"天水市", 
"dist":[{"name":"麦积区"},
{"name":"武山县"}]},

{"name":"定西市", 
"dist":[{"name":"陇西县"}]},

{"name":"兰州市", 
"dist":[{"name":"城关区"},
{"name":"红古区"}]},

{"name":"酒泉市", 
"dist":[{"name":"全市"}]},

{"name":"金昌市", 
"dist":[{"name":"全市"}]},

{"name":"平凉市", 
"dist":[{"name":"全市"}]},

{"name":"庆阳市", 
"dist":[{"name":"全市"}]},

{"name":"张掖市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"青海", 
"city":[
{"name":"西宁市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"西藏", 
"city":[
{"name":"拉萨市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"新疆", 
"city":[
{"name":"克拉玛依市", 
"dist":[{"name":"全市"}]},

{"name":"乌鲁木齐市", 
"dist":[{"name":"全市"}]},

{"name":"昌吉市", 
"dist":[{"name":"全市"}]},

{"name":"库尔勒市", 
"dist":[{"name":"全市"}]},

{"name":"吐鲁番市", 
"dist":[{"name":"鄯善县"}]},

{"name":"哈密市", 
"dist":[{"name":"全市"}]},

{"name":"喀什市", 
"dist":[{"name":"全市"}]},

{"name":"奎屯市", 
"dist":[{"name":"全市"}]},

{"name":"博乐市", 
"dist":[{"name":"全市"}]},

{"name":"伊宁市", 
"dist":[{"name":"边境经济合作区"}]}

] 
},

{"province":"内蒙古", 
"city":[
{"name":"包头市", 
"dist":[{"name":"全市"}]},

{"name":"鄂尔多斯市", 
"dist":[{"name":"东胜区"}]},

{"name":"锡林浩特市", 
"dist":[{"name":"全市"}]},

{"name":"乌兰察布市", 
"dist":[{"name":"集宁区"}]},

{"name":"呼和浩特市", 
"dist":[{"name":"新城区"}]},

{"name":"乌海市", 
"dist":[{"name":"全市"}]}

] 
},

{"province":"宁夏", 
"city":[
{"name":"银川市", 
"dist":[{"name":"兴庆区"}]},

{"name":"固原市", 
"dist":[{"name":"全市"}]}

] 
}

]; 