<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no">
	<title>与baby圆圆嗨聊(3)</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script>
		var phoneWidth = parseInt(window.screen.width);
		var phoneScale = phoneWidth/694;
		var ua = navigator.userAgent;
		if (/Android (\d+\.\d+)/.test(ua)){
			document.write('<meta name="viewport" content="width=694, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
		} else {
			document.write('<meta name="viewport" content="width=694, user-scalable=no, target-densitydpi=device-dpi">');
		}
    </script>
</head>
<body>
	<div id="pageload"><div id="loadPress"><span></span></div></div>
	<div class="warp">
     
    	<div class="main">
        	<div class="box">

                <div class="join">
                    <span>Anglebaby邀请<em>你</em>加入了群聊<i>撤销</i></span>
                </div>
                <div class="list">
                    <ul>
                        <li class="fixed">
                            <img src="img/yuan.jpg" />
                            <div class="say">
                                <p>房子装修好烦哦！要找设计师，要找材料，还怕费用太高！<i class="bq1"></i></p>
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/ab.jpg">
                            <div class="say">
                                <p>有个好消息要告诉你哦</p>
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/ab.jpg">
                            <div class="pp" data-img="p1">
                                <img src="img/p1.jpg">
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/yuan.jpg" />
                            <div class="say">
                                <p>快点分享<i class="bq2"></i></p>
                            </div>
                        </li>
                        <li class="fixed me">
                            <img src="img/me.jpg">
                            <div class="say">
                                <p>快点分享<i class="bq4"></i></p>
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/ab.jpg">
                            <div class="say">
                                <p>最近有免费装修梦想基金开始报名啦！10月7日截止报名。</p>
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/ab.jpg">
                            <div class="say">
                                <p>免费设计、免费监理、主材免费、免费软装，不用烦恼，圆你装修梦<i class="bq3"></i><i class="bq3"></i></p></p></p>
                            </div>
                        </li>
                        <li class="fixed">
                            <img src="img/yuan.jpg">
                            <div class="say">
                                <p>我要报名！</p>
                            </div>
                        </li>
                        
                        <li class="fixed me">
                            <img src="img/me.jpg">
                            <div class="say"><p>我要报名</p></div>
                        </li>
                        <li class="fixed last">
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom">
        	<em></em>
        	<div class="input"></div>
            <ul class="choose fixed">

                <li>我要报名</li>
            </ul>
            <a href="javascript:void(0);" class="enter"></a>
        </div>
    </div>
    <div class="pop hide" id="pop">
        <div class="popWarp">
            <img src="img/bg4.png" class="popBg">
            <div class="popBox popBox1 ">
                <p class="title">活动内容</p>
                <div class="info">
                    <p>2015年9月26日至12月31日，由“腾讯亚太家居” 网站主办，联合红星美凯龙、家倍得及一些建材、家具、软装品牌等，打造“免费装修 助力圆梦”活动，围绕消费者家庭背景、家的故事、居住烦恼和对梦想中家的憧憬展开互动征集。此次活动将为5种户型的消费者提供“免费设计、免费监理、免费主材、免费装饰”，全国5名，在媒体公开发布。</p>
                    <p>报名时间：2015.09.26-2015.10.07</p>
                    <img src="img/logo.png?v=1.0" class="logo">
                </div>
                <span class="tipsIcon"></span>
                <p class="btn btn1">立即报名</p>
            </div>
            <div class="popBox popBox2 hide">
                <p class="title">参与报名</p>
                <p class="tips">（填写资料，仅供本次活动使用）</p>
                <div class="form">
                    <p class="item">
                        姓名：<input type="text" class="name" />
                    </p>
                    <p class="item">
                        手机：<input type="text" class="phone" />
                    </p>
                    <p class="item">
                        地址：<input type="text" class="adress" />
                    </p>
                    <p class="item">
                        装修面积：<input type="text" class="area" />㎡ 
                    </p>
                    <p class="item">
                        房龄：<input type="text" class="age" />
                    </p>
                </div>
                <p class="btn btn2">马上提交</p>
            </div>
        </div>
    </div>
    <div class="pop2 hide" id="pop2">
        <div class="popWarp2">
            <img src="img/bg3.jpg" class="popBg">
            <img src="img/ewm.png" class="ewm">
        </div>
    </div>
    <div class="tanchu">
        <div class="pic"><img src="img/p1.jpg"></div>
        <div class="bg"></div>
    </div>
    <audio src="img/sound.mp3" preload id="sound" style="display:none;"></audio>
    <script src="js/wxmoment.min.js"></script>
    <script src="js/zepto.min.js"></script>
    <script src="js/iscroll-lite.js"></script>
    <script src="js/common.js"></script>
    <script>
        $(function () {
            // 点击立即报名
            $("#pop .btn1").click(function(){
                $("#pop .popBox1").hide();
                $("#pop .popBox2").show();
            });
            // 提交信息
            $("#pop .btn2").click(function(){
                var name = $("#pop .form .name").val();
                var tel = $("#pop .form .phone").val();
                var address = $("#pop .form .adress").val();
                var area = $("#pop .form .area").val();
                var age = $("#pop .form .age").val();
                var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
                var num = /^[0-9]*[.]{0,1}[0-9]*$/;

                if(name =="" || tel =="" || address == "" || area == "" || age == ""){
                    alert("请填写资料！");
                }else if(!mob.test(tel)){
                    alert("请填写正确的手机号码！");
                }else if(!num.test(area)){
                    alert("请填写正确的装修面积！");
                }else if(!num.test(age)){
                    alert("请填写正确的房龄！");
                }else{
                   $.ajax({
                        async:true,
                        url:"server.php",
                        data:{act:'submit', name:name, phone:tel, address:address, acreage:area, age:age},
                        type: 'post',
                        dataType:'json',
                        success:function(result){
                            if(!result.errcode){
                                $("#pop").hide();
                                $("#pop2").show();  
                            }else{
                                alert(result.errmsg);
                            }
                        }
                    });
                }
            });
        })
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
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo'
          ]
      });
    wx.ready(function () {
        var wxData = {
            "imgUrl":'http://zt.jia360.com/hx101/img/share.jpg',
            "link":'http://zt.jia360.com/hx101/index.php',
            "desc":"Baby圆圆有好消息公布！",
            "title":"明星邀你组群嗨聊 "
        };
        wx.onMenuShareAppMessage(wxData);
        wx.onMenuShareTimeline(wxData);
    });
    </script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>