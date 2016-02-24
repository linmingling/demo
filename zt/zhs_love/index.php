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

if($_GET['mcid'])
{
	$formid = $_GET['mcid'];
}
else
{
	$formid = 0;
}

$check_sql = "select id,wechaname from zhs_love where openid='{$openId}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if(empty($check_row))
{
	$sql = "INSERT INTO zhs_love(add_time, openid,wechaname,from_id) VALUES('".date('Y-m-d H:i:s', time())."','".$openId."','" . $wechaname . "','". $formid ."')";
	mysqli_query($db, $sql);
	$mcid = mysqli_insert_id($db);	
}
else
{
	$mcid = $check_row['id'];
}


$nick = '芝华仕';
$bg = 1;

if($_GET['mcid'])
{
	$check_sql2 = "select wechaname from zhs_love where id='{$formid}'";
	$check_res2 = mysqli_query($db,$check_sql2);
	$check_row2 = $check_res2->fetch_assoc();
	if(!empty($check_row2))
	{
		$nick = $check_row2['wechaname'];
	}
}

if(isset($_GET['bg'])) 
	$bg = $_GET['bg'];
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
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" src="libs/swiper.3.1.7.min.js"></script>
    <script type="text/javascript" src="libs/swiper.animate1.0.2.min.js"></script>
    <script type="text/javascript" src="libs/jquery-2.1.js"></script>
     <script type="text/javascript">
            var MenuIndex = "<?php echo $bg?>";//不同状态1:家人,2:恋人,3:朋友,4:领导
            var UserName = "<?php echo $nick?>";//昵称
        </script>
    <title>谢谢你在我生命的每一天</title>
</head>
<body>
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
<div id="ShareModule" class="n_wrapper">
    <img src="images/Mc_arrow.png" id="Mc_arrow"/>
</div>
<img src="images/Btn_sound.png" id="Btn_sound" class="SoundAni"/>
<div class="swiper-container n_wrapper Mc_bg" id="SwiperModule">
    <p><img src="images/Mc_logo.png" id="Mc_logo"/></p>

    <p>

    <div id="Ani_arrow"></div>
    </p>
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper unShow" id="SlidePage1">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="0s">
                    <img src="images/Mc_gift_p1.png"/></p>

                <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                   swiper-animate-delay="0.5s">你收到一份</p>

                <p class="txt_p2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                   swiper-animate-delay="0.5s" id="Txt_user"></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage2">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="pulse" swiper-animate-duration="1s"
                   swiper-animate-delay="0s"><img src="images/Mc_tape.png" id="Mc_tape"/></p>

                <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                   swiper-animate-delay="0.5s">我要把舒适送给你</p>

                <p class="txt_p2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                   swiper-animate-delay="0.5s">因为你是我在乎的人</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage3">
            <div class="ver n_wrapper">
                <div class="ContentBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0s"><img src="images/Mc_bg_content1.jpg"/></p>

                    <p class="Mc_cir ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0.2s"><img src="images/Mc_cir.png"></p>

                    <p class="Mc_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.8s"><img src="images/Mc_tit1.png"/></p>

                    <p class="Mc_txt_Fir ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="1.4s"><img src="images/Mc_txt_Fir1.png"/></p>

                    <p class="Mc_txt_Sec ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2s"><img src="images/Mc_txt_Sec1.png"/></p>

                    <p class="Mc_txt_Thr ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2.6s"><img src="images/Mc_txt_Thr1.png"/></p>

                    <p class="Mc_txt_Fou ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_txt_Fou1.png"/></p>

                    <p class="LineFir ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineSec ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineThr ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage4">
            <div class="ver n_wrapper">
                <div class="ContentBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0s"><img src="images/Mc_bg_content2.jpg"/></p>

                    <p class="Mc_cir ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0.2s"><img src="images/Mc_cir.png"></p>

                    <p class="Mc_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.8s"><img src="images/Mc_tit2.png"/></p>

                    <p class="Mc_txt_Fir ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="1.4s"><img src="images/Mc_txt_Fir2.png"/></p>

                    <p class="Mc_txt_Sec ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2s"><img src="images/Mc_txt_Sec2.png"/></p>

                    <p class="Mc_txt_Thr ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2.6s"><img src="images/Mc_txt_Thr2.png"/></p>

                    <p class="Mc_txt_Fou ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_txt_Fou2.png"/></p>

                    <p class="LineFir ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineSec ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineThr ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage5">
            <div class="ver n_wrapper">
                <div class="ContentBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0s"><img src="images/Mc_bg_content3.jpg"/></p>

                    <p class="Mc_cir ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0.2s"><img src="images/Mc_cir.png"></p>

                    <p class="Mc_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.8s"><img src="images/Mc_tit3.png"/></p>

                    <p class="Mc_txt_Fir ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="1.4s"><img src="images/Mc_txt_Fir3.png"/></p>

                    <p class="Mc_txt_Sec ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2s"><img src="images/Mc_txt_Sec3.png"/></p>

                    <p class="Mc_txt_Thr ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2.6s"><img src="images/Mc_txt_Thr3.png"/></p>

                    <p class="Mc_txt_Fou ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_txt_Fou3.png"/></p>

                    <p class="LineFir ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineSec ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineThr ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper unShow" id="SlidePage6">
            <div class="ver n_wrapper">
                <div class="ContentBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0s"><img src="images/Mc_bg_content4.jpg"/></p>

                    <p class="Mc_cir ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.3s"
                       swiper-animate-delay="0.2s"><img src="images/Mc_cir.png"></p>

                    <p class="Mc_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.8s"><img src="images/Mc_tit4.png"/></p>

                    <p class="Mc_txt_Fir ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="1.4s"><img src="images/Mc_txt_Fir4.png"/></p>

                    <p class="Mc_txt_Sec ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2s"><img src="images/Mc_txt_Sec4.png"/></p>

                    <p class="Mc_txt_Thr ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="2.6s"><img src="images/Mc_txt_Thr4.png"/></p>

                    <p class="Mc_txt_Fou ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1.2s"
                       swiper-animate-delay="3.2s"><img src="images/Mc_txt_Fou4.png"/></p>

                    <p class="LineFir ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineSec ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>

                    <p class="LineThr ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                       swiper-animate-delay="4s"><img src="images/Mc_line.png"/></p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper swiper-no-swiping" id="SlidePage7">
            <div class="n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="0.6s"
                   swiper-animate-delay="0s"><img src="images/Mc_gift_p4.png" id="Mc_gift_p4"/></p>
                <div class="n_wrapper" id="PrintBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.5s" id="Btn_fingerprint"><img src="images/Btn_fingerprint.png"/></p>

                    <p><img src="images/Mc_light.png" id="Mc_light"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.5s" id="Print_txt1">点击拆开礼物</p>

                    <p class="txt_p2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.5s" id="Print_txt2">一次满足两个愿望</p>
                </div>
            </div>
        </div>
        <div class="swiper-slide n_wrapper swiper-no-swiping" id="SlidePage8">
            <div class="n_wrapper Mc_bg_rule">
                <div id="RuleBox">
                    <p class="ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0s"><img src="images/Mc_rule.png" alt=""/></p>
                </div>
                <p class="" id="Btn_share"><img src="images/Btn_share.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper" id="SlidePage9">
            <div class="n_wrapper Mc_bg_menu">
                <div id="MenuBox">
                    <p class="ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0s" id="Mc_show1"><img src="images/Mc_show1.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                       swiper-animate-delay="0.7s" id="Mc_show2"><img src="images/Mc_show2.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                       swiper-animate-delay="1.4s" id="Mc_show3"><img src="images/Mc_show3.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.5s"
                       swiper-animate-delay="2.1s" id="Mc_show4"><img src="images/Mc_show4.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="0.3s" id="Btn_menu1"><img src="images/Btn_menu1.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="1s" id="Btn_menu2"><img src="images/Btn_menu2.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="1.7s" id="Btn_menu3"><img src="images/Btn_menu3.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="2.4s" id="Btn_menu4"><img src="images/Btn_menu4.png"/></p>

                    <p class="txt_p1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.6s"
                       swiper-animate-delay="2.5s" id="Mc_txt_menu"><img src="images/Mc_txt_menu.png"/></p>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="bgid" id="bgid" value="<?php echo $bg?>"/>
</div>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
function onWeixinShare(){	  
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
    var mcid = "<?php echo $mcid;?>";
    var bg = $("#bgid").val();
    var wxData = {
        "imgUrl": 'http://zt.jia360.com/zhs_love/images/share.jpg',
        "link": 'http://zt.jia360.com/zhs_love/index.php?a=a&mcid=' + mcid + '&bg=' + bg,
        "desc": "谢谢你在我生命的每一天！我要把舒适送给你,因为你是我在乎的人！",
        "title": "用心去爱 芝华仕邀您坐头等舱看大片"
    };
    wx.onMenuShareAppMessage(wxData);
    wx.onMenuShareTimeline(wxData);
});
}
onWeixinShare();
</script>
<script type="text/javascript" charset="UTF-8" src="libs/Main.js"></script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>