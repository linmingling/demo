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
	<title>芬琳漆—爱情公寓装修遇难题</title>
	<meta name="keywords" content=" 芬琳漆  爱情公寓   装修 ">
	<meta name="description" content="腾讯家居 芬琳漆—爱情公寓装修遇难题">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link type="text/css" rel="stylesheet" href="css/com.css?v=01" media="all" />
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
								<div class="am am2">
									<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInRight">
										请选择帮助对象：
									</p>
								</div>
								<div class="am am3">
									<div class="swiper-container animation an3" id="swiper-container-2" data-item="an3" data-delay="600" data-animation="fadeInLeft">
										<div class="swiper-wrapper">
											<div class="swiper-slide"><img src="images/p1_1.png" alt="客厅" class="swiper-img"></div>
											<div class="swiper-slide"><img src="images/p1_2.png" alt="厨房" class="swiper-img"></div>
											<div class="swiper-slide"><img src="images/p1_3.png" alt="卧室" class="swiper-img"></div>
										</div>
										<div class="pagination-2"></div>
									</div>
									<a class="arrow-left" href="#"></a>
									<a class="arrow-right" href="#"></a>
								</div>
								<div class="am am4">
									<p class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInRight">
										手指<span class="red">左右滑动</span>选择帮助对象
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
								<div class="am am2">
									<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
										请选择墙面漆颜色：
									</p>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
									<div class="select able" s="1" scene_type="kt"><img src="images/kt1.png"></div>
									<div class="select able" s="2" scene_type="kt"><img src="images/kt2.png"></div>
									<div class="select able" s="3" scene_type="kt"><img src="images/kt3.png"></div>
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
								<div class="am am2">
									<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
										请选择墙面漆颜色：
									</p>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
									<div class="select able" s="1" scene_type="cf"><img src="images/cf1.png"></div>
									<div class="select able" s="2" scene_type="cf"><img src="images/cf2.png"></div>
									<div class="select able" s="3" scene_type="cf"><img src="images/cf3.png"></div>
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
								<div class="am am2">
									<p class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
										请选择墙面漆颜色：
									</p>
								</div>
								<div class="am am3 animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight">
									<div class="select able" s="1" scene_type="ws"><img src="images/ws1.png"></div>
									<div class="select able" s="2" scene_type="ws"><img src="images/ws2.png"></div>
									<div class="select able" s="3" scene_type="ws"><img src="images/ws3.png"></div>
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
					<div class="swiper-slide page-5">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >挑选神秘礼物！</p>
									<p class="red" >猜猜你会抽到什么？</p>
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
					<!--礼物-->
					<div class="swiper-slide page-6">
					  <div class="container">
							<div class="wraper" id="">
								<div class="am am1">
									<img src="images/title.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2 animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft">
									<p class="big" >你太幸运啦~</p>
									<p class="red" >拿礼物编号去领奖吧！</p>
									<p class="blue" id="sn"></p>
								</div>
								<div class="am am3">
									<img src="images/liwu.png"  class="animation an1" data-item="an1" data-delay="600" data-animation="fadeInLeft"/>
								</div>
								<div class="am am4 animation an4" data-item="an4" data-delay="600" data-animation="fadeInRight">
									<p class="red">神秘礼物一份~</p>
								</div>
							</div>

						</div>
					</div>


			   </div>
			</div>

		</div>
		<div class="footWrap" id="foot">
			<div class="foot">
			</div>
		</div>

	</div>
	<img src="images/select1.png" class="hide"/>
	<img src="images/select2.png" class="hide"/>
	<img src="images/select3.png" class="hide"/>

	<script src="js/jquery-1.8.3.min.js"></script>
	<script src="js/idangerous.swiper-2.1.min.js"></script>
	<script type="text/javascript" src="../static/jquery.websocket.js"  media="all"></script>
	<script src="js/mobile_socket.js?v=01"></script>
	<script type="text/javascript">
		var key = "<?php echo $_GET['key'];?>";
		WS_STATIC_URL = '<?php echo PC_URL ?>';
		WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
		WS_PORT = <?php echo WEBSOCKET_PORT ?>;
	</script>
</body>
</html>
