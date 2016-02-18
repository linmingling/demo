<?php
//error_reporting(0);
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$res = mysqli_query($db,"select count(*) as num from dpjj_yuyue");
$num = $res->fetch_array();


$res = mysqli_query($db,"select * from dpjj_yuyue");
while($res && $row = $res->fetch_array()){
	$list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>提前双十一 不必等喵喵-东鹏洁具O2O抢先钜惠</title>
	<link rel="stylesheet"  href="css/main.css">
	<link rel="stylesheet"  href="css/animate.css">
	<link rel="stylesheet" href="css/swiper.min.css">
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery.tabs.js"></script>
    <script src="js/my.js?v=1.2"></script>
	<script src="js/my2.js?v=1.2"></script>
</head>
<body>
	<div class="bg1">
		<div class="inside">
			<div class="nav"></div>
			<!-- <div class="icon2-1"><img src="images/icon2.png" height="155" width="279" alt=""></div> -->
			<div class="menu">
				<ul>
					<li><a href="javascript:void(0)" id="hx"></a></li>
					<li><a href="javascript:void(0)" id="sg"></a></li>
					<li><a href="javascript:void(0)" id="bk"></a></li>
					<li style="margin-top:160px;"><a href="http://wpa.qq.com/msgrd?V=3&amp;uin=2577087101&amp;Site=613在线咨询&amp;Menu=yes" target="blank"></a></li>
					<li><a href="javascript:void(0)" id="goToTop"></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="bg2"><!-- <a href="#" name="hx" style="display:block;height:121px;"></a> --></div>
    <div class="bg4">
		<div class="inside">
		<!-- <a href="#" name="sg" style="display:block;height:121px;"></a> -->
		<!-- 申购弹出 -->	
	<div class="pop-box hide" id="pop-box">
	   <div class="mbg"></div>
            <input class="name" type="text" name="name" value="" id="myname"/>    
            <input class="phone" type="text" name="phone" value="" id="myphone"/>
            
		 <p class="sure" id="btn"></p>
		 <div class="close"></div>
		 <div class="pick" id="list2">
		                   <div class="opt-ly" style="float:left; margin-left:0px;">
                               <select id="prov2" onChange="toProvince2();">
                                  <option value="">请选择省</option>
                                </select>
                           </div>
                           <div class="opt-ly" style="float:left">
                               <select id="city2" onChange="toCity2();">
                                 <option value="">请选择市</option>
                                </select>
                           </div>

                           <div class="opt-ly">
                               <select id="dist2">
                                 <option value="">请选择区</option>
                                </select>
                           </div>
		    </div> 
	</div>
		<div class="turn taber">
		   <div class="square"></div>
			<ul class="tab_menu">
				<li class="current"><a href="javascript:void(0)" >智能马桶</a></li>
				<li id="sLi2"><a href="javascript:void(0)" >音乐花洒</a></li>
				<li id="sLi3"><a href="javascript:void(0)" >雅克浴室柜</a></li>
				<li id="sLi4"><a href="javascript:void(0)" >奥斯卡马桶</a></li>
			</ul>

		<div class="tab_box">
			<div id="swiper1">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<!-- 申购报名弹出 -->
			            	<a href="javascript:void(0)" class="popup1 an" onClick="pop('智能马桶')"></a>
								<!-- end -->
			            <img src="images/a1.jpg" alt="" width="1000" height="605" >
                      	</div>
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('智能马桶')"></a>
						  <img src="images/a2.jpg" height="605" width="1000" alt="">
                          
            			</div>
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('智能马桶')"></a>
						  <img src="images/a3.jpg" height="605" width="1000" alt="">
			            </div> 
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('智能马桶')"></a>
						  <img src="images/a4.jpg" height="605" width="1000" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        
			    </div> <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			</div>
			<div class="hide" id="swiper2">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            	<a href="javascript:void(0)" class="popup1" onClick="pop('音乐花洒')"></a>
							<img src="images/b1.jpg" height="605" width="1000" alt="">
			          </div>
			            
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('音乐花洒')"></a>
							<img src="images/b2.jpg" height="605" width="1000" alt="">
			            </div>

			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('音乐花洒')"></a>
							<img src="images/b3.jpg" height="605" width="1000" alt="">
			            </div>
                        <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('音乐花洒')"></a>
							<img src="images/b4.jpg" height="605" width="1000" alt="">
			            </div>

			        </div>
			        <!-- Add Pagination -->
				        
			    </div> <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
			<div class="hide" id="swiper3">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            			            	<a href="javascript:void(0)" class="popup1" onClick="pop('雅克浴室柜')"></a>

							<img src="images/c1.jpg" height="605" width="1000" alt="">
				        </div>
			            
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('雅克浴室柜')"></a>
							<img src="images/c2.jpg" height="605" width="1000" alt="">
			            </div>

			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('雅克浴室柜')"></a>
							<img src="images/c3.jpg" height="605" width="1000" alt="">
			            </div>

			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('雅克浴室柜')"></a>
							<img src="images/c4.jpg" height="605" width="1000" alt="">
			            </div> 
                        <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('雅克浴室柜')"></a>
							<img src="images/c5.jpg" height="605" width="1000" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        
			    </div> <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
			<div class="hide" id="swiper4">
				<div class="swiper-container">
			        <div class="swiper-wrapper">
			            <div class="swiper-slide">
			            <a href="javascript:void(0)" class="popup1" onClick="pop('奥斯卡马桶')"></a>
							<img src="images/d1.jpg" height="605" width="1000" alt="">
				        </div>
			            
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('奥斯卡马桶')"></a>
							<img src="images/d2.jpg" height="605" width="1000" alt="">
			            </div>

			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('奥斯卡马桶')"></a>
							<img src="images/d3.jpg" height="605" width="1000" alt="">
			            </div>

			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('奥斯卡马桶')"></a>
							<img src="images/d4.jpg" height="605" width="1000" alt="">
			            </div> 
			            <div class="swiper-slide"><a href="javascript:void(0)" class="popup1s" onClick="pop('奥斯卡马桶')"></a>
							<img src="images/d5.jpg" height="605" width="1000" alt="">
			            </div> 
			        </div>
			        <!-- Add Pagination -->
				        
			    </div> <div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
			</div>
				</div>
			</div>
		</div>
	</div>
    <div class="bg2s"></div>
	<div class="bg3">
		<div class="inside">
           <!-- 报名-->
            <div id="sign">
                <div class="sign">
                    <p class="ct">
                        <input id="name" type="text" name="name" value="" />
                    </p>
                    <p class="ct">
                        <input id="phone" type="text" name="phone" value="" />
                    </p>
                          <div class="opt-ly" style="float:left; margin-left:98px;">
                               <select id="prov" onChange="toProvince();">
                                  <option value="">请选择省</option>
                                </select>
                           </div>
                           <div class="opt-ly" style="float:left">
                               <select id="city" onChange="toCity();">
                                 <option value="">请选择市</option>
                                </select>
                           </div>

                           <div class="opt-ly" style="width:;">
                               <select id="dist">
                                 <option value="">请选择区</option>
                                </select>
                           </div>

                    </p>
                    <p class="sub" id="btn2"></p>


<!--                     <p class="sign-data">
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
                     -->

                    <p class="sign-data">
                    	<!--<span class="snum">550</span>
                    	<span class="lnum">1450</span>-->
                    </p>

                    <marquee direction="up"  scrolldelay="300" class="tab-content">
                    <?php foreach($list as $k){ 
                    		echo "<p class='link'>" .$k['city']."&nbsp;".$k['username'] ."&nbsp;". mb_substr($k['phone'],0,3) . "****" . mb_substr($k['phone'],-4) . "</p>";

                    }?>
                    </marquee>
                    
                </div>
            </div>
            <!--报名 end -->
		</div>
	</div>
	
	<div class="bg5">

	</div>
	<div class="bg6"></div>
	<div class="bg7"></div>
	<input type="hidden" id="myprd" />
    <!-- 申购弹出蒙层 -->
	<div class="bg10 hide"id="bg10"></div>
	<script src="js/swiper.min.js"></script>
    <script>

    //弹出申购
 //    $(".popup1").click(function(){
	// 	$("#pop-box").show();
	// 	$("#bg10").show();

	// });
	// $(".popup1s").click(function(){
	// 	$("#pop-box").show();
	// 	$("#bg10").show();

	// });
	$("#pop-box .close").click(function(){
		$(".pop-box").hide();
		$("#bg10").hide();
	});

 //    $(".popup2").click(function(){
	// 	$("#pop-box").show();
	// 	$("#bg10").show();

	// });
	

 //    $(".popup3").click(function(){
	// 	$("#pop-box").show();
	// 	$("#bg10").show();

	// });
	
    function getCookie(c_name)
    {
        if (document.cookie.length>0)
          {
          c_start=document.cookie.indexOf(c_name + "=")
          if (c_start!=-1)
            { 
            c_start=c_start + c_name.length+1 
            c_end=document.cookie.indexOf(";",c_start)
            if (c_end==-1) c_end=document.cookie.length
            return unescape(document.cookie.substring(c_start,c_end))
            } 
          }
        return ""
    }

	function pop(type){
		$("#pop-box").show();
	 	$("#bg10").show();
		$('#myprd').val(type);
	}


		$('#btn').bind('click',function(){
			var _type=$('#myprd').val();;//产品类型
			var _name=$("#myname").val();
			var _phone=$("#myphone").val();
			var _prov=$("#prov2").val();
			var _city=$("#city2").val();
			var _dist=$("#dist2").val();
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
			//console.log(_type+';'+_name+';'+_phone+';'+_prov+';'+_city+';'+_dist+';');
		    
            if(_name == "" || !mob.test(_phone) || _prov == "请选择省" || _prov == "" || _city == "" || _city == "请选择市" || _dist =="请选择区" || _dist ==""||$('#prov').val()==''){
                alert("请填写正确的信息");
                return;
            }else{
                var source = getCookie('source');
                $.ajax({
                    async:true,
                    url:'../dpjj_11/index.php?type=shenggou&source='+source,
                    data:"goodsname="+_type+"&username="+_name+"&phone="+_phone+"&province="+_prov+"&city="+_city+"&address="+_dist,
                    type: 'post',
                    dataType:'json',
                    success:function(result){
                        
                        if(result.state == 1){
                            $("#name").val('');
                            $("#phone").val('');
                            $("#prov").val('');
                            $("#city").val('');
                            $("#dist").val('');
                            alert("恭喜你，预购成功！");
                            $(".pop-box").hide();
                            $("#bg10").hide();
                            $.ajax({
                                url:"../dpjj_11/index.php?type=sendmsg",
                                data:"phone="+_phone+"&content=【腾讯家居·优居网】"+_name+"先生/小姐，恭喜您预购成功，您的预购码为"+result.msg+"，请凭预购码去东鹏洁具当地门店看样购买。请保持手机畅通，以便客服及时联系您，祝生活愉快。",
                                type: "POST",
                                dataType:'json',
                                success:function(msg){
    //							console.log(msg);
                                }         
                            });
                        }
                        


                    }
                });
            }

		
		})

	$('#btn2').bind('click',function(){
			var _name=$("#name").val();
			var _phone=$("#phone").val();
			var _prov=$("#prov").val();
			var _city=$("#city").val();
			var _dist=$("#dist").val();
            var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|18[0-9])[0-9]{8}$/;
			//console.log(_name+';'+_phone+';'+_prov+';'+_city+';'+_dist+';');

            if(_name == "" || !mob.test(_phone) || _prov == "请选择省" || _prov == "" || _city == "" || _city == "请选择市" || _dist =="请选择区" || _dist ==""||$('#prov').val()==''){
                alert("请填写正确的信息");
                return;
            }else{
                var source = getCookie('source');
//                alert('123');
                $.ajax({
                    async:true,
                    url:'../dpjj_11/index.php?type=yuyue&source='+source,
                    data:"username="+_name+"&phone="+_phone+"&province="+_prov+"&city="+_city+"&address="+_dist,
                    type: 'post',
                    dataType:'json',
                    success:function(result){
                        if(result.state == 1){
                            $("#name").val('');
                            $("#phone").val('');
                            $("#prov").val('');
                            $("#city").val('');
                            $("#dist").val('');
                            alert("恭喜你，预约成功！");
                            $.ajax({
                                url:"../dpjj_11/index.php?type=sendmsg",
                                data:"phone="+_phone+"&content=【腾讯家居·优居网】"+_name+"先生/小姐，恭喜您预约浴室升级成功，除享受4项免费服务外，我们还将提供价值110元浴室升级现金供抵用券。请保持手机畅通，以便客服及时联系您，祝生活愉快。",
                                type: "POST",
                                dataType:'json',
                                success:function(msg){}         
                            });
                        }
                        else
                        {
                            alert(result.msg);
                        }
                    }
                });
            }
			
		})






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

    $('.tab_menu li').bind('click',function(){
    	$('.tab_menu li').removeClass('current');
			$(this).addClass('current');
    	if($(this).text().trim()=='智能马桶')
    	{
    		$("#swiper2,#swiper3,#swiper4").hide();
			$("#swiper1").show();

    	}
    	else if($(this).text().trim()=='音乐花洒')
    	{
    		$("#swiper1,#swiper3,#swiper4").hide();
    		$("#swiper2").show();
    	}
    	else if($(this).text().trim()=='雅克浴室柜')
    	{
    		$("#swiper2,#swiper1,#swiper4").hide();
    		$("#swiper3").show();
    	}
    	else{
    		$("#swiper2,#swiper3,#swiper1").hide();
    		$("#swiper4").show();
    	}

    })
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