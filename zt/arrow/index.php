<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
    echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}
$_SESSION['arrow_openid'] = '';
$openid = $_REQUEST['openid'];

/**/
if($openid){
    $_SESSION['arrow_openid'] = $openid;
    $check_sql = "select * from arrow where openid='".$openid."'";
    $url = mysqli_query($db, $check_sql);
    $arr = array();
    while($row = $url->fetch_array()){
        $arr = $row;
    }
    if(!$arr){
        $sql = "INSERT INTO arrow(prize_name, prize, add_time, add_strtotime, openid, times, is_times) VALUES('','','".date('Y-m-d H:i:s', time())."','".time()."','".$openid."','1','0')";
        mysqli_query($db, $sql);
    }
}
if(empty($_SESSION['arrow_openid'])){
    $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
    $redirect_url = 'http://www.yoju360.com/api/Across_oauth.php?scope=snsapi_base&url='.$url;//静默授权
    echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>箭牌橱柜</title>
<meta name="keywords" content="箭牌橱柜" />
<meta name="description" content="箭牌橱柜" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />

</head>
<body>
<div class="warp">
	<div class="main" id="main">
		<!-- 转盘 -->
		<div id="lottery" class="lottery">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="lottery-unit lottery-unit-0"><img src="images/thx2.png"></td>
					<td class="lottery-unit lottery-unit-1"><img src="images/jp1.png"></td>
					<td class="lottery-unit lottery-unit-2"><img src="images/thx1.png"></td>
		            <td class="lottery-unit lottery-unit-3"><img src="images/thx2.png"></td>
				</tr>
				<tr>
					<td class="lottery-unit lottery-unit-11"><img src="images/thx1.png"></td>
					<td colspan="2" rowspan="2"><a href="#"></a></td>
					<td class="lottery-unit lottery-unit-4"><img src="images/jp3.png"></td>
				</tr>
				<tr>
					<td class="lottery-unit lottery-unit-10"><img src="images/jp4.png"></td>
					<td class="lottery-unit lottery-unit-5"><img src="images/thx2.png"></td>
				</tr>
		        <tr>
					<td class="lottery-unit lottery-unit-9"><img src="images/thx1.png"></td>
					<td class="lottery-unit lottery-unit-8"><img src="images/thx2.png"></td>
					<td class="lottery-unit lottery-unit-7"><img src="images/jp2.png"></td>
		            <td class="lottery-unit lottery-unit-6"><img src="images/thx1.png"></td>
				</tr>
			</table>
		</div>
		<div class="ued"><span>腾讯网•亚太家居UED出品</span></div>
		<!-- 游戏规则 -->
		<div class="rule " id="rule">
			<div class="ruleBg">
				<span class="close c1">×</span>
				<p class="title red">活动细则</p>
				<p>每人每天拥有1次抽奖机会，<span class="red">分享</span>即可增加一次。【每日限抽奖10次】</p>
				<p class="sTitle"><span>游戏时间：</span></p>
				<p>7月8日-11日（现场兑奖）</p>
				<p class="sTitle"><span>奖品设置：</span></p>
				<p>苹果卷尺、小夜灯、饭盒和行李箱</p>
			</div>
			<p class="c2"><span class="close">我知道了</span></p>
		</div>
		<!-- loading -->
		<div class="cn-spinner hide" id="loading">
			<div class="spinnerBg"></div>
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

	</div>
</div>

<script src="js/jquery-1.8.3.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
var lottery={
	index:-1,	//当前转动到哪个位置，起点位置
	count:0,	//总共有多少个位置
	timer:0,	//setTimeout的ID，用clearTimeout清除
	speed:20,	//初始转动速度
	times:0,	//转动次数
	cycle:50,	//转动基本次数：即至少需要转动多少次再进入抽奖环节
	prize:-1,	//中奖位置
	hje:-1,		//后台传回中奖位置
	init:function(id){
		if ($("#"+id).find(".lottery-unit").length>0) {
			$lottery = $("#"+id);
			$units = $lottery.find(".lottery-unit");
			this.obj = $lottery;
			this.count = $units.length;
			$lottery.find(".lottery-unit-"+this.index).addClass("active");
		};
	},
	roll:function(){
		var index = this.index;
		var count = this.count;
		var lottery = this.obj;
		$(lottery).find(".lottery-unit-"+index).removeClass("active");
		index += 1;
		if (index>count-1) {
			index = 0;
		};
		$(lottery).find(".lottery-unit-"+index).addClass("active");
		this.index=index;
		return false;
	},
	stop:function(index){
		this.prize=index;
		return false;
	}
};

function roll(i){
	lottery.times += 1;
	lottery.roll();

	if (lottery.times > lottery.cycle+10 && lottery.prize==lottery.index) {
		clearTimeout(lottery.timer);
		lottery.prize=-1;
		lottery.times=0;
		setTimeout(function(){
			switch(lottery.hje){
				case 1 :alert("恭喜您，抽中了饭盒一个");break;
				case 4 :alert("恭喜您，抽中了旅行箱一个");break;
				case 7 :alert("恭喜您，抽中了小夜灯一个");break;
				case 10 :alert("恭喜您，抽中了卷尺一个");break;
				default:alert("谢谢参与~");break;
			}
			
			click=false;
		},1000)
	}else{
		if (lottery.times<lottery.cycle) {
			lottery.speed -= 10;
		}else if(lottery.times==lottery.cycle) {
			
			lottery.prize = lottery.hje;		
			//console.log(lottery.times+'^^^^^^'+lottery.speed+'^^^^^^^'+lottery.prize);
		}else{
			if (lottery.times > lottery.cycle+10 && ((lottery.prize==0 && lottery.index==7) || lottery.prize==lottery.index+1)) {
				lottery.speed += 110;
			}else{
				lottery.speed += 20;
			}
		}
		if (lottery.speed<40) {
			lottery.speed=40;
		};
		
		lottery.timer = setTimeout(roll,lottery.speed);
	}
	return false;
}

var click=false;

window.onload=function(){
	var main = $("#main");
	var win = $(window)
	var bgH = win.width()*0.78;
	main.css({"padding-top":bgH})

	if((main.height()+bgH)<560){
		main.height(550-bgH);
	}
	if((main.height()+bgH)<win.height()){
		main.height(win.height()-bgH-30);
	}

	$("#rule .close").click(function(){
		$("#rule").hide()
	})


	lottery.init('lottery');
	$("#lottery a").click(function(){
		console.log(click)
		if (click) {
			return false;
		}else{
			click=true;
			//请求后台
			$("#loading").show();
            $.ajax({
                async:false,
                url: 'server.php',
                data:{act:'start'},
                type: "post",
                dataType:'json',
                success:function(result){
                    //数据返回后执行
                    if(result.errcode != 0){
                        $("#loading").hide();
						alert(result.errmsg);
                        return false;
					}else{
                        $("#loading").hide();
                        lottery.hje = result.prize;  
                        lottery.speed=100;
                        roll();
                        click=true;
                        return false;
                    }
                    
                }
            });

		}
	});

};
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
			"imgUrl":'http://zt.jia360.com/arrow/images/share.jpg',
			"link":'http://zt.jia360.com/arrow',
			"desc":"建博会来了！礼品也来啦！赶紧来箭牌橱柜抢吧！",
			"title":"幸运大抽奖—箭牌橱柜",
			success:function(){
				//分享成功回调
                $.ajax({
                    async:false,
                    url: 'server.php',
                    data:{act:'add'},
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
	
<!--#include virtual="/public/tongji.html"-->
</body>
</html>