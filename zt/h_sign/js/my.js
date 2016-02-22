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
        if(mySwiper.activeIndex==1){
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
            mode: 'vertical',
            mousewheelControl:true,
			
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
    $('.sucBack').click(function(){
        mySwiper.swipeTo(2);
    })
    $("#sign").swipeUp(function(){mySwiper.swipeTo(2);});
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
        
        /*************第二页的交互***************/
        //弹出试用规则
        $('.button-4').click(function(){
            $('.page-2 .am5').show();
            $('#sign').css('z-index',0);
        })
        //弹出试用名单
        $('.button-5').click(function(){
            $('.page-1 .am7').show();
            $('#sign').css('z-index',0);
        })
        //试用名单下一页
        $("#two_btn").click(function(){
            $('#one').hide();
            $('#two').show();
        })
        //试用名单上一页
        $("#one_btn").click(function(){
            $('#one').show();
            $('#two').hide();
        })
         //弹出监察员名单
        $('.button-6').click(function(){
            $('.page-1 .am8').show();
            $('#sign').css('z-index',0);
        })
        //增加样式
        $('.select .chk').each(function(index){
            var s1= '免费试用';
            var s2= '上门检测';
            $(this).click(function(){
                if ($(this).hasClass('checked')){
                     $(this).removeClass('checked');
                    if(index==0){
                        s1= '';
                    } else {
                        s2= '';
                    }
                } else {
                    $(this).addClass('checked');
                    if(index==0){
                        s1= $(this).attr('value');
                    } else {
                        s2= $(this).attr('value');
                    }
                }
                $('#select').val(s1+'  '+s2);
            })
        })
        $('.page-2 .am4 .ct .chk').click(function(){
            $('#select').val($(this).attr('value'));
        })
        //提交活动报名信息
        $('.sure').click(function(){
            //报名信息1
            var name= returnVal('name');
            var phone= returnVal('phone');
            var city= returnVal('city');
            var select= returnVal('select');
            if(checkForm(name,phone,city,select)){
                $.ajax({
                	async:false,
                    url: 'server.php',
                    data:{act:'trial', name:name, phone:phone, city:city, select:select},
                    type: "post",
                    dataType:'json',
                    success:function(result){
                    	if(parseInt(result.code) == 1){
                    		alert(result.msg);
                    	}else if(parseInt(result.code) == 2001){
                            //成功将信息赋给下一个表单
                            $('#name1').val(name);
                            $('#phone1').val(phone);
                            $('#city1').val(city);
                            //成功提示层
                            $('.page-2 .am6').show();
                            $('#sign').css('z-index',0);
                    	} else {
                    		alert(result.msg);
                    	}
                    }
                });
                
            }
        })

        /*************第三页的交互***************/
        $('.sex .chk').click(function(){
            $('#sex').val($(this).attr('value'));
        })
        $('.isclean .chk').click(function(){
            $('#isclean').val($(this).attr('value'));
        })
        $('.isdec .chk').click(function(){
            $('#isdec').val($(this).attr('value'));
        })
        $('.issmoking .chk').click(function(){
            $('#issmoking').val($(this).attr('value'));
        })
        $('.ishealth .chk').click(function(){
            $('#ishealth').val($(this).attr('value'));
        })
        $('.isanimal .chk').click(function(){
            $('#isanimal').val($(this).attr('value'));
        })
        //弹出申请条件
        $('.button-2').click(function(){
            $('.page-3 .am9').show();
        })
        //弹出报名内容
        $('.button-3').click(function(){
            $('#request').show();
        })
        //返回关闭当前窗
        $('.s-ct-a .back').each(function(index){
            $(this).click(function(){
               $('.s-ct-a').hide();
               $('#sign').css('z-index',10);
            })
        })
        //提交活动报名信息
        $('.sub-1').click(function(){
            //复选框
            var type =[];
            $('input[type=checkbox]:checked').each(function(){
                type.push($(this).val());
            })
            //报名信息2
            var name1= returnVal('name1');
            var sex=returnVal('sex');
            var phone1= returnVal('phone1');
            var city1= returnVal('city1');
            var address= returnVal('address');
            var type= type;
            var isclean= returnVal('isclean');
            var isdec= returnVal('isdec');
            var issmoking= returnVal('issmoking');
            var ishealth= returnVal('ishealth');
            var isanimal = returnVal('isanimal');//新增
            //宣言内容
            var xy = returnVal('x1') + returnVal('x2');
            if(checkForm_2(name1,sex,phone1,city1,address,ishealth,issmoking,isdec,isclean,isanimal,xy)){
                $.ajax({
                	async:false,
                    url: 'server.php',
                    data:{act:'apply', name:name1, phone: phone1, sex:sex, city:city1, address:address, type:type, ishealth:ishealth, issmoking:issmoking, isdec:isdec, isclean:isclean,isanimal:isanimal, xy:xy},
                    type: "post",
                    dataType:'json',
                    success:function(data){
                    	if(parseInt(data.code) == 1){
                    		alert(data.msg);
                    	} else if(parseInt(data.code) == 2001){
                    		//成功提示层
                    		$("#request").hide();
                            $('.page-3 .am10').show();
                    	} else {
                    		alert(data.msg);
                    	}
                    }
                });
                
            }
        })

        /*************第四页的交互***************/
        $('.special img').each(function(index){
            $(this).click(function(){
                $('.specialW .ct').eq(index).show().siblings().hide();
            })
        })
        /*********************函数***************/
        //return value
        function returnVal(id){
            return $('#'+id).attr('value');
        }
		// 验证表单1
        function checkForm(name,tel,city,select){
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
            var telp = /^0\d{2,3}-?\d{7,8}$/;
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
            
            if(city == ""){
                alert("请选择城市！");
                return false;
            }
            //判断小区
            if(select == ""){
                alert("请选择方式！");
                return false;
            }
            return true;
        }
        // 验证表单2
        function checkForm_2(name,sex,tel,city,address,ishealth,issmoking,isdec,isclean,isanimal,xy){
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
            var telp = /^0\d{2,3}-?\d{7,8}$/;
            //判断收货人是否为空
            if(name == ""){
               alert("请输入姓名！");
               return false;
            }
            if(sex == ""){
               alert("请选择性别！");
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
            if(city == ""){
                alert("请填写城市！");
                return false;
            }
            if(address == ""){
                alert("请填写详细地址！");
                return false;
            }
            /*if(type == ""){
                alert("请选择家庭成员！");
                return false;
            }*/
            if(isdec == ""){
                alert("请判断是否新装修！");
                return false;
            }

            if(issmoking == ""){
                alert("请判断家里是否有人吸烟！");
                return false;
            }
            if(ishealth == ""){
                alert("请判断家里是否有呼吸疾病人员！");
                return false;
            }
            if(isanimal == ""){
                alert("请判断家里是否有宠物！");
                return false;
            }
            if(isclean == ""){
                alert("请判断是否使用过空气净化器！");
                return false;
            }
            if(xy == ""){
                alert("请填写宣言！");
                return false;
            }
            return true;
        }      
    };

 
};
yt.init();

