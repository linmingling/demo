<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>腾讯家居 携手家未来</title>
<meta name="keywords" content="腾讯家居 携手家未来" />
<meta name="description" content="腾讯家居 携手家未来" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.0"  />

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
			  		<div class="am am6">
						<img src="images/p1-2.png?v=1.0" class="layer" data-depth="0.3"/>
					</div>
					<div class="am am1">
						<img src="images/logo1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInLeft"  />
					</div>
					<div class="am am2">
						<img src="images/logo2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInRight"  />
					</div>
					
					<div class="am am3">
						<img src="images/p1-3.png?v=1.1" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"  />
					</div>
					<div class="am am4 animation an5"  data-item="an5" data-delay="800" data-animation="bounceIn">
						<p>中国·广州</p>
						<p>2015.7.7</p>
					</div>
					<div class="am am5">
						<div class="layer" data-depth="0.8">
							<img src="images/p1-1.png"  />
						</div>
					</div>
			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2">
			  <div class="container">
					<div class="am am2">
						<div class="layer" data-depth="0.8">
							<img src="images/p1-1.png"  />
						</div>
					</div>
					<div class="am am1">
						<p class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInLeft">尊敬的阁下：</p>
						<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">我们诚挚的邀请您于2015年7月7日14:00点参加在广州香格里拉酒店一楼北江宴会厅举行的“携手家未来”— 亚太传媒2.7亿融资成功新闻
发布会暨第二届七夕家装节战略发布会</p>
						<img src="images/p2-1.png"  class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInLeft" />
						<p class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">PART1：亚太传媒新起航</p>
						<p class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInLeft">PART2：家居资本论坛<span>（家居行业如何获得资本青睐）</span</p>
						<p class="animation an6" data-item="an6" data-delay="1200" data-animation="fadeInLeft">PART3：家居生态圈新构想</p>
						<p class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInLeft">PART4：第二届七夕家装节战略发布仪式</p>
						<p class="animation an8" data-item="an8" data-delay="1600" data-animation="fadeInLeft">PART5：第二届七夕家装节亮点推介</p>
					</div>
					
			  </div>             
		  </div>

		  <div class="swiper-slide page-3 ps3">
			  <div class="container">
			  		<div class="am am2">
						<div class="layer" data-depth="0.8">
							<img src="images/p1-1.png"  />
						</div>
					</div>
					<div class="am am1">
						<img src="images/p3-1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown" />
						<img src="images/p3-4.png?v=1.0"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown" />
						<!-- <img src="images/p3-3.png"  class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown" /> -->
					</div>
			  </div>           
		  </div>

		  <div class="swiper-slide page-4 ps6">
			  <div class="container">
			  		<div class="am am2">
						<div class="layer" data-depth="0.8">
							<img src="images/p1-1.png"  />
						</div>
					</div>
					<div class="am am1">
						<img src="images/p3-1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown" />
						<img src="images/p3-5.png?v=1.0"  class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown" />
					</div>
			  </div>           
		  </div>
		  
		  <div class="swiper-slide page-5 ps4">
			  <div class="container">
					<div class="am am1">
						<img src="images/p4-1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown" />
						<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">广州市海珠区会展东路1号香格里拉酒店</p>
						<p class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInLeft">(琶洲国际会展中心-琶洲地铁站A出口)</p>
						<img src="images/p4-2.png?v=1.0"  class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown" />
						<p class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInLeft">℡客服热线：0755-26605039-8011</p>
						<p class="animation an6" data-item="an6" data-delay="1200" data-animation="fadeInLeft">15920082057（严生）</p>
						<p class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInLeft">主办单位：亚太传媒　腾讯家居</p>
						<img src="images/p4-3.png" id="goto5"  class="animation an8" data-item="an8" data-delay="1600" data-animation="fadeInDown" />
						
					</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-6 ps5">
			  <div class="container">
					<div class="am am2">
						<div class="layer" data-depth="0.8">
							<img src="images/p1-1.png"  />
						</div>
					</div>
					<div class="am am1">
						<img src="images/p5-2.png"  class="p5-title" />
						<p>仅限300席</p>
					</div>
			  </div>                    
		  </div>
   </div>
</div>
<div class="cn-slidetips next">
    <div class="slidetips">
        <a href="javascript:void(0);" title="NEXT" id="next">
            <img src="images/next.png" />
        </a>
    </div>
</div>

<div class="form hide" id="form">
	<p>您的公司</p>
	<p class="inputP"><input type="text" id="company" class="company" placeholder="请填写您的公司名"/></p>
	<p>姓名</p>
	<p class="inputP"><input type="text" id="name" class="name" placeholder="请填写您的姓名"/></p>
	<p>联系方式</p>
	<p class="inputP"><input type="text" id="tel" class="tel" placeholder="请填写您的联系方式"/></p>
	<img src="images/p5-1.png" id="bm" />
</div>

<div class="shareTips hide" id="shareTips">
	<img src="images/share-tips.png"/>
</div>
<!--音乐  -->
<div id="music">
	<a href="javascript:void(0)" class="open musicBtn" ></a>
	<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
</div>

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/jquery.parallax.min.js"></script>
<script src="js/my.js?v=1.1"></script>

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
		"imgUrl":'http://zt.jia360.com/invitation/images/share.jpg?v=1.0',
		"link":'http://zt.jia360.com/invitation/index.php',
		"desc":"携手家未来——亚太传媒2.7亿融资成功新闻发布会暨第二届七夕家装节战略发布会",
		"title":"携手家未来——亚太传媒2.7亿融资成功新闻发布会暨第二届七夕家装节战略发布会",
		success: function (res) {
			$("#shareTips").hide();
		}
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>