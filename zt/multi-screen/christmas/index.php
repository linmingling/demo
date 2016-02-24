<?php
define( 'DIR_WEBSOCKET', dirname(__FILE__) );
require( 'server/config.php' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="front-end technicist" content="jinger" />
	<title>圣诞快乐</title>
	<meta name="keywords" content="圣诞快乐" />
	<meta name="description" content="圣诞快乐" />
	<meta name="front-end technicist" content="jinger" />
	<link type="text/css" rel="stylesheet" href="css/pc.css" media="all" />
</head>

<body>
<div class="leftEnter" id="leftEnter">
	<div class="chrismasImg"></div>
	<div id="chrismasEWM" class="chrismasEWM" style="display: none"></div>
	<div class="chrismasTips" style="display:none"></div>
</div>
<div class="rightEnter" id="rightEnter"></div>
<div class="chrismasAnim" id="chrismasAnim">
	<img src="images/p4_1.png" />
</div>
<p>当前模拟key：<span id="key"></span></p>
<p>tips：<span id="tips"></span></p>
<div class="chrismasCard" id="chrismasCard">
	<a class="cardClose"></a>
	<p>Merry Chrismas 节日快乐</p>
	<div class="cardImg">
		<img src="images/p2_1.png" class="cardImg1"/>
		<img src="images/p2_2.png" class="cardImg1" />
		<img src="images/p2_3.png" class="cardImg1" />
		<img src="images/p2_4.png" class="cardImg2" />
	</div>
	<div class="cardBg"></div>
</div>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jquery.qrcode.js"></script>
<script type="text/javascript" src="js/qrcode.js"></script>

<script type="text/javascript" src="static/jquery.websocket.js"  media="all"></script>
<script type="text/javascript" src="js/pc_socket.js?v=20141117"></script>
<script>
	var key = "<?php echo uniqid();?>";
	var mobile_url = '<?php echo QRCODE_URL ?>'+key;
	WS_STATIC_URL = '<?php echo PC_URL ?>';
	WS_HOST = '<?php echo WEBSOCKET_HOST ?>';
	WS_PORT = <?php echo WEBSOCKET_PORT ?>;
	$("#key").html(key);
</script>
</body>
