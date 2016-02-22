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
    
    //$_SESSION['hx_llk_openid'] = '963852';
    //$_SESSION['hx_llk_wechaname'] = '王晓峰';
    //$_SESSION['hx_llk_headurl'] = 'baidu.com';
    
    
    if(!$_POST['openid'])
    //if(!isset($_POST['openid']))
    {
    	$openId = $_SESSION['hx_llk_openid'];
    	$wechaname = $_SESSION['hx_llk_wechaname'];
    	$headurl = $_SESSION['hx_llk_headurl'];
    
    	if(empty($openId))
    	{
    		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    		$redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=jlf';
    		echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    	}
    }
    else
    {
    	$openId = $_POST['openid'];
    	$wechaname = base64_decode($_POST['wechaname']);
    	$headurl = urldecode($_POST['headimgurl']);
    	$_SESSION['hx_llk_openid'] = $openId;
    	$_SESSION['hx_llk_wechaname'] = $wechaname;
    	$_SESSION['hx_llk_headurl'] = $headurl;
    }
    
    //是否第一次进入
    $table = 'hx_llk_info';
    $mem_sql = "select * from $table where openid='{$openId}'";
    $mem_res = mysqli_query($db, $mem_sql);
    $mem_row = $mem_res->fetch_assoc();
    
    if(empty($mem_row)) //第一次进入
    {
    	$sql = "insert into $table (openid,wechaname,add_time) values ('{$openId}','{$wechaname}','" . date('Y-m-d H:i:s') . "')";
    	mysqli_query($db, $sql);
    }

?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
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

		<link rel="stylesheet" type="text/css" href="css/global.css" />
		<link rel="stylesheet" type="text/css" href="css/swiper.css" />
		<link rel="stylesheet" type="text/css" href="css/animate.min.css" />
		<link rel="stylesheet" type="text/css" href="css/layout.css" />
		<script type="text/javascript" src="libs/swiper.3.1.7.min.js"></script>
        <script type="text/javascript" src="libs/swiper.animate1.0.2.min.js"></script>
		<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		
		<script src="../../public/crypto/jquery-1.8.3.min.js"></script>
    	<script src="../../public/crypto/core-min.js"></script>
    	<script src="../../public/crypto/enc-utf16-min.js"></script>
    	<script src="../../public/crypto/sha1-min.js"></script>
    	<script src="../../public/crypto/md5-min.js"></script>
    	<script src="../../public/crypto/aes.js"></script>
    	<script src="../../public/crypto/bigint.js"></script>
    	<script src="../../public/crypto/secret_new.js?v=1.2"></script>
    	
    	<script type="text/javascript">
			var _hmt = _hmt || [];
			(function() {
  				var hm = document.createElement("script");
  				hm.src = "//hm.baidu.com/hm.js?8c9ff044c1d215fd2c448dedc448d132";
  				var s = document.getElementsByTagName("script")[0]; 
  				s.parentNode.insertBefore(hm, s);
			})();
		</script>

		<title>免费抢Iphone6S，左右开战！</title>
		<style>
			#GameModule,canvas{
        				-webkit-transform: translate3d(0,0,0);
        				-webkit-tap-highlight-color:rgba(0,0,0,0);
        			}
			#TipsModule {
			            background-color: #000;
						position: fixed;
						top: 0;
						left: 0;
						right: 0;
						bottom: 0;
						z-index: 6;
			            display: none;
			        }
			
			        #TipsModule div {
			            top: 50%;
			            position: absolute;
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
		</style>
	</head>

	<body>
		<!--load_module-->
		<div class="load_module common_md" id="load_module">
			<div class="n_wrapper ver relative">
				<img src="img/common/top.png" class="top" />
				<img src="img/common/bot.png" class="bot" />
				<img src="img/common/loading.png" />
			</div>
		</div>
		<!--load_module-->
		<!--firsthalf-->
		<div class="firsthalf common_md" id="firsthalf">
			<div class="n_wrapper ver relative">
				<img src="img/common/top.png" class="top" />
				<img src="img/common/bot.png" class="bot" />
				<img src="img/common/tiaoguo.png" id="tiaoguo" />
				<div class="swiper-container relative">
					<div class="swiper-wrapper">
						<!--第1页-->
						<div class="swiper-slide">
							<div class="n_wrapper relative">
								<img src="img/p1/1.png" class="p1_1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.8s" />
								<img src="img/p1/2.png" class="p1_2 ani" swiper-animate-effect="swing" swiper-animate-duration="0.7s" swiper-animate-delay="1.1s" />
								<img src="img/p1/3.png" class="p1_3 ani" swiper-animate-effect="bounceIn" swiper-animate-duration="0.5s" swiper-animate-delay="1.9s" />
							</div>
						</div>
						<!--第1页-->
						<!--第2页-->
						<div class="swiper-slide">
							<div class="n_wrapper relative">
								<img src="img/p2/1.png" class="p2_1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.8s" />
								<img src="img/p2/2.png" class="p2_2 ani" swiper-animate-effect="shake" swiper-animate-duration="0.8s" swiper-animate-delay="0.85s" />
								<img src="img/p2/3.png" class="p2_3 ani" swiper-animate-effect="bounceIn" swiper-animate-duration="0.5s" swiper-animate-delay="1.7s" />
							</div>
						</div>
						<!--第2页-->
						<!--第3页-->
						<div class="swiper-slide">
							<div class="n_wrapper relative">
								<img src="img/p3/1.png" class="p3_1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.8s" />
								<img src="img/p3/2.png" class="p3_2 ani" swiper-animate-effect="zoomIn" swiper-animate-duration="0.8s" swiper-animate-delay="1.7s" />
								<img src="img/p3/3.png" class="p3_3 ani" swiper-animate-effect="bounceIn" swiper-animate-duration="0.8s" swiper-animate-delay="0.85s" />
							</div>
						</div>
						<!--第3页-->
						<!--第4页-->
						<div class="swiper-slide">
							<div class="n_wrapper relative">
								<img src="img/p4/1.png" class="p4_1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.8s" />
								<img src="img/p4/2.png" class="p4_2 ani" swiper-animate-effect="tada" swiper-animate-duration="0.85s" swiper-animate-delay="1s" />
								<img src="img/p4/3.png" class="p4_3 ani" swiper-animate-effect="rubberBand" swiper-animate-duration="0.5s" swiper-animate-delay="1.9s" />
							</div>
						</div>
						<!--第4页-->
						<!--第5页-->
						<div class="swiper-slide">
							<div class="n_wrapper relative">
								<img src="img/p5/1.png" class="p5_1 ani" swiper-animate-effect="fadeInDown" swiper-animate-duration="0.8s" />
								<img src="img/p5/2.png" class="p5_2 ani" swiper-animate-effect="shake" swiper-animate-duration="1s" swiper-animate-delay="1.8s" />
								<img src="img/p5/3.png" class="p5_3 ani" swiper-animate-effect="tada" swiper-animate-duration=".7s" swiper-animate-delay="1s" />
								<img src="img/p5/startBtn.png" id="startBtn" class="p5_startBtn ani" swiper-animate-effect="flipInY" swiper-animate-duration="1s" swiper-animate-delay="2.8s" />
							</div>
						</div>
						<!--第5页-->
					</div>
					<!-- 如果需要分页器 -->
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
		<!--firsthalf-->
		<!--rule_module-->
		<div class="rule_module common_md" id="rule_module">
			<div class="n_wrapper ver">
				<div class="relative rule_wra" id="rule_wra">
					<img src="img/common/res.png" id="rule_res" />
					<img src="img/common/rule_tit.png" class="common_tit" />
					<div class="rule_text" id="rule_text">
						<img src="img/common/rule.png" />
					</div>
				</div>
			</div>
		</div>
		<!--rule_module-->
		<!--rank_module-->
		<div class="rank_module common_md" id="rank_module">
			<div class="n_wrapper ver">
				<div class="relative rank_wra">
					<img src="img/common/rank_tit.png" class="common_tit" />
					<div class="rank_text">
						<ul class="rank_fir hor">
							<li class="rank_num"><strong>名次</strong> </li>
							<li class="rank_name"><strong>名称</strong></li>
							<li class="rank_score"><strong>分数</strong> </li>
						</ul>
						<!--php此处输出数据-->
						<ul class="rank_nor hor">
							<li class="rank_num">1</li>
							<li class="rank_name">王小明</li>
							<li class="rank_score">99999</li>
						</ul>
						<!--php此处输出数据-->
					</div>
					<img src="img/common/res.png" id="rank_res" />
				</div>
			</div>
		</div>
		<!--rank_module-->
		<!--win_module-->
		<div class="win_module common_md" id="win_module">
			<div class="n_wrapper ver">
				<div class="relative win_wra">
					<img src="img/common/win_tit.png" class="common_tit" />
					<div class="win_text">
						<ul class="win_fir hor">
							<li class="win_name"><strong>名称</strong></li>
							<li class="win_price"><strong>奖品</strong></li>
						</ul>
						<ul class="win_nor hor">
							<li class="win_name">王小明</li>
							<li class="win_price">I啊啊啊啊啊啊啊啊啊啊啊啊</li>
						</ul>
					</div>
					<img src="img/common/res.png" id="win_res" />
				</div>
			</div>
		</div>
		<!--win_module-->
		<!--info_module-->
		<div class="info_module common_md" id="info_module">
			<div class="n_wrapper ver">
				<div class="relative info_wra">
					<img src="img/common/info_tit.png" class="common_tit" />
					<div class="info_text">
						<p>
							<input type="" name="" id="user_name" value="" placeholder="姓名" />
						</p>
						<p>
							<input type="" name="" id="user_phone" value="" placeholder="联系电话" />
						</p>
					</div>
					<img src="img/common/submit.png" id="submit" />
				</div>
			</div>
		</div>
		<!--info_module-->
		<!--tips_module-->
		<div class="tips_module common_md" id="tips_module">
			<div class="n_wrapper ver">
				<div class="relative tips_wra">
					<img src="img/common/tips_tit.png" class="common_tit" />
					<div id="sucessmes">您的信息已经成功提交！</div>
					<img src="img/common/res.png" id="tips_res" />
				</div>
			</div>
		</div>
		<!--tips_module-->
		<div id="GameModule"></div>
		<div id="TipsModule">
			<div>
				<p>为了更好的体验游戏，请选择竖屏模式进行游戏</p>
			</div>
		</div>
		<audio src="sound/Sound_bg.mp3" id="Sound_bg" preload="auto" loop="true"></audio>
		<script type='text/javascript' charset="UTF-8" src='./libs/lufylegend-1.9.11.simple.min.js'></script>
        		<script type="text/javascript" src="libs/jquery-1.7.2.min.js"></script>
        		<script type='text/javascript' charset="UTF-8" src='./libs/Redstar_linking.min.js'></script>
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
                "imgUrl":'http://zt.jia360.com/game/linking/images/share.jpg',
                "link":'http://zt.jia360.com/game/linking/index.php',
                "desc":'快来赢取6s，幸福，从坐好一点开始，左右沙发幸福价临！',
                "title":'免费抢Iphone6S，左右开战！',
                success: function() {
                }
            };
            wx.onMenuShareAppMessage(wxData);
            wx.onMenuShareTimeline(wxData);
        });
		</script>
	</body>
</html>

