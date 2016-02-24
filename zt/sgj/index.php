<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>时光鸡</title>
<meta name="keywords" content="时光鸡" />
<meta name="description" content="时光鸡" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />



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

       <div class="swiper-container swiper-pages indexWarp" id="swiper-container1">
            <div class="swiper-wrapper" id="wrapper">

                  <div class="swiper-slide page-1" id="p1">
					  <div class="container">
							<div class="am am1">
								<img src="images/p1_1.png"  />
							</div>
							<div class="am am2">
								<img src="images/p1_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeIn"/>
							</div>
							<div class="am am3">
								<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="700" data-animation="fadeIn"/>
							</div>
							<div class="am am4">
								<img src="images/p1_4.png" class="animation an4" data-item="an4" data-delay="1200" data-animation="fadeInRight"/>
							</div>
							<div class="am am5">
								<img src="images/p1_5.png" class="animation an5" data-item="an5" data-delay="1700" data-animation="fadeInRight"/>
							</div>
							<!-- <div class="am am6 btnBox">
								<img src="images/btn1_1.png" class="btn1"/>
								<img src="images/btn1_2.png" class="btn2"/>
							</div> -->
							<div class="am am6 btnBox">
								<input type="hidden" class="single-slider" id="btn1" value="100" />
							</div>

					  </div>
                  </div>
				  <div class="swiper-slide page-2" id="p2">
					  <div class="container">
							<div class="am am1">
								<img src="images/p2_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp"/>
							</div>
					  </div>                
				  </div>
                  <div class="swiper-slide page-3" id="p3">
					  <div class="container">
							<div class="am am1">
								<div class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<div class="cy"><img src="images/p3_1.png"/><span>1</span></div>
									<div class="cy"><img src="images/p3_1.png"/><span>9</span></div>
									<div class="cy"><img src="images/p3_1.png"/><span>9</span></div>
									<div class="cy"><img src="images/p3_1.png"/><span>2</span></div>
								</div>
							</div>
							<div class="am am2">
								<img src="images/p3_2.png" class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp"/>
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-4 personBox style0" id="p4">
					  <div class="container">
							<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
								<img src="images/p4_1.png" class="p4_1"/>
								<img src="images/p4_2.png" class="p4_2 shake" />
							</div>
							<div class="am am2 an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
								<div class="rw rw1 hide">
									<div class="whiteBg"></div>
									<img src="images/sby.png" class="rwImg"/>
									<p class="name">水冰月</p>
									<p class="info">你穿越到1992年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
								<div class="rw rw2 hide">
									<div class="whiteBg"></div>
									<img src="images/ljr.png" class="rwImg"/>
									<p class="name">绿巨人</p>
									<p class="info">你穿越到2003年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
								<div class="rw rw3 hide">
									<div class="whiteBg"></div>
									<img src="images/hlw.png" class="rwImg"/>
									<p class="name">葫芦娃</p>
									<p class="info">你穿越到1986年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
								<div class="rw rw4 hide">
									<div class="whiteBg"></div>
									<img src="images/sds.png" class="rwImg"/>
									<p class="name">圣斗士</p>
									<p class="info">你穿越到1986年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
								<div class="rw rw5 hide">
									<div class="whiteBg"></div>
									<img src="images/xwz.png" class="rwImg"/>
									<p class="name">樱桃小丸子</p>
									<p class="info">你穿越到1995年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
								<div class="rw rw6 hide">
									<div class="whiteBg"></div>
									<img src="images/kn.png" class="rwImg"/>
									<p class="name">柯南</p>
									<p class="info">你穿越到1996年，原来你以前长酱紫</p>
									<div class="upload">
										<p>[+]</p>
										<p>上传头像</p>
									</div>
								</div>
							</div>
							<div class="am am3 btnBox">
								<input type="hidden" class="single-slider" id="btn2" value="100" />
							</div>
					  </div>                
				  </div>
				  <div class="swiper-slide page-5 personBox style0" id="p5">
					  <div class="container">
					  		<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
								<img src="images/p5_1.png" class="p5_1"/>
							</div>
							<div class="am am2 an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
								<div class="rw rw1 hide">
									<div class="whiteBg"></div>
									<img src="images/sby.png" class="rwImg"/>
									<p class="name">水冰月</p>
									<p class="info">你穿越到1992年，原来你以前长酱紫</p>
								
								</div>
								<div class="rw rw2 hide">
									<div class="whiteBg"></div>
									<img src="images/ljr.png" class="rwImg"/>
									<p class="name">绿巨人</p>
									<p class="info">你穿越到2003年，原来你以前长酱紫</p>
								
								</div>
								<div class="rw rw3 hide">
									<div class="whiteBg"></div>
									<img src="images/hlw.png" class="rwImg"/>
									<p class="name">葫芦娃</p>
									<p class="info">你穿越到1986年，原来你以前长酱紫</p>
									
								</div>
								<div class="rw rw4 hide">
									<div class="whiteBg"></div>
									<img src="images/sds.png" class="rwImg"/>
									<p class="name">圣斗士</p>
									<p class="info">你穿越到1986年，原来你以前长酱紫</p>
								
								</div>
								<div class="rw rw5 hide">
									<div class="whiteBg"></div>
									<img src="images/xwz.png" class="rwImg"/>
									<p class="name">樱桃小丸子</p>
									<p class="info">你穿越到1995年，原来你以前长酱紫</p>
								
								</div>
								<div class="rw rw6 hide">
									<div class="whiteBg"></div>
									<img src="images/kn.png" class="rwImg"/>
									<p class="name">柯南</p>
									<p class="info">你穿越到1996年，原来你以前长酱紫</p>
								
								</div>
							</div>
							<div class="am am3 btnBox">
								<input type="hidden" class="single-slider" id="btn3" value="0" />
							</div>
							<div class="am am4 btnBox">
								<input type="hidden" class="single-slider" id="btn4" value="100" />
							</div>
					  </div>                
				  </div>
				  
           </div>
        </div>
        <input type="file" class="file hide" id="file" />
        <div class="shareTips hide" id="shareTips">
        	<img src="images/shareTips.jpg" />
        </div>

<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/jquery.range.js"></script>
<script src="js/my.js"></script>


<!--
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
			"imgUrl":'http://zt.jia360.com/sgj/images/share.png',
			"link":'http://zt.jia360.com/sgj/index.php',
			"desc":"描述",
			"title":"标题"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	-->
<!--#include virtual="/public/tongji.html"-->

</body>
</html>