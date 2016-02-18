<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然木门-520食木族来了</title>
<meta name="keywords" content="大自然木门-520食木族来了" />
<meta name="description" content="大自然木门-520食木族来了" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.3"  />
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
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
			    <div class="am am3">
					<img src="images/a1_1.png" class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"  />
				</div>
				<div class="am am4">
					<img src="images/a0_1.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="fadeInDown"  />
				</div>

                <div class="next">
					<img src="images/next.png" />
				</div>


			</div>
		</div>
	
		<!-- 第2屏 -->
		<div class="swiper-slide page-2">
			<div class="container">
				<div class="am am1">
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/a1_1.png" class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"  />
				</div>
				<div class="am am4">
					<img src="images/a1_2.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInRight"/>
				</div>
				<div class="am am5">
					<img src="images/a1_4.png" class="animation an5" data-item="an5" data-delay="1400" data-animation="fadeInRight"  />
				</div>
                <div class="am am6">
					<img src="images/a1_3.png" class="animation an6" data-item="an6" data-delay="2600" data-animation="fadeInLeft"  />
				</div>
                <div class="am am7">
              
					<img src="images/a1_5.png" class="animation an7" data-item="an7" data-delay="2200" data-animation="fadeInLeft"  />
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
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
			    <div class="am am3">
					<img src="images/a1_1.png" class="animation an3" data-item="an3" data-delay="800" data-animation="bounceIn"  />
				</div>
				<div class="am am4">
					<img src="images/zj_1.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="fadeInDown"  />
				</div>
				<div class="am am5">
					<img src="images/zj_2.png" class="animation an5" data-item="an5" data-delay="1600" data-animation="fadeInDown"  />
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
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/a2_1.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="bounceIn"/>
				</div>
                <div class="am am4">
					<img src="images/a2_2.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn"/>
				</div>
                <div class="am am5">
					<img src="images/a2_3.png" class="animation an5" data-item="an5" data-delay="1400" data-animation="bounceInLeft"/>
				</div>
                <div class="am am6">
					<img src="images/a2_4.png" class="animation an6" data-item="an6" data-delay="1600" data-animation="bounceInRight"/>
				</div>
                <div class="am am7">
					<img src="images/a2_5.png" class="animation an7" data-item="an7" data-delay="2200" data-animation="fadeInUp"/>
				</div>
                <div class="am am8">
                <div class="next"></div>
					<img src="images/a2_6.png" class="animation an8 button" data-item="an8" data-delay="2400" data-animation="fadeInUp"/>
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
                  <img src="images/zcbt.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown"/>
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
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
                   <img src="images/a3_1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight"  />
				</div>
                <div class="am am4">
					<img src="images/a3_2.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInRight"  />
				</div>
                <div class="am am5">
					<img src="images/a3_4.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="bounceIn"  />
				</div>
                <div class="am am6">
					<img src="images/a3_5.png" class="animation an6" data-item="an6" data-delay="1200" data-animation="bounceIn"  />
				</div>
                <div class="am am7">
					<img src="images/a3_6.png" class="animation an7" data-item="an7" data-delay="2000" data-animation="fadeInRight"  />
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
					<img src="images/logo1.jpg" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn"  />
				</div>
				<div class="am am2">
					<img src="images/logo2.jpg" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/a4_1.png" class="animation an3" data-item="an3" data-delay="500" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a4_2.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInUp"  />
				</div>
                <div class="am am5">
					<img src="images/a4_3.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="bounceIn"  />
				</div>
                <div class="am am6">
					<img src="images/a4_4.png" class="animation an6" data-item="an6" data-delay="1200" data-animation="bounceIn"  />
				</div>
                <div class="am am7">
					<img src="images/a4_5.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="bounceIn"  />
				</div>
                <div class="am am8">
					<img src="images/a4_6.png" class="animation an8" data-item="an8" data-delay="1600" data-animation="fadeInDown"  />
				</div>
                <div class="am am9">
					<img src="images/a4_7.png" class="animation an9 shareBtn" data-item="an9" data-delay="1800" data-animation="fadeInDown"  />
				</div>
                <div class="am am10">
					<img src="images/wx1.jpg" class="animation an10" data-item="an10" data-delay="2000" data-animation="fadeInDown"  />
				</div>
                <div class="am am11">
					<img src="images/wx2.jpg" class="animation an11" data-item="an11" data-delay="2200" data-animation="fadeInDown"  />
				</div>
                <div class="am am12">
					<img src="images/a4_8.png" class="animation an12" data-item="an12" data-delay="2400" data-animation="fadeInDown"  />
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
		imgUrl:'http://zt.jia360.com/dzr520/images/a1_1.png',
		link:'http://zt.jia360.com/dzr520/index.php',
		desc:"大自然木门-520食木族来了",
		title:"大自然木门-520食木族来了"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>

<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/idangerous.swiper.scrollbar-2.0"></script>
<script src="js/my.js"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>