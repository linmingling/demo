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
		if(mySwiper.activeIndex==9){
			$("#ewm").show();
		}else{
			$("#ewm").hide();
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
	
};
//初始化
yt.init = function () {

    window.onload = function () {
    
        $("#loading").hide();
        setTimeout(yt.app);
		//设置可抽奖次数
		$("#count").val(2);
        $("#zdxz").val(1);

    };

 
};
yt.init();



/***************************************/

function jpqh(type){
    if(type=='left'){
        if($('.jp img').attr('zdy')=='jp1')
        {
            $('.jp img').attr('src','images/jp2.png?vid=1.0');
            $('.jp img').attr('zdy','jp2');
        }
        else{
            $('.jp img').attr('src','images/jp1.png');
            $('.jp img').attr('zdy','jp1');
        }
    }
    else{
        if($('.jp img').attr('zdy')=='jp1')
        {
            $('.jp img').attr('src','images/jp2.png?vid=1.0');
            $('.jp img').attr('zdy','jp2');
        }
        else{
            $('.jp img').attr('src','images/jp1.png');
            $('.jp img').attr('zdy','jp1');
        }
    }
}
function qie(obj){
    if($(obj).text()=='活动规则'){
        //活动规则:
        $("#jpgz").css('display','inline');
        $("#jpzs").css('display','none');
        $('#my2').css('background-color','#e1e1e1');
        $('#my1').css('background-color','#ffffff');
    }
    else{
        //奖品展示
        $("#jpgz").css('display','none');
        $("#jpzs").css('display','inline');
        $('#my1').css('background-color','#e1e1e1');
        $('#my2').css('background-color','#ffffff');
    }
}
// 次数用完
function cs(){
    var _tan=$(".tan");
    var _bg = $(".bg");

    _bg.fadeIn();
    _tan.fadeIn();

    _bg.click(function(){
        _bg.fadeOut();
        _tan.fadeOut();
    });
}

$('#fximg').click(function(){
    var _fxbg=$('.fxbg');
    var _tan=$(".tan");
    var _bg = $(".bg");

    _fxbg.fadeIn();
    _bg.fadeOut();
    _tan.fadeOut();
})


//分享成功
function fxsuccess(){
    var _fxbg=$(".fxbg");
    _fxbg.fadeIn();
}

$("#zp").click(function(){
    var type=0;
    var count=$("#count").val();
    if($("#zdxz").val()==0){
        // alert($("#zdxz").val());
        return false;
    }
	var endTag = true;
    //活动结束
    //tanprd('<p>活动结束后</p><p>会有专人通知您的了！</p>');
    
//    if(count<1){
//        cs('');
//        return;
//    }
	$.ajax({
		async:false,
		url:'server.php',
		data:{act:'start'},
		type:'post',
		dataType:'json',
		success:function(result){
			if(result.errcode!=0)
			{
				if(result.errcode == 1003)
				{
					cs();
				}
				else
				{
					common('<p>系统提示</p>','<p>'+result.errmsg+'</p>');
				}
				endTag = false;
			}
			else
			{
				type=result.prize;
			}
		}
	});
	if(!endTag)
	{
		return false;
	}

    switch (type) {
            case 1: 
                rotateFunc(1,0,'箭牌智能坐便器AKB1130');
                count--;
                break;
            case 2: 
                rotateFunc(0,60,'谢谢参与');
                count--;
                break;
            case 3: 
                rotateFunc(2,120,'箭牌卫浴智能马桶盖AK1002');
                count--;
                break;
            case 4: 
                rotateFunc(0,180,'');
                count--;
                break;
            case 5: 
                rotateFunc(3,240,'箭牌卫浴品牌优质毛巾');
                count--;
                break;
            default:
                rotateFunc(0,300,'');
                count--;
        }
        $("#count").val(count);
        $("#zdxz").val(0);

});

var rotateFunc = function(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
    var _zdpic=$('#zd');
    _zdpic.stopRotate();
    _zdpic.rotate({
        angle: 0,
        duration: 4000,
        animateTo: angle + 1800,  //angle是图片上各奖项对应的角度，1440是让指针固定旋转4圈
        callback: function(){
            tanprd(awards);
        }
    });
};

setInterval(function(){ 
   $("#zdxz").val(1);
},8000);

function tanprd(type){
    var _title=$("#tanprd2 .product-tilte");
    var _con=$("#tanprd2 .product-con");
    var _btn=$("#tanprd2 .product-btn");
    //var _countcon=$("#tanprd2 .product-count");
    //var count=1;//剩余抽奖次数

    var _product=$('#tanprd2');
    var _bg = $(".bg");

    

    switch(type){
        case 1:
            _product.fadeIn();
            _bg.fadeIn();
            _title.html('<p>恭喜您！</p>');
            _con.html('<p>获得了特等奖</p><p>箭牌智能坐便器</p><p>AKB1130!</p>');
            _btn.html('<img src="images/btn3.png" width="50%" onclick="message(\'1\')">');
            //_countcon.html('<p>您还剩有<font>'+count+'</font>次抽奖机会！</p>');
            break;
        case 2:
            _product.fadeIn();
            _bg.fadeIn();
            _title.html('<p>恭喜您！</p>');
            _con.html('<p>获得了优秀奖</p><p>箭牌卫浴智能马桶盖</p><p>AK1002!</p>');
            _btn.html('<img src="images/btn3.png" width="50%" onclick="message(\'2\')">');
            //_countcon.html('<p>您还剩有<font>'+count+'</font>次抽奖机会！</p>');
            break;
        case 3:
            _product.fadeIn();
            _bg.fadeIn();
            _title.html('<p>恭喜您！</p>');
            _con.html('<p>获得了参与奖</p><p>箭牌卫浴品牌优质毛巾</p>');
            _btn.html('<img src="images/btn3.png" width="50%" onclick="message(\'3\')">');
            //_countcon.html('<p>您还剩有<font>'+count+'</font>次抽奖机会！</p>');
            break;
        case 0:
            cs();
            // _title.html('<p>很遗憾。</p>');
            // _con.html('<p>感谢您的参与，下次中</p><p>奖机会一定属于您！</p>');
            // _btn.html('<a href="index.php"><img src="images/btn4.png" width="50%"></a>');
            // _bg.click(function(){
            //     _bg.fadeOut();
            //     _product.fadeOut();
            // });
            break;
        default:
            
    }
    
}
//公共弹窗
function common(title,text){
    var _title=$("#tanprd .product-tilte");
    var _con=$("#tanprd .product-con");
    var _btn=$("#tanprd .product-btn");

    var _product=$('#tanprd');
    var _bg = $(".bg");

    _product.fadeIn();
    _bg.fadeIn();

    _title.html(title);
    _con.html(text);

    _btn.html('<a id="combtn"><img src="images/btn2.png" width="50%"></a>');


    // _bg.click(function(){
    //     _bg.fadeOut();
    //     _product.fadeOut();
    // });
    $("#combtn").click(function(){
        _bg.fadeOut();
        _product.fadeOut();
    });
}

//填写个人资料
function message(type){
    var _type=type;//奖项
    var _msg=$('#messageid');
    var _bg = $(".bg");

    var _product=$('#tanprd2');
    _product.fadeOut();

    _msg.fadeIn();
    _bg.fadeIn();
}
function zh(obj){

    var _msg=$('#messageid');
    // var _product=$('#tanprd');
    // var _bg = $(".bg");
	var errTag=true;
	var name = $("#name").val();
	var phone = $("#phone").val();
	var address = $("#address").val();
	console.log(name);

	$.ajax({
		async:false,
		url:'server.php',
		data:{act:'addinfo',name:name,phone:phone,address:address},
		type:'post',
		dataType:'json',
		success:function(result){
			if(result.errcode!=0)
			{
				alert(result.errmsg);
				errTag = false;
			}
			else
			{
				return false;
			}
		}
	});
	if(!errTag)
	{
		return false;
	}

    _msg.fadeOut();
    //_product.fadeIn();

    common('<p>谢谢您参与！</p>','<p>活动结束后</p><p>会有专人通知您的了！</p>')
   

    // $("#end").click(function(){

    //     _bg.fadeOut();
    //     _product.fadeOut();
    // });
}

function producttag(type){
    var _bg = $(".bg");
    var _tag=$("#tag");
    _bg.fadeIn();
    _tag.fadeIn();

    var _tagpic=$("#tag .prd-tag-pic");
    var _tagtitle=$("#tag .prd-tag-title");
    var _tagcon=$("#tag .prd-tag-con");
    var _tagtype=$("#tag .prd-tag-type");
    var _close=$("#tag .prd-tag-close");

    switch(type){
        case '1':
            _tagpic.find('img').attr('src','images/product1-1.png');
            _tagtitle.html('<p>3D奈丽实木浴室柜</p>');
            _tagcon.html('<p>箭牌卫浴将3D奈丽一体成形技术应用与浴室柜，突破传统的制造技术，是产品造型更加优美、性能更加稳定同时简约流畅的线条又极高提升了浴室柜的空间装饰价值，典雅高尚。</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 3D奈丽板</p>\
                <p><span class="prd-tag-bg">型号</span> APGM10L4136-B</p>\
                <p><span class="prd-tag-bg">规格</span> 盆尺寸：702*409*198mm</p>\
                <p class="prd-tag-sj">主柜尺寸：1010*545*820mm</p> <p class="prd-tag-sj">镜柜尺寸：950*160*650mm</p>');
            // $('.prd-tag-up').css('display','none');
            // $('.prd-tag-down').css('display','none');
            break;
        case '2':
            _tagpic.find('img').attr('src','images/product1-2.png');
            _tagtitle.html('<p>气泡按摩浴缸</p>');
            _tagcon.html('<p>经过整整一天紧张的工作后，每个人都应该在一个舒适浴室中让自己回到从容，得到抚慰。韵.格雅系列包括了高质量的多功能浴室家具和令人难以割舍的无缝对接浴缸等多种产品，完全可以满足你的全方位需要。</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 压克力</p>\
                <p><span class="prd-tag-bg">型号</span> AQ1601UQ</p>\
                <p><span class="prd-tag-bg">规格</span> L1600*W800*H680mm</p>');
            // $('.prd-tag-up').css('display','none');
            // $('.prd-tag-down').css('display','none');
            break;
        case '3':
            _tagpic.find('img').attr('src','images/product1-3.png');
            _tagtitle.html('<p>喷射虹吸式连体坐便器</p>');
            _tagcon.html('<p>韵.格雅系列将纯粹的几何美学发挥得淋漓尽致，所有角落均变得柔滑，反映它蕴藏的美学思想。陶瓷产品超薄盖板、环保节水尖端技术的应用，使其功能品质也得到了最佳呈现。</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 陶瓷</p>\
                <p><span class="prd-tag-bg">型号</span> AB1170</p>\
                <p><span class="prd-tag-bg">规格</span> L686*W370*H730mm</p>\
                <p class="prd-tag-sj">坑距280/390mm</p>');
            // $('.prd-tag-up').css('display','none');
            // $('.prd-tag-down').css('display','none');
            break;
        case '4':
            _tagpic.find('img').attr('src','images/product2-1.png');
            _tagtitle.html('<p>3D奈丽实木浴室柜（诺曼系列）</p>');
            _tagcon.html('<p><div class="prd-tag-yuan">1</div>产品时尚而又极具个性，可与任何现代家居装修风格搭配；诺曼系列采用突破传统的一体柜脚设计，产品整体设计一气呵成，直指追求时尚个性的内心，时尚的配色与经典立体花纹相得益彰，点缀经典款镶钻拉手，诺曼系列就是要带给大家华丽、个性、永恒的时尚；</p>\
                    <p><div class="prd-tag-yuan">2</div>产品采用箭牌全新的3D奈丽一体成形技术,呈现完美而又充满个性的外观；</p>\
                    <p><div class="prd-tag-yuan">3</div>进口全橡胶实木为基材，环保油漆工艺技术；</p>\
                    <p><div class="prd-tag-yuan">4</div>精致的立体花纹面，纯手工打磨，保证产品的经典外观，价值非凡；</p>\
                    <p><div class="prd-tag-yuan">5</div>配套柜盆、镜柜，置物功能丰富；</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 3D奈丽板</p>\
                    <p><span class="prd-tag-bg">型号</span> APGM8L3218-B</p>\
                    <p><span class="prd-tag-bg">规格</span> 柜盆：805x502x188mm</p>\
                    <p class="prd-tag-sj">主柜：780*490*780mm</p>\
                    <p class="prd-tag-sj">镜柜：790*180*680mm</p>');
            // $('.prd-tag-up').css('display','inline');
            // $('.prd-tag-down').css('display','inline');
            break;
        case '5':
            _tagpic.find('img').attr('src','images/product2-2.png');
            _tagtitle.html('<p>气泡按摩浴缸</p>');
            _tagcon.html('<p><p><div class="prd-tag-yuan">1</div>一体化全裙边设计；</p>\
                    <p><div class="prd-tag-yuan">2</div>简约溢水孔设计；</p>\
                    <p><div class="prd-tag-yuan">3</div>直线，亦可与墙面无缝贴近，无需要定制左右裙；</p>\
                    <p><div class="prd-tag-yuan">4</div>弧度充当靠垫，躺着舒适，人性化设计</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 压克力</p>\
                    <p><span class="prd-tag-bg">型号</span>  AQ16807TQ</p>\
                    <p><span class="prd-tag-bg">规格</span> L1600xW800xH700mm</p>');
            // $('.prd-tag-up').css('display','none');
            // $('.prd-tag-down').css('display','none');
            break;
        case '6':
            _tagpic.find('img').attr('src','images/product2-3.png');
            _tagtitle.html('<p>智能座便器</p>');
            _tagcon.html('<p>舒乐一体超感坐便器，以时尚为创意远点，宛若一朵绽放于艺术上的鲜花。它简约圆滑的设计，勾勒出优雅曼妙的外形，配先进金的洁体科技，以一体化的人性方式呈现出人性科技与尖端设计的完美融合。</p>\
                    <p><div class="prd-tag-yuan">1</div>无水箱设计，超薄盖板，产品小尺寸设计、更加整体时尚；</p>\
                    <p><div class="prd-tag-yuan">2</div>即热式加热，使用更方便；</p>\
                    <p><div class="prd-tag-yuan">3</div>不锈钢喷枪，三档可调；</p>\
                    <p><div class="prd-tag-yuan">4</div>内部模块化设计，不同的款式内部结构、模块全部通用，方便维护；</p>\
                    <p><div class="prd-tag-yuan">5</div>低水压下冲洗也非常干净，并具备防虹吸功能；</p>\
                    <p><div class="prd-tag-yuan">6</div>妇洗、洗便、座圈加热、烘干、除臭、节能、遥控器功能；</p>');
            _tagtype.html('<p><span class="prd-tag-bg">材质</span> 陶瓷</p>\
                    <p><span class="prd-tag-bg">型号</span> AKB1130</p>\
                    <p><span class="prd-tag-bg">规格</span> 尺寸：L600xW404xH533mm</p>\
                    <p class="prd-tag-sj">坑距：290/390mm</p>');
                    // $('.prd-tag-up').css('display','inline');
                    // $('.prd-tag-down').css('display','inline');
            break;

        
        
        default:
            
    }


    _close.click(function(){

        _bg.fadeOut();
        _tag.fadeOut();
    });
}



