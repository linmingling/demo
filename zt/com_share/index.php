<?php
require_once "../data/jssdk.php";
require_once "server.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
    echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

// //微信授权
if(!$_POST['openid']){
    $openId = $_SESSION['com_openid'];
    if(empty($openId)){
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=com_share';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
} else {
    $_SESSION['com_openid'] = $_POST['openid'];
    $_SESSION['com_wechaname'] = base64_decode($_POST['wechaname']);
}
// $_SESSION['com_openid'] = '1112111';
// $_SESSION['com_wechaname'] = 'wechaname';

$sql = "SELECT id,prize_code,is_receive from com_share WHERE openid='".$_SESSION['com_openid']."'";
$res = mysqli_query($db, $sql);
$arr = array();
while($row = $res->fetch_array()){
    $arr = $row;
}
if(!$arr){
    $sql = "INSERT INTO com_share(openid, wechaname, prize_code, prize, add_time, is_receive) VALUES('".$_SESSION['com_openid']."','".$_SESSION['com_wechaname']."','0','','".date('Y-m-d H:i:s')."','0')";
    $url = mysqli_query($db, $sql);
    if(!$url){
         echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
    }
    $page = 0;
    $is_receive = 0;
} else {
    if($arr['prize_code']){
        $page = $arr['prize_code'] + 1;
    } else {
        $page = 0;
    }
    $is_receive = $arr['is_receive'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>COM分享会</title>
<meta name="keywords" content="COM分享会" />
<meta name="description" content="COM分享会" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />

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

                  <div class="swiper-slide page-1">
					  <div class="container">
							<div class="am am1">
								<img src="images/p1_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
								<img src="images/p1_2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="bounceIn"/>
								<div class="shake">
									<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="600" data-animation="bounceIn"/>
								</div>
								<img src="images/p1_4.png" class="animation an4" data-item="an4" data-delay="800" data-animation="bounceIn"/>
							</div>
							<div class="am am2">
								<p>腾讯网·亚太家居UED出品</p>
							</div>
					  </div>
                  </div>

                  <div class="swiper-slide page-2">
					  <div class="container">
							<div class="am am1">
								<img src="images/p2_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
								<img src="images/p2_2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="bounceIn"/>
							</div>
					  </div>                
				  </div>

				  <div class="swiper-slide page-3">
					  <div class="container">
							<div class="am am1">
								<img src="" date-src="images/jp_bg.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
								<img src="" date-src="images/jp1.png" class="animation an1 jp" />
								<div class="btnBox animation an2" data-item="an2" data-delay="400" data-animation="bounceIn">
									<!-- 可领取状态 -->
									<img src="" date-src="images/btn1.png" class="btn1"/>
									<img src="" date-src="images/btn2.png" class="btn2 hide"/>
									
									<p class="tips">请到签到处由工作人员点击领取</p>
								</div>
							</div>
					  </div>                
				  </div>
				  
				  <div class="swiper-slide page-4">
					  <div class="container">
							<div class="am am1">
								<img src="" date-src="images/jp_bg.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
								<img src="" date-src="images/jp2.png" class="animation an1 jp" />
								<div class="btnBox animation an2" data-item="an2" data-delay="400" data-animation="bounceIn">
									<!-- 可领取状态 -->
									<img src="" date-src="images/btn1.png" class="btn1"/>
									<img src="" date-src="images/btn2.png" class="btn2 hide"/>
									
									<p class="tips">请到签到处由工作人员点击领取</p>
								</div>
							</div>
					  </div>                
				  </div>
           </div>
        </div>
        
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.4"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
	// page 0：未抽奖  2：扫地机  3：公仔
	var page = <?php echo $page ?>;
	var is_receive = <?php echo $is_receive ?>;
	if(is_receive){
		$(".btnBox .btn1").hide();
	    $(".btnBox .btn2").show();
	}
</script>
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
			"imgUrl":'http://zt.jia360.com/com_share/images/p1_3.png',
			"link":'http://zt.jia360.com/com_share/',
			"desc":"互联网效果营销暨第二届七夕家装节分享会",
			"title":"COM分享会"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>