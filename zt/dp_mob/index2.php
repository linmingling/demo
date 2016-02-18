<?php
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

if(isset($_GET['fromid']) && (int)$_GET['fromid'] == 1){
	mysqli_query($db,"update dp_tj set from_1 = from_1 + 1");
}

$res = mysqli_query($db,"select count(*) as num from dp_yuyue");
$num = $res->fetch_array();

if(isset($_GET['source']) && (int)$_GET['source'] > 0){
	setcookie('source', $_GET['source'], 0);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>东鹏洁具 7月全民卫浴冰爽月</title>
<meta name="keywords" content="东鹏洁具 7月全民卫浴冰爽月" />
<meta name="description" content="东鹏洁具 7月全民卫浴冰爽月" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css"  />



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
					<div class="am am1 all">
						
						<img src="images/p1_3.png" class="animation an1 goto" goto="1" />
						<img src="images/p1_4.png" class="animation an1 goto" goto="3" />
						<img src="images/p1_2.png" class="animation an1 goto" goto="9" data-item="an1" data-delay="200" data-animation="bounceIn"/>
						<img src="images/p1_5.png" class="animation an1 goto" goto="13" />
					</div>
					
			  </div>
		  </div>

		  <div class="swiper-slide page-2 ps2">
			  <div class="container">
					<div class="am am1">
						<img src="images/p2_1.png" />
						<img src="images/p2_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
					</div>
					
			  </div>                
		  </div>

		  <div class="swiper-slide page-3 ps3">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p2_1.png" />
						<img date-src="images/p3_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
					</div>
				
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-4 ps4">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p4_1.png" />
						<img date-src="images/p4_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
					</div>
					
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-5 ps5">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p4_1.png" />
						
					</div>
					<div class="am am2">
						<img date-src="images/p5_3.jpg" class="animation an1 goto" goto="6"/>
						<img date-src="images/p5_2.jpg" class="animation an1 goto" goto="5" data-item="an1" data-delay="200" data-animation="bounceIn"/>
						<img date-src="images/p5_5.jpg" class="animation an1 goto" goto="7"/>
						<img date-src="images/p5_4.jpg" class="animation an1 goto" goto="8"/>
						
					</div>
				
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-6 productBox ps6">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p6_1.png" />
					</div>
					<div class="am am2">
						<img date-src="images/p6_2.jpg" />
						<div class="icon icon1"></div>
						<div class="icon icon2"></div>
						<div class="icon icon3"></div>
						<div class="icon icon4"></div>
					</div>
					<div class="am product product1 hide">
						<img date-src="images/p6_3.png" />
					</div>
					<div class="am product product2 hide">
						<img date-src="images/p6_4.png" />
					</div>
					<div class="am product product3 hide">
						<img date-src="images/p6_5.png" />
					</div>
					<div class="am product product4 hide">
						<img date-src="images/p6_6.png" />
					</div>
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-7 productBox ps7">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p7_1.png" />
					</div>
					<div class="am am2">
						<img date-src="images/p7_2.jpg" />
						<div class="icon icon1"></div>
						<div class="icon icon2"></div>
						<div class="icon icon3"></div>
						<div class="icon icon4"></div>
						<div class="icon icon5"></div>
					</div>
					<div class="am product product1 hide">
						<img date-src="images/p7_3.png" />
					</div>
					<div class="am product product2 hide">
						<img date-src="images/p7_4.png" />
					</div>
					<div class="am product product3 hide">
						<img date-src="images/p7_5.png" />
					</div>
					<div class="am product product4 hide">
						<img date-src="images/p7_6.png" />
					</div>
					<div class="am product product5 hide">
						<img date-src="images/p7_7.png" />
					</div>
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-8 productBox ps8">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p8_1.png" />
					</div>
					<div class="am am2">
						<img date-src="images/p8_2.jpg" />
						<div class="icon icon1"></div>
						<div class="icon icon2"></div>
						<div class="icon icon3"></div>
						<div class="icon icon4"></div>
						<div class="icon icon5"></div>
						<div class="icon icon6"></div>
					</div>
					<div class="am product product1 hide">
						<img date-src="images/p8_3.png" />
					</div>
					<div class="am product product2 hide">
						<img date-src="images/p8_4.png" />
					</div>
					<div class="am product product3 hide">
						<img date-src="images/p8_5.png" />
					</div>
					<div class="am product product4 hide">
						<img date-src="images/p8_6.png" />
					</div>
					<div class="am product product5 hide">
						<img date-src="images/p8_7.png" />
					</div>
					<div class="am product product6 hide">
						<img date-src="images/p8_8.png" />
					</div>
					

			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-9 productBox ps9">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p9_1.png" />
					</div>
					<div class="am am2">
						<img date-src="images/p9_2.jpg" />
						<div class="icon icon1"></div>
						<div class="icon icon2"></div>
						<div class="icon icon3"></div>
						<div class="icon icon4"></div>
						<div class="icon icon5"></div>
					</div>
					<div class="am product product1 hide">
						<img date-src="images/p9_3.png" />
					</div>
					<div class="am product product2 hide">
						<img date-src="images/p9_4.png" />
					</div>
					<div class="am product product3 hide">
						<img date-src="images/p9_5.png" />
					</div>
					<div class="am product product4 hide">
						<img date-src="images/p9_6.png" />
					</div>
					<div class="am product product5 hide">
						<img date-src="images/p9_7.png" />
					</div>
				
			  </div>                
		  </div>
		  
		  <div class="swiper-slide page-10 ps10">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p10_1.png" />
						<a href="http://tao.jia360.com/index.php?g=Wap&m=MarkDown&a=index&action_id=23 ">
							<img date-src="images/p10_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
						</a>
					</div>
			
				
				</div>
		  </div>
		  
		  <div class="swiper-slide page-11 ps11">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p10_1.png" />
						<a href="http://tao.jia360.com/index.php?g=Wap&m=MarkDown&a=index&action_id=23 ">
							<img date-src="images/p11_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
						</a>
					</div>
				
				
				</div>
		  </div>
		  <div class="swiper-slide page-12 ps12">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p10_1.png" />
						<a href="http://tao.jia360.com/index.php?g=Wap&m=MarkDown&a=index&action_id=23 ">
							<img date-src="images/p12_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
						</a>
					</div>
				
				
				</div>
		  </div>
		  <div class="swiper-slide page-13 ps13">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p13_1.png" />
						<img date-src="images/p13_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="bounceIn"/>
					</div>
					<div class="am btnBox">
						<img src="images/bottom2.png"/>
						<div class="yuyue"></div>
						<div class="shengou"></div>
					</div>
				
				</div>
		  </div>
		  <div class="swiper-slide page-14 ps14">
			  <div class="container">
					<div class="am am1">
						<img date-src="images/p14_1.png" />
					</div>
					<div class="am am2">
						<img date-src="images/p14_2.png" class="animation an2" data-item="an2" data-delay="200" data-animation="fadeInUp"/>
					</div>
					
				
				</div>
		  </div>
		  
		  
   </div>
</div>
<!-- 底部按钮 -->
<div class="am btnBox">
	<img src="images/bottom2.png"/>
	<div class="yuyue"></div>
	<div class="shengou"></div>
</div>
<!--预约-->
<div class="yuyueBox formBox hide" id="yuyueBox">
	<div class="formWarp">
		<span class="close">×</span>
		<div class="yellowHead cf">
			<p class="big">限定2000个名额</p>
			<p>已有<?php echo $num['num']; ?>人报名，剩余<?php echo 2000-$num['num']; ?>个名额</p>
		</div>
		<div class="form cf">
			<div class="nameBox inputBox">姓名：<input type="text" class="name" /></div>
			<div class="telBox inputBox">联系方式：<input type="text" class="tel" /></div>
			<!-- <div class="shengBox inputBox">省：<input type="text" class="sheng" /></div>
			<div class="shiBox inputBox">市：<input type="text" class="shi" /></div> -->
			<div class="cf">
				<div class="shengBox inputBox">省：
					<select id="province">
					  	<option>省份</option> 
						<option>广东</option>
						<option>海南</option>
						<option>湖南</option>
						<option>江西</option>
						<option>福建</option>
						<option>河南</option>
						<option>广西</option>
						<option>云南</option>
						<option>贵州</option>
						<option>四川</option>
						<option>江苏</option>
						<option>安徽</option>
						<option>北京</option>
						<option>山东</option>
						<option>黑龙江</option>
						<option>吉林</option>
						<option>内蒙古</option>
						<option>宁夏</option>
						<option>辽宁</option>
						<option>天津</option>
						<option>山西</option>
						<option>河北</option>
						<option>陕西</option>
						<option>甘肃</option>
						<option>青海</option>
						<option>西藏</option>
						<option>新疆</option>
						<option>湖北</option>
						<option>重庆</option>
						<option>上海</option>
						<option>浙江</option>
						
					</select>
				</div>
				<div class="shiBox inputBox">市：
					<select class="city"> 
	   						<option>城市</option> 
	   					</select> 
					   <select class="city"> 
					       <option>广州</option> 
					       <option>深圳</option> 
					       <option>中山</option> 
					       <option>珠海</option> 
					       <option>东莞</option> 
					       <option>汕头</option> 
					       <option>陆丰</option> 
					       <option>河源</option> 
					       <option>梅州</option> 
					       <option>揭阳</option> 
					       <option>惠州</option> 
					       <option>韶关</option> 
					       <option>清远</option> 
					       <option>肇庆</option> 
					       <option>湛江</option> 
					       <option>江门</option> 
					       <option>阳江</option> 
					       <option>茂名</option> 
					       <option>佛山</option> 
					   </select> 

						<select class="city">
							<option>海口</option>
							<option>三亚</option>
						</select> 

					   <select class="city"> 
					       <option>常德</option> 
					       <option>衡阳</option> 
					       <option>长沙</option> 
					       <option>岳阳</option> 
					       <option>邵阳</option> 
					       <option>株洲</option> 
					       <option>娄底</option> 
					       <option>湘潭</option> 
					       <option>张家界</option> 
					       <option>永州</option> 
					       <option>益阳</option> 
					       <option>郴州</option> 
					   </select> 

					   <select class="city"> 
					       <option>九江</option> 
					       <option>吉安</option> 
					       <option>抚州</option> 
					       <option>南昌</option> 
					       <option>新余</option> 
					       <option>宜春</option> 
					       <option>萍乡</option> 
					       <option>丰城</option> 
					       <option>景德镇</option> 
					       <option>鄱阳县</option> 
					       <option>上饶</option> 
					       <option>赣州</option> 
					       <option>赣南</option> 
					   </select> 
					   <select class="city"> 
					       <option>龙岩</option> 
					       <option>莆田</option> 
					       <option>宁德</option> 
					       <option>福州</option> 
					       <option>泉州</option> 
					   </select> 
					   <select class="city"> 
					       <option>信阳</option> 
					       <option>卫辉市</option> 
					       <option>三门峡</option> 
					       <option>鹤壁</option> 
					       <option>济源</option> 
					       <option>平顶山</option> 
					       <option>开封</option> 
					       <option>郑州</option> 
					       <option>周口</option> 
					       <option>南阳</option> 
					       <option>安阳</option> 
					       <option>兰考县</option> 
					       <option>邓州</option>
	   				       <option>濮阳</option> 
					   </select> 
					   <select class="city"> 
					       <option>玉林</option> 
					       <option>钦州</option> 
					       <option>北海</option> 
					       <option>百色</option> 
					       <option>柳州</option> 
					       <option>南宁</option> 
					       <option>来宾</option> 
					       <option>梧州</option> 
					       <option>桂林</option> 
					       <option>贵港</option> 
					       <option>贺州</option> 
					   </select> 
					   <select class="city"> 
					       <option>昆明</option> 
					       <option>蒙自</option> 
					   </select> 
					   <select class="city"> 
					       <option>黔西南州</option> 
					       <option>仁怀</option> 
					       <option>贵阳</option> 
					       <option>安顺</option> 
					       <option>黔东南州</option> 
					       <option>贵州</option>  
					   </select>
					   <select class="city"> 
					       <option>攀枝花</option> 
					       <option>遂宁</option> 
					       <option>德阳</option> 
					       <option>达州</option> 
					       <option>崇州</option> 
					       <option>成都</option> 
					       <option>内江</option> 
					       <option>广安</option> 
					       <option>峨眉山</option> 
					       <option>眉山</option> 
					       <option>泸州</option> 
					       <option>绵阳</option> 
					       <option>自贡</option>
	   				       <option>都江堰市</option> 
					       <option>南充</option> 
					   </select> 
					   <select class="city"> 
					       <option>宜兴</option> 
					       <option>苏州</option> 
					       <option>无锡</option> 
					       <option>扬州</option> 
					       <option>连云港</option> 
					       <option>义乌</option> 
					       <option>秦州</option> 
					       <option>徐州</option> 
					       <option>淮安</option> 
					       <option>张家港</option> 
					       <option>盐城</option> 
					       <option>常州</option>
	   				       <option>南通</option> 
					       <option>宿迁</option> 
					       <option>南京</option>
					       <option>江阴</option>
					   </select> 
					   <select class="city"> 
					       <option>蚌埠</option> 
					       <option>安庆</option> 
					       <option>阜阳</option> 
					       <option>亳州</option> 
					       <option>芜湖</option> 
					       <option>六安</option> 
					       <option>淮南</option> 
					       <option>滁州</option> 
					       <option>合肥</option> 
					       <option>宿州市</option> 
					   </select> 
					   <select class="city"> 
	                       <option>朝阳区</option>
					       <option>东城区</option> 
					       <option>西城区</option> 
					       <option>海淀区</option> 
					       <option>丰台区</option> 
					       <option>石景山区</option> 
					       <option>门头沟区</option> 
					       <option>房山区</option> 
					       <option>大兴区</option>
					       <option>通州区</option>
					       <option>顺义区</option>
					       <option>昌平区</option>
						   <option>平谷区</option>
					       <option>怀柔区</option>
					       <option>密云县</option>
						   <option>延庆县</option>
					   </select> 
					   <select class="city"> 
					       <option>青岛</option> 
					       <option>潍坊</option> 
					       <option>威海</option> 
					       <option>临沂</option> 
					       <option>枣庄</option> 
					       <option>莱阳市</option> 
					       <option>济宁</option> 
					       <option>泰安</option> 
					       <option>淄博</option> 
					       <option>滨州</option> 
					       <option>聊城</option> 
					       <option>济南</option>
					       <option>德州</option>
					   </select> 
					   <select class="city"> 
					       <option>大庆</option> 
					       <option>哈尔滨</option> 
					   </select> 
					   <select class="city"> 
					       <option>长春</option> 
					       <option>吉林</option> 
					       <option>松原</option> 
					       <option>四平</option> 
					   </select> 
					   <select class="city"> 
					       <option>呼伦贝尔</option> 
					       <option>满洲里</option> 
					       <option>赤峰</option> 
					       <option>包头</option> 
					       <option>乌兰察布</option> 
					       <option>呼和浩特</option> 
					       <option>乌海</option> 
					   </select> 
					   <select class="city"> 
					       <option>银川</option> 
					       <option>固原</option> 
					   </select> 
					   <select class="city"> 
					       <option>沈阳</option> 
					       <option>大连</option> 
					       <option>盘锦</option> 
					       <option>锦州</option> 
					       <option>鞍山</option> 
					       <option>葫芦岛</option> 
					       <option>阜新</option> 
					       <option>铁岭</option> 
					   </select> 
					   <select class="city"> 
					       <option>河西区</option> 
					   </select> 
					   <select class="city"> 
					       <option>运城</option> 
					       <option>长治</option> 
					       <option>临汾</option> 
					       <option>吕梁</option> 
					       <option>忻州</option> 
					       <option>阳泉</option> 
					       <option>大同</option> 
					   </select> 
					   <select class="city"> 
					       <option>石家庄</option> 
					       <option>唐山</option> 
					       <option>秦皇岛</option> 
					       <option>保定</option> 
					       <option>承德</option> 
					       <option>沧州</option> 
					       <option>衡水</option> 
					       <option>邯郸</option> 
					       <option>任丘市</option> 
					       <option>霸州市</option> 
					      
					   </select>
					   <select class="city"> 
					       <option>榆林</option> 
					       <option>西安</option> 
					   </select>
					   <select class="city"> 
					       <option>天水</option> 
					       <option>定西</option> 
					       <option>兰州</option> 
					       <option>酒泉</option> 
					       <option>金昌</option>
					       <option>平凉</option> 
					       <option>庆阳</option> 
					       <option>张掖</option> 
					   </select>
					   <select class="city"> 
					       <option>西宁</option> 
					   </select>
					   <select class="city"> 
					       <option>拉萨</option> 
					   </select>
					   <select class="city"> 
					       <option>克拉玛依</option> 
					       <option>伊宁市</option> 
					       <option>乌鲁木齐</option> 
					       <option>库尔勒市</option> 
					       <option>哈密</option> 
					       <option>喀什</option> 
					   </select>
					   <select class="city"> 
					       <option>襄阳</option> 
					       <option>随州</option> 
					       <option>十堰</option> 
					       <option>荆门</option> 
					       <option>仙桃</option> 
					       <option>孝感</option> 
					       <option>天门</option> 
					       <option>武汉</option> 
					       <option>黄石</option> 
					       <option>黄冈</option> 
					       <option>咸宁</option> 
					       <option>宜昌</option>
					       <option>恩施</option>
					       <option>荆州</option>
					   </select>
					   <select class="city"> 
					       <option>酉阳县</option> 
					       <option>石柱县</option> 
					       <option>梁平县</option> 
					       <option>丰都县</option> 
					       <option>永川区</option> 
					       <option>九龙坡区</option> 
					       <option>璧山区</option> 
					       <option>南川区</option> 
					       <option>大足区</option> 
					   </select>
					   <select class="city">
					       <option>浦东新区</option>
					    </select> 
					    <select class="city">
					       <option>温州市</option>
					       <option>衢州市</option>
					       <option>金华市</option>
					       <option>杭州市</option>
					       <option>嘉兴市</option>
					       <option>湖州市</option>
					       <option>宁波市</option>
					    </select> 
				</div>
			</div>
			<div class="addressBox inputBox">地址：<input type="text" class="address" /></div>
			<div class="yuyueBtn btn">预约浴室升级</div>
			<!-- <p class="qq">客服 qq：<br/>
				<span>2577087101</span>
				<span>3165485497</span>
			</p> -->
			
		</div>
	</div>
	<div class="tips">
		1、报名成功后会有专人在24小时内电话联系您，请注意陌生来电。 <br />2、我们会严格的保护您的隐私，不用于其他用途。 
	</div>
</div>

<!--申购-->
<div class="shengouBox formBox hide" id="shengouBox">
	<div class="formWarp">
		<span class="close">×</span>
		<div class="yellowHead cf">
			<div class="select">
				<input type="checkbox" id="cb1" value="奥斯卡马桶" name="product" class="checkbox" />
				<label for="cb1">奥斯卡马桶</label>
			</div>
			<div class="select">
				<input type="checkbox" id="cb2" value="奥拉大花洒" name="product" class="checkbox" />
				<label for="cb2">奥拉大花洒</label>
			</div>
			<div class="select">
				<input type="checkbox" id="cb3" value="阿凡提浴室柜套装" name="product" class="checkbox" />
				<label for="cb3">阿凡提浴室柜套装</label>
			</div>
			<div class="select">
				<input type="checkbox" id="cb4" value="卫洗宝智能马桶" name="product" class="checkbox" />
				<label for="cb4">卫洗宝智能马桶</label>
			</div>
		</div>
		<div class="form cf">
			<div class="nameBox inputBox">姓名：<input type="text" class="name" /></div>
			<div class="telBox inputBox">联系方式：<input type="text" class="tel" /></div>
			<div class="cf">
				<div class="shengBox inputBox">省：
					<select id="province1">
					  	<option>省份</option> 
						<option>广东</option>
						<option>海南</option>
						<option>湖南</option>
						<option>江西</option>
						<option>福建</option>
						<option>河南</option>
						<option>广西</option>
						<option>云南</option>
						<option>贵州</option>
						<option>四川</option>
						<option>江苏</option>
						<option>安徽</option>
						<option>北京</option>
						<option>山东</option>
						<option>黑龙江</option>
						<option>吉林</option>
						<option>内蒙古</option>
						<option>宁夏</option>
						<option>辽宁</option>
						<option>天津</option>
						<option>山西</option>
						<option>河北</option>
						<option>陕西</option>
						<option>甘肃</option>
						<option>青海</option>
						<option>西藏</option>
						<option>新疆</option>
						<option>湖北</option>
						<option>重庆</option>
						<option>上海</option>
						<option>浙江</option>
						
					</select>
				</div>
				<div class="shiBox inputBox">市：
					<select class="city1"> 
	   						<option>城市</option> 
	   					</select> 
					   <select class="city1"> 
					       <option>广州</option> 
					       <option>深圳</option> 
					       <option>中山</option> 
					       <option>珠海</option> 
					       <option>东莞</option> 
					       <option>汕头</option> 
					       <option>陆丰</option> 
					       <option>河源</option> 
					       <option>梅州</option> 
					       <option>揭阳</option> 
					       <option>惠州</option> 
					       <option>韶关</option> 
					       <option>清远</option> 
					       <option>肇庆</option> 
					       <option>湛江</option> 
					       <option>江门</option> 
					       <option>阳江</option> 
					       <option>茂名</option> 
					       <option>佛山</option> 
					   </select> 

						<select class="city1">
							<option>海口</option>
							<option>三亚</option>
						</select> 

					   <select class="city1"> 
					       <option>常德</option> 
					       <option>衡阳</option> 
					       <option>长沙</option> 
					       <option>岳阳</option> 
					       <option>邵阳</option> 
					       <option>株洲</option> 
					       <option>娄底</option> 
					       <option>湘潭</option> 
					       <option>张家界</option> 
					       <option>永州</option> 
					       <option>益阳</option> 
					       <option>郴州</option> 
					   </select> 

					   <select class="city1"> 
					       <option>九江</option> 
					       <option>吉安</option> 
					       <option>抚州</option> 
					       <option>南昌</option> 
					       <option>新余</option> 
					       <option>宜春</option> 
					       <option>萍乡</option> 
					       <option>丰城</option> 
					       <option>景德镇</option> 
					       <option>鄱阳县</option> 
					       <option>上饶</option> 
					       <option>赣州</option> 
					       <option>赣南</option> 
					   </select> 
					   <select class="city1"> 
					       <option>龙岩</option> 
					       <option>莆田</option> 
					       <option>宁德</option> 
					       <option>福州</option> 
					       <option>泉州</option> 
					   </select> 
					   <select class="city1"> 
					       <option>信阳</option> 
					       <option>卫辉市</option> 
					       <option>三门峡</option> 
					       <option>鹤壁</option> 
					       <option>济源</option> 
					       <option>平顶山</option> 
					       <option>开封</option> 
					       <option>郑州</option> 
					       <option>周口</option> 
					       <option>南阳</option> 
					       <option>安阳</option> 
					       <option>兰考县</option> 
					       <option>邓州</option>
	   				       <option>濮阳</option> 
					   </select> 
					   <select class="city1"> 
					       <option>玉林</option> 
					       <option>钦州</option> 
					       <option>北海</option> 
					       <option>百色</option> 
					       <option>柳州</option> 
					       <option>南宁</option> 
					       <option>来宾</option> 
					       <option>梧州</option> 
					       <option>桂林</option> 
					       <option>贵港</option> 
					       <option>贺州</option> 
					   </select> 
					   <select class="city1"> 
					       <option>昆明</option> 
					       <option>蒙自</option> 
					   </select> 
					   <select class="city1"> 
					       <option>黔西南州</option> 
					       <option>仁怀</option> 
					       <option>贵阳</option> 
					       <option>安顺</option> 
					       <option>黔东南州</option> 
					       <option>贵州</option>  
					   </select>
					   <select class="city1"> 
					       <option>攀枝花</option> 
					       <option>遂宁</option> 
					       <option>德阳</option> 
					       <option>达州</option> 
					       <option>崇州</option> 
					       <option>成都</option> 
					       <option>内江</option> 
					       <option>广安</option> 
					       <option>峨眉山</option> 
					       <option>眉山</option> 
					       <option>泸州</option> 
					       <option>绵阳</option> 
					       <option>自贡</option>
	   				       <option>都江堰市</option> 
					       <option>南充</option> 
					   </select> 
					   <select class="city1"> 
					       <option>宜兴</option> 
					       <option>苏州</option> 
					       <option>无锡</option> 
					       <option>扬州</option> 
					       <option>连云港</option> 
					       <option>义乌</option> 
					       <option>秦州</option> 
					       <option>徐州</option> 
					       <option>淮安</option> 
					       <option>张家港</option> 
					       <option>盐城</option> 
					       <option>常州</option>
	   				       <option>南通</option> 
					       <option>宿迁</option> 
					       <option>南京</option>
					       <option>江阴</option>
					   </select> 
					   <select class="city1"> 
					       <option>蚌埠</option> 
					       <option>安庆</option> 
					       <option>阜阳</option> 
					       <option>亳州</option> 
					       <option>芜湖</option> 
					       <option>六安</option> 
					       <option>淮南</option> 
					       <option>滁州</option> 
					       <option>合肥</option> 
					       <option>宿州市</option> 
					   </select> 
					   <select class="city1"> 
					       <option>东城区</option> 
					       <option>西城区</option> 
					       <option>海淀区</option> 
					       <option>丰台区</option> 
					       <option>石景山区</option> 
					       <option>门头沟区</option> 
					       <option>房山区</option> 
					       <option>大兴区</option>
					       <option>通州区</option>
					       <option>顺义区</option>
					       <option>昌平区</option>
						   <option>平谷区</option>
					       <option>怀柔区</option>
					       <option>密云县</option>
						   <option>延庆县</option>
					   </select> 
					   <select class="city1"> 
					       <option>青岛</option> 
					       <option>潍坊</option> 
					       <option>威海</option> 
					       <option>临沂</option> 
					       <option>枣庄</option> 
					       <option>莱阳市</option> 
					       <option>济宁</option> 
					       <option>泰安</option> 
					       <option>淄博</option> 
					       <option>滨州</option> 
					       <option>聊城</option> 
					       <option>济南</option>
					       <option>德州</option>
					   </select> 
					   <select class="city1"> 
					       <option>大庆</option> 
					       <option>哈尔滨</option> 
					   </select> 
					   <select class="city1"> 
					       <option>长春</option> 
					       <option>吉林</option> 
					       <option>松原</option> 
					       <option>四平</option> 
					   </select> 
					   <select class="city1"> 
					       <option>呼伦贝尔</option> 
					       <option>满洲里</option> 
					       <option>赤峰</option> 
					       <option>包头</option> 
					       <option>乌兰察布</option> 
					       <option>呼和浩特</option> 
					       <option>乌海</option> 
					   </select> 
					   <select class="city1"> 
					       <option>银川</option> 
					       <option>固原</option> 
					   </select> 
					   <select class="city1"> 
					       <option>沈阳</option> 
					       <option>大连</option> 
					       <option>盘锦</option> 
					       <option>锦州</option> 
					       <option>鞍山</option> 
					       <option>葫芦岛</option> 
					       <option>阜新</option> 
					       <option>铁岭</option> 
					   </select> 
					   <select class="city1"> 
					       <option>河西区</option> 
					   </select> 
					   <select class="city1"> 
					       <option>运城</option> 
					       <option>长治</option> 
					       <option>临汾</option> 
					       <option>吕梁</option> 
					       <option>忻州</option> 
					       <option>阳泉</option> 
					       <option>大同</option> 
					   </select> 
					   <select class="city1"> 
					       <option>石家庄</option> 
					       <option>唐山</option> 
					       <option>秦皇岛</option> 
					       <option>保定</option> 
					       <option>承德</option> 
					       <option>沧州</option> 
					       <option>衡水</option> 
					       <option>邯郸</option> 
					       <option>任丘市</option> 
					       <option>霸州市</option> 
					      
					   </select>
					   <select class="city1"> 
					       <option>榆林</option> 
					       <option>西安</option> 
					   </select>
					   <select class="city1"> 
					       <option>天水</option> 
					       <option>定西</option> 
					       <option>兰州</option> 
					       <option>酒泉</option> 
					       <option>金昌</option> 
					       <option>平凉</option> 
					       <option>庆阳</option> 
					       <option>张掖</option> 
					   </select>
					   <select class="city1"> 
					       <option>西宁</option> 
					   </select>
					   <select class="city1"> 
					       <option>拉萨</option> 
					   </select>
					   <select class="city1"> 
					       <option>克拉玛依</option> 
					       <option>伊宁市</option> 
					       <option>乌鲁木齐</option> 
					       <option>库尔勒市</option> 
					       <option>哈密</option> 
					       <option>喀什</option> 
					   </select>
					   <select class="city1"> 
					       <option>襄阳</option> 
					       <option>随州</option> 
					       <option>十堰</option> 
					       <option>荆门</option> 
					       <option>仙桃</option> 
					       <option>孝感</option> 
					       <option>天门</option> 
					       <option>武汉</option> 
					       <option>黄石</option> 
					       <option>黄冈</option> 
					       <option>咸宁</option> 
					       <option>宜昌</option>
					       <option>恩施</option>
					       <option>荆州</option>
					   </select>
					   <select class="city1"> 
					       <option>酉阳县</option> 
					       <option>石柱县</option> 
					       <option>梁平县</option> 
					       <option>丰都县</option> 
					       <option>永川区</option> 
					       <option>九龙坡区</option> 
					       <option>璧山区</option> 
					       <option>南川区</option> 
					       <option>大足区</option> 
					   </select>
					   <select class="city1">
					       <option>浦东新区</option>
					    </select> 
					    <select class="city1">
					       <option>温州市</option>
					       <option>衢州市</option>
					       <option>金华市</option>
					       <option>杭州市</option>
					       <option>嘉兴市</option>
					       <option>湖州市</option>
					       <option>宁波市</option>
					    </select> 
				</div>
			</div>
			<div class="addressBox inputBox">地址：<input type="text" class="address" /></div>
			<div class="shengouBtn btn">立即申购</div>
			<p class="qq">客服 qq：<br/>
				<span>2577087101</span>
				<span>3165485497</span>
			</p>
		</div>
	</div>
</div>

<script src="js/zepto.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="js/my.js?v=3.1"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>

<script>
	var currentShowCity=0;
	var currentShowCity2=0;
	$(function(){
		$("#province").change(function(){
		   $("#province option").each(function(i,o){
			   if($(this).attr("selected"))
			   {		 
				   $(".city").hide();
				   $(".city").eq(i).show();
				   currentShowCity=i;
			   }
		   });
	   });
		$("#province").change();

		$("#province1").change(function(){
		   $("#province1 option").each(function(i,o){
			   if($(this).attr("selected"))
			   {		 
				   $(".city1").hide();
				   $(".city1").eq(i).show();
				   currentShowCity2=i;
			   }
		   });
	   });
		$("#province1").change();
		
	})
	
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
			"imgUrl":'http://zt.jia360.com/dp_mob/images/share.jpg',
			"link":'http://zt.jia360.com/dp_mob/index2.php',
			"desc":"冰临盛夏，快乐暑假——东鹏洁具2015全民冰爽月",
			"title":"东鹏洁具 7月全民卫浴冰爽月"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
<!--#include virtual="/public/tongji.html"-->

</body>
</html>