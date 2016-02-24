<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>定制无醛，定制爱 HOLiKE好莱客</title>
<meta name="keywords" content="定制无醛，定制爱 HOLiKE好莱客" />
<meta name="description" content="定制无醛，定制爱 HOLiKE好莱客" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.6"  />



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
	<!--音乐  -->
	<div id="music">
		<a href="javascript:void(0)" class="open musicBtn" ></a>
		<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
	</div>
	<div class="swiper-wrapper" id="wrapper">

		  <div class="swiper-slide page-1">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p1_bg.jpg" style="height:100%;"class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="images/logo.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown"  />
					</div>
					<div class="am am4">
						<img src="images/p1_1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
						<img src="images/p1_2.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInDown"/>
						<img src="images/p1_3.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="fadeInDown"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next1.png" />
					</div>
			  </div>
		  </div>

		  <div class="swiper-slide page-2">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="images/p2_1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
						<img src="images/p2_2.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInDown"/>
						<img src="images/p2_3.png" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInDown"/>
					</div>
					<div class="am am4">
						<img src="images/p2_4.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="fadeIn"/>
						<img src="images/p2_5.png" class="animation an8" data-item="an8" data-delay="3600" data-animation="fadeIn"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>             
		  </div>

		  <div class="swiper-slide page-3">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/P3_1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInRight"/>
						<img src="" date-src="images/P3_2.png?vs=1.0" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInRight"/>
						<img src="" date-src="images/P3_3.png" class="animation an6" data-item="an6" data-delay="2200" data-animation="fadeInRight"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>           
		  </div>
		  
		  <div class="swiper-slide page-4">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/p4_1.png?vs=1.0" style="left: 4%" class="animation an3" data-item="an3" data-delay="800" data-animation="fadeInDown"/>
						<img src="" date-src="images/p4_2.png" style="left: 2%" class="animation an4" data-item="an4" data-delay="1000" data-animation="fadeInDown"/>
					</div>
					<div class="am am4">
						<img src="" date-src="images/p4_3.png" class="animation an5" data-item="an5" data-delay="1400" data-animation="fadeIn"/>
						<img src="" date-src="images/p4_4.png" class="animation an6" data-item="an6" data-delay="1800" data-animation="fadeIn"/>
						<img src="" date-src="images/p4_5.png" class="animation an7" data-item="an7" data-delay="2200" data-animation="fadeIn"/>
						<img src="" date-src="images/p4_6.png" class="animation an8" data-item="an8" data-delay="2600" data-animation="fadeIn"/>
						<img src="" date-src="images/p4_7.png" class="animation an9" data-item="an9" data-delay="3000" data-animation="fadeIn"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-5">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/p5_1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
						<img src="" date-src="images/p5_2.png?vs=1.0" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInDown"/>
						<img src="" date-src="images/p5_3.png?vs=1.0" class="animation an6" data-item="an6" data-delay="2200" data-animation="fadeInDown"/>
					</div>
					<div class="am am4">
						<img src="" date-src="images/p5_5.png" class="animation an8" data-item="an8" data-delay="3000" data-animation="fadeIn"/>
						<img src="" date-src="images/p5_6.png" class="animation an9" data-item="an9" data-delay="4000" data-animation="fadeIn"/>
						<img src="" date-src="images/p5_7.png" class="animation an10" data-item="an10" data-delay="5000" data-animation="fadeIn"/>
						<img src="" date-src="images/p5_8.png" class="animation an11" data-item="an11" data-delay="6000" data-animation="fadeIn"/>
						<img src="" date-src="images/p5_9.png" class="animation an12" data-item="an12" data-delay="7000" data-animation="fadeIn"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>                    
		  </div>
		  
		  <div class="swiper-slide page-6">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p2_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/p6_1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
						<img src="" date-src="images/p6_2.png?version=1.1" class="animation an5" data-item="an5" data-delay="1800" data-animation="fadeInDown"/>
						<img src="" date-src="images/p6_3.png?version=1.2" class="animation an6" data-item="an6" data-delay="2200" data-animation="fadeInDown"/>
					</div>
					<div class="am am4">
						<img src="" date-src="images/p6_4.png" class="animation an7" data-item="an7" data-delay="2600" data-animation="fadeIn"/>
						<img src="" date-src="images/p6_5.png" class="animation an8" data-item="an8" data-delay="3600" data-animation="fadeIn"/>
						<img src="" date-src="images/p6_6.png" class="animation an9" data-item="an9" data-delay="4600" data-animation="fadeIn"/>
						<img src="" date-src="images/p6_7.png" class="animation an10" data-item="an10" data-delay="5600" data-animation="fadeIn"/>
						<img src="" date-src="images/p6_8.png" class="animation an11" data-item="an11" data-delay="6600" data-animation="fadeIn"/>
						
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-7">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p7_bg.jpg" style="height:100%;" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/p7_1.png" class="animation an4" data-item="an4" data-delay="1000" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_2.png" class="animation an5" data-item="an5" data-delay="1400" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_3.png" class="animation an6" data-item="an6" data-delay="1800" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_4.png" class="animation an7" data-item="an7" data-delay="2200" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_5.png" class="animation an8" data-item="an8" data-delay="2600" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_6.png" class="animation an9" data-item="an9" data-delay="3000" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_7.png" class="animation an10" data-item="an10" data-delay="3400" data-animation="fadeInDown"/>
						<img src="" date-src="images/p7_8.png" class="animation an11" data-item="an11" data-delay="3800" data-animation="fadeInDown"/>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next2.png" />
					</div>
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-8">
			  <div class="container">
					<div class="am am1 bg">
						<img src="images/p8_bg.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
					</div>
					<div class="am am3">
						<img src="" date-src="images/p8_1.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"/>
						<img src="" date-src="images/p8_2.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"/>
					</div>
					<div class="am am4">
						<img src="" date-src="images/p8_3.png" class="animation an5" data-item="an5" data-delay="2200" data-animation="fadeInDown"/>
					</div>
					<!-- <div class="am am5">
						<img src="" date-src="images/p8_ewm.png" class="animation an6" data-item="an6" data-delay="1000" data-animation="fadeInDown"/>
					</div> -->
					<div class="am am6">
						<p class="animation an7" data-item="an7" data-delay="2400" data-animation="fadeInDown">腾讯网·亚太家居UED出品</p>
					</div>
					<div class="am am2 leaf">
						<img src="images/leaf.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next3.png" />
					</div>
			  </div>                  
		  </div>
		  
		  
   </div>
</div>
<!-- 二维码 -->
<img src="images/p8_ewm.png" id="ewm" class="ewm"/>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
		"imgUrl":'http://zt.jia360.com/wuquan/images/share.jpg',
		"link":'http://zt.jia360.com/wuquan/index.php',
		"desc":"拒绝甲醛，自由呼吸，让“无醛”成为人类健康环保至大的财富。",
		"title":"定制无醛，定制爱 HOLiKE好莱客"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.0"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>