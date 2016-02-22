<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$sql = "select count(*) as c from hbs_yy";
$res = mysqli_query($db,$sql);
$row = $res->fetch_assoc();

$count = $row['c']*7;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>呼博士净享新居</title>
<meta name="keywords" content="I won't let you down ，呼博士净享新居" />
<meta name="description" content="I won't let you down ，呼博士净享新居" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css"  href="css/com.css?v=1.1"  />
<script type="text/javascript" src="js/jquery-1.5.2.min.js"></script>
<script type="text/javascript"> 

var currentShowCity=0;

$(document).ready(function(){
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
   $("#province2").change(function(){
	   $("#province2 option").each(function(i,o){
		   if($(this).attr("selected"))
		   {
		 
			   $(".city2").hide();
			   $(".city2").eq(i).show();
			   currentShowCity=i;
		   }
	   });
   });
   $("#province2").change();
});

// 预约省市联动
	    var currentShowCity=0;	
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


		// 调查省市联动
	    var currentShowCity2=0;	
		$(function(){	
		   $("#province2").change(function(){
			   $("#province2 option").each(function(i,o){
				   if($(this).attr("selected"))
				   {		 
					   $(".city2").hide();
					   $(".city2").eq(i).show();
					   currentShowCity2=i;
				   }
			   });
		   });
		   $("#province2").change();
		});

// function getSelectValue(){

	
// 	alert("1级="+$("#province").val());
	 
// 	$(".city").each(function(i,o){
                   
// 		 if(i == currentShowCity){
// 			alert("2级="+$(".city").eq(i).val());
// 		 }
		
//    });

// }


</script> 
</head>
<body>
       <!--<div class="cn-spinner" id="loading" style=" opacity: 1;">
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
    </div>-->
   <!--<div class="gd"><img src="images/gd.png" ></div>-->
   <div class="swiper-container swiper-pages" id="swiper-container1">
   		<!--音乐 <div id="music">	
			<audio class="audio hide"  id="musicBox" preload="auto" loop="true" ></audio>
		</div> -->
		
		<div class="swiper-wrapper" id="wrapper">
			

			<div class="swiper-slide page-1">
				<div class="container">
					<div class="ps1 swiper-container"><img src="images/hbs_01.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-2">
				<div class="container">
					<div class="ps2 swiper-container"><img src="images/hbs_02.jpg" >
                       <div class="infobox">
                          <div class="rshu">已有<b><?php echo $count;?></b>人预约</div>
                         <div class="srb" id="form1">
                             <p><label>是否新装修：</label><input  type="radio" value="是" name="isNew">　<input  type="radio" value="否" checked name="isNew"></p>
                             <p><label>姓名：</label><input class="tmsr" name="name" type="text"></p>
                             <p><label>联系电话：</label><input class="tmsr" name="phone" type="text"></p>
                             <p><label>地址：</label>
                             <select id="province"> 
   	   <option>选择省</option> 
       <option>北京</option> 
       <option>上海</option> 
       <option>广东</option> 
       <option>安徽</option> 
       <option>江苏</option> 
       <option>山东</option> 
       <option>福建</option> 
   </select> 

   <select class="city"> 
   		<option>选择市</option> 
   </select> 
   
   <select class="city"> 
       <option>北京</option> 
   </select> 

   <select class="city"> 
       <option>徐汇区</option> 
       <option>黄浦区</option> 
       <option>长宁区</option> 
   </select> 
   
   <select class="city"> 
       <option>广州</option> 
       <option>深圳</option> 
   </select> 
   <select class="city"> 
       <option>合肥</option>  
   </select>
   <select class="city"> 
       <option>无锡</option> 
       <option>秦州</option> 
   </select>
   
   <select class="city"> 
       <option>聊城</option> 
   </select>
   
   <select class="city"> 
       <option>厦门</option> 
   </select>
                             </p>
                             <p><input class="tmsrs" name="address" type="text"></p>
                          </div>
                       </div>
                       <a class="bnts" href="javascript:void(0);"></a>
                    </div>
				</div>
			</div>
            <div class="swiper-slide page-3">
				<div class="container">
					<div class="ps3 swiper-container"><img src="images/hbs_03.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-4">
				<div class="container">
					<div class="ps4 swiper-container"><img src="images/hbs_04.jpg" ></div>
				</div>
			</div>
            <div class="swiper-slide page-5">
				<div class="container">
					<div class="ps5 swiper-container" id="form2"><img src="images/hbs_05.jpg" >
                       <div class="foxbd">
                         <div class="sbox" style="width:50%;"><label>姓名：</label><input class="lxd" name="name" type="text"></div>
                         <div class="sbox" style="width:50%;"><label>电话：</label><input class="lxd" name="phone" type="text"></div>
                         <div class="sbox" style="width:50%;"><label>年龄：</label><input class="lxd" name="age" type="text"></div>
                         <div class="sbox" style="width:50%;"><label>性别：</label>男<input name="gender" type="radio" value="男">　女<input name="gender" type="radio" value="女" checked></div>
                      <div class="sbox" style=" margin-bottom:0px;">
                              <label>详细地址：</label>
                              <select id="province2"> 
   	   <option>请选择省份</option> 
       <option>北京</option> 
       <option>上海</option> 
       <option>广东</option> 
       <option>安徽</option> 
       <option>江苏</option> 
       <option>山东</option> 
       <option>福建</option> 
   </select> 

   <select class="city2"> 
   		<option>请选择城市</option> 
   </select> 
   
   <select class="city2"> 
       <option>北京</option> 
   </select> 

   <select class="city2"> 
       <option>徐汇区</option> 
       <option>黄浦区</option> 
       <option>长宁区</option> 
   </select> 
   
   <select class="city2"> 
       <option>广州</option> 
       <option>深圳</option> 
   </select> 
   <select class="city2"> 
       <option>合肥</option>  
   </select>
   <select class="city2"> 
       <option>无锡</option> 
       <option>秦州</option> 
   </select>
   
   <select class="city2"> 
       <option>聊城</option> 
   </select>
   
   <select class="city2"> 
       <option>厦门</option> 
   </select>
                           </div>
                           <div class="sbox"><input class="lxd2" name="address" type="text"></div>
                         <div class="sbox"><label>家庭组成：</label>老人<input name="family" type="checkbox" checked value="老人">孕妇<input name="family" type="checkbox" value="孕妇">幼儿 <input name="family" type="checkbox" value="婴幼儿">均无<input name="family" type="checkbox" value="均无"></div>
                          <div class="sbox"><label>是否新装修：</label>是<input name="isNew" type="radio" value="是">　否<input name="isNew" type="radio" value="否" checked></div>
                          <div class="sbox"><label>是否有二手烟：</label>是<input name="smoke" type="radio" value="是">　否<input name="smoke" type="radio" value="否" checked></div>
                          <div class="sbox"><label>是否有呼吸疾病人员：</label>是<input name="sick" type="radio" value="是">　否<input name="sick" type="radio" value="否" checked></div>
                          <div class="sbox" style="width:50%;"><label>是否过敏：</label>是<input name="allergy" type="radio" value="是">否<input name="allergy" type="radio" value="否" checked></div>
                          <div class="sbox" style="width:50%;"><label>是否有宠物：</label>是<input name="pet" type="radio" value="是">否<input name="pet" type="radio" value="否" checked></div>
                          <div class="sbox"><label>是否使用过空气净化器：</label>是<input name="air" type="radio" value="是">　否<input name="air" type="radio" value="否" checked></div>
                          <div class="sbox"><label>是否想过购买空气净化器：</label>是<input name="buy" type="radio" value="是">　否<input name="buy" type="radio" value="否" checked></div>
                       </div>
                       <a class="bnts2" href="javascript:void(0);"></a>
                    </div>
				</div>
			</div>
            <div class="swiper-slide page-6">
				<div class="container">
					<div class="ps6 swiper-container"><img src="images/hbs_06.jpg" ></div>
				</div>
			</div>
          
	   </div>
	</div>
	<div class="cn-slidetips">
		
	</div>
<script src="js/jquery-1.8.3.min.js"></script>
<script src="js/idangerous.swiper-2.1.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="js/com.js"></script>
<script>
    $(function(){
		//提交信息
		$(".bnts").click(function(){
            var isNew=$("#form1 input[name='isNew']:checked").val();
            var province=$("#province").attr('value');

            if(province == "选择省"){
                alert("请选择省份！");
                    return false;
            }

            var city=$(".city").eq(currentShowCity).val();
            var name=$("#form1 input[name='name']").val();
            var phone=$("#form1 input[name='phone']").val();
            var address=$("#form1 input[name='address']").val();
            $.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'addinfo',name:name,phone:phone,province:province,city:city,address:address,isNew:isNew},
                type: "post",
                dataType:'json',
                success:function(result){
                    console.log(result);
                    if(result.errcode != 0){
						alert(result.errmsg);
	                }else{
                        alert(result.errmsg);
                    }
                }
            });


        });

        $(".bnts2").click(function(){
            var isNew=$("#form2 input[name='isNew']:checked").val();
            var province=$("#province2").attr('value');

            if(province == "请选择省份"){
//                alert("请选择省份！");
//                    return false;
            }

            var city=$(".city2").eq(currentShowCity2).val();
            var name=$("#form2 input[name='name']").val();
            var phone=$("#form2 input[name='phone']").val();
            var address=$("#form2 input[name='address']").val();
            var age=$("#form2 input[name='age']").val();
            var smoke=$("#form2 input[name='smoke']:checked").val();
            var gender=$("#form2 input[name='gender']:checked").val();
            var sick=$("#form2 input[name='sick']:checked").val();
            var allergy=$("#form2 input[name='allergy']:checked").val();
            var pet=$("#form2 input[name='pet']:checked").val();
            var air=$("#form2 input[name='air']:checked").val();
            var buy=$("#form2 input[name='buy']:checked").val();
            
            var family ="";
            $("#form2 input[name='family']:checked").each(function(){
                if(family == ""){
                    family += $(this).attr("value");
                }else{
                    family += ","+$(this).attr("value");
                }
                
            });
            console.log(gender);
            
            $.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'addsurvey',name:name,phone:phone,province:province,city:city,address:address,isNew:isNew,family:family,age:age,gender:gender,smoke:smoke,sick:sick,allergy:allergy,pet:pet,air:air,buy:buy},
                type: "post",
                dataType:'json',
                success:function(result){
                    console.log(result);
                    if(result.errcode != 0){
						alert(result.errmsg);
	                }else{
                        alert(result.errmsg);
                    }
                }
            });


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
			"imgUrl":'http://zt.jia360.com/hxlp_m/images/hxl_01.jpg',
			"link":'http://zt.jia360.com/hxlp_m/index.php',
			"desc":"绿色领跑，开启绿色家居梦想",
			"title":"绿色领跑，开启绿色家居梦想"
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
<!--#include virtual="/public/tongji.html"-->

</body>
</html>