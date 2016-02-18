<?php
    require_once "../data/jssdk.php";
    require_once "server.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    
    if(!$_POST['openid']){
        $openId = $_SESSION['dzr_ltjh_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_base&url='.urlencode($url);
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['dzr_ltjh_openid'] = $_POST['openid'];
    }
    
//     $_SESSION['dzr_ltjh_openid'] = '1111111';
    $sql = "SELECT name,sn,is_winning from dzr_ltjh WHERE openid='".$_SESSION['dzr_ltjh_openid']."'";
    $res = mysqli_query($db, $sql);
    $arr = $res->fetch_assoc();
    if(!$arr){
        $sql = "INSERT INTO dzr_ltjh(openid, add_time) VALUES('".$_SESSION['dzr_ltjh_openid']."','".date('Y-m-d H:i:s', time())."')";
        mysqli_query($db, $sql);
        
        $last_id = mysqli_insert_id($db);
        $strlen = strlen($last_id);
        $a = '';
        if($strlen < 4){
            for ($i=0;$i<(4-$strlen);$i++){
                $a = $a.'0';
            }
            $sn = date('md').$a.$last_id;
        } else {
            $sn = date('md').$last_id;
        }
        $up_sql = "UPDATE dzr_ltjh SET sn='".$sn."' WHERE openid='".$_SESSION['dzr_ltjh_openid']."'";
        mysqli_query($db, $up_sql);
        
        $is_winning = 0;
        $is_name = 0;
    } else {
        $is_winning = $arr['is_winning'];
        $is_name = empty($arr['name']) ? 0 : 1;
        $sn = $arr['sn'];
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
    <link rel="stylesheet" href="css/swiper.3.1.7.min.css"/>
    <link rel="stylesheet" href="css/animate.min.css"/>
    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/index.css"/>
    <script type="text/javascript" src="libs/swiper.3.1.7.min.js"></script>
    <script type="text/javascript" src="libs/swiper.animate1.0.2.min.js"></script>
    <script type="text/javascript" src="libs/jquery-2.1.js"></script>
    <title>大自然木门11.7万人疯抢</title>
</head>
<body>
<div class="ver" id="loading">
    <div class="spinner"></div>
</div>
<div class="swiper-container n_wrapper" id="SwiperModule">
    <div class="swiper-wrapper n_wrapper">
        <div class="swiper-slide n_wrapper" id="SlidePage1">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="Mc_logo"/></p>
                <p class="Txt_p1 ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_tit_p1.png"/></p>
                <div id="ShowPage1" class="ani" swiper-animate-effect="shake" swiper-animate-duration="0.5s" swiper-animate-delay="1s">
                    <img src="images/Mc_txt_p1.png" id="Mc_txt_p1"/>
                    <img src="images/Mc_hand1.png" id="Mc_hand1"/>
                </div>
                <p class="Txt Txt_logo ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.4s">腾讯网·亚太家居UED出品</p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage2">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="Mc_logo"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.7s" swiper-animate-delay="0s"><img src="images/Mc_txt_p9.png"/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage5">
                    <div class="ver n_wrapper">
                        <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="ShowLogo"/></p>

                        <div class="ShowBox">
                            <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s" swiper-animate-delay="0s"><img src="images/Mc_show_p4.jpg" class=""/></p>
                            <p class="ani" swiper-animate-effect="flash" swiper-animate-duration="0.5s" swiper-animate-delay="0.7s"><img src="images/Mc_hot.png" class="Mc_hot"/></p>
                        </div>

                        <div class="hor ShowName">
                            <p><img src="images/Mc_bg_name2.jpg" alt=""/></p>
                            <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_name_p4.png" class="Mc_name"/></p>
                            <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_price4.png" class="Mc_price"/></p>
                        </div>
                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_txt_p4.png"/></p>
                    </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage4">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="ShowLogo"/></p>

                <div class="ShowBox">
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s" swiper-animate-delay="0s"><img src="images/Mc_show_p3.jpg" class=""/></p>
                    <p class="ani" swiper-animate-effect="flash" swiper-animate-duration="0.5s" swiper-animate-delay="0.7s"><img src="images/Mc_hot.png" class="Mc_hot"/></p>
                </div>
                <div class="hor ShowName">
                    <p><img src="images/Mc_bg_name2.jpg" alt=""/></p>
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_name_p3.png" class="Mc_name"/></p>
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_price3.png" class="Mc_price"/></p>
                </div>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_txt_p3.png"/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage3">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="ShowLogo"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s" swiper-animate-delay="0s"><img src="images/Mc_show_p2.jpg" class=""/></p>

                <div class="ver ShowName">
                    <p><img src="images/Mc_bg_name.jpg" alt=""/></p>
                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_name_p2.png" class="Mc_name"/></p>

                    <div class="ver ShowTip">
                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_hand2.png" id="Btn_hand2" class="HandAni2"/></p>

                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_tip.png"/></p>
                    </div>
                </div>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_txt_p2.png"/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage6">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="ShowLogo"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s" swiper-animate-delay="0s"><img src="images/Mc_show_p5.jpg" class=""/></p>

                <div class="hor ShowName">
                    <p><img src="images/Mc_bg_name.jpg" alt=""/></p>

                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_name_p5.png" class="Mc_name"/></p>

                    <div class="ver ShowTip">
                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_hand2.png" id="Btn_hand5" class="HandAni2"/></p>

                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_tip.png"/></p>
                    </div>
                </div>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_txt_p5.png"/></p>
            </div>
        </div>
        <div class="swiper-slide n_wrapper ShowBg" id="SlidePage7">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="ShowLogo"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.2s" swiper-animate-delay="0s"><img src="images/Mc_show_p6.jpg" class=""/></p>

                <div class="hor ShowName">
                    <p><img src="images/Mc_bg_name.jpg" alt=""/></p>

                    <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_name_p6.png" class="Mc_name"/></p>

                    <div class="ver ShowTip">
                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_hand2.png" id="Btn_hand6" class="HandAni2"/></p>

                        <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_tip.png"/></p>
                    </div>
                </div>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_txt_p6.png"/></p>
            </div>
        </div>
        <div class="ver n_wrapper swiper-slide" id="CodeModule">
            <div class="ver n_wrapper">
                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.1s"><img src="images/Mc_logo.png" class="Mc_logo"/></p>

                <p class="ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_tit_p1.png" class="Mc_tit_p1"/></p>

                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_code.png" id="Mc_code"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_line1.png" id="Mc_line1"/></p>
                <p class="ani" swiper-animate-effect="fadeIn" swiper-animate-duration="0.5s" swiper-animate-delay="0.2s"><img src="images/Mc_line2.png" id="Mc_line2"/></p>

                <p class="Txt_logo ani" swiper-animate-effect="fadeInLeft" swiper-animate-duration="0.5s" swiper-animate-delay="0.4s">腾讯网·亚太家居UED出品</p>
            </div>
        </div>
    </div>
    <img src="images/Mc_arrow.png" id="Mc_arrow"/>
</div>

<div class="n_wrapper" id="PlayModule">
    <div class="n_wrapper ver">
        <p><img src="images/Mc_hand3.png" id="Mc_hand3" class="HandAni"/></p>

        <p><img src="images/Mc_txt_p7.png" alt=""/></p>
    </div>
</div>
<div class="n_wrapper" id="OverModule">
    <div class="ver n_wrapper">
        <div class="ResultBox">
            <img src="images/Mc_show_p8.png"/>
            <p><?php echo $sn ?></p>
        </div>
        <p><img src="images/Mc_txt_p8.png" id="Mc_txt_p8"/></p>

        <p>
            <?php if($is_name){?>
            <img src="images/Btn_share.png" id="Btn_share"/>
            <?php }else{?>
            <img src="images/Btn_ok.png" id="Btn_ok"/>
            <?php }?>
        </p>
        <img src="images/Mc_bag.png" id="bag1"/>
        <img src="images/Mc_bag.png" id="bag2"/>
        <img src="images/Mc_bag.png" id="bag3"/>
        <img src="images/Mc_bag.png" id="bag4"/>
    </div>
</div>
<div class="ver n_wrapper" id="InfoModule">
    <div class="ver n_wrapper">
        <div id="InfoBox">
            <img src="images/Mc_bg_post.png" id="Mc_bg_post"/>
            <input id="Txt_name" type="text" placeholder="姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名"/>
            <input id="Txt_phone" type="text" placeholder="联系电话"/>
            <img src="images/Btn_post.png" id="Btn_post"/>
        </div>
    </div>
</div>
<div class="ver n_wrapper" id="PopModule">
    <div class="ver n_wrapper">
        <p><img src="images/Mc_bg_pop.png" alt=""/></p>

        <p><img src="images/Btn_share.png" id="Btn_share"/></p>
    </div>
</div>
<div class="t_right" id="ShareModule">
    <img src="images/Mc_arrow_share.png" alt=""/>
</div>
<script type="text/javascript" src="libs/Main.js?v=1.3"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    var is_winning = <?php echo $is_winning?>;
    var is_name = <?php echo $is_name?>;
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
            "imgUrl":'http://zt.jia360.com/dzr_ltjh/images/share.jpg',
            "link":'http://zt.jia360.com/dzr_ltjh/index.php',
            "desc":"百元代金券一摇到手 决战网购陷阱 正品买贵赔十",
            "title":"大自然木门11.7万人疯抢"
        };
        wx.onMenuShareAppMessage(wxData);
        wx.onMenuShareTimeline(wxData);
    });
</script>
</body>
</html>