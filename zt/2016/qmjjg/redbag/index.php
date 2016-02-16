<?php
header("Content-Type: text/html;charset=utf-8");
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
require($rootPath.'/data/config.php');
require($rootPath.'/data/jssdk.php');

$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$debug = FALSE;	// TRUE OR FALSE 是否开启调试模式
$distingArr = array('2016-02-15','2016-02-16','2016-02-17'); // 期数以天为单位
$tableName = 'hl_red_packet';

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
	$openId = $userinfo['openid'];
} 

if( $debug === TRUE ) {
	//$_SESSION['openid']		= md5(uniqid());
	$_SESSION['openid']		= 'ABCDEFG';
	$_SESSION['nickname']	= 'test';
	$_SESSION['headimgurl'] = '';
}
/*
* 是否第一次参加本活动
*/

$sql = 'SELECT id FROM ' . $tableName . ' WHERE openid=\'' . $openId . '\' LIMIT 1';
$query_res = mysqli_query($db, $sql);
if($query_res) 
{
	$result = $query_res->fetch_assoc();
	// 释放资源
	mysqli_free_result( $query_res );
}

if(empty($result))
{
	// 获取活动期数，没有设置默认值0
	$disting = array_search(date('Y-m-d'), $distingArr);
	$disting = $disting!==false?$disting+1:0;

	// 入库数组
	$insertData = array(
		'openid'=> $_SESSION['openid'],
		'nickname'=> $_SESSION['nickname'],
		'head_icon'=> $_SESSION['headimgurl'],
		'disting'=> $disting,
		'add_time'=> date('Y-m-d H:i:s'),
		'modify_time'=> date('Y-m-d H:i:s'),
	);

	$fields = null;
	$values = null;
	foreach($insertData as $field=>$value)
	{
		$fields .= "`" . $field . "`,";
		$values .= "'" . $value . "',";
	}
	
	// 检查，入库操作
	if( $fields && $values) {
		$fields = substr($fields, 0,-1);
		$values = substr($values, 0,-1);
		
		$sql = 'INSERT INTO ' . $tableName . ' ( ' . $fields . ') VALUES ( ' . $values . ')';

		mysqli_query($db, $sql);		
	}

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
	// 没抽到奖，分享显示次数 0 不显示，1 显示。
	var is_show_num = 0;
	
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
    <link rel="stylesheet" href="css/animate.min.css?v=1"/>
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css?v=1"/>
    <link rel="stylesheet" href="css/global.css?v=1"/>
    <link rel="stylesheet" href="css/index.css?v=1"/>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js?v=1"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.3.1.7.min.js?v=1"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.animate1.0.2.min.js?v=1"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js?v=1"></script>	

    <title>开工利是-“乐抢开门红”</title>
</head>
<body>
<div class="n_wrapper ver" id="SwiperModule">
    <div class="swiper-container f_wrapper">
        <div class="swiper-wrapper n_wrapper">
            <div class="swiper-slide n_wrapper swiper-no-swiping" id="SlidePage1">
                <div id="OpenModule" class="n_wrapper">
                    <div class="Door l_door">
                        <div class="f_wrapper hidden ver OpenBox relative">
                            <div class="ShowBox1 relative">
                                <p class="P1_txt1 ani" swiper-animate-effect="pulse" swiper-animate-duration="1.5s"
                                   swiper-animate-delay="0.5s"><img src="images/P1_txt1.png" alt=""/></p>

                                <p class="P1_txt2 ani" swiper-animate-effect="shake" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="1.5s"><img src="images/P1_txt2.png" alt=""/></p>

                                <p class="P1_tit ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="1.5s"><img src="images/P1_tit.png" alt=""/></p>

                                <p class="P1_txt3 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="2s"><img src="images/P1_txt3.png" alt=""/></p>

                                <p class="P1_hand AniHand"><img src="images/P1_hand.png" alt=""/></p>

                                <p class="L_knob"><img src="images/P1_knob.png" alt=""/></p>

                                <p class="R_knob"><img src="images/P1_knob.png" alt=""/></p>

                            </div>
                            <p class="P1_logo1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                               swiper-animate-delay="0s"><img src="images/P1_logo1.png" alt=""/></p>

                            <p class="P1_logo2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                               swiper-animate-delay="0s"><img src="images/P1_logo2.png" alt=""/></p>
                        </div>
                    </div>
                    <div class="Door r_door">
                        <div class="f_wrapper hidden ver OpenBox relative">
                            <div class="ShowBox1 relative">
                                <p class="P1_txt1 ani" swiper-animate-effect="pulse" swiper-animate-duration="1.5s"
                                   swiper-animate-delay="0.5s"><img src="images/P1_txt1.png" alt=""/></p>

                                <p class="P1_txt2 ani" swiper-animate-effect="shake" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="1.5s"><img src="images/P1_txt2.png" alt=""/></p>

                                <p class="P1_tit ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="1.5s"><img src="images/P1_tit.png" alt=""/></p>

                                <p class="P1_txt3 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s"
                                   swiper-animate-delay="2s"><img src="images/P1_txt3.png" alt=""/></p>

                                <p class="P1_hand AniHand"><img src="images/P1_hand.png" alt=""/></p>

                                <p class="L_knob"><img src="images/P1_knob.png" alt=""/></p>

                                <p class="R_knob"><img src="images/P1_knob.png" alt=""/></p>

                            </div>
                            <p class="P1_logo1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                               swiper-animate-delay="0s"><img src="images/P1_logo1.png" alt=""/></p>

                            <p class="P1_logo2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                               swiper-animate-delay="0s"><img src="images/P1_logo2.png" alt=""/></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide n_wrapper swiper-no-swiping" id="SlidePage2">
                <div id="MenuModule" class="n_wrapper ver">
                    <div class="f_wrapper hidden ver MenuBox relative">
                        <p class="P2_show"><img src="images/P2_show.png" alt=""/></p>

                        <div class="ShowBox2 relative">

                            <p class="P2_txt1 ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"
                               swiper-animate-delay="0s"><img src="images/P2_txt1.png" alt=""/></p>

                            <p class="P2_txt2 ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"
                               swiper-animate-delay="0.1s"><img src="images/P2_txt2.png" alt=""/></p>

                            <p class="P2_txt3 ani" swiper-animate-effect="bounceInRight" swiper-animate-duration="1s"
                               swiper-animate-delay="0.2s"><img src="images/P2_txt3.png" alt=""/></p>

                            <p class="P2_input ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                               swiper-animate-delay="0.5s"><img src="images/P2_input.png" alt=""/></p>

                            <p id="Btn_menu1" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                               swiper-animate-delay="0.7s"><img src="images/Btn_menu1.png" alt=""/></p>

                            <p id="Btn_menu2" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                               swiper-animate-delay="0.9s"><img src="images/Btn_menu2.png" alt=""/></p>

                            <p id="Btn_menu3" class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="1s"
                               swiper-animate-delay="1.1s"><img src="images/Btn_menu3.png" alt=""/></p>

                            <p id="Btn_rule" class="ani" swiper-animate-effect="fadeInRight"
                               swiper-animate-duration="1s"
                               swiper-animate-delay="1s"><img src="images/Btn_rule.png" alt=""/></p>
                        </div>
                        <p class="P2_logo1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                           swiper-animate-delay="0s"><img src="images/P2_logo1.png" alt=""/></p>

                        <p class="P2_logo2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                           swiper-animate-delay="0s"><img src="images/P2_logo2.png" alt=""/></p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide n_wrapper swiper-no-swiping" id="SlidePage3">
                <div id="GameModule" class="n_wrapper ver">
                    <div class="f_wrapper relative hidden GameBox">
                        <img src="images/Mc_tree.png" class="Mc_tree"/>
                        <div class="PerBox">
                            <img src="images/P3_bg_pre.png" alt=""/>

                            <div class="n_wrapper ver TxtBox">
                                <div class="ArtTxt" id="Txt_per3">
                                    <div class="fontR0"></div>
                                    <div class="fontR10"></div>
                                </div>
                            </div>
                        </div>
                        <div id="BagBox" class="relative n_wrapper"></div>
                        <p class="P2_logo1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s"
                           swiper-animate-delay="0s"><img src="images/P2_logo1.png"/></p>

                        <p class="P3_logo2 ani" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s"
                           swiper-animate-delay="0s"><img src="images/P3_logo2.png"/></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="RuleModule" class="n_wrapper ver">
    <div class="f_wrapper ver hidden Mc_mask">
        <div class="RuleBox relative">
            <img src="images/Mc_bg_rule.png" alt=""/>

            <div class="RuleContent">
                <img src="images/Mc_rule.png" alt=""/>
            </div>
        </div>
    </div>
</div>
<div id="ShareModule" class="n_wrapper ver">
    <div class="f_wrapper hidden relative Mc_mask">
        <img src="images/Mc_arrow.png" class="Mc_arrow"/>
        <img src="images/P5_txt1.png" class="P5_txt1"/>
    </div>
</div>
<div id="TipsModule" class="n_wrapper ver">
    <div class="f_wrapper ver Mc_mask">
        <p><img src="images/Mc_txt_tip.png" alt=""/></p>

        <p id="Btn_start"><img src="images/Btn_start.png" alt=""/></p>
    </div>
</div>
<div id="PopsModule" class="n_wrapper ver">
    <div class="f_wrapper ver Mc_mask">
        <p><img src="images/Mc_bag3.png" alt=""/></p>

        <p class="Txt_pop1">温馨提示</p>

        <p class="Txt_pop2">本期活动您已领过一个口令红包。不可重复领取。</p>
    </div>
</div>
<div id="OverModule1" class="n_wrapper ver">
    <div class="f_wrapper hidden relative Mc_mask2">
        <div class="AniObj1 circle1"></div>
        <div class="AniObj1 circle2"></div>
        <div class="AniObj1 circle3"></div>
        <div class="AniObj2 circle4"></div>
        <div class="AniObj2 circle5"></div>
        <div class="AniObj3 triangle1"></div>
        <div class="AniObj3 triangle2"></div>
        <img src="images/Mc_bg_over2.png" class="Mc_bg_over2"/>
        <img src="images/P4_txt1.png" class="P4_txt1"/>
        <img src="images/P4_txt3.png" class="P4_txt3"/>
        <img src="images/Mc_QRcode.png" class="Mc_QRcode"/>
        <img src="images/Btn_again.png" id="Btn_again"/>

        <p id="Txt_tip1">马上继续摇,把红包摇下来!</p>
        <i id="Txt_count1">0</i>

        <div class="ArtTxt" id="Txt_per1">
            <div class="font0"></div>
            <div class="font10"></div>
        </div>
    </div>
</div>
<div id="OverModule2" class="n_wrapper ver">
    <div class="f_wrapper hidden relative Mc_mask2">
        <div class="AniObj1 circle1"></div>
        <div class="AniObj1 circle2"></div>
        <div class="AniObj1 circle3"></div>
        <div class="AniObj2 circle4"></div>
        <div class="AniObj2 circle5"></div>
        <div class="AniObj3 triangle1"></div>
        <div class="AniObj3 triangle2"></div>
        <img src="images/Mc_bg_over2.png" class="Mc_bg_over2"/>
        <img src="images/P4_txt1.png" class="P4_txt1"/>
        <img src="images/P4_txt2.png" class="P4_txt2"/>
        <img src="images/Mc_QRcode.png" class="Mc_QRcode"/>
        <img src="images/Btn_share.png" id="Btn_share"/>

        <p id="Txt_tip2">已把红包摇下<strong>0%</strong>,邀请好友帮你继续完成，同样可以获得现金红包的奖励</p>
        <i id="Txt_count2">0</i>

        <div class="ArtTxt" id="Txt_per2">
            <div class="font0"></div>
            <div class="font10"></div>
        </div>
    </div>
</div>
<div id="OverModule3" class="n_wrapper ver">
    <div class="f_wrapper hidden relative Mc_mask2">
        <div class="AniObj1 circle1"></div>
        <div class="AniObj1 circle2"></div>
        <div class="AniObj1 circle3"></div>
        <div class="AniObj2 circle4"></div>
        <div class="AniObj2 circle5"></div>
        <div class="AniObj3 triangle1"></div>
        <div class="AniObj3 triangle2"></div>
        <img src="images/Mc_bg_over1.png" class="Mc_bg_over1"/>
        <img src="images/Mc_QRcode.png" class="Mc_QRcode"/>

        <p id="Txt_code"></p>
    </div>
</div>
<div id="LeafModule" class="n_wrapper ver">
    <div class="f_wrapper relative hidden">
        <ul id="scene" class="scene">
            <li class="layer" data-depth="1.00"><img src="images/Mc_leaf1.png"></li>
            <li class="layer" data-depth="0.80"><img src="images/Mc_leaf2.png"></li>
            <li class="layer" data-depth="0.60"><img src="images/Mc_leaf3.png"></li>
            <li class="layer" data-depth="0.40"><img src="images/Mc_leaf4.png"></li>
            <li class="layer" data-depth="0.20"><img src="images/Mc_leaf5.png"></li>
            <li class="layer" data-depth="1.00"><img src="images/Mc_leaf6.png"></li>
        </ul>
    </div>
</div>
<div id="LoadModule" class="n_wrapper ver">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
<script type="text/javascript" charset="UTF-8" src="libs/bag.min.js?v=1"></script>
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

//微信分享动作
wx.ready(function () {
	var wxData = {
		"imgUrl":wxImgUrl,
		"link":wxLink,
		"desc":wxDesc,
		"title":wxTitle,
		success:function(){
			//分享成功，增加抽奖次数
			$.ajax({
				async:false,
				url: 'server.php',
				data:{act:'share'},
				type: "post",
				dataType:'json',
				success:function(result){
					if(result.errCode == '0' && is_show_num == 1) {
                        $("#ShareModule").fadeOut();
                        $("#OverModule2").fadeOut();
                        $("#OverModule1").css({display: "-webkit-box"});
						result.return*=1;
						GameCount=result.return;
                        $("#Txt_count1").html(result.return);
                        setArtFont("Txt_per1", "font", mPer);
					}
				}
			});
		}
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
    function onPostData(data) {
        var code_url = "server.php";
        $.ajax({
            type: "POST",
            url: code_url,
            data: {
                "act": "get_code",
                "percent": data
            },
            dataType: "json",
            success: function (result) {
				result.errCode = parseInt(result.errCode);
                if (result.errCode == 0) {
                    GamePer = parseInt(result.percent);
                    $("#Txt_code").html(result.return);
                } else if( result.errCode == 1007 || result.errCode == 1008 ) {
					GamePer = parseInt(result.percent);
				}else{
                     alert(result.errMsg);
                 }
            }
        });
    }
  function onNextPage() {
         var check_url = "server.php";
         $.ajax({
             type: "POST",
             url: check_url,
             data: {
                 "act": "check"
             },
             dataType: "json",
             success: function (data) {
                 if (data.errCode == 0) {
                     GameCount = parseInt(data.return);
                     GamePer = parseInt(data.percent);
                     mSwiper.slideNext();
                 }else if(data.errCode == 1003||data.errCode==1004||data.errCode==1005){
					 $(".Txt_pop2").html(data.errMsg);
                     $("#PopsModule").css({display: "-webkit-box"});
					 return false;
                 }else{
                     alert(data.errMsg);
                 }
             }
         });
     }
</script>
<!--#include virtual="/public/tongji.html"-->  
</body>
</html>