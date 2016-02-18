<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然地板健身强心亲子运动会</title>
<meta name="keywords" content="大自然 地板 健身强心 亲子 运动会" />
<meta name="description" content="大自然 地板 健身强心 亲子 运动会" />
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
			<!--首页-->
			<div class="swiper-slide page-1 ps1">
			  <div class="container">
		  		<div class="am am1 bg">

				</div>
				<div class="am am2 logo">
					<img src="images/logo.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown" />
				</div>
				<div class="am am3">
					<img src="images/logo2.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
		                <img src="images/banner.png"  class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next" class="click-btn">
		                <img src="images/tip.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
		            </a>
				</div>
				<div class="am am6">
		                <img src="images/title.png"  class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>

			  </div>
			</div>

			<!--page2-->
			<div class="swiper-slide page-2 ps2">
			  <div class="container2">
		  		<div class="am am1 bg">

				</div>
				<div class="am am3">
					<img src="images/title2.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/cir.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am6 animation an4"  data-item="an4" data-delay="500" data-animation="fadeInDown">
					<img src="images/hand.png" />
				</div>
				<div class="am am7 animation an4"  data-item="an5" data-delay="800" data-animation="fadeInDown">
					<img src="images/num.png" />
				</div>
				<div class="am am8 animation an4"  data-item="an6" data-delay="1100" data-animation="fadeInDown">
					<img src="images/t1.png" />
				</div>
				<div class="am am9">
					<img src="images/star1.png" class="animation an7"  data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am10">
					<img src="images/star2.png" class="animation an8"  data-item="an8" data-delay="1700" data-animation="fadeInDown"/>
				</div>
				<div class="am am11" >
					<img src="images/star3.png" class="animation an9"  data-item="an9" data-delay="2000" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next2" class="click-btn">
		                <img src="images/tip.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
		            </a>
				</div>
			  </div>
          	</div>

			<!--page3-->
			<div class="swiper-slide page-3 ps3">
			  <div class="container3">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title3.png"  />
				</div>
				<div class="am am3">
					<img src="images/hins.png"/>
				</div>

				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next3" class="click-btn">
		                <img src="images/tip.png" />
		            </a>
				</div>
				<div class="am am6 swiper-container3">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="images/turn1.png"/></div>

						<div class="swiper-slide"><img src="images/turn2.png" /></div>

						<div class="swiper-slide"><img src="images/turn3.png" /></div>

						<div class="swiper-slide"><img src="images/turn4.png" /></div>
					</div>
				</div>


				<div class="am am8">
					<img src="images/fish.png" />
				</div>
				<div class="am am9">
					<img src="images/fish2.png" />
				</div>
			  </div>
			</div>

             <!--page4-->
            <div class="swiper-slide page-4 ps4">
			  <div class="container4">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title4.png"  />
				</div>
				<div class="am am3 swiper-container2" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="images/pic1.png" /></div>

						<div class="swiper-slide"><img src="images/pic2.png" /></div>

						<div class="swiper-slide"><img src="images/pic3.png" /></div>
					</div>
					<div class="am am7 swiper-button-next">
						<a href="javascript:void(0);"  id="p-next" class="click-btn">
			                <img src="images/btnr.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
			            </a>
					</div>
					<div class="am am8 swiper-button-prev">
						<a href="javascript:void(0);"  id="p-pre" class="click-btn">
			                <img src="images/btnl.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
			            </a>
					</div>
				</div>

				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next4" class="click-btn">
		                <img src="images/tip.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
		            </a>
				</div>

			  </div>
			</div>

			<!--page5-->
			<div class="swiper-slide page-5 ps5">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title6.png"  />
				</div>
				<div class="am am3">
					<img src="images/code.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/cam.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next5" class="click-btn">
		                <img src="images/tip.png"/>
		            </a>
				</div>
				<div class="am am6">
					<img src="images/t2.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am8">
					<img src="images/leave1.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am9">
					<img src="images/leave2.png" class="animation an6" data-item="an6" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am10">
					<img src="images/leave3.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am11">
					<img src="images/leave4.png" class="animation an8" data-item="an8" data-delay="1700" data-animation="fadeInDown"/>
				</div>
				<div class="am am12">
					<img src="images/leave5.png" class="animation an9" data-item="an9" data-delay="2000" data-animation="fadeInDown"/>
				</div>
			  </div>
			</div>

			 <!--page6-->
            <div class="swiper-slide page-6 ps6">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title6.png"  />
				</div>
				<div class="am am3">
					<img src="images/t3.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/t6.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>

				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next6" class="click-btn">
		                <img src="images/tip.png"/>
		            </a>
				</div>
				<div class="am am6">
					<img src="images/snap3.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am7">
					<img src="images/leave8.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am8">
					<img src="images/leave2.png" class="animation an6" data-item="an6" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am9">
					<img src="images/leave11.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>

			  </div>
			</div>

			<!--page7-->
			<div class="swiper-slide page-7 ps7">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title6.png"  />
				</div>
				<div class="am am3">
					<img src="images/t3.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/t4.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>

				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next7" class="click-btn">
		                <img src="images/tip.png"/>
		            </a>
				</div>
				<div class="am am6">
					<img src="images/snap1.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am7">
					<img src="images/snap2.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am8">
					<img src="images/leave6.png" class="animation an6" data-item="an6" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am9">
					<img src="images/leave7.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am10">
					<img src="images/leave8.png" class="animation an8" data-item="an8" data-delay="1700" data-animation="fadeInDown"/>
				</div>

			  </div>
			</div>

			<!--page8-->
            <div class="swiper-slide page-8 ps8">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/title5.png"  />
				</div>
				<div class="am am3">
					<img src="images/t5.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/box.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>

			  </div>
			</div>




       </div>
    </div>
    <!--div class="cn-slidetips">
        <div class="slidetips">
            <a href="javascript:void(0);" title="NEXT" id="next" class="next">
                <img src="images/next.png" />
            </a>
        </div>
    </div-->

<script src="js/zepto.min.js"></script>
<script src="js/touch.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.0"></script>
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
			"imgUrl":'http://zt.jia360.com/dzr_ydh/images/share.jpg',
			"link":'http://zt.jia360.com/dzr_ydh',
			"desc":"大自然地板健身强心亲子运动会，爸爸享受3%返利特权，参加大自然地板活动更有机会跟着《爸爸去哪儿》去旅行。",
			"title":"这个周末我和爸爸约惠大自然",
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>

<!--#include virtual="/public/tongji.html"-->

</body>
</html>