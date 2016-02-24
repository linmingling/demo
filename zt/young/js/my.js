String.prototype.format = function (args) {
    if (arguments.length > 0) {
        var result = this, reg;
        if (arguments.length == 1 &&
        Object.prototype.toString.call(args) == "[object Object]") {
            for (var key in args) {
                reg = new RegExp("({" + key + "})", "g");
                result = result.replace(reg, args[key]);
            }
        }
        else {
            for (var i in arguments) {
                if (arguments[i] == undefined) {
                    return "";
                }
                else {
                    reg = new RegExp("({[" + i + "]})", "gi");
                    result = result.replace(reg, arguments[i]);
                }
            }
        }
        return result;
    }
    else {
        return this;
    }
};  //end string


//亚太传媒
var yt = yt || {};

//全局配置
yt.cf = {
    w: 640,
    h:1008
};
//弹出层函数
yt.openWindow=window.openWindow = function (_obj, callBack) {

    if (!_obj) { return; }
    var cf = {
        obj: null,     //jquery对象 弹出层对象
        width: null,   //宽
        height: null,  //高
        lock: true,    //是否锁屏
        close: null    //回调函数
    };
    if (typeof _obj === 'string') {

        cf.obj = $(_obj);
    }
    else if (_obj instanceof jQuery) {
        cf.obj = _obj;
    }
    else if (typeof _obj === 'object' && _obj.obj) {
        cf = $.extend(true, cf, _obj);
    }
    var obj = cf.obj,
        $wbg = function () {
            var _wbg = function () {
                return $('#windows_bg');
            };
            if (!_wbg().length) {
                obj.parent().append('<a class="windows_bg" id="windows_bg" style="display: none;">  </a>');
            }
            return _wbg();
        }();

    var $parent = obj.parent(),
        _parent = $parent.get(0);
    $parent.show();
    obj.show();
    var close = function () {
        if (_parent.nodeName.toLowerCase() != 'body') {
            $parent.hide();
        }
        
        obj.hide();
        $wbg.hide();
        cf.close && cf.close(obj);
    },
    setly = function () {

        var topx = parseInt(($(parent.window).height() - obj.height()) / 2) + $(parent.window).scrollTop();
        if (topx < 0) { topx = 20; }
        obj.css({
            left: (parseInt(($(parent.window).width() - obj.width()) / 2) + $(parent.window).scrollLeft()),
            top: topx,
            position: "absolute"
        });


    },
    backApi = {
        obj: obj,
        bg: $("#window_bg"),
        close: close
    };
    init = function () {

        cf.width && obj.width(cf.width);
        cf.height && obj.height(cf.height);
        cf.lock && $wbg.show();
        obj.find('.t_clo,.btn_s').unbind().bind("click", close);
        $(window).resize(setly);
        setly();
        callBack && callBack.call(backApi);
    };
    init();

   
    return backApi;
};



//加载图片
yt.loadImg = function ($imgs, time) {
    var _time = 0;
    time = time || 20;

    $imgs.each(function () {
        var $that = $(this), src = $that.data('src');
        if (!($that.data('hasload') || !src)) {
        
            setTimeout(function () {

                $that.attr('src', src);
                $that.attr('data-hasload', 'true');

            }, _time);
            _time += time;
        }
        
    });
};

//内容切换
yt.bindTab = function (cf) {

    var _cf = {
        $menu: null,
        $cn: null,
        fade: true,
        fadeTime: 500,
        event: "click",
        activeCls: "active",
        eventAfter: null
    };
    cf = $.extend(true, {}, _cf, cf);

    if (cf.$menu.length < 1 || cf.$cn.length < 1) { return; }
    var $lis = cf.$menu.children(),
        $divs = cf.$cn.children();

    var tab = {
        $menu: cf.$menu,
        $cn: cf.$cn,
        index: 0
    };

    $lis.on(cf.event, function () {

        var $that = $(this);

     
        var index = $lis.index($that),
        $div = $divs.eq(index);

        if (!cf.fade) {
            $div.show().siblings().hide();
        }
        else {
            $div.siblings().hide();
            $div.fadeIn(cf.fadeTime);
        }

        $that.addClass(cf.activeCls).siblings().removeClass(cf.activeCls);
        tab.index = index;

        cf.eventAfter && cf.eventAfter.call(tab, index);

    });
    return tab;

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

//绑定滑动幻灯片
yt.bindSlider = function (index, isNav) {
    isNav = isNav || true;

    var mySwiper=$("#swiper-container" + index).swiper({
       pagination: isNav?".pagination" + index:null,
       paginaClickable: true,

       createPagination:true,
        grabCursor: true
    });
    if (isNav) {
        $(".pagination" + index + " .swiper-pagination-switch").click(function () {
            var $that = $(this),
                index = $that.index();
            mySwiper.swipeTo(index);
        });
    }
   
    return mySwiper
};

//绑定滑动幻灯片2
yt.bindSlider2 = function () {
    var $swiperContainer = $("#swiper-container2"),
        mySwipe;

    //滑动绑定函数
    var onSlideChangeTime = 0;

    var onSlideChange = function () {
        if (onSlideChangeTime > 1) {
            return;
        }
        onSlideChangeTime = 20;
        var index = mySwiper.activeIndex;
        nowIndex = index;




        var timer = setInterval(function () {
            onSlideChangeTime -= 1;
            if (onSlideChangeTime == 0) {
                clearInterval(timer);
            }
        }, 1);
    };

    var onTouchEnd = function () {
        onSlideChange();
    };

    var onSlideChangeEnd = function () {
        onSlideChange();
    };
    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            pagination: ".pagination2",
       
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            grabCursor: true
        });




    };
    
    //init
    bindSwiper();
};

//绑定滚动
yt.bindScroll = function (id) {
    //Scroll Containers
    $(id||'.scroll-container').each(function () {
        $(this).swiper({
            mode: 'vertical',
            scrollContainer: true,
            mousewheelControl: true,
            scrollbar: {
                container: $(this).find('.swiper-scrollbar')[0]
            }
        })
    })
};

//加入music
yt.addMusic= function () {
        $("body").append('');
        var musicBox = document.getElementById("musicBox");
        if (!musicBox.src) {
            musicBox.src = "js/music.mp3";
        }
        function touchmusic() {
            musicBox.pause();
            //musicBox.pause();
            //alert(1)
        }
        $(".music a").bind("click", function () {
            if ($(".music a.btnopen").size() > 0) {
                musicBox.play();
            } else {
                musicBox.pause();
            }
            $(this).toggleClass("btnopen");
        });
       
        return {
            play: function () {

                $("#music").show();
                musicBox.pause();
            }
        }
    };

//滑动绑定
yt.content = function () {
   
    var $swiperContainer = $("#swiper-container1"),
        $pages = $("#wrapper").children(),
        $as = $("#nav li a"),
        $lis = $("#nav li"),
        $win =$(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper;
    	i = 0;
    var params = {
        selectorClassName: "swiper-container",
        animationClassName: acn,
        animationElm: $("." + acn)
    };
    var setCssText = function (prop, value) {
        return prop + ': ' + value + '; ';
    };

    //在头部插入动画样式
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
     
    //设置动画样式
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
            w = yt.cf.w,
            h = yt.cf.h;
        var sl = function () {
            var _w = $wraper1.width(),
                hx = $win.height(),

               // _h = isWap && _w < hx ? $win.height() : _w * h / w;
            _h =  _w * h / w;
            $wrapers.height(_h);
        };
        sl();
        $win.resize(sl);
    };

    //设置弹出层父级窗体
    var setPWinLayout = function () {
        var $wraper1 = $("#win-wraper"),
            w = yt.cf.w,
            h = yt.cf.h;

        var sl = function () {
            var _w = $win.width(),
            _h = _w * h / w;
            if (_w < w) {
                $wraper1.height(_h);
            }
            else {
                $wraper1.height('100%');
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

        //懒加载当前模块图片
        loadImgx(index,0);


        onSlideChangeTime = 20;
        setAms();
        nowIndex = index || 0;
        history.pushState(null, null, "index.php?p=" + (nowIndex + 1));

        //懒加载下一模块图片 2秒后执行
        loadImgx(index,2000);
        
        if (index == 6) {
            var $video = $("#video"),
                hasLoad = $video.data('hasload');
            if (!hasLoad) {
                var html = $("#tpl-video").html();
                //$("#video").html(html).data('hasload',"true");
            }
            //setTimeout(function () {
            //    $("#video").html($("#tpl-video").html());
            //},2000);

        }

        //执行动画
        var timer=setInterval(function () {
            onSlideChangeTime -= 1;
            if (onSlideChangeTime == 0) {
                clearInterval(timer);
            }
        },1);
    };

    //触摸开始绑定
    var onTouchStart = function () {

    };

    //触摸结束绑定
    var onTouchEnd = function () {
        var index = mySwiper.index;
        if (nowIndex == slideCount-1 && +mySwiper.touches['diff'] <-50) {

           
            return mySwiper.swipeTo(0);
        }
        onSlideChange();
        
    };

    //滑动开始绑定
    var onSlideChangeStart = function () {

    };

    //滑动结束绑定
    var onSlideChangeEnd = function () {
       
        onSlideChange();
    };

    //绑定滑动主函数
    var bindSwiper = function () {
        mySwiper = $swiperContainer.swiper({
            pagination: false,
            paginationClickable: false,
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            mode: 'vertical',
			moveStartThreshold:100000,
            unTouchFn: function () {

                //return !!(mySwiper.touches['abs'] < 50);
                return !!this.getAttribute('data-ut');
            },
            grabCursor: true
        });
        $("#cn-slider4 *").attr("data-ut", "true");

    };
    
    //滚到下一个屏
    var bindNext = function () {
    	 $('.ctx1 p').click(function(){
		        var index = $(this).index();
		        $(this).addClass('current').siblings().removeClass('current');
		        $(this).siblings('.ans').html(index);
		 });
    	 
        $("#next").on("click", function () {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#next2").on("click", function () {
	        var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 3){
	        	i++;
	        }
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#next3").on("click", function () {
			
			var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 1){
	        	i++;
	        }
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#next4").on("click", function () {
			var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 2){
	        	i++;
	        }
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#next5").on("click", function () {
			var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 0){
	        	i++;
	        }
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#next6").on("click", function () {
			var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 3){
	        	i++;
	        }
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex||0) + 1;
            mySwiper.swipeTo(index);
        });
		$("#more8").on("click", function () {
			var _ans = $(this).parent('.cbnt').prev('.ctx1').find('.ans').html();
	        if(_ans == ''){
	        	alert('请选择');
	        	return;
	        }
	        if(_ans == 3){
	        	i++;
	        }
	        if(i == 6){
	        	//alert('恭喜你全部答对了，这里弹出信息收集框');
	             yt.openWindow("#win9");
	             yt.bindScroll("#swiper-containerx9");
	        } else {
	        	//alert('恭喜你全部答对了'+i+'题，这里弹出真遗憾的页面');
	        	$(".true_num").html(i);
	        	 var id = $(this).attr('id').replace('more', '');
	             yt.openWindow("#win" + id);
	             yt.bindScroll("#swiper-containerx" + id);
	        }
        });
		$(".readMore_share").on("click", function () {
			$("#win10").show();
		});
		
		$("#win10").on("click", function () {
			$("#win10").hide();
			location.href = "http://zt.jia360.com/young/index.php?p=1";
		});
		
		$(".readMore_add").on("click", function () {
			var name = $('#name').val(),
                phone = $('#phone').val(),
                address =$('#address').val();
                if(checkForm(name,phone,address)){
	              	  $.ajax({
	          			async:true,
	          		 	url: 'server.php',
	          		 	data: {act:'submit', name:name, phone:phone, address:address},
	          		 	type: 'post',
	          		 	dataType:'json',
	          		 	success:function(result){
	          		 		if(parseInt(result.code) == '2001'){
	          		 			alert(result.msg);
	          		 			$("#win10").show();
	          		 		} else {
	          		 			alert(result.msg);return;
	          		 		}
	          		 	}
	          		});
                }
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
        if (!params && !params[p] && params[p] < 1 || params[p] > slideCount) {
            return false;
        }
        //alert(params[p]);
        mySwiper.swipeTo(Math.floor(params[p])-1,1);
    };

    //产品滑动
    var bindSlider3 = function () {

        var mySlider3 = yt.bindSlider(3, false);

        $("#prevx").click(function () {

            var index = mySlider3.activeIndex;
            index = index == 0 ? 6 : index - 1;
            mySlider3.swipeTo(index);
        });

        $("#nextx").click(function () {
            var index = mySlider3.activeIndex;
            index = index == 6 ? 0 : index + 1;
            mySlider3.swipeTo(index);
        });
    };


    //懒加载模块图片
    var allLNum = 0;
    var loadImgx = function (index, time) {

        if (index == slideCount) { return; }

        var $cn = $pages.eq(index),
            hasLoad = $cn.data('hasLoad');

        time = time == undefined ? 1200 : time;
        setTimeout(function () {
            allLNum++;
            yt.loadImg($cn.find('.lz'));
            //if (allLNum < slideCount-1) {
            //    loadImgx(index+1);
            //}
        }, time)
    };


    //加载图片
    var loadImgs = function (time,name) {

        setTimeout(function () {
            yt.loadImg($(".lz"));
        },time||2000);
    };

    //阅读更多
    var bindWins = function () {
        $(".readMore").click(function () {
            var id = $(this).attr('id').replace('more', '');
            yt.openWindow("#win" + id);
            yt.bindScroll("#swiper-containerx" + id);
           

        });
    };

    //绑定产品图片
    var bindPros = function () {
        var sliders = {};
        var showImg = function (id, index) {
          
            var idx="#winp"+id,
                $idx = $(idx),
                mySlider = sliders[idx],
                $lzs = $idx.find('.lzx');
            
            yt.openWindow(idx);
            if (!mySlider) {
                sliders[idx] = yt.bindSlider(id);
                mySlider = sliders[idx];
            }
            mySlider.swipeTo(index, 1);
            yt.loadImg($lzs.eq(index), 0);
            setTimeout(function () {
                yt.loadImg($lzs, 0);
            }, 500)
        };

        $(".ax").click(function () {
            var $that = $(this);
            showImg($that.data('id'), +$that.attr('title')-1);
        });
    };

   //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setPWinLayout();
    setAms();
    goPageByParams();
    bindWins();
    bindPros();
    window.addEventListener('popstate', function (e) {
        goPageByParams(true);
    });

    loadImgs();
   // 验证表单
    function checkForm(name,tel,address){
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
        if(address == ""){
            alert("请填写地址！");
            return false;
        }
        return true;
    }
        

    
    //var music = yt.addMusic();

    /*setTimeout(function () {
        music.play();
    },3000);*/

};

yt.setPWinLayout = function () {
    var $wraper1 = $("#win-wraper"),
        $win = $(window),
        w = yt.cf.w,
        h = yt.cf.h;

    var sl = function () {
        var _w = $win.width(),
        _h = _w * h / w;
        if (_w < w) {
            $wraper1.height(_h);
        }
        else {
            $wraper1.height('100%');
        }

    };
    sl();
    $win.resize(sl);
};

//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        yt.content();
    };
};

yt.init();

