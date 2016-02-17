<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>水墨丹青-可以“森”呼吸的墙纸</title>
<meta name="keywords" content="水墨丹青-可以“森”呼吸的墙纸" />
<meta name="description" content="水墨丹青-可以“森”呼吸的墙纸" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=2.2"  />
</head>
<body>
<!-- 加载 -->
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
<!-- 二维码-->
<div class="am am4 hide" id="sign">
  <div class="sign">
		<img src="images/wx.jpg"  />
	</div>
</div>
<!-- end -->

<!-- 主要内容 -->
<div class="swiper-container swiper-pages" id="swiper-container1">
<div class="bgs"><img src="images/bg.jpg"  /></div>
	<div class="swiper-wrapper" id="wrapper">

		<!-- 第一屏 -->
		<div class="swiper-slide page-1">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  />
				</div>
				<div class="am am2">
					<img src="images/a1_b6.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/renwu.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInRight"  />
				</div>
				<div class="am am4">
					<img src="images/a1_b1.png" class="animation an4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/a1_b2.png" class="animation an5" data-item="an5" data-delay="1600" data-animation="fadeInDown"  />
				</div>
                <div class="am am6">
					<img src="images/a1_b3.png" class="animation an6" data-item="an6" data-delay="1800" data-animation="fadeInDown"  />
				</div>
                <div class="am am7">
					<img src="images/a1_b4.png" class="animation an7" data-item="an7" data-delay="2000" data-animation="fadeInDown"  />
				</div>
                <div class="am am8">
					<img src="images/a1_b5.png" class="animation an8" data-item="an8" data-delay="2300" data-animation="fadeIn"  />
				</div>
                <div class="next">
					<img src="images/a1_b7.png"  />
				</div>


			</div>
		</div>
		<!-- 第二屏 -->
		<div class="swiper-slide page-2">
			<div class="container">
				<div class="am am1">
					<img src="images/a2_b1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am2">
					<img src="images/a2_b2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/logo.png" class="animation an4 button-4" data-item="an4" data-delay="1000" data-animation="bounceInDown"/>
				</div>
				<!-- 报名 无奈摞出-->

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第三屏 -->
		<div class="swiper-slide page-3">
			<div class="container">
				<div class="am am1">

				</div>
				<div class="am am2">
					<img src="images/a3_b0.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a3_b1.png" class="animation an3 button-4" data-item="an3" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/a3_b2.png" class="animation an4 button-5" data-item="an4" data-delay="1200" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/a3_b3.png" class="animation an5 button-6" data-item="an5" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am6">
					<img src="images/logo.png" class="animation an6" data-item="an6" data-delay="1800" data-animation="bounceInDown"/>
				</div>
				<div class="am am7">
					<img src="images/a3_b4.png" class="animation an7 button-7" data-item="an7" data-delay="1600" data-animation="fadeInDown"/>
				</div>
                <div class="am am8">
					<img src="images/a3_b5.png" class="animation an8 button-8" data-item="an8" data-delay="1800" data-animation="fadeInDown"/>
				</div>


				<div class="next">
					<img src="images/next.png" />
				</div>
                <!-- t1 -->
				<div class="s-ct-a am9 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/a3_b1.png"  /></div>
							<p class="p1">天然无机矿物净醛材料添加，持续吸附分解空气中的游离甲醛，24小时内可吸附分解游离甲醛80%以上，健康呼吸每一天。</p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
                <!-- t2 -->
				<div class="s-ct-a am10 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/a3_b2.png"  /></div>
							<p class="p1">采用广泛用于食品、饮料、儿童玩具等包装印刷品的高环保水性油墨。安全无异味，保持室内空气清新。</p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
                <!-- t3 -->
				<div class="s-ct-a am11 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/a3_b3.png"  /></div>
							<p class="p1">采用150克透气无纺纸基材，透气性强，保障墙面保持干爽，不易霉变。</p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
                <!-- t4 -->
				<div class="s-ct-a am12 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/a3_b4.png"  /></div>
							<p class="p1">应用英国Emerson设备独具的SC-G混合圆网发泡工艺技术，使壁纸吸音降噪，并使壁纸肌理立体、细腻、自然，不同角度全新视觉感受，有效缓解审美疲劳。</p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
                <!-- t5 -->
				<div class="s-ct-a am13 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/a3_b5.png"  /></div>
							<p class="p1">纯天然植物胶，避免对人体造成危害，确保壁纸黏贴牢固，边角不易翻卷。</p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
			</div>
		</div>
		<!-- 第四屏 -->
		<div class="swiper-slide page-4">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1800" data-animation="bounceInDown"/>
				</div>
				<div class="am am2">
					<img src="images/a4_b1.png" class="animation an2" data-item="an2" data-delay="500" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<p class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInDown">文房四宝书香案前笔走龙蛇	</p>
					<p class="animation an4" data-item="an4" data-delay="1100" data-animation="fadeInDown">三尺斗方生宣纸上挥毫泼墨	</p>
                    <p class="animation an5" data-item="an5" data-delay="1200" data-animation="fadeInDown">国画以墨色为主，丹青色为辅，所以称作“水墨丹青画”。此版以中国传统纹样为设计素材，故称之为——《水墨丹青》。</p>
                    <p class="animation an6" data-item="an6" data-delay="1300" data-animation="fadeInDown">我们本着高端品位大众化的设计诉求，来传达设计理念。</p>
                    <p class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown">正可谓：“旧时王榭堂前燕，飞入寻常百姓家”。</p>
				</div>
                <div class="am am4">
					<img src="images/a4_b2.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
				<div class="next">
					<img src="images/a4_b4.png" />
				</div>
			</div>
		</div>
		<!-- 第五屏 -->
		<div class="swiper-slide page-5">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1800" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_b1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a5_b2.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a5_b3.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第六屏 -->
		<div class="swiper-slide page-6">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1800" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_b1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a6_1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a6_2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第七屏 -->
		<div class="swiper-slide page-7">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_b1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a7_1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a7_2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第八屏 -->
		<div class="swiper-slide page-8">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_b1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a8_1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a8_2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第九屏 -->
		<div class="swiper-slide page-9">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a5_b1.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a9_1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a9_2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/a9_3.png" />
				</div>
			</div>
		</div>
        <!-- 第十屏 -->
		<div class="swiper-slide page-10">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a10_b0.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a10_b1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a10_b2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第十一屏 -->
		<div class="swiper-slide page-11">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a11_b0.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a11_b1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a11_b2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>

        <!-- 第十二屏 -->
		<div class="swiper-slide page-12">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a11_b0.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a12_b1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					<img src="images/a12_b2.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>

        <!-- 第十三屏 -->
		<div class="swiper-slide page-13">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/btbg.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a13_b0.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>

				<div class="am am4">
					<img src="images/a13_b1.png" class="animation an4 button-9" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                
                 <!-- tx -->
				<div class="s-ct-a am14 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							
							<p class="p1"><img src="images/a13_b2.png" /></p>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        <!-- 第十四屏 -->
        <div class="swiper-slide page-14">
			<div class="container">
				<div class="am am1">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="1400" data-animation="bounceInDown"/>
				</div>
                <div class="am am2">
					<img src="images/a14_b1.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown"  />
				</div>
				<div class="am am3">
					<img src="images/a14_b2.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
				</div>
				<div class="am am4">
					<img src="images/a14_b3.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"  />
				</div>
                <div class="am am5">
					
				</div>
                <div class="am am6">
					<img src="images/a14_b4.png" class="animation an6" data-item="an6" data-delay="1000" data-animation="fadeInDown"  />
				</div>

				<div class="next">
					<img src="images/a14_b5.png" />
				</div>
			</div>
		</div>

   </div>
</div>
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
		imgUrl:'http://zt.jia360.com/bgqz/images/renwu.jpg',
		link:'http://zt.jia360.com/bgqz/index.php',
		desc:"壁高墙纸《水墨丹青》画册品鉴",
		title:"壁高墙纸《水墨丹青》画册品鉴"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.8"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>