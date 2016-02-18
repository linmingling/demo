﻿<?php
//error_reporting(0);
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

require_once "../data/jssdk.php";
$jssdk = new JSSDK();//优居生活服务号
$signPackage = $jssdk->GetSignPackage();

function sendSms($phone, $content){
	header("Content-Type: text/html; charset=UTF-8");
        $flag = 0;
        $params=''; //要post的数据
        //以下信息自己填以下
        $argv = array(
            'name' => '3086533498@qq.com',//必填参数。用户账号
            'pwd' => '52F4A74F3EAD7BFF6EF5A84D0F96',//必填参数。（web平台：基本资料中的接口密码）
            'content' => $content,//必填参数。发送内容（1-500 个汉字）UTF-8编码
            'mobile' => $phone,//必填参数。手机号码。多个以英文逗号隔开
            'stime' => '', //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
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
        $url = "http://api.1xinxi.cn:1860/asmx/smsservice.aspx?".$params; //提交的url地址
//        die(json_encode(array('state'=>0,'msg'=>$url)));
        $con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
        if($con == '0'){
           return 0;//发送成功
        } else {
           return 1;//发送失败
        }
}

if(date('Y-m-d H:i:s') > '2015-11-15 13:59:59')
{
    die(json_encode(array('state'=>0,'msg'=>'活动已结束')));
}

if(isset($_GET['type']) && $_GET['type'] == 'yuyue' && $_POST){
	header('Content-type:application/json;charset=utf-8;');
    if(empty($_POST['province']) || empty($_POST['city']) || empty($_POST['address']))
    {
        die(json_encode(array('state'=>0,'msg'=>'请填写完整信息')));
    }
	$from = isset($_GET['from']) ? (int)$_GET['from'] : 0;
	$res = mysqli_query($db,"select count(*) as num from dpjj_yuyue");
	$tmp = $res->fetch_array();
	if($tmp['num'] > 2000){
		die(json_encode(array('state'=>0,'msg'=>'已超过预约名额')));
	}
	$source = $_GET['source']; 
	$res = mysqli_query($db,"insert into dpjj_yuyue(`username`,`phone`,`province`,`city`,`address`,`time`,`from`,`source`) values('".$_POST['username']."','".$_POST['phone']."','".$_POST['province']."','".$_POST['city']."','".$_POST['address']."','".time()."','".$from."','".$source."')");
	if($res){
		
		die(json_encode(array('state'=>1,'msg'=>'success')));
	}
	die(json_encode(array('state'=>0,'msg'=>'您已预约过了')));
}

if(isset($_GET['type']) && $_GET['type'] == 'shenggou' && $_POST){
	header('Content-type:application/json;charset=utf-8;');
	$from = isset($_GET['from']) ? (int)$_GET['from'] : 0;
	$code = substr((string)time(),2);
	$res = mysqli_query($db,"insert into dpjj_shengou(`goodsname`,`username`,`province`,`city`,`address`,`phone`,`time`,`from`,`code`) values('".$_POST['goodsname']."','".$_POST['username']."','".$_POST['province']."','".$_POST['city']."','".$_POST['address']."','".$_POST['phone']."','".time()."','".$from."','".$code."')");
	if($res){
		
		die(json_encode(array('state'=>1,'msg'=>$code)));
	}
	die(json_encode(array('state'=>0,'msg'=>'faile')));
}

if(isset($_GET['type']) && $_GET['type'] == 'sendmsg' && $_POST){
//    die(json_encode(array('state'=>$_POST['phone'],'msg'=>$_POST['content'])));
	sendSms($_POST['phone'],$_POST['content']); exit();
}

if(isset($_GET['fromid']) && (int)$_GET['fromid'] == 1){
	mysqli_query($db,"update dpjj_tj set from_1 = from_1 + 1");
}

if(isset($_GET['fromid']) && (int)$_GET['fromid'] == 2){
	mysqli_query($db,"update dpjj_tj set from_2 = from_2 + 1");
}

$res = mysqli_query($db,"select count(*) as num from dpjj_yuyue");
$num = $res->fetch_array();


$res = mysqli_query($db,"select * from dpjj_yuyue");
while($res && $row = $res->fetch_array()){
	$list[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提前11.11 狂抢不必等</title>
	<meta name="keywords" content="提前11.11 狂抢不必等">
	<meta name="description" content="提前11.11 狂抢不必等">
	<meta name="front-end technicist" content="jinger">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.4" media="all" /> 
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
                                <img src="images/logo.png"  />
                            </div>
                            <div class="am am2">
                                <a id="gopage2">
                                    <img src="images/page1-1.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceInLeft"/>
                                </a>
                            </div>
                            <div class="am am3">
                                <a id="gopage3">
                                    <img src="images/page1-2.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInRight"/>
                                </a>
                            </div>
                            <div class="am am4">
                                <a href="http://dongpengjieju.ep7.net/WeiXin/index.jsp?flag=1">
                                    <img src="images/page1-3.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceInLeft"/>
                                </a>
                            </div>
                            <div class="am am5">
                                <a id="gopage9">
                                    <img src="images/page1-4.png"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceInRight"/>
                                </a>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-2">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page2-1.jpg"  />
                            </div>
                            <div class="am am7">
                                <img src="images/page2-7.png"  class="animation an7" data-item="an7" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am8">
                                <img src="images/page2-8.png"  class="animation an8" data-item="an8" data-delay="400" data-animation="bounceIn"/>
                            </div>
                            <div class="am am9">
                                <img src="images/page2-9.png"  class="animation an9" data-item="an9" data-delay="800" data-animation="bounceIn"/>
                            </div>
                            <div class="am am2">
                                <img src="images/page2-2.png"  class="animation an2" data-item="an2" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page2-3.png"  class="animation an3" data-item="an3" data-delay="1600" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page2-4.png"  class="animation an4" data-item="an4" data-delay="2000" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page2-5.png"  class="animation an5" data-item="an5" data-delay="2400" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page2-6.png"  class="animation an6" data-item="an6" data-delay="2800" data-animation="bounceInRight"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-3">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page3-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page3-2.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page3-3.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page3-4.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceIn"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page3-5.png"  class="animation an5" data-item="an5" data-delay="1000" data-animation="bounceIn"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page3-6.png"  class="animation an6" data-item="an6" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                             <div class="am am7">
                                <img src="images/page3-7.png"  class="animation an7" data-item="an7" data-delay="1400" data-animation="bounceIn"/>
                            </div>
                            <div class="am am8">
                                <img src="images/page3-8.png"  class="animation an8" data-item="an8" data-delay="1600" data-animation="bounceIn"/>
                            </div>
                            <div class="am am9">
                                <img src="images/page3-9.png"  class="animation an9" data-item="an9" data-delay="1800" data-animation="bounceIn"/>
                            </div>
                            <div class="am am10">
                                <img src="images/page3-10.png"  class="animation an10" data-item="an10" data-delay="2200" data-animation="bounceInUp"/>
                            </div>
                            <div class="kuang animation an10" data-item="an10" data-delay="2200" data-animation="fadeIn">
                                
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-4">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page4-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page4-2.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <div class="am am3">
                                <a id="gopage6">
                                    <img src="images/page4-3.jpg"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInLeft"/>
                                </a>
                            </div>
                            <div class="am am4">
                                <a id="gopage7">
                                    <img src="images/page4-4.jpg"  class="animation an4" data-item="an4" data-delay="400" data-animation="bounceInRight"/>
                                </a>
                            </div>
                            <div class="am am5">
                                <a id="gopage8">
                                    <img src="images/page4-5.jpg"  class="animation an5" data-item="an5" data-delay="800" data-animation="bounceInLeft"/>
                                </a>
                            </div>
                            <div class="am am6">
                                <a id="gopage5">
                                    <img src="images/page4-6.jpg"  class="animation an6" data-item="an6" data-delay="800" data-animation="bounceInRight"/>
                                </a>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-5">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page5-1.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am2">
                                <img src="images/page5-2.jpg"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft"/>
                                <div class="icon-1 cn1 animation an3" data-item="an3" data-delay="800" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="td(1)" />
                                </div>
                                <div class="icon-1 cn2 animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="cs(1)"/>
                                </div>
                                <div class="icon-1 cn3 animation an5" data-item="an5" data-delay="1600" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="xj(1)"/>
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-6">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page6-1.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am2">
                                <img src="images/page6-2.jpg"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft"/>
                                <div class="icon-1 cn1 animation an3" data-item="an3" data-delay="800" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="td(2)"/>
                                </div>
                                <div class="icon-1 cn2 animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="cs(2)"/>
                                </div>
                                <div class="icon-1 cn3 animation an5" data-item="an5" data-delay="1600" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="xj(2)"/>
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-7">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page7-1.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am2">
                                <img src="images/page7-2.jpg"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft"/>
                                <div class="icon-1 cn1 animation an3" data-item="an3" data-delay="1200" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="td(3)"/>
                                </div>
                                <div class="icon-1 cn2 animation an4" data-item="an4" data-delay="1600" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="cs(3)"/>
                                </div>
                                <div class="icon-1 cn3 animation an5" data-item="an5" data-delay="2000" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="xj(3)"/>
                                </div>
                                <!-- <div class="icon-1 cn4 animation an6" data-item="an6" data-delay="800" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="ys(3)"/>
                                </div> -->
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-8">
                      <div class="container">
                            <div class="am am1">
                                <img src="images/page8-1.jpg"  class="animation an1" data-item="an1" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am2">
                                <img src="images/page8-2.jpg"  class="animation an2" data-item="an2" data-delay="400" data-animation="bounceInLeft"/>
                                <div class="icon-1 cn1 animation an3" data-item="an3" data-delay="800" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="td(4)"/>
                                </div>
                                <div class="icon-1 cn2 animation an4" data-item="an4" data-delay="1200" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="cs(4)"/>
                                </div>
                                <div class="icon-1 cn3 animation an5" data-item="an5" data-delay="1600" data-animation="bounceIn">
                                    <img src="images/icon-1.png" onclick="xj(4)"/>
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-9">
                      <div class="container">
                           <div class="am am1">
                                <img src="images/page9-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page9-2.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page9-3.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page9-4.jpg"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am5">
                                <img src="images/page9-5.jpg"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page9-6.jpg"  class="animation an6" data-item="an6" data-delay="1600" data-animation="bounceInLeft"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-10">
                      <div class="container">
                           <div class="am am1">
                                <img src="images/page9-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page9-2.png"  class="animation an2" data-item="an2" data-delay="000" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page10-1.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am4">
                                <a href="http://group.yoju360.com/phone/yiyuanqiang/index/5?from=dp">
                                    <img src="images/page10-2.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceIn"/>
                                </a>
                            </div>
                            <div class="am am5">
                                <img src="images/page10-3.jpg"  class="animation an5" data-item="an5" data-delay="1200" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page10-4.jpg"  class="animation an6" data-item="an6" data-delay="1600" data-animation="bounceInRight"/>
                            </div>
                            <div class="am am7">
                                <img src="images/page10-5.jpg"  class="animation an7" data-item="an7" data-delay="2000" data-animation="bounceInLeft"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-11">
                      <div class="container">
                           <div class="am am1">
                                <img src="images/page11-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page11-2.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceInLeft"/>
                            </div>
                            <div class="am am3">
                                <img src="images/page11-3.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"/>
                            </div>
                      </div>
                  </div>

                  <div class="swiper-slide page-12">
                      <div class="container">
                           <div class="am am1">
                                <img src="images/page12-1.jpg"  />
                            </div>
                            <div class="am am2">
                                <img src="images/page12-2.png"  class="animation an2" data-item="an2" data-delay="0" data-animation="bounceIn"/>
                            </div>
                            <!-- <div class="am am3">
                                <img src="images/page12-3.png"  class="animation an3" data-item="an3" data-delay="400" data-animation="bounceIn"/>
                            </div>
                            <div class="am am4">
                                <img src="images/page12-4.png"  class="animation an4" data-item="an4" data-delay="800" data-animation="bounceIn"/>
                            </div> -->
                            <div class="am am5">
                                <img src="images/page12-5.png"  class="animation an5" data-item="an5" data-delay="400" data-animation="bounceIn"/>
                            </div>
                            <div class="am am6">
                                <img src="images/page12-6.jpg"  class="animation an6" data-item="an6" data-delay="800" data-animation="bounceIn"/>
                            </div>
                            <div class="am am7">
                                <img src="images/page12-7.png"  class="animation an7" data-item="an7" data-delay="1200" data-animation="bounceIn"/>
                            </div>
                      </div>
                  </div>

                  


            </div>
            <div class="am bottom-bg">
                <img src="images/bottom-bg.png" />
            </div>
            <div class="am bottom-btn-1" id="yysj">
                <img src="images/bottom-btn-1.png" />
            </div>
            <div class="am bottom-btn-2" id="ljyg">
                <img src="images/bottom-btn-2.png" />
            </div>



            <div class="bg"></div>
            <!-- 产品特点 -->
            <div class="td" id="td">
                <div class="td-title">产品特点</div>
                <div class="td-close" ><img src="images/icon-2.png" id="tdclose"/></div>
                <div id="tdcon">
                    <div id="tdfont"></div>
                </div>
            </div>

            <!-- 产品参数 -->
            <div class="cs" id="cs">
                <div class="cs-title">产品参数</div>
                <div class="cs-close" ><img src="images/icon-2.png" id="csclose"/></div>
                <div id="cscon">
                    <div id="csfont"></div>
                </div>
            </div>

            <!-- 产品细节 -->
            <div class="xj" id="xj1">
                <div class="xj-title">产品细节</div>
                <div class="xj-close" ><img src="images/icon-2.png" id="xjclose1"/></div>
                <div id="xjcon" class="xj-content">
                     <div id="swiper1" class="swiper">
                        <div class="swiper2-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="xj-content-1">
                                        <img src="images/prd1-1.png" />
                                    </div>
                                    <div class="xj-content-2">
                                        <p>☆</p>
                                        <p>盖板缓冲效果</p>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="xj-content-1">
                                        <img src="images/prd1-2.png" />
                                    </div>
                                    <div class="xj-content-2">
                                        <p>☆</p>
                                        <p>一键式智能操控</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="xj-qh" id="xjdian1">
                    <img src="images/icon-3.png" />
                    <img src="images/icon-4.png" />
                </div>
            </div>
            <!-- 产品细节2 -->
            <div class="xj" id="xj2">
                <div class="xj-title">产品细节</div>
                <div class="xj-close" ><img src="images/icon-2.png" id="xjclose2"/></div>
                <div id="xjcon2" class="xj-content">
                     <div id="swiper2" class="swiper">
                        <div class="swiper2-container">
                            <div class="swiper-wrapper" >
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-1.png" /></div><div class="xj-content-2"><p>☆</p><p>经典侧按</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-2.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">4寸超大排水阀，闪电急冲</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd2-3.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">48mm超大管径，C型专利管道，绝不堵塞</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xj-qh" id="xjdian2">
                    <img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />
                </div>
            </div>

            <!-- 产品细节3 -->
            <div class="xj" id="xj3">
                <div class="xj-title">产品细节</div>
                <div class="xj-close" ><img src="images/icon-2.png" id="xjclose3"/></div>
                <div id="xjcon3" class="xj-content">
                     <div id="swiper3" class="swiper">
                        <div class="swiper2-container">
                            <div class="swiper-wrapper" >
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-1.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">表层真空镀膜，时尚美观</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-2.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">铝镁合金材质，防潮耐用</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd3-3.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">十级电镀五金配件，经久耐用</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xj-qh" id="xjdian3">
                    <img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />
                </div>
            </div>

            <!-- 产品细节4 -->
            <div class="xj" id="xj4">
                <div class="xj-title">产品细节</div>
                <div class="xj-close" ><img src="images/icon-2.png" id="xjclose4"/></div>
                <div id="xjcon4" class="xj-content">
                     <div id="swiper4" class="swiper">
                        <div class="swiper2-container">
                            <div class="swiper-wrapper" >
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-1.png" /></div><div class="xj-content-2"><p>☆</p><p>超薄豪华大顶喷</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-2.png" /></div><div class="xj-content-2"><p>☆</p><p>三功能手持花洒</p></div></div>
                                <div class="swiper-slide"><div class="xj-content-1"><img src="images/prd4-3.png" /></div><div class="xj-content-2"><p>☆</p><p class="f14">精致蓝牙音乐盒</p><p class="f14">航空级玻璃置物面板</p></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xj-qh" id="xjdian4">
                    <img src="images/icon-3.png" /><img src="images/icon-4.png" /><img src="images/icon-4.png" />
                </div>
            </div>

            <!-- 六大优势 -->
            <div class="ys" id="ys">
                <div class="ys-title">六大优势</div>
                <div class="ys-close" ><img src="images/icon-2.png" id="ysclose"/></div>
                <div class="ys-content" id="yscon">
                    <div class="ys-font" id="ysfont">
                        <p>1、优质银镜，成像清晰，不变形；</p>
                        <p>2、色彩因您而定，充分满足您的想象空间，一举颠覆传统胡子形象；</p>
                        <p>3、E1级环保漆面，健康无甲醛；</p>
                        <p>4、实用新型国家专利挑檐陶瓷盆，防溢水设计。1250°高温烧制，釉面细腻洁白，易清洁；</p>
                        <p>5、高密度PVC板材，防水性能更好，耐腐蚀，硬度强、不易变形，承重性能好；</p>
                        <p>6、高品质不锈钢门铰，10级电镀表面经过盐雾测试、防锈耐用，并带有可调节缓冲功能。</p>
                    </div>
                </div>
            </div>



            <!-- 预约升级 -->
            <div class="buy-1" id="buy1">
               <div class="buy-1-close">
                   <img src="images/icon-5.jpg" id="buyclose"/>
               </div> 
               <div class="buy-1-title">
                   <div class="hide yysjtil">
                       <p class="f20">限定2000个名额，</p>
                       <p class="f16">已有<?php echo $num['num']; ?>人报名，剩余<?php echo 2000-$num['num']; ?>个名额</p>
                   </div>
                   <div class="chb-ly hide" style="margin-top: 5px;">
                       <div class="chb-left">
                           <input type="checkbox" id="checkbox-1-1" class="regular-checkbox" />
                           <!-- <label for="checkbox-1-1"></label> --><p class="chb-font">奥斯卡马桶</p>
                        </div>
                        <div class="chb-right">
                           <input type="checkbox" id="checkbox-1-2" class="regular-checkbox" />
                           <!-- <label for="checkbox-1-2"></label> --><p class="chb-font">雅克浴室柜</p>
                        </div>
                    </div>
                    <div class="chb-ly hide" style="margin: 2px auto 10px;">
                       <div class="chb-left">
                           <input type="checkbox" id="checkbox-1-3" class="regular-checkbox" />
                           <!-- <label for="checkbox-1-3"></label> --><p class="chb-font2">音乐花洒</p>
                        </div>
                        <div class="chb-right">
                           <input type="checkbox" id="checkbox-1-4" class="regular-checkbox" />
                           <!-- <label for="checkbox-1-4"></label> --><p class="chb-font2">智能马桶</p>
                        </div>
                    </div>
               </div>
               <div class="buy-1-con">
                   <div class="buy-1-con-ly">
                       <div class="text-ly">
                           <span style="padding-right: 5px;">姓名：</span><input type="text" id="name" class="inputcss">
                       </div>
                   </div>
                   <div class="buy-1-con-ly">
                       <div class="text-ly">
                           <span style="padding-right: 5px;">联络电话：</span><input type="text" id="phone" class="inputcss">
                       </div>
                   </div>
                   <div class="buy-1-con-ly">
                       <div style="width: 84%;margin:0 auto;height: 30px;">
                           <div class="opt-ly" style="float:left">
                               <span>省：</span>
                               <select id="prov" onchange="toProvince();">
                                  <option value ="">请选择</option>
                                </select>
                           </div>
                           <div class="opt-ly" style="float:right">
                               <span>市：</span>
                               <select id="city" onchange="toCity();">
                                  <!-- <option value ="">请选择</option> -->
                                </select>
                           </div>
                       </div>
                       <div style="width: 84%;margin:10px auto 0;height: 30px;">
                           <div class="opt-ly" style="width:95%;">
                               <span>区：</span>
                               <select id="dist">
                                  <!-- <option value ="">请选择</option> -->
                                </select>
                           </div>
                       </div>
                   </div>
                   <div class="buy-1-con-ly" style="padding-bottom:10px;">
                       <div class="btn-ly" id="btn">
                           <!-- 预约升级 立即申购 -->
                       </div>
                   </div>
                   
                   <div class="buy-1-tip">
                       我们承诺：1、报名成功后会有专人电话联系您，请注意陌生来电。2、我们会严格保护您的隐私，不用于其他用途。
                   </div>
               </div>
            </div>





        </div>
        
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/idangerous.swiper-2.1.min.js"></script>
    <script src="js/my.js?v=1.6"></script>
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
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			"imgUrl":'http://zt.jia360.com/dpjj_11/images/fx.jpg',
			"link":'http://zt.jia360.com/dpjj_11/index.php',
			"desc":"浴室升级、潮品预购、1元购，任君选择",
			"title":"提前11.11 狂抢不必等"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
	
</body>
</html>
