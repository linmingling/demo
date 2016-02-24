<?php
require_once "../data/jssdk.php";
$jssdk = new JSSDK("wxd6ddd7ef03d96e23", "800854664b973d99046e809f82fe8e13");//优居生活服务号
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>6月只听新中源声音-明星助阵 直供沪苏</title>
<meta name="keywords" content="新中源陶瓷" />
<meta name="description" content="新中源陶瓷" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.3"  />


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

                  <div class="swiper-slide page-1">
					  <div class="container">
						  
							<div class="am am1">
								<img src="images/p11.png?v=1.0" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
								<div class="djs">
									<strong id="day_show">0</strong>天
									<strong id="hour_show">0</strong>时
									<strong id="minute_show">0</strong>分
									<strong id="second_show">0</strong>
								</div>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-2">
					  <div class="container">
							<div class="am am1">
								<img src="images/p21.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-3">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p31.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-4">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p41.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-5">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p51.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-6">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p61.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-7">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p71.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-8">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p81.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-9">
					  <div class="container">
							<div class="am am1">
								<img date-src="images/p91.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
					  </div>
                  </div>
                  <div class="swiper-slide page-10">
					  <div class="container">
							<div class="am am2">
								<img src="images/p101.png" class="animation an1" data-item="an1" data-delay="200" data-animation="bounceIn"/>
							</div>
							<a href="http://tao.jia360.com/index.php?g=Wap&m=MarkDown&a=invite&goods_id=852&action_id=20"></a>
					  </div>
                  </div>

           </div>
        </div>
        <div class="cn-slidetips">
	        <div class="slidetips">
	            <a href="javascript:void(0);" title="NEXT" id="next" class="next">
	                <img src="images/next.png" />
	            </a>
	        </div>
	    </div>
<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=1.1"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<!-- 倒计时 -->
<script type="text/javascript"  language="javascript">

setTimeout("count_down()",1000);//设置每一秒调用一次倒计时函数

 

//根据天，时，分，秒的ID找到相对应的元素

var time_day = document.getElementById("day_show");

var time_hour = document.getElementById("hour_show");

var time_minute = document.getElementById("minute_show");

var time_second = document.getElementById("second_show");

var time_end = new Date("2015/06/28 00:00:00");  // 设定活动结束结束时间

time_end = time_end.getTime();

 

//定义倒计时函数

function count_down(){ 

   var time_now = new Date();  // 获取当前时间

   time_now = time_now.getTime();

   var time_distance = time_end - time_now;  // 时间差：活动结束时间减去当前时间   

   var int_day, int_hour, int_minute, int_second;   

 if(time_distance >= 0){   

     // 相减的差数换算成天数   

     int_day = Math.floor(time_distance/86400000)

     time_distance -= int_day * 86400000; 

 

 // 相减的差数换算成小时

        int_hour = Math.floor(time_distance/3600000) 

        time_distance -= int_hour * 3600000;  

 

// 相减的差数换算成分钟   

     int_minute = Math.floor(time_distance/60000)    

    time_distance -= int_minute * 60000; 

 

 // 相减的差数换算成秒数  

      int_second = Math.floor(time_distance/1000)    

 

    // 判断小时小于10时，前面加0进行占位

        if(int_hour < 10) 

        int_hour = "0" + int_hour;  

 

// 判断分钟小于10时，前面加0进行占位      

  if(int_minute < 10)    

   int_minute = "0" + int_minute;  

 

 // 判断秒数小于10时，前面加0进行占位 

       if(int_second < 10) 

       int_second = "0" + int_second;       

 

// 显示倒计时效果       

time_day.innerHTML = int_day;

time_hour.innerHTML = int_hour; 

time_minute.innerHTML = int_minute; 

time_second.innerHTML = int_second;

setTimeout("count_down()",1000);

    }else{

//指定的结束日期结束后，往后推迟3天，或者称之为：往后加3天

//在这里可以非常灵活的设置：比如往后推迟2天或往后加2天：2*24*60*60*1000

//比如往后推迟1天或往后加1天：1*24*60*60*1000

//比如往后推迟2小时或往后加2小时：2*60*60*1000

// 比如往后推迟40分钟或往后加40分钟：40*1000这里设置根据大家需要，灵活设置。

 time_end=time_end+3*24*60*60*1000;

setTimeout("count_down()",1000); 

   }

}

</script>


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
			"imgUrl":'http://zt.jia360.com/xzy/images/share.jpg',
			"link":'http://zt.jia360.com/xzy',
			"desc":"6月只听新中源声音",
			"title":"6月只听新中源声音-明星助阵 直供沪苏"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>
