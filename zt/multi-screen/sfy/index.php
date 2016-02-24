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
	<link type="text/css" rel="stylesheet" href="css/com.css?v=1.1" media="all" />
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
									<img src="images/scene/page1.png" class="animation an1" data-item="an1"/>
									<div id="qrcode" class="qrcode">
										<div class="animation an3" id="qrcodeTable" data-item="an3"></div>
									</div>
								</div>
<!-- 								<div class="am am2">
									<img src="images/index/index_02.png" class="animation an2" data-item="an2" data-delay="0" data-animation="bounceInLeft"/>
								</div> -->
								<!-- <div class="am am3" id="message">
									<div id="qrcode">
										<div class="animation an3" id="qrcodeTable" data-item="an3"></div>
									</div>
								</div> -->
<!-- 								<div class="am am4">
									<img src="images/index/index_03.png" class="animation an4" data-item="an4" data-delay="200" data-animation="bounceInRight"/>
								</div> -->
							</div>
						</div>
					</div>
					<!--挑选场景-->
					<div class="swiper-slide page-2">
						<div class="container">
							<div class="wraper">
								<div class="scene_title">
									<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
										<p class="big">定制空间<span id="cj">客厅</span></p>
										<p class="small">请用手机操作，定制你想要的电视柜和入户柜，成功就有机会获得神秘礼物</p>
									</div>
								</div>
								<div class="scene_box">
									<div class="swiper-container am am2 animation an2" id="swiper-container-2" data-item="an2" data-delay="400" data-animation="bounceInRight">
										<div class="swiper-wrapper">
											<div class="swiper-slide kt"><img src="images/scene/kt1.png" alt="客厅" class="swiper-img"></div>
											<div class="swiper-slide cf"><img src="images/scene/sf1.png" alt="书房" class="swiper-img"></div>
											<div class="swiper-slide ws"><img src="images/scene/ws1.png" alt="卧室" class="swiper-img"></div>
											<div class="swiper-slide wy"><img src="images/scene/ym1.png" alt="衣帽间" class="swiper-img"></div>
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
										<p class="big">定制空间<span>客厅</span></p>
										<p class="small">用手机定制你想要的电视柜和入户柜，成功就有机会获得神秘礼物</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/kt1.png" />
									<img src="images/scene/kt2.png" class="hide"/>
									<img src="images/scene/kt3.png" class="hide"/>
									<img src="images/scene/kt5.png" class="hide"/>
									<img src="images/scene/kt4.png" class="hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/b1.png" alt="boy" class="animation an3 p1_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
							
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i>
											<i class="red">哪</i><i class="red">套</i><i class="red">家</i><i class="red">具</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small1">◆提供四套款式，请用手机挑选</p>
										</div>
										
										<div class="dialog_box hide">
											<p><i>这套产品我不喜欢</i>
											<i class="red">再帮我看看其它款</i></p>
											<p class="small1">◆我喜欢更加便捷的</p>
											
										</div>
										
										<div class="dialog_box hide">
											<p><i>这款产品外观不错</i>
											<i class="red">但我东西比较多</i></p>
											<p class="small">◆还是挑一款收纳型强点的吧</p>
											
										</div>
										
										<div class="dialog_box hide">
											<p><i>你真棒！</i>
											<i class="red">我喜欢你选的这套配搭！</i></p>
											<p class="small">◆你也喜欢这个配搭吧？</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>
										
							            <div class="dialog_box hide">
											<p><i>这款不错，但他</i>
											<i class="red">可能不喜欢哦！</i></p>
											<p class="small">◆他应该喜欢高大上的吧？</p>
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
										<p class="big">定制空间<span>书房</span></p>
										<p class="small">用手机定制你想要的书柜，成功就有机会获得神秘礼物</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/sf1.png" class="sfimg"/>
									<img src="images/scene/sf2.png" class="sfimg hide"/>
									<img src="images/scene/sf3.png" class="sfimg hide"/>
									<img src="images/scene/sf3.png" class="sfimg hide"/>
									<img src="images/scene/sf1.png" class="sfimg hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/g1.png" alt="girl" class="animation an3 p2_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
								
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i>
											<i class="red">哪</i><i class="red">套</i><i class="red">书</i><i class="red">桌</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small1">◆提供两套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这款产品外观不错</i>
											<i class="red">但是不太适合我</i></p>
											<p class="small">◆我需要一个实用、方便、充分利用空间的</p>
											
										</div>
                                        <div class="dialog_box hide"></div>
										<div class="dialog_box hide">
											<p><i>你真棒！对于职场白领的我来说</i></p>
											<p><i class="red1">一张实用的多功能书桌尤为重要</i></p>
											<p class="small1">◆你也喜欢这个配搭对吧？</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>
                                        <div class="dialog_box hide"></div>
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
										<p class="big">定制空间<span>卧室</span></p>
										<p class="small">用手机定制你想要的衣柜，成功就有机会获得神秘礼物</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/ws1.png" class="wsimg"/>
									<img src="images/scene/ws2.png" class="wsimg hide"/>
									<img src="images/scene/ws3.png" class="wsimg hide"/>
									<img src="images/scene/ws4.png" class="wsimg hide"/>
									<img src="images/scene/ws5.png" class="wsimg hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/b1.png" alt="boy" class="animation an3 p3_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i>
											<i class="red">哪</i><i class="red">个</i><i class="red">衣</i><i class="red">柜</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small1">◆提供四套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这套产品我不喜欢</i>
											<i class="red">再帮我看看其它款</i></p>
											<p class="small1">◆我喜欢简约风格的</p>
											
										</div>
										<div class="dialog_box hide">
											<p><i>这款产品外观不错</i>
											<i class="red">但不是我喜欢的风格</i></p>
											<p class="small1">◆我喜欢充满热情，充满阳光的热带雨林风</p>
											
										</div>
										
										<div class="dialog_box hide">
											<p><i>你真棒！对于追求高品质生活的我，</i></p>
											<p><i class="red1">我喜欢你选的这套配搭!</i></p>
											<p class="small1">◆你也喜欢这个配搭对吧？</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>
										
										<div class="dialog_box hide">
											<p><i>这衣柜看起来不错，</i>
											<i class="red">但可能不适合我哦</i></p>
											<p class="small1">◆我喜欢简约自然，幽雅浪漫田园风</p>
											
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
										<p class="big">定制空间<span class="span1">衣帽间</span></p>
										<p class="small">用手机定制你想要的衣帽间，成功就有机会获得神秘礼物</p>
									</div>
								</div>
								<div class="scene_box am am2 animation an2" data-item="an2" data-delay="400" data-animation="bounceInRight">
									<img src="images/scene/ym1.png" class="ymimg"/>
									<img src="images/scene/ym2.png" class="ymimg hide"/>
									<img src="images/scene/ym3.png" class="ymimg hide"/>
									<img src="images/scene/ym3.png" class="ymimg hide"/>
									<img src="images/scene/ym3.png" class="ymimg hide"/>
								</div>
								<div class="person_box am am3 " >
									<img src="images/scene/g1.png" alt="girl" class="animation an3 p4_1" data-item="an3" data-delay="800" data-animation="bounceInUp"/>
									
									<div class="dialog animation an4" data-item="an4" data-delay="1400" data-animation="">
										<div class="dialog_box">
											<p><i>嘿</i><i>！</i><i>帮</i><i>我</i><i>快</i><i>看</i><i>看</i><i>！</i>
											<i class="red">哪</i><i class="red">套</i><i class="red">衣</i><i class="red">帽</i><i class="red">间</i><i>适</i><i>合</i><i>我</i><i>？</i></p>
											<p class="small1">◆提供两套款式，请用手机挑选</p>
										</div>
										<div class="dialog_box hide">
											<p><i>这衣帽间看起来不错，</i>
											<i class="red">要选一套符合我气质的哦</i></p>
											<p class="small1">◆简约又不失气质是我想要的哦</p>
											
										</div>
                                        <div class="dialog_box hide"></div>
										<div class="dialog_box hide">
											<p><i>你真棒！衣帽间看起来很不错</i></p>
											<p><i class="red1">合适才是最好的</i></p>
											<p class="small11">◆简约而不简单，温馨淡雅才是我的范</p>
											<img src="images/scene/true.png" class="tipsImg"/>
										</div>
                                        <div class="dialog_box hide"></div>
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
<!-- 								<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="bounceInLeft">
									<p class="big">帮忙成功 <span class="red">挑选礼物</span></p>
									<p>用手机点击开始，神秘礼物等着你。</p>
								</div> -->
								<div class="am am2" >
									<div id="zp_person" class="animation an2" data-item="an2"/>
										<img src="images/scene/b3.png" class="p1_3 ">
										<img src="images/scene/b4.png" class="p2_3 hide">
										<img src="images/scene/g3.png" class="p3_3 ">
									</div>

<!-- 									<div class="dialog animation an3" data-item="an3" data-delay="1000" data-animation="bounceIn">
										<div class="dialog_box">
											<p><i>别跟我客气啊</i></p>
											<p><i class="red">赶紧选吧！</i></p>
										</div>
									</div> -->
								</div>
								<div class="zhuanpan" id="zhuanpan">
									<img src="images/scene/zp.png" class="zp_bg">
									<img src="images/scene/zp2.png" class="zp_btn">
								</div>
							</div>
						</div>
					</div>
					

					<div class="swiper-slide page-8">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am2" >
									<div id="lj_person" class="animation an2" data-item="an2"/>
										<img src="images/scene/b3.png" class="b3 ">
										<img src="images/scene/b4.png" class="b4 hide">
										<img src="images/scene/g3.png" class="g3">
									</div>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="" id="nz">
									<img src="images/scene/nz1.png" height="110" width="305" alt="" class="nz1">
									<img src="images/scene/nz2.png" height="111" width="392"  alt="" class="nz2">
								</div>
								<div class="am am4 animation an4" data-item="an4" data-delay="600" data-animation="" id="zj">
									<div class="dialog_box">
										<p><i>哈哈！你真幸运！</i></p>
										<p><i class="red">获得<span class="jp"></span>1个！</i></p>
									</div>
									<img src="images/scene/z2.png" height="113" width="393"   alt="" class="nz3">
								</div>
 						</div>
						</div>
					</div>
					<div class="swiper-slide page-9">
						<img src="images/scene/bargin.png" alt="" class="bargin">
						<img src="images/scene/sy.png" alt="" class="sy"/>
					</div>
			   </div>
			</div>
	<script src="js/jquery-1.8.3.min.js"></script>
	<script>
	/*alert(navigator.userAgent.indexOf('MSIE'))*/
	if(navigator.userAgent.indexOf('MSIE')>0){
		$("body").empty().html("<h2 style='width:100%;color:#fff;font-size:30px;text-align:center;margin-top:50px'>请在高级浏览器下打开</h2>");

	}
	</script>
	<script src="js/idangerous.swiper-2.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.qrcode.js"></script>
	<script type="text/javascript" src="js/qrcode.js"></script>
	<script src="js/com.js?v=1.1"></script>
	<script type="text/javascript" src="static/jquery.websocket.js"  media="all"></script>
	<script type="text/javascript" src="js/websocket.js?v=1.1"></script>
	<script>
		var key = "<?php echo uniqid();?>";
// 	    var key = 123;
		var mobile_url = '<?php echo QRCODE_URL ?>'+key;
		WS_STATIC_URL = '<?php echo PC_URL ?>';
		WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
		WS_PORT = <?php echo WEBSOCKET_PORT ?>;
	</script>
    <?php include '../../public/head.html' ?>
    <?php include '../../public/tongji.html' ?>
    <?php include '../../public/footer.html' ?>
    <!-- JiaThis Button BEGIN -->
	<script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_r.js?move=0&amp;btn=r1.gif" charset="utf-8"></script>
	<!-- JiaThis Button END -->
</body>
</html>
