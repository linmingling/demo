<?php
	require_once "../../data/jssdk.php";
	require_once "server.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();

    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    echo "<script>alert('活动已结束！')</script>";
    //微信授权
    if(!$_POST['openid']){
        $openId = $_SESSION['zabwz_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=com_share';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['zabwz_openid'] = $_POST['openid'];
        $_SESSION['zabwz_wechaname'] = base64_decode($_POST['wechaname']);
    }
// 	$_SESSION['zabwz_openid'] = '1112111';
// 	$_SESSION['zabwz_wechaname'] = 'wechaname';

    $sql = "SELECT id from game_zabwz WHERE openid='".$_SESSION['zabwz_openid']."'";
    $res = mysqli_query($db, $sql);
    $info = $res->fetch_assoc();
    if(!$info){
        $sql = "INSERT INTO game_zabwz(openid, wechaname, score, add_time) VALUES('".$_SESSION['zabwz_openid']."','".$_SESSION['zabwz_wechaname']."','0','".date('Y-m-d H:i:s')."')";
        $url = mysqli_query($db, $sql);
        if(!$url){
            echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
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

    <link rel="stylesheet" href="css/global.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/allmodule.css"/>
    <script src='./libs/jquery-2.1.js' type='text/javascript'></script>
    <script src='./libs/lufylegend-1.9.9.simple.js' type='text/javascript'></script>
    <script src='./libs/JOMOO_Ninja.min.js?v=1.2' type='text/javascript'></script>

    <script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    <script src="../../public/crypto/core-min.js"></script>
    <script src="../../public/crypto/enc-utf16-min.js"></script>
    <script src="../../public/crypto/sha1-min.js"></script>
    <script src="../../public/crypto/md5-min.js"></script>
    <script src="../../public/crypto/aes.js"></script>
    <script src="../../public/crypto/bigint.js"></script>
    <script src="../../public/crypto/secret_new.js?v=1.3"></script>
    <title>九牧卫浴·智爱保卫战</title>
    <script type="text/javascript">
        function setWidth(a) {
            //为了防止拉动	
            if (/Andriod/i.test(navigator.userAgent)) {
                var c, b = window.innerWidth;
                (b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function () {
                    var d = document.getElementsByTagName("body")[0];
                    d.style.webkitTransformOrigin = "left top";
                    d.style.webkitTransform = "scale(" + c + ")"
                }, !1)
            }
        }
        setWidth(640);
    </script>
    <style>
        #loading {
            position: absolute;
            z-index: 2;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }
        #loading p {
            font-size: 60px;
            color: #ffffff;
        }
    </style>
</head>
<body style="margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;background:#000;overflow: hidden">
<div id="loading" class="ver">
    <img src="images/loading.png">

    <p id="loading_txt"></p>
</div>
<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="true"></audio>
<div id="lufyLegend"></div>
<div id="tips" style=" background-color:#ffffff;width: 100%;height: 100%;display: none">
    <div style="top:50%;position: absolute;;z-index: 100; width: 100%">
        <div style="color:#ffffff;text-align: center; width: 100%;font-size:30px;font-family:'黑体'">
            为了更好的体验游戏，请选择竖屏模式进行游戏
        </div>
    </div>
</div>
<div id="mesModule" class="fixed">
    <div class="n_wrapper ver b_mask">
        <div class="relative">
            <img src="images/end.png"/>
            <div class="m_div_1 hor"><img src="images/mestxt1.png"/><span id="score">12323</span><img src="images/mestxt2.png"/></div>
            <div class="m_div_2"><img src="images/mestxt3.png"/></div>
            <input type="tel" name="tel" value="" id="phone" placeholder="输入手机号码"/>
        </div>
        <p class="t_center"><img src="images/submit.png" id="submitBtn"/></p>
    </div>
</div>
<div id="successModuel" class="fixed">
    <div class="n_wrapper ver b_mask">
        <img src="images/success.png"/>
        <p class="t_center"><img src="images/shareBtn.png" id="shareBtn"/></p>
        <p class="t_center"><img src="images/resBtn.png" id="resBtn"/></p>
    </div>
</div>
<div id="shareModuel" class="fixed" style="display: none">
    <div class="n_wrapper b_mask">
        <p class="t_right"><img src="images/Mc_arrow.png"/></p>
    </div>
</div>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    function sub_score(text){
    	wx.ready(function () {
			wxData = {
				imgUrl:'http://zt.jia360.com/game/zabwz/images/fx.jpg',
	            link:'http://zt.jia360.com/game/zabwz/index.php',
	            desc:"恭喜你得到"+text+"分，智爱保卫战护周全，赶快行动起来！",
				title:"九牧卫浴·智爱保卫战",
				success: function (res) {
				}
			};
			wxData2 = {
				imgUrl:"http://zt.jia360.com/game/zabwz/images/fx.jpg",
				link:"http://zt.jia360.com/game/zabwz/index.php",
				title:"恭喜你得到"+text+"分，智爱保卫战护周全，赶快行动起来！",
				success: function (res) {
				}
			};
			wx.onMenuShareTimeline(wxData2);
			wx.onMenuShareAppMessage(wxData);
		});
        var _0x3dd1=["\x70\x61\x72\x73\x65","\x55\x74\x66\x38","\x65\x6E\x63","\x32\x30\x31\x35\x30\x33\x31\x33\x35\x38\x34\x35\x32\x36\x39\x31","\x65\x6E\x63\x72\x79\x70\x74","\x41\x45\x53"];var md5_secret=CryptoJS.MD5(secret);var key=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](md5_secret);var iv=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](_0x3dd1[3]);var encrypted=CryptoJS[_0x3dd1[5]][_0x3dd1[4]](text.toString(),key,{iv:iv});var scoreStr=encrypted.toString();
        $.ajax({
            async:false,
            url:"server.php",
            data:{act:"score", score:scoreStr},
            type: 'post',
            dataType:'json',
            success:function(result){
                if(result.errcode) {
                    alert(result.errmsg);
                } else {
                    if(result.phone){
                        openModuel("successModuel");
                        closeModuel("mesModule");
                    } else {
                        openModuel("mesModule");
                    }
                }
            }
        });
    }
    //说明：
    //mesModule ——>留资页模块
    //successModuel ——>留资成功模块
    var phone = document.getElementById("phone");
    phone.addEventListener(Event.MOUSEDOWN, function () {
        phone.focus()
    });
    var submitBtn = document.getElementById("submitBtn");
    submitBtn.addEventListener(Event.MOUSEDOWN, function () {
        //提交信息按钮
        var tel = $("#phone").val();
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
        if(!mob.test(tel)){
            alert("请填入正确的手机号码！");
        } else {
            $.ajax({
                async:true,
                url:"server.php",
                data:{act:"submit", tel:tel},
                type: 'post',
                dataType:'json',
                success:function(result){
                    if(result.errcode) {
                        alert(result.errmsg);
                    } else {
                        closeModuel("mesModule");
                        openModuel("successModuel");
                    }
                }
            })
        }
    })
    var shareBtn = document.getElementById("shareBtn");
    shareBtn.addEventListener(Event.MOUSEDOWN, function () {
        //分享按钮
        openModuel("shareModuel");
    });
    var resBtn = document.getElementById("resBtn");
    resBtn.addEventListener(Event.MOUSEDOWN, function () {
        //返回按钮
        closeModuel("successModuel");
        closeModuel("mesModule");
        GameRestart();
    });
    document.getElementById("shareModuel").addEventListener(Event.MOUSEDOWN,function(){
        closeModuel("shareModuel");
        closeModuel("mesModule");
    });
</script>
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
            imgUrl:'http://zt.jia360.com/game/zabwz/images/fx.jpg',
            link:'http://zt.jia360.com/game/zabwz/index.php',
            desc:"九牧卫浴·智爱保卫战",
            title:"九牧卫浴·智爱保卫战"
        };
        wx.onMenuShareAppMessage(wxData);
        wx.onMenuShareTimeline(wxData);
    });
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>	
	
