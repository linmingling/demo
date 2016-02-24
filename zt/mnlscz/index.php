<?php
    require_once "../data/jssdk.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no, email=no" />
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
					(b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function() {
						var d = document.getElementsByTagName("body")[0];
						d.style.webkitTransformOrigin = "left top";
						d.style.webkitTransform = "scale(" + c + ")";
					}, !1)
				}
			}
			setWidth(640);
		</script>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/swiper.css" />
		<link rel="stylesheet" href="css/animate.min.css" />
		<link rel="stylesheet" href="css/index.css?c=sdsdsdadsad" />
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/swiper.min.js"></script>
		<script type="text/javascript" src="js/swiper.animate1.0.2.min.js"></script>
		<script type="text/javascript" src="js/load.js" ></script>
		

		<style>
			*{-moz-user-select:none;-webkit-user-select:none;-webkit-touch-callout:none;}
			img{-webkit-transform: translate3D(0,0,0);}
			@-webkit-keyframes shan{
				0%{opacity: 1;}
				100%{opacity: 0;}
			}
			#left,#right{-webkit-animation:"shan" .7s ease-in  infinite alternate;}
		</style>

		<title></title>
	</head>

	<body>

		<img _src="img/open.png" id="yinyueBtn" style="display: none;"/>
		<img _src="img/bottom.png" id="bottom" style="position: fixed;bottom:10px;left: 50%;-webkit-transform: translateX(-50%);z-index: 99;display: none;" />
		<div id="ver_modul" class="n_wrapper" style="visibility: hidden;">
			<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="loop"></audio>
			<div class="swiper-container" id="ver_swiper">
				<div class="swiper-wrapper">
					<div class="swiper-slide n_wrapper relative" id="main_modul">
						<img _src="img/index/m_tit.png" id="m_tit" class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.3s" />
						<img _src="img/index/logo.png" class="logo" />
					</div>
					<div class="swiper-slide n_wrapper">
						<div class="swiper-container relative ani"id="hor_swiper" swiper-animate-effect="pulse" swiper-animate-duration="1s" swiper-animate-delay="0s" style="-webkit-transform: translate3D(0,0,0);background-color: #2e2f2e;">
							<div class="swiper-wrapper" id="horInner">
								<div class="swiper-slide" name="kala">
									<div>
										<img _src="img/select/kala/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/kala/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper relative" style="background:url(img/select/kala/kala.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/kala/kala.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="xixi">
									<div>
										<img _src="img/select/xixi/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/xixi/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/xixi/xixi.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/xixi/xixi.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="bingdao">
									<div>
										<img _src="img/select/bingdao/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/bingdao/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/bingdao/bingdao.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/bingdao/bingdao.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="dianya">
									<div>
										<img _src="img/select/dianya/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/dianya/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/dianya/dianya.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/dianya/dianya.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="feicui">
									<div>
										<img _src="img/select/feicui/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/feicui/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/feicui/feicui.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/feicui/feicui.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="jueshi">
									<div>
										<img _src="img/select/jueshi/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/jueshi/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/jueshi/jueshi.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/jueshi/jueshi.png" class="ver_hor"/>
									</div>
								</div>
								<div class="swiper-slide" name="pasi">
									<div>
										<img _src="img/select/pasi/chanpin.jpg" />
									</div>
									<div class="none">
										<img _src="img/select/pasi/kongjian.jpg"/>
									</div>
									<div class="none n_wrapper" style="background:url(img/select/pasi/pasi.jpg) no-repeat;background-size: cover;">
										<img _src="img/select/pasi/pasi.png" class="ver_hor"/>
									</div>
								</div>
							</div>
							<img id="left" src="img/left.png" style="position: absolute;top: 50%;margin-top: -20px;z-index: 3;left: 0;"/>
							<img id="right" src="img/right.png" style="position: absolute;top: 50%;margin-top: -20px;z-index: 3;right: 0;"/>
							<img _src="img/select/kala/tit.png" id="tile_tit" />
						</div>
						<div id="botColum" class="ani" swiper-animate-effect="pulse" swiper-animate-duration="1s" swiper-animate-delay="0s">
							<div>
								<img _src="img/select/kala/name.png" id="tile_name" />
								<ul id="btnList" class="hor pack_justify">
									<li><img _src="img/select/btn/chanpin_on.png" /><img _src="img/select/btn/chanpin_off.png" style="display: none;" /></li>
									<li><img _src="img/select/btn/kongjian_on.png" style="display: none;" /><img _src="img/select/btn/kongjian_off.png" /></li>
									<li><img _src="img/select/btn/jiedu_on.png" style="display: none;" /><img _src="img/select/btn/jiedu_off.png" /></li>
								</ul>
								<div class="swiper-pagination" id="pagecolum"></div>
							</div>

						</div>
					</div>

					<div class="swiper-slide n_wrapper relative ver1">
						<img _src="img/index/logo.png" class="logo" />
						<img _src="img/ver/1_1.png" id="ver_1_1" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s" swiper-animate-delay="0.3s" />
						<img _src="img/ver/1_2.png" id="ver_1_2" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.8s" swiper-animate-delay="1.1s" />
					</div>
					<div class="swiper-slide n_wrapper relative ver2">
						<img _src="img/index/logo.png" class="logo" />
						<img _src="img/ver/2_1.png" id="ver_2_1" class="ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="0.3s" />
					</div>
					<div class="swiper-slide n_wrapper relative ver3">
						<img _src="img/index/logo.png" class="logo" />
						<img _src="img/ver/3_1.png" id="ver_3_1" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.8s" swiper-animate-delay="0.3s" />
					</div>
					<div class="swiper-slide n_wrapper relative ver4">
						<img _src="img/index/logo.png" class="logo" />
						<img _src="img/ver/4_1.png" id="ver_4_1" class="ani" swiper-animate-effect="pulse" swiper-animate-duration="1s" swiper-animate-delay="0.3s" />
						<img _src="img/ver/4_2.png" id="ver_4_2" class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.7s" swiper-animate-delay="1.3s" />
					</div>
					<div class="swiper-slide n_wrapper relative ver5 ver">
						<img _src="img/index/logo.png" class="logo" />
						<div class="relative">
							<img _src="img/ver/5_1.png" id="ver_5_1" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.7s" swiper-animate-delay="0.3s" />
							<img _src="img/ver/5_2.png" id="ver_5_2" class="ani" swiper-animate-effect="flash" swiper-animate-duration="0.7s" swiper-animate-delay="1.3s" />
							<img _src="img/ver/5_3.png" id="ver_5_3" class="ani" swiper-animate-effect="flipInY" swiper-animate-duration="1s" swiper-animate-delay="2.3s" />
							<div class="hor pack_justify" id="endBtn">
								<img _src="img/ver/shareBtn.png" id="shareBtn" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="3.3s" />
								<img _src="img/ver/knowBtn.png" id="knowBtn" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s" swiper-animate-delay="3.3s" />
							</div>
						</div>
						<div id="shareCon">
							<p class="t_right"><img _src="img/sharetip.png" id="sharetip" /></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	<script type="text/javascript" src="js/main.js" ></script>
	</body>

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
                "imgUrl":'http://zt.jia360.com/mnlscz/img/share.jpg',
                "link":'http://zt.jia360.com/mnlscz/index.php',
                "desc":"罗马宝石-喷墨通体瓷质砖，独居匠心，只为成就传奇！",
                "title":"蒙娜丽莎瓷砖罗马宝石"
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>

</html>