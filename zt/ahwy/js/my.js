/** * name   :   自适应屏大小效果 */
 
 // (function () {
 //            var phoneWidth = parseInt(window.screen.width);
 //            var phoneScale = phoneWidth / 640;
 //            var ua = navigator.userAgent;
 //            if (/Android (\d+\.\d+)/.test(ua)) {
 //                var version = parseFloat(RegExp.$1);
 //                if (version > 2.3) {
 //                    document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
 //                } else {
 //                    document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
 //                }
 //            } else {
 //                document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
 //            }
 //        })();


/** * name   :   弹出窗效果 */
(function ($) { 
    $.popWin = function(param){
        var _bg = $("#bg"),
            _popWin = $("#popContent"),
            _image=_popWin.find(".pop1"),
            _popWin_title = _popWin.find(".pop2"),
            _popWin_con = _popWin.find(".pop3"),
            _closeBtn = _popWin.find(".popclose");

        var _popWinB = $("#popContentB"),
            _imageB=_popWinB.find(".pop1B"),
            _popWin_titleB = _popWinB.find(".pop2B"),
            _popWin_conB = _popWinB.find(".pop3"),
            _closeBtnB = _popWinB.find(".popcloseB");
        
        switch (param) 
        {
            case '侧按键':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd1-1.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>侧按键</p>');
                _popWin_con.html('<p>精美的侧按键设计，主要操作功能有：冲水、烘干、妇洗、便洗、停止</p>');
                break;
            case '镀铬装饰条':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd1-3.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>镀铬装饰条</p>');
                _popWin_con.html('<p>金属色泽的加入，与灯光的点缀，更加凸显出产品的奢华与时尚</p>');
                break;
            case '操作提示灯':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd1-2.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>操作提示灯</p>');
                _popWin_con.html('<p>提示电源、落座、自动冲水</p>');
                break;
            // ----------------------------产品2-----------------------------    
            case '遥控器':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd2-1.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>遥控器</p>');
                _popWin_con.html('<p>单手操作，控制随心所欲。</p>');
                break;
            case '按键':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd2-2.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>按键</p>');
                _popWin_con.html('<p>设计于座圈上，使用方便触手可及。</p>');
                break;
            case '阻尼缓冲':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd2-3.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>阻尼缓冲</p>');
                _popWin_con.html('<p>座圈和盖板带有防止急速下落的阻尼缓冲装置</p>');
                break;
            case '不锈钢喷头自洁':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd2-4.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>不锈钢喷头自洁</p>');
                _popWin_con.html('<p>落座后自动喷水3S湿润喷头以减少脏污的粘附</p>');
                break;
            case '手动放水':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd2-5.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>手动放水</p>');
                _popWin_con.html('<p>独有的男生专用按钮，设置在座圈底部，让男士使用更方便，更贴心</p>');
                break;
            // ----------------------------产品3----------------------------- 
            case '超厚加料五金件':
                _bg.fadeIn();
                _popWinB.fadeIn();
                _imageB.html('<img src="images/prd3-1.jpg" width="100%" height="100%">');
                _popWin_titleB.html('<p>超厚加料五金件</p>');
                //_popWin_con.html('<p>独有的男生专用按钮，设置在座圈底部，让男士使用更方便，更贴心</p>');
                break;
            case '一体铸造双色拉手':
                _bg.fadeIn();
                _popWinB.fadeIn();
                _imageB.html('<img src="images/prd3-2.jpg" width="100%" height="100%">');
                _popWin_titleB.html('<p>一体铸造双色拉手</p>');
                //_popWin_con.html('<p>独有的男生专用按钮，设置在座圈底部，让男士使用更方便，更贴心</p>');
                break;
            case '三扇8mm钢化玻璃':
                _bg.fadeIn();
                _popWinB.fadeIn();
                _imageB.html('<img src="images/prd3-3.jpg" width="100%" height="100%">');
                _popWin_titleB.html('<p>三扇8mm钢化玻璃</p>');
                //_popWin_con.html('<p>独有的男生专用按钮，设置在座圈底部，让男士使用更方便，更贴心</p>');
                break;
            // ----------------------------产品4----------------------------- 
            case '不规则浴镜':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd4-1.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>不规则浴镜</p>');
                _popWin_con.html('<p style="font-size:3.5vw">相对于非方既圆的浴镜设计更加具有年轻的活力，带给您的个性前卫又时尚魅力的卫浴体验。</p><p style="font-size:3.5vw">具有观赏性的同时也具备置物使用功能</p>');
                break;
            case '骑马抽':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd4-2.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>骑马抽</p>');
                _popWin_con.html('<p style="font-size:3.5vw">又称豪华阻尼抽，奠定高端品位风尚的同时，也让消费者享受到无噪音浴室生活.全拉出设计使柜内物品一目了然且方便去放，超静音缓冲结构</p>');
                break;  

            // ----------------------------产品5----------------------------- 
            case '多功能抽屉':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd5-1.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>多功能抽屉</p>');
                _popWin_con.html('<p style="font-size:4.1vw">根据不同的物品，设有不同的置物空间，保障收纳的同时又可以清晰分类，充分享受生活的点点滴滴。</p>');
                break;
            case '半开放式镜柜':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd5-2.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>半开放式镜柜</p>');
                _popWin_con.html('<p>一体成型，常用物品可置于外部，洗漱用品触手可及。</p>');
                break;
            case '加高柜脚':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd5-3.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>加高柜脚</p>');
                _popWin_con.html('<p>柜脚加高设计，清洁工具随意出入，您再也不用担心柜底的卫生情况了。</p>');
                break;
            case '弧形边角':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd5-4.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>弧形边角</p>');
                _popWin_con.html('<p>一体成型，常用物品可置于外部，洗漱用品触手可及。</p>');
                break;
            case '贴心设计':
                _bg.fadeIn();
                _popWin.fadeIn();
                _image.html('<img src="images/prd5-5.jpg" width="100%" height="100%">');
                _popWin_title.html('<p>贴心设计</p>');
                _popWin_con.html('<p>圆弧台面造型与陶瓷盆相呼应，内衬金色搭配，贴心提醒，时尚、巧妙。</p>');
                break;
          

            default:
                alert('未知错误');
                

        }
        _closeBtn
            .bind("click",function(){
                _bg.fadeOut();
                _popWin.fadeOut();
            });

        _closeBtnB
            .bind("click",function(){
                _bg.fadeOut();
                _popWinB.fadeOut();
            });
    }
})(jQuery);


/** * name   :   弹出窗效果2 */
(function ($) { 
    $.popWin2 = function(param){
        var prd1='<div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>采用最新智能技术，即热式水箱，自动冲洗，温水洗净、暖风干燥等强大功能。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>一体型设计，不占用更多的空间，时尚、简约。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>防污效果好，污迹难于黏附，打扫更方便。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>冲洗完臀部喷嘴自动收缩消毒仓，更加卫生。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>全程遥控，柔光照明，如厕随心所欲，倍感舒适。</p></div></div>';
        
        var prd2='<div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>采用新技术，无水箱设计，造型圆润，线条优雅流畅。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>控制水压在1.2kg内，具有恒流控制功能，自动传感调节水压。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>具有恒温效果，使用倍感舒适，运用直热式水箱，水电隔离，自由控制水温。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>功能主要有：自动冲水，静音防撞，空气净化，碰头自洁，男士开关，女性专用，只能遥控。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>防污效果好，污迹难于黏附，打扫更方便。</p></div></div>';

        var prd3='<div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>这款方型淋浴房外观沉稳，黄金分割设计。尺寸比例和谐默契，1/3部分镀铬突显光亮，2/3部分烤玫瑰金漆别具个性。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>尺寸比例和谐默契，两种颜色搭配，更平添幻彩时尚，珠联璧合。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>五金门铰材质内、外表里如一。</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>产品既奢华又个性的设计，合页设计玻璃两端，整体配置别具特色！</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>外开门方式！大理石挡水边 ，五扇8mm玻璃！</p></div></div>';

        var prd4='<div class="conbg"><p>配套产品：主柜+镜柜+aP33017陶瓷盆+单把单孔面盆龙头</p></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>玫瑰金色和白色搭配，大气典雅</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>门板造型和拉手造型，彰显艺术感</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>整体精心处理无棱角，避免生硬直角造成的伤害，使用更安心</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>采用“3D丽木”成型技术，防水、防开裂，圆润光滑，使用更放心</p></div></div>\
                  <div ><div class="popJianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="popJianjie2-right"><p>高端品味设计，让您感受贵族般的尊贵气息。</p></div></div>';

        var prd5='<div ><div class="pop2Jianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="pop2Jianjie2-right"><p>精致风抒发着对生活的感触，简约风消去繁杂的同时也将情感氛围渲染的更加极致。多彩的金属让光泽散发得更加迷人，温柔知性的外形也带来了时尚优雅的视觉感受，从色彩中迸发出的奢华感让人更加难以拒绝。</p></div></div>\
                  <div ><div class="pop2Jianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="pop2Jianjie2-right"><p>专注于细节的美化和装饰   细节和造型上精美柔和的浴柜设计很好的满足部分人对于情感表达的诉求，整体大气又雅致的空间中营造出高贵明艳的卫浴氛围。</p></div></div>\
                  <div ><div class="pop2Jianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="pop2Jianjie2-right"><p>储物功能最大化   两门两抽搭配半开放镜柜的设计，将空间充分利用，再也不用担心东西会被放的杂乱不堪了。</p></div></div>\
                  <div ><div class="pop2Jianjie2-left"><img src="images/tubiao4.png" width="100%" height="100%"></div><div class="pop2Jianjie2-right"><p>安全易清洁   圆润的边角以及一体式镜柜设计，安全无接缝，便于清洁。</p></div></div>';


        var _bg = $("#bg"),
            _popWin = $("#popJianjie"),
            _popWin2 = $("#pop2Jianjie"),
            _popWin_title = _popWin.find(".popJianjie1"),
            _popWin_title2 = _popWin2.find(".pop2Jianjie1"),
            _popWin_con = _popWin.find(".popJianjie2"),
            _popWin_con2 = _popWin2.find(".pop2Jianjie2"),
            _closeBtn = _popWin.find(".popJianjie3");
            _closeBtn2 = _popWin2.find(".pop2Jianjie3");
        
        

        switch (param) 
        {
            case '1':
                _bg.fadeIn();
                _popWin.fadeIn();
                _popWin_title.html('<p style="padding-left: 10%;">aB13008产品简介: </p>');
                _popWin_con.html(prd1);
                break;
            case '2':
                _bg.fadeIn();
                _popWin.fadeIn();
                _popWin_title.html('<p style="padding-left: 10%;">aB13020产品简介: </p>');
                _popWin_con.html(prd2);
                break;
            case '3':
                _bg.fadeIn();
                _popWin.fadeIn();
                _popWin_title.html('<p style="padding-left: 10%;">anL054产品简介: </p>');
                _popWin_con.html(prd3);
                break;
            case '4':
                _bg.fadeIn();
                _popWin2.fadeIn();
                _popWin_title2.html('<p>anPGM33017G产品简介: </p>');
                _popWin_con2.html(prd4);
                break;
            case '5':
                _bg.fadeIn();
                _popWin2.fadeIn();
                _popWin_title2.html('<p>anPGM43012产品简介: </p>');
                _popWin_con2.html(prd5);
                break;
            default:
                

        }
        _closeBtn
            .bind("click",function(){
                _bg.fadeOut();
                _popWin.fadeOut();
            });
        _closeBtn2
            .bind("click",function(){
                _bg.fadeOut();
                _popWin2.fadeOut();
            });    
    }
})(jQuery);