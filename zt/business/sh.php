<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>诚邀品鉴 静候光临</title>
<meta name="keywords" content="诚邀品鉴 静候光临" />
<meta name="description" content="诚邀品鉴 静候光临" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/sh.css?version=1.1"  />

</head>
<body>
       <div class="cn-spinner" id="loading" style=" opacity: 1;">
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
   <div class="swiper-container swiper-pages" id="swiper-container1">
   		<!-- 新音乐样式 -->
   		<div id="music" class="video_exist open" style="display: block;">
			<div id="yinfu" class="rotate"></div>
			<audio src="images/music.mp3" id="media" preload="auto" loop="true"></audio>
		</div>
		<div class="swiper-wrapper" id="wrapper">
			<!--1-->
			<div class="swiper-slide page-1">
				<div class="container">
				</div>
			</div>
			<!--2-->
			<div class="swiper-slide page-2" >
				<div class="container">
				</div>
			</div>
			<!--3-->
			<div class="swiper-slide page-3">
				<div class="container">
				</div>
			</div>
			<!--4-->
			<div class="swiper-slide page-4">
				<div class="container">
				</div>
			</div>
			<!--5-->
			<div class="swiper-slide page-5">
				<div class="container">
				</div>
			</div>
			<!--6-->
			<div class="swiper-slide page-6" >
				<div class="container">
				</div>
			</div>
			<!--7-->
			<div class="swiper-slide page-7">
				<div class="container">
				</div>
			</div>
			<!--8-->
			<div class="swiper-slide page-8">
				<div class="container">
				</div>
			</div>
	   </div>
	</div>
	<div class="cn-slidetips">
		<div class="slidetips">
			<a href="javascript:void(0);" title="NEXT" id="next">
				<img src="images/next.png" />
			</a>
		</div>
	</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/com.js?version=1.0"></script>
<script>
	//微信分享控制
	wx.config({
		  debug: false,
	      appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
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
			"imgUrl":'http://zt.jia360.com/business/images/share.png',
			"link":'http://zt.jia360.com/business/sh.php',
			"desc":"6月10日-6月12日，呼博士2015年上海国际空气净化设备与污染治理展览会静候您光临！",
			"title":"诚邀品鉴 静候光临 "
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>