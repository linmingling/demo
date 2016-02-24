<?php
    require_once "../data/jssdk.php";
    require_once "server.php";
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage();
    
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }
    if(time() > strtotime('2015-11-16')){
        echo "<script>alert('活动已结束！')</script>";
    }
    
    if(!$_POST['openid']){
        $openId = $_SESSION['monalisa_openid'];
        if(empty($openId)){
            $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
            $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=monalisa';
            echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
        }
    } else {
        $_SESSION['monalisa_openid'] = $_POST['openid'];
        $_SESSION['monalisa_wechaname'] = base64_decode($_POST['wechaname']);
    }
    
    // $_SESSION['monalisa_openid'] = '111111';
    // $_SESSION['monalisa_wechaname'] = '222222';
    $sql = "SELECT id,surplus_num,last_time FROM monalisa WHERE openid='".$_SESSION['monalisa_openid']."'";
    $res = mysqli_query($db, $sql);
    $info = $res->fetch_assoc();
    if(!$info){
        $sql = "INSERT INTO monalisa(openid, wechaname, surplus_num, add_time) VALUES('".$_SESSION['monalisa_openid']."','".$_SESSION['monalisa_wechaname']."','3','".date('Y-m-d H:i:s')."')";
        $url = mysqli_query($db, $sql);
        if(!$url){
            echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
        }
    } else {
        if((strtotime(date('Y-m-d', time())) - strtotime(date('Y-m-d', strtotime($info['last_time'])))) >= 86400){
            $up_sql = "UPDATE monalisa SET surplus_num=3 WHERE openid='".$_SESSION['monalisa_openid']."'";
            mysqli_query($db, $up_sql);
        }
    }
    $list_sql = "SELECT id,phone,prize FROM monalisa WHERE phone <> '' ORDER BY last_time DESC LIMIT 20";
    $res = mysqli_query($db, $list_sql);
    $arr = array();
    while($row = $res->fetch_array()){
        $arr[] = $row;
    }
    if($arr){
        foreach ($arr as $k => $key){
            $list[$k] = substr($key['phone'], 0, 4).'****'.substr($key['phone'], -3).'获得'.$key['prize'];
        }
    } else {
        $list[0] = '';
    }
    
    $num_sql = "SELECT SUM(num) AS num FROM monalisa";
    $num = mysqli_query($db, $num_sql);
    $number = $num->fetch_assoc();
    $count = $number['num']*10 + 100000;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>蒙娜丽莎瓷砖双11摇一摇赢iPhone6s</title>
	<meta name="keywords" content="优居网 蒙娜丽莎" />
	<meta name="description" content="优居网 蒙娜丽莎" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.8"  />

</head>
<body>
    <div class="cn-spinner loading1" id="loading">
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
<div class="wraper">
	<div class="swiper-container swiper-pages" id="swiper-container1">
	    <div class="swiper-wrapper" id="wrapper">
			<!-- 首页 -->
			<div class="swiper-slide page-1">
				<div class="container bg1">
					<!-- logo -->
					<div class="am logo">
						<img src="images/logo.png" class="logo" />
					</div>
	
					<div class="am am3">
						<img src="images/p1_bg.png" class="p1_bg" />
					</div>
					<div class="am am1">
						<img src="images/p1_1.png"  class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInUp" />
					</div>
					<div class="am am2 animation an2" data-item="an2" data-delay="700" data-animation="fadeInUp">
						<!-- 眼见惠实按钮 -->
						<p class="btnStyle1">
							<img src="images/p1_btn1.png" class="btn1 openTc" tc="boonTc" />
						</p>
						<!-- 摇一摇按钮 -->
						<p class="btnStyle1">
							<img src="images/p1_btn2.png" class="btn2"  />
						</p>
						<p class="btnStyle2">
							<!-- 摇摇规则按钮 -->
							<img src="images/p1_btn3.png" class="btn3 openTc" tc="ruleTc"/>
							<!-- 豪礼按钮 -->
							<img src="images/p1_btn4.png" class="btn4 openTc" tc="prizeTc"/>
						</p>
						<p class="copyright">腾讯网·亚太家居UED出品</p>
					</div>
					<div class="am notice">
						<div id="x2" class="xMarquee">
						    <ol>
						    	<?php foreach ($list as $k => $key){?>
						        <li><span><?php echo $key?></span></li>
						        <?php }?>
						    </ol>
						</div>
						
					</div>
					<div class="am tips">已有<span><?php echo $count;?></span>人参与摇一摇</div>
				</div>
			</div>
			<!-- 摇一摇 -->
			<div class="swiper-slide page-2">
				<div class="container bg2">
					<div class="am blackBg"></div>
					<!-- logo -->
					<div class="am logo">
						<img src="images/logo.png" class="logo" />
					</div>
				  	<div class="am am1">
						<img src="images/p2_1.png" class="p2_1 shake"  />
						<img src="images/p2_2.png" class="p2_2"  />
						
					</div>
					<p class="btn goto" page="0">返回首页</p>

				</div>
			</div>
			<!-- 没中奖 -->
			<div class="swiper-slide page-3">
				<div class="container bg2">
					<div class="am blackBg"></div>
					<!-- logo -->
					<div class="am logo">
						<img src="images/logo.png" class="logo" />
					</div>
					<div class="am am1">
						<img src="images/failBg.png" class="failBg"  />
						<div class="textBox">
							<p class="blue" id="over">没有摇中哦</p>
							<p class="blue" id="chance">今天还有<span class="red">0</span>次抽奖机会</p>
							<p>分享朋友圈每次可再获1次机会！</p>
							<p class="btn1 btn goto hide" page="4">点击领取蒙娜丽莎瓷砖百元代金券</p>
							<p class="btn2 btn goto" page="1">再摇一次</p>
						</div>
					</div>
				</div>
			</div>
			<!-- 中奖 -->
			<div class="swiper-slide page-4" id="pricePage">
				<div class="container bg2">
					<div class="am blackBg"></div>
					<!-- logo -->
					<div class="am logo">
						<img src="images/logo.png" class="logo" />
					</div>
					<div class="am am1">
						<img src="images/jp5.jpg" class="jpImg"  />
						<img src="images/succeedBg.png" class="succeedBg"  />
						<p class="priceInfo">5元</p>
						<div class="textBox">
							<p class="red">获得<span class="name">手机话费5元</span>一个</p>
							<p>温馨提示：请填写有效联系方式以便兑奖</p>
							<p class="btn openTc" tc="form1">填写兑奖资料</p>
						</div>
					</div>

				</div>
			</div>
			<!-- 二维码 -->
			<div class="swiper-slide page-5">
				<div class="container bg2">
					<div class="am blackBg"></div>
					<!-- logo -->
					<div class="am logo">
						<img src="images/logo.png" class="logo" />
					</div>
					<div class="am am1">
						<img src="images/ewmBg.png?v=1.0" class="ewmBg"  />
						<img src="images/ewm.png" class="ewm"  />
						<div class="textBox">
							<p>分享朋友圈每次可再获1次机会！</p>
							<p class="btn openTc" tc="shareTips">邀请小伙伴一起摇一摇</p>
							<p class="btn gohome goto" page="0">回到首页</p>
						</div>
					</div>

				</div>
			</div>

			  
	   </div>
	</div>

	<!-- 活动规则 -->
	<div class="tc ruleTc hide" id="ruleTc">
		<div class="am blackBg close"></div>

		<div class="am am1 ruleBox">
			<img src="images/ruleHead.png" class="ruleHead"  />
			<div class="rule">
				<img src="images/p2_1.png" class="ruleImg"/>
				<p><span class="title1">活动时间</span></p>
				<p>2015年10月26日-11月15日</p>
				<p><span class="title1">活动形式</span></p>
				<p>打开活动页面，摇一摇，中奖后填写联系方式</p>
				<p><span class="title1">活动说明</span></p>
				<p><span class="title2">1</span>每人每天有3次摇一摇机会，每分享转发至好友或朋友圈可增加1次机会，次数不设上限。<br/><font color="red">抽奖次数次日不累计，请当天用完，每人仅限中奖一次</font></p>
				<p><span class="title2">2</span>获奖者请填写有效收件人、收件电话以及收件详细地址以便兑奖，以上3项收件信息不全的获奖者视为自动弃奖；</p>
				<p><span class="title2">3</span>摇中手机话费的将于活动结束（11月15日）后15个工作日内直接充值至登记的手机号码；</p>
				<p><span class="title2">4</span>所有奖品将于活动结束（11月15日）后15个工作日内寄发至登记的收件地址。</p>
				<p><span class="title2">5</span>本活动最终解释权归蒙娜丽莎瓷砖所有</p>
			</div>
			<img src="images/formFoot.png" class="formFoot"  />
		</div>
		<div class="closeTips close">点击空白处关闭</div>
	</div>

	<!-- 豪礼抢先看 -->
	<div class="tc prizeTc hide" id="prizeTc">
		<div class="am blackBg close"></div>
		<div class="am am1 prizeBox">
			<img data-src="images/prize.png" class="prize"  />
			
		</div>
		<div class="closeTips close">点击空白处关闭</div>
	</div>

	<!-- 眼见惠实 -->
	<div class="tc boonTc" id="boonTc">
		<div class="am blackBg close"></div>
		<div class="am am1 boonBox">
			<img src="images/boonBg.png" class="boonBg"  />
			<div id="swiper2" class="swiper swiperStyle2">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="images/boon1.png"  />
						</div>
						<div class="swiper-slide">
							<img data-src="images/boon2.png"  />
						</div>
						<div class="swiper-slide">
							<img data-src="images/boon3.png"  />
						</div>
						<div class="swiper-slide">
							<img data-src="images/boon4.png"  />
						</div>
						<div class="swiper-slide">
							<img data-src="images/boon5.png"  />
						</div>
					</div>
				</div>
				<div class="pagination"></div>
			</div>
		</div>
		<div class="closeTips close">点击空白处关闭</div>
	</div>

	<!-- 填信息1 -->
	<div class="tc formTc hide" id="form1">
		<div class="am blackBg"></div>
		<div class="am am1 formBox">
			<img src="images/formHead.png" class="formHead"  />
			<div class="form">
				<p>
					<input type="text" class="name" name="name" placeholder="收件人" />
				</p>
				<p>
					<input type="text" class="tel" name="tel" placeholder="收件电话" />
				</p>
				<p>
					<select id="province">
						<option value="0">省份</option>
					</select>
					<select id="city">
						<option value="0">城市</option>
					</select>
				</p>
				<p>
					<input type="text" class="adress" name="adress" placeholder="收件详细地址" />
				</p>
				<p><span class="btn">确定<span></p>
			</div>
			<img src="images/formFoot.png" class="formFoot"  />
			
		</div>

	</div>
	<!-- 填信息2 -->
	<div class="tc formTc hide" id="form2">
		<div class="am blackBg"></div>
		<div class="am am1 formBox">
			<img src="images/formHead.png" class="formHead"  />
			<div class="form">
				<p>
					<input type="text" class="name" name="name" placeholder="姓名" />
				</p>
				<p>
					<input type="text" class="tel" name="tel" placeholder="手机号码" />
				</p>
				<p><span class="btn">确定<span></p>
			</div>
			<img src="images/formFoot.png" class="formFoot"  />
			
		</div>

	</div>

	

	<!-- 分享提示 -->
	<div class="tc shareTips hide" id="shareTips">
		<div class="am blackBg close"></div>
		<img src="images/shareTips.png" class="close" />
	</div>

	<!-- 打开提示 -->
	<div class="tc comTips hide" id="comTips">
		<div class="am blackBg close"></div>
		<div class="text">11.11-11.15摇一摇中奖概率翻倍，祝你好运！</div>
	</div>

	<div id="music" class="music">
		<audio class="audio hide"  id="musicBox" preload="auto" src="images/shake.mp3" ></audio>
	</div>

</div>

<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/xMarquee.js"></script>
<script src="js/my.js?v=1.9"></script>

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
			"imgUrl":'http://zt.jia360.com/monalisa/images/share.jpg',
			"link":'http://zt.jia360.com/monalisa/index.php',
			"desc":"蒙娜丽莎双十一摇一摇，轻松赢话费、iPhone6s！",
			"title":"蒙娜丽莎瓷砖双11摇一摇赢iPhone6s",
			success:function(){
				$.ajax({
		            async:true,
		            url:'server.php',
		            data:{act:'share'},
		            type: 'post',
		            dataType:'json',
		            success:function(result){
			            if(result.errcode){
				            alert(result.errmsg)
				        } else {
				        	$("#chance").hide();
				        	$("#shareTips").hide();
				        }
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