<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>科学睡眠大挑战-2015全民睡眠节</title>
<meta name="keywords" content="科学睡眠大挑战 2015全民睡眠节" />
<meta name="description" content="科学睡眠大挑战 2015全民睡眠节" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=2.2"  />



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
						  <div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<img src="images/p1_title.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
								</div>
								<div class="am am3">
									<img src="images/p1_1.png" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"/>
								</div>
						  </div>
					  </div>
                  </div>

                  <div class="swiper-slide page-2">
					  <div class="container">
						  <div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<img src="images/p2_1.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
									<img src="images/p2_2.png" id="menu1" class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"/>
									<img src="images/p2_3.png" id="menu2" class="animation an4" data-item="an4" data-delay="600" data-animation="bounceIn"/>
								</div>
						  </div>
					  </div>
				  </div>

                  <div class="swiper-slide page-3 style1">
                      <div class="container">
							<div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<img src="images/p3_1.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
									<div class="warp" id="warp2">
										<div class="swiper-container " id="swiper-container2">
											<div class="swiper-wrapper" id="wrapper2">
												<div class="swiper-slide">
													<img src="images/fbh1.jpg" />
													<p>要让地球人都知道喜临门发布2015睡眠指数了</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh2.jpg" />
													<p>好好学习睡眠指数 掌握科学睡觉姿势</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh3.jpg" />
													<p>发布会即将开始，现场布置完毕</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh4.jpg" />
													<p>喜临门副总裁陈建致辞</p>
												</div>
											</div>
										</div>
										<span class="jt jt_left"><img src="images/jt_left.png" /></span>
										<span class="jt jt_right"><img src="images/jt_right.png" /></span>
									</div>
									<div class="warp" id="warp3">
										<div class="swiper-container " id="swiper-container3">
											<div class="swiper-wrapper" id="wrapper3">
												<div class="swiper-slide">
													<img src="images/fbh5.jpg" />
													<p>红星美凯龙董事副总裁朱家桂</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh6.jpg" />
													<p>这么重要的场合总少不了媒体的长枪短炮</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh7.jpg" />
													<p>中国66.5%都有睡眠问题</p>
												</div>
												<div class="swiper-slide">
													<img src="images/fbh8.jpg" />
													<p>发布会圆满结束，大佬们来张合影吧！</p>
												</div>
											</div>
										</div>
										<span class="jt jt_left"><img src="images/jt_left.png" /></span>
										<span class="jt jt_right"><img src="images/jt_right.png" /></span>
									</div>
								</div>
							</div>
                        </div>
                  </div>

				  <div class="swiper-slide page-4 style1">
                      <div class="container">
							<div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<img src="images/p4_1.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
									<div class="warp" id="warp4">
										<div class="swiper-container " id="swiper-container4">
											<div class="swiper-wrapper" id="wrapper4">
												<div class="swiper-slide">
													<img src="images/xc1.jpg" />
													<p>产品这么好，下单一点不手软！</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc2.jpg" />
													<p>喜临门导购太贴心了，购产品还赠送科学睡眠知识普及！</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc3.jpg" />
													<p>宣传很醒目，主题有内涵。</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc4.jpg" />
													<p>为了消费者就要舍得下血本，又买又送这种好事哪里找啊。</p>
												</div>
											</div>
										</div>
										<span class="jt jt_left"><img src="images/jt_left.png" /></span>
										<span class="jt jt_right"><img src="images/jt_right.png" /></span>
									</div>
									<div class="warp" id="warp4">
										<div class="swiper-container " id="swiper-container5">
											<div class="swiper-wrapper" id="wrapper5">
												<div class="swiper-slide">
													<img src="images/xc5.jpg" />
													<p>时刻不忘提醒消费者，睡眠也要讲科学的。</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc6.jpg" />
													<p>时尚、时尚，最时尚，喜临门除了产品时尚，店面设计也如此有型。</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc7.jpg" />
													<p>喜临门，红星美凯龙是被你承包了嘛？</p>
												</div>
												<div class="swiper-slide">
													<img src="images/xc8.jpg" />
													<p>转个视角，换种风格，就像喜临门床垫让你家随心而安。</p>
												</div>
											</div>
										</div>
										<span class="jt jt_left"><img src="images/jt_left.png" /></span>
										<span class="jt jt_right"><img src="images/jt_right.png" /></span>
									</div>
								</div>
							</div>
                        </div>
                  </div>



				  <div class="swiper-slide page-5">
                      <div class="container">
							<div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<img src="images/p5_1.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
									<div class="p5_div animation an3" data-item="an3" data-delay="400" data-animation="bounceIn">
										睡眠作为生命所必须的过程，是健康不可缺少的组成部分，拥有健康才能拥有一切。本次睡眠节活动，吸引了线上网民及线下用户对睡眠节的关注，借此唤起了全民对睡眠重要性的认识。据媒体报道，“喜临门中国睡眠指数”是我国唯一一个以中国人睡眠状况为研究对象的专业指标体系，连续发布三年。由于科学、全面、权威性被国内外机构及媒体广泛援引，对推动我国对睡眠问题的深入研究，加快科学睡眠的社会化进程，提升人民健康水平有着深远意义。
									</div>
								</div>
							</div>
                        </div>
                  </div>

				  <div class="swiper-slide page-6">
                      <div class="container">
							<div class="wraper">
								<div class="am am1 logoBox">
									<img src="images/logo.png"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceIn"/>
								</div>
								<div class="am am2">
									<div class="p6_div cf">
										<img src="images/p6_1.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInUp"/>
										<img src="images/p6_2.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInUp"/>
									</div>
									<img src="images/p6_3.png" class="animation an4" data-item="an4" data-delay="400" data-animation="bounceIn"/>
								</div>
								<!--#include virtual="/public/Copyright.html"-->
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

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=2.0"></script>

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
			"imgUrl":'http://zt.jia360.com/mkl_xlm/images/share.jpg',
			"link":'http://zt.jia360.com/mkl_xlm/index.php',
			"desc":"科学睡眠大挑战",
			"title":"2015全民睡眠节"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>

<!--#include virtual="/public/tongji.html"-->

</body>
</html>