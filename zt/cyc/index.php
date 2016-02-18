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
		<div class="bg">
			<div class="content">
				<div class="logo"></div>
				<div class="biaoti"></div>
				<div class="btn" id="sel1" style="margin-top:45px;"><span class="wz"><b>非常好礼</b></span></div>
				<div class="btn" id="sel2"><span class="wz"><b>非常盛惠</b></span></div>
				<div class="btn" id="sel3"><span class="wz"><b>非常特卖</b></span></div>
				<div class="btn" id="sel4"><span class="wz"><b>立即报名</b></span></div>
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
				}
				if(!tel){
					alert("请填写手机号");
				}
				if(!reg.test(tel)){ 
					alert("手机号格式不正确!");
				}
				if(tel && name && reg.test(tel)){
					$.post("ajax.request.php",{"act":"addinfo","name":name,"phone":tel},function (data){
						data =  eval('('+data+')');	
						$('.input_bg').fadeOut();
						if(data.errcode == 0)
						{
							$('.input_success').fadeIn();
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
		</script>
	</body>
</html>
