<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然地板20周年全球感恩盛典</title>
<meta name="keywords" content="大自然地板20周年全球感恩盛典" />
<meta name="description" content="大自然地板20周年全球感恩盛典" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=2.5"  />
</head>
<body>
<!-- 加载 -->
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
<!-- 二维码
<div class="am am4 hide" id="sign">
  <div class="sign">
		<img src="images/wx.png"  />
	</div>
</div>
-->

<!-- 主要内容 -->
<div class="swiper-container swiper-pages" id="swiper-container1">
<div class="bgs"><img src="images/bg.jpg"  /></div>
	<div class="swiper-wrapper" id="wrapper">

		<!-- 第一屏 -->
		<div class="swiper-slide page-1">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/a1_1.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a1_2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am4">
					<img src="images/a1_3.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
				</div>


                <div class="next">
					<img src="images/next.png" />
				</div>


			</div>
		</div>
		<!-- 第二屏 -->
		<div class="swiper-slide page-2">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/a2_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a2_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>

				<!-- 报名 无奈摞出-->

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第三屏 -->
		<div class="swiper-slide page-3">
			<div class="container">
				<div class="am am1">
                    <img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/a3_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a3_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/a3_3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"/>
				</div>
				


				<div class="next">
					<img src="images/next.png" />
				</div>
                
               
            
			</div>
		</div>
		<!-- 第四屏 -->
		<div class="swiper-slide page-4">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/a4_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a4_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>
                <div class="am am4">
					<img src="images/a4_3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"  />
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第五屏 -->
		<div class="swiper-slide page-5">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"/>
				</div>
                <div class="am am2">
					<img src="images/a5_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>
				<div class="am am4">
					<img src="images/a5_3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"  />
				</div>


				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第六屏 -->
		<div class="swiper-slide page-6">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"/>
				</div>
                <div class="am am2">
					<img src="images/a6_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a6_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>



				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第七屏 -->
		<div class="swiper-slide page-7">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"/>
				</div>
                <div class="am am2">
					<img src="images/a7_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a7_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>


				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第八屏 -->
		<div class="swiper-slide page-8">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeIn"/>
				</div>
                <div class="am am2">
					<img src="images/a8_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a8_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"  />
				</div>
				<div class="am am4">
					<img src="images/a8_3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"  />
				</div>
				<div class="am am5">
					<a href="http://zt.jia360.com/nature20/index.php"><img src="images/a8_4.png" class="animation an5" data-item="an5" data-delay="2200" data-animation="fadeInDown"  /></a>
				</div>
				<div class="next">
					<img src="images/next2.png" />
				</div>
			</div>
		</div>
       

       
        

   </div>
</div>
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
		imgUrl:'http://zt.jia360.com/dzr_20m/images/zft.jpg',
		link:'http://zt.jia360.com/dzr_20m/index.php',
		desc:"狂送200万份感恩大礼  狂抽2000个免单大礼 全球寻找20年前的老客户 享尊贵礼遇",
		title:"大自然地板20周年全球感恩盛典"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.9"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>