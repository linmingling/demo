<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$dzr_openid = empty($_REQUEST['openid']) ? '' : $_REQUEST['openid'];
if($dzr_openid){
    $_SESSION['dzr_openid'] = $dzr_openid;
} else {
    if(empty($_SESSION['dzr_openid'])){
        $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
        $redirect_url = 'http://www.yoju360.com/api/Across_oauth.php?scope=snsapi_base&url='.$url;//静默授权
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
    }
}

$sql = "SELECT id,draw_time from dzr_yy WHERE openid='".$_SESSION['dzr_openid']."'";
$res = mysqli_query($db, $sql);
$arr = array();
while($row = $res->fetch_array()){
    $arr = $row;
}
if(empty($arr['id'])){
    $sql = "INSERT INTO dzr_yy(openid, prize_name, num, draw_time, add_time) VALUES('".$_SESSION['dzr_openid']."','','3','".time()."','".date("Y-m-d H:i:s",time())."')";
    mysqli_query($db, $sql);
} else {
    $time = strtotime(date('Y-m-d',time()));
    $old_time = strtotime(date('Y-m-d',$arr['draw_time']));
    $new_time = ($time - $old_time)/86400;
    if($new_time >= 1){
        $sql = "UPDATE dzr_yy SET num='3' WHERE openid='".$_SESSION['dzr_openid']."'";
        $url = mysqli_query($db, $sql);
    }
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然地板摇一摇</title>
<meta name="keywords" content="I won't let you down ，大自然地板摇一摇" />
<meta name="description" content="I won't let you down ，大自然地板摇一摇" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.9"  />

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
   <!-- input居然不能放在swiper里面！！！ -->
	 <div class="cn cn4 hide">
		<div class="cp3">
			<p class="cp3-1">填写兑奖信息</p>
			<p class="cp3-2">请准确填写个人信息以便主办方联系兑奖。</p>
			<p class="cp3-3">姓名：</p>
			<p class="cp3-4"><input type="text" id= "name" name="name" placeholder="请输入您的姓名" value=""/></p>
	        <p class="cp3-5">手机号码：</p>
	        <p class="cp3-4"><input type="text" id="phone" name="phone" placeholder="请输入您的手机号" value="" /></p>
	        <p class="cp3-5">省份：</p>
	        <p class="cp3-6" id="citylist">
				<input type="text" id="prov" name="prov" placeholder="请输入所在省份" value="" /><br/>
	    		&nbsp;&nbsp;城市：<br/><input type="text" id="city" name="city" placeholder="请输入所在城市" value="" />
	        </p>
	        <p class="cp3-7" id="submit"><img src="images/4-1.png"></p>
		</div>
</div>
	<!-- end -->
   <div class="swiper-container swiper-pages" id="swiper-container1">
   		<!--音乐  -->
		<div id="music">	
			<audio class="audio hide"  id="musicBox" preload="auto" loop="true" ></audio>
		</div>
		<div class="swiper-wrapper" id="wrapper">
			
			<!--5-->
			<div class="swiper-slide page-1" id="page-1">
				<div class="container">
					<div class="wraper">
						<!-- 活动摇一摇 START-->
							<div class="main">
								<!-- 首页 -->
								<div class="cn cn1">
									<div class="click"><img src="images/1-2.png"></div>
								</div>
								<!-- 摇一摇 -->
								<div class="cn cn2 hide">
                                   <div class="jt"><img src="images/jt.png"></div>
									<div class="yao handImg"><img src="images/yao.png"></div>
								</div>
								<!-- 摇一摇礼品 -->
								<div class="cn cn3 hide">
									<div class="cp1">
										<span class="num"></span>
									</div>
									<span class="cp2" id="sure"><img src="images/3-2.png"></span>
								</div>
                                <!-- 摇一摇不中奖 -->
                               <div class="cn cn6 sy2 hide">
                                    <div class="mz zyyc"><img src="images/2-1.png"></div>
							   </div>
                               <!-- 摇一摇不中奖用完3次机会-->
                               <div class="cn cn6 sy3 hide">
                                    <div class="yw jss"><img src="images/2-2.png"></div>
							   </div>
							   <div class="cn cn6 sy1 hide">
                                    <div class="yw zyyc"><img src="images/2-3.png"></div>
							   </div>
								<!-- 二维码居然不能放在swiper里面！！！-->
								<div class="cn cn5 hide">
									<img src="images/5-2.jpg">
									<img src="images/share1.png" class="share hide">
									<!--#include virtual="/public/Copyright.html"-->
								</div>
							</div>
						<!-- end -->


					</div>
				</div>
			</div>


	   </div>
	</div>
	<div class="cn-slidetips">
		
	</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/com.js?v=1.9"></script>
<script>
	//微信分享控制
	wx.config({
		  debug: false,
	      appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
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
			"imgUrl":'http://zt.jia360.com/dzr_yy/images/1-1.jpg',
			"link":'http://zt.jia360.com/dzr_yy/index.php',
			"desc":"I won't let you down ，这个周末我和爸爸约惠-大自然",
			"title":"大自然地板摇一摇"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>