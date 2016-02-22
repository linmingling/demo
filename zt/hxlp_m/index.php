<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>红星美凯龙-奔跑吧绿色家居</title>
<meta name="keywords" content="I won't let you down ，红星美凯龙-奔跑吧绿色家居" />
<meta name="description" content="I won't let you down ，红星美凯龙-奔跑吧绿色家居" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.4"  />

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
   <div class="gd"><img src="images/gd.png" ></div>
   <div class="swiper-container swiper-pages" id="swiper-container1">
   		<!--音乐  -->
		<div id="music">	
			<audio class="audio hide"  id="musicBox" preload="auto" loop="true" ></audio>
		</div>
		<div class="swiper-wrapper" id="wrapper">
			

			<div class="swiper-slide page-1">
				<div class="container">
					<div class="ps1 swiper-container"><img src="images/hxl_01.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-2">
				<div class="container">
					<div class="ps2 swiper-container"><img src="images/hxl_02.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-3">
				<div class="container">
					<div class="ps3 swiper-container"><img src="images/hxl_03.jpg" ><div class="sping"><iframe frameborder="0" width="100%" height="auto" src="http://v.qq.com/iframe/player.html?vid=n0158sf424z&tiny=0&auto=0" allowfullscreen></iframe></div></div>
				</div>
			</div>
            <div class="swiper-slide page-4">
				<div class="container">
					<div class="ps4 swiper-container"><img src="images/hxl_04.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-5">
				<div class="container">
					<div class="ps5 swiper-container"><img src="images/hxl_05.jpg" ><div class="sping"><iframe frameborder="0" width="100%" height="auto" src="http://v.qq.com/iframe/player.html?vid=b0159wce8ja&tiny=0&auto=0" allowfullscreen></iframe></div></div>
				</div>
			</div>
            <div class="swiper-slide page-6">
				<div class="container">
					<div class="ps6 swiper-container"><img src="images/hxl_06.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-7">
				<div class="container">
					<div class="ps7 swiper-container"><img src="images/hxl_07.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-8">
				<div class="container">
					<div class="ps8 swiper-container"><img src="images/hxl_08.jpg" ></div>
				</div>
			</div>
	   </div>
	</div>
	<div class="cn-slidetips">
		
	</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/com.js"></script>
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
			"imgUrl":'http://zt.jia360.com/hxlp_m/images/hxl_01.jpg',
			"link":'http://zt.jia360.com/hxlp_m/index.php',
			"desc":"绿色领跑，开启绿色家居梦想",
			"title":"绿色领跑，开启绿色家居梦想"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>