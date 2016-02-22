<?php
	require_once "../../data/jssdk.php";
	require_once "server.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();

    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    if(time() > strtotime('2015-11-02')){
        echo "<script>alert('活动已结束！')</script>";
    }
    //微信授权
    if(!$_POST['openid']){
        $openId = $_SESSION['hxfes_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=com_share';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['hxfes_openid'] = $_POST['openid'];
        $_SESSION['hxfes_wechaname'] = base64_decode($_POST['wechaname']);
        $_SESSION['hxfes_headimgurl'] = urldecode($_POST['headimgurl']);
    }
// 	$_SESSION['hxfes_openid'] = '1112111';
// 	$_SESSION['hxfes_wechaname'] = 'wechaname';
// 	$_SESSION['hxfes_headimgurl'] = '222';
	
    $sql = "SELECT id from game_hxfes WHERE openid='".$_SESSION['hxfes_openid']."'";
    $res = mysqli_query($db, $sql);
    $info = $res->fetch_assoc();
    if(!$info){
        $sql = "INSERT INTO game_hxfes(openid, wechaname, headimgurl, add_time) VALUES('".$_SESSION['hxfes_openid']."','".$_SESSION['hxfes_wechaname']."','".$_SESSION['hxfes_headimgurl']."','".date('Y-m-d H:i:s')."')";
        $url = mysqli_query($db, $sql);
        if(!$url){
            echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
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

    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/index.css?v=1.0"/>
    <link rel="stylesheet" href="css/selecthor.css"/>
    <link rel="stylesheet" href="css/selectver.css"/>
    <link rel="stylesheet" href="css/rule.css"/>
    <link rel="stylesheet" href="css/rank.css?v=1.0"/>
    <script type="text/javascript" src="libs/touch.js"></script>
    <link rel="stylesheet" href="css/swiper.css"/>
    <script type="text/javascript" src="libs/jquery-2.1.js"></script>
    <script type="text/javascript" src="libs/swiper.min.js"></script>
    <title>法恩莎卫浴</title>
</head>

<body>
<div class="n_wrapper">
    <div class="relative" id="index_mdu">
        <p class="t_center"><img src="img/index/ad.png" id="ad"/></p>

        <p class="t_center"><img src="img/index/startBtn.png" id="startBtn"/></p>

        <p class="t_center"><img src="img/index/rankBtn.png" id="rankBtn"/></p>
    </div>
    <div id="selecthor_mdu" class="relative n_wrapper">
        <div class="n_wrapper ver">
            <div id="sel_wrapper">
                <p class="t_center"><img src="img/hor/tip.png"/></p>
                <section class="relative">
                    <div class="swiper-container" id="horsw">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="img/hor/child.png"/></div>
                            <div class="swiper-slide"><img src="img/hor/old.png"/></div>
                            <div class="swiper-slide"><img src="img/hor/man.png"/></div>
                        </div>
                    </div>
                    <img src="img/hor/left.png" id="left"/>
                    <img src="img/hor/right.png" id="right"/>
                </section>

            </div>
            <img src="img/hor/l1.png" class="l1"/>
            <img src="img/hor/l2.png" class="l2"/>
            <img src="img/hor/l3.png" class="l3"/>
        </div>
    </div>
    <div id="selectver_mdu" class="relative n_wrapper">
        <div class="swiper-container" id="versw">
            <div class="swiper-wrapper">
                <div class="swiper-slide ver relative">
                    <img id="verOne" width="640" height="837"/>
                    <img src="img/hor/l1.png" class="l1"/>
                    <img src="img/hor/l2.png" class="l2"/>
                    <img src="img/hor/l3.png" class="l3"/>
                    <img src="img/ver/bottom.png" class="bottom"/>
                </div>
                <div class="swiper-slide ver relative">
                    <img id="verTwo" width="640" height="837"/>
                    <img src="img/hor/l1.png" class="l1"/>
                    <img src="img/hor/l2.png" class="l2"/>
                    <img src="img/hor/l3.png" class="l3"/>
                    <img src="img/ver/bottom.png" class="bottom"/>
                </div>

                <div class="swiper-slide swiper-no-swiping">
                   <img src="img/hor/l2.png" class="l2"/>
                   <img src="img/hor/l3.png" class="l3"/>
                    <div class="n_wrapper relative">
                        <div id="ruleheight" class="ver">
                            <p class="t_center"><img src="img/rule/txt.png"/></p>

                            <div class="t_left" style="font-size: 1.8rem;color: #FFFFFF;width: 500px;">点击<span
                                    id="item"></span>,测试限定时间内能够关爱TA多少次。点击其他产品或空白处会随机扣除分数，超过5次，则游戏结束。
                            </div>
                            <section class="hor" id="selectList">
                                <div><img src="img/rule/matongdian.png" alt=""/><span><img src="img/rule/selected.png"
                                                                                           alt=""
                                                                                           class="unactive"/></span>
                                </div>
                                <div><img src="img/rule/matong.png" alt=""/><span><img src="img/rule/selected.png"
                                                                                       alt="" class="unactive"/></span>
                                </div>
                                <div><img src="img/rule/yugang.png" alt=""/><span><img src="img/rule/selected.png"
                                                                                       alt="" class="unactive"/></span>
                                </div>
                            </section>
                           <p class="t_center"><img src="img/rule/playBtn.png" id="playBtn" style="margin-top: 125px"/></p>
                        </div>
                        <div id="ruleBot">
                            <div class="relative">
                                <img src="img/rule/paper.png"/>
                                <img src="img/rule/ruleBtn.png" id="ruleBtn"/>
                            </div>
                        </div>
                        <div id="ruletxtCon">
                            <div class="t_center relative" style="margin-top: -100px;">
                                <img src="img/rule/rulebg.png"/>
                                  <div id="ruleTxt">
                                       <img src="img/rule/ruletxt1.png" alt=""/>
                                  </div>
                                <img src="img/rule/close.png" id="closeBtn"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="rank_modul">
        <div class="t_center relative" style="margin-top: -100px;">
            <img src="img/rule/rank.png"/>
            <div id="rank_list_wrapper">
                <ul>
                    <div class="hor">
                        <li class="bold">名次</li>
                        <li class="bold">名称</li>
                        <li class="bold">分数</li>
                    </div>
                    <div class="hor">
                        <li>1</li>
                        <li>王小明</li>
                        <li>99999</li>
                    </div>
                </ul>
            </div>
            <img src="img/rule/close.png" id="closerankBtn"/>
        </div>
        <ul id="pagecon" class="hor pack_justify">
            <li id="oneList">第1期</li>
            <li class="no_select" id="twoList">第2期</li>
        </ul>
    </div>
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    //		selctItem
    //		0->child
    //		1->old
    //		2->man
    var selctItem = null;
    $("#startBtn").bind(Event.MOUSEDOWN, function () {
        $("#index_mdu").hide();
        $("#selecthor_mdu").show();
        var mySwiper = new Swiper('#horsw', {
            direction: 'horizontal',
            loop: false,
 onTap:function(){
                $("#verOne").attr({
                    src: 'img/ver/' + imgArr[mySwiper.activeIndex] + "1.png"
                });
                $("#verTwo").attr({
                    src: 'img/ver/' + imgArr[mySwiper.activeIndex] + "2.png"
                });
                selctItem = mySwiper.activeIndex;
                $("#selecthor_mdu").hide();
                $("#selectver_mdu").show();
                var myverSwiper = new Swiper('#versw', {
                    direction: 'vertical',
                    loop: false,
                });

                $("#selectList div span img").eq(selctItem).removeClass("unactive");
                $("#selectList div span img").eq(selctItem).addClass("active");
                $("#item").html(textArr[selctItem]);
            }
        });
        document.getElementById("left").addEventListener(Event.MOUSEDOWN, function () {
            mySwiper.slidePrev();
        });
        document.getElementById("right").addEventListener(Event.MOUSEDOWN, function () {
            mySwiper.slideNext();
        });

        var imgArr = ["child", "old", "man"];
        var textArr = ["“儿童马桶”", "“智能马桶”", "“按摩浴缸”"]

    });
    $("#rankBtn").bind(Event.MOUSEDOWN, function () {
        $.ajax({
            async:false,
            url:"server.php",
            data:{act:"rank",qishu:0},
            type: 'post',
            dataType:'json',
            success:function(result){
            	var list = $("#rank_list_wrapper ul");
  	            list.html('<div class="hor"><li class="bold">名次</li><li class="bold">名称</li><li class="bold">分数</li></div>');
  		 		for(i=0;i<result.length;i++){
  	                list.append('<div class="hor">'+
  	                    '<li>'+result[i]['rank']+'</li>'+
  	                    '<li>'+result[i]['wechaname']+'</li>'+
  	                    '<li>'+result[i]['score']+'</li>'+
  	                    '</div');
  	            };
               	$("#index_mdu").hide();
                $("#rank_modul").show();
            }
        });
    });
    $("#closerankBtn").bind(Event.MOUSEDOWN, function () {
        $("#index_mdu").show();
        $("#rank_modul").hide();
    });
    $("#ruleBtn").bind(Event.MOUSEDOWN, function () {
        $("#ruletxtCon").show();
    });
    $("#playBtn").bind(Event.MOUSEDOWN, function () {
        window.location.href = "game.php?type=" + (selctItem+1).toString();
    });
    $("#closeBtn").bind(Event.MOUSEDOWN, function () {
        $("#ruletxtCon").hide();
    });
    $("#oneList").bind(Event.MOUSEDOWN, function () {
        $.ajax({
            async:false,
            url:"server.php",
            data:{act:"rank",qishu:1},
            type: 'post',
            dataType:'json',
            success:function(result){
            	var list = $("#rank_list_wrapper ul");
  	            list.html('<div class="hor"><li class="bold">名次</li><li class="bold">名称</li><li class="bold">分数</li></div>');
  		 		for(i=0;i<result.length;i++){
  	                list.append('<div class="hor">'+
  	                    '<li>'+result[i]['rank']+'</li>'+
  	                    '<li>'+result[i]['wechaname']+'</li>'+
  	                    '<li>'+result[i]['score']+'</li>'+
  	                    '</div');
  	            };
    	        $("#twoList").css("color"," #b5b5b5");
    	        $("#oneList").css("color","#ffffff")
            }
        });
    });
    $("#twoList").bind(Event.MOUSEDOWN, function () {
        $.ajax({
            async:false,
            url:"server.php",
            data:{act:"rank",qishu:2},
            type: 'post',
            dataType:'json',
            success:function(result){
            	var list = $("#rank_list_wrapper ul");
  	            list.html('<div class="hor"><li class="bold">名次</li><li class="bold">名称</li><li class="bold">分数</li></div>');
  		 		for(i=0;i<result.length;i++){
  	                list.append('<div class="hor">'+
  	                    '<li>'+result[i]['rank']+'</li>'+
  	                    '<li>'+result[i]['wechaname']+'</li>'+
  	                    '<li>'+result[i]['score']+'</li>'+
  	                    '</div');
  	            };
    	        $("#oneList").css("color"," #b5b5b5");
    	        $("#twoList").css("color","#ffffff");
            }
        });
        
    });
</script>
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
    wx.ready(function () {
        var wxData = {
            imgUrl:'http://zt.jia360.com/game/hxfes/images/fx.jpg',
            link:'http://zt.jia360.com/game/hxfes/index.php',
            desc:"最近城里的小伙伴最近都在玩！法恩莎免费大礼在招手",
            title:"法恩莎卫浴 关爱无边 健康无限",
        	success: function (res) {
        		share(0);
	   		}
        };
        wx.onMenuShareAppMessage(wxData);
        wx.onMenuShareTimeline(wxData);
    });
    function share(score){
		$.ajax({
            async:false,
            url:"server.php",
            data:{act:"share",score:score},
            type: 'post',
            dataType:'json',
            success:function(result){
            }
        });
    }
</script>
<!--#include virtual="/public/tongji.html"-->
</html>