<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$sql = "select count(*) as c from hbs_yy";
$res = mysqli_query($db,$sql);
$row = $res->fetch_assoc();

$count = $row['c']*7;

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>呼博士 净享新居 为爱行动</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" media="all"/>
</head>
<body>
	<div class="box1">
				<!-- flash -->
		    <object class="swf" id="swf"  height="650" width="100%">
				<param name="movie" value="images/index.swf" >
				<param name="quality" value="high">
				<param NAME="wmode" VALUE="transparent">
				<embed src="images/index.swf"  wmode="transparent" height="650" width="100%"></embed>
			</object>
		
	</div>


	<div class="box2">
		<div class="inbox">
		<!-- 预约 -->
		<div class="sub">
			<p class="note">已有<span class="num"><?php echo $count;?></span>人预约</p>
				<div class="odbox" id="odbox">
					<p class="ct">
						<span class="isdes">是否新装修:
						&nbsp&nbsp&nbsp&nbsp
							<span class="isdes2">
								是<span class="chk" value="是"></span>
								&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>
								<input type="hidden" value="" id="isdes">
							</span>
						</span>
					</p>
					<p class="ct"><span class="user">姓名:</span>&nbsp<input id="name" type="text" name="name" value=""></p>
					<p class="ct"><span class="phone">联系电话:</span>&nbsp<input id="tel" type="text" name="tel" value=""></p>
					<p class="ct">
						<span class="address">地址:</span>&nbsp
						   <select id="province"> 
						   	   <option>----请选择----</option> 
						       <option>北京</option> 
						       <option>上海</option> 
						       <option>广州</option> 
						       <option>深圳</option> 
						       <option>安徽</option> 
							   <option>江苏</option> 
							   <option>山东</option> 
							   <option>福建</option> 
						   </select> 

						   <select class="city"> 
						   		<option>----请选择----</option> 
						   </select> 

						   <select class="city"> 
						       <option>北京</option> 
						   </select> 

					      <select class="city"> 
						       <option>黄浦区</option> 
						       <option>徐汇区</option> 
						       <option>长宁区</option> 
						  </select> 
					      <select class="city"> 
						       <option>广州</option> 
						  </select> 
					      <select class="city"> 
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
					<p class="ct"><input type="text" id="address" name="address" value=""></p>
				</div>
			<p class="sure"></p>
		</div>
		</div>
	</div>


	<div class="box3"><div class="inbox"><div class="btn-a"></div></div></div>


	<div class="box4">
		<div class="inbox"><a href="http://mall.jd.com/index-123759.html"  target="_blank" class="shop1"></a></div>
	</div>


	<div class="box5">
		<div class="inbox">
			<div class="research" id="research">
				<p class="p1">
					<span class="user2">姓名:</span><input id="name2" type="text" name="name2" value="">
					<span class="phone2">联系电话:</span><input id="tel2" type="text" name="tel2" value="">
					<span class="sex">性别:</span>						
						&nbsp&nbsp&nbsp&nbsp
						<span class="sex2">
							男<span class="chk" value="男"></span>
							&nbsp&nbsp&nbsp&nbsp
							女<span class="chk" value="女"></span>
							<input type="hidden" value="" id="sex">
						</span>
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
					<span class="age">年龄:</span><input id="age" type="text" name="age" value="">
				</p>
				<p class="p2">
					<span class="location">所在城市:</span>
						   <select id="province2"> 
						   	   <option>----请选择----</option> 
						       <option>北京</option> 
						       <option>上海</option> 
						       <option>广州</option> 
						       <option>深圳</option> 
						       <option>安徽</option> 
							   <option>江苏</option> 
							   <option>山东</option> 
							   <option>福建</option> 
						   </select> 

						   <select class="city2"> 
						   		<option>----请选择----</option> 
						   </select> 

						   <select class="city2"> 
						       <option>北京</option> 
						   </select> 

					      <select class="city2"> 
						       <option>黄浦区</option> 
						       <option>徐汇区</option> 
						       <option>长宁区</option> 
						  </select> 
					      <select class="city2"> 
						       <option>广州</option> 
						  </select> 
					      <select class="city2"> 
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
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						  <span class="d-address">详细地址:</span>
						  <input type="text" id="address2" name="address2" value="">
				</p>


				<p class="p3">
						<span class="family">家庭成员组成:						
						&nbsp&nbsp&nbsp&nbsp
							<span class="family2">
								老人<span class="chk" value="老人"></span>&nbsp
								孕妇<span class="chk" value="孕妇"></span>&nbsp
								婴幼儿<span class="chk" value="婴幼儿"></span>&nbsp
								均无<span class="chk" value="均无"></span>
								<input type="hidden" value="" id="family">
							</span>
						</span>
						<span class="isnew">是否新装修:
						&nbsp&nbsp&nbsp&nbsp
							<span class="isnew2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="isnew">
							</span>
						</span>
				</p>
				<p class="p4">
						<span class="issmoke">是否有二手烟:
						&nbsp&nbsp&nbsp&nbsp
							<span class="issmoke2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="issmoke">
							</span>
						</span>
						<span class="isill">是否有呼吸疾病人员:
						&nbsp&nbsp&nbsp&nbsp
							<span class="isill2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="isill">
							</span>
						</span>
				</p>
				<p class="p5">
						<span class="ispain">是否过敏:
						&nbsp&nbsp&nbsp&nbsp
							<span class="ispain2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="ispain">
							</span>
						</span>
						<span class="ispat">是否有宠物:
						&nbsp&nbsp&nbsp&nbsp
							<span class="ispat2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="ispat">
							</span>
						</span>
				</p>
				<p class="p6">
						<span class="isuse">是否使用空气净化器:
						&nbsp&nbsp&nbsp&nbsp
							<span class="isuse2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="isuse">
							</span>
						</span>
						<span class="isbuy">是否想过购买空气净化器:
						&nbsp&nbsp&nbsp&nbsp
							<span class="isbuy2">
								是<span class="chk" value="是"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								否<span class="chk" value="否"></span>&nbsp
								<input type="hidden" value="" id="isbuy">
							</span>
						</span>
				</p>

				<div class="send"></div>
			</div>
		</div>
	</div>


	<div class="box6"><div class="inbox"><div class="btn-b"></div></div></div>


	<!-- 弹层1 -->

	<div class="bg hide">
		<div class="pop">
		<div class="cls"></div>
		</div>
	</div>
	<!-- 弹层2 -->
	<div class="bg2 hide">
		<div class="pop2">
		<div class="cls2"></div>
		<div class="h1"><img src="images/h1.png"alt=""><a href="http://mall.jd.com/index-123759.html"  target="_blank" class="shop2"></a></div>
		</div>
	</div>

	
<script src="js/jquery-1.8.3.min.js"></script>
<script>
	
$(function(){

        // 弹层
		$('.btn-a').click(function(){
			$('.bg').show();
			document.body.style.overflow="hidden";
		})

		$('.bg .cls').click(function(){
			$('.bg').hide();
			document.body.style.overflow="auto";
		})



		$('.btn-b').click(function(){
			$('.bg2').show();
			document.body.style.overflow="hidden";
		})

		$('.bg2 .cls2').click(function(){
			$('.bg2').hide();
			document.body.style.overflow="auto";
		})


})



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

	// 勾选框
    $('#odbox .isdes2 .chk').each(function(index){
        var s1= '是';
        var s2= '否';
        $(this).click(function(){
            if($(this).hasClass('checked')){

            	$(this).removeClass('checked');
            	if(index==0){
                    s1= '';
                } else {
                    s2= '';
                }

            } else {
            	$('#odbox .isdes2 .chk').removeClass('checked');
            	$(this).addClass('checked');
                if(index==0){
                    s1= $(this).attr('value');
                    $('#isdes').val(s1);                    
                } else {
                    s2= $(this).attr('value');
                    $('#isdes').val(s2);
                }

            }

        })
    })


    $('#research .sex2 .chk').each(function(index){
	        var s3= '男';
	        var s4= '女';
	        $(this).click(function(){
	            if ($(this).hasClass('checked')){
	                 $(this).removeClass('checked');
	                if(index==0){
	                    s3= '';
	                } else {
	                    s4= '';
	                }
	            } else {
	            	$('#research .sex2 .chk').removeClass('checked');
	                $(this).addClass('checked');
	                if(index==0){
	                    s3= $(this).attr('value');
	                    $('#sex').val(s3);
	                } else {
	                    s4= $(this).attr('value');
	                    $('#sex').val(s4);
	                }
	            }
		       })
	})

    $('#research .family2 .chk').each(function(index){
	        $(this).click(function(){
	            if ($(this).hasClass('checked')){

	                $(this).removeClass('checked');
	               
	            } else {
	            	$(this).addClass('checked');               
	                if(index==0 || index ==1 || index ==2){
	                    $('#research .family2 .chk').eq(3).removeClass('checked');             		                              
	                }  else if(index==3){
	                	$('#research .family2 .chk').removeClass('checked');
	                	$(this).addClass('checked');
	                	//s8= $(this).attr('value');                 
	                }
	                /*if(index==0){
	                    s5= $(this).attr('value');
	                    $('#family').val(s5);                                  
	                } else if(index==1){
	                    s6= $(this).attr('value');
	                    $('#family').val(s6);
	                } else if(index==2){
	                    s7= $(this).attr('value');
	                    $('#family').val(s7);
	                } else if(index==3){
	                	$('#research .family2 .chk').removeClass('checked');
	                	$(this).addClass('checked');
	                	s8= $(this).attr('value');
	                    $('#family').val(s8);
	                }*/
	            }
	            
	        })
    })


	$('#research .isnew2 .chk').each(function(index){
	        var s9= '是';
	        var s10= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s9= '';
	                } else {
	                    s10= '';
	                }

	            } else {
	            	$('#research .isnew2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s9= $(this).attr('value');
	                    $('#isnew').val(s9);                    
	                } else {
	                    s10= $(this).attr('value');
	                    $('#isnew').val(s10);
	                }

	            }

	        })
    })


	$('#research .issmoke2 .chk').each(function(index){
	        var s11= '是';
	        var s12= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s11= '';
	                } else {
	                    s12= '';
	                }

	            } else {
	            	$('#research .issmoke2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s11= $(this).attr('value');
	                    $('#issmoke').val(s11);                    
	                } else {
	                    s12= $(this).attr('value');
	                    $('#issmoke').val(s12);
	                }

	            }

	        })
    })

	$('#research .isill2 .chk').each(function(index){
	        var s13= '是';
	        var s14= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s13= '';
	                } else {
	                    s14= '';
	                }

	            } else {
	            	$('#research .isill2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s13= $(this).attr('value');
	                    $('#isill').val(s13);                    
	                } else {
	                    s14= $(this).attr('value');
	                    $('#isill').val(s14);
	                }

	            }

	        })
    })


	$('#research .ispain2 .chk').each(function(index){
	        var s15= '是';
	        var s16= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s15= '';
	                } else {
	                    s16= '';
	                }

	            } else {
	            	$('#research .ispain2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s15= $(this).attr('value');
	                    $('#ispain').val(s15);                    
	                } else {
	                    s16= $(this).attr('value');
	                    $('#ispain').val(s16);
	                }

	            }

	        })
    })


	$('#research .ispat2 .chk').each(function(index){
	        var s17= '是';
	        var s18= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s17= '';
	                } else {
	                    s18= '';
	                }

	            } else {
	            	$('#research .ispat2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s17= $(this).attr('value');
	                    $('#ispat').val(s17);                    
	                } else {
	                    s18= $(this).attr('value');
	                    $('#ispat').val(s18);
	                }

	            }

	        })
    })
    

    $('#research .isuse2 .chk').each(function(index){
        var s19= '是';
        var s20= '否';
        $(this).click(function(){
            if($(this).hasClass('checked')){

            	$(this).removeClass('checked');
            	if(index==0){
                    s19= '';
                } else {
                    s20= '';
                }

            } else {
            	$('#research .isuse2 .chk').removeClass('checked');
            	$(this).addClass('checked');
                if(index==0){
                    s19= $(this).attr('value');
                    $('#isuse').val(s19);                    
                } else {
                    s20= $(this).attr('value');
                    $('#isuse').val(s20);
                }

            }

        })
    })

    $('#research .isbuy2 .chk').each(function(index){
	        var s21= '是';
	        var s22= '否';
	        $(this).click(function(){
	            if($(this).hasClass('checked')){

	            	$(this).removeClass('checked');
	            	if(index==0){
	                    s21= '';
	                } else {
	                    s22= '';
	                }

	            } else {
	            	$('#research .isbuy2 .chk').removeClass('checked');
	            	$(this).addClass('checked');
	                if(index==0){
	                    s21= $(this).attr('value');
	                    $('#isbuy').val(s21);                    
	                } else {
	                    s22= $(this).attr('value');
	                    $('#isbuy').val(s22);
	                }

	            }

	        })
    })




    //预约报名信息
    $('.sure').click(function(){
        //报名信息1
        var isdes = returnVal('isdes');
        var name = returnVal('name');
        var tel = returnVal('tel');
        var province = returnVal('province');
        var city = $(".city").eq(currentShowCity).val();
        var address = returnVal('address');
        if(checkForm(isdes,name,tel,province,city,address)){
            $.ajax({
            	async:false,
                url: 'server.php',
                data:{act:'addinfo',name:name,phone:tel,province:province,city:city,address:address,isNew:isdes},
                type: "post",
                dataType:'json',
                success:function(result){
                    if(result.errcode != 0){
						alert(result.errmsg);
	                }else{
                        alert(result.errmsg);
                    }
                }
            });
            
        }
    });


    //return value
    function returnVal(id){
        return $('#'+id).attr('value');
	}


	// 预约验证表单
    function checkForm(isdes,name,tel,province,city,address){
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        var telp = /^0\d{2,3}-?\d{7,8}$/;
        //判断收货人是否为空

        if(isdes == ""){
           alert("请选择是否新装修！");
           return false;
        }

        if(name == ""){
           alert("请输入姓名！");
           return false;
        }
        //判断电话格式
        if(tel == ""){
            alert("请输入电话！");
            return false;
        }else if(!telp.test(tel) && !mob.test(tel)){
            alert("请输入正确的电话！");
            return false;
        }
        
        if(province == "----请选择----"){
            alert("请选择省份！");
            return false;
        }

        //判断地址
        if(address == ""){
            alert("请输入详细地址！");
            return false;
        }
        return true;
    }




    //提交活动报名信息
    $('.send').click(function(){
        //复选框
        var family ="";
        $('.family2 .checked').each(function(){
        	if(family == ""){
        		family += $(this).attr("value");
        	}else{
        		family += ","+$(this).attr("value");
        	}
        	
        });

        //报名信息2
        var name2= returnVal('name2');
        var tel2= returnVal('tel2');
        var sex=returnVal('sex');
		var age= returnVal('age');
        var province2 = returnVal('province2');
        var city2 = $(".city2").eq(currentShowCity2).val();
        var address2 = returnVal('address2');
		var isnew = returnVal('isnew');
        var issmoke = returnVal('issmoke');
        var isill= returnVal('isill');
        var ispain= returnVal('ispain');
        var ispat= returnVal('ispat');
        var isuse= returnVal('isuse');
        var isbuy = returnVal('isbuy');
        
       
        if(checkForm_2(name2,tel2,sex,age,province2,city2,address2,isnew,issmoke,isill,ispain,ispain,ispat,isuse,isbuy)){
             $.ajax({
                 async:false,
                 url:'server.php',
                 data:{act:'addsurvey',name:name2,phone:tel2,gender:sex,age:age,province:province2,city:city2,address:address2,isNew:isnew,smoke:issmoke,family:family,sick:isill,allergy:ispain,pet:ispat,air:isuse,buy:isbuy},
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
            
        }
    })
    /*********************函数***************/
    //return value
    // function returnVal(id){
    //     return $('#'+id).attr('value');
    // }
    // 验证表单
    function checkForm_2(name2,tel2,sex,age,province2,city2,address2,isnew,issmoke,isill,ispain,ispat,isuse,isbuy){
        var mob = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/;
        var telp = /^0\d{2,3}-?\d{7,8}$/;
        //判断收货人是否为空
        if(name2 == ""){
           alert("请输入姓名！");
           return false;
        }
        if(sex == ""){
           alert("请选择性别！");
           return false;
        }
        //判断电话格式
        if(tel2 == ""){
            alert("请输入电话！");
            return false;
        }else if(!telp.test(tel2) && !mob.test(tel2)){
            alert("请输入正确的电话！");
            return false;
        }
        if(province2 == "----请选择----"){
            alert("请填写省份！");
            return false;
        }       
        if(address2 == ""){
            alert("请填写详细地址！");
            return false;
        }
        if(family== ""){
            alert("请判断家庭成员组成！");
            return false;
        }
        if(isnew== ""){
            alert("请判断是否新装修！");
            return false;
        }
        if(issmoke== ""){
            alert("请判断家里是否有人吸烟！");
            return false;
        }
        if(isill == ""){
            alert("请判断家里是否有呼吸疾病人员！");
            return false;
        }
        if(ispat == ""){
            alert("请判断家里是否有宠物！");
            return false;
        }
        if(isuse == ""){
            alert("请判断是否使用过空气净化器！");
            return false;
        }
        if(isbuy == ""){
            alert("请判断是否想过购买空气净化器");
            return false;
        }
        return true;
    }   


</script>
	    <!--#include virtual="/public/head.html"-->
        <!--#include virtual="/public/tongji.html"-->
        <!--#include virtual="/public/footer.html"-->
</body>
</html>