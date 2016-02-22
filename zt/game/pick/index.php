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

    //$_SESSION['lj_openid'] = '432432';
   	//$_SESSION['lj_wechaname'] = '谎的';
    //$_SESSION['lj_headurl'] = 'sdhaj.com';


if(!$_POST['openid'])
//if(!isset($_POST['openid']))
{
	$openId = $_SESSION['lj_openid'];
	$wechaname = $_SESSION['lj_wechaname'];
	$headurl = $_SESSION['lj_headurl'];

	if(empty($openId))
	{
		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=lj';
		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
	}
}
else
{
	$openId = $_POST['openid'];
	$wechaname = base64_decode($_POST['wechaname']);
	$headurl = urldecode($_POST['headimgurl']);
	$_SESSION['lj_openid'] = $openId;
	$_SESSION['lj_wechaname'] = $wechaname;
	$_SESSION['lj_headurl'] = $headurl;
}

// 时间判断得到期数
$nowPer = '';
// 测试用
$timeQua = array("2015-11-06 00:00:00","2015-11-21 23:59:59","2015-12-01 23:59:59","2015-12-11 23:59:59");
$nowDate = date('Y-m-d H:i:s');
//$timeQua = array("2015-11-08 00:00:00","2015-11-21 23:59:59","2015-12-01 23:59:59","2015-12-11 23:59:59","2015-12-21 23:59:59");
if (strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) >= strtotime($nowDate)) {
	$nowPer = 1;
} else if(strtotime($timeQua[1]) < strtotime($nowDate) && strtotime($timeQua[2]) >= strtotime($nowDate)) {
	$nowPer = 2;
} else if(strtotime($timeQua[2]) < strtotime($nowDate) && strtotime($timeQua[3]) >= strtotime($nowDate)) {
	$nowPer = 3;
} else {
	$nowPer = 0;
}

//当前期数是否第一次进入
$lj_weixin = 'langjing_info';
$mem_sql = "select * from $lj_weixin where openid='{$openId}' and periods='{$nowPer}'";
$mem_res = mysqli_query($db, $mem_sql);
$mem_row = $mem_res->fetch_assoc();

if(empty($mem_row)) //第一次进入
{
	$sql = "insert into $lj_weixin (openid,wechaname,headimgurl,add_time,periods) values ('{$openId}','{$wechaname}','{$headurl}','" . date('Y-m-d H:i:s') . "','{$nowPer}')";
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

    <script type='text/javascript' charset="UTF-8" src='./libs/jquery-2.1.js'></script>
    <script type='text/javascript' charset="UTF-8" src='./libs/lufylegend-1.9.11.simple.min.js'></script>

    <script type='text/javascript' charset="UTF-8" src='./libs/SSWW_Pick.min.js'></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    
    <script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    <script src="../../public/crypto/core-min.js"></script>
    <script src="../../public/crypto/enc-utf16-min.js"></script>
    <script src="../../public/crypto/sha1-min.js"></script>
    <script src="../../public/crypto/md5-min.js"></script>
    <script src="../../public/crypto/aes.js"></script>
    <script src="../../public/crypto/bigint.js"></script>
    <script src="../../public/crypto/secret_new.js?v=1.2"></script>
    
	<script type="text/javascript">
		var _hmt = _hmt || [];
		(function() {
			var hm = document.createElement("script");
			hm.src = "//hm.baidu.com/hm.js?33e823fd3389bbfa185404b5e0cfa8de";
			var s = document.getElementsByTagName("script")[0]; 
			s.parentNode.insertBefore(hm, s);
		})();
	</script>

    <title>捧在手心的惊喜—浪鲸卫浴</title>
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
            background: #4ed8c6;
            overflow: hidden;
        }

        .hor {
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-orient: horizontal;
            -ms-flex-direction: row;
            -webkit-flex-direction: row;
            flex-direction: row;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
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

        .Bg_mask {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .PopModule {
            display: none;
            position: fixed;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            z-index: 100;
        }

        #RuleBox {
            position: relative;
        }

        #Btn_close2 {
            position: absolute;
            right: 0px;
            top: -30px;
        }

        #Btn_close1 {
            position: absolute;
            right: 0px;
            top: -8px;
        }

        #Mc_rule_content {
              position: absolute;
              left: 67px;
                     top: 120px;
                     width: 455px;
                     height: 667px;
                     overflow-x: hidden;
                     overflow-y: scroll;
                     z-index: 300;
        }

        #RankBox {
            position: relative;

        }

        #Mc_rank_content {
         position: absolute;
                    left: 44px;
                    top: 168px;
                    width: 474px;
                    height: 590px;
                    overflow-x: hidden;
                    overflow-y: scroll;
        }

        #Mc_rank_content ul {
            width: 464px;
            position: absolute;
            left: 0px;
            top: 0px;
        }

        #Mc_rank_content ul div {
            list-style: none;
            width: 100%;
            font-size: 23px;
            margin-bottom: 30px;
            color: #795949;
        }

        #Mc_rank_content ul div li img {
            width: 100%;
        }

        #Mc_rank_content ul div li:nth-child(1) {
            width: 55px;
        }

        #Mc_rank_content ul div li:nth-child(2) {
            width: 55px;
            height: 55px;
        }

        #Mc_rank_content ul div li:nth-child(3) {
            width: 195px;
            margin: 0px 10px 0px 10px;
        }

        #Mc_rank_content ul div li:nth-child(4) {
            width: 125px;
            text-align: right;
        }

        #Btn_menu {
            position: absolute;
            left: 100px;
            bottom: 45px;
            width: 350px;
        }

        #Btn_menu li {
            list-style: none;
            width: 50px;
            line-height: 50px;
            font-size: 26px;
            text-align: center;
            color: #ffffff;
            border-radius: 50em;
            background-color: #bf9a80;
            margin: 0px 10px 0px 10px;
        }

    </style>
</head>
<body>
<div id="LoadModule" class="ver">
    <img src="images/loading.png"/>

    <p id="Txt_load"></p>
</div>
<div id="RuleModule" class="ver Bg_mask PopModule">
    <div id="RuleBox">
        <img src="images/Mc_bg_rule.png" alt=""/>

        <div id="Mc_rule_content">
            <img src="images/Mc_rule.png" id="Mc_rule"/>
        </div>
        <img src="images/Btn_close2.png" id="Btn_close2" class="Btn_close"/>
    </div>
</div>
<div id="RankModule" class="ver Bg_mask PopModule">
    <div id="RankBox">
        <img src="images/Mc_bg_rank.png" alt=""/>

        <div id="Mc_rank_content">
            <ul>
                <div class="hor">
                    <li>1</li>
                    <li>
                        <div>
                            <img src="images/pic.png"/>
                        </div>
                    </li>
                    <li>小夜曲</li>
                    <li>999分</li>
                </div>
            </ul>
        </div>

        <img src="images/Btn_close1.png" id="Btn_close1" class="Btn_close"/>
        <ul id="Btn_menu" class="hor">
            <li id="Btn_menu1" style="background-color: #097c25;width: 100px">1期</li>
            <li id="Btn_menu2">2</li>
            <li id="Btn_menu3">3</li>
        </ul>
    </div>
</div>
<div id="GameModule"></div>
<div id="TipsModule">
    <div><p>为了更好的体验游戏，请选择竖屏模式进行游戏</p></div>
</div>
<!--<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="true"></audio>-->
<script type="text/javascript" charset="UTF-8">
    document.documentElement.style.height = window.innerHeight + 'px';
    $("#Btn_close1").on('touchstart', function (e) {
        $("#RankModule").hide();
    });
    $("#Btn_close2").on('touchstart', function (e) {
        $("#RuleModule").hide();
    });
    var preindex = 0;
    var actindex = 0;
    $("#Btn_menu li").bind('touchstart', function (e) {
        actindex = $(this).index();
        $(this).css({"background-color": "#097c25", width: "100px"});
        $(this).html((actindex + 1) + "期");
        $("#Btn_menu li").eq(preindex).css({"background-color": "#bf9a80", width: "50px"});
        $("#Btn_menu li").eq(preindex).html(preindex + 1);
        preindex = actindex;
		// 选择第几期
		var sel = actindex + 1;
        $.ajax({
            async:false,
            url: 'server.php',
            data:{act:'search',per:sel},
            type: "post",
            dataType:'json',
            success:function(result){
          		var arr = new Array();
          		arr = result.paihang;
          		var htmlblock = '';
          		for (var i=0;i<arr.length;i++) {
          			htmlblock += '<div class="hor"><li>' + arr[i]['mingci'] + '</li><li><div><img src="' + arr[i]['headimgurl'] + '"/></div></li><li>' + arr[i]['wechaname'] + '</li><li>' + arr[i]['score'] + '分</li></div>';
          		}
          		$("#Mc_rank_content ul").html(htmlblock);
            },
            error: function(XMLHttpRequest) {
            	if(XMLHttpRequest.readyState == '0'){
                	alert("网络异常");
            	}
            }
        }); 
    });
    function onPostData(){
        //提交分数GameScore
        var _0x3dd1=["\x70\x61\x72\x73\x65","\x55\x74\x66\x38","\x65\x6E\x63","\x32\x30\x31\x35\x30\x33\x31\x33\x35\x38\x34\x35\x32\x36\x39\x31","\x65\x6E\x63\x72\x79\x70\x74","\x41\x45\x53"];
		var md5_secret=CryptoJS.MD5(secret);
		var key=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](md5_secret);
		var iv=CryptoJS[_0x3dd1[2]][_0x3dd1[1]][_0x3dd1[0]](_0x3dd1[3]);
		var encrypted=CryptoJS[_0x3dd1[5]][_0x3dd1[4]](GameScore.toString(),key,{iv:iv});
		var scoreStr=encrypted.toString();
    	$.ajax({
            async:false,
            url: 'server.php',
            data:{
                act:'subScore',
                score:scoreStr
                },
            type: "post",
            dataType:'json',
            success:function(result){
                console.log(result);
                if(result.errcode !=0)
                {
                    alert(result.errmsg);
                }               
            },
            error: function(XMLHttpRequest) {
            	if(XMLHttpRequest.readyState != '4'){
                	alert("网络异常,分数提交失败");
                	window.location.reload()
            	}
            }
        });
    }

    function onRankHandler(){
		actindex = 0;
        $("#Btn_menu li").eq(actindex).css({"background-color": "#097c25", width: "100px"});
        $("#Btn_menu li").eq(actindex).html((actindex + 1) + "期");
        if (preindex != 0) {
            $("#Btn_menu li").eq(preindex).css({"background-color": "#bf9a80", width: "50px"});
            $("#Btn_menu li").eq(preindex).html(preindex + 1);
            preindex = 0;
        }
		var sel = actindex + 1;
		// 排行榜触发
    	$.ajax({
            async:false,
            url: 'server.php',
            data:{act:'search'},
            type: "post",
            dataType:'json',
            success:function(result){
          		var arr = new Array();
          		arr = result.paihang;
          		var htmlblock = '';
          		for (var i=0;i<arr.length;i++) {
          			htmlblock += '<div class="hor"><li>' + arr[i]['mingci'] + '</li><li><div><img src="' + arr[i]['headimgurl'] + '"/></div></li><li>' + arr[i]['wechaname'] + '</li><li>' + arr[i]['score'] + '分</li></div>';
          		}
          		$("#Mc_rank_content ul").html(htmlblock);
            },
            error: function(XMLHttpRequest) {
            	if(XMLHttpRequest.readyState == '0'){
                	alert("网络异常");
            	}
            }
        });
    }
    
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
                "imgUrl":'http://zt.jia360.com/game/pick/images/share.jpg',
		        "link":'http://zt.jia360.com/game/pick/index.php',
                "desc":'玩游戏赢大奖，我在这里等你哦！',
                "title":'捧在手心的惊喜–浪鲸卫浴'
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
</script>
</body>
</html>	