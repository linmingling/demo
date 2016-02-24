<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
echo "<script>alert('活动已结束！')</script>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>920全民智爱告白行动</title>
<meta name="keywords" content="920·九牧全民智爱告白行动" />
<meta name="description" content="920·九牧全民智爱告白行动" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.2"  />



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

              <div class="swiper-slide page-1">
				  <div class="container">
					<div class="am am1">
						<img src="images/p1-1.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown"/>
					</div>
					<div class="next">
						<img src="images/next.png"/>
					</div>
				  </div>
              </div>

              <div class="swiper-slide page-2">
				  <div class="container">
					<div class="am am1">
						<img src="images/p2-1.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown"/>
					</div>
					<div class="next">
						<img src="images/next.png"/>
					</div>
				  </div>
			  </div>

			  <div class="swiper-slide page-3">
				  <div class="container">
					<div class="am am1">
						<img src="images/p3-1.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown"/>
					</div>
					<div class="next">
						<img src="images/next.png"/>
					</div>
				  </div>
			  </div>
			  <div class="swiper-slide page-4">
				  <div class="container">
					<div class="am am1 animation an1">

						<p class="animation an1"  data-item="an1" data-delay="500" data-animation="fadeInDown">快节奏的<span class="yellow f20">生活</span></p>
						<p class="animation an2"  data-item="an2" data-delay="1500" data-animation="fadeInDown"><span class="yellow f20">体贴</span>变得敷衍</p>
						<p class="animation an3"  data-item="an3" data-delay="2500" data-animation="fadeInDown">繁忙的<span class="yellow f20">工作</span></p>
						<p class="animation an4"  data-item="an4" data-delay="3500" data-animation="fadeInDown">问候成了奢望</p>
						<p class="animation an5 f25"  data-item="an5" data-delay="4500" data-animation="fadeInDown">你</p>
						<p class="animation an6"  data-item="an6" data-delay="5500" data-animation="fadeInDown">有多久<span class="yellow f20">没有关心过</span>身边的家人</p>
						<img src="images/p4-2.png"  class="animation an7"  data-item="an7" data-delay="6500" data-animation="fadeInDown" />
					</div>
					<div class="next">
						<img src="images/next.png"/>
					</div>
				  </div>
			  </div>
			  <div class="swiper-slide page-5">
				  <div class="container">
					<div class="am am1 ">
						<img src="images/p5-1.jpg" class="animation an1" data-item="an1" data-delay="500" data-animation="fadeInDown" />
						<p class="animation an2" data-item="an2" data-delay="1500" data-animation="fadeInDown">秉承“<span class="yellow">让科技更懂生活</span>”的理念</p>
						<p class="animation an3" data-item="an3" data-delay="2500" data-animation="fadeInDown">致力于打造智能卫浴带来的高端舒适体验</p>
						<p class="animation an4" data-item="an4" data-delay="3500" data-animation="fadeInDown">为您的家人</p>
						<p class="animation an5 f20" data-item="an5" data-delay="4500" data-animation="fadeInDown">送上<span class="yellow">智爱</span>的问候</p>
					</div>
					<div class="next">
						<img src="images/next.png"/>
					</div>
				  </div>
			  </div>

			  <div class="swiper-slide page-6">
				  <div class="container">
					<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown">
						<img src="images/p6-1.png" class="p6-1" />
						<p>为您致爱的人写上您的关爱告白，就有</p>
						<p>机会获得九牧智能马桶盖等精美礼品。</p>
						<div class="btnBox" id="btn">
							<img src="images/p6-2.png" class="btn"/>
							<img src="images/p6-3.png" class="heart"/>
						</div>
					</div>
					<p class="am am2">腾讯网·亚太家居UED</p>
				  </div>
			  </div>
			  <div class="swiper-slide page-7">
				  <div class="container">

				  </div>
			  </div>





       </div>
    </div>

    <!-- 填写资料 -->
	<div class="form hide" id="form">
		<div class="formWarp">
			<img src="images/form-title.png" class="formTitle" />
			<p class="p1">请填写你的告白内容，我们将把你的爱传递给<span class="pink">TA</span></p>
			<textarea class="textarea"></textarea>
			<p class="p2">请填写告白对象信息，<span class="pink">TA</span>将收到意想不到的惊喜</p>
			<p class="f15 p3"><span class="pink">TA</span>的称呼:</p>
			<input type="name" class="name"  />
			<p class="f15 p4">联系电话：</p>
			<input type="phone" class="phone"  />
			<span class="btn">我要提交</span>
		</div>
		<div class="success hide">
			<div class="blackBg"></div>
			<div class="successWarp">
				<img src="images/success-bg.jpg" class="successBg" />
				<div class="text">
					<p class="sp1">你爱的<span class="pink">TA</span>就有机会获得</p>
					<p class="sp2"><span class="pink">九牧智能盖板</span>等精美礼品</p>
					<span class="sbtn">返回</span>
				</div>
			</div>
		</div>
	</div>

	<!--音乐  -->
	<div id="music">
		<a href="javascript:void(0)" class="open musicBtn" ></a>
		<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
	</div>

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.2"></script>
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
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			"imgUrl":'http://zt.jia360.com/jomoo/images/share.jpg?v=1.0',
			"link":'http://zt.jia360.com/jomoo/index.php',
			"title":"920全民智爱告白行动",
			"desc":"920全民智爱告白行动，将你的爱传递给致爱的TA，你还等什么？"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>

<!--#include virtual="/public/tongji.html"-->

</body>
</html>