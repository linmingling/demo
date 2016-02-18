<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
    echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

$openid = empty($_REQUEST['openid']) ? '' : $_REQUEST['openid'];
$wechaname = empty($_REQUEST['wechaname']) ? '' : $_REQUEST['wechaname'];

// $openid = '123123aaaa';
// $wechaname = '123123saaa';
if($openid){
    $_SESSION['dp_cx_openid'] = $openid;
    $_SESSION['dp_cx_wechaname'] = $wechaname;
} else {
    if(empty($_SESSION['dp_cx_openid'])){
        $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        $redirect_url = 'http://www.yoju360.com/api/Across_oauth.php?scope=snsapi_userinfo&cookie_name=abc&url='.$url;//静默授权
       echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
    }
}



if($openid){
    $check_sql = "select openid from dp_cx where openid='".$openid."'";
    $url = mysqli_query($db, $check_sql);
    $arr = array();
    while($row = $url->fetch_array()){
        $arr = $row;
    }
    if(!$arr){
        $sql = "INSERT INTO dp_cx(add_time, add_strtotime, last_time,openid,wechaname) VALUES('".date('Y-m-d H:i:s', time())."','".time()."','".time()."','{$openid}','{$wechaname}')";
        mysqli_query($db, $sql);
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>东鹏品牌形象代言人全民大猜想</title>
<meta name="keywords" content="东鹏品牌 形象代言人 全民 大猜想" />
<meta name="description" content="东鹏品牌 形象代言人 全民 大猜想" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.5"  />

</head>
<body>
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
	<div id="black_bg" class="black_bg hide">
		<img src="images/rule-bg.png"  class="rule-bg" />
		<img src="images/close.png" class="rule-close" />
		<span class="rule-box"><img src="images/rule.png" /></span>
	</div>
	<div id="tips_bg" class="tips_bg hide">
		<img src="images/tips-bg.png"  class="tips-bg" />
		<img src="images/close2.png" class="tips-close" />
		<span class="tips-box" id="tips-box"><img src="images/ans4.png" /></span>
	</div>
	<div id="share_bg" class="share_bg hide">
		<img src="images/share_bg.png"  class="share-bg" />
	</div>
	<div id="form_bg" class="form_bg hide">
		<img src="images/bg.jpg" class="form-bg" />
		<p class="form-logo"><img src="images/logo.png" /></p>
		<p class="form-title"><img src="images/p4-title.png" /></p>
		<p class="form-name" >
			<input type="text" class="input-text" placeholder="姓名" id="name"/>
		</p>
		<p class="form-phone">
			<input type="text" class="input-text" placeholder="联系电话" id="phone" />
		</p>
		<p class="form-submit" id="infoSubmit">
	        <img src="images/submit-btn.png"/>
		</p>
	</div>
	<div id="music">
		<a href="javascript:void(0)" class="open musicBtn" ></a>
		<audio class="audio hide"  id="musicBox" preload="auto" loop="true" src="images/music.mp3"  style="height:0"></audio>
	</div>
   <div class="swiper-container swiper-pages" id="swiper-container1">
        <div class="swiper-wrapper" id="wrapper">
			<!--首页-->
			<div class="swiper-slide page-1 ps1">
			  <div class="container">
		  		<div class="am am1 bg">

				</div>
				<div class="am am2 logo">
					<img src="images/logo.png" class="animation an3" data-item="an3" data-delay="200" data-animation="fadeInDown" />
				</div>
				<div class="am am3">
					<img src="images/ta-g.png" class="animation an5" data-item="an5" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
		                <img src="images/ta-f.png"  class="animation an6" data-item="an6" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next" class="click-btn">
		                <img src="images/next-btn.png" class="animation an8" data-item="an8" data-delay="1700" data-animation="fadeInDown"/>
		            </a>
				</div>
				<div class="am am6">
		                <img src="images/ta-s.png"  class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am7 detail-btn">
		                <img src="images/detail-btn.png"  class="animation an4" data-item="an4" data-delay="500" data-animation="fadeInDown"/>
				</div>

			  </div>
			</div>

			<!--page2-->
			<div class="swiper-slide page-2 ps2">
			  <div class="container">
		  		<div class="am am1 backindex">
                    返回
				</div>
				<div class="am am2 logo">
					<img src="images/logo.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInDown" />
				</div>
				<div class="am am3">
					<img src="images/tips-line.png" class="animation an3" data-item="an3" data-delay="500" data-animation="fadeInDown"/>
				</div>
				<div class="am am4 get-tips" data="1">
					<img src="images/tips1.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am6 get-tips" data="2">
					<img src="images/tips2.png" class="animation an5" data-item="an5" data-delay="1100" data-animation="fadeInDown"/>
				</div>
				<div class="am am7 get-tips" data="3">
					<img src="images/tips3.png"  class="animation an6" data-item="an6" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am8 get-tips" data="4">
					<img src="images/tips4.png"  class="animation an7" data-item="an7" data-delay="1700" data-animation="fadeInDown"/>
				</div>
				<div class="am am9 get-tips" data="5">
					<img src="images/tips5.png" class="animation an8"  data-item="an8" data-delay="2000" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<a href="javascript:void(0);" title="NEXT" id="next2" class="click-btn">
		                <img src="images/iknow.png" class="animation an9" data-item="an9" data-delay="2300" data-animation="fadeInDown"/>
		            </a>
				</div>
			  </div>
          	</div>

			<!--page3-->
			<div class="swiper-slide page-3 ps3">
			  <div class="container">
				<div class="am am1 backindex">
                    返回
				</div>
				<div class="am am2">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3">
					<img src="images/p3-title.png"/>
				</div>
				<div class="am am4 select-ans" data="4" ans="赵薇">
					<img src="images/zw.png"/>
					<i class="showSelect4"></i>
				</div>

				<div class="am am5" id="gSubmit">
					<a href="javascript:void(0);"  class="click-btn">
		                <img src="images/g-submit.png" />
		            </a>
				</div>
				<div class="am am6 select-ans" data="6" ans="孙俪">
					<img src="images/sl.png" />
					<i class="showSelect6"></i>
				</div>


				<div class="am am7 select-ans" data="7" ans="刘涛">
					<img src="images/lt.png" />
					<i class="showSelect7"></i>
				</div>
				<div class="am am8 select-ans" data="8" ans="高圆圆">
					<img src="images/gyy.png" />
					<i class="showSelect8"></i>
				</div>
			  </div>
			</div>

             <!--page4-->
            <div class="swiper-slide page-4 ps4 ">
			  <div class="container">
				
				

			  </div>
			</div>

			<!--page5-->
			<div class="swiper-slide page-5 ps5">
			  <div class="container">
				<div class="am am1 bg">
				</div>
				<div class="am am2">
					<img src="images/logo.png"  />
				</div>
				<div class="am am3 share-btn">
					<img src="images/p5-title.png"/>
				</div>
				
			  </div>
			</div>

			 

			




       </div>
    </div>
    <!--div class="cn-slidetips">
        <div class="slidetips">
            <a href="javascript:void(0);" title="NEXT" id="next" class="next">
                <img src="images/next.png" />
            </a>
        </div>
    </div-->

<script src="js/zepto.min.js"></script>
<script src="js/touch.js"></script>
<script src="js/fx.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.1"></script>
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
			"imgUrl":'http://zt.jia360.com/dp_cx/images/share.jpg',
			"link":'http://zt.jia360.com/dp_cx/index.php',
			"desc":"我猜我猜我猜猜猜，猜猜东鹏代言人得大奖！",
			"title":"东鹏品牌形象代言人全民大猜想"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>

<!--#include virtual="/public/tongji.html"-->

</body>
</html>