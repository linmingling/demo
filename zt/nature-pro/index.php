<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然朦胧时光地板微评测</title>
<meta name="keywords" content="大自然朦胧时光地板微评测" />
<meta name="description" content="大自然朦胧时光地板微评测" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css" />

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
	<div class="swiper-wrapper" id="wrapper">

		  <div class="swiper-slide page-1 ps1">
			  <div class="container">
			  		<div class="am am1">
						<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am2">
						<img src="images/title.png" class="animation an2" data-item="an2" data-delay="800" data-animation="bounceIn" />
					</div>
					<div class="am am3">
						<img src="images/cir.png" class="animation an3" data-item="an3" data-delay="1600" data-animation="bounceIn" />
					</div>
					<div class="cn-slidetips next">
					    <div class="slidetips">
					        <a href="javascript:void(0);" title="NEXT">
					            <img src="images/tips.png" />
					        </a>
					    </div>
					</div>

			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2">
			  <div class="container2">
			  		<div class="am am1">
						<img src="images/title2.png" />
					</div>
					<div class="am am2">
						<img src="images/line.png" />
					</div>
					<div class="am am3">
						<img src="images/t1.png" class="animation an3" data-item="an3" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am4">
						<img src="images/pic1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown" />
					</div>
					<div class="am am5">
						<img src="images/t2.png" class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInDown" />
					</div>
					<div class="cn-slidetips next">
					    <div class="slidetips">
					        <a href="javascript:void(0);" title="NEXT">
					            <img src="images/tip2.png" />
					        </a>
					    </div>
</div>
			  </div>             
		  </div>

		  <div class="swiper-slide page-3 ps3">
			  <div class="container3">
			  		<div class="am am1">
						<img src="images/title3.png" />
					</div>
					<div class="am am2">
						<img src="images/line.png" />
					</div>
					<div class="am am3">
						<img src="images/p1.png" class="animation an3" data-item="an3" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am4">
						<img src="images/tree.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown" />
					</div>
					<div class="am am5">
						<img src="images/in1.png" class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInDown" />
					</div>
					<div class="am am6">
						<img src="images/in2.png" class="animation an6" data-item="an6" data-delay="1600" data-animation="fadeInDown" />
					</div>
					<div class="am am7">
						<img src="images/in3.png" class="animation an7" data-item="an7" data-delay="2000" data-animation="fadeInDown" />
					</div>
					<div class="am am8">
						<img src="images/in4.png" class="animation an8" data-item="an8" data-delay="2400" data-animation="fadeInDown" />
					</div>
					<div class="am am9">
						<img src="images/in5.png" class="animation an9" data-item="an9" data-delay="2800" data-animation="fadeInDown" />
					</div>
					<div class="am am10">
						<img src="images/in6.png" class="animation an10" data-item="an10" data-delay="3200" data-animation="fadeInDown" />
					</div>
					<div class="am am11">
						<img src="images/detail.png" class="animation an11" data-item="an11" data-delay="3600" data-animation="fadeInDown" />
					</div>
					<div class="detail"></div>
					 <!-- 弹出层 -->

					<div class="d-box hide" id="d-box">
						<div class="bg"><img src="images/blur1.jpg" class="blur1" /></div>
					    <img src="images/po1.png"/>
						<div class="close"></div>
					</div>

					<div class="cn-slidetips next">
    <div class="slidetips">
        <a href="javascript:void(0);" title="NEXT" >
            <img src="images/tip2.png" />
        </a>
    </div>
</div>

			  </div>           
		  </div>

		  <div class="swiper-slide page-4 ps4">
			  <div class="container4">
			  		<div class="am am1">
						<img src="images/title4.png" />
					</div>
					<div class="am am2">
						<img src="images/line.png" />
					</div>
					<div class="am am3">
						<img src="images/p2.png" class="animation an3" data-item="an3" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am4">
						<img src="images/t3.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown" />
					</div>
					<div class="am am5">
						<img src="images/t4.png" class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInDown" />
					</div>
					<div class="am am6">
						<img src="images/detail.png" class="animation an6" data-item="an6" data-delay="1600" data-animation="fadeInDown" />
					</div>
					<div class="detail1"></div>
				<div class="d-box hide" id="d-box2">
						<div class="bg"><img src="images/blur2.jpg" class="blur2" /></div>
					    <img src="images/po2.png"/>
						<div class="close"></div>
					</div>
					<div class="cn-slidetips next">
					    <div class="slidetips">
					        <a href="javascript:void(0);" title="NEXT" >
					            <img src="images/tip2.png" />
					        </a>
					    </div>
					</div>
			  </div>           
		  </div>


		  <div class="swiper-slide page-5 ps5">
			  <div class="container5">
			  		<div class="am am1">
						<img src="images/title5.png" />
					</div>
					<div class="am am2">
						<img src="images/line.png" />
					</div>
					<div class="am am3">
						<img src="images/t5.png" class="animation an3" data-item="an3" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am4">
						<img src="images/t6.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown" />
					</div>
						<div class="cn-slidetips next">
						    <div class="slidetips">
						        <a href="javascript:void(0);" title="NEXT" >
						            <img src="images/tip2.png" />
						        </a>
						    </div>
						</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-6 ps6">
			  <div class="container6">
					<div class="cn-slidetips next">
					    <div class="slidetips">
					        <a href="javascript:void(0);" title="NEXT" >
					            <img src="images/tip2.png" />
					        </a>
					    </div>
					</div>
			  </div>                    
		  </div>
   </div>
</div>




 <!--音乐  -->
<!-- <div id="music">
	<a href="javascript:void(0)" class="open musicBtn" ></a>
	<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
</div> -->


<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/jquery.parallax.min.js"></script>
<script src="js/my.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
   $(".detail").click(function(){
		$("#d-box").show();
	});
	$("#d-box .close").click(function(){
		$("#d-box").hide();
	});

	$(".detail1").click(function(){
		$("#d-box2").show();
	});
	$("#d-box2 .close").click(function(){
		$("#d-box2").hide();
	});



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
			"imgUrl":'http://zt.jia360.com/nature-pro/images/zhuanfa.png',
			"link":'http://zt.jia360.com/nature-pro/',
			"desc":"朦胧时光VT39013外观较平实，灰白色给人以朦胧的浪漫感觉，与国际流行花色接轨，时尚气息十足。",
			"title":"大自然朦胧时光地板微评测"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>