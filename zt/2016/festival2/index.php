<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../data/config.php');
	require_once(ROOT_PATH .'../../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();

    $agent = $_SERVER['HTTP_USER_AGENT'];
     if(!strpos($agent,"MicroMessenger")){
    	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    
    /* $_SESSION['fest3_openid'] = '87569';
    $_SESSION['fest3_wechaname'] = 'dsghgdad';
    $_SESSION['fest3_headurl'] = 'baidu.com'; */
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
		
    	$openId = $_SESSION['fest3_openid'];
    	$wechaname = $_SESSION['fest3_wechaname'];
    	$headurl = $_SESSION['fest3_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=fest3';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {		
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['fest3_openid'] = $openId;
    	$_SESSION['fest3_wechaname'] = $wechaname;
    	$_SESSION['fest3_headurl'] = $headurl;
    }
	
    //获得公司区分
    $mem_sql = "select * from festival2016_ld as ld,festival2016_ld_user as user where ld.user_id=user.user_id and ld.openid='{$openId}'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
		
	$sign = '';
	if(!empty($mem_row))
    {		
		$sign = $mem_row['company'];
	}else{
		$sign = '-1';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="format-detection" content="telephone=no, email=no"/>
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
                (b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function () {
                    var d = document.getElementsByTagName("body")[0];
                    d.style.webkitTransformOrigin = "left top";
                    d.style.webkitTransform = "scale(" + c + ")";
                }, !1)
            }
        }
        setWidth(640);
		var sig = '<?php echo $sign;?>';
    </script>
    <title>摇一摇抽大奖</title>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js"></script>
</head>
<body>
<div id="ShakeModule" class="n_wrapper ver">
    <div class="f_wrapper ver" id="ShowBox">
        <p><img src="images/Mc_logo.png" class="Mc_logo"/></p>

        <p><img src="images/Mc_tit.png" class="Mc_tit"/></p>

        <div class="relative" id="ShakeBox">
            <div id="Mc_back" class="BackAni">
            </div>
            <div id="ShakeCircle">
                <div>
                    <img src="images/Mc_hand.png" class="Mc_hand HandAni"/>
                </div>

            </div>
        </div>
        <p id="Txt_user" style="display:none">欢迎您,*****用户</p>

        <div id="CodeBox" class="relative">
            <img src="images/Btn_law.png" id="Btn_law"/>
            <img src="images/Mc_QR.png" id="Mc_QR"/>
        </div>
    </div>
</div>

<div id="LoadModule" class="n_wrapper">
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
<script type="text/javascript" charset="UTF-8" src="libs/Main.js"></script>
</body>
</html>
