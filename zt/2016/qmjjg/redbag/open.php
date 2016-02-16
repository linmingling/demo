<?php
header("Content-Type: text/html;charset=utf-8");
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
require($rootPath.'/data/config.php');
require($rootPath.'/data/jssdk.php');

$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$debug = FALSE;	// TRUE OR FALSE 是否开启调试模式

/*
* 判断是否微信环境
*/
 $agent = $_SERVER['HTTP_USER_AGENT'];
 if(!strpos($agent,"MicroMessenger") && $debug === FALSE ){
	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
} 

/*
* 获取openId
*/

$openId = $_SESSION['openid'];
if( empty($openId) ){
	$userinfo = $jssdk->getOauth();
	$_SESSION['openid']		= $userinfo['openid'];
	$_SESSION['nickname']	= $userinfo['wechaname'];
	$_SESSION['headimgurl'] = $userinfo['headimgurl'];
} 

if( $debug === TRUE ) {
	//$_SESSION['openid']		= md5(uniqid());
	$_SESSION['openid']		= 'ABCDEFG';
	$_SESSION['nickname']	= 'test';
	$_SESSION['headimgurl'] = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
		
		<!-- 微信分享控制 -->
		var wxDesc = '全民家居购携手朱丹派发开工利是，数万红包抢光为止。呼朋唤友，小心错过一个亿！';
		var wxTitle = '开工利是-“乐抢开门红”';
		var wxLink  = 'http://zt.jia360.com/2016/qmjjg/redbag/index.php';
		var wxImgUrl = 'http://zt.jia360.com/2016/qmjjg/redbag/images/share.jpg';
		
    </script>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/open.css"/>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=1"></script>	
    <title>开工利是-“乐抢开门红”</title>
</head>
<body>
<div id="BagModule" class="n_wrapper ver hidden">
    <div class="f_wrapper ver">
        <div class="relative">
            <img src="images/Mc_bg_open.png" alt=""/>
            <img src="images/Mc_horn.png" class="Mc_horn"/>
            <img src="images/Btn_open.png" id="Btn_open"/>
            <img src="images/Mc_txt_code.png" class="Mc_txt_code"/>
            <img src="images/Mc_txt_tip1.png" class="Mc_txt_tip1"/>
            <input type="text" id="Txt_code" value="HB201602"/>
        </div>
    </div>
</div>
<div id="ResultModule" class="n_wrapper ver hidden">
    <div class="f_wrapper ver">
        <div class="relative">
            <img src="images/Mc_bg_open.png" alt=""/>
            <img src="images/Mc_txt_open.png" class="Mc_txt_open"/>
            <img src="images/Btn_share2.png" id="Btn_share2"/>
            <img src="images/Mc_txt_tip1.png" class="Mc_txt_tip1"/>
            <p id="Txt_money"><strong>0.00</strong>元</p>
        </div>
    </div>
</div>
<div id="ShareModule" class="n_wrapper ver">
    <div class="f_wrapper hidden relative Mc_mask">
        <img src="images/Mc_arrow.png" class="Mc_arrow"/>
        <img src="images/P5_txt1.png" class="P5_txt1"/>
    </div>
</div>
<img src="images/P2_logo1.png" class="P2_logo1"/>
<img src="images/P3_logo2.png" class="P3_logo2"/>
	
<script type="text/javascript" charset="UTF-8">
	//微信分享设置
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

	// 分享
	wx.ready(function () {  
		var wxData = {
			"imgUrl":wxImgUrl,
			"link":wxLink,
			"desc":wxDesc,
			"title":wxTitle,
			success: function() {
			}
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});

    var money_url="server.php";
    $("#ShareModule").on("click", function () {
        $("#ShareModule").fadeOut();
    });
    $("#Btn_share2").on("click", function () {
        $("#ShareModule").css({display:"-webkit-box"});
    });
    $("#Btn_open").on("click", function () {
		alert('红包已领完，更多精彩请关注全民家居购其他活动');
        /* var Regx = /^[A-Za-z0-9]$/;
        var codeStr = $("#Txt_code").val();
        if (codeStr == "") {
            alert("请正确输入红包代码!");
        } else if (Regx.test(codeStr)) {
            alert("请正确输入红包代码!");
        } else {
            $.ajax({
                type: "POST",
                url: money_url,
                data: {
                    "act": "get_money",
                    "code": codeStr // 输入的兑换码
                },
                dataType: "json",
                success: function (data) {
					data.errCode = parseInt(data.errCode );
                    if (data.errCode != 0) {
						alert(data.errMsg);
                    } else {
                        $("#BagModule").fadeOut();
                        $("#ResultModule").css({display:"-webkit-box"});
                        $("#Txt_money strong").html(data.money);
                    }
                },
                error: function (XMLHttpRequest) {
                    if (XMLHttpRequest.readyState != '4') {
                        alert("网络异常,请稍后重试");
                    }
                }
            });
        } */
		
    })
</script>
<!--#include virtual="/public/tongji.html"-->  
</body>
</html>