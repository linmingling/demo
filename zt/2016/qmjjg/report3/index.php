<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../../data/config.php');
	require_once(ROOT_PATH . '../../../../data/jssdk.php');
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
    <title>全民大卖 可喜可贺</title>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.3.1.7.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.animate1.0.2.min.js"></script>
</head>
<body>
<div class="swiper-container n_wrapper Mc_bg" id="SwiperModule">
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper hidden" id="SlidePage1">
            <div class="relative n_wrapper">
                <p class="Mc_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

                <p class="P1_show1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="0s"><img src="images/P1_show1.png" alt=""/></p>

                <p class="P1_tit1 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.5s"><img src="images/P1_tit1.png" alt=""/></p>

                <p class="P1_txt1 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.5s"><img src="images/P1_txt1.png" alt=""/></p>

                <p class="P1_txt2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0.5s"><img src="images/P1_txt2.png" alt=""/></p>

                <p class="P1_show2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="1.5s"
                   swiper-animate-delay="1s"><img src="images/P1_show2.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage2">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.5s"><img src="images/P2_txt1.png" alt=""/></p>

                <div class="ShowBox2">
                    <p class="P_showL ani" swiper-animate-effect="rotateInDownRight" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P2_show1.png" alt=""/></p>

                    <p class="P_showR ani" swiper-animate-effect="rotateInDownLeft" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P2_show2.png" alt=""/></p>

                    <p class="P_showM ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="2s"><img src="images/P2_show3.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P2_txt2.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage10">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.5s"><img src="images/P10_txt1.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P10_txt2.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P10_txt3.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P10_txt4.png" alt=""/></p>

                <div class="ShowBox10">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2s"
                       swiper-animate-delay="4s"><img src="images/Mc_light.png" alt=""/></p>

                    <p class="P10_show ani" swiper-animate-effect="slideInLeft" swiper-animate-duration="1s"
                       swiper-animate-delay="3s"><img src="images/P10_show.png" alt=""/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage3">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="5s"><img src="images/P3_txt1.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s"
                   swiper-animate-delay="5s"><img src="images/P3_txt2.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="5s"><img src="images/P3_txt3.png" alt=""/></p>

                <div class="ShowBox3">
                    <p class="Mc_money1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="3s"><img src="images/Mc_money1.png" alt=""/></p>

                    <p class="Mc_money2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_money1.png" alt=""/></p>

                    <p class="Mc_money3 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_money1.png" alt=""/></p>

                    <p class="Mc_money4 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="3.6s"><img src="images/Mc_money1.png" alt=""/></p>

                    <p class="P3_obj1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.1s"
                       swiper-animate-delay="3.8s"><img src="images/P3_obj1.png" alt=""/></p>

                    <p class="P3_obj2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.2s"
                       swiper-animate-delay="3.8s"><img src="images/P3_obj2.png" alt=""/></p>

                    <p class="P3_obj3 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.3s"
                       swiper-animate-delay="3.8s"><img src="images/P3_obj3.png" alt=""/></p>

                    <p class="P3_obj4 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.4s"
                       swiper-animate-delay="3.8s"><img src="images/P3_obj4.png" alt=""/></p>

                    <p class="P3_obj5 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.5s"
                       swiper-animate-delay="3.8s"><img src="images/P3_obj5.png" alt=""/></p>
                </div>

            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage4">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="4s"><img src="images/P4_txt1.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="4s"><img src="images/P4_txt3.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s"
                   swiper-animate-delay="4.5s"><img src="images/P4_txt2.png" alt=""/></p>

                <div class="ShowBox4">
                    <p class="Mc_fridge1 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="3.1s"><img src="images/Mc_fridge.png" alt=""/></p>

                    <p class="Mc_fridge2 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_fridge.png" alt=""/></p>

                    <p class="Mc_fridge3 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="3.3s"><img src="images/Mc_fridge.png" alt=""/></p>

                    <p class="Mc_fridge4 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_fridge.png" alt=""/></p>

                    <p class="Mc_money5 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="3.5s"><img src="images/Mc_money2.png" alt=""/></p>

                    <p class="Mc_money6 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_money2.png" alt=""/></p>

                    <p class="P4_obj1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="4s"><img src="images/P4_obj1.png" alt=""/></p>

                    <p class="P4_obj2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="4s"><img src="images/P4_obj2.png" alt=""/></p>

                    <p class="Mc_phone1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.5s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_phone.png" alt=""/></p>

                    <p class="Mc_phone2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.5s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_phone.png" alt=""/></p>

                    <p class="Mc_phone3 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.5s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_phone.png" alt=""/></p>

                    <p class="Mc_phone4 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1.5s"
                       swiper-animate-delay="3.4s"><img src="images/Mc_phone.png" alt=""/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage5">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2s"><img src="images/P5_txt1.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.2s"><img src="images/P5_txt2.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.4s"><img src="images/P5_txt3.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.6s"><img src="images/P5_txt4.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.8s"><img src="images/P5_txt5.png" alt=""/></p>

                <div class="ShowBox5">
                    <p class="P5_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="2.5s"><img src="images/P5_show.png" alt=""/></p>

                    <p class="P5_point1 ani" swiper-animate-effect="bounceInDown" swiper-animate-duration="1s"
                       swiper-animate-delay="3s"><img src="images/P5_point.png" alt=""/></p>

                    <p class="P5_point2 ani" swiper-animate-effect="bounceInDown" swiper-animate-duration="1s"
                       swiper-animate-delay="3.5s"><img src="images/P5_point.png" alt=""/></p>

                    <p class="P5_point3 ani" swiper-animate-effect="bounceInDown" swiper-animate-duration="1s"
                       swiper-animate-delay="3.5s"><img src="images/P5_point.png" alt=""/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage6">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="3.5s"><img src="images/P6_txt1.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s"
                   swiper-animate-delay="3.5s"><img src="images/P6_txt2.png" alt=""/></p>

                <p class="P6_tit ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="3.5s"><img src="images/P6_tit.png" alt=""/></p>

                <p class="P6_logo ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="4s"><img src="images/P6_logo1.png" alt=""/></p>

                <p class="P6_logo ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="4.2s"><img src="images/P6_logo2.png" alt=""/></p>

                <p class="P6_logo ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="4.4s"><img src="images/P6_logo3.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage7">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_tit ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.5s"><img src="images/P7_txt1.png" alt=""/></p>

                <div class="ShowBox7">
                    <p class="P_showL ani" swiper-animate-effect="rotateInDownRight" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P7_show1.png" alt=""/></p>

                    <p class="P_showR ani" swiper-animate-effect="rotateInDownLeft" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P7_show2.png" alt=""/></p>

                    <p class="P_showM ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="2s"><img src="images/P7_show3.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P7_txt2.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P7_txt3.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P7_txt4.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden unShow" id="SlidePage8">
            <div class="n_wrapper ver">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="2s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo2.png" alt=""/></p>

                <div class="WishBox">
                    <p class="ani" swiper-animate-effect="rotateIn" swiper-animate-duration="1s"
                       swiper-animate-delay="0.5s"><img src="images/Mc_bg_txt.png" alt=""/></p>

                    <p class="Mc_txt ani" swiper-animate-effect="zoomIn" swiper-animate-duration="1s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_txt.png" alt=""/></p>

                    <p class="Mc_cloud1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2.5s"
                       swiper-animate-delay="2.5s"><img src="images/Mc_cloud1.png" alt=""/></p>

                    <p class="Mc_cloud2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                       swiper-animate-delay="1.5s"><img src="images/Mc_cloud2.png" alt=""/></p>
                </div>
                <p class="P_tit ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="2.5s"><img src="images/P8_txt1.png" alt=""/></p>

                <div class="ShowBox7">
                    <p class="P_showL ani" swiper-animate-effect="rotateInDownRight" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P8_show1.png" alt=""/></p>

                    <p class="P_showR ani" swiper-animate-effect="rotateInDownLeft" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/P8_show2.png" alt=""/></p>

                    <p class="P_showM ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="2s"><img src="images/P8_show3.png" alt=""/></p>
                </div>
                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P8_txt2.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P8_txt3.png" alt=""/></p>

                <p class="P_txt ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                   swiper-animate-delay="3s"><img src="images/P8_txt4.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper hidden" id="SlidePage9">
            <div class="n_wrapper ver">
                <p class="P9_logo ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_logo.png" alt=""/></p>

                <p class="P9_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                   swiper-animate-delay="0.5s"><img src="images/P9_txt1.png" alt=""/></p>

                <p class="P9_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                   swiper-animate-delay="0.7s"><img src="images/P9_txt2.png" alt=""/></p>

                <p class="P9_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                   swiper-animate-delay="0.9s"><img src="images/P9_txt3.png" alt=""/></p>

                <p class="P9_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                   swiper-animate-delay="1.1s"><img src="images/P9_txt4.png" alt=""/></p>

                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                   swiper-animate-delay="1.5s"><img src="images/Mc_QRcode1.png" alt=""/></p>

                <div class="BtnBox">
                    <div class="Bnt">
                        <div class="Btn_bg"><img src="images/Mc_bg_btn.png" alt=""/></div>
                    </div>
                    <p id="Btn_back" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                       swiper-animate-delay="2.5s"><img src="images/Btn_back.png" alt=""/></p>
                </div>
                <div class="relative">
                    <p id="Btn_law" class="ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                       swiper-animate-delay="2s"><img src="images/Btn_law.png" alt=""/></p>

                    <p id="Mc_QRcode2"><img src="images/Mc_QRcode2.png" alt=""/></p>
                </div>
            </div>
        </div>
    </div>
</div>
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
<div id="ColorModule">
    <img src="images/Mc_color1.png" class="Mc_color1"/>
    <img src="images/Mc_color2.png" class="Mc_color2"/>
    <img src="images/Mc_color3.png" class="Mc_color3"/>
    <img src="images/Mc_color4.png" class="Mc_color4"/>
    <img src="images/Mc_color5.png" class="Mc_color5"/>
</div>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
<img src="images/Mc_arrow.png" id="Mc_arrow"/>
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
              "imgUrl": 'http://zt.jia360.com/2016/qmjjg/report3/images/share.jpg',
              "link": 'http://zt.jia360.com/2016/qmjjg/report3/index.php',
              "desc": "全民家居购贺岁季完美收官，那些火爆全国的大事你都知道么？",
              "title": "全民大卖 可喜可贺"
      		};
      		wx.onMenuShareAppMessage(wxData);
      		wx.onMenuShareTimeline(wxData);
      	});
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>