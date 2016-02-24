<?php
define( 'DIR_WEBSOCKET', dirname(__FILE__) );
require( 'server/config.php' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="front-end technicist" content="jinger" />
	<title>腾讯网亚太家居-爱情公寓装修遇到难题</title>
	<meta name="keywords" content="腾讯网亚太家居 爱情公寓装修遇到难题">
	<meta name="description" content="腾讯网亚太家居 爱情公寓装修遇到难题">
	<link type="text/css" rel="stylesheet" href="css/com.css?v=20141120" media="all" />
	<link type="text/css" rel="stylesheet" href="css/idangerous.swiper.css" media="all" />
</head>

<body>
	<h1 class="hide">爱情公寓 装修遇到难题</h1>
	<!--loading-->
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
	<div class="mainWrap">
		<div class="main">

			<div class="swiper-container swiper-pages" id="swiper-container-1">
				<div class="swiper-wrapper" id="wrapper">
					<!--首页-->
					<div class="swiper-slide page-1">
						<div class="container">
							<div class="wraper" id="wraper1">
								<div class="am am1">
									<img src="images/index/index_01.png" class="animation an1" data-item="an1" data-delay="400" data-animation="bounceInDown"/>
								</div>
								<div class="am am2">
									<img src="images/index/index_02.png" class="animation an2" data-item="an2" data-delay="0" data-animation="bounceInLeft"/>
								</div>
								<div class="am am3" id="message">
									<div id="qrcode">
										<div class="animation an3" id="qrcodeTable" data-item="an3" data-delay="200" data-animation="bounceInRight"></div>
									</div>
									<!-- <p>当前模拟key：<span id="key"></span></p> -->
								</div>
								<div class="am am4">
									<img src="images/index/index_03.png" class="animation an4" data-item="an4" data-delay="200" data-animation="bounceInRight"/>
								</div>
							</div>
						</div>
					</div>
					<!--挑选场景-->
					<div class="swiper-slide page-2">
						<div class="container">
							<div class="wraper">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">帮助场景：<span id="cj">客厅</span></p>
										<p>请用手机与当前屏幕互动，挑选帮助对象。</p>
									</div>
								</div>
								<div class="scene_box">
									<div class="swiper-container am am2 animation an2" id="swiper-container-2" data-item="an2" data-delay="400" data-animation="bounceInRight">
										<div class="swiper-wrapper">
											<div class="swiper-slide kt"><img src="images/scene/kt1.png" alt="客厅" class="swiper-img"></div>
											<div class="swiper-slide cf"><img src="images/scene/cf1.png" alt="厨房" class="swiper-img"></div>
											<div class="swiper-slide ws"><img src="images/scene/ws1.png" alt="卧室" class="swiper-img"></div>
											<div class="swiper-slide wy"><img src="images/scene/wy1.png" alt="卫浴" class="swiper-img"></div>
										</div>
										<div class="pagination-2"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--场景客厅-->
					<div class="swiper-slide page-3">
					  <div class="container">
							<div class="wraper kt_box" id="kt">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">帮忙<span>挑选客厅家具~</span></p>
										<p>用手机挑选家具，成功就有机会得到神秘礼物哦</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/kt1.png" />
									<img src="images/scene/kt2.png" class="hide"/>
									<img src="images/scene/kt3.png" class="hide"/>
									<img src="images/scene/kt4.png" class="hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/p1_1.png" alt="一菲" class="animation an3 p1_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i></p>
											<p><i class="red">哪</i><i class="red">套</i><i class="red">家</i><i class="red">具</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small">提供三套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这套家具我不喜欢</i></p>
											<p><i class="red">再帮我看看其它款</i></p>
											<p class="small">一菲喜欢简单时尚的款式</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>这款不错但是不配我</i></p>
											<p><i class="red">我喜欢大气上档次的</i></p>
											<p class="small">一菲喜欢颜色深的沙发</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>哈哈！我喜欢这套，</i></p>
											<p><i class="red">你真棒</i></p>
											<p class="small">你跟我一样，都是有品位的。</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>

									</div>

								</div>
								<div class="tc hide">
									<div class="tc_bg"></div>
									<div class="tc_box">
										<p class="big">谢谢你的<span class="red">热心帮忙</span></p>
										<p>为了感谢你，我送你一份<span class="red">神秘礼物</span>，请一定收下。</p>
										<div class="btn">用手机互动 挑选礼物</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide page-4">
						<div class="container">
							<div class="wraper cf_box" id="cf">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">帮忙<span>挑选橱柜厨具~</span></p>
										<p>用手机挑选厨具，成功就有机会得到神秘礼物哦</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/cf1.png" />
									<img src="images/scene/cf2.png" class="hide"/>
									<img src="images/scene/cf3.png" class="hide"/>
									<img src="images/scene/cf4.png" class="hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/p2_1.png" alt="小贤" class="animation an3 p2_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i></p>
											<p><i class="red">哪</i><i class="red">套</i><i class="red">厨</i><i class="red">具</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small">提供三套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这套厨具我不喜欢</i></p>
											<p><i class="red">再帮我看看其它款</i></p>
											<p class="small">小贤喜欢简单时尚的款式</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>这款不错但是不配我</i></p>
											<p><i class="red">我喜欢大气上档次的</i></p>
											<p class="small">小贤喜欢简单时尚的款式</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>哈哈！我喜欢这套，</i></p>
											<p><i class="red">你真厉害！</i></p>
											<p class="small">你跟我一样，都是有品位的。</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>

									</div>

								</div>
								<div class="tc hide">
									<div class="tc_bg"></div>
									<div class="tc_box">
										<p class="big">谢谢你的<span class="red">热心帮忙</span></p>
										<p>为了感谢你，我送你一份<span class="red">神秘礼物</span>，请一定收下。</p>
										<div class="btn">用手机互动 挑选礼物</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide page-5">
					  <div class="container">
							<div class="wraper ws_box" id="ws">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">帮忙<span>挑选卧室家具~</span></p>
										<p>用手机挑选家具，成功就有机会得到神秘礼物哦</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/ws1.png" />
									<img src="images/scene/ws2.png" class="hide"/>
									<img src="images/scene/ws3.png" class="hide"/>
									<img src="images/scene/ws4.png" class="hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/p3_1.png" alt="悠悠" class="animation an3 p3_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>你好，帮我快看看！</i></p>
											<p><i class="red">哪款卧室家具</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small">提供三套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这款衣柜我不喜欢</i></p>
											<p><i class="red">再帮我看看其它款</i></p>
											<p class="small">悠悠喜欢有质感的家具</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>这款不错但是不配我</i></p>
											<p><i class="red">我喜欢颜色鲜艳的</i></p>
											<p class="small">女孩子一般喜欢什么颜色？</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>亲爱的！我喜欢这套，</i></p>
											<p><i class="red">这颜色好独特！</i></p>
											<p class="small">你也喜欢这个颜色对吧。</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>

									</div>

								</div>
								<div class="tc hide">
									<div class="tc_bg"></div>
									<div class="tc_box">
										<p class="big">谢谢你的<span class="red">热心帮忙</span></p>
										<p>为了感谢你， 我送你一份<span class="red">神秘礼物</span>，请一定收下。</p>
										<div class="btn">用手机互动 挑选礼物</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide page-6">
					  <div class="container">
							<div class="wraper wy_box" id="wy">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">帮忙<span>挑选卫浴产品~</span></p>
										<p>用手机挑选卫浴产品，成功就有机会得到神秘礼物哦</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/wy1.png" />
									<img src="images/scene/wy2.png" class="hide"/>
									<img src="images/scene/wy3.png" class="hide"/>
									<img src="images/scene/wy4.png" class="hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/p4_1.png" alt="关谷" class="animation an3 p4_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>你好，帮我快看看！</i></p>
											<p><i class="red">哪款卫浴产品</i><i>适合我？</i></p>
											<p class="small">提供三套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这款产品我不喜欢</i></p>
											<p><i class="red">再帮我看看其它款</i></p>
											<p class="small">我喜欢简单的</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>这款不错但她们</i></p>
											<p><i class="red">可能不喜欢哦！</i></p>
											<p class="small">她们应该喜欢红的的吧？</p>
											<img src="images/scene/false.png" class="tipsImg"/>
										</div>
										<div class="dialog_box hide">
											<p><i>选得好，就是这款！</i></p>
											<p><i class="red">这下妹子们开心啦</i></p>
											<p class="small">你真是帮我大忙啦~</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>

									</div>

								</div>
								<div class="tc hide">
									<div class="tc_bg"></div>
									<div class="tc_box">
										<p class="big">谢谢你的<span class="red">热心帮忙</span></p>
										<p>为了感谢你， 我送你一份<span class="red">神秘礼物</span>，请一定收下。</p>
										<div class="btn">用手机互动 挑选礼物</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide page-7">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
									<p class="big">帮忙成功 <span class="red">挑选礼物</span></p>
									<p>用手机点击开始，神秘礼物等着你。</p>
								</div>
								<div class="am am2" >
									<div id="zp_person" class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft">
										<img src="images/scene/p1_1.png" class="p1_3 ">
										<img src="images/scene/p2_1.png" class="p2_3 hide">
										<img src="images/scene/p3_1.png" class="p3_3 hide">
										<img src="images/scene/p4_1.png" class="p4_3 hide">
									</div>
									<div class="dialog animation an3" data-item="an3" data-delay="1000" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>别跟我客气啊</i></p>
											<p><i class="red">赶紧选吧！</i></p>
										</div>
									</div>
								</div>
								<div class="zhuanpan" id="zhuanpan">
									<img src="images/scene/zp1.png" class="zp_bg">
									<img src="images/scene/zp2.png" class="zp_btn">
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide page-8">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/scene/scene_title.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft"/>
								</div>
								<div class="am am2" >
									<div id="lj_person" class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft">
										<img src="images/scene/p1_1.png" class="p1_3 ">
										<img src="images/scene/p2_1.png" class="p2_3 hide">
										<img src="images/scene/p3_1.png" class="p3_3 hide">
										<img src="images/scene/p4_1.png" class="p4_3 hide">
									</div>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="bounceInRight">
									<p class="big">哈哈哈，你真幸运！</p>
									<p class="red">赶紧去领取神秘礼物吧~</p>
								</div>
								<div class="am am4 animation an4" data-item="an4" data-delay="800" data-animation="bounceInRight">
									<p>拿上手机神秘礼物编码，去工作台领取礼物</p>
									<p><span class="red">15</span>秒后，自动跳转到活动首页</p>
								</div>

							</div>

						</div>
					</div>

			   </div>
			</div>
		</div>
		<div class="footWrap" id="foot">
			<div class="foot">
				<a class="logo" href="http://www.jia360.com/" target="_blank"></a>
			</div>
		</div>
	</div>
	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/idangerous.swiper-2.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.qrcode.js"></script>
	<script type="text/javascript" src="js/qrcode.js"></script>
	<script src="js/com.js?v=20141120"></script>
	<script type="text/javascript" src="static/jquery.websocket.js"  media="all"></script>
	<script type="text/javascript" src="js/websocket.js?v=20141117"></script>
	<script>
		var key = "<?php echo uniqid();?>";
		var mobile_url = '<?php echo QRCODE_URL ?>'+key;
		WS_STATIC_URL = '<?php echo PC_URL ?>';
		WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
		WS_PORT = <?php echo WEBSOCKET_PORT ?>;
		$("#key").html(key);
	</script>
</body>
</html>
