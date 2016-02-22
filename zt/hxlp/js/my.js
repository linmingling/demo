//亚太传媒
var yt = yt || {};

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
    


    //init
    bindHyChannel();
    bindTopNav();

};

//内容模块
yt.content = function () {

    var lzImg = function ($imgs) {
        $imgs.lazyload({
            effect: "fadeIn",
            effect_speed: 100
        })
    };
  
    var bindImg = function () {

        lzImg($("img.lz"));
    };
 

    //init

    //bindImg();
 

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
        var timer = null,timers=0,nums=0;
        $win.bind('mousewheel', function (event, delta, deltaX, deltaY) { //两个参数
            //deltaY -1 向下
            //deltaY  1 向上
           
            if (timers > 0 ) {
                return false;
            }
           
            var index = $as.index($("#runNav a.active"));
            index = deltaY == -1 ? (index == count - 1 ? 0 : index + 1) : index - 1;
            if (index == -1) { return false; }
            $as.eq(index).trigger('click');
            timers = 50;
            timer = setInterval(function () {
                timers -= 1;
                if (timers < 1) {
                    clearInterval(timer);
                }
            },2);
           

        });
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