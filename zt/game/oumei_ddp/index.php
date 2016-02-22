<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require_once "../../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){ 
    echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

// $_SESSION['oumei_ddp_openid'] = 'abc123123';
// $_SESSION['oumei_ddp_wechaname'] = 'hehehe';
// $_SESSION['oumei_ddp_headurl'] = 'abcaaa';
// $openId = $_SESSION['oumei_ddp_openid'];
// $wechaname = $_SESSION['oumei_ddp_wechaname'];

//if(!isset($_POST['openid']))
if(!$_POST['openid'])
{
    $openId = $_SESSION['oumei_ddp_openid'];
    $wechaname = $_SESSION['oumei_ddp_wechaname'];
    $headurl = $_SESSION['oumei_ddp_headurl'];

    if(empty($openId))
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=oumei_ddp';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
}
else 
{
    $openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $headurl = urldecode($_POST['headimgurl']);
    $_SESSION['oumei_ddp_openid'] = $openId;
    $_SESSION['oumei_ddp_wechaname'] = $wechaname;
    $_SESSION['oumei_ddp_headurl'] = $headurl;
}

$check_sql = "select openid from game_oumei_ddp where openid='{$openId}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if(empty($check_row))
{
    $sql = "INSERT INTO game_oumei_ddp(add_time, last_time, openid, nickname, headurl) VALUES('".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$openId."','" . $wechaname . "','{$headurl}')";
    mysqli_query($db, $sql);
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


    <script src='./libs/jquery-2.1.js' type='text/javascript'></script>
    <script src='./libs/lufylegend-1.9.9.simple.js' type='text/javascript'></script>
    <script src='./libs/OUMEI_Bejeweled.min.js' type='text/javascript'></script>
    
    <script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    <script src="../../public/crypto/core-min.js"></script>
    <script src="../../public/crypto/enc-utf16-min.js"></script>
    <script src="../../public/crypto/sha1-min.js"></script>
    <script src="../../public/crypto/md5-min.js"></script>
    <script src="../../public/crypto/aes.js"></script>
    <script src="../../public/crypto/bigint.js"></script>
    <script src="../../public/crypto/secret_new.js?v=1.2"></script>



    <title>欧美陶瓷 新品对对碰 赢apple watch</title>
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
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .ver {
            display: -webkit-box;
            display: -ms-flexbox;
            -webkit-box-orient: vertical;
            -ms-flex-direction: column;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
        }

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
<body style="margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;background:#9a3eb6;overflow: hidden">
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
var wxData = {
    imgUrl:'http://zt.jia360.com/game/oumei_ddp/images/share.jpg',
    link:'http://zt.jia360.com/game/oumei_ddp/index.php',
    desc:"小瓷终于等到您了，快跟我们瓷砖小萌宠一起玩对对碰吧！",
    title:"欧美陶瓷 新品对对碰 赢apple watch"
};
wx.ready(function () {

	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>	
	
