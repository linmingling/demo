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

$registor_sql = "select id,name,phone from nyhs order by add_strtotime desc limit 50";
$registor_res = mysqli_query($db,$registor_sql);
$registor_rows = array();
while($registor_row = $registor_res->fetch_assoc())
{
    $registor_rows[$registor_row['id']]['name'] = mb_substr($registor_row['name'],0,1,'utf-8') . "**";
    $registor_rows[$registor_row['id']]['phone'] = mb_substr($registor_row['phone'],0,3) . "****" . mb_substr($registor_row['phone'],-4);
}
// var_dump($registor_rows);die;
$draw_sql = "select id,name,phone from nyhs where is_draw=1 order by add_strtotime desc limit 50";
$draw_res = mysqli_query($db,$draw_sql);
$draw_rows = array();
while($draw_row = $draw_res->fetch_assoc())
{
    $draw_rows[$draw_row['id']]['name'] = mb_substr($draw_row['name'],0,1,'utf-8') . "**";
    $draw_rows[$draw_row['id']]['phone'] = mb_substr($draw_row['phone'],0,3) . "****" . mb_substr($draw_row['phone'],-4);
}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>南洋胡氏-抽奖</title>
	<link rel="stylesheet" href="css/main.css">
	<script src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
	<div class="bg1">
		<div class="in">

		</div>
	</div>


	<div class="bg2">
	    <div class="in">

	         <!--倒计时-->
			 <div class="time">
	           <div class="time-item p_djs" djs="August 18,2015,15:00">
		    	   <strong id="day_show" class="days">0</strong>
		    	   <strong id="hour_show" class="hours">00</strong>
		     	   <strong id="minute_show" class="minutes">00</strong>
		           <strong id="second_show" class="seconds">00</strong>
		      </div>
	         </div>
	         <!-- 倒计时 -->


           <!-- 抽奖结束时间 -->
	           <div class="time-item2 f_djs hide" fdjs="August 18,2015,15:30">
		      </div>


            <!-- 抽奖 -->
					<div class="result">
						<!-- <div class="d1"><p id="personNum">参与人数:533</p></div> -->
						<div class="d2">
							<div class="numberbox">
								<div class="number">
								</div>
								<div class="number">
								</div>
								<div class="number">
								</div>
								<div class="hidden">
									
								</div>
								<div class="number">
								</div>
								<div class="number">
								</div>
								<div class="number">
								</div>
								<div class="number">
								</div>
							</div>
						</div>
					</div>

					<div class="submit">
						<a  class="submitBtn"></a>
					</div>

					<div class="fin hide"></div><!-- 活动结束 -->

	          <marquee direction="up"  scrolldelay="300" class="w-list" id='showWinner'>
	          	<?php foreach($draw_rows as $k=>$v){ ?>
		          <p class="wl"><span class="w-name"><?php  echo $v['name'];?></span><span class="w-num"><?php  echo $v['phone'];?></span><span class="price">健康之旅2日游</span></p>
		        <?php } ?>
	          </marquee>

	         <!-- 报名 -->
	         <div class="sign" id="sign">
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

	            <div class="sure" id="submit_btn"></div>
            </div>
            <!-- 报名 -->
		</div>
	</div>
	<div class="bg3">
		<div class="in">
		  <!-- 报名列表 -->
		  <marquee direction="up"  scrolldelay="300" class="sign-user">
		  		<?php foreach($registor_rows as $v){ ?>
		          <p class="su"><span class="s-name"><?php  echo $v['name'];?></span><span class="s-num"><?php  echo $v['phone'];?></span></p>
		        <?php } ?>
		      
		    </marquee>
		</div>
	</div>
	<div class="bg4"><div class="in"></div></div>



		
<script>
var resultNumber="";
var drawAction;
$(document).ready(function(){
	
});

</script>


<script>
//手机号抽奖JS
$(function(){
	setupNumberbox();

});

function doIt(){
	var btnObj=$(".submitBtn");
	$.ajax({
	        async:false,
	        url: 'server.php',
	        data:{act:'check'},
	        type: "post",
	        dataType:'json',
	        success:function(result){
	            //数据返回后执行
	            if(result.errcode != 0){    //抽奖完成
	                return false;
	            }else{  
	            	setInterval(numberStart(btnObj),3000);
	 				setTimeout(numberOver(btnObj),5000);
					return false;
	            }
	            
	        }
	    });
	
}

function numberStart(obj){
	//请求后台,检查是否抽奖完成
	$.ajax({
        async:false,
        url: 'server.php',
        data:{act:'check'},
        type: "post",
        dataType:'json',
        success:function(result){
            //数据返回后执行
            if(result.errcode != 0){    //抽奖完成
                alert(result.errmsg);
                 return false;
            }else{  

                $.ajax({
			        async:false,
			        url: 'server.php',
			        data:{act:'draw'},
			        type: "post",
			        dataType:'json',
			        success:function(result){
			            //数据返回后执行
			            if(result.errcode != 0){
			                alert(result.errmsg);
			                clearInterval(drawAction);
			            }else{
			                resultNumber=result.phone;
			                obj.addClass('stop');
							startAction();
			            }
			            
			        }
			    });
            }
            
        }
    });
}
 

function numberOver(obj){
	obj.removeClass('stop');
	stopAction(resultNumber);
}


function setupNumberbox(){
	var html=' <div> <span>0</span> <span>1</span> <span>2</span> <span>3</span> <span>4</span> <span>5</span> <span>6</span> <span>7</span> <span>8</span> <span>9</span> </div>';
	$(".numberbox").find(".number").each(function(){
		$(this).append(html);
	});
}

var running=0;
function startAction(){
	$(".numberbox").find(".number").each(function(i){
		scroll(this, random(100, 100));
	});

	running=1;
}
function scroll(object, speed){
	var span=$(object).find("div > span").first().clone();
	$(object).find("div").append(span);
	
	$(object).find("div").stop().animate({top:-54}, speed, "linear", function(){
		$(object).find("div > span").first().remove();
		$(object).find("div").css("top",0);

		if(running==0){
			var n=$(object).find("div > span").first().html();
			var _n=$(object).data("-data-number-");
			if(n==_n){
				return;
			}
		}
		scroll(object, speed);
	});
}

var tmpContent;
function stopAction(number){
	var list=number.split("").slice(0, 3).concat(number.split("").slice(7, 11));
	$(".numberbox").find(".number").each(function(i){
		var n=list[i];
		$(this).data("-data-number-", n);
	});
	var showNumRes=number.substr(0,3)+"****"+number.substr(7);
	tmpContent="<span>"+showNumRes+"</span>";
	
	running=0;
}

function addWinnerNum(){
	$("#showWinner").append(tmpContent);
	
}

//get random number
function random(min,max){
    return Math.floor(min+Math.random()*(max-min));
}

</script>






<script>
// 其他城市
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

$("#submit_btn").click(function(){
    var na=$("#name").val();
    var phone=$("#phone").val();
    var city=$("#city-select").val();
    var othercity=$("#othercity").val();
    var shopname=$("#shopname").val();
    var ordersn=$("#ordersn").val();
    var captcha=$("#captcha").val();
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
                alert(result.errmsg);
                return false;
            }
            
        }
    });

    
});


// countdown
function showTime(deadline,deadline2,dom) {
    var countdown = new Date(deadline) - new Date();
    var countdown2 =new Date(deadline2) - new Date();
    
    var restDays = dom.find(".days");
    var restHours = dom.find(".hours");
    var restMinutes = dom.find(".minutes");
    var restSeconds = dom.find(".seconds");

	if(countdown<0 && countdown2>0){ //抽奖ing
		$.ajax({
	        async:false,
	        url: 'server.php',
	        data:{act:'check'},
	        type: "post",
	        dataType:'json',
	        success:function(result){
	            //数据返回后执行
	            if(result.errcode != 0){    //抽奖完成
	                return false;
	            }else{  
	            	//drawAction = setInterval(function(){doIt()},5000);
					return false;
	            }
	            
	        }
	    });

	    return false;
		
	}
	else if(countdown2<0){	//抽奖后
		console.log(2);
		$(".fin").show();
		return false;
	}

    var timer = setInterval(function() {
        var days = Math.floor(countdown / 86400000) < 0 ? 0 : Math.floor(countdown / 86400000);
        var hours = Math.floor((countdown - days * 86400000) / 3600000) < 0 ? 0 : Math.floor((countdown - days * 86400000) / 3600000);
        var minutes = Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000) / 60000);
        var seconds = Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000) < 0 ? 0 : Math.floor((countdown - days * 86400000 - hours * 3600000 - minutes * 60000) / 1000);          
         days < 10 ? days =  "0"+ days : days = days;
        hours < 10 ? hours = "0" + hours : hours = hours;
        minutes < 10 ? minutes = "0" + minutes : minutes = minutes;
        seconds < 10 ? seconds = "0" + seconds : seconds = seconds;

        restDays.html(days);
        restHours.html(hours);
        restMinutes.html(minutes);
        restSeconds.html(seconds);
        countdown -= 1000;
    }, 1000)
    
}

$(function(){
	$(".p_djs").each(function(){
		var setTime1=$(this).attr("djs");
		var setTime2=$(".f_djs").attr("fdjs");
        showTime(setTime1,setTime2,$(this));
    });
});	








</script>
	    <!--#include virtual="/public/head.html"-->
        <!--#include virtual="/public/tongji.html"-->
        <!--#include virtual="/public/footer.html"-->
</body>
</html>