<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK("wxd6ddd7ef03d96e23", "800854664b973d99046e809f82fe8e13");//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>芝华士</title>
<meta name="keywords" content="芝华士" />
<meta name="description" content="芝华士" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />
<script src="js/jquery.js"></script>
<script src="js/util.js"></script>
<script src="js/create.js"></script>
<script src="js/tweenMax.js"></script>
<script src="js/avatar.js"></script>
<script src="js/score.js"></script>
<script src="js/ani.js"></script>
<script src="js/game.js"></script>


</head>
<body>
	<div class="view">
        <div id="timeBar"><span></span></div>
        <canvas id="demoCanvas" width="320" height="480">您的浏览器不支持canvas</canvas>
    </div>

    <!--开始前-->
    <div class="index" id="index">
        <img src="image/start.png" class="startBtn" id="openRule" />
        <img src="image/top.png" class="rankBtn" id="openRank" />
    </div>

    <!--排行榜-->
    <div class="rank" id="rank">
        <div class="rankWarp">
            <span class="close"></span>
            <img src="image/rankHead.png" class="rankHead" />
            <div class="rankMain">
                
            </div>
        </div>
    </div>

    <!--规则-->
    <div class="rule" id="rule">
        <div class="ruleWarp">
            <img src="image/ruleHead.png" class="ruleHead" />
            <div class="ruleMain">
                <p>1.限时45秒</p>
                <p>点击交换位置，三个或三个以上连成一线即可消除并获得100积分，超过3个连成一线可获得150积分。</p>
                <p>每期获奖名单将在开奖日公布（用户不得重复获奖），请关注微信号［cheerssofa］或［enlanda-mw］查阅。</p>
                <p>每期获奖者请在开奖日后的三个工作日内回复，过期视为作废，回复内容：HJ+姓名+电话号码+地址。</p>
            </div>
            <img src="image/know.png" class="know" id="start" />
        </div>
    </div>

    <!--结束界面-->
    <div id="scoreItem">
        <img src="image/shareTips.png" class="shareTips" id="shareTips" />
        <div class="scoreWarp">
            <p class="text"><span>恭喜你获得<b class="score">99999</b>分</span></p>
            <p>
                <img src="image/again.png" class="again" id="again" />
                <img src="image/shareBtn.png" class="shareBtn" id="shareBtn" />
            </p>
        </div>
    </div>

    
    <!--时间条提示-->
    <div id="over"><img src="image/over.png"></div>
    <div id="model"></div>


<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
	function hje_score(score){
        console.log(score);

    }
	window.onload = init;
        
        function init(){

            var game;
            var theme = $.getVar("theme")
            var themeName = theme ? theme : "default";
            
            //开始游戏
            game = Game.init({"canvasID":"demoCanvas", "theme":themeName});
            $("#start").click(function(){
                $("#index").hide();
                $("#rule").hide();
                Game.startGame(5);

            })
        }
        
        $("#openRule").click(function(){
            $("#rule").show();
        });
        $("#openRank").click(function(){
            var rankInfo = new Array(
                 new Array("1","何小静","99999"),
                 new Array("2","何小静","9999"),
                 new Array("3","何小静","999"),
                 new Array("4","何小静","99"),
                 new Array("5","何小静","9"),
                 new Array("6","何小静","99999"),
                 new Array("7","何小静","9999"),
                 new Array("8","何小静","999"),
                 new Array("9","何小静","99"),
                 new Array("10","何小静","9")
            )
            var rankMain = $("#rank .rankMain");
            rankMain.html('<p class="tl cf"><span class="l1">名次</span><span class="l2">名称</span><span class="l3">分数</span></p>');
            for(var i=0;i<rankInfo.length;i++){
                rankMain.append('<p class="cf">'+
                    '<span class="l1">'+rankInfo[i][0]+'</span>'+
                    '<span class="l2">'+rankInfo[i][1]+'</span>'+
                    '<span class="l3">'+rankInfo[i][2]+'</span>'+
                '</p>');
            }
            /*$.ajax({
                async:true,
                url:'',
                data:'',
                type: 'post',
                dataType:'json',
                success:function(result){
                    
                }
            });*/

            $("#rank").show();
        });
        $("#rank .close").click(function(){
            $("#rank").hide();
        });
        $("#shareBtn").click(function(){
            $("#shareTips").addClass("stShow");
        });
        $("#shareTips").click(function(){
            $("#shareTips").removeClass("stShow");
        });
        /*$("#again").click(function(){
            $("#scoreItem").hide()
            Game.startGame(5);
        });*/


	
	//微信分享控制
	wx.config({
	      debug: false,
	      appId: '<?php echo $signPackage["appId"];?>',
		  timestamp: <?php echo $signPackage["timestamp"];?>,
		  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
          signature: '<?php echo $signPackage["signature"];?>',
	      jsApiList: [
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			"imgUrl":'',
			"link":'',
			"desc":"芝华士",
			"title":"芝华士"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>