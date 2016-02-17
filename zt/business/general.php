<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>诚征全国经销商  共商财富大计</title>
<meta name="keywords" content="诚征全国经销商  共商财富大计" />
<meta name="description" content="诚征全国经销商  共商财富大计" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/general.css?version=1.1"  />

</head>
<body>
       <div class="cn-spinner" id="loading" style=" opacity: 1;">
        <div class="spinner">

            <div class="spinner-container container1">
                <div class="circle1"></div>
                <div class="circle2"></div> <div class="circle3"></div>
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
			"link":'http://zt.jia360.com/business/general.php',
			"desc":"医用级空气净化器品牌BRI呼博士 诚征全国经销商  共商财富大计",
			"title":"诚征全国经销商  共商财富大计"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>