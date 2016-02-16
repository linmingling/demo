//亚太传媒 
var yt = yt || {};

//公用函数
//图片懒加载
yt.lzImg = function ($imgs) {
    if ($imgs === undefined) {
        $imgs = $("img.lz");
    }
    $imgs.lazyload({
        effect: "fadeIn",
        effect_speed: 100
    })
};

//图片延时加载
yt.delayImg = function ($imgs, time) {
    var _time = 0;
    time = time !== undefined ? +time : 20;

    $imgs.each(function () {
        var $that = $(this), src = $that.data('src');
        if (!($that.data('hasload') || !src)) {
            setTimeout(function () {
                $that.attr('src', src).data('hasload', 'true');
            }, _time);
            _time += time;
        }

    });
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


    var $lis = $("#slider1 li");
    var liData = {};
    var loadTpl = function (i) {
        if (!liData[i]) {
            var $tpl = $("#tpl" + (i + 1));
            $tpl.length && $lis.eq(i).html($tpl.html());
            liData[i] = 1;
        }
    };
    var slider1 = function () {



       var sl =  ytSlider({
            idBox: "slider1",
            easing: "easeOutQuart",
            speed:800,
            isShowNav: false,
            slideAuto: false
        
    
       });
     
       sl.addSlideFns(function (i) {
           loadTpl(i+1);
       });
    };

    //init 

    $lis.each(function (i) {
        liData[i] = !!($lis.eq(i).html() !== '');
    });

    slider1();
    window.onload = function () {
        loadTpl(1);
    };
    $("#kxb").kxbdMarquee({ direction: "left", scrollDelay: 40, isEqual: false });
 

};

yt.init = function () {
    yt.header();
    yt.content();
};

yt.init();