<?php
//error_reporting(0);
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

function sendSms($phone, $content){
	header("Content-Type: text/html; charset=UTF-8");
	$flag = 0;
	$params=''; //要post的数据
	//以下信息自己填以下
	$argv = array(
		'name' => '3086533498@qq.com',//必填参数。用户账号
		'pwd' => '966E0BD8F94BCED72E1052474E7C',//必填参数。（web平台：基本资料中的接口密码）
		'content' => $content,//必填参数。发送内容（1-500 个汉字）UTF-8编码
		'mobile' => $phone,//必填参数。手机号码。多个以英文逗号隔开
		'stime' => '',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
		'sign' => '',    //必填参数。用户签名。
		'type' => 'pt',  //必填参数。固定值 pt
		'extno' => ''    //可选参数，扩展码，用户定义扩展码，只能为数字
	);
	//print_r($argv);exit;
	//构造要post的字符串
	//echo $argv['content'];
	foreach ($argv as $key => $value) {
		if ($flag!=0) {
			$params .= "&";
			$flag = 1;
		}
		$params.= $key."="; $params.= urlencode($value);// urlencode($value);
		$flag = 1;
	}
	$url = "http://web.1xinxi.cn/asmx/smsservice.aspx?".$params; //提交的url地址
	$con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
	if($con == '0'){
	   return 0;//发送成功
	} else {
	   return 1;//发送失败
	}
}

if(isset($_GET['type']) && $_GET['type'] == 'yuyue' && $_POST){
	header('Content-type:application/json;charset=utf-8;');
	$from = isset($_GET['from']) ? (int)$_GET['from'] : 0;
	$res = mysqli_query($db,"select count(*) as num from dp_yuyue");
	$tmp = $res->fetch_array();
	if($tmp['num'] > 2000){
		die(json_encode(array('state'=>0,'msg'=>'faile')));
	}
	$source = $_GET['source']; 
	$res = mysqli_query($db,"insert into dp_yuyue(`username`,`phone`,`province`,`city`,`address`,`time`,`from`,`source`) values('".$_POST['username']."','".$_POST['phone']."','".$_POST['province']."','".$_POST['city']."','".$_POST['address']."','".time()."','".$from."','".$source."')");
	if($res){
		//sendSms($_POST['phone'],"尊敬的".$_POST['username']."，恭喜您预约报名成功，我们会在24小时内联系您。除了免费量尺、提供设计方案外，我们还提供抵用券、东鹏礼包。请保持手机畅通，请留意我们的客服电话 - 东鹏洁具。");
		die(json_encode(array('state'=>1,'msg'=>'success')));
	}
	die(json_encode(array('state'=>0,'msg'=>'faile')));
}

if(isset($_GET['type']) && $_GET['type'] == 'shenggou' && $_POST){
	header('Content-type:application/json;charset=utf-8;');
	$from = isset($_GET['from']) ? (int)$_GET['from'] : 0;
	$code = substr((string)time(),2);
	$res = mysqli_query($db,"insert into dp_shengou(`goodsname`,`username`,`province`,`city`,`address`,`phone`,`time`,`from`,`code`) values('".$_POST['goodsname']."','".$_POST['username']."','".$_POST['province']."','".$_POST['city']."','".$_POST['address']."','".$_POST['phone']."','".time()."','".$from."','".$code."')");
	if($res){
		//sendSms($_POST['phone'],"尊敬的".$_POST['username']."，恭喜您预约成功，您的申购码为".$code.",请凭借申购码去线下购买，亲，线下付款购买后，我们可以包邮哦 - 东鹏洁具");
		die(json_encode(array('state'=>1,'msg'=>$code)));
	}
	die(json_encode(array('state'=>0,'msg'=>'faile')));
}

if(isset($_GET['type']) && $_GET['type'] == 'sendmsg' && $_POST){
	sendSms($_POST['phone'],$_POST['content']); exit();
}

if(isset($_GET['fromid']) && (int)$_GET['fromid'] == 1){
	mysqli_query($db,"update dp_tj set from_1 = from_1 + 1");
}

if(isset($_GET['fromid']) && (int)$_GET['fromid'] == 2){
	mysqli_query($db,"update dp_tj set from_2 = from_2 + 1");
}

$res = mysqli_query($db,"select count(*) as num from dp_yuyue");
$num = $res->fetch_array();


$res = mysqli_query($db,"select * from dp_yuyue");
while($res && $row = $res->fetch_array()){
	$list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>东鹏洁具 7月全民卫浴冰爽月</title>
	<link rel="stylesheet"  href="css/main.css">
	<link rel="stylesheet"  href="css/animate.css">
	<link rel="stylesheet" href="css/swiper.min.css">
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery.tabs.js"></script>
</head>
<body>
	<div class="bg1">
		<div class="inside">
			<div class="nav"></div>
			<div id="icon"><img src="images/icon.png" height="554" width="673" alt=""></div>
			<div id="sun"><img src="images/sun.png" height="258" width="304" alt=""></div>
			<div class="icon2"><img src="images/icon2.png" height="155" width="279" alt=""></div>
			<!-- <div class="icon2-1"><img src="images/icon2.png" height="155" width="279" alt=""></div> -->
			<div class="menu">
				<ul>
					<li><a href="javascript:void(0)" id="hx"></a></li>
					<li><a href="javascript:void(0)" id="sg"></a></li>
					<li><a href="javascript:void(0)" id="bk"></a></li>
					<li><a href="http://wpa.qq.com/msgrd?V=3&amp;uin=2577087101&amp;Site=613在线咨询&amp;Menu=yes" target="blank"></a></li>
					<li><a href="javascript:void(0)" id="goToTop"></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="bg2"><!-- <a href="#" name="hx" style="display:block;height:121px;"></a> --></div>
	<div class="bg3">
		<div class="inside">
           <!-- 报名-->
            <div id="sign">
                <div class="sign">
                    <p class="ct">
                        姓名:<input id="name" type="text" name="name" value="" />
                    </p>
                    <p class="ct">
                        手机:<input id="phone" type="text" name="phone" value="" />
                    </p>
                    <p class="ct">省份:&nbsp&nbsp          
                    <select id="province">
					  <option>----请选择省份----</option> 
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
				
				   <select class="city"> 
				<option>----请选择城市----</option> 
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
				       <option>义务</option> 
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
				    
                    </p>
                    <p class="ct">
                        地址:<input id="address" type="text" name="address" value="" />
                    </p>

                    <p class="sub"></p>


                    <p class="sign-data">
                    	<span class="snum"><?php echo $num['num']; ?></span>
                    	<span class="lnum"><?php echo 2000-$num['num']; ?></span>
                    </p>

                   <marquee direction="up"  scrolldelay="300" class="tab-content">
				<?php
					if($list){
						foreach($list as $k){
							echo "<p class='link'>".$k['city']."&nbsp;".$k['username'].date('n',$k['time'])."月".date('j',$k['time'])."日已申请上门量尺</p>";
						}
					}
				?>
                    </marquee>
                    

<!--                     <p class="sign-data">
                    	<span class="snum">550</span>
                    	<span class="lnum">1450</span>
                    </p>

                    <marquee direction="up"  scrolldelay="300" class="tab-content">
                    		<p class="link">天津赵女士07月06日已申请上门量尺</p>
                    		<p class="link">南京赵女士07月06日已申请上门量尺</p>
                    		<p class="link">北京赵女士07月06日已申请上门量尺</p>
                    		<p class="link">青岛赵女士07月06日已申请上门量尺</p>
                    </marquee> -->
                    
                </div>
            </div>
            <!--报名 end -->
		</div>
	</div>
	<div class="bg4">
		<div class="inside">
		<!-- <a href="#" name="sg" style="display:block;height:121px;"></a> -->
		<!-- 申购弹出 -->
	<div class="pop-box hide" id="pop-box">
	   <div class="mbg"></div>
            <input class="name" type="text" name="name" value="" />    
            <input class="phone" type="text" name="phone" value="" />
            <p class="address2">地&nbsp址:<input  type="text" id="address2" name="address2" value="" /></p>
		 <p class="sure"></p>
		 <div class="close"></div>
		 <p class="pick">
		        <select id="province1">
					  <option>----请选择省份----</option> 
 
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
				
				   <select class="city1"> 
   							<option>----请选择城市----</option> 
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
				       <option>陇南</option> 
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
		    </p> 
	</div>
		<div class="turn taber">
		   <div class="square"></div>
			<ul class="tab_menu">
				<li class="current" data="奥斯卡马桶"><a href="javascript:void(0)" class="a1"></a></li>
				<li id="sLi2" data="奥拉大花洒"><a href="javascript:void(0)" class="a2"></a></li>
				<li id="sLi3" data="阿凡提浴室柜套餐"><a href="javascript:void(0)" class="a3"></a></li>
				<li id="sLi4" data="卫洗宝智能马桶"><a href="javascript:void(0)" class="a4"></a></li>
			</ul>

		<div class="tab_box">
			<div id="swiper1">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<a href="http://v.qq.com/page/g/0/4/g01595iwl04.html" target="blank" alt="奥斯卡马桶" class="site1"></a>
			            	<!-- 申购报名弹出 -->
			            	<a href="javascript:void(0)" class="popup1"></a>
								<!-- end -->
							<img src="images/o/o1.jpg" height="568" width="939" alt="">
				        </div>
			            <div class="swiper-slide">
							<img src="images/o/o2.jpg" height="568" width="939" alt="">
			            </div>
			            <div class="swiper-slide">
							<img src="images/o/o3.jpg" height="568" width="939" alt="">
			            </div>
			            <div class="swiper-slide">
							<img src="images/o/o4.jpg" height="568" width="939" alt="">
			            </div> 
			            <div class="swiper-slide">
							<img src="images/o/o5.jpg" height="568" width="939" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			    </div> 
			</div>
			<div class="hide" id="swiper2">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			                <a href="javascript:void(0)" class="popup2"></a>
							<img src="images/ol/ol1.jpg" height="568" width="939" alt="">
				        </div>
			            
			            <div class="swiper-slide">
							<img src="images/ol/ol2.jpg" height="568" width="939" alt="">
			            </div>

			            <div class="swiper-slide">
							<img src="images/ol/ol3.jpg" height="568" width="939" alt="">
			            </div>
			        </div>
			        <!-- Add Pagination -->
				        <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			    </div> 
					</div>
			<div class="hide" id="swiper3">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            <a href="http://v.qq.com/page/z/o/u/z01596slkou.html " target="blank" alt="阿凡提" class="site2"></a>
			                <a href="javascript:void(0)" class="popup3"></a>
							<img src="images/a/a1.jpg" height="568" width="939" alt="">
				        </div>
			            
			            <div class="swiper-slide">
							<img src="images/a/a2.jpg" height="568" width="939" alt="">
			            </div>

			            <div class="swiper-slide">
							<img src="images/a/a3.jpg" height="568" width="939" alt="">
			            </div>

			            <div class="swiper-slide">
							<img src="images/a/a4.jpg" height="568" width="939" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			    </div> 
					</div>
			<div class="hide" id="swiper4">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            <a href="http://v.qq.com/page/w/5/q/w0159ey5o5q.html" target="blank" alt="智能" class="site3"></a>
			            <a href="javascript:void(0)" class="popup1"></a>
							<img src="images/w/w1.jpg" height="568" width="939" alt="">
				        </div>
			            
			            <div class="swiper-slide">
							<img src="images/w/w2.jpg" height="568" width="939" alt="">
			            </div>

			            <div class="swiper-slide">
							<img src="images/w/w3.jpg" height="568" width="939" alt="">
			            </div>

			            <div class="swiper-slide">
							<img src="images/w/w4.jpg" height="568" width="939" alt="">
			            </div> 
			            <div class="swiper-slide">
							<img src="images/w/w5.jpg" height="568" width="939" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			    </div> 
			</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bg5">
		<!-- <a href="#" name="bk" style="display:block;height:121px;"></a> -->
		<div class="inside">
		<img src="images/2-code.png" height="162" width="162" alt="">
		</div>
	</div>
	<div class="bg6"></div>
	<div class="bg7"></div>
	<div class="bg8"></div>
	<div class="bg9"></div>

	<!-- 申购弹出蒙层 -->
	<div class="bg10 hide"id="bg10"></div>

	<script src="js/swiper.min.js"></script>
    <script>

    //弹出申购
    $(".popup1").click(function(){
		$("#pop-box").show();
		$("#bg10").show();

	});
	$("#pop-box .close").click(function(){
		$(".pop-box").hide();
		$("#bg10").hide();
	});

    $(".popup2").click(function(){
		$("#pop-box").show();
		$("#bg10").show();

	});
	$("#pop-box .close").click(function(){
		$(".pop-box").hide();
		$("#bg10").hide();
	});

    $(".popup3").click(function(){
		$("#pop-box").show();
		$("#bg10").show();

	});
	$("#pop-box .close").click(function(){
		$(".pop-box").hide();
		$("#bg10").hide();
	});

	// tab
		$(function(){
		$('.taber').Tabs();
	});

	// 省市联动
		var currentShowCity=0;
		// 报名
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
		});

//申购
		var currentShowCity=0;

		$(function(){
		   $("#province1").change(function(){
			   $("#province1 option").each(function(i,o){
				   if($(this).attr("selected"))
				   {		 
					   $(".city1").hide();
					   $(".city1").eq(i).show();
					   currentShowCity=i;
				   }
			   });
		   });
		   $("#province1").change();
		});


	//报名
	$("#sign .sub").click(function(){
		var username = $("#name").val();
		var phone = $("#phone").val();
		var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
		var province = $("#province").val();
		var city = '';
		/*$(".city").each(function(){
			if($(this).css('display') != 'none'){
				city = $(this).val();
			}
		});*/
		city = $(".city").eq(currentShowCity).val()
		var address = $("#address").val()
		if(username == "" || !mob.test(phone) || province == "" || province == "----请选择省份----"|| city == "" || city == "----请选择城市----" || address == ''){
				alert("请填写正确的信息");
		}else{
			$.ajax({
				url:"http://zt.jia360.com/dongpeng/index.php?type=yuyue",
				data:"username="+username+"&phone="+phone+"&province="+province+"&city="+city+"&address="+address,
				type: "POST",
				dataType:'json',
				success:function(msg){
					if(msg.state == 1){
						//成功
				alert("恭喜你，预约成功！");
									$.ajax({
										url:"http://zt.jia360.com/dongpeng/index.php?type=sendmsg",
										data:"phone="+phone+"&content=尊敬的"+username+"，恭喜您预约报名成功，我们会在24小时内联系您。除了免费量尺、提供设计方案外，我们还提供抵用券、东鹏礼包。请保持手机畅通，请留意我们的客服电话【东鹏洁具】",
										type: "POST",
										dataType:'json',
										success:function(msg){} 		
									});
					}
				} 		
			});
		}
	});
	

	//申购
	$("#pop-box .sure").click(function(){
		var goodname = $('.tab_menu li.current').attr('data');
		var username = $("#pop-box .name").val();
		var phone = $("#pop-box .phone").val();
		var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
		var province = $("#province1").val();
		var city = '';
		// $(".city1").each(function(){
		// 	if($(this).css('display') != 'none'){
		// 		city = $(this).val();
		// 	}
		// });
	    city = $(".city1").eq(currentShowCity).val()
		var address = $("#address2").val()
		if(username == "" || !mob.test(phone) || province == "" || province == "----请选择省份----"|| city == "" || city == "----请选择城市----" || address == ''){
				alert("请填写正确的信息");
		}else{
			$.ajax({
				url:"http://zt.jia360.com/dongpeng/index.php?type=shenggou",
				data:"goodsname="+goodname+"&username="+username+"&phone="+phone+"&province="+province+"&city="+city+"&address="+address,
				type: "POST",
				dataType:'json',
				success:function(msg){
					if(msg.state == 1){
						//成功
						alert("恭喜你，申购成功！");
					//$("#pop-box").hide();
									$.ajax({
										url:"http://zt.jia360.com/dongpeng/index.php?type=sendmsg",
										data:"phone="+phone+"&content=尊敬的"+username+"，恭喜您预约成功，您的申购码为"+msg.msg+"，请凭借申购码去线下购买，亲，线下付款购买后，我们可以包邮哦【东鹏洁具】",
										type: "POST",
										dataType:'json',
										success:function(msg){} 		
									});
					}
				} 		
			});
		};
	
	});




	

	//swiper
        setTimeout(function(){
            var swiper = new Swiper('#swiper1 .swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            // autoplay : 5000,
            loop: true,
            });
        },1);

    $('#sLi2').hover(function (){
        setTimeout(function(){
            var swiper = new Swiper('#swiper2 .swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            // autoplay : 5000,
            loop: true,
            });
        },1);
    });
    $('#sLi3').hover(function (){
        setTimeout(function(){
            var swiper = new Swiper('#swiper3 .swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            // autoplay : 5000,
            loop: true,
            });
        },1);
    });
    $('#sLi4').hover(function (){
        setTimeout(function(){
            var swiper = new Swiper('#swiper4 .swiper-container', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            // autoplay : 5000,
            loop: true,
            });
        },1);
    });
 	// animation
		$(function(){
			$('#icon').addClass('zoomIn')
		})

		$(function(){
			$('#sun').addClass('rotateIn')
		})

		$(function(){
			$('.icon2').addClass('zoomInUp')
		})

    $("#hx").click(function(){
        $("html,body").animate({scrollTop: 800}, 300);
    });

    $("#sg").click(function(){
        $("html,body").animate({scrollTop: 2460}, 300);
    });

    $("#bk").click(function(){
        $("html,body").animate({scrollTop: 3660}, 300);
    });


    //goToTop
    $(window).scroll(function(){
        if($(window).scrollTop()>1){
            $("#goToTop").show(100);
        }else{
            $("#goToTop").hide(100);
        }
    });
    $("#goToTop").click(function(){
        if(scroll=="off") return;
        $("html,body").animate({scrollTop: 0}, 300);
    });


</script>
	    <!--#include virtual="/public/head.html"-->
        <!--#include virtual="/public/tongji.html"-->
        <!--#include virtual="/public/footer.html"-->
</body>
</html>