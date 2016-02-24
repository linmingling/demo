<?php
	define('ROOT_PATH', dirname(__FILE__));
	require(ROOT_PATH . '../../data/config.php');
	require_once(ROOT_PATH .'../../data/jssdk.php');
    $jssdk = new JSSDK();
    $signPackage = $jssdk->GetSignPackage(); 
    
    //查询数据
    $table = 'niujin_toupiao';
    $mem_sql = "select * from $table";
    $mem_res = mysqli_query($db, $mem_sql);
	
	$tmp = array();
	$i = 1;
	while($row = $mem_res->fetch_assoc()) {
		$tmp[$i]['num'] = $row['num'];			
		$i++;
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="<yes>    </yes>" /><!-- 删除苹果默认的工具栏和菜单栏 -->
    <meta name="apple-mobile-web-app-status-bar-style"  content="black" /><!-- 设置苹果工具栏颜色 -->
    <meta name="format-detection" content="telphone=no,     email=no" /><!--    忽略页面中的数字识别为电话，忽略email识别 -->
    <!-- 启用360浏览器的极速模式(webkit) -->
    <meta name="renderer" content="webkit">
    <!-- 避免IE使用兼容模式 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- 针对手持设备优化，主要是针对一些老的不识别<viewpor> </viewpor>t的浏览器，比如黑莓 -->
    <meta name="HandheldFriendly" content="true">
    <!-- 微软的老式浏览器 -->
    <meta name="MobileOptimized" content="320">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="portrait">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="portrait">
    <!-- UC强制全屏 -->
    <meta name="full-screen" content="yes">
    <!-- QQ强制全屏 -->
    <meta name="x5-fullscreen" content="true">
    <!-- UC应用模式 -->
    <meta name="browsermode" content="application">
    <!-- QQ应用模式 -->
    <meta name="x5-page-mode" content="app">
    <!-- windows phone 点击无高光 -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- 适应移动端end -->
    

    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css?v=1.0" />
    <script type="text/javascript" src="js/jquery-1.11.1.min.js?v=1.0"></script>
    <script type="text/javascript" src="js/index.js?v=1.0"></script>
    <script type="text/javascript" src="js/TouchSlide.1.1.js?v=1.0"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <title>牛津字典2015年度之词</title>
	
	<script type="text/javascript">
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
				"imgUrl":'http://zt.jia360.com/niujin/img/share.jpg',
				"link":'http://zt.jia360.com/niujin/',
				"desc":'牛津字典2015年度词竟然是...显然牛津君颠覆了过去25年传统，因为严格来说这并不算字',
				"title":'牛津字典2015年度之词竟然是......',
				success:function(){
					
				}
			};
			wx.onMenuShareAppMessage(wxData);
			wx.onMenuShareTimeline(wxData);
		});
	</script>
</head>
<body>
<section class="wrap">
    <img  class="bg" src="img/bg.jpg" alt="" />
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one1"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one2"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one3"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one4"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="one5"></a>

    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="two1"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="two2"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="two3"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="two4"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="two5"></a>


    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="three1"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="three2"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="three3"></a>
    <a href="http://www.jia360.com/2015/1223/1450866766864.html#"  class="three4"></a>
    <div class="code">
        <p><span class="close">x</span></p>
        <a href="http://www.jia360.com/2015/1223/1450866766864.html#"><img src="img/biedian.png" alt=""  class="codei" /></a>
    </div>



    <div class="left"></div>
    <div class="right"></div>

    <div class="left_l">

        <div class="left_s" id="leftsh"><?php echo $tmp[1]['num'] ?></div>
        <p class="pick">票</p>   
        
    </div>
    <div class="right_r">
        <div class="right_s"><?php echo $tmp[2]['num'] ?></div>
        <p class="pick">票</p>
    </div>

</section>
<!--#include virtual="/public/tongji.html"-->
</body>
</html>