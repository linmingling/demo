<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../data/config.php');
	require_once(ROOT_PATH . '../../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
   $agent = $_SERVER['HTTP_USER_AGENT'];
        if(!strpos($agent,"MicroMessenger")){
       	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
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
    <title>买不到车票，也要开怀大笑—买联邦家私就送大兵相声演出门票!</title>
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
<img src="images/Mc_arrow.png" id="Mc_arrow"/>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>

<div class="swiper-container n_wrapper Mc_bg">
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper " id="SlidePage1">
            <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
               swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

            <div class="ver n_wrapper">
                <div class="relative P1Box">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0s"><img src="images/P1_show.png" alt=""/></p>

                    <p id="P1_tit" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0.3s"><img src="images/P1_tit.png" alt=""/></p>

                    <p id="P1_txt1" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0.5s"><img src="images/P1_txt1.png" alt=""/></p>

                    <p id="P1_txt2" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0.5s"><img src="images/P1_txt2.png" alt=""/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper " id="SlidePage4">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="0s"><img src="images/P4_txt1.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper " id="SlidePage5">
            <div class="ver n_wrapper">
                <p class="Txt_tit3 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">百款放价 <span style="color: white">千城狂欢</span></p>

                <div class="containerBox relative" id="P5_swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <p><img src="images/P5_show1.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P5_show2.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P5_show3.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P5_show4.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P5_show5.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P5_show6.jpg" alt=""/></p>
                        </div>
                    </div>
                    <div class="swiper-button-prev BtnPrev"></div>
                    <div class="swiper-button-next BtnNext"></div>
                </div>

                <div class="NameBox ver ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s"
                     swiper-animate-delay="0s">
                    <p>爆款尖货</p>
                </div>

                <p class="Txt_tip ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">*图片仅供参考，详情以联邦京东旗舰店内公告为准</p>

                <p class="Txt_info2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">百款迎新爆款，千城狂欢开抢</p>

                <p class="Txt_info1 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.1s">联邦家居众多爆款尖货，迎新放价5折起开抢</p>

                <p class="Txt_info1 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.2s">开抢时间：即日起至2016年1月10日</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper" id="SlidePage2">
            <div class="ver n_wrapper">
                <p class="Txt_tit1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">全屋名牌家具</p>

                <p class="Txt_tit2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">31件3.1万</p>

                <div class="containerBox relative" id="P2_swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <p><img src="images/P2_show1.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P2_show2.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P2_show3.jpg" alt=""/></p>
                        </div>
                        <div class="swiper-slide">
                            <p><img src="images/P2_show4.jpg" alt=""/></p>
                        </div>
                    </div>
                    <div class="swiper-button-prev BtnPrev"></div>
                    <div class="swiper-button-next BtnNext"></div>
                </div>
                <div class="NameBox ver ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s"
                     swiper-animate-delay="0s">
                    <p>家家具系列套餐</p>
                </div>

                <p class="Txt_tip ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">*图片仅供参考，详情以联邦京东旗舰店内公告为准</p>

                <p class="Txt_info1 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">值联邦31周年，特向全球推出周年庆优惠套餐</p>

                <p class="Txt_info2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.1s">只需3.1万元，全屋名牌家具31件套</p>

                <p class="Txt_info1 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.2s">您可轻松搬回家！</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper" id="SlidePage8">
            <div class="ver n_wrapper">
                <div class="ver relative">
                    <p class="P8_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s"><img src="images/P8_show.png" alt=""/></p>

                    <p class="P8_tit ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0s"><img src="images/P1_tit.png" alt=""/></p>
                </div>

                <p class="P8_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.1s">12月20日 著名笑星大兵</p>

                <p class="P8_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.2s">与他的团队亲临 联邦VIP顾客答谢会</p>

                <p class="P8_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.3s">现在报名 与大兵一起迎新抢购乐翻天</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper " id="SlidePage6">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/P6_show.png" alt=""/></p>

                <p class="P6_Txt1 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.5s">大品牌<strong>有保障</strong></p>

                <p class="P6_Txt2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.1s">一站购齐 品质有保证</p>

                <p class="P6_Txt3 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.2s">齐全的产品阵容</p>

                <p class="P6_Txt3 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.3s">丰富的产品风格</p>

                <p class="P6_Txt3 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.4s">完善的配套服务</p>

                <p class="P6_Txt4 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.8s">一站式购买</p>

                <p class="P6_Txt3 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.5s">省时、省心、省钱、省事……</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper " id="SlidePage7">
            <div class="ver n_wrapper">
                <p class="P7_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s">买后<strong>无忧</strong></p>

                <div class="relative P7Box">
                    <p id="P7_show1" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s"><img src="images/P7_show1.png" alt=""/></p>

                    <p id="P7_show2" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s"><img src="images/P7_show2.png" alt=""/></p>

                    <p id="P7_show3" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s"><img src="images/P7_show3.png" alt=""/></p>

                    <p id="P7_show4" class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s"><img src="images/P7_show4.png" alt=""/></p>
                </div>
            </div>
        </div>

        <div class="swiper-slide n_wrapper " id="SlidePage9">
            <div class="ver n_wrapper">
                <p id="Btn_jd" class="ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.3s"><img src="images/Btn_jd.png" alt=""/></p>

                <div class="TimeBox ver ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                     swiper-animate-delay="0.4s"><p><strong>开抢时间：即日起至2016年1月10日</strong></p></div>
                <p id="P9_show" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.2s"
                   swiper-animate-delay="0s"><img src="images/P9_show.png" alt=""/></p>
            </div>
            <div class="ver CodeBox ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                 swiper-animate-delay="0.3s">
                <p id="Mc_code"><img src="images/Mc_code.png" alt=""/></p>

                <p id="Mc_law"><img src="images/Mc_law.png" alt=""/></p>
            </div>
        </div>
    </div>
</div>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
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
              "imgUrl": 'http://zt.jia360.com/lapp/news/images/share.jpg',
              "link": 'http://zt.jia360.com/lapp/news/index.php',
              "desc": "著名笑星大兵来了！联邦家私迎新抢购乐翻天，百款放价千城狂欢",
              "title": "买不到车票，也要开怀大笑—买联邦家私就送大兵相声演出门票!"
      		};
      		wx.onMenuShareAppMessage(wxData);
      		wx.onMenuShareTimeline(wxData);
      	});
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>