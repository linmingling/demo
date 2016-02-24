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

// $_SESSION['redstar_love_openid'] = 'abc123123';
// $_SESSION['redstar_love_wechaname'] = 'hehehe';
// $_SESSION['redstar_love_headimgurl'] = 'images/user3.png';

// if(!isset($_POST['openid']))
if(!$_POST['openid'])
{
    $openId = $_SESSION['redstar_love_openid'];
    $wechaname = $_SESSION['redstar_love_wechaname'];
    $headimgurl = $_SESSION['redstar_love_headimgurl'];

    if(empty($openId))
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=redstar_love';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
}
else
{
    $openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $headimgurl = urldecode($_POST['headimgurl']);
    $_SESSION['redstar_love_openid'] = $openId;
    $_SESSION['redstar_love_wechaname'] = $wechaname;
    $_SESSION['redstar_love_headimgurl'] = $headimgurl;
}

$nick = '芝华仕';
if(isset($_GET['nick']))
	$nick = urldecode($_GET['nick']);

$bg = 1;
if(isset($_GET['bg']))
	$bg = $_GET['bg'];
echo 'abc';
echo $wechaname;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
    </script>
    <script type="text/javascript" src="libs/jquery-2.1.js"></script>
     <script type="text/javascript">
            var MenuIndex = "<?php echo $bg?>";//不同状态1:家人,2:恋人,3:朋友,4:领导
            var UserName = "<?php echo $nick?>";//昵称
        </script>
    <title>谢谢你在我生命的每一天</title>
</head>
<body>
	<input type="hidden" name="bgid" id="bgid" value="1"/>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
alert(MenuIndex +' '+UserName);

$(document).ready(function () {	  
        //微信分享控制
        wx.config({
            debug: true,
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
            var vname = "<?php echo $wechaname;?>";
            var bg = $("#bgid").val();
            var wxData = {
                "imgUrl": 'http://zt.jia360.com/zhs_love/images/share.jpg',
                "link": 'http://zt.jia360.com/zhs_love/test.php?a=a&nick=' + vname + '&bg=' + bg,
                "desc": "谢谢你在我生命的每一天！我要把舒适送给你,因为你是我在乎的人！",
                "title": "用心去爱 芝华仕邀您坐头等舱看大片",
				  success: function () { 
						alert('成功'+'http://zt.jia360.com/zhs_love/test.php?a=a&nick=' + vname + '&bg=' + bg);
					},
					cancel: function () { 
						alert('失败'+'http://zt.jia360.com/zhs_love/test.php?a=a&nick=' + vname + '&bg=' + bg);
					},
					fail: function () { 
						alert('失败'+'http://zt.jia360.com/zhs_love/test.php?a=a&nick=' + vname + '&bg=' + bg);
					}
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
		
		
		
});
</script>
</body>
</html>