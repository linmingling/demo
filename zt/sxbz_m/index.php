<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>圣象标准门-悦·色系列</title>
<meta name="keywords" content="圣象标准门-悦·色系列" />
<meta name="description" content="圣象标准门-悦·色系列" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.8"  />
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
<!-- 报名  无奈摞出-->
<div class="am am4 hide" id="sign">
  <div class="sign">
		<p class="ct">
			<span class="des">公司 </span>
			<input id="firm" type="text" name="firm" value="" />
		</p>
		<p class="ct">
			<span class="des">姓名</span>
			<input id="name" type="text" name="name" value="" />
		</p>
        <p class="ct">
			<span class="des">职位</span>
			<input id="post" type="text" name="post" value="" />
		</p>
    <p class="ct">
			<span class="des">手机</span>
			<input id="phone" type="text" name="phone" value="" />
	  </p>
		
	  <p class="sub"><span class="sure"><img src="images/bnt.png"/></span></p>
	</div>
</div>
<!-- end -->
<!-- 报名成功 -->
				<div class="s-ct-a am6 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-5">
						<div class="cloud"></div>
						<div class="condition">
							<p class="p1">信息提交成功</p>
							<p class="p2">报名社会监察员，</p>
							<p class="p2">一起来参加厦门净化之旅吧!</p>
						</div>
						<span class="back">确认</span>
					</div>
				</div>
				<!-- end -->

<!-- 主要内容 -->
<div class="swiper-container swiper-pages" id="swiper-container1">
<!--音乐  -->
		<div id="music">
			<a href="javascript:void(0)" class="musicBtn open"></a>
			<audio class="audio hide" id="musicBox" preload="auto" loop="true" src="images/music.mp3"></audio>
		</div>
	<div class="swiper-wrapper" id="wrapper">

	   <!-- 第1屏 -->
		<div class="swiper-slide page-1">
			<div class="container">
				<div class="am am1">
					<img src="images/kc1.png" class="animation an1" data-item="an1" data-delay="2800" data-animation="fadeout"  />
				</div>
			    <div class="am am2">
					<img src="images/kc2.png" class="animation an2" data-item="an2" data-delay="3000" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/kc3.jpg" class="animation an3" data-item="an3" data-delay="4500" data-animation="fadeIn"  />
				</div>
				<div class="am am4">
					<img src="images/kc4.jpg" class="animation an4" data-item="an4" data-delay="4800" data-animation="fadeIn"  />
				</div>
				<div class="am am5">
					<img src="images/kc5.jpg" class="animation an5" data-item="an5" data-delay="5100" data-animation="fadeIn"  />
				</div>
				<div class="am am6">
					<img src="images/kc6.jpg" class="animation an6" data-item="an6" data-delay="5400" data-animation="fadeIn"  />
				</div>
				<div class="am am7">
					<img src="images/kc7.jpg" class="animation an7" data-item="an7" data-delay="6300" data-animation="fadeIn"  />
				</div>
				
				<div class="next">
					<img src="images/next.png" class="animation an8" data-item="an8" data-delay="7000" data-animation="fadeIn"/>
				</div>
			


			</div>
		</div>
	
		<!-- 第2屏 -->
		<div class="swiper-slide page-2">
			<div class="container">

			    
				<div class="am am1">
					<img src="images/bg3_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg3_2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinX"  />
				</div>
				<div class="am am3">
					<img src="images/bg3_3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg3s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>


                <div class="next">
					<img src="images/next.png" />
				</div>


			</div>
		</div>
		
		<!-- 第3屏 -->
		<div class="swiper-slide page-3">
			<div class="container">
				<div class="am am1">
					<img src="images/bg4_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg4_2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinX"  />
				</div>
				<div class="am am3">
					<img src="images/bg4_3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg4s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>

                <div class="next">
					<img src="images/next.png" />
				</div>


			</div>
		</div>
		
		<!-- 第4屏 -->
		<div class="swiper-slide page-4">
			<div class="container">
				<div class="am am1">
					<img src="images/bg5_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg5_2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinY"  />
				</div>
				<div class="am am3">
					<img src="images/bg5_3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinX"  />
				</div>
				<div class="am am4">
					<img src="images/bg5s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第5屏 -->
		<div class="swiper-slide page-5">
			<div class="container">
				<div class="am am1">
					<img src="images/bg6_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg6_2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinY"  />
				</div>
				<div class="am am3">
					<img src="images/bg6_3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinX"  />
				</div>
				<div class="am am4">
					<img src="images/bg6s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				


				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第6屏 -->
		<div class="swiper-slide page-6">
			<div class="container">
				<div class="am am1">
					<img src="images/bg7_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg7_3.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinY"  />
				</div>
				<div class="am am3">
					<img src="images/bg7_2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg7s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第7屏 -->
		<div class="swiper-slide page-7">
			<div class="container">
				<div class="am am1">
					<img src="images/bg8_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg8_3.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinY"  />
				</div>
				<div class="am am3">
					<img src="images/bg8_2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg8s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		
		<!-- 第8屏 -->
		<div class="swiper-slide page-8">
			<div class="container">
				<div class="am am1">
					<img src="images/bg9_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg9_3.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinY"  />
				</div>
				<div class="am am3">
					<img src="images/bg9_2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg9s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		
		<!-- 第9屏 -->
		<div class="swiper-slide page-9">
			<div class="container">
				<div class="am am1">
					<img src="images/bg10_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="flipinY"  />
				</div>
				<div class="am am2">
					<img src="images/bg10_3.png" class="animation an2" data-item="an2" data-delay="600" data-animation="flipinX"  />
				</div>
				<div class="am am3">
					<img src="images/bg10_2.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="flipinY"  />
				</div>
				<div class="am am4">
					<img src="images/bg10s.png" class="animation an4" data-item="an4" data-delay="2000" data-animation="fadeinL"  />
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		
		<!-- 第10屏 -->
		<div class="swiper-slide page-10">
			<div class="container">
				<div class="am am1">
					<img src="images/bg11.jpg" class="animation an1" data-item="an1" data-delay="100" data-animation="fadeIn"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
       
       

   </div>
</div>
<img src="images/fenxiang.png" class="tcImg hide" id="fx_tips"/>
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
		imgUrl:'http://zt.jia360.com/sxbz_m/images/kc7.jpg',
		link:'http://zt.jia360.com/sxbz_m/index.php',
		desc:"圣象标准门全新系列",
		title:"圣象标准门-悦·色系列"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>

<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/idangerous.swiper.scrollbar-2.0"></script>
<script src="js/my.js?v=1.0"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>