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
        $openId = $_SESSION['fes_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=com_share';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['fes_openid'] = $_POST['openid'];
        $_SESSION['hxfes_wechaname'] = base64_decode($_POST['wechaname']);
        $_SESSION['hxfes_headimgurl'] = urldecode($_POST['headimgurl']);
    }
// 	$_SESSION['fes_openid'] = '1112111';
// 	$_SESSION['hxfes_wechaname'] = 'wechaname';
// 	$_SESSION['hxfes_headimgurl'] = '222';
	
    $sql = "SELECT id from game_hxfes WHERE openid='".$_SESSION['fes_openid']."'";
    $res = mysqli_query($db, $sql);
    $info = $res->fetch_assoc();
    if(!$info){
        $sql = "INSERT INTO game_hxfes(openid, wechaname, headimgurl, add_time) VALUES('".$_SESSION['fes_openid']."','".$_SESSION['hxfes_wechaname']."','".$_SESSION['hxfes_headimgurl']."','".date('Y-m-d H:i:s')."')";
        $url = mysqli_query($db, $sql);
        if(!$url){
            echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
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
        var core_url = "code.php";//二维码链接
        var home_url = "index.php";//首页链接
        function getQueryString(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]);
            return null;
        }
        var SelectNum = getQueryString("type");//选中第几个
        console.log(SelectNum);
        if (SelectNum == null) {
            //单独测试用
            SelectNum = 3;
        }
    </script>

    <link rel="stylesheet" href="css/global.css"/>
    <link rel="stylesheet" href="css/rank.css?v=1.0"/>
    <script type='text/javascript' src='./libs/touch.js'></script>
    <script type='text/javascript' src='./libs/jquery-2.1.js'></script>
    <script type='text/javascript' src='./libs/lufylegend-1.9.9.simple.js'></script>

    <!--<script type='text/javascript' src='./js/module/BUtils.js'></script>-->
    <!--<script type='text/javascript' src='./js/module/ArtFont.js'></script>-->
    <!--<script type='text/javascript' src='./js/module/plugin.js'></script>-->
    <!--<script type='text/javascript' src='./js/module/Element.js'></script>-->
    <!--<script type='text/javascript' src='./js/GameScene.js'></script>-->
    <!--<script type='text/javascript' src='./js/OverScene.js'></script>-->
    <!--<script type='text/javascript' src='./js/Main.js'></script>-->
    <script type='text/javascript' src='./libs/Redstar_Beat.min.js'></script>
    
    <title>法恩莎卫浴</title>
    <script type="text/javascript">
        function onPostData() {
            $.ajax({
                async:false,
                url:"server.php",
                data:{act:"score", score:GameScore},
                type: 'post',
                dataType:'json',
                success:function(result){
                	wx.ready(function () {
	        			wxData = {
        					imgUrl:'http://zt.jia360.com/game/hxfes/images/fx.jpg',
        		            link:'http://zt.jia360.com/game/hxfes/index.php',
        		            desc:"最近城里的小伙伴最近都在玩！法恩莎卫浴免费大礼在招手",
        		            title:"法恩莎卫浴 关爱无边 健康无限",
	        				success: function (res) {
	        					share(GameScore);
	        				}
	        			};
	        			wxData2 = {
        					imgUrl:'http://zt.jia360.com/game/hxfes/images/fx.jpg',
        		            link:'http://zt.jia360.com/game/hxfes/index.php',
        		            title:"最近城里的小伙伴最近都在玩！法恩莎卫浴免费大礼在招手",
	        				success: function (res) {
	        					share(GameScore);
	        				}
	        			};
	        			wx.onMenuShareTimeline(wxData2);
	        			wx.onMenuShareAppMessage(wxData);
	        		});
                    if(result.errcode == 1000) {
                        alert("首次参与需分享到好友或朋友圈才可加入排行榜哦！");
                    } else if(!result.errcode){
                    	mOverScene.updateBest(result.max_score);
                    } else {
                    	alert(result.errmsg);
                    }
                }
            });
        }
        function onRankHandler() {
            //结果页排行榜按钮事件
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
        	        document.getElementById("rank_modul").style.display = "block";
                }
            });
        }
    </script>
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
            background: #186d2e;
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
    </style>
</head>
<body>
<div id="loading" class="ver">
    <img src="images/loading.png"/>

    <p id="loading_txt"></p>
</div>
<div id="lufyLegend"></div>
<div id="tips">
    <div>
        <p>
            为了更好的体验游戏，请选择竖屏模式进行游戏
        </p>
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    $("#closerankBtn").bind(Event.MOUSEDOWN, function () {
        $("#rank_modul").hide();
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
<!--<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="true"></audio>-->
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
            desc:"最近城里的小伙伴最近都在玩！法恩莎卫浴免费大礼在招手",
            title:"法恩莎卫浴 关爱无边 健康无限",
        	success: function (res) {
            	share(GameScore);
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
<audio src="sound/bg.mp3" id="bgSound" preload="auto" loop="true"></audio>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>