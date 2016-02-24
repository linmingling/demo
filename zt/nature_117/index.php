<?php
define('ROOT_PATH', dirname(__FILE__));
require (ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
//优居生活服务号
$signPackage = $jssdk -> GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if (!strpos($agent, "MicroMessenger")) {
	echo "<script>alert('请在微信浏览器中打开！')</script>";exit ;
}

// $_SESSION['nature_117_openid'] = 'abc123123';
// $_SESSION['nature_117_wechaname'] = 'hehehe';
// $_SESSION['nature_117_headurl'] = 'abcaaa';

// if(!isset($_POST['openid']))
if (!$_POST['openid']) 
{
	$openId = $_SESSION['nature_117_openid'];
	$wechaname = $_SESSION['nature_117_wechaname'];
	$headurl = $_SESSION['nature_117_headurl'];

	if (empty($openId)) {
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = strpos($url, '?') ? $url . "&rand=" . time() : $url . "?rand=" . time();
		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url=' . urlencode($url) . '&cookie_name=nature_117';
		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";
		exit();
	}
} else {
	$openId = $_POST['openid'];
	$wechaname = base64_decode($_POST['wechaname']);
	$headurl = urldecode($_POST['headimgurl']);
	$_SESSION['nature_117_openid'] = $openId;
	$_SESSION['nature_117_wechaname'] = $wechaname;
	$_SESSION['nature_117_headurl'] = $headurl;
}

$check_sql = "select openid from nature_117_user where openid='{$openId}'";
$check_res = mysqli_query($db, $check_sql);
$check_row = $check_res -> fetch_assoc();
if (empty($check_row)) {
	$sql = "INSERT INTO nature_117_user(add_time, openid, wechaname, headurl) VALUES('" . date('Y-m-d H:i:s') . "','" . $openId . "','" . $wechaname . "','{$headurl}')";
	mysqli_query($db, $sql);
}

$user_info_sql = "select * from nature_117_user where openid='{$openId}'";
$user_info_res = mysqli_query($db, $user_info_sql);
$user_info_row = $user_info_res -> fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no, email=no" />
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
		<script type="text/javascript">function setWidth(a) {
	if (/Andriod/i.test(navigator.userAgent)) {
		var c, b = window.innerWidth;
		(b != a) && (c = b / a), document.addEventListener("DOMContentLoaded", function() {
			var d = document.getElementsByTagName("body")[0];
			d.style.webkitTransformOrigin = "left top";
			d.style.webkitTransform = "scale(" + c + ")";
		}, !1)
	}
}
setWidth(640);</script>
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/jgestures.min.js"></script>
		<link rel="stylesheet" href="css/global.css" />
		<link rel="stylesheet" href="css/layout.css?v=1.0" />
		<link rel="stylesheet" type="text/css" href="css/swiper.css" />
		<title>
			天后演唱会门票正在派件中，请查收
		</title>
	</head>
	<body>
		<!--<section class="m_3 n_wrapper" id="m_3">
		<div class="n_wrapper ver">
		<div class="white_wrapper m_3_con bg_white">
		<h1 class="htit">超值大礼包</h1>
		</div>
		</div>
		</section>-->
		<div class="n_wrapper">
			<!--m_1 start-->
			<section class="m_1 n_wrapper" id="m_1">
				<div class="n_wrapper ver relative">
					<div class="m_1_con">
						<p class="t_center">
							<img src="img/m_1/support.png" />
						</p>
						<p class="t_center  m_1_2">
							<img src="img/m_1/tit.png" />
						</p>
						<div class="t_center relative">
							<img src="img/m_1/mid.png" />
							<div style="position: absolute;left: 50%;-webkit-transform: translateX(-50%);bottom: -180px;">
								<p class="t_center">
									<img src="img/m_1/qianggou.png" id="qiangBtn" />
								</p>
								<p class="t_center">
									<img src="img/m_1/daijinquan.png" id="daiBtn" />
								</p>
								<?php
								if ($user_info_row['prize'] || $user_info_row['q_1'] || $user_info_row['q_2'] || $user_info_row['q_3'] || $user_info_row['q_4'] || $user_info_row['q_5'] || $user_info_row['q_6']) {
									echo "<p class='t_center' id='user_mod'><img src='img/m_1/zhongxin.png' id='user_mod_btn'/></p>";
								}
								?>
								<p class="t_center mt10	">
									腾讯网·亚太家居UED出品
								</p>
							</div>
						</div>
					</div>
				</div>
		</section>
		<!--m_1 end-->
		<!--m_2 start-->
		<section class="m_2 n_wrapper" id="m_2">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_2_con bg_white">
					<h1 class="htit">
						一元预售参与疯狂抽奖
					</h1>
					<p class="t_center">
						<img src="img/m_2/price.png" class="m_2_pri" />
					</p>
					<p class="t_center f16 mt2">
						*本活动最终解释权归大自然所有。
					</p>
					<p class="t_center mt8">
						<img src="img/m_2/yuBtn.png" id="yuBtn"/>
					</p>
				</div>
			</div>
		</section>
		<!--m_2 end-->
		<!--m_3 start-->
		<section class="m_3 n_wrapper" id="m_3">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_3_con bg_white">
					<h1 class="htit">
						超值大礼包
					</h1>
					<p class="t_center">
						<img src="img/m_3/txt.png" />
					</p>
					<div class="m_3_txt">
						<p>
							获赠价值98元的纯实木筷子礼盒。
						</p>
						<p>
							获赠《健康存折一本通》。
						</p>
						<p>
							凭存折到门店可预存100-1000元，并可享受每天1%增值。
						</p>
						<p>
							万人疯抢活动现场成功订单的，可抵扣100元货款。
						</p>
						<p>
							万人疯抢活动现场有限抢购权，优先抢购，抢完即止。
						</p>
						<p>
							请确保填写信息的正确性，以免给支付订单带来不必要的麻烦。
						</p>
						<p>
							活动最终解释权归大自然所有。
						</p>
					</div>
					<p class="t_center">
						<img src="img/m_3/nextBtn.png" id="nextBtn"/>
					</p>
				</div>
			</div>
		</section>
		<!--m_3 end-->
		<!--m_4 start-->
		<section class="m_4 n_wrapper" id="m_4">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_4_con bg_white">
					<h1 class="htit">
						填写信息
					</h1>
					<div class="m_4_mid ver">
						<div class="formlist ver pack_justify">
							<p>
								<input type="text" name="name" id="name" value="" placeholder="收件人" />
							</p>
							<p>
								<input type="text" name="phone" id="phone" value="" placeholder="收件电话" />
							</p>
							<div class="hor pack_justify" style="width: 100%;">
								<select class="province" id="province">
									<option value="0">
										省份
									</option>
								</select>
								<select class="city" id="city">
									<option value="0">
										城市
									</option>
								</select>
							</div>
							<p>
								<input type="text" id="address" value="" placeholder="收件地址" />
							</p>
						</div>
						<div class="gray_hr">
						</div>
						<p class="m_4_ling">
							<img src="img/m_4/ling.png" />
						</p>
						<p class="f16">
							*本活动最终解释权归大自然所有。
						</p>
						<p>
							<img src="img/m_4/submitBtn.png" id="m_4_submitBtn" />
						</p>
					</div>
				</div>
			</div>
		</section>
		<!--m_4 end-->
		<!--m_5 start-->
		<section class="m_5 n_wrapper" id="m_5">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_5_con bg_white">
					<h1 class="htit">
						转盘抽奖
					</h1>
					<div class="t_center m_5_pancon relative">
						<img src="img/m_5/pan.jpg" />
						<div id="pr_border" style="width: 123px;height: 120px;background-color: rgba(0,0,0,0.5);position: absolute;top:10px;left:25px;">
						</div>
					</div>
					<p class="t_center">
						<img src="img/m_5/chou.png" id="chouBtn"/>
					</p>
				</div>
			</div>
		</section>
		<!--m_5 end-->
		<section class="m_16 n_wrapper" id="m_16">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_6_con bg_white">
					<h1 class="htit">
						提示
					</h1>
					<p class="t_center mt10">
						<img src="img/m_6/0.png" />
					</p>
					<p class="f16 t_center">
						您的抽奖次数已用完！万人疯抢现场
					</p>
					<p class="f16 t_center">
						<strong style="color: #d22020;">更多大奖等着您！</strong>
					</p>
					<p class="t_center">
						<img src="img/m_6/mianfeiling.png" id="m_16_ling" />
					</p>
				</div>
			</div>
		</section>
		<!--m_6 start-->
		<section class="m_6 n_wrapper" id="m_6">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_6_con bg_white">
					<h1 class="htit">
						提示
					</h1>
					<p class="t_center mt10">
						<img src="img/m_6/0.png" />
					</p>
					<p class="f16 t_center">
						不中奖，没关系！万人疯抢现场
					</p>
					<p class="f16 t_center">
						<strong style="color: #d22020;">更多大奖等着您！</strong>
					</p>
					<p class="t_center">
						<img src="img/m_6/mianfeiling.png" id="m_6_ling" />
					</p>
				</div>
			</div>
		</section>
		<!--m_6 end-->
		<!--m_7 start-->
		<section class="m_7 n_wrapper" id="m_7">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_7_con bg_white">
					<h1 class="htit">
						提示
					</h1>
					<p class="t_center mt10">
						<img src="img/m_7/0.png" />
					</p>
					<div class="m_7_txt">
						<p class="f16">
							恭喜您获得由大自然地板万人疯抢<span id="price_txt">终极大奖</span>，兑奖码：<span id="duijiangma">88888888</span>。大自然工作人员将在20个工作日内联系您进行兑奖，请保留好您的兑奖码。
						</p>
					</div>
					<p class="t_center">
						<img src="img/m_6/mianfeiling.png" id="m_7_ling" />
					</p>
				</div>
			</div>
		</section>
		<!--m_7 end-->
		<!--m_8 start-->
		<section class="m_8 n_wrapper" id="m_8">
			<div class="n_wrapper ver">
				<h1>
					活动展示
				</h1>
				<div class="relative">
					<img src="img/m_8/m8_0.jpg" />
					<img src="img/m_8/chanping.png" id="chanping" />
				</div>
			</div>
		</section>
		<!--m_8 end-->
		<!--m_9 start-->
		<section class="m_9 n_wrapper" id="m_9">
			<div class="n_wrapper ver">
				<h1>
					产品展示
				</h1>
				<div class="relative">
					<img src="img/m_9/m9_0.jpg" />
					<img src="img/m_9/yaochu.png" id="yaochu" />
				</div>
			</div>
		</section>
		<!--m_9 end-->
		<!--m_10 start-->
		<section class="m_10 n_wrapper" id="m_10">
			<div class="n_wrapper relative">
				<div class="m_10_shake">
					<p>
						<img src="img/m_10/shake.png" id="shakeani" />
					</p>
					<p>
						<img src="img/m_10/shake_txt.png" />
					</p>
				</div>
			</div>
		</section>
		<!--m_10 end-->
		<!--m_11 start-->
		<section class="m_11 n_wrapper" id="m_11">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_11_con bg_white relative">
					<img src="img/m_11/hongbao.png" style="position: absolute;top: 90px;"/>
					<h1 class="htit">
						恭喜你
					</h1>
					<p class="t_center">
						<img src="" id="price_Img" width="340" height="486" alt="加载中..." />
					</p>
					<div class="m_11_txtcon">
						<p id="price_Txt" class="f16">
						</p>
					</div>
					<p class="t_center mt6">
						<img src="img/m_11/sure.png" id="m11_sureBtn" />
					</p>
				</div>
			</div>
		</section>
		<!--m_11 end-->
		<!--m_12 start-->
		<section class="m_12 n_wrapper" id="m_12">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_12_con bg_white">
					<h1 class="htit">
						领取代金券
					</h1>
					<div class="m_12_mid ver">
						<div class="formlist ver pack_justify">
							<p>
								<input type="text" name="_name" id="_name" value="" placeholder="收件人" />
							</p>
							<p>
								<input type="text" name="_phone" id="_phone" value="" placeholder="收件电话" />
							</p>
							<div class="hor pack_justify" style="width: 100%;">
								<select class="province" id="m_12_province">
									<option value="0">
										省份
									</option>
								</select>
								<select class="city" id="m_12_city">
									<option value="0">
										城市
									</option>
								</select>
							</div>
							<p>
								<input type="text" id="_address" value="" placeholder="收件地址" />
							</p>
						</div>
						<p class="f16">
							*本活动最终解释权归大自然所有。
						</p>
						<p>
							<img src="img/m_4/submitBtn.png" id="m_12_submitBtn" />
						</p>
					</div>
				</div>
			</div>
		</section>
		<!--m_12 end-->
		<!--m_13 start-->
		<section class="m_13 n_wrapper" id="m_13">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_13_con bg_white">
					<h1 class="htit">
						提示
					</h1>
					<div class="m_13_height ver pack_justify">
						<p class="f18 t_center">
							<strong>您的信息已提交成功！</strong>
						</p>
						<p class="t_center">
							<img src="img/m_13/zhuanfa.png" id="zhuanfa"/>
						</p>
					</div>
				</div>
			</div>
		</section>
		<!--m_13 end-->
		<!--m_14 start-->
		<section class="m_14" id="m_14">
			<div class="n_wrapper">
				<p class="t_right" style="margin: 20px;">
					<img src="img/m_14/sharetip.png" />
				</p>
			</div>
		</section>
		<!--m_14 end-->
		<!--m_15 start-->
		<section class="m_15 n_wrapper" id="m_15">
			<div class="n_wrapper ver">
				<div class="white_wrapper m_15_con bg_white">
					<h1 class="htit">
						个人中心
					</h1>
					<div class="swiper-container relative">
						<div class="swiper-wrapper">
							<?php
							if ($user_info_row['q_1'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/0.png'/></div>";
							}
							if ($user_info_row['q_2'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/1.png'/></div>";
							}
							if ($user_info_row['q_3'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/2.png'/></div>";
							}
							if ($user_info_row['q_4'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/3.png'/></div>";
							}
							if ($user_info_row['q_5'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/4.png'/></div>";
							}
							if ($user_info_row['q_6'] == 1) {
								echo "<div class='swiper-slide'><img src='img/m_15/5.png'/></div>";
							}
							?>
						</div>
						<img src="img/m_15/left.png" id="left_btn"/>
						<img src="img/m_15/right.png" id="right_btn"/>
					</div>
					<?php
					if ($user_info_row['prize_code'] > 0) {
						echo "<p class='t_center f16 m_15_1'>您的兑奖码：<span id='m_15_code'> " . $user_info_row['prize_code'] . "</span> </p>";
					}
					?>
					<p class="t_center">
						<img src="img/m_11/sure.png" id="m_15_sure"/>
					</p>
				</div>
			</div>
		</section>
		<!--m_15 end-->
		</div>
		<script type="text/javascript" src="js/swiper.min.js"></script>
		<script type="text/javascript" src="js/liandong.js?v=1.5"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>//微信分享控制
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
    "imgUrl":'http://zt.jia360.com/nature_117/img/share.jpg',
	"link": 'http://zt.jia360.com/nature_117/index.php',
	"desc": "家装大牌集结 1元超值大礼包 疯狂抽奖陈慧琳演唱会门票",
	"title": "天后演唱会门票正在派件中，请查收",
	success: function() {
		//分享成功，增加抽奖次数
		$.ajax({
			async: false,
			url: 'server.php',
			data: {
				act: 'addtimes'
			},
			type: "post",
			dataType: 'json',
			success: function(result) {
				location.reload();
			}
		});
	}
};
wx.onMenuShareAppMessage(wxData);
wx.onMenuShareTimeline(wxData);
});</script>
	</body>
</html>