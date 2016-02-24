<?php
error_reporting(0);
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$id = empty($_GET['id']) ? '' : $_GET['id'];
if(empty($id)){
	echo "<script>alert('数据异常，请退出重试')</script>";exit;
}

$info_sql = "SELECT * FROM live WHERE id=".$id;
$info = mysqli_query($db, $info_sql);
while($info_row = $info->fetch_array()){
	$info_arr = $info_row;
}

$sql = "SELECT * FROM live_list WHERE is_blocked=0 AND action_id=".$id." ORDER BY add_time DESC";
$url = mysqli_query($db, $sql);

while($row = $url->fetch_array()){
	$arr[]= $row;
}
if(!empty($arr)){
	foreach ($arr as $k => $key){
		$list_arr[$k]['id'] = $key['id'];
		$list_arr[$k]['title'] = $key['title'];
		$list_arr[$k]['text'] = $key['info'];
		$list_arr[$k]['md_time'] = date('m月d日', $key['add_time']);
		$list_arr[$k]['hi_time'] = date('H:i', $key['add_time']);
	}
}
$list_arr = !empty($list_arr) ? $list_arr : '';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <meta charset="UTF-8">
	    <title><?php echo $info_arr['title']?></title>
	    <meta name="author" content="腾讯亚太家居">
	    <meta name="Copyright" content="腾讯亚太家居">
	    <meta name="format-detection" content="email=no,address=no,telephone=no">
	    <script>
			var phoneWidth = parseInt(window.screen.width);
			var phoneScale = phoneWidth/640;
			var ua = navigator.userAgent;
			if (/Android (\d+\.\d+)/.test(ua)){
				document.write('<meta name="viewport" content="width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
			} else {
				document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
			}
	    </script>
	    <link rel="stylesheet" type="text/css" href="css/new.css?v=2.0">
  </head>
  <body >
    <section class="warp">
		<header class="header">
			<p class="title"><?php echo $info_arr['title']?><span>直播</span></p>
		</header>
		<?php if($info_arr['info']){?>
      	<section class="synopsis"><?php echo $info_arr['info']?></section>
      	<?php }?>
      	<?php foreach ($list_arr as $k => $key){?>
      	<article class="live-list-item cf">
			<div class="list-item-time">
	          	<div class="item-time-date"><?php echo $key['md_time']?></div>
	          	<div class="item-time-time">
		          	<div class="time-detail"><?php echo $key['hi_time']?></div>
		          	<div class="time-dot"></div>
	          	</div>
          	</div>
          	<div class="list-item-bd">
	          	<div class="list-item-content fix-break-word">
	          		<p class="c-blue"><?php echo $key['title']?></p>
	          		<?php echo $key['text']?>
	          	</div>
          	</div>
      	</article>
      	<?php }?>
      	
    </section>
	<script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">
    $(function(){

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
	        'checkJsApi',
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			imgUrl:'<?php echo $info_arr['share_img']?>',
			//link:'http://zt.jia360.com/live/index.php?id=<?php echo $id?>',
			link:'http://zt.com/live3/index.php?id=<?php echo $id?>',
			desc:"<?php echo $info_arr['share_desc']?>",
			title:"<?php echo $info_arr['share_title']?>"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
    <!--#include virtual="/public/tongji.html"-->
</body>
</html>