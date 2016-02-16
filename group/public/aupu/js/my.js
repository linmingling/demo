var yt = yt || {};

//加载图片
yt.loadImg = function($imgs, time) {
    var _time = 0;
    time = time || 200;

    $imgs.each(function() {
        var $that = $(this);
        if ($that.data('hasload')) {
            return false;
        }
        setTimeout(function() {
            $that.fadeOut(0);
            $that.attr('src', $that.data('src'));
            $that.attr('data-hasload', 'true');
            $that.fadeIn(500);
        }, _time);
        _time += time;
    });
};

//wap端环境
yt.isWap = function() {
    var s = navigator.userAgent.toLowerCase();
    var ipad = s.match(/ipad/i) == "ipad",
        iphone = s.match(/iphone os/i) == "iphone os",
        midp = s.match(/midp/i) == "midp",
        uc7 = s.match(/rv:1.2.3.4/i) == "rv:1.2.3.4",
        uc = s.match(/ucweb/i) == "ucweb",
        android = s.match(/android/i) == "android",
        ce = s.match(/windows ce/i) == "windows ce",
        wm = s.match(/windows mobile/i) == "windows mobile";
    if (iphone || midp || uc7 || uc || android || ce || wm || ipad) {
        return true;
    }
    return false;
};

//滑动绑定
yt.app = function() {

    var $swiperContainer = $("#swiper-container1"),
        $pages = $("#wrapper").children(),
        $as = $("#nav li a"),
        $lis = $("#nav li"),
        $win = $(window),
        slideCount = $pages.length,
        nowIndex = 0,
        acn = "animation",
        mySwiper;

    var params = {
        selectorClassName: "swiper-container",
        animationClassName: acn,
        animationElm: $("." + acn)
    };
    var setCssText = function(prop, value) {
        return prop + ': ' + value + '; ';
    };

    /*
     * insertCss(rule)
     * 向文档<head>底部插入css rule操作
     * rule: 传入的css text
     * */
    var insertCss = function(rule) {
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

    var setAnimationStyle = function() {
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
        $ans.each(function() {
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
    var setAms = function() {
        insertCss(setAnimationStyle());
    };

    //设置布局
    var setLayout = function() {
        var $wrapers = $("#swiper-container1 .wraper"),
            $wraper1 = $("#wraper1"),

            isWap = yt.isWap(),
            w = 720,
            h = 1135;
        var sl = function() {
            var _w = $wraper1.width(),
                h = $win.height(),
                _h = isWap && _w < h ? $win.height() : _w * 1135 / 720;
            $wrapers.height(_h);
            if ($win.height() < 300) {
                $(".cn-slidetips").hide();
            } else {
                $(".cn-slidetips").show();
            }
        };
        sl();
        $win.resize(sl);
    };

    //滑动绑定函数
    var onSlideChangeTime = 0;

    var onSlideChange = function() {
        if (onSlideChangeTime > 1) {
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
        var timer = setInterval(function() {
            onSlideChangeTime -= 1;
            if (onSlideChangeTime == 0) {
                clearInterval(timer);
            }
        }, 1);
    };


    //触摸结束绑定
    var onTouchEnd = function() {

        var index = mySwiper.index;

        if (nowIndex == slideCount - 1 && +mySwiper.touches['diff'] < -50) {
            return mySwiper.swipeTo(0);
        }

    };

    //滑动结束绑定
    var onSlideChangeEnd = function() {
        $("#swiper-container1 .swiper-slide img").each(function() {

            if ($(this).attr("data-src")) {
                $(this).attr("src", $(this).attr("data-src"));
            }
        });

        var page = mySwiper.activeIndex+1;
        var hmID = "ap_PV_" + page;
        _hmt.push(['_trackEvent', '奥普', 'ap_滑屏PV', hmID]);


        /* var load1 = mySwiper.activeIndex*2 + 1;
         var load2 = mySwiper.activeIndex*2 + 2;

         //console.log(load1+" , "+load2);
         $("#swiper-container1 .page-"+load1+" img").each(function(){
             if($(this).attr("data-src")){
                 $(this).attr("src",$(this).attr("data-src"));
             }
         });
         $("#swiper-container1 .page-"+load2+" img").each(function(){
             if($(this).attr("data-src")){
                 $(this).attr("src",$(this).attr("data-src"));
             }
         });*/
        onSlideChange();
    };
    //滑动2 绑定内页滑动函数
    var bindSwiper2 = function() {
        mySwiper2 = $("#swiper2 .swiper-container").swiper({
            mode: 'horizontal',
            //mousewheelControl:true,
            //grabCursor: true,
            loop: true,
            pagination: "#swiper2 .pagination",
            paginationClickable: true
        });

    };

    //滑动3 绑定内页滑动函数

    var bindSwiper3 = function() {
        mySwiper3 = $("#swiper3 .swiper-container").swiper({
            mode: 'horizontal',
            //mousewheelControl:true,
            //grabCursor: true,
            loop: true,
            pagination: "#swiper3 .pagination",
            paginationClickable: true
        });

    };
    //绑定滑动主函数
    var bindSwiper = function() {
        mySwiper = $swiperContainer.swiper({
            onTouchEnd: onTouchEnd,
            onSlideChangeEnd: onSlideChangeEnd,
            //mousewheelControl:true,
            mode: 'vertical',
            pagination: "#pagination1",
            paginationClickable: true
        });
    };

    //滚到下一个屏
    var bindNext = function() {
        $(".next").on("click", function() {
            mySwiper.activeIndex = mySwiper.activeIndex || 0;
            var index = mySwiper.activeIndex == slideCount - 1 ? 0 : (mySwiper.activeIndex || 0) + 1;

            mySwiper.swipeTo(index);
        });
    };


    //初始化
    bindSwiper();
    bindNext();
    setLayout();
    setAms();

    bindSwiper2();
    bindSwiper3();

    function djs(i) {
        //console.log(i)
        if (i < 1) {
            $("#baoming .getCode").html("获取验证码").removeClass("false2");
        } else {
            $("#baoming .getCode").html(i + "s重新获取").addClass("false2");
            setTimeout(function() {
                djs(i - 1)
            }, 1000);
        }
    }

    function send(tel, j) {
    	$.ajax({
            async: true,
            url: '/phone/aupu/send',
            data: {phone: tel,verify: j},
            type: 'post',
            dataType: 'json',
            success: function(result) {}
        });
    }

    function comTips(text) {
        $("#comTips .tipsBody").html(text);
        $("#comTips").show();
    }

    $(".cityOpen").click(function() {
        $("#citySelect").show();
    });
    $("#citySelect .cityClose").click(function() {
        $("#citySelect").hide();
    });
    $("#citySelect .black_bg").click(function() {
        $("#citySelect").hide();
    });

    $(".bmOpen").click(function() {
        var page = mySwiper.activeIndex+1;
        var hmID = "ap_Page_" + page;
        _hmt.push(['_trackEvent', '奥普', 'ap_0元领票按钮', hmID]);

        $("#baoming").show();
        $("#succeed img").each(function() {
                // 加载成功页面图片
                if ($(this).attr("data-src")) {
                    $(this).attr("src", $(this).attr("data-src"));
                }
            })
    });

    $("#baoming .bmClose").click(function() {
        $("#baoming").hide();
    });

    $("#baoming .lpForm input").keyup(function() {
        var name = $("#baoming .name").val();
        var tel = $("#baoming .tel").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;

        if (name == "" || tel == "" || !mob.test(tel)) {
            $("#baoming .lpBtn").addClass("false");
            return false;
        } else {
            $("#baoming .lpBtn").removeClass("false");
            if (name != "") {
                $("#baoming .lpBtn").removeClass("false");
            } else {
                $("#baoming .lpBtn").addClass("false");
            }
        }
    });

    // 领票弹出
    $("#baoming .lpBtn").click(function() {
        var page = mySwiper.activeIndex+1;
        var hmID = "ap_lpBtn";
        _hmt.push(['_trackEvent', '奥普', 'ap_提交用户信息', hmID]);

        if ($(this).hasClass("false") || $(this).hasClass("false2")) {
            return false;
        } else {
            $("#baoming .lpBtn").html("正在提交...").addClass("false");
            $("#baoming .lpBtn").addClass("false2");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            var btn_id = $("#baoming #btn_id").val();
            //发短信
            $.ajax({
                async: true,
                url: '/phone/aupu/getVerify',
                data: {name: name, phone: tel, btn_id: btn_id},
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    $("#baoming .lpBtn").html("提交领票").removeClass("false");
                    if (result.errcode == 1002) {
                        $("#baoming .lpBtn").removeClass("false2");
                        $("#baoming").hide();
                        $("#succeed").show();
                        send(tel, 0);
                    } else if (!result.errcode) {
                        $("#baoming .bmBtn").removeClass("false3");
                        djs(60);
                        $("#baoming .bmHead .lph").hide();
                        $("#baoming .lpForm").hide();
                        $("#baoming .bmHead .lpf").show();
                        $("#baoming .bmForm").show();
                        send(tel, result.verify);
                    } else {
                        $("#baoming .lpBtn").removeClass("false2");
                        comTips(result.errmsg);
                    }
                }
            });
        }
    });

    function checkPage2() {
        var code = $("#baoming .code").val();
        var address = $("#baoming .address").val();
        var area = $("#baoming .area").val();
        if (code == "" || address == "" || area == "---请选择---") {
            $("#baoming .bmBtn").addClass("false");
            return false;
        } else {
            $("#baoming .bmBtn").removeClass("false");
        }
    }

    $("#baoming .bmForm input").keyup(function() {
        checkPage2();
    });
    $("#baoming .bmForm select").change(function() {
        checkPage2();
    });

    //页面布点
    $('.click_btn').click(function() {
        var btn_id = $(this).attr('data-id');
        $("#btn_id").attr('value', btn_id);
        $.ajax({
            async: true,
            url: '/phone/aupu/click',
            data: {btn_id: btn_id},
            type: 'post',
            dataType: 'json',
            success: function(result) {}
        });
    });

    //60s后获取验证码
    $("#baoming .getCode").click(function() {

        var hmID = "ap_getCode";
        _hmt.push(['_trackEvent', '奥普', 'ap_重新获取验证码', hmID]);

        if ($(this).hasClass("false") || $(this).hasClass("false2")) {
            return false;
        } else {
            $("#baoming .getCode").addClass("false2");
            var name = $("#baoming .name").val();
            var tel = $("#baoming .tel").val();
            //发短信
            $.ajax({
                async: true,
                url: '/phone/aupu/getVerify',
                data: {name: name,phone: tel},
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    if (result.errcode) {
                        $("#baoming .getCode").removeClass("false2");
                        comTips(result.errmsg);
                    } else {
                        $("#baoming .bmBtn").removeClass("false3");
                        djs(60);
                        send(tel, result.verify);
                    }
                }
            });
        }
    });

    $("#baoming .bmBtn").click(function() {

        var hmID = "ap_bmBtn";
        _hmt.push(['_trackEvent', '奥普', 'ap_提交地址信息', hmID]);

        if ($(this).hasClass("false") || $(this).hasClass("false3")) {
            return false;
        } else {
            //报名
            $("#baoming .bmBtn").html("正在报名...").addClass("false");
            var tel = $("#baoming .tel").val();
            var code = $("#baoming .code").val(); //验证码
            var address = $("#baoming .address").val(); //详细地址
            var area = $("#baoming .area").val(); //区
            $.ajax({
                async: true,
                url: '/phone/aupu/submit',
                data: {code: code,phone: tel,address: address,area: area},
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    $("#baoming .bmBtn").html("立即报名").removeClass("false");
                    if (!result.errcode) {
                        $("#baoming").hide();
                        $("#succeed").show();
                        send(tel, 0);
                    } else if (result.errcode == 1004) {
                        //验证码错误
                        $("#baoming .code").val("").attr("placeholder", "验证码错误").addClass("redPlaceholder");
                        $("#baoming .bmBtn").addClass("false");
                    } else {
                        //其他错误
                        comTips(result.errmsg);
                    }
                }
            });
        }
    });

    $("#baoming .code").focus(function() {
        $("#baoming .code").val("");
    })
    $("#comTips .tipsClose").click(function() {
        $("#comTips .tipsBody").html("");
        $("#comTips").hide();
    })

    // 个城市 区选项
    $.ajax({
        async:false,
        type:'get',
        url : payDomain + '/phone/Ext/region/'+code,
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
    var hmID = "ap_PV_" + 1;
    _hmt.push(['_trackEvent', '奥普', 'ap_滑屏PV', hmID]);
};
//初始化
yt.init = function() {

    window.onload = function() {

        $("#loading").hide();
        setTimeout(yt.app);

        var w = $(window).width();
        var h = $(window).height();
        // console.log(w + " , " + h + " , " + h / w)
        if (h / w < 1.47) {
            $("#swiper-container1").addClass("fat");
        }
    };
};
yt.init();