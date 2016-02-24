<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>红星美凯龙“2天来了”大牌之夜</title>
<meta name="keywords" content="I won't let you down ，不会让你失望" />
<meta name="description" content="I won't let you down ，不会让你失望" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?version=3.3"  />

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
   <!-- input居然不能放在swiper里面！！！ -->
	 <div class="cn cn4 hide">
		<div class="cp3">
			<p class="cp3-1">留名赢礼遇</p>
			<p class="cp3-2">登记后凭个人信息</p>
			<p class="cp3-2">免费入场参与大牌之夜活动</p>
			<p class="cp3-3">姓名：</p>
			<p class="cp3-4"><input type="text" id= "name" name="name" placeholder="请输入您的姓名" value=""/></p>
	        <p class="cp3-5">手机号码：</p>
	        <p class="cp3-4"><input type="text" id="phone" name="phone" placeholder="请输入您的手机号" value="" /></p>
	        <p class="cp3-5">省份：</p>
	        <p class="cp3-6" id="citylist">
				<select name="prov" class="prov" id="prov">
				</select>
	    		&nbsp;&nbsp;城市:<br/><select name="city" class="city" id="city" disabled="disabled"></select>
	        </p>
	        <p class="cp3-7" id="submit"><img src="images/4-1.png"></p>
		</div>
	</div>
	<!-- end -->
   <div class="swiper-container swiper-pages" id="swiper-container1">
   		<!--音乐  -->
		<div id="music">
			<a href="javascript:void(0)" class="open musicBtn" ></a>
			<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3" ></audio>
		</div>
		<div class="swiper-wrapper" id="wrapper">
			<!--1-->
			<div class="swiper-slide page-1" id="page-1">
				<div class="container">
				  <div class="wraper">
						<div class="p1-1">
						</div>
				  </div>
				</div>
			</div>
			<!--2-->
			<div class="swiper-slide page-2" id="page-2">
				<div class="container">
				  <div class="wraper">
						<div class="p2-1">
						</div>
				  </div>
				</div>
			</div>
			<!--3-->
			<div class="swiper-slide page-3" id="page-3">
				<div class="container" id="page-3-container">
				  <div class="wraper">
						<div class="am am1">
							<img src="images/p3-1.png" date-src="images/p3-1.png" class="containerBg" />
							<img src="images/p3-2.png" date-src="images/p3-2.png" class="containerBg hide" />
							<img src="images/p3-3.png" date-src="images/p3-3.png"  class="containerBg hide" />
							<img src="images/p3-4.png" date-src="images/p3-4.png"  class="containerBg hide" />
							<img src="images/p3-5.png" date-src="images/p3-5.png"  class="containerBg hide" />
							<div class="swiper-container animation an1" id="swiper-container2" data-item="an1" data-delay="200" data-animation="fadeInLeft">
								<div class="swiper-wrapper">
									<div class="swiper-slide"><img src="images/p3-1-c.png" date-src="images/p3-1-c.png" class="a6"></div>
									<div class="swiper-slide"><img src="images/p3-2-c.png" date-src="images/p3-2-c.png" class="a1"></div>
									<div class="swiper-slide"><img src="images/p3-3-c.png" date-src="images/p3-3-c.png" class="a2"></div>
									<div class="swiper-slide"><img src="images/p3-4-c.png" date-src="images/p3-4-c.png" class="a3"></div>
									<div class="swiper-slide"><img src="images/p3-5-c.png" date-src="images/p3-5-c.png" class="a4"></div>
								</div>
							</div>
							<a class="arrow-left arrow"></a>
							<a class="arrow-right arrow"></a>
						</div>
				  </div>
				</div>
			</div>
			<!--4-->
			<div class="swiper-slide page-4" id="page-4">
				<div class="container">
					<div class="wraper">
						<div class="p4-1">
						</div>
					</div>
				</div>
			</div>
			<!--5-->
			<div class="swiper-slide page-5" id="page-5">
				<div class="container">
					<div class="wraper">
						<!-- 活动摇一摇 START-->
							<div class="main">
								<!-- 首页 -->
								<div class="cn cn1">
									<div class="click"><img src="images/1-2.png" style="width: 200px;"></div>
								</div>
								<!-- 摇一摇 -->
								<div class="cn cn2 hide">
									<div class="yao handImg"><img src="images/yao.png"></div>
								</div>
								<!-- 摇一摇礼品 -->
								<div class="cn cn3 hide">
									<div class="cp1">
										<span class="num"></span>
										<span class="guide"><img src="images/3-3.png" class="animate"></span>
									</div>
									<span class="cp2" id="sure"><img src="images/3-2.png"></span>

								</div>
								<!-- 二维码居然不能放在swiper里面！！！ -->
								<div class="cn cn5 hide">
									<img src="images/5-2.jpg">
									<img src="images/share1.png" class="share hide">
									<!--#include virtual="/public/Copyright.html"-->
								</div>
							</div>
						<!-- end -->


					</div>
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
<script type="text/javascript" src="js/jquery.cityselect.js"></script>
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
			"imgUrl":'http://zt.jia360.com/lt_m/images/1-1.png',
			"link":'http://zt.jia360.com/lt_m/index.php',
			"desc":"I won't let you down ，不会让你失望",
			"title":"2天来了"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>