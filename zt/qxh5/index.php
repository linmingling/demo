<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>七夕家装节</title>
<meta name="keywords" content="七夕家装节" />
<meta name="description" content="七夕家装节" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.0" />

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
			  		<div class="am am1">
						<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="400" data-animation="fadeInDown" />
					</div>
					<div class="am am2">
						<img src="images/title.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"  />
					</div>
					<div class="am am3">
						<img src="images/guy.png" class="animation an3" data-item="an3" data-delay="1600" data-animation="fadeInDown"  />
					</div>
			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2">
			  <div class="container2">
			  		<div class="am am1">
						<img src="images/title2.png" class="animation an1" data-item="an1" data-delay="100" data-animation="fadeInDown"  />
					</div>
			  		<div class="am am2">
						<img src="images/b1.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInLeft"  />
					</div>
			  		<div class="am am3">
						<img src="images/b2.png" class="animation an3" data-item="an3" data-delay="1200" data-animation="fadeInRight"  />
					</div>
			  		<div class="am am4">
						<img src="images/b3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInLeft"  />
					</div>
			  		<div class="am am5">
						<img src="images/b4.png" class="animation an5" data-item="an5" data-delay="2400" data-animation="fadeInRight"  />
					</div>
			  </div>             
		  </div>

		  <div class="swiper-slide page-3 ps3">
			  <div class="container3">
			  		<div class="am am1">
						<img src="images/title3.png" class="animation an1" data-item="an1" data-delay="100"  data-animation="fadeInDown"  />
					</div>
			  		<div class="am am2">
						<img src="images/c1.png?v=1.0" class="animation an2" data-item="an2" data-delay="1000"  data-animation="fadeInDown"  />
						<img src="images/c2.png?v=1.0" class="animation an3" data-item="an3" data-delay="2000"  data-animation="fadeInDown"  />
						<img src="images/c3.png?v=1.0" class="animation an4" data-item="an4" data-delay="3000"  data-animation="fadeInDown"  />
					</div>
			 
					<div class="am am5">
						<img src="images/c4.png" class="animation an5" data-item="an5" data-delay="4000"  data-animation="fadeInDown"  />
					</div>
			  </div>           
		  </div>

		  <div class="swiper-slide page-4 ps4">
			  <div class="container4">
			  		<div class="am am1">
						<img src="images/title4.png" class="animation an1" data-item="an1" data-delay="100" data-animation="fadeIn"  />
					</div>
			  		<div class="am am2">
						<img src="images/logo2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeIn"  />
					</div>
			  </div>           
		  </div>
		  
		  <div class="swiper-slide page-5 ps5">
			  <div class="container5">
			  		<div class="am am1">
						<img src="images/title5.png" class="animation an1" data-item="an1" data-delay="100" data-animation="fadeInDown"  />
					</div>
			  		<div class="am am2">
						<a href="http://group.yoju360.com/phone/qixi?city=tianjin"><img src="images/tj.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am3">
						<a href="http://group.yoju360.com/phone/qixi?city=hangzhou"><img src="images/hz.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am4">
						<a href="http://group.yoju360.com/phone/qixi?city=kunming"><img src="images/km.png" class="animation an4" data-item="an4" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am5">
						<a href="http://group.yoju360.com/phone/qixi?city=haerbin"><img src="images/hrb.png" class="animation an5" data-item="an5" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am6">
						<a href="http://group.yoju360.com/phone/qixi?city=nanjing"><img src="images/nj.png" class="animation an6" data-item="an6" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am7">
						<a href="http://group.yoju360.com/phone/qixi?city=nanchang"><img src="images/nc.png" class="animation an7" data-item="an7" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
				  	<div class="am am8">
						<a href="http://group.yoju360.com/phone/qixi?city=wuhan"><img src="images/wh.png" class="animation an8" data-item="an8" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am9">
						<a href="http://group.yoju360.com/phone/qixi?city=xiamen"><img src="images/xm.png" class="animation an9" data-item="an9" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am10">
						<a href="http://group.yoju360.com/phone/qixi?city=qingdao"><img src="images/qd.png" class="animation an10" data-item="an10" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>

			  		<div class="am am11">
						<a href="http://group.yoju360.com/phone/qixi?city=xian"><img src="images/xa.png" class="animation an11" data-item="an11" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am12">
						<a href="http://group.yoju360.com/phone/qixi?city=changsha"><img src="images/cs.png" class="animation an12" data-item="an12" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am13">
						<a href="http://group.yoju360.com/phone/qixi?city=shijiazhuang"><img src="images/sjz.png" class="animation an13" data-item="an13" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am14">
						<a href="http://group.yoju360.com/phone/qixi?city=taiyuan"><img src="images/ty.png" class="animation an14" data-item="an14" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am15">
						<a href="http://group.yoju360.com/phone/qixi?city=jinan"><img src="images/jn.png" class="animation an15" data-item="an15" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
			  		<div class="am am16">
						<a href="http://group.yoju360.com/phone/qixi?city=guiyang"><img src="images/gy.png" class="animation an16" data-item="an16" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
					<div class="am am18">
						<a href="http://group.yoju360.com/phone/qixi?city=zhengzhou"><img src="images/zz.png" class="animation an18" data-item="an18" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
					<div class="am am19">
						<a href="http://group.yoju360.com/phone/qixi?city=dongguan"><img src="images/dg.png" class="animation an19" data-item="an19" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>
					<div class="am am20">
						<a href="http://group.yoju360.com/phone/qixi?city=beijing"><img src="images/bj.png" class="animation an20" data-item="an20" data-delay="600" data-animation="fadeInDown"  /></a>
					</div>

			  		<div class="am am17">
						<img src="images/intro.png" class="animation an17" data-item="an17" data-delay="600" data-animation="fadeInDown"  />
					</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-6 ps6">
			  <div class="container6">
			  		<div class="am am1">
						<img src="images/join.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
			  </div>                    
		  </div>	  

   </div>
</div>
<div class="cn-slidetips next">
    <div class="slidetips">
        <a href="javascript:void(0);" title="NEXT" id="next">
            <img src="images/tip.png" />
        </a>
    </div>
</div>
<!--音乐  -->
<div id="music">
	<a href="javascript:void(0)" class="open musicBtn" ></a>
	<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
</div>

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js"></script>


<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?4f801a3be05fbee10700404e0e020f21";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

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
			"imgUrl":'http://zt.jia360.com/qxh5/images/zf.jpg?v=1.0',
			"link":'http://zt.jia360.com/qxh5/index.php',
			"desc":"中国人的家装节，开创全民“家装购物狂欢节”",
			"title":"七夕家装节，大牌抄底价"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
</script>


<!--#include virtual="/public/tongji.html"-->
</body>
</html>