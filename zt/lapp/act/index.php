<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../data/config.php');
	require_once(ROOT_PATH . '../../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
	/* $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(!isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
    	echo "<script>alert('请在移动端中打开！')</script>";exit;
    } */
	if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
          
        }else{
			echo "<script>alert('请在移动端中打开！')</script>";exit;
		} 
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no, email=no"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="HandheldFriendly" content="true">
    <meta name="MobileOptimized" content="640">
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <meta name="full-screen" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="browsermode" content="application">
    <meta name="x5-page-mode" content="app">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="width=640,target-densitydpi=device-dpi,maximum-scale=1.0, user-scalable=no">
    <script type="text/javascript">
		/* if(!document.hasOwnProperty("ontouchstart")){
			alert('请在移动端打开！');
		} */
        function setWidth(a) {
            if (/Andriod/i.test(navigator.userAgent)) {
                var c, b = window.innerWidth;
                (b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function () {
                    var d = document.getElementsByTagName("body")[0];
                    d.style.webkitTransformOrigin = "left top";
                    d.style.webkitTransform = "scale(" + c + ")";
                }, !1)
            }
        }
        setWidth(640);
    </script>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.3.1.7.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.animate1.0.2.min.js"></script>
    <title>女神不一样,全民新丹当!</title>
</head>
<body>
<div id="LoadModule" class="n_wrapper">
    <div class="spinner">
        <div class="spinner-container container1">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
        <div class="spinner-container container2">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
        <div class="spinner-container container3">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
            <div class="circle4"></div>
        </div>
    </div>
</div>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>
<div class="swiper-container n_wrapper" id="SwiperModule">
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper unShow" id="SlidePage1">
            <div class="ver n_wrapper relative hidden">
                <p class="P1_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P1_txt.png" alt=""/></p>

                <p class="P1_tit ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.6s"><img src="images/P1_tit.png" alt=""/></p>

                <p class="P1_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s"
                   swiper-animate-delay="0s"><img src="images/P1_show.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage2">
            <div class="ver n_wrapper relative hidden">
                <p class="P1_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P2_txt.png" alt=""/></p>

                <p class="P1_tit ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.6s"><img src="images/P2_tit.png" alt=""/></p>

                <p class="P1_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s"
                   swiper-animate-delay="0s"><img src="images/P2_show.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage3">
            <div class="ver n_wrapper relative hidden">
                <p class="P3_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s"
                   swiper-animate-delay="0s"><img src="images/P3_show.png" alt=""/></p>

                <div class="P3_rect ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s"
                     swiper-animate-delay="0s"></div>
                <p class="P3_tit ani" swiper-animate-effect="flipInY" swiper-animate-duration="0.8s"
                   swiper-animate-delay="0s"><img src="images/P3_tit.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage4">
            <div class="ver n_wrapper relative hidden">
                <p class="P4_tit1 ani" swiper-animate-effect="slideInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P4_tit1.png" alt=""/></p>

                <p class="P4_tit2 ani" swiper-animate-effect="slideInLeft" swiper-animate-duration="0.3s"
                   swiper-animate-delay="0s"><img src="images/P4_tit2.png" alt=""/></p>

                <p class="P4_tit3 ani" swiper-animate-effect="slideInRight" swiper-animate-duration="0.3s"
                   swiper-animate-delay="0s"><img src="images/P4_tit3.png" alt=""/></p>

                <p class="P4_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.3s"><img src="images/P4_txt1.png" alt=""/></p>

                <p class="P4_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.3s"><img src="images/P4_txt2.png" alt=""/></p>

                <p class="Mc_arrow Ani_arrow"><img src="images/Mc_arrow.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage5">
            <div class="ver n_wrapper relative hidden">
                <p class="P5_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P5_logo.png" alt=""/></p>

                <p class="P5_show1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P5_show1.png" alt=""/></p>

                <p class="P5_tit ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.2s"><img src="images/P5_tit.png" alt=""/></p>

                <p class="P5_show2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.8s"
                   swiper-animate-delay="0.3s"><img src="images/P5_show2.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper Mc_bg unShow" id="SlidePage6">
            <div class="n_wrapper relative hidden">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

                <div class="Mc_light"></div>

                <p class="Mc_tit"><img src="images/P6_tit.png" alt=""/></p>

                <p class="P6_show2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P6_show2.png" alt=""/></p>

                <p class="P6_show1 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P6_show1.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper Mc_bg unShow" id="SlidePage7">
            <div class="n_wrapper relative hidden">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>
                <div class="Mc_light"></div>
                <p class="Mc_tit"><img src="images/P7_tit.png" alt=""/></p>

                <p class="P7_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P7_show.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper Mc_bg unShow" id="SlidePage8">
            <div class="n_wrapper relative hidden">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

                <div class="Mc_light"></div>
                <p class="Mc_tit"><img src="images/P8_tit.png" alt=""/></p>

                <p class="P8_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P8_show.png" alt=""/></p>

                <p class="P8_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P8_txt.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper Mc_bg unShow" id="SlidePage9">
            <div class="n_wrapper relative hidden">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

                <div class="Mc_light"></div>
                <p class="Mc_tit"><img src="images/P9_tit.png" alt=""/></p>

                <p class="Btn_form ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Btn_form.png" alt=""/></p>

                <p class="P9_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P9_show.png" alt=""/>
                </p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper Mc_bg" id="SlidePage10">
            <div class="n_wrapper relative hidden">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>
                <div class="Mc_light"></div>
                <p class="Mc_tit"><img src="images/P10_tit.png" alt=""/></p>

                <p class="P10_show1 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P10_show1.png" alt=""/></p>

                <p class="P10_show2 Ani_light"><img src="images/P10_show2.png" alt=""/></p>

                <p class="P10_show3"><img src="images/P10_show3.png" alt=""/></p>
            </div>
        </div>
    </div>
</div>
<audio src="sound/Sound_bg1.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
<script type="text/javascript" charset="UTF-8" src="libs/Main.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
	//微信分享控制
        wx.config({
      	  debug: false,
      	  appId: '<?php echo $signPackage["appId"];?>',
      	  timestamp: '<?php echo $signPackage["timestamp"];?>',
      	  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      	  signature: '<?php echo $signPackage["signature"];?>',
      	  jsApiList: [
      		'checkJsApi',
      		'onMenuShareTimeline',
      		'onMenuShareAppMessage',
      		'onMenuShareQQ',
      		'onMenuShareWeibo'
      	  ]
      	});

      	wx.ready(function () {
      		var wxData = {
              "imgUrl": 'http://zt.jia360.com/lapp/act/images/share.jpg',
              "link": 'http://zt.jia360.com/lapp/act/index.php',
              "desc": "继文艺女神王珞丹倾情加盟后,全民家居购贺岁季又添新丹当,想知道她是谁么?",
              "title": "女神不一样,全民新丹当!"
      		};
      		wx.onMenuShareAppMessage(wxData);
      		wx.onMenuShareTimeline(wxData);
      	});
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>