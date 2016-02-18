<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../data/config.php');
	require_once(ROOT_PATH .'../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
     
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
    	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    } 
    
    //$_SESSION['christmas_openid'] = '76576';
    //$_SESSION['christmas_wechaname'] = 'dsghgdad';
    //$_SESSION['christmas_headurl'] = 'baidu.com';
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['christmas_openid'];
    	$wechaname = $_SESSION['christmas_wechaname'];
    	$headurl = $_SESSION['christmas_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=jlf2';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['christmas_openid'] = $openId;
    	$_SESSION['christmas_wechaname'] = $wechaname;
    	$_SESSION['christmas_headurl'] = $headurl;
    }
	
	// 时间判断得到期数
	$nowDate = date('Y-m-d H:i:s'); // 正确时间应该是24 号23号是测试数据
	$timeArr = array('2015-12-24 0:0:0','2015-12-24 23:59:59',
					 '2015-12-25 0:0:0','2015-12-25 23:59:59',
					 '2015-12-26 0:0:0','2015-12-26 23:59:59'); // 时间段函数
	$nowPer = '';
	if(strtotime($timeArr['0']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['1'])) {
		$nowPer = 1;
	} else 	if(strtotime($timeArr['2']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['3'])) {
		$nowPer = 2;
	} else 	if(strtotime($timeArr['4']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['5'])) {
		$nowPer = 3;
	} else {
		$nowPer = 0;
	}
	
    //是否第一次进入
    $jlf_weixin = 'christmas';
    $mem_sql = "select * from $jlf_weixin where openid='{$openId}' and disting='1'";
    $mem_res = mysqli_query($db, $mem_sql);
	if($mem_res)
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //第一次进入
    {
    	$sql = "insert into $jlf_weixin (openid,nickname,add_time,disting,per,is_prize) values ('{$openId}','{$wechaname}','" . date('Y-m-d H:i:s') . "','1','".$nowPer."',100)";
    	mysqli_query($db, $sql);
    }
?>
<!DOCTYPE html>
<html>
  <head>
      <title>全民解救圣诞老人</title>
      <meta charset="UTF-8">
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
	<script type="text/javascript">
		var wxDesc = '据可靠消息，圣诞老人在平安夜前突然消失，全民家居购贺岁大使朱丹厚礼悬赏，求助解救圣诞老人，你还不快来！';
		var wxTitle = '全民解救圣诞老人';
		var wxLink  = 'http://zt.jia360.com/christmas/index.php';
		var wxImgUrl = 'http://zt.jia360.com/christmas/resource/christmas/share.jpg';
	</script>		
      <script src="libs/core.min.js?v=8"></script>
      <script src="src/christmas/christmasRes.js?v=8"></script>
		<script src="src/Main.js?v=8"></script>
		<script type="text/javascript" src="js/jquery-1.11.0.js?v=8" ></script>
		<link rel="stylesheet" href="css/global.css?v=8"/>
      <style>
          body {
              text-align: center;
              background:#7bb4d1;
              padding: 0;
              border: 0;
              margin: 0;
              height: 100%;
          }
          html {
              -ms-touch-action: none; /* Direct all pointer events to JavaScript code. */
              overflow: hidden;
          }
          canvas {
              display:block;
              position:absolute;
              margin: 0 auto;
              padding: 0;
              border: 0;
          }
          #submitCon,#successCon,#cishuCon{position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 99999;background-color: rgba(0,0,0,0.9);display: none;}
          .submitCon_wh{width: 548px;height: 617px;background-color: #FFFFFF;border-radius: 25px;}
          .submitCon_inwh{height: 530px;}
          .common_div{width: 442px;line-height: 81px;min-height: 81px;text-align: left;background-color: #e3e3e3;margin: 0 auto;margin-bottom: 30px;}
         .submitCon_inwh h1{font-size: 2rem;width: 442px;height:90px;line-height:90px;}
          .common_div span{padding-left: 10px;}
          .common_div input{height: 81px;line-height: 81px;width: 320px;outline: 0;border: 0;font-size: 2rem;background-color: #e3e3e3;text-indent: 10px;}
      		#submitBtn{width: 442px;height: 90px;background-color: #5593cc;font-size: 3rem;line-height: 90px;color: #FFFFFF;}
      		.successCon_wh,.cishuCon_wh{width: 485px;height: 459px;background-color: #FFFFFF;border-radius: 25px;}
      		.playAgain{height: 90px;background-color: #5593cc;font-size: 3rem;line-height: 90px;color: #FFFFFF;margin-top: 90px;}
      </style>
  </head>
  <body>
  	<div id="Loading" style="position: fixed;top: 0;left: 0;bottom: 0;right: 0;z-index: 9999;background-color: #7bb4d1;">
  			<div style="width: 100%;height: 100%;position: relative;">
  					<img src="loading.gif?v=8" style="position: absolute;top: 50%;left: 50%;margin-top: -129px;margin-left: -220px;"/>
  			</div>
  	</div>
  	<div id="submitCon">
  		<div class="n_wrapper  ver">
  			<div class="submitCon_wh ver">
  					<div class="submitCon_inwh">
  						<h1 class="t_center" id="priceName">美的扫地机一台</h1>
  						<div class="common_div">
  						<span>您的姓名</span>
  						<input type="text" name="" id="user_name" value="" />
  					</div>
   					<div class="common_div">
  						<span>手机号码</span>
  						<input type="text" name="" id="user_phone" value="" />
  					</div>
  					<div class="common_div" id="adressCon">
  						<span>收货地址</span>
  						<input type="text" name="" id="user_adress" value="" />
  					</div>
  					<div id="submitBtn">
  						提交
  					</div>
  					</div>
  			</div>
  		</div>
  	</div>
  	<div id="successCon" >
  		<div class="n_wrapper ver">
  				<div class="successCon_wh ver">
  					<div style="width: 394px;height: 274px;">
  							<div style="font-size: 1.9rem;margin-top: 40px;">填写完成，我们会在7个工作日与您取得联系并送出礼品</div>
  							<div id="playAgain" class="playAgain" style="margin-top: 30px;">再玩一次</div>
  					</div>
  				</div>
  		</div>
  	</div>
  	<div id="cishuCon">
  		<div class="n_wrapper ver">
  			<div class="cishuCon_wh ver">
  					<div style="width: 394px;height: 250px;" class="ver pack_justify">
  							<div style="font-size: 1.9rem;margin-top: 0px;min-height: 42px;" id="alertTxt"></div>
  							<div id="shareBtn" class="playAgain" style="margin-top: 0;padding: 0 30px;">邀请好友参加</div>
  					</div>
  			</div>
  		</div>
  	</div>
  <div style="position:relative;" id="game">loading</div>
  <audio src="sound/bg.mp3" id="bgSound" loop="loop" preload="auto"></audio>
  <audio src="sound/aobama.mp3" id="aobama" loop="loop" preload="auto"></audio>
  <audio src="sound/boom.mp3" id="boom" preload="auto"></audio>
  <audio src="sound/chou.MP3" id="chou" preload="auto"></audio>
  <audio src="sound/click.mp3" id="click" preload="auto"></audio>
  <audio src="sound/mj.mp3"  id="mj" loop="loop" preload="auto"></audio>
  <audio src="sound/shengdan.mp3"  id="shengdan" loop="loop" preload="auto"></audio>
  <audio src="sound/jiaju.mp3"  id="jiaju" loop="loop" preload="auto"></audio>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

	<script type="text/javascript">
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
							"imgUrl":wxImgUrl,
							"link":wxLink,
							"desc":wxDesc,
							"title":wxTitle,
							success:function(){
								//分享成功，增加抽奖次数
								$.ajax({
									async:false,
									url: 'server.php',
									data:{act:'share'},
									type: "post",
									dataType:'json',
									success:function(result){
										alert('分享成功');
									}
								});
							}
						};
						wx.onMenuShareAppMessage(wxData);
						wx.onMenuShareTimeline(wxData);
					});
	  </script>

  <script>
  		function Audio(obj, cb) {
				document.getElementById(obj).addEventListener("touchstart", function() {
				cb();
		})
		var e = document.createEvent("MouseEvents");
		e.initEvent("touchstart", true, true);
		document.getElementById(obj).dispatchEvent(e);
	};

	Audio("bgSound",function(){
		document.getElementById("bgSound").play();
	});
	document.documentElement.style.height = window.innerHeight + 'px';


  </script>
  <!--#include virtual="/public/tongji.html"-->  
  </body>
</html>