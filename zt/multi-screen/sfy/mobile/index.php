<?php
header("Content-type: text/html; charset=utf-8");
define( 'DIR_WEBSOCKET', dirname(__FILE__));
require( '../server/config.php' );
//记录用户体验次数
$file_name =  $_GET['key'] . '.txt';
$file = str_replace('mobile','',DIR_WEBSOCKET).'server/lock/'.$file_name;
file_put_contents($file, '');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="front-end technicist" content="jinger" />
	<title>腾讯网亚太家居-爱情公寓装修遇到难题</title>
	<meta name="keywords" content="腾讯网亚太家居 爱情公寓装修遇到难题">
	<meta name="description" content="腾讯网亚太家居 爱情公寓装修遇到难题">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
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
	<div id="tips" class="tips hide">
		<p>扫码慢了，已经有人在玩了哦~</p>
		<p>请退出重新扫码！</p>
	</div>
	<div class="mainWrap" id="mainWrap">
		<div class="main">
			<div class="swiper-container swiper-pages" id="swiper-container-1">
				<div class="swiper-wrapper" id="wrapper">
					<!--选场景-->
					<div class="swiper-slide page-1">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
<!-- 								<div class="am am2">
									<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight">
										请选择帮助对象：
									</p>
								</div> -->
								<div class="am am3">
									<div class="swiper-container animation an3" id="swiper-container-2" data-item="an3" data-delay="600" data-animation="fadeInLeft">
										<div class="swiper-wrapper">
											<div class="swiper-slide"><img src="images/p1_1.png" alt="客厅" class="swiper-img"></div>
											<div class="swiper-slide"><img src="images/p1_2.png" alt="厨房" class="swiper-img"></div>
											<div class="swiper-slide"><img src="images/p1_3.png" alt="卧室" class="swiper-img"></div>
											<div class="swiper-slide"><img src="images/p1_4.png" alt="卫浴" class="swiper-img"></div>
										</div>
										<div class="pagination-2"></div>
									</div>
									<a class="arrow-left" href="#"></a>
									<a class="arrow-right" href="#"></a>
								</div>
								<div class="am am4">
									<p class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInRight">
										<!-- 手指<span class="red">左右滑动</span>选择帮助对象 -->
										手指左右滑动选择帮助对象
									</p>
								</div>
								<div class="am am5 hide" id="sceneBtn">
									<div class="an5">
										我要帮忙
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--客厅-->
					<div class="swiper-slide page-2 selectBox">
					  <div class="container">
							<div class="wraper" id="kt">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>

								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeIn">
									<div class="select able" s="1" scene_type="kt"><img src="images/kt1.png"><i></i></div>
									<div class="select able" s="2" scene_type="kt"><img src="images/kt1.png"><i></i></div>
									<div class="select able" s="4" scene_type="kt"><img src="images/kt3.png"><i></i></div>
									<div class="select able" s="3" scene_type="kt"><img src="images/kt4.png"><i></i></div>

								</div>
								<div class="am am4 btn">
									<div class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">
										我选好啦
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--厨房-->
					<div class="swiper-slide page-3 selectBox">
					  <div class="container">
							<div class="wraper" id="cf">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeIn">
									<div class="select able" s="1" scene_type="cf"><img src="images/sf1.png"><i></i></div>
									<div class="select able" s="3" scene_type="cf"><img src="images/sf2.png"><i></i></div>
								</div>
								<div class="am am4 btn">
									<div class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">
										我选好啦
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--卧室-->
					<div class="swiper-slide page-4 selectBox">
					  <div class="container">
							<div class="wraper" id="ws">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>

								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
									<div class="select able" s="1" scene_type="ws"><img src="images/ws1.png"><i></i></div>
									<div class="select able" s="2" scene_type="ws"><img src="images/ws2.png"><i></i></div>
									<div class="select able" s="4" scene_type="ws"><img src="images/ws4.png"><i></i></div>
									<div class="select able" s="3" scene_type="ws"><img src="images/ws3.png"><i></i></div>
								</div>
								<div class="am am4 btn">
									<div class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">
										我选好啦
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--衣帽间-->
					<div class="swiper-slide page-5 selectBox">
					  <div class="container">
							<div class="wraper" id="wy">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>

								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
									<div class="select able" s="1" scene_type="wy"><img src="images/ym2.png"><i></i></div>
									<div class="select able" s="3" scene_type="wy"><img src="images/ym1.png"><i></i></div>
								</div>
								<div class="am am4 btn">
									<div class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">
										我选好啦
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--转盘-->
					<div class="swiper-slide page-6">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >挑选礼物</p>
									<p class="red" >猜猜你会抽到什么</p>
								</div>
								<div class="am am3">
									<div id="start" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
										开始滚动
									</div>
								</div>
								<div class="am am4">
									<p class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft">
										点击按钮，大屏幕转盘将滚动。
									</p>
								</div>
							</div>
						</div>
					</div>

					<!--提交中奖者信息-->
					<div class="swiper-slide page-7">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >你太幸运啦</p>
									<p class="red" >填写信息领奖吧!</p>
								</div>
									<!-- 领奖信息 -->
									<div class="form">
										<div class="am3">
											<p><input type="text" name="name" value="" id="name" placeholder="姓      名"></p>
											<p><input type="phone" name="phone" value="" id="phone" placeholder="联络电话"></p>
											<p><input type="text" name="address" value="" id="address" placeholder="联系地址"></p>
										</div>
										<div id="sure" class="am4">确定</div>				
									</div>
							</div>

						</div>
					</div>
					<!-- 提交中奖信息完毕 -->
					<div class="swiper-slide page-8">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" id="zjts">感谢参与！</p>
									<p class="red" >你还可以...</p>
								</div>

								<div class="am am4">
									<div id="cuxiao" class="animation an4" data-item="an4" data-delay="600" data-animation="fadeInRight">
										了解索菲亚促销信息
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- 促销信息 -->
					<div class="swiper-slide page-9">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<img src="images/cuxiao.png?v=1.2"  alt="促销信息"/>
								</div>
							</div>

						</div>
					</div>
					<!-- 没中奖页面 -->
					<div class="swiper-slide page-10">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >很遗憾！你没中奖！</p>
									<p class="red" >你还可以...</p>
								</div>
								<div class="am am3">
									<div id="ag" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
										重新扫码选择家具再抽1次奖
									</div>
								</div>
								<div class="am am4">
									<div id="cuxiao2" class="animation an4" data-item="an4" data-delay="600" data-animation="fadeInRight">
										了解索菲亚促销信息
									</div>
								</div>
							</div>

						</div>
					</div>

					<!-- 已经中奖页面 -->
					<div class="swiper-slide page-11">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >你已经中过奖了哦</p>
									<p class="red" >你还可以...</p>
								</div>

								<div class="am am4">
									<div id="cuxiao3" class="animation an4" data-item="an4" data-delay="600" data-animation="fadeInRight">
										了解索菲亚促销信息
									</div>
								</div>
							</div>

						</div>
					</div>
						
			   </div>
			</div>


		</div>
		<div class="headWrap" id="head">
			<div class="logo">
			</div>
		</div>
		<div class="footWrap" id="foot">
			<div class="foot">腾讯网·亚太家居UED出品</div>
		</div>

	</div>
	<img src="images/select1.png" class="hide"/>
	<img src="images/select2.png" class="hide"/>
	<img src="images/select3.png" class="hide"/>

	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/idangerous.swiper-2.1.min.js"></script>
	<script type="text/javascript" src="../static/jquery.websocket.js"  media="all"></script>
	<script src="js/mobile_socket.js?v=1.0"></script>
	<script type="text/javascript">
		var key = "<?php echo $_GET['key'];?>";
		WS_STATIC_URL = '<?php echo PC_URL ?>';
		WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
		WS_PORT = <?php echo WEBSOCKET_PORT ?>;
	</script>
</body>
</html>
