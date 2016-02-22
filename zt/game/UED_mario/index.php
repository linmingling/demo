<?php

	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../../data/config.php');
	require_once(ROOT_PATH .'../../../data/jssdk.php');
	include ROOT_PATH . "../../../public/tongji.html";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    
	
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
    	echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    } 
	
    
    //$_SESSION['hegii_lf_openid'] = '362423';
   // $_SESSION['hegii_lf_wechaname'] = '按规定';
   // $_SESSION['hegii_lf_headurl'] = 'baidu.com';
    
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['hegii_lf_openid'];
    	$wechaname = $_SESSION['hegii_lf_wechaname'];
    	$headurl = $_SESSION['hegii_lf_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=hegii';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['hegii_lf_openid'] = $openId;
    	$_SESSION['hegii_lf_wechaname'] = $wechaname;
    	$_SESSION['hegii_lf_headurl'] = $headurl;
    }
    
    // 时间判断得到期数
	$nowDate = date('Y-m-d H:i:s');
	$nowPer = '';
	if(strtotime('2015-12-21 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-23 23:59:59')) {
		$nowPer = 1;
	} else 	if(strtotime('2015-12-24 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-27 23:59:59')) {
		$nowPer = 2;
	} else 	if(strtotime('2015-12-28 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-31 23:59:59')) {
		$nowPer = 3;
	} else 	if(strtotime('2016-1-1 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2016-1-3 23:59:59')) {
		$nowPer = 4;
	} else {
		$nowPer = 0;
	}	
    
    //是否第一次进入
    $table = 'ued_game_lf_info';
    $mem_sql = "select * from $table where openid='{$openId}' and periods='{$nowPer}'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //当期第一次进入
    {
    	$sql = "insert into $table (openid,wechaname,headimgurl,add_time,periods) values ('{$openId}','{$wechaname}','{$headurl}','" . date('Y-m-d H:i:s') . "','{$nowPer}')";
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
    <title>女神励险记</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            background: #ffbc3b;
            overflow: hidden;
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

        #LoadModule {
            position: absolute;
            z-index: 2;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

        }

         .LoadAni {
                    -webkit-transform-origin: center bottom;
                    -webkit-animation: load 2s infinite linear;
                    -o-animation: load 2s infinite linear;
                    animation: load 2s infinite linear;
                }

                @keyframes load {
                    0%, 100% {
                        -webkit-transform: rotate(10deg);
                    }
                    50% {
                        -webkit-transform: rotate(-10deg);
                    }

                }
        #LoadModule p {
            font-size: 60px;
            color: #ffffff;
        }

        #TipsModule {
            background-color: #000;
            width: 100%;
            height: 100%;
            display: none;
        }

        #TipsModule div {
            top: 50%;
            position: absolute;;
            z-index: 100;
            width: 100%;
        }

        #TipsModule p {
            color: #ffffff;
            text-align: center;
            width: 100%;
            font-size: 30px;
            font-family: '黑体';
        }

        .n_wrapper {
            width: 100%;
            height: 100%;
        }

        .relative {
            position: relative;
        }

        .ModuleBox {
            background-color: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            z-index: 100;
            display: none;
        }

        .Mc_tit {
            position: absolute;
            top: 10px;
            left: 130px;
        }

        .Btn_close {
            position: absolute;
            top: 20px;
            right: 10px;
        }

        #Btn_Fir {
            position: absolute;
            right: 0px;
            top: 145px;
        }

        #Btn_Sec {
            position: absolute;
            right: 0px;
            top: 295px;
        }

        #Btn_Thr {
            position: absolute;
            right: 0px;
            top: 445px;
        }

        #Btn_Fou {
            position: absolute;
            right: 0px;
            top: 595px;
        }

        .RuleBox {
            position: absolute;
            top: 100px;
            left: 70px;
            width: 400px;
            height: 605px;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        #Btn_rank {
            position: absolute;
            right: 10px;
            top: 415px;
        }

        #Btn_go {
            position: absolute;
            right: 10px;
            top: 575px;
        }

        #RankBox {
            position: absolute;
            left: 53px;
            top: 100px;
            width: 420px;
            height: 600px;
            overflow: hidden;
            overflow-y: scroll;
        }

        #RankBox ul {
            font-size: 1.6rem;
            color: #795949;
            list-style: none;
            width: 400px;
            overflow: hidden;
        }

        #RankBox ul div {
            margin-bottom: 5px;
        }

        #RankBox ul div img {
            width: 100%;
        }

        #RankBox ul li:nth-child(1) {
            width: 50px;
            text-align: left;
            margin: 0px 0px 0px 0px;
            float: left;
            line-height: 50px;
        }

        #RankBox ul li:nth-child(2) {
            width: 50px;
            height: 50px;
            margin: 0px 0px 0px 0px;
            float: left;
            line-height: 50px;
        }

        #RankBox ul li:nth-child(3) {
            width: 130px;
            margin: 0px 0px 0px 0px;
            float: left;
            line-height: 50px;
            overflow: hidden;
        }

        #RankBox ul li:nth-child(4) {
            width: 150px;
            text-align: right;
            margin-right: 0px;
            float: left;
            line-height: 50px;
        }

             #Btn_sound {
                    position: fixed;
                    top: 30px;
                    right: 30px;
                    z-index: 500;
                }

                .SoundAni {
                    -webkit-animation: sound 2s infinite linear;
                    -o-animation: sound 2s infinite linear;
                    animation: sound 2s infinite linear;
                }

                @keyframes sound {
                    0% {
                        transform: rotate(0deg);
                    }
                    50% {
                        transform: rotate(180deg);
                    }
                    100% {
                        transform: rotate(360deg);
                    }
                }

                @-webkit-keyframes sound {
                    0% {
                        transform: rotate(0deg);
                    }
                    50% {
                        transform: rotate(180deg);
                    }
                    100% {
                        transform: rotate(360deg);
                    }
                }
    </style>
    <script type="text/javascript" charset="UTF-8">
		var wxDesc = '面对女神，看你能坚持多久！';
		var wxTitle = '女神励险记, 全民家居购邀你一起GO!';
		var wxImgUrl = 'http://zt.jia360.com/game/UED_mario/images/share.png';
		var wxLink = 'http://zt.jia360.com/game/UED_mario/index.php';
	</script>	
</head>
<body>
<div id="LoadModule" class="ver">
  <img src="images/loading.png?v=1.0" class="LoadAni"/>

    <p id="Txt_load"></p>
</div>
<div id="RuleModule" class="ModuleBox">
    <div class="ver n_wrapper">
        <div class="relative">
            <img src="images/Mc_bg_pop1.png"/>
            <img src="images/Mc_tit_rule.png" class="Mc_tit"/>
            <img src="images/Btn_close.png" class="Btn_close" id="Btn_close1" for="RuleModule"/>
            <img src="images/Btn_rank.png" id="Btn_rank"/>
            <img src="images/Btn_go.png" id="Btn_go"/>

            <div class="RuleBox">
                <img src="images/Mc_rule.png" alt=""/>
            </div>
        </div>
    </div>
</div>
<div id="RankModule" class="ModuleBox ">
    <div class="ver n_wrapper">
        <div class="relative">
            <img src="images/Mc_bg_pop2.png" alt=""/>
            <img src="images/Mc_tit_prize.png" class="Mc_tit"/>
            <img src="images/Btn_close.png" class="Btn_close" id="Btn_close2" for="RankModule"/>
            <img src="images/Btn_Fir.png" id="Btn_Fir"/>
            <img src="images/Btn_Sec.png" id="Btn_Sec"/>
            <img src="images/Btn_Thr.png" id="Btn_Thr"/>
            <img src="images/Btn_Fou.png" id="Btn_Fou"/>

            <div id="RankBox">
                <ul>
                    <div>
                        <li>1</li>
                        <li>
                            <div>
                                <img src="images/pic.png" alt=""/>
                            </div>
                        </li>
                        <li>小夜曲</li>
                        <li>99分</li>
                        <div style="clear: both;"></div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="GameModule"></div>
<div id="TipsModule">
    <div><p>为了更好的体验游戏，请选择竖屏模式进行游戏</p></div>
</div>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="true"></audio>
<script src='./libs/jquery-2.1.js' type='text/javascript'></script>
<script src='./libs/lufylegend-1.9.11.simple.min.js' type='text/javascript'></script>
<script type='text/javascript' charset="UTF-8" src='./libs/UED_mario.min.js'></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    <script src="../../public/crypto/core-min.js"></script>
    <script src="../../public/crypto/enc-utf16-min.js"></script>
    <script src="../../public/crypto/sha1-min.js"></script>
    <script src="../../public/crypto/md5-min.js"></script>
    <script src="../../public/crypto/aes.js"></script>
    <script src="../../public/crypto/bigint.js"></script>
    <script src="../../public/crypto/secret_new.js?v=1.2"></script>
<script type="text/javascript" charset="UTF-8">
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
</script>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>	
	
