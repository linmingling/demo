<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();
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
<title>优居 - 华美超级博览会</title>
<meta name="keywords" content="优居 华美超级博览会">
<meta name="description" content="优居 华美超级博览会">
<link rel="Bookmark" href="/favicon.ico" >
<link rel="Shortcut Icon" href="/favicon.ico" />
<link href="css/com.css?v=3.4" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/idangerous.swiper-2.1.min.js"></script>
<script type="text/javascript" src="js/com.js?v=3.4"></script>


</head>
<body>
	<div class="cn-spinner loading1" id="loading">
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
			<!--1-->
			<div class="swiper-slide page-1 ps-1">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p1-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p1-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
					<img src="images/p1-3.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
					<p class="animation an6 " data-item="an6" data-delay="1200" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>
			</div>
			<!--2-->
			<div class="swiper-slide page-2 ps-2">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p2-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p2-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
					<img src="images/p2-3.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
					<p class="animation an6 " data-item="an6" data-delay="1200" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>                
			</div>
			<!--3-->
			<div class="swiper-slide page-3 ps-3">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p3-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p3-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
					<img src="images/p3-3.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
					<img src="images/p3-4.png" class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
					<img src="images/p3-5.png" class="animation an6 " data-item="an6" data-delay="1200" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an7 " data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
					<p class="animation an8 " data-item="an8" data-delay="1600" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>                
			</div>
			<!--4-->
			<div class="swiper-slide page-4 ps-4">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p4-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p4-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
					<img src="images/p4-3.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
					<img src="images/p4-4.png" class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
					<img src="images/p4-5.png" class="animation an6 " data-item="an6" data-delay="1200" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an7 " data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
					<p class="animation an8 " data-item="an8" data-delay="1600" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>  
			</div>   
			<!--5-->
			<div class="swiper-slide page-5 ps-5">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p5-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p5-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
					<p class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>                
			</div>
			<!-- 6 -->
			<div class="swiper-slide page-6 ps-6">
			  <div class="container">
				<div class="am logo">
					<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am1"  >
					<img src="images/p6-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					<img src="images/p6-2.png" class="animation an3 " data-item="an3" data-delay="600" data-animation="fadeInDown"/>
					<img src="images/p6-3.png" class="animation an4 " data-item="an4" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am2 comBtn"  >
					<img src="images/btn2.png" class="animation an5 " data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
					<p class="animation an6 " data-item="an6" data-delay="1200" data-animation="fadeInDown">名额有限！抢完为止！</p>
				</div>
			  </div>               
			</div>
			
			<!--7-->
			<div class="swiper-slide page-7 bm-page">
				<div class="container">
					<div class="am logo">
						<img src="images/logo.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
					<div class="am am1"  >
						<img src="images/p7-1.png" class="animation an2 " data-item="an2" data-delay="400" data-animation="fadeInDown"/>
					</div>    
					<div class="am am2"  >
						<img src="images/p7-2.png" class="animation an3 " data-item="an3" data-delay="800" data-animation="fadeInDown"/>
					</div>      
					<div class="am am3 animation an4" data-item="an4" data-delay="600" data-animation="fadeInDown">
						<p class="nameBox">
							姓名<input type="text" id="name" class="name" placeholder=""/>
						</p>
						<p class="telBox">
							手机<input type="text" id="tel" class="tel" placeholder=""/>
						</p>	
						<p class="addBox">
							地址<input type="text" id="add" class="tel" placeholder=""/>
						</p>	
						<img src="images/btn.png" class="button" id="bm"/>
					</div>       
				</div>
			
			</div>
			

			    
	   </div>
	</div>
	<div class="next">
		<img src="images/next.png" />
	</div>
	<!--提示层 一般提示-->
	<div id="tips" class="tips hide"></div>
	<!--loading-->
	<div id="loading2" class="cn-spinner loading2 hide">
		<div class="spinner-warp">
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
	</div>
	
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script>
	//微信分享控制
	wx.config({
		  debug: false,
		  appId: '',
		  timestamp: '',
		  nonceStr: '',
		  signature: '',
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
			imgUrl:'',
			link:'',
			desc:"",
			title:""
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	var sto;
	function tips(text){
		$("#tips").html(text);
		$("#tips").fadeIn();
		clearTimeout(sto);
		sto = setTimeout(function(){
			$("#tips").stop().fadeOut();
		},5000);
	}
	$(function(){
		
	
		$("input").click(function(){
			$(this).focus();
		});

		$("#bm").click(function(){
			var name = $("#name").val();
			var tel = $("#tel").val();
			var add = $("#add").val();
			var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
			if(name == ""){
				tips("姓名不能为空");
				return;
			}else if(!mob.test(tel)){
				tips("请填入正确的手机号码！");
				return;
			}if(add == ""){
				tips("地址不能为空");
				return;
			}else{
				//存数据
				$("#loading2").show();
				$.ajax({
					async:true,
					url:'server.php',
					data:{name:name, phone:tel, address:add, act:'submit'},
					type: 'post',
					dataType:'json',
					success:function(result){
						alert(result.errmsg);
						$("#loading2").hide();
					}
				});
			}
		});
	});
	</script>
	
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	//微信分享控制
	wx.config({
	      debug: false,
	      appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
		  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
          signature: '<?php echo $signPackage["signature"];?>',
	      jsApiList: [
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			"imgUrl":'http://zt.jia360.com/huamei_expo/images/share.jpg',
			"link":'http://zt.jia360.com/huamei_expo/',
			"desc":"6月26-28日吉安华美超级博览会，现场活动，惊喜不断！",
			"title":"吉安华美超级博览会免费门票限量抢"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>