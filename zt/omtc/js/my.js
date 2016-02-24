////亚太传媒
//var yt = yt || {};
//
////头部模块
//yt.header = function () {
//
//
//  //下拉菜单
//  var bindHyChannel = function () {
//      var $hy = $("#hychannel"),
//          $p = $hy.find('p'),
//          $ul = $hy.find('ul');
//
//      $hy.hover(function () {
//          $p.toggleClass('up');
//          $ul.toggleClass('tg');
//      });
//  };
//  //浮动top
//  var bindTopNav = function () {
//
//      var $topNav = $("#topNav"),
//          $doc = $(document),
//          htop = 0,
//          height = 36,
//          isDown = false;
//      $(window).scroll(function () {
//          var _htop = $doc.scrollTop(),
//          _isDown = !!(_htop - htop > 0),
//          _top = _isDown ? -height : 0;
//          htop = _htop;
//          if (_isDown == isDown) {
//              return;
//          }
//          isDown = _isDown;
//          $topNav.stop().animate({ top: _top }, 500);
//      });
//  };
//
//
//  //init
//  bindHyChannel();
//  bindTopNav();
//
//};
//
////内容模块
//yt.content = function () {
//
//  var lzImg = function ($imgs) {
//      $imgs.lazyload({
//          effect: "fadeIn",
//          effect_speed: 100
//      })
//  };
//
//  var bindImg = function () {
//
//      lzImg($("img.lz"));
//  };
// 
//
//  //init
//
//  //bindImg();
// 
//
//};
//
//yt.init = function () {
//  yt.header();
//  yt.content();
//};
//
//yt.init();