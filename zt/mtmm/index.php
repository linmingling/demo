<?php
// die;
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
if(!strpos($agent,"MicroMessenger")){
     echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
}

//$_SESSION['mtmm_openid'] = '';
$openid = empty($_POST['openid']) ? '' : $_POST['openid'];
$wechaname = empty($_POST['wechaname']) ? '' : $_POST['wechaname'];

// $openid = 'oghnDt4j9i7ryV0e-u5GxKe_VWCI';
// $wechaname = 'hehehe';
/**/
if($openid){
    $_SESSION['mtmm_openid'] = $openid;
    $check_sql = "select * from mtmm where openid='".$openid."'";
    $url = mysqli_query($db, $check_sql);
    $arr = array();
    while($row = $url->fetch_array()){
        $arr = $row;
    }
    if(!$arr){
        $sql = "INSERT INTO mtmm(name,phone,city,prize_name, prize, add_time, add_strtotime, openid,wechaname,last_time, times, is_times) VALUES('','','','','','".date('Y-m-d H:i:s', time())."','".time()."','{$openid}','{$wechaname}'," . time() . ",'1','0')";
        mysqli_query($db, $sql);
    }
}
if(empty($openid)){
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$url = strpos($url,'?') ? $url."&rand=".time() : $url."?rand=".time();
    $redirect_url = 'http://www.yoju360.com/api/weixin_oauth.php?scope=snsapi_base&url='.$url;//静默授权
//     $redirect_url = 'http://www.yoju360.com/api/Across_oauth.php?scope=snsapi_userinfo&url='.$url.'&cookie_name=zt-mtmm';
     echo "<script language=\"javascript\">location.href=\"$redirect_url\"</script>";exit;
}

//更新时间和次数
$check_sql = "select prize_name,times,is_times,last_time from mtmm where openid='{$_SESSION['mtmm_openid']}'";
$check_res = mysqli_query($db,$check_sql);
$check_row = $check_res->fetch_assoc();
if((strtotime(date('Y-m-d',$check_row['last_time']))) < strtotime('today'))
{
    $update_sql = "update mtmm set is_times=0,last_time=" . time() . " where openid='{$_SESSION['mtmm_openid']}'";
    mysqli_query($db,$update_sql);
}
/**/

//可抽奖次数
$times_sql = "select times,is_times,last_time from mtmm where openid='{$openid}'";
$times_res = mysqli_query($db, $times_sql);
$times_row = $times_res->fetch_assoc();
$last_times = '0';

switch($times_row['is_times'])
{
    case 0:
        $last_times = '2';
        break;
    case 1:
        $last_times = '1';
        break;
    case 2:
        $last_times = '0';
        break;
    default:
        $last_times = '0';
        break;
}
//var_dump($last_times);die;
if($times_row['times'] < $last_times)
{
    $last_times = $times_row['times'];
}




//中奖名单
$draw_sql = "select id,name,phone from mtmm where prize>0 and phone>0 order by add_strtotime desc limit 8";
$draw_res = mysqli_query($db,$draw_sql);
$draw_rows = array();
while($draw_row = $draw_res->fetch_assoc())
{
    $draw_rows[$draw_row['id']]['name'] = mb_substr($draw_row['name'],0,1,'utf-8') . "**";
    $draw_rows[$draw_row['id']]['phone'] = mb_substr($draw_row['phone'],0,3) . "****" . mb_substr($draw_row['phone'],-4);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>梦天木门</title>
<meta name="keywords" content="梦天木门" />
<meta name="description" content="梦天木门" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.9"  />



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

		  <div class="swiper-slide page-1 ps1 bg1">
			  <div class="container">
					<div class="am am1">
						<img src="images/p1_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
					<div class="am am2">
						<img src="images/p1_2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown"  />
						<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next.png" />
					</div>
			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2 bg2 ">
			  <div class="container">
					<div class="am am1 animation an1" data-item="an1" data-delay="200" data-animation="fadeIn">
						<img src="images/p2_1.png"  />
					</div>
					<div class="next">
						<img src="images/next.png" />
					</div>
			  </div>             
		  </div>

		  <div class="swiper-slide page-3 ps3 bg3">
			  <div class="container">
					<div class="am am1">
						<img src="images/p3_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
					<div class="am am3">
						<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="am am2" id="object"></div>
					<div class="next">
						<img src="images/next.png" />
					</div>
			  </div>           
		  </div>
		  
		  <div class="swiper-slide page-4 ps4 bg2">
			  <div class="container">
					<div class="am am1">
						<img src="images/p4_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
					<div class="am am2">
						<img src="images/p4_2.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown"  />
						<img src="images/p1_3.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"  />
					</div>
					<div class="next">
						<img src="images/next.png" />
					</div>
			  </div>                 
		  </div>
		  
		  <div class="swiper-slide page-5 ps5 bg1">
			  <div class="container">
					<div class="am am1">
						<img src="images/p5_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
					</div>
					<div class="am am2">
						<div class="zp">
							<img src="images/p5_2.png"  class="" />
							<img src="images/p5_3.png"  class="pointer" id="pointer"/>
						</div>
						<p class="tips">您今天还有<span class="red"><?php  echo $last_times;?></span>次抽奖机会</p>
						<p><img src="images/p5_4.png"  class="btn" id="btn"/></p>
						<p class="list cf">
							<span>中奖名单： </span>
							<marquee>
                            <?php foreach($draw_rows as $k=>$v){ ?>
                              <?php  echo $v['name'];?>  <?php  echo $v['phone'];?>  
                            <?php } ?>
							</marquee>
						</p>
						<div class="rule">
							<p>活动规则</p>
							<p>1. 分享到朋友圈就可以获得1次抽奖机会，每天最高2次抽奖机会；</p>
							<p>2. 请您务必填写真实信息，以便中奖后我们与您联系；</p>
							<p>3. 终极大奖共1名，奖品为梦天木门新闻发布会门票；</p>
							<p>4. 在法律允许范围内，本活动最终解释权归浙江梦天木业有限公司所有。</p>
					
							<span class="time">抽奖时间：8月10日-8月16日</span>
						</div>
					</div>
					
			  </div>                    
		  </div>
		  
		  
		  
		  
   </div>
</div>
<!-- 获奖填写信息 -->
<div class="formTc hide" id="formTc">
	<div class="form">
		<span class="close">×</span>
		<p>请填写您的个人信息，方便领奖：</p>
		<p>
			<input type="text" class="name" placeholder="请输入您的姓名" />
		</p>
		<p>
			<input type="text" class="tel" placeholder="请输入您的手机号码" />
		</p>
		<p>
			<input type="text" class="city" placeholder="所在城市" />
		</p>
		<p>
			<img src="images/formBtn.jpg"  class="formBtn" id="formBtn"/>
		</p>
	</div>
</div>

<!-- 没中奖 -->
<div class="formTc fail hide" id="fail">
	<div class="form">
		<p>很遗憾没有中奖</p>
		<p class="shareBtn" id="shareBtn">
			分享好友再抽一次
		</p>
	</div>
</div>

<div id="shareTips" class="shareTips hide">
	<img src="images/shareTips.png" />
</div>



<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/awardRotate.js"></script>
<script src="js/my.js?v=1.2"></script>
<script>
	$(function(){
		//提交信息
		$("#formBtn").click(function(){
			var name = $("#formTc .name").val();
			var tel = $("#formTc .tel").val();
			var city = $("#formTc .city").val();
			var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
			if(name == "" || tel == "" || city == "" ){
				alert("请填写个人信息");
				return false;
			}else if(!mob.test(tel)){
				alert("请填写正确的手机号码");
				return false;
			}else{
				$.ajax({
	            	async:false,
	                url: 'server.php',
	                data:{act:'addinfo',name:name,phone:tel,city:city},
	                type: "post",
	                dataType:'json',
	                success:function(result){
                        //数据返回后执行
                        if(result.errcode != 0){
                            alert(result.errmsg);
                            return false;
                        }else{
                            alert(result.errmsg);
                            $("#formTc").hide();
                            return false;
                        }
	                	
	                }
	            });
			}
		});
		//关闭提交信息框
		$("#formTc .close").click(function(){
			$("#formTc").hide();
		})
		//关闭分享提示
		$("#shareTips").click(function(){
			$("#shareTips").hide();
		})
		//关闭分享提示
		$("#shareBtn").click(function(){
			$("#fail").hide();
			$("#shareTips").show();
		})
		//转盘
		var bRotate = false;
		var rotateTimeOut = function (){
			$('#pointer').rotate({
				angle:0,
				animateTo:2160,
				duration:8000,
				callback:function (){
					alert('网络超时，请检查您的网络设置！');
				}
			});
		};
		var rotateFn = function (awards, angles, txt){
			bRotate = !bRotate;
			$('#pointer').stopRotate();
			$('#pointer').rotate({
				angle:0,
				animateTo:angles+1800,
				duration:8000,
				callback:function (){
				
					if(awards == 0 || awards == 3 || awards == 5){
						$("#fail").show();
					}else if(awards == 7){
						alert(txt);
					}else{
						alert(txt);
						$("#formTc").show();
					}
					var tips = $(".tips .red");
					tips.html(tips.html()-1);
					bRotate = !bRotate;
				}
			});
			
			isFX = false;
		};

		$('#btn').click(function (){
			if(bRotate){
				return;
			}else if($(".tips .red").html()<1){
				alert("今天的抽奖次数已用完")
				return;
			}else{
				//rotateTimeOut();
				
        	/**/$.ajax({
	            	async:false,
	                url: 'server.php',
	                data:{act:'start'},
	                type: "post",
	                dataType:'json',
	                success:function(result){
	                	if(result.errcode != 0){
							alert(result.errmsg);
	                	}
                        else{
                            switch (result.prize) {
								case 0:
									rotateFn(0, 0, '继续加油');
									break;
								case 1:
									rotateFn(1, 51, 'Andox情侣钥匙扣');
									break;
								case 2:
									rotateFn(2, 102, 'Andox空调抱枕毯两用');
									break;
								case 3:
									rotateFn(3, 153, '继续加油');
									break;
								case 4:
									rotateFn(4, 204, 'Andox马克杯');
									break;
								case 5:
									rotateFn(5, 255, '继续加油');
									break;
								case 6:
									rotateFn(6, 306, '终极大奖');
									break;
								case 7:
									alert(result.errmsg);
									break;	
								default:
									rotateFn(0, 0, '继续加油');
									break;
							}
                        }
	                }
	            });
			}
		});

	});
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
		"imgUrl":'http://zt.jia360.com/mtmm/images/share2.jpg',
		"link":'http://zt.jia360.com/mtmm/index.php',
		"desc":"高档装修，用梦天木门",
		"title":"“带你去见他”天王之遇，机不可失",
		success:function(){
			//分享成功，增加抽奖次数
			$.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'addtimes'},
                type: "post",
                dataType:'json',
                success:function(result){
                    $.ajax({
                        async:false,
                        url: 'server.php',
                        data:{act:'addtimes'},
                        type: "post",
                        dataType:'json',
                        success:function(result){
                            //数据返回后执行
                            //alert('分享成功！');
                            $("#shareTips").hide();
                            $(".tips .red").html(result.times);
                        }
                    });
                	
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