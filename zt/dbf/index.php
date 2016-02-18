<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK("wxd6ddd7ef03d96e23", "800854664b973d99046e809f82fe8e13");//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>腾讯家居·端午节</title>
<meta name="keywords" content="腾讯家居·端午节" />
<meta name="description" content="腾讯家居·端午节" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.2"  />



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

   <div class="swiper-container swiper-pages" id="swiper-container1">
        <div class="swiper-wrapper" id="wrapper">

			<div class="swiper-slide page-1 ps1">
			  <div class="container">
		  		<div class="am am1 bg">
					<img src="images/p1-bg.jpg"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn" />
				</div> 
				<div class="am am2">
					<div class="animation an9" data-item="an9" data-delay="700" data-animation="fadeInDown">
						<img src="images/p1-1.png"  class="animation an2" data-item="an2" data-delay="3100" data-animation="fadeoutB" />
					</div>
					<div class="animation an8 pab" data-item="an8" data-delay="900" data-animation="fadeInDown">
						<img src="images/p1-2.png"  class="animation an3" data-item="an3" data-delay="2900" data-animation="fadeoutB" />
					</div>
					<div class="animation an7 pab" data-item="an7" data-delay="1100" data-animation="fadeInDown">
						<img src="images/p1-3.png"  class="animation an4" data-item="an4" data-delay="2700" data-animation="fadeoutB" />
					</div>
					<div class="pab">
						<img src="images/p1-4.png"  class="animation an5" data-item="an5" data-delay="1300" data-animation="fadeInDown" />
					</div>
					<div class="pab">
						<img src="images/p1-5.png"  class="animation an6" data-item="an6" data-delay="1500" data-animation="fadeInDown" />
					</div>
				</div>
			  </div>
			</div>

			<div class="swiper-slide page-2 ps2">
			  <div class="container">
		  		<div class="am am1 bg">
					<img src="images/p2-bg.jpg"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeIn" />
				</div>
				<div class="am am3">
					<img src="images/gif1.gif?v=1.0"   />
				</div>
				<div class="am am2">
					<div class="animation an9" data-item="an9" data-delay="700" data-animation="fadeInDown">
						<img src="images/p2-1.png"  class="animation an2" data-item="an2" data-delay="3100" data-animation="fadeoutB" />
					</div>
					<div class="animation an8 pab" data-item="an8" data-delay="900" data-animation="fadeInDown">
						<img src="images/p2-2.png"  class="animation an3" data-item="an3" data-delay="2900" data-animation="fadeoutB" />
					</div>
					<div class="animation an7 pab" data-item="an7" data-delay="1100" data-animation="fadeInDown">
						<img src="images/p2-3.png"  class="animation an4" data-item="an4" data-delay="2700" data-animation="fadeoutB" />
					</div>
					<div class="pab">
						<img src="images/p2-4.png"  class="animation an5" data-item="an5" data-delay="1300" data-animation="fadeInDown" />
					</div>
				</div>
				
			  </div>
			</div>
			 
			<div class="swiper-slide page-3 ps3">
			  <div class="container">
			  	<div class="am am1 bg">
					<img src="images/p3-bg.jpg" />
				</div>
			  	<div class="am am3">
					<img src="images/gif2.gif?v=1.0"   />
				</div>
				<div class="am am2">
					<div class="animation an9" data-item="an9" data-delay="700" data-animation="fadeInDown">
						<img src="images/p3-1.png"  class="animation an2" data-item="an2" data-delay="3100" data-animation="fadeoutB" />
					</div>
					<div class="animation an8 pab" data-item="an8" data-delay="900" data-animation="fadeInDown">
						<img src="images/p3-2.png"  class="animation an3" data-item="an3" data-delay="2900" data-animation="fadeoutB" />
					</div>
					<div class="animation an7 pab" data-item="an7" data-delay="1100" data-animation="fadeInDown">
						<img src="images/p3-3.png"  class="animation an4" data-item="an4" data-delay="2700" data-animation="fadeoutB" />
					</div>
					<div class="animation an6 pab" data-item="an6" data-delay="1300" data-animation="fadeInDown">
						<img src="images/p3-4.png"  class="animation an5" data-item="an5" data-delay="2500" data-animation="fadeoutB" />
					</div>
				</div>
				
			  </div>
			</div> 

			<div class="swiper-slide page-4 ps4">
			  <div class="container">
			  	<div class="am am1 bg">
					<img src="images/p3-bg.jpg" />
				</div>
			  	<div class="am am3">
					<img src="images/gif3.gif"   />
				</div>
				<div class="am am2">
					<div class="animation an9" data-item="an9" data-delay="700" data-animation="fadeInDown">
						<img src="images/p4-1.png"  class="animation an2" data-item="an2" data-delay="3100" data-animation="fadeoutB" />
					</div>
					<div class="animation an8 pab" data-item="an8" data-delay="900" data-animation="fadeInDown">
						<img src="images/p4-2.png"  class="animation an3" data-item="an3" data-delay="2900" data-animation="fadeoutB" />
					</div>
					<div class="animation an7 pab" data-item="an7" data-delay="1100" data-animation="fadeInDown">
						<img src="images/p4-3.png"  class="animation an4" data-item="an4" data-delay="2700" data-animation="fadeoutB" />
					</div>
					<div class="animation an6 pab" data-item="an6" data-delay="1300" data-animation="fadeInDown">
						<img src="images/p4-4.png"  class="animation an5" data-item="an5" data-delay="2500" data-animation="fadeoutB" />
					</div>
				</div>
				
			  </div>
			</div> 

			<div class="swiper-slide page-5 ps5">
			  <div class="container">
			  	<div class="am bg">
					<img src="images/p3-bg.jpg" />
				</div>
			  	<div class="am am3">
					<img src="images/gif4.gif"   />
				</div>
				<div class="am am1">
					<img src="images/p5-1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown" />
					
				</div>
				<div class="am am2">
					<img src="images/p5-2.png"  class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInDown" />
					<img src="images/p5-3.png"  class="animation an3 pab" data-item="an3" data-delay="1100" data-animation="fadeInLeft" />
					<img src="images/p5-4.png"  class="animation an4 pab" data-item="an4" data-delay="1100" data-animation="fadeInRight" />
					<img src="images/p5-5.png"  class="animation an5 pab" data-item="an5" data-delay="1300" data-animation="fadeInUp" />
					<img src="images/p5-6.png"  class="animation an6 pab" data-item="an6" data-delay="900" data-animation="fadeInDown" />
				</div>
				<div class="am am4">
					腾讯家居UED出品
				</div>
			  </div>
			</div> 

       </div>
    </div>
    <div class="music" id="music">
		<a href="javascript:void(0)" class="open musicBtn" ></a>
		<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3" ></audio> 
	</div>

<!--     <div class="cn-slidetips">
    <div class="slidetips">
        <a href="javascript:void(0);" title="NEXT" id="next" class="next">
            <img src="images/next.png" />
        </a>
    </div>
</div> -->
        
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.0"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
	//微信分享控制
	document.getElementById("musicBox").play();
	//音乐播放
	$("#music .musicBtn").click(function(){
		
		if($(this).hasClass("open")){
			$(this).removeClass("open").addClass("close");
			musicBox.pause();
		}else{
			$(this).removeClass("close").addClass("open");
			musicBox.play();
		}
	});
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
			"imgUrl":'http://zt.jia360.com/dbf/images/share.jpg?v=1.0',
			"link":'http://zt.jia360.com/dbf',
			"desc":"腾讯家居预祝各位端午父亲节快乐！！",
			"title":"腾讯家居预祝各位端午父亲节快乐！！"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>