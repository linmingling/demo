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
    //$_SESSION['hegii_lf_wechaname'] = '按规定';
    //$_SESSION['hegii_lf_headurl'] = 'baidu.com';
    
    
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
    $nowPer = '';
    $timeQua = array("2015-11-26 00:00:00","2015-12-09 23:59:59","2015-12-10 23:59:59");
    $nowDate = date('Y-m-d H:i:s');
    if (strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) >= strtotime($nowDate)) {
    	$nowPer = 1;
    } else if(strtotime($timeQua[1]) < strtotime($nowDate) && strtotime($timeQua[2]) >= strtotime($nowDate)) {
    	$nowPer = 2;
    } else {
    	$nowPer = 0;
    }
    
    //是否第一次进入
    $table = 'hegii_lf_info';
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
    <title>雷锋历险记</title>
    <link rel="stylesheet" type="text/css" href="css/global.css"/>
    <script type="text/javascript" charset="UTF-8">
		var wxDesc = '您好，我是恒洁快递的。您的智能马桶盖到了，能不能签收一下？';
		var wxTitle = '恒洁卫浴-雷锋历险记';
		var wxImgUrl = 'http://zt.jia360.com/game/mario/images/share.gif';
		var wxLink = 'http://zt.jia360.com/game/mario/index.php';
	</script>
    <style>
     body {
               background: url("images/Mc_bg_load.jpg");
               background-size: cover;
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
               font-size: 30px;
               color: #ffffff;
               font-weight: normal;
           }

           #LoadModule #Txt_load {
               font-size: 50px;
               font-weight: bolder;
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

           .ContentBox {
               position: relative;
           }

           #Mc_rule_content {
               position: absolute;
               left: 45px;
               top: 123px;
               width: 400px;
               height: 625px;
               overflow: hidden;
               overflow-y: scroll;
           }

           #Btn_close {
               position: absolute;
               right: 48px;
               top: 47px;
           }

           #Btn_rank2 {
               position: absolute;
               right: 25px;
               bottom: 231px;
           }

           #Btn_go {
               position: absolute;
               right: 25px;
               bottom: 78px;
           }

           #Btn_close2 {
               position: absolute;
               right: 14px;
               top: 47px;
           }

           #Btn_first {
               position: absolute;
               right: 7px;
               bottom: 217px;
           }

           #Btn_second {
               position: absolute;
               right: 7px;
               bottom: 95px;
           }

           #Mc_rank_content {
               position: absolute;
               left: 45px;
               top: 123px;
               width: 420px;
               height: 625px;
               overflow: hidden;
               overflow-y: scroll;
           }

           #Mc_rank_content ul {
               font-size: 1.6rem;
               color: #795949;
               list-style: none;
               width: 400px;
               overflow: hidden;
           }

           #Mc_rank_content ul div{
               margin-bottom: 5px;
           }

           #Mc_rank_content ul div img {
               width: 100%;
           }

           #Mc_rank_content ul li:nth-child(1) {
               width: 50px;
               text-align: left;
               margin: 0px 0px 0px 0px;
               float: left;
               line-height: 50px;
           }

           #Mc_rank_content ul li:nth-child(2) {
               width: 50px;
               height: 50px;
               margin: 0px 0px 0px 0px;
               float: left;
               line-height: 50px;
           }

           #Mc_rank_content ul li:nth-child(3) {
               width: 130px;
               margin: 0px 0px 0px 0px;
               float: left;
               line-height: 50px;
               overflow: hidden;
           }

           #Mc_rank_content ul li:nth-child(4) {
               width: 150px;
               text-align: right;
               margin-right: 0px;
               float: left;
               line-height: 50px;
           }
    </style>
</head>
<body>
<div id="LoadModule" class="hor">
    <img src="images/loading.png"/>
    <div class="ver">
        <p id="Txt_load"></p>

        <p>LOADING</p>
    </div>
</div>
<div id="RuleModule" class="ModuleBox">
    <div class="n_wrapper ver">
        <div class="ContentBox">
            <img src="images/Mc_bg_rule.png"/>
            <img src="images/Btn_close.png" id="Btn_close"/>
            <img src="images/Btn_rank2.png" id="Btn_rank2"/>
            <img src="images/Btn_go.png" id="Btn_go"/>

            <div id="Mc_rule_content">
                <img src="images/Mc_rule.png" alt=""/>
            </div>
        </div>
    </div>
</div>
<div id="RankModule" class="ModuleBox">
    <div class="n_wrapper ver">
        <div class="ContentBox">
            <img src="images/Mc_bg_rank.png" alt=""/>
            <img src="images/Btn_close.png" id="Btn_close2"/>


            <div id="Mc_rank_content">
                <ul>
                     <div class="">
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
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="true"></audio>
<script type='text/javascript' charset="UTF-8" src='./libs/jquery-2.1.js'></script>
<script type='text/javascript' charset="UTF-8" src='./libs/lufylegend-1.9.11.simple.min.js'></script>
<script type='text/javascript' charset="UTF-8" src='./libs/Hegll_mario.min.js'></script>
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
</body>
</html>	