188//亚太传媒
var yt = {};

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

yt.bindTab = function (cf) {

    var _cf = {
        $menu: null,
        $cn: null,
        fade: true,
        fadeTime:500,
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
        index:0
    };

    $lis.on(cf.event, function () {
        
        var $that = $(this);
            
        yt.bindTabTimer && clearTimeout(yt.bindTabTimer);
        yt.bindTabTimer = setTimeout(function () {

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

        }, 5);

       
    });
    return tab;

};



//头部模块
yt.header = function () {


    //下拉菜单
    var bindHyChannel = function () {
        var $hy = $("#hychannel"),
            $p = $hy.find('p'),
            $ul = $hy.find('ul');

        $hy.hover(function () {
            $p.toggleClass('up');
            $ul.toggleClass('tg');
        });
    };

    //浮动top
    var bindTopNav = function () {

        var $topNav = $("#topNav"),
            $doc = $(document),
            htop = 0,
            height = 36,
            isDown = false;
        $(window).scroll(function () {
            var _htop = $doc.scrollTop(),
            _isDown = !!(_htop - htop > 0),
            _top = _isDown ? -height : 0;
            htop = _htop;
            if (_isDown == isDown) {
                return;
            }
            isDown = _isDown;
            $topNav.stop().animate({ top: _top }, 500);
        });
    };


    //init
    bindHyChannel();
    bindTopNav();

};

//内容模块
yt.content = function () {

    var $win = $(window),
        $doc = $(document);
    var lzImg = function ($imgs) {
        $imgs.lazyload({
            effect: "fadeIn",
            effect_speed: 100
        })
    };
   
    //动画模块
    var bindAms = function () {
        var $cn1 = $("#cn1"),
            $cn2 = $("#cn2");

        var tl = function () {
            return new TimelineLite();
        };
        //导航动画
        var amNav = function () {
            var t1 = tl(),
                $as = $("#runNav a");
            $as.css('visibility', 'visible');
               return t1.staggerFrom($as, 1, { right: -500, scale: 0, ease: Back.easeOut, delay: 2.5 },0.1);
        };
        //动画1
        var am1 = function () {
            var $c1m1 = $("#c1m1 img"),
                $c1m2 = $("#c1m2 img"),
                $c1m3 = $("#c1m3 img"),
                $c1m4 = $("#c1m4 img"),
                $c1m5 = $("#c1m5 img"),
                $c1m6 = $("#c1m6 img"),
                $wxs = $("#wxs .wx"),
                $nav = $("#cnNav");

            var t1 = tl(),
                t2 = tl(),
                t3 = tl(),
                t4 = tl(),
                t5 = tl(),
                t6 = tl(),
                t7 = tl(),
                t8=tl();

            var navAm = function () {
                $nav.css('top', -200).show();
                setTimeout(function () {
                    $nav.stop().animate({ 'top': 20 }, 1000, 'easeOutQuart');
                },2000);
            };
            $("#cn1 img").show();
            $wxs.show();
            $nav.show();

            t7.from($nav, 1, { autoAlpha: 0, left: -1000,  delay: 1.2  });
            t1.from($c1m1, 1, { autoAlpha: 0, left: -150,  delay: 0.2 });
            t2.from($c1m2, 1, { autoAlpha: 0, right: -150,  delay: 0.4 });
            t3.from($c1m3, 1, { autoAlpha: 0, bottom: -100,  delay: 0.6 });
            t4.from($c1m4, 1, { autoAlpha: 0, left: -50,  delay: 1.5 });
            t5.from($c1m5, 1, { autoAlpha: 0, left: -1000, scale: 0, ease: Back.easeOut, delay: 1.5 });
            t6.from($c1m6, 1, { autoAlpha: 0, right: -1000, scale: 0, delay: 1.8, rotation: "-" + (360 * 5) + "deg" });
            t8.staggerFrom($wxs, 1, { autoAlpha: 0, left: -300,  ease: Back.easeOut, delay: 2.8 }, 0.1);
            amNav();
            //navAm();
            
        };

        //动画2
        var am2 = function () {
            var $ch1 = $("#c2-1"),
                $ch2 = $("#c2-2"),
                $ch3 = $("#c2-3"),
                $imgs = $(".heart img", $cn2),
                $txts = $(".txt", $cn2),
                $bts = $(".b-top", $cn2),
                $bls = $(".b-left", $cn2);

            var bts1A = [$bts.eq(0), $bts.eq(2), $bts.eq(4)],
                bts2A = [$bts.eq(1), $bts.eq(3)],
                bls1A = [$bls.eq(0), $bls.eq(2), $bls.eq(4)],
                bls2A = [$bls.eq(1), $bls.eq(3)];
            var t1 = tl(),
                t2 = tl(),
                t3 = tl(),
                t4 = tl(),
                t5 = tl(),
                t6 = tl(),
                t7 = tl(),
                t8 = tl(),
                t9 = tl();

            $("#c2m0").show();
            $imgs.show();
            $txts.show();
            $bts.show();
            $bls.show();

            t7.from($ch1, 1, { autoAlpha: 0, left: -1000 });
            t9.from($ch3, 1, { autoAlpha: 0, right: -1000 });
            t8.from($ch2, 1, { autoAlpha: 0, top: -200, ease: Back.easeOut, delay: 1 });

            t1.staggerFrom( bts1A,1, { autoAlpha: 0, left: -1000},0.2);
            t2.staggerFrom(bts2A, 1, { autoAlpha: 0, right: -1000 }, 0.2);
            t3.staggerFrom(bls1A, 1, { autoAlpha: 0, top: 1000 }, 0.2);
            t4.staggerFrom(bls2A, 1, { autoAlpha: 0, top: 1000 }, 0.2);
            t5.staggerFrom($imgs, 1, { autoAlpha: 0, top: -1000, scale: 0, ease: Back.easeOut, delay: 1 }, 0.3);
            t6.staggerFrom($txts, 1, { autoAlpha: 0, top: 200,  ease: Back.easeOut, delay: 1 }, 0.3);
        };

        //滚动执行动画
        var bindScroll = function () {
            var hasRun2 = false;
            var cnTop2 = $cn2.offset().top - 100;
            $win.scroll(function () {

               
                if (!hasRun2 && cnTop2 < $doc.scrollTop()) {
                   
                    am2();
                    hasRun2 = true;
                }
            });

        };

        //init
        am1();
        bindScroll();
    };

    //图片懒加载
    var bindLzImg = function () {

        lzImg($("img.lz"));
    };

    //微信
    var bindWx = function () {
        var btop = 200;
        $win.bind("scroll", function () {

            var top_ = $doc.scrollTop();
            setTimeout(function () {
                $("#wxs").stop().animate({
                    top: btop + top_
                }, {
                    easing: 'easeOutExpo',
                    duration: 800
                });
            }, 50);

        });
    };

    //绑定滚动菜单
    var bindMenu = function () {
        var $as = $("#runNav a"),
            count = $as.length;
        var _bind = function ($that) {
           
            $that.addClass('active').siblings().removeClass('active');
            $('html, body').stop().animate({
                scrollTop: $("#" + $that.data('id')).offset().top
            }, {
                easing: 'easeOutExpo',
                duration: 1000,
                complete: function () {

                }
            });
        };
        $("#cnMenu a,#runNav a").click(function () {
           
            _bind($(this));

        });
      //  var timer = null,timers=0,nums=0;
//        $win.bind('mousewheel', function (event, delta, deltaX, deltaY) { //两个参数
//            //deltaY -1 向下
//            //deltaY  1 向上
//           
//            if (timers > 0 ) {
//                return false;
//            }
//           
//            var index = $as.index($("#runNav a.active"));
//            index = deltaY == -1 ? (index == count - 1 ? 0 : index + 1) : index - 1;
//            if (index == -1) { return false; }
//            $as.eq(index).trigger('click');
//            timers = 50;
//            timer = setInterval(function () {
//                timers -= 1;
//                if (timers < 1) {
//                    clearInterval(timer);
//                }
//            },2);
//           
//
//        });
    };
     
    //绑定模块3
    var bindCn3 = function () {

        var bindSlier1 = function () {
            var $lis = $("#slider1 .lt");
            var slider1 =  ytSlider({
                id: 'slider1',
                wait: -1,//滚动间隔时间
                slideAfter: function () {
                    var me = this,
                        $li = $lis.eq(me.index);
                    bindSlider2("slider2-" + (me.index + 1));
                },

            });


        };

        var bindSlider2 = function (id) {

            var $slider = $("#" + id);
            if ($slider.data('bind')) { return false; }

            yt.loadImg($('img', $slider));
          
            //滑动容器
            ytSlider({
                id: id,//每一组id
                activeCls: "active",//当前选择点class
                wait: 5000,//滚动间隔时间
                activeEvent: "mouseover",
                initBefore: function () {

                    var len = $slider.find("ul>li").length,
                        i=1,
                        html = "";
                    while (len--) {
                        html += "<li title=" + (i++) + "></li>";
                    }
                    html = "<ol>" + html + "</ol>";
                    $slider.append(html);
                }

            });
            $slider.attr('data-bind', 'true');
        };

        var bindTab = function () {
            var $sliders = $("#slider22x .slider2")
            yt.bindTab({
                $menu: $("#menu2"),
                $cn: $("#cts2"),
                fade: false,
                event: "click",
                activeCls: "active",
                eventAfter: function (index) {
                    $sliders.eq(index).show().siblings().hide();
                    if (index ==1) {
                        bindSlider2("slider2-2x");
                    }
                   
                }
            });
        };

        var bindProImgs = function () {

            var bindFancybox = function ($cnGallery) {

                $("a[rel=gallery]", $cnGallery).fancybox({
                    "overlayColor": '#000',
                    "overlayOpacity": 0.6,
                    'titlePosition': 'over',
                    'showNavArrows': true,
                    'transitionIn': 'elastic',
                    'transitionOut': 'elastic',
                    titleShow :false
                  
                });
            };
           
            $("#slider1 .ct-c").each(function () {
                bindFancybox($(this));
            });
        };



        //init
        bindSlier1();
        bindTab();
        bindProImgs();
    };

    //绑定模块4
    var bindCn4 = function () {

        var bindTab1 = function () {

         
            yt.bindTab({
                $menu: $("#nav1"),
                $cn: $("#cts4-1"),
                fade: true,
                fadeTime:200,
                event: "mouseover",
                activeCls: "active",
                eventAfter: function (index) {
                 
                    if (index == 1) {
                       
                    }

                }
            });
        };

        var bindTab2 = function () {

            var $cn = $("#cts4-2"),
                $cns = $cn.children();
            yt.bindTab({
                $menu: $("#nav2"),
                $cn: $cn,
                fade: true,
                fadeTime: 200,
                event: "click",
                activeCls: "active",
                eventAfter: function (index) {
                    yt.loadImg($cns.eq(index).find('.dimg'));
                },
              
            });
        };
       
        var bindTab3 = function () {

            var $menusx = $("#menus").children();
            yt.bindTab({
                $menu: $("#nav3"),
                $cn: $("#cts4"),
                fade: false,
                event: "click",
                activeCls: "active",
                eventAfter: function (index) {
                 
                    $menusx.eq(index).show().siblings().hide();
                    if (index == 1) {
                        yt.loadImg($("#bg1"));
                    }
            }
            });
        };


        //init
        bindTab1();
        bindTab2();
        bindTab3();
       
    };

  
    //init
    bindLzImg();
    bindMenu();
    bindCn3();
    bindCn4();
    bindWx();
    bindAms();

};

yt.init = function () {
    yt.header();
    yt.content();
};

window.onload = function () {
    yt.init();
};