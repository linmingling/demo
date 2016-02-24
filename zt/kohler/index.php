<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>科勒奇浴记</title>
<meta name="keywords" content="科勒奇浴记" />
<meta name="description" content="科勒奇浴记" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />



</head>
<body>
       <div class="cn-spinner loading1" id="loading">
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
								<img src="images/p1_1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp" />
							</div>
							<div class="am am2  ">
								<img src="images/p1_2.png" class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp"/>
							</div>
							<div class="am am3">
								<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="1200" data-animation="fadeInUp"/>
							</div>
							<div class="am am4 next">
								
							</div>

					  </div>
                  </div>

                  <div class="swiper-slide page-2">
					  <div class="container">
							<div class="am am1">
								<div class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<img src="images/p2_1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp" />
								</div>
							</div>
							<div class="am am2">
								<img src="images/p2_2.png" class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp"/>
							</div>
							<div class="am am3 next">
								
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-3" id="page-3">
					  <div class="container">
							<div class="am am1" open="0">
								<img src="images/p3_1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp" />
								
								<div  class="animation an2 puke" num="0" data-item="an2" data-delay="700" data-animation="fadeInBigDown">
									<img src="images/p3_3.png" class="face hide"/>
									<img src="images/p3_2.png" class="back"/>
								</div>
								<div  class="animation an3 puke" num="1" data-item="an3" data-delay="1200" data-animation="fadeInBigDown">
									<img src="images/p3_4.png" class="face hide"/>
									<img src="images/p3_2.png" class="back"/>
								</div>
								<div  class="animation an4 puke" num="2" data-item="an4" data-delay="1700" data-animation="fadeInBigDown">
									<img src="images/p3_5.png" class="face hide"/>
									<img src="images/p3_2.png" class="back"/>
								</div>
								<div  class="animation an5 puke" num="3" data-item="an5" data-delay="2200" data-animation="fadeInBigDown">
									<img src="images/p3_6.png" class="face hide"/>
									<img src="images/p3_2.png" class="back"/>
								</div>
								<div  class="animation an6 puke" num="4" data-item="an6" data-delay="2700" data-animation="fadeInBigDown">
									<img src="images/p3_7.png" class="face hide"/>
									<img src="images/p3_2.png" class="back"/>
								</div>
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-4" id="page-4">
					  <div class="container">
							<div class="am am1">
								<div  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<img src="images/p4_1_1.png" class="p4_1_1"/>
									<img src="images/p4_1_2.png" class="p4_1_2 hide"/>
									<img src="images/p4_1_3.png" class="p4_1_3 hide"/>
									<img src="images/p4_1_4.png" class="p4_1_4 hide"/>
									<img src="images/p4_1_5.png" class="p4_1_5 hide"/>
								</div>
								<div  class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
									<div class="js">
										<img src="images/p4_2_1.png" class="jsBg"/>
										<img src="images/p4_2_2.png" class="jsBg hide"/>
										<img src="images/p4_2_3.png" class="jsBg hide"/>
										<img src="images/p4_2_4.png" class="jsBg hide"/>
										<img src="images/p4_2_5.png" class="jsBg hide"/>
										<img src="images/p4_5.png" class="openBtn"/>
										<a href="http://copstr.5ylb.com/kohler/index.html">
											<img src="images/p4_6.png" class="link"/>
										</a>
									</div>
									<img src="images/p4_3.png" class="p4_3"/>
								</div>
							</div>
							<div class="am am2 hide">
								<img src="images/p4_4.png" class="p4_4"/>
								<div class="info info1 ">
									<p class="title">APP Control系列</p>
									<p>科勒，作为全球厨卫领先品牌，重磅推出一款APP应用系统，它能被安装在智能平板电脑PAD上，用来操控卫浴空间中的科勒水•乐浴缸、DTV+智能淋浴系统、NUMI+纽密新声代一体超感座便器。三款产品在秉承着科勒一贯设计美学的同时，也通过为消费者缔造卫浴时音乐盛宴享受，集灯光、音乐、水流等多重全身SPA体验，并依托PAD control系统而铸就的简单便捷操控，再一次践行着科勒百年承诺：提供代表那个时代最高水准的产品。科勒这次大胆的尝试，必将掀起数字化生活新一轮的改革，它率先为全球消费者呈现数字卫浴带来的全新体验。</p>
								</div>
								<div class="info info2 hide">
									<p class="title">艾菲系列AvidBrochure</p>
									<p>科勒艾非龙头系列，将动态感官与至简美学嫁接，成为极简思潮的进化产物。它悠长的把手弧度搭配平滑的龙头表面，形成一个令人着迷夹角：你可以细看，艾非每个细节的设计，都是为了这开关时不期而遇的碰撞。它的每个元素都是必不可少的，这也正应和了艾非简约、清澈、优雅的设计语言。整套系列都传递着设计的灵动性，只为完美搭配现代空间。</p>
								</div>
								<div class="info info3 hide">
									<p class="title">柏诗系列ComposedBrochure</p>
									<p>科勒柏诗龙头系列，既保留了隽永的圆形把手，又以干净的线条诉说着简约之美。它的每一个细节：简约，透彻，经典，宁静都蕴含着美学意义上的自信。即使在科勒顶级的龙头家族中，科勒柏诗仍显得那么的与众不同。</p>
									<p>科勒柏诗以简约而不简单的线条设计，无声的诉说着经典永恒和内蕴非凡的美学哲理。就如毕加索所说，去除了冗余，留下了经典的柏诗，在时间的长河中熠熠生辉。</p>
								</div>
								<div class="info info4 hide">
									<p class="title">曼达系列BeitouBrochure</p>
									<p>科勒曼达浴室龙头系列，在建筑的线条美感和自然的恬静和谐中，找到了一种平衡。它就静静的在那里，带来平和、安心的氛围，提供一个回归心灵深处的庇护所。</p>
									<p>平静的水流淌漾在河涧、溪岸，是曼达灵感来源。我们模仿自然瀑布，让水流毫不费力的在龙头上层流淌，随着完美的角度倾泻下来。如果你有自然光—晨光、落日，甚至是星光—曼达就如河床一般，波光粼粼。</p>
								</div>
								<div class="info info5 hide">
									<p class="title">斯蒂系列STEAM</p>
									<p>科勒，作为全球厨卫领先品牌，重磅推出专业SPA体验的蒸汽淋浴设备：斯帝。该款蒸汽淋浴设备为您量身定制私人蒸汽浴，带来健康、私密、自由、随心的SPA体验。科勒斯帝的推出，标志着湿蒸这一专业的SPA体验将进入个人时代，从此你足不出户，就能体验桑拿房的畅快淋漓。</p>
								</div>
								<div class="close"></div>
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-5" id="page-5">
					  <div class="container">
							<div class="am am1">
								<div  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<img src="images/p5_1.png" class="p5_1"/>
									<img src="images/p5_2.png" class="p5_2"/>
								</div>
							
								<div  class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
									<img src="images/p5_3.png" class="p5_3"/>
								</div>
							</div>
					  </div>                
				  </div>
				  
				  <div class="swiper-slide page-6" id="page-6">
					  <div class="container">
							<div class="am am1">
								<div  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<img src="images/p5_1.png" class="p5_1"/>
									<img src="images/p6_1.png" class="p6_1"/>
									<div class="form" id="form">
										<p><input type="text" id="name" class="name" placeholder="姓名"/></p>
										<p><input type="text" id="tel" class="tel" placeholder="手机"/></p>	
										<p><input type="text" id="adress" class="adress" placeholder="地址"/></p>		
									</div>
								</div>
							
								<div  class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
									<img src="images/p6_2.png" class="p6_2"/>
								</div>
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-7" id="page-7">
					  <div class="container">
							<div class="am am1">
								<div  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp">
									<img src="images/p7_1.png"/>
								</div>
								<div  class="animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
									<a href="http://copstr.5ylb.com/kohler/index.html"><img src="images/p7_3.png"/></a>
									<img src="images/p7_4.png" class="return"/>
								</div>
								<div  class="animation an3" data-item="an3" data-delay="1200" data-animation="fadeInUp">
									腾讯网·亚太家居UED出品
								</div>
							</div>
							<div class="am am2">
								<img src="images/p7_2.png"  class="animation an4" data-item="an4" data-delay="1700" data-animation="fadeInUp" />
							</div>
					  </div>                
				  </div>
				  
           </div>
        </div>
    <!--loading-->


<div id="loading2" class="cn-spinner loading2 hide">
	<div class="spinner-warp">
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
</div>

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js"></script>


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
			"imgUrl":'http://zt.jia360.com/kohler/images/p4_3.png',
			"link":'http://zt.jia360.com/kohler/index.php',
			"desc":"科勒奇浴记",
			"title":"科勒奇浴记"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>

<!--#include virtual="/public/tongji.html"-->

</body>
</html>