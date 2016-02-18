<?php
header("Content-type: text/html; charset=utf-8");
define('ROOT_PATH', dirname(__FILE__));
$agent = $_SERVER['HTTP_USER_AGENT'];
define('site_url', 'http://local.zt');
session_start();
date_default_timezone_set('PRC'); //设置本地时区
	
if(!strpos($agent,"MicroMessenger")) {
    echo '';
}
else {// 微信浏览器
	include_once "../data/jssdk.php";
	$jssdk = new JSSDK();//优居生活服务号
	$signPackage = $jssdk->GetSignPackage();

	// $_SESSION['nature20_openid'] = 'abc123123';
	// $_SESSION['nature20_wechaname'] = 'hehehe';
	// $_SESSION['nature20_headimgurl'] = 'images/user3.png';

	// if(!isset($_POST['openid']))
	if(!$_POST['openid'])
	{
		$openId = $_SESSION['nature20_openid'];
		$wechaname = $_SESSION['nature20_wechaname'];
		$headimgurl = $_SESSION['nature20_headimgurl'];

		if(empty($openId))
		{
			$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
			$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=nature20';
			echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
		}
	}
	else 
	{
		$openId = $_POST['openid'];
		$wechaname = base64_decode($_POST['wechaname']);
		$headimgurl = urldecode($_POST['headimgurl']);
		$_SESSION['nature20_openid'] = $openId;
		$_SESSION['nature20_wechaname'] = $wechaname;
		$_SESSION['nature20_headimgurl'] = $headimgurl;
	}
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no, email=no" />
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="HandheldFriendly" content="true">
		<meta name="MobileOptimized" content="640">
		<meta name="screen-orientation" content="portrait">
		<meta name="x5-orientation" content="portrait">
		<meta name="full-screen" content="yes">
		<meta name="x5-fullscreen" content="true">
		<meta name="browsermode" content="application">
		<meta name="x5-page-mode" content="app">
		<meta name="msapplication-tap-highlight" content="no">
		<meta name="viewport" content="width=640,target-densitydpi=device-dpi,maximum-scale=1.0, user-scalable=no">
		<script type="text/javascript">
			function setWidth(a) {
				if (/Andriod/i.test(navigator.userAgent)) {
					var c, b = window.innerWidth;
					(b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function() {
						var d = document.getElementsByTagName("body")[0];
						d.style.webkitTransformOrigin = "left top";
						d.style.webkitTransform = "scale(" + c + ")";
					}, !1)
				}
			}
			setWidth(640);
		</script>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="js/jquery-1.7.2.min.js" ></script>
		<title>城外诚非常价日</title>
	</head>
	<body>
			<div style="display:none"><img src="images/share.png"></div>
		<div class="bg">
			<div class="content">
				<div class="logo"></div>
				<div class="biaoti"></div>
				<div class="btn" id="sel1" style="margin-top:20px;"><span class="wz"><b>非常好礼</b></span></div>
				<div class="btn" id="sel2"><span class="wz"><b>非常盛惠</b></span></div>
				<div class="btn" id="sel3"><span class="wz"><b>非常特卖</b></span></div>
				<div class="btn" id="sel4"><span class="wz"><b>立即报名</b></span></div>
				<div style="margin-top:10px;color:white;font-family:微软雅黑;font-size:1em">咨询电话：400-610-5088</div>
				<div class="bot"></div>
				<div class="pop_sel">
					<div class="pop_title"><span id="pop_title">非常好礼</span></div>
					<div class="pop_con"></div>
				</div>
				<div class="input_bg">
					<input type="text" class="input_t" style="margin-top:130px;" id="name" placeholder="  姓名"/>
					<input type="text" class="input_t" id="tel" placeholder="  电话"/>
					<div class="input_btn" id="submit"><span>提 交</span></div>
				</div>
				<div class="input_success">
					<div style="margin-top:160px;font-size:1.2em;"><span>您的信息已提交成功！</span></div>
					<div class="input_btn" id="finish" style="margin-top:95px;"><span>我知道了</span></div>
				</div>
				<div class="opa_bg"></div>
			</div>
		</div>
		
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
			document.documentElement.style.height = window.innerHeight + 'px';
			
			$('.btn').bind('click',function(){
				if(this.id=="sel1"){
					$(".pop_con").css("background",'url(images/01.png)');
					$('#pop_title').html("非常好礼");
					$('.pop_sel').fadeIn();
				}else if(this.id=="sel2"){
					$(".pop_con").css("background",'url(images/02.png)');
					$('#pop_title').html("非常盛惠");
					$('.pop_sel').fadeIn();
				}else if(this.id=="sel3"){
					$(".pop_con").css("background",'url(images/03.png)');
					$('#pop_title').html("非常特卖");
					$('.pop_sel').fadeIn();
				}else if(this.id=="sel4"){
					$('.opa_bg').fadeIn();
		  		$('.input_bg').fadeIn();
				}
				$('.opa_bg').fadeIn();
			})
			
			//提交按钮事件
			$('#submit').bind('click',function(){
				var name = $("#name").val();
				var tel = $("#tel").val();
				var reg = /^1[3|4|5|8][0-9]\d{4,8}$/;
				if(!name){
					alert("请填写姓名");
					return '';
				}
				if(!tel){
					alert("请填写手机号");
					return '';
				}
				if(tel!='' && !reg.test(tel)){ 
					alert("手机号格式不正确!");
					return '';
				}
				if(tel && name && reg.test(tel)){
					$.post("ajax.request.php",{"act":"addinfo","name":name,"phone":tel},function (data){
						data =  eval('('+data+')');	
						$('.input_bg').fadeOut();
						if(data.errcode == 0)
						{
							$('.input_success').fadeIn();
							alert('【恭喜您，您是第'+ data.lastId +'位报名成功的用户】');
						}
						else
						{
							alert(data.errmsg);
						}
					});
				}
			})

			$('#finish').bind('click',function(){
				$('.opa_bg').fadeOut();
				$('.input_success').fadeOut();
			})
			$('.opa_bg').bind('click',function(){
	  		$('.opa_bg').fadeOut();
		  	$('.pop_sel').fadeOut();
		  	$('.input_bg').fadeOut();
		  	$('.input_success').fadeOut();
			})
			$('.pop_sel').bind('click',function(){
	  		$('.opa_bg').fadeOut();
		  	$('.pop_sel').fadeOut();
			})
			
			$(function(){
				var ua = navigator.userAgent.toLowerCase();
				if(ua.match(/MicroMessenger/i)=="micromessenger") {
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
							"imgUrl":'http://zt.jia360.com/cyc_reg/images/share.jpg',
							"link":'http://zt.jia360.com/cyc_reg/',
							"desc":"城外诚年终盛惠 非常价日 惊喜尽在城外诚",
							"title":"城外诚非常价日"
						};
						wx.onMenuShareAppMessage(wxData);
						wx.onMenuShareTimeline(wxData);
					 });
				}
			});
		</script>
		<!--#include virtual="/public/tongji.html"-->
	</body>
</html>
