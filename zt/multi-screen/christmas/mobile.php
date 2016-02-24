<?php
header("Content-type: text/html; charset=utf-8");
define( 'DIR_WEBSOCKET', dirname(__FILE__));
require( 'server/config.php' );
//记录用户体验次数
$key = $_GET['key'];
if(empty($key)){
	$key = 0;
}
$file_name =  $key . '.txt';
$file = DIR_WEBSOCKET.'/server/lock/'.$file_name;
file_put_contents($file, '');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Merry Chrismas</title>
<meta name="keywords" content="腾讯网 亚太家居 Merry Chrismas" />
<meta name="description" content="腾讯网 亚太家居 Merry Chrismas" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=20141223"  />

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

                  <div class="swiper-slide page-1" id="page-1">
					  <div class="container">
						  <div class="wraper">
								<div class="am am1">
									<img src="images/p1_1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight"/>
								</div>
								<div class="am am2">
									<img src="images/p1_2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft"/>
								</div>
								<div class="am am3">
									<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInRight"/>
								</div>
								<div class="am am4">
									<img src="images/hand.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInLeft"/>
								</div>
								<img src="images/p1_5.png"  class="am am5"/>
								<img src="images/p1_4.png"  class="am am6"/>
						  </div>
					  </div>
                  </div>

                  <div class="swiper-slide page-2" id="page-2">
					  <div class="container">
						<div class="wraper">
							<div class="am am1">
								<img src="images/chrismas.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInLeft" />
							</div>
							<div class="am am2">
								<img src="images/bell.png" class="animation an2"  data-item="an2" data-animation="bounceIn"  data-delay="400"/>
							</div>
							<div class="am am3">
								<div class="swiper-container animation an3" id="swiper-container2" data-item="an3" data-delay="600" data-animation="fadeInLeft">
									<div class="swiper-wrapper" id="wrapper2">
										<div class="swiper-slide"><img src="images/p2_1.png"></div>
										<div class="swiper-slide"><img src="images/p2_2.png"></div>
										<div class="swiper-slide"><img src="images/p2_3.png"></div>
										<div class="swiper-slide"><img src="images/p2_4.png"></div>
									</div>
								</div>
								<a class="arrow arrow-left"></a>
								<a class="arrow arrow-right"></a>
							</div>
							<div class="am am4">
								<img src="images/p2_5.png" class="animation an4"  data-item="an4" data-animation="bounceIn"  data-delay="800"/>
							</div>
							<div class="am am5">
								<span id="btn1" class="btn">开始制作</span>
							</div>
						</div>
					  </div>
				  </div>

				  <div class="swiper-slide page-3" id="page-3">
					  <div class="container">
						  <div class="wraper">
								<div class="bg"></div>
								<div class="am am1">
									<span class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInRight">Merry Chrismas</span>
								</div>
								<div class="am am2">
									<img src="images/p2_1.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInLeft"/>
									<img src="images/p2_2.png" class="animation" data-item="an2" data-delay="400" data-animation="fadeInLeft"/>
									<img src="images/p2_3.png" class="animation" data-item="an2" data-delay="400" data-animation="fadeInLeft"/>
									<img src="images/p2_4.png" class="animation" data-item="an2" data-delay="400" data-animation="fadeInLeft"/>
								</div>
								<div class="am am3">
									<img src="images/p3_1.png" class="animation an3" data-item="an3" data-delay="800" data-animation="fadeInLeft"/>
								</div>
								<div class="am am4">
									<input class="animation an4" type="text" placeholder="Merry Chrismas" data-item="an4" data-delay="800" data-animation="fadeInLeft" value="" id="chrismas_text"/>
									<span style="color:red;" id="chrismas_tips"></span>
								</div>
								<div class="am am5">
									<span class="btn"  id="but_text">我写好了</span>
								</div>
								<div class="am am6">
									<img src="images/p3_2.png" class="animation an6" data-item="an6" data-delay="1000" data-animation="fadeInLeft"/>
								</div>
								<div class="am am7">
									<img src="images/hand.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInLeft"/>
								</div>
						  </div>
					  </div>
                  </div>

				  <div class="swiper-slide page-4" id="page-4">
					  <div class="container">
						<div class="wraper">
							<div class="am am1">
								<img src="images/chrismas.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInLeft" />
							</div>
							<div class="am am2">
								<img src="images/bell.png" class="animation an2"  data-item="an2" data-animation="bounceIn"  data-delay="400"/>
							</div>
							<div class="am am3">
								<img src="images/p4_1.png" class="animation an3"  data-item="an3" data-animation="bounceIn"  data-delay="600"/>
							</div>
							<div class="am am4">
								<span class="animation an4 btn"  data-item="an4" data-animation="bounceIn"  data-delay="800" id="but">放飞你的祝福</span>
							</div>
						</div>
					  </div>
				  </div>

				  <div class="swiper-slide page-5" id="page-5">
					  <div class="container">
						<div class="wraper">
							<div class="am am1">
								<img src="images/chrismas.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInLeft" />
							</div>
							<div class="am am2">
								<img src="images/bell.png" class="animation an2"  data-item="an2" data-animation="bounceIn"  data-delay="400"/>
							</div>
							<div class="am am3">
								<img src="images/p1_5.png" class="animation an3"  data-item="an3" data-animation="bounceIn"  data-delay="600"/>
							</div>
							<div class="am am4">
								<span class="animation an4 btn"  data-item="an4" data-animation="bounceIn"  data-delay="800">请看电脑屏幕</span>
							</div>
						</div>
					  </div>
				  </div>

           </div>
        </div>

		<img src="images/share_tips.png" class="share_tips" id="share_tips" />


<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=20141224"></script>
<!-- <script src="js/WeixinApi.js"></script> -->
<script type="text/javascript" src="static/jquery.websocket.js"  media="all"></script>
<script src="js/mobile_socket.js?v=20141223"></script>
<script type="text/javascript">
	$("#but_text").click(function(){
		if(!$("#chrismas_text").val()){
			$("#chrismas_text").css('background', '#FFDFDD');
			$("#chrismas_tips").html('请填写您想说的话！');
			return false;
		}
	});

	var key = "<?php echo $_GET['key'];?>";
	WS_STATIC_URL = '<?php echo PC_URL ?>';
	WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
	WS_PORT = <?php echo WEBSOCKET_PORT ?>;
</script>
</body>
</html>