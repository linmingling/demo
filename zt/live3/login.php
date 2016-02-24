<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
//$live_user = !empty($_SESSION['live_user']) ? $_SESSION['live_user'] : 0;
$live_user = false;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title>微信现场直播发布端 </title>
<link rel="stylesheet" type="text/css" href="css/com.css?v=1.1" />
<link rel="stylesheet" type="text/css" href="css/login.css" />
</head>
</body>
<div class="warp" id="warp">
	<div class="main">
		<!--登录确认-->
		<div id="pwd_tips" class="pwd_tips tc hide">
		<div class="tc_head">
			<p>管理员登录</p>
			<!-- <span class="close">×</span> -->
		</div>
		<div class="tc_main">
			<p class="nameBox">账号：<input type="text" class="username" placeholder="请输入账号"/></p>
			<p class="nameBox">密码：<input type="password" class="password" placeholder="请输入密码"/></p>
			<p class="bm">确认</p>
			<!-- <span id="qr_id" style="display: none"></span> -->
			<p id="tips" style="color:red"></p>
		</div>
		</div>
	</div>
</div>
<!--遮罩层-->
<div id="black_bg" class="mask hide"></div>

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.bm').click(function(){
		var username = $(".tc_main .username").val();
		var password = $(".tc_main .password").val();
		if(!username){
			$("#tips").html("");
			$("#tips").html('用户名不能为空');return;
		}
		if(!password){
			$("#tips").html("");
			$("#tips").html('请输入密码');return;
		}
		$.ajax({
			async:false,
		 	url: 'server.php',
		 	data: {act:'verify', username:username, password:password},
		 	type: 'post',
		 	dataType:'json',
		 	success:function(result){
		 		if(!parseInt(result.code)){
		 			$("#tips").html(result.msg);return;
		 		} else {
		 			location.href = "/live3/admin.php";
			 	}
		 	},
		 	error:function(){
		 		$("#tips").html("");
		 		$("#tips").html('服务器繁忙，请刷新或退出重试！');return;
			}
		});
	});
	<?php if(!$live_user){?>
		$('.mask').show();
		$('.pwd_tips').show();
	<?php }?>
});
</script>
<?php include '../public/head.html' ?>
<?php include '../public/tongji.html' ?>
</body>
</html>