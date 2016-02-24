<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK("wxd6ddd7ef03d96e23", "800854664b973d99046e809f82fe8e13");//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>芬琳漆2015年新品闪亮登陆</title>
<meta name="keywords" content="芬琳漆 2015年新品 闪亮登陆" />
<meta name="description" content="芬琳漆 2015年新品 闪亮登陆" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.1"  />



</head>
<body>
    <div class="cn-spinner" id="loading">
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
	<!-- 擦一擦 -->
	<div id="lotteryContainer" class="lotteryContainer"></div>
   <div class="swiper-container swiper-pages" id="swiper-container1">
        <div class="swiper-wrapper" id="wrapper">

			<div class="swiper-slide page-1 ps1">
			  <div class="container">
		  		<div class="am am1 bg">
					<img src="images/p1-bg.jpg"  />
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p1-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
			  </div>
			</div>

			<div class="swiper-slide page-2 ps2">
			  <div class="container">
		  		<div class="am am1 bg">
					<img src="images/p2-bg.jpg"  />
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p2-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
			  </div>
          	</div>

			<div class="swiper-slide page-3 ps3" id="ps3">
			  <div class="container">
				<div class="am am1 bg">
					<img src="images/p3-bg.jpg"  />
				</div>
				<div class="am am3">
					<img src="images/p3-3.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
					<span  class="animation an4" data-item="an4" data-delay="200" data-iteration-count="infinite" data-duration="1800" data-timing-function="linear" data-animation="dots"></span>
				</div>
				<div class="am am4">
					<img src="images/p3-1.jpg"/>
				</div>
				<div class="am am5">
					<img src="images/p3-2.jpg"/>
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
			  </div>
			</div>
             
            <div class="swiper-slide page-4 ps4">
			  <div class="container">
				<div class="am am1 bg">
					<img src="images/p4-bg.jpg"  />
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am5">
					<img src="images/p4-2.jpg" class="animation an5" data-item="an5" data-delay="400" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/p4-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<p class="animation an4" data-item="an4" data-delay="600" data-animation="fadeInDown">
						◇ 芬兰原装进口
					</p>
					<p class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown">
						◇ 拥有芬兰M1环保认证
					</p>
					<p class="animation an6" data-item="an6" data-delay="1000" data-animation="fadeInDown">
						◇ 水性特殊效果漆
					</p>
					<p class="animation an7" data-item="an7" data-delay="1200" data-animation="fadeInDown">
						◇ 白天吸收阳光 在夜晚发出荧光
					</p>
				</div>
			  </div>
			</div>

			<div class="swiper-slide page-5 ps5">
			  <div class="container">
				<div class="am am1 bg">
					<img src="images/p5-bg.jpg"  />
				</div>
				
			  </div>
			</div>

			<div class="swiper-slide page-6 ps6" id="ps6">
			  <div class="container">
				<div class="am am1 bg">
					<img src="images/p6-bg.jpg"  />
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p6-1.png" class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp"/>
					<img src="images/p6-1-2.png" class="animation an3" data-item="an3" data-delay="1200" data-animation="fadeInUp"/>
				</div>
				<div class="am am4">
					<img src="images/p6-2.png?v=1.0" class="animation an4" data-item="an4" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am5 produce">
					<span class="animation an5" data-item="an5" data-delay="200" data-iteration-count="infinite" data-duration="2000" data-animation="bigSmall">+</span>
					<img src="images/p6-4.png?v=1.0" class="productImg hide" />
				</div>
				<div class="am am6 produce">
					<span class="animation an6" data-item="an6" data-delay="500" data-iteration-count="infinite" data-duration="2000" data-animation="bigSmall">+</span>
					<img src="images/p6-3.png?v=1.0" class="productImg hide" />
				</div>
			  </div>
			</div>

			<div class="swiper-slide page-7 ps7">
			  <div class="container">
				
				<div class="am am2">
					<img src="images/p7-2.png" class="animation an2" data-item="an2" data-delay="200" data-duration="2000" data-animation="hand"/>
				</div>
				<div class="am am3">
					<img src="images/p7-1.png"/>
				</div>
				<div class="am am4">
					<img src="images/p7-3.png?v=1.0" class="animation an3" data-item="an3" data-delay="2000" data-animation="bounceIn"/>
				</div>
				<div class="am am1 logo">
					<img src="images/logo.png"  />
				</div>
			  </div>
			</div>

			<div class="swiper-slide page-8 ps8">
			  <div class="container">
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<p class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown">
						TIKKURILA INSPIRES YOU
					</p>
					<p class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown">
						TO COLOR YOUR LIFE.<span class="small">TM</span>
					</p>
				</div>
				<div class="am am4">
					<img src="images/p8-1.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
			  </div>
			</div>
			  
			  
       </div>
    </div>
    <div class="cn-slidetips">
        <div class="slidetips">
            <a href="javascript:void(0);" title="NEXT" id="next" class="next">
                <img src="images/next.png" />
            </a>
        </div>
    </div>
        
<script src="js/zepto.min.js"></script>
<script src="js/touch.js"></script>
<script src="js/fx.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js"></script>
<script src="js/Lottery.js" type="text/javascript" charset="utf-8"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
	//首屏掀开效果
	var flag = 0;
	var h = $(window).height();
	var w = $(window).width();
	var lottery = new Lottery('lotteryContainer', 'images/p5-tu.jpg', 'image', w, h);
	lottery.init('images/p5-bg.jpg', 'image');
	function draw() {
		if(flag){
			

			setTimeout(function(){
				$("#lotteryContainer").animate({"filter":"alpha(opacity=0)","-moz-opacity":"0","opacity":"0"},500,function(){
					$("#lotteryContainer").hide();
					$(".cn-slidetips").show()
				});
			
			},2000);
		}
	}
	$("#lotteryContainer canvas").mousedown(function(){
		flag = 1;
		draw();
	});
	$("#lotteryContainer canvas").bind("touchstart",function(event){
		flag = 1;
		draw();
	  });


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
			"imgUrl":'http://zt.jia360.com/tikkurila/images/share.jpg',
			"link":'http://zt.jia360.com/tikkurila',
			"desc":"点击打开通往斯堪的纳维亚浪漫的探索之旅！",
			"title":"芬琳漆2015年新品闪亮登陆"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>