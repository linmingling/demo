<?php
	require_once "../../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();

    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/code.css?v=1.0"/>
    <title>法恩莎卫浴</title>
</head>
<body>
<div class="WrapBg ver">
    <p style="text-align: center"><img id='Code' src="img/code/Mc_code.png" alt=""/></p>
    <p style="text-align: center"><img id="TxtCode" src="img/code/Mc_txt_code.png" alt=""/></p>
</div>
</body>
<script type='text/javascript' src='./libs/jquery-2.1.js'></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
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
            imgUrl:'http://zt.jia360.com/game/hxfes/images/fx.jpg',
            link:'http://zt.jia360.com/game/hxfes/index.php',
            desc:"最近城里的小伙伴最近都在玩！法恩莎卫浴免费大礼在招手",
            title:"法恩莎卫浴 关爱无边 健康无限",
        	success: function (res) {
        		share(0);
	   		}
        };
        wx.onMenuShareAppMessage(wxData);
        wx.onMenuShareTimeline(wxData);
    });
    function share(score){
		$.ajax({
            async:false,
            url:"server.php",
            data:{act:"share",score:score},
            type: 'post',
            dataType:'json',
            success:function(result){
            }
        });
    }
</script>
<!--#include virtual="/public/tongji.html"-->
</html>