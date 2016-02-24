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

// $_SESSION['nature20_openid'] = 'abc123123';
// $_SESSION['nature20_wechaname'] = 'hehehe';
// $_SESSION['nature20_headimgurl'] = 'images/user3.png';

// if(!isset($_POST['openid']))
if(!$_POST['openid'])
{
    $openId = $_SESSION['nature20_openid'];
    $wechaname = $_SESSION['nature20_wechaname'];
    $headimgurl = $_SESSION['nature20_headimgurl'];

    if(empty($openId))
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
        $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_userinfo&url='.urlencode($url).'&cookie_name=nature20';
        echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit();
    }
}
else 
{
    $openId = $_POST['openid'];
    $wechaname = base64_decode($_POST['wechaname']);
    $headimgurl = urldecode($_POST['headimgurl']);
    $_SESSION['nature20_openid'] = $openId;
    $_SESSION['nature20_wechaname'] = $wechaname;
    $_SESSION['nature20_headimgurl'] = $headimgurl;
}


$check_sql = "select id,openid,from_id,wechaname,headurl,share_count from nature20 where openid='{$openId}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if(empty($check_row))
{
    $sql = "INSERT INTO nature20(add_time, add_strtotime, openid,wechaname,headurl) VALUES('".date('Y-m-d H:i:s', time())."','".time()."','".$openId."','" . $wechaname . "','{$headimgurl}')";
//    die($sql);
    mysqli_query($db, $sql);
    $mcode = mysqli_insert_id($db);
}
else
{
    $mcode = $check_row['id'];

}

if(isset($_GET['mcode']))
{
    $from_id = $_GET['mcode'] == 0 ? 0 :$_GET['mcode'];
}
else
{
    $from_id = 0;
}

$rank_sql = "select wechaname,headurl,share_count from nature20 where share_count>0 order by share_count desc limit 20";
$rank_res = mysqli_query($db, $rank_sql);

$curr_sql = "select count(*) as c from nature20 where share_count>=(select share_count from nature20 where openid='{$openId}' and share_count>0)";
$curr_res = mysqli_query($db,$curr_sql);
$curr_row = $curr_res->fetch_assoc();

$share_sql = "select headurl from nature20 where from_id={$check_row['id']} and from_id>0";
$share_res = mysqli_query($db,$share_sql);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大自然20周年</title>
<meta name="keywords" content="大自然20周年" />
<meta name="description" content="大自然20周年" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.8" />

</head>
<body>
<div class="cn-spinner" id="loading" style=" opacity: 1;">
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

<div class="swiper-container swiper-pages" id="swiper-container1">
	<div class="swiper-wrapper" id="wrapper">
		  <div class="swiper-slide page-1 ps1">
			  <div class="container">
			  		<div class="am am1">
				  		 <img src="images/logo.png" alt=""/>
					</div>
					<div class="am am2">
						<a href="http://b.mashort.cn/S.zCObj"><img src="images/tmall.png" alt=""/></a>
					</div>
					<div class="am am3">
						<img src="images/point.png" alt=""/>
					</div>					
					<div class="am am4">
						<img src="images/text.png"  alt=""/>
					</div>
					<div class="am am5" id="start">
						<img src="images/qs.png" alt=""/>
					</div>
					<div class="am am6" id="rank">
						<img src="images/rk.png" alt=""/>
					</div>				
			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2">
			  <div class="container2">
				<div class="am am1">
					<img src="images/text2.png"  alt=""/>
				</div>
				<div class="am am2">
					<img src="images/j1.png"  alt=""/>
				</div>
				<div class="am am3">
					<img src="images/j2.png"  alt=""/>
				</div>
				<div class="am am4">
					<img src="images/j3.png"  alt=""/>
				</div>
				<div class="am am5">
					<img src="images/text3.png"  alt=""/>
				</div>
				<div class="am am6" id="know">
					<img src="images/know.png"  alt=""/>
				</div>
			  </div>             
		  </div>

		  <div class="swiper-slide page-3 ps3">
			  <div class="container3">
			  </div>
		  </div>

		  <div class="swiper-slide page-4 ps4">
			  <div class="container4">
   				<div class="am am1">
					<img src="images/rk-t.png" alt="">
				</div>
				<div class="am am2">
                    <?php
                        $i = 1;
                        while($rank_row = $rank_res->fetch_assoc())
                        {
                    ?>
					<div class="umsg cf">
						<span class="rk-num"><?php echo $i;$i++;?></span >
						<div class="u-info">
							<div class="mark"><img src="<?php echo $rank_row['headurl'];?>" alt=""></div>
							<span class="nickname"><?php echo $rank_row['wechaname'];?></span>
						</div>
						<span class="staff"><?php echo $rank_row['share_count'];?></span>
					</div>
                    <?php
                        }    
                    ?>
					
				</div>

				<div class="am am3">
				    <p class="tle">
				    	<span>——</span>
				    	<span>我的排名</span>
				    	<span>——</span>
				    </p>
					<div class="mymsg cf">
						<span class="my-num"><?php echo $curr_row['c'];?></span >
						<div class="my-info">
							<div class="mark"><img src="<?php echo $check_row['headurl'];?>" alt=""></div>
							<span class="nickname"><?php echo $check_row['wechaname'];?></span>
						</div>
						<span class="staff"><?php echo $check_row['share_count'];?></span>
					</div>
					<p class="line"></p>
				</div>
				<div class="am am6"><p>你的庆生伙伴</p></div>
				<div class="am am4">
					<ul class="frd">
                    <?php
                        while($share_row = $share_res->fetch_assoc())
                        {
                    ?>
						<li><img src="<?php echo $share_row['headurl'];?>" alt=""/></li>
                    <?php
                        }    
                    ?>
					</ul>
				</div>
				<div class="am am5" id="back">
					<img src="images/back.png"alt="" />
				</div>
			  </div>           
		  </div>
		  
		  <div class="swiper-slide page-5 ps5">
			  <div class="container5">
				<div class="am am1">
					<img src="images/thx.png"  alt="" />
				</div>
			  </div>                 
		  </div>                  
    </div>
</div>

			<div class="fbg hide" id="fbg">
				<img src="images/bg2.png" alt="">
				<div class="form">
					<img src="images/form.png" alt="">
					<div class="pic"><img src="<?php echo $headimgurl;?>"  alt=""></div>
					<p class="u-name"><?php echo $wechaname;?></p>
					<textarea  id="textmsg" class="textmsg" name="textmsg" value="" col="6"></textarea>
					<p class="msg">你的庆生太给力了!“我”将寿比南山啦!请填写以下信息,方便兑奖噢!</p>
					<p class="name"><label>姓名:</label><input type="text" name="name" value="" id="name"></p>
					<p class="tel"><label>电话:</label><input type="phone" name="phone" value="" id="phone"></p>
                    <input type="hidden" name="phone" value="<?php echo $from_id;?>" id="fromId">
                    <p class="btnBox">
                    	<img src="images/fin.png" alt=""  id="done"/>
                    	<img src="images/invite.png" alt="" id="invite"/>
                    </p>
				</div>
			</div>

				
			
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>



$(function(){

// 输入框获取焦点
$('.textmsg').click(function(){
	$('.textmsg').focus();
})

$('#name').click(function(){
	$('#name').focus();
});
$('#phone').click(function(){
	$('#phone').focus();
});

$('#know').click(function(){
	$('#fbg').show();
});

$("#textmsg").css("height", "95px")


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
	 		"imgUrl":'http://zt.jia360.com/nature20/images/share.jpg',
	 		"link":'http://zt.jia360.com/nature20/index.php?a=a&mcode=<?php echo $mcode;?>',
	 		"desc":"【<?php echo $wechaname;?>】已经在大快朵颐享受919大自然地板20周年蛋糕了，一起庆生赢取足金项链！",
	 		"title":"大自然地板20周年庆生"
	 	};
	 	wx.onMenuShareAppMessage(wxData);
	 	wx.onMenuShareTimeline(wxData);
	 });

});
</script>


<!--#include virtual="/public/tongji.html"-->

</body>
</html>