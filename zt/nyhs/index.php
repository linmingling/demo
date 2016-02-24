<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require_once "../data/jssdk.php";
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$city_sql = "select city from nyhs_city_captcha group by city order by captcha asc";
$city_res = mysqli_query($db,$city_sql);
$city_rows = array();
while($city_row = $city_res->fetch_assoc())
{
    $city_rows[] = $city_row['city'];
}

//var_dump($city_rows);die;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>南洋胡氏22周年厂庆抽奖</title>
<meta name="keywords" content="注册抽奖-价值4999元健康之旅2日游！" />
<meta name="description" content="注册抽奖-价值4999元健康之旅2日游！" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.4"  />
</head>
<body>
<!-- 加载 -->
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
<!-- 二维码-->
<div class="am am4 hide" id="sign">
  <div class="sign">
		<img src="images/wx.jpg"  />
	</div>
</div>
<!-- end -->
 <!--说明-->
				<div class="s-ct-a am9 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
						<div class="condition">
							<div class="titles"><img src="images/smbg1.jpg"  /></div>
                            <div class="txtbox">
                               <div class="shuombt">抽奖说明 </div>
							   <div class="smtxt"><img src="images/smtxt.jpg"  /></div>
                            </div>
						</div>
						<span class="back"><img src="images/back.png"  /></span>
					</div>
				</div>
				<!-- end -->
                <!-- 注册 -->
				<div class="s-ct-a am10 hide">
					<div class="s-bg"></div>
					<div class="s-ct s-ct-4">
						<div class="cloud"></div>
                        
						<div class="condition">
							<div class="titles"><img src="images/smbg1.jpg"  /></div>
                            <div class="titles2"><img src="images/smbg2.jpg"  /></div>
							<div class="txtbox">
                               <div class="fbox"><label>姓　名：</label><input name="name" type="text" id="name"/></div>
                               <div class="fbox"><label>手机号：</label><input name="phone" type="text" id="phone"/></div>

                               <div class="fbox" id="city-box"><label>城　市：</label>
                                <select name="city" class="city-select" id="city-select" onchange="addOther(this.options[this.options.selectedIndex].value);">
                                  <?php foreach($city_rows as $k=>$v){ ?>
                                  <option value="<?php echo $v;?>"><?php echo $v;?></option>
                                  <?php } ?>
                                  <option value="其他城市">其他城市</option>
                                  <input class="qtcs hide" name="othercity" id="othercity" type="text" />
                                </select>
                               </div>
                               
                               <div class="fbox"><label>专卖店：</label><input name="shopname" type="text" id="shopname" /></div>
                               <div class="fbox"><label>订单号：</label><input name="ordersn" type="text" id="ordersn" /></div>
                               <div class="fbox"><label>验证码：</label><input name="captcha" type="text" id="captcha" /></div>
                            </div>

						</div>
						<span class="back"><img src="images/back.png"  /></span>
                        <span class="back2" id="submit_btn">确认</span>
					</div>
				</div>
				<!-- end -->
<!-- 主要内容 -->
<div class="swiper-container swiper-pages" id="swiper-container1">
<div class="bgs"><img src="images/bg.jpg"  /></div>
	<div class="swiper-wrapper" id="wrapper">

		<!-- 第一屏 -->
		<div class="swiper-slide page-1">
			<div class="container">
				<div class="am am1">
					<img src="images/a1_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am2">
					<img src="images/a1_2.png" class="animation an2" data-item="an2" data-delay="600" data-animation="fadeIn"  />
				</div>
				<div class="am am3">
					<img src="images/a1_3.png" class="animation an3" data-item="an3" data-delay="1000" data-animation="fadeInRight"  />
				</div>
				<div class="am am4">
					<img src="images/a1_4.png" class="animation an4 button-4" data-item="an4" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/a1_5.png" class="animation an5 button-5" data-item="an5" data-delay="1600" data-animation="fadeInDown"  />
				</div>
                <div class="next">
					<img src="images/next.png" />
				</div>
                

			</div>
		</div>
		<!-- 第二屏 -->
		<div class="swiper-slide page-2">
			<div class="container">
				<div class="am am1">
					<img src="images/a2_1.png" class="animation an1" data-item="an1" data-delay="200" data-animation="fadeInDown"  />
				</div>
				<div class="am am2">
					<img src="images/a2_5.png" class="animation an2" data-item="an2" data-delay="400" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a2_2.png" class="animation an3" data-item="an3" data-delay="600" data-animation="fadeInDown"/>
				</div>
                <div class="am am4">
					<img src="images/a2_5.png" class="animation an4" data-item="an4" data-delay="800" data-animation="fadeInDown"/>
				</div>
				<div class="am am5">
					<img src="images/a2_3.png" class="animation an5" data-item="an5" data-delay="1000" data-animation="fadeInDown"/>
				</div>
                <div class="am am6">
					<img src="images/a2_5.png" class="animation an6" data-item="an6" data-delay="1200" data-animation="fadeInDown"/>
				</div>
                <div class="am am7">
					<img src="images/a2_4.png" class="animation an7" data-item="an7" data-delay="1400" data-animation="fadeInDown"/>
				</div>
                <div class="am am8">
					<img src="images/a1_5.png" class="animation an8 button-5" data-item="an8" data-delay="1600" data-animation="fadeInDown"/>
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
                
			</div>
		</div>
		<!-- 第三屏 -->
		<div class="swiper-slide page-3">
			<div class="container">
				<div class="am am1">

				</div>
				<div class="am am1">
					<img src="images/a3_1.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am2">
					<img src="images/a3_2.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a3_3.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/a3_4.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"/>
				</div>
                <div class="am am5">
					<img src="images/a1_5.png" class="animation an5 button-5" data-item="an5" data-delay="2000" data-animation="fadeInDown"/>
				</div>



				<div class="next">
					<img src="images/next.png" />
				</div>
               
                
              
			</div>
		</div>
		<!-- 第四屏 -->
		<div class="swiper-slide page-4">
			<div class="container">
				<div class="am am1">
					<img src="images/a3_1.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am2">
					<img src="images/a4_1.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a4_2.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/a4_3.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"/>
				</div>
                <div class="am am5">
					<img src="images/a4_4.png" class="animation an5" data-item="an5" data-delay="2200" data-animation="fadeInDown"/>
				</div>
                <div class="am am6">
					<img src="images/a1_5.png" class="animation an6 button-5" data-item="an6" data-delay="2500" data-animation="fadeInDown"/>
				</div>
				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
		<!-- 第五屏 -->
		<div class="swiper-slide page-5">
			<div class="container">
				<div class="am am1">
					<img src="images/a5_1.png" class="animation an1" data-item="an1" data-delay="600" data-animation="fadeInDown"/>
				</div>
				<div class="am am2">
					<img src="images/a5_2.png" class="animation an2" data-item="an2" data-delay="1000" data-animation="fadeInDown"/>
				</div>
				<div class="am am3">
					<img src="images/a5_3.png" class="animation an3" data-item="an3" data-delay="1400" data-animation="fadeInDown"/>
				</div>
				<div class="am am4">
					<img src="images/wx.png" class="animation an4" data-item="an4" data-delay="1800" data-animation="fadeInDown"/>
				</div>
                <div class="am am5">
					<img src="images/a1_5.png" class="animation an5 button-5" data-item="an5" data-delay="2000" data-animation="fadeInDown"/>
				</div>

				<div class="next">
					<img src="images/next.png" />
				</div>
			</div>
		</div>
        
      
		</div>

   </div>
</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
function addOther(v)
{
    if(v == '其他城市')
    {
        $("#othercity").show();
    }
    else
    {
        $("#othercity").hide();
    }
}

/*
$("#city-select").click(function(){
    if($("#city-select").find("option:selected").text() == '其他城市'){
        $("#othercity").show();
    }else{
        $("#othercity").hide();
    }
});
*/

$("#submit_btn").click(function(){
    var na=$("#name").val();
    var phone=$("#phone").val();
    var city=$("#city-select").val();
    var othercity=$("#othercity").val();
    var shopname=$("#shopname").val();
    var ordersn=$("#ordersn").val();
    var captcha=$("#captcha").val();
    console.log(city);
    //请求后台
    $.ajax({
        async:false,
        url: 'server.php',
        data:{act:'add',name:na,phone:phone,city:city,othercity:othercity,shopname:shopname,ordersn:ordersn,captcha:captcha},
        type: "post",
        dataType:'json',
        success:function(result){
            //数据返回后执行
            if(result.errcode != 0){
                alert(result.errmsg);
                return false;
            }else{
                console.log(result.errmsg);
                alert(result.errmsg);
                return false;
            }
            
        }
    });

    
});




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
		imgUrl:'http://zt.jia360.com/nyhs/images/zf.jpg',
		link:'http://zt.jia360.com/nyhs/index.php',
		desc:"注册抽奖-价值4999元健康之旅2日游！",
		title:"南洋胡氏22周年厂庆抽奖"
	};
	wx.onMenuShareAppMessage(wxData);
	wx.onMenuShareTimeline(wxData);
});
</script>
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.8"></script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>