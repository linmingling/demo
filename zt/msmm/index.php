<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK("wxd6ddd7ef03d96e23", "800854664b973d99046e809f82fe8e13");//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>慕思床垫6月除螨抽签</title>
<meta name="keywords" content="慕思床垫 6月除螨 抽签" />
<meta name="description" content="慕思床垫 6月除螨 抽签" />
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
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/title-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
		                <img src="images/click-btn.png"  class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next" class="click-btn">
		                <img src="images/title-2.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
		            </a>
				</div>
				<div class="am am6">
		                <img src="images/title-3.png"  class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am7">
		                <img src="images/copyright.png"  class="animation an6" data-item="an6" data-delay="1100" data-animation="fadeInDown"/>
				</div>
			  </div>
			</div>

			<!--page2-->
			<div class="swiper-slide page-2 ps2">
			  <div class="container">
		  		<div class="am am1 bg">
				
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p2-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
				</div>
				<div class="am am6 animation an4" c data-item="an4" data-delay="500" data-animation="fadeInDown">
					<input type="text" name="bedten" id="bedten" value="0" class="input-bed" maxlength="1" />
					<input type="text" name="bedone" id="bedone" value="0" class="input-bed" maxlength="1" />
					&nbsp;&nbsp;<font style="color:rgb(203,230,63);font-size:45px;font-family:'黑体';font-weight:100;">年</font>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT"  class="next-btn">
		                <img src="images/next-btn.png?v=1.0" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
		            </a>
				</div>
			  </div>
          	</div>

			<!--page3-->
			<div class="swiper-slide page-3 ps3">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p3-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
				</div>
				<div class="am am5 animation an4" c data-item="an4" data-delay="500" data-animation="fadeInDown">
					<input type="text" name="bedten" id="timesten" value="0" class="input-times" maxlength="1" />
					<input type="text" name="bedone" id="timesone" value="0" class="input-times" maxlength="1" />
					&nbsp;&nbsp;<font style="color:rgb(203,230,63);font-size:45px;font-family:'黑体';font-weight:100;">次</font>
				</div>
				<div class="am am6 btn">
					<a href="javascript:void(0);"  class="sub-btn">
		                <img src="images/p3-btn.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
		            </a>
				</div>
			  </div>
			</div>
             
             <!--page4-->
            <div class="swiper-slide page-4 ps4">
			  <div class="container4">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p4-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="un1">
						<img src="images/un-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page5-->
			<div class="swiper-slide page-5 ps5">
			  <div class="container4">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p5-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="goto-hpn">
						<img src="images/hpn-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			 <!--page6-->
            <div class="swiper-slide page-6 ps6">
			  <div class="container3">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p6-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="un2">
						<img src="images/un-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page7-->
			<div class="swiper-slide page-7 ps7">
			  <div class="container3">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p7-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="goto-hpn">
						<img src="images/hpn-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page8-->
            <div class="swiper-slide page-8 ps8">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p8-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="un3">
						<img src="images/un-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page9-->
			<div class="swiper-slide page-9 ps9">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p9-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="goto-hpn">
						<img src="images/hpn-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page10-->
            <div class="swiper-slide page-10 ps10">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p10-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="un4">
						<img src="images/un-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page11-->
			<div class="swiper-slide page-11 ps11">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p11-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="goto-hpn">
						<img src="images/hpn-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page12-->
			<div class="swiper-slide page-12 ps12">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p12-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 btn">
					<a href="javascript:void(0);"  class="paper-btn">
						<img src="images/server-btn.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
				<div class="am am5 hide paper">
					<img src="images/paper.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					<div class="scroll-img">
						<img src="images/scroll-img.jpg"  class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
					</div>
				</div>
				<div class="am am6 hide paper">
					<img src="images/paper-tips.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am7 hide paper">
					<a href="javascript:void(0);"  class="paper-close">
						<img src="images/paper-close.png" class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
					</a>
				</div>
			  </div>
			</div>

			<!--page13-->
			<div class="swiper-slide page-13 ps13">
			  <div class="container2">
				<div class="am am1 bg">
				</div>
				<div class="am am2 logo">
				</div>
				<div class="am am3">
					<img src="images/p13-1.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown"/>
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
			"imgUrl":'http://zt.jia360.com/msmm/images/share.jpg',
			"link":'http://zt.jia360.com/msmm',
			"desc":"点击打开你的没螨生活！",
			"title":"慕思床垫6月除螨抽签",
			success: function () {
				location.href = "http://mp.weixin.qq.com/s?__biz=MzA4MDc2NDM2Mw==&mid=210056948&idx=1&sn=927c308c9487634778776a5911f5e47d&scene=1&key=af154fdc40fed003f878109607b5bd92911b94982ab33557ec163aeeff582331398899093e43680ac7dbce8846bb299e&ascene=1&uin=MTMxMDY1ODEwMQ%3D%3D&devicetype=webwx&version=70000001&pass_ticket=019KarQEAlpwbHylfVObko4b80cWPqBYWpSA1l7K7F7vqAs2I8vtxyvWha7lpSOi"
				
			}
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>