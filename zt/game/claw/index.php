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
// $_SESSION['claw_openid'] = 'abc123';
// $_SESSION['claw_wechaname'] = 'hehe';
// $_SESSION['claw_headurl'] = 'baidu.com';


if(!$_POST['openid'])
// if(!isset($_POST['openid']))
{
	$openId = $_SESSION['claw_openid'];
	$wechaname = $_SESSION['claw_wechaname'];
	$headurl = $_SESSION['claw_headurl'];

	if(empty($openId))
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=claw';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
	}
}
else
{
	$openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $headurl = urldecode($_POST['headimgurl']);
    $_SESSION['claw_openid'] = $openId;
    $_SESSION['claw_wechaname'] = $wechaname;
    $_SESSION['claw_headurl'] = $headurl;
}

//是否第一次进入
$mem_sql = "select * from game_claw_info where openid='{$openId}'";
$mem_res = mysqli_query($db, $mem_sql);
$mem_row = $mem_res->fetch_assoc();

if(empty($mem_row)) //第一次进入
{
	$sql = "insert into game_claw_info (openid,wechaname,add_time,last_log_time,score,sum_score) values ('{$openId}','{$wechaname}','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s') . "',100,100)";
	mysqli_query($db, $sql);
	$tag = 1;
}
else
{
	//每天第一次登陆
	if($mem_row['last_log_time'] < date('Y-m-d'))
	{
		$sql = "update game_claw_info set last_log_time='" . date('Y-m-d H:i:s') . "',score=score+100,sum_score=sum_score+100,log_days=log_days+1 where openid='{$openId}'";
		mysqli_query($db, $sql);
		$tag = 1;
	}
	else //不是当天第一次登陆
	{
		$tag = 0;
			
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

    <script type="text/javascript">
        var AD_url = "http://group.yoju360.com/phone/qmjjg/index.html?from=jiajuyouxi";
    </script>
    <script src='./libs/jquery-2.1.js' type='text/javascript'></script>
    <script src='./libs/lufylegend-1.9.9.simple.js' type='text/javascript'></script>

    <!--<script src='./js/module/ArtFont.js' type='text/javascript'></script>-->
    <!--<script src='./js/module/BUtils.js' type='text/javascript'></script>-->
    <!--<script src='./js/module/Plugin.js' type='text/javascript'></script>-->
    <!--<script src='./js/module/Element.js' type='text/javascript'></script>-->
    <!--<script src='./js/module/Cloud.js' type='text/javascript'></script>-->
    <!--<script src="./js/CodeScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/GameScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/OpenScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/OverScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/RankScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/ShareScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/RuleScene.js" type="text/javascript"></script>-->
    <!--<script src="./js/SignScene.js" type="text/javascript"></script>-->
    <!--<script src='./js/Main.js' type='text/javascript'></script>-->

     <script type='text/javascript' src='./libs/UED_Claw.min.js'></script>
     
    <script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    <script src="../../public/crypto/core-min.js"></script>
    <script src="../../public/crypto/enc-utf16-min.js"></script>
    <script src="../../public/crypto/sha1-min.js"></script>
    <script src="../../public/crypto/md5-min.js"></script>
    <script src="../../public/crypto/aes.js"></script>
    <script src="../../public/crypto/bigint.js"></script>
    <script src="../../public/crypto/secret_new.js?v=1.2"></script>

    <title>全民家居购 天天有礼</title>
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
            background: #fed64e;
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

        #tips {
            background-color: #ffffff;
            width: 100%;
            height: 100%;
            display: none;
        }

        #tips div {
            top: 50%;
            position: absolute;;
            z-index: 100;
            width: 100%;
        }

        #tips p {
            color: #ffffff;
            text-align: center;
            width: 100%;
            font-size: 30px;
            font-family: '黑体';
        }

        #CodeModule {
            display: none;
            position: fixed;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 999;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .CodeBox {
            position: relative;
        }

        #CodeModule #Mc_code {
            position: absolute;
            top: 143px;
            left: 115px;
        }
    </style>
</head>
<body>
<div id="loading" class="ver">
    <img src="images/loading.png">

    <p id="loading_txt"></p>
</div>
<div class="ver" id="CodeModule">
    <div class="CodeBox">
        <p><img src="images/Mc_bg_code.png" alt=""/></p>

        <p><img src="images/Mc_code.png" id="Mc_code"/></p>
    </div>
</div>
<div id="lufyLegend"></div>
<div id="tips">
    <div>
        <p>
            为了更好的体验游戏，请选择竖屏模式进行游戏
        </p>
    </div>
</div>
<script type="text/javascript">
    var RankData = {
        "list": [
            {
                "rank": 1,
                "nickname": "\u98ce***\u9b42",
                "score": "00'00"
            },
            {
                "rank": 2,
                "nickname": "b**y",
                "score": "00'00"
            },
            {
                "rank": 3,
                "nickname": "B**g",
                "score": "00'00"
            },
            {
                "rank": 4,
                "nickname": "\u5143***\u65b9",
                "score": "00'00"
            },
            {
                "rank": 5,
                "nickname": "\u4e09***\u55b5",
                "score": "00'00"
            },
            {
                "rank": 6,
                "nickname": "\u533a****\u2714",
                "score": "00'00"
            },
            {
                "rank": 7,
                "nickname": "b**y",
                "score": "00'00"
            },
            {
                "rank": 8,
                "nickname": "B**g",
                "score": "00'00"
            },
            {
                "rank": 9,
                "nickname": "\u5143***\u65b9",
                "score": "00'00"
            },
            {
                "rank": 10,
                "nickname": "\u4e09***\u55b5",
                "score": "00'00"
            }
        ]
    };//排行榜数据
    var tag=<?php echo $tag;?>;
    function initRank() {
        console.log(RankData);
        //进入排行榜
        $.ajax({
		async:false,
        url: 'server.php',
        data:{act:'rank'},
        type: "post",
        dataType:'json',
        success:function(result){
            RankData = result.ranklist;
        }
    });
        onSetRankData(RankData);
    }
    function onPostData() {
        //游戏结束提交积分GameScore;
        var _0x3dd1=["\x70\x61\x72\x73\x65","\x55\x74\x66\x38","\x65\x6E\x63","\x32\x30\x31\x35\x30\x33\x31\x33\x35\x38\x34\x35\x32\x36\x39\x31","\x65\x6E\x63\x72\x79\x70\x74","\x41\x45\x53"];var md5_secret=CryptoJS.MD5(secret);var key=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](md5_secret);var iv=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](_0x3dd1[3]);var encrypted=CryptoJS[_0x3dd1[5]][_0x3dd1[4]](GameScore.toString(),key,{iv:iv});var scoreStr=encrypted.toString();
    	$.ajax({
            async:false,
            url: 'server.php',
            data:{act:'submitscore',score:scoreStr},
            type: "post",
            dataType:'json',
            success:function(result){
                console.log(result);
                
            }
        });

    }

    function onADHandler()
    {
    	$.ajax({
            async:false,
            url: 'server.php',
            data:{act:'register'},
            type: "post",
            dataType:'json',
            success:function(result){
            }
        });
    }
    
    $("#CodeModule").on("touchstart", function (e) {
        if (e.target.id != "Mc_code") {
            $("#CodeModule").hide();
        }
    });
</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
		"imgUrl":'http://zt.jia360.com/game/claw/images/share.jpg',
		"link":'http://zt.jia360.com/game/claw/index.php',
		"desc":"还记得那些年抓不起来的娃娃么？王珞丹和红包通通抓到碗里来！",
		"title":"全民家居购 天天有礼",
		success:function(){
			//分享成功，增加抽奖次数
			$.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'share'},
                type: "post",
                dataType:'json',
                success:function(result){
                }
            });
		}
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="true"></audio>
</body>
</html>	
	
