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
    
    /* $_SESSION['fest_openid'] = '87569';
    $_SESSION['fest_wechaname'] = 'dsghgdad';
    $_SESSION['fest_headurl'] = 'baidu.com'; */
    
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['fest_openid'];
    	$wechaname = $_SESSION['fest_wechaname'];
    	$headurl = $_SESSION['fest_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=fest';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['fest_openid'] = $openId;
    	$_SESSION['fest_wechaname'] = $wechaname;
    	$_SESSION['fest_headurl'] = $headurl;
    }
    
    //是否第一次进入
    $fest_weixin = 'festival2016_ld';
    $mem_sql = "select * from $fest_weixin where openid='{$openId}'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //第一次进入
    {
    	$sql = "insert into $fest_weixin (openid,head_icon,nickname) values ('{$openId}','{$headurl}','{$wechaname}')";
    	mysqli_query($db, $sql);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
    <title>2015腾讯优居年会</title>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.3.1.7.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/swiper.animate1.0.2.min.js"></script>
    <script type="text/javascript" charset="UTF-8" src="libs/jquery-2.1.js"></script>
	<script type="text/javascript" charset="UTF-8" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" charset="UTF-8">
        function onPostData() {
            var myreg = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|18[0-9]|177)\d{8}$/;
            var usernameVal = $("#Txt_name").val();
            var phoneVal = $("#Txt_phone").val();
            if (usernameVal == "") {
                alert("请输入您的姓名！");
                return false;
            } else if (!myreg.exec(phoneVal)) {
                alert('请输入正确的手机号码！');
                return false;
            } else {
                //alert("提交")
				$.ajax({
					async:false,
					url: 'server_h5.php',
					data:{
						act:'sub',
						name:usernameVal,
						phone:phoneVal.toString()
						},
					type: "post",
					dataType:'json',
					success:function(result){
						if(result.errcode !=0)
						{
							alert(result.errmsg);
						}else{
							alert("登记成功！");
							$("#ShareModule").fadeIn();
						}
					},
					error: function(XMLHttpRequest) {
						if(XMLHttpRequest.readyState != '4'){
							alert("网络异常,请稍后重试");
						}
					}
				});
			}
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
                "imgUrl":'http://zt.jia360.com/2016/festival/images/share.jpg',
		        "link":'http://zt.jia360.com/2016/festival/',
                "desc":'2015腾讯优居年会',
                "title":'2015腾讯优居年会'
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
    </script>
</head>
<body>
<div class="swiper-container n_wrapper" id="SwiperModule">
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage1">
            <div class="relative f_wrapper ShowBox1">
                <p class="P1_bg_bottom ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="0s"><img src="images/P1_bg_bottom.jpg" alt=""/></p>

                <p class="P1_bg_top ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="0s"><img src="images/P1_bg_top.png" alt=""/></p>

                <p class="P1_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="5s"
                   swiper-animate-delay="3s"><img src="images/P1_show.png" alt=""/></p>

                <p class="P1_tit ani" swiper-animate-effect="flipInX" swiper-animate-duration="1.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_titV.png" alt=""/></p>

                <p class="P1_txt ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="3s"><img src="images/P1_txt.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage2">
            <div class="relative f_wrapper ShowBox2">
                <p class="P2_tit ani" swiper-animate-effect="flipInX" swiper-animate-duration="1.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_titV.png" alt=""/></p>

                <p class="P2_txt1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="1s"><img src="images/P2_txt1.png" alt=""/></p>

                <p class="P2_txt2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="1.1s"><img src="images/P2_txt2.png" alt=""/></p>

                <p class="P2_txt3 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/P2_txt3.png" alt=""/></p>

                <p class="P2_txt4 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.1s"><img src="images/P2_txt4.png" alt=""/></p>

                <p class="P2_txt5 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.2s"
                   swiper-animate-delay="2.2s"><img src="images/P2_txt5.png" alt=""/></p>

                <p class="P2_rect ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="3s"><img src="images/Mc_rect4.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage3">
            <div class="relative f_wrapper ShowBox3">
                <p class="P3_tit ani" swiper-animate-effect="flipInY" swiper-animate-duration="1.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_titH.png" alt=""/></p>

                <p class="P3_txt1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2s"
                   swiper-animate-delay="1s"><img src="images/P3_txt1.png" alt=""/></p>

                <p class="P3_txt2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2s"
                   swiper-animate-delay="1.1s"><img src="images/P3_txt2.png" alt=""/></p>

                <p class="P3_txt3 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/P3_txt3.png" alt=""/></p>

                <p class="P3_txt4 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.1s"><img src="images/P3_txt4.png" alt=""/></p>

                <p class="P3_txt5 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.2s"
                   swiper-animate-delay="2.2s"><img src="images/P3_txt5.png" alt=""/></p>

                <p class="Mc_rect1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect1.png" alt=""/></p>

                <p class="Mc_rect2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect2.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage4">
            <div class="relative f_wrapper ShowBox4">
                <p class="P4_show ani" swiper-animate-effect="fadeIn" swiper-animate-duration="3s"
                   swiper-animate-delay="0s"><img src="images/P4_show.jpg" alt=""/></p>

                <p class="P4_tit ani" swiper-animate-effect="flipInX" swiper-animate-duration="1.5s"
                   swiper-animate-delay="1s"><img src="images/Mc_titV.png" alt=""/></p>

                <p class="P4_txt1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="1.5s"><img src="images/P4_txt1.png" alt=""/></p>

                <p class="P4_txt2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2.5s"
                   swiper-animate-delay="1.6s"><img src="images/P4_txt2.png" alt=""/></p>

                <p class="P4_txt3 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.5s"><img src="images/P4_txt3.png" alt=""/></p>

                <p class="P4_txt4 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.6s"><img src="images/P4_txt4.png" alt=""/></p>

                <p class="Mc_rect1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.7s"><img src="images/Mc_rect3.png" alt=""/></p>

                <p class="Mc_rect2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.7s"><img src="images/Mc_rect4.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage5">
            <div class="relative f_wrapper ShowBox5">

                <p class="P5_tit ani" swiper-animate-effect="flipInY" swiper-animate-duration="1.5s"
                   swiper-animate-delay="0s"><img src="images/Mc_titH.png" alt=""/></p>

                <p class="P5_txt1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2s"
                   swiper-animate-delay="1s"><img src="images/P5_txt1.png" alt=""/></p>

                <p class="P5_txt2 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="2s"
                   swiper-animate-delay="1.1s"><img src="images/P5_txt2.png" alt=""/></p>

                <p class="P5_txt3 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/P5_txt3.png" alt=""/></p>

                <p class="P5_txt4 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2.1s"><img src="images/P5_txt4.png" alt=""/></p>

                <p class="Mc_rect1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect3.png" alt=""/></p>

                <p class="Mc_rect2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect4.png" alt=""/></p>
            </div>
        </div>

        <div class="swiper-slide n_wrapper ver hidden" id="SlidePage6">
            <div class="relative f_wrapper ShowBox6">

                <p class="P6_tit ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="3s"
                   swiper-animate-delay="0s"><img src="images/P6_tit.png" alt=""/></p>

                <p class="P6_txt1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="1s"><img src="images/P6_txt1.png" alt=""/></p>

                <p class="P6_txt2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                   swiper-animate-delay="1.7s"><img src="images/P6_txt2.png" alt=""/></p>

                <p class="P6_txt3 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                   swiper-animate-delay="1.8s"><img src="images/P6_txt3.png" alt=""/></p>

                <p class="P6_txt4 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                   swiper-animate-delay="1.9s"><img src="images/P6_txt4.png" alt=""/></p>

                <p class="Mc_rect1 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect1.png" alt=""/></p>

                <p class="Mc_rect2 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2.5s"
                   swiper-animate-delay="2s"><img src="images/Mc_rect2.png" alt=""/></p>
            </div>
        </div>
        <div class="swiper-slide ver hidden swiper-no-swiping" id="SlidePage7">
            <div class="f_wrapper relative">
                <div class="flipbook">
                    <div class="n_wrapper ver PageBox7">
                        <div class="relative ShowBox7">

                            <p class="P7_show "><img src="images/P7_show.png" alt=""/></p>

                            <p class="P7_txt1 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                               swiper-animate-delay="0s"><img src="images/P7_txt1.png" alt=""/></p>

                            <p class="P7_txt2 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                               swiper-animate-delay="0.2s"><img src="images/P7_txt2.png" alt=""/></p>

                            <p class="P7_txt3 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                               swiper-animate-delay="0.4s"><img src="images/P7_txt3.png" alt=""/></p>

                            <p class="P7_txt4 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                               swiper-animate-delay="0.6s"><img src="images/P7_txt4.png" alt=""/></p>

                            <p class="P7_txt5 ani" swiper-animate-effect="fadeInRight" swiper-animate-duration="2s"
                               swiper-animate-delay="0.8s"><img src="images/P7_txt5.png" alt=""/></p>

                            <p class="P7_txt6 ani" swiper-animate-effect="rotateInDownLeft" swiper-animate-duration="2s"
                               swiper-animate-delay="2s"><img src="images/P7_txt6.png" alt=""/></p>

                            <p class="P7_txt7 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2s"
                               swiper-animate-delay="3s"><img src="images/P7_txt7.png" alt=""/></p>

                            <p class="P7_txt8 ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2s"
                               swiper-animate-delay="3.5s"><img src="images/P7_txt8.png" alt=""/></p>

                            <p class="Mc_line ani" swiper-animate-effect="fadeIn" swiper-animate-duration="2s"
                               swiper-animate-delay="2s"><img src="images/Mc_line.png" alt=""/></p>
                        </div>
                        <p class="Mc_tip Ani_tip"><img src="images/Mc_tip.png" alt=""/></p>
                    </div>
                    <div class="n_wrapper PageBack">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="InfoModule" class="n_wrapper ver">
    <div class="relative f_wrapper ver ShowBox8">

        <p class="P8_tit"><img src="images/P8_tit.png" alt=""/></p>

        <p class="P8_txt1 "><img src="images/P8_txt1.png" alt=""/></p>

        <p><img src="images/Mc_logo.png" alt=""/></p>

        <div class="TxtBox relative">
            <img src="images/Mc_bg_name.png" alt=""/>
            <input type="text" id="Txt_name"/>
        </div>
        <div class="TxtBox relative">
            <img src="images/Mc_bg_phone.png" alt=""/>
            <input type="text" id="Txt_phone"/>
        </div>
        <p id="Btn_post"><img src="images/Btn_post.png" alt=""/></p>
    </div>
</div>
<div id="EffectModule" class="n_wrapper ver">
    <div id="EffectBox" class="f_wrapper relative">
    </div>
</div>
<img src="images/Mc_arrow.png" id="Mc_arrow"/>

<div id="ShareModule" class="n_wrapper ver">
    <div class="ver f_wrapper relative">
        <img src="images/Mc_show_share.png" class="Mc_show_share"/>
        <img src="images/Mc_txt_share.png" class="Mc_txt_share"/>
    </div>
</div>
<img src="images/Btn_sound1.png" id="Btn_sound" class="SoundAni"/>
<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="loop"></audio>
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
<script type="text/javascript" charset="UTF-8" src="libs/card.min.js"></script>
</body>
</html>
