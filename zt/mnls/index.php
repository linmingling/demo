<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
//中奖名单
$draw_sql = "select id,phone,prize from mnls where prize>0 and phone>0 order by add_strtotime desc limit 8";
$draw_res = mysqli_query($db,$draw_sql);
$draw_rows = array();
while($draw_row = $draw_res->fetch_assoc())
{
    $draw_rows[$draw_row['id']]['phone'] = mb_substr($draw_row['phone'],0,3) . "****" . mb_substr($draw_row['phone'],-4);
    if($draw_row['prize'] == 1)
    {
        $draw_rows[$draw_row['id']]['msg'] = '四等奖';
    }
    else
    {
        $draw_rows[$draw_row['id']]['msg'] = '三等奖';
    }
    
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="front-end technicist" content="jinger" />
	<title>蒙娜丽莎第7届微笑节</title>
	<meta name="keywords" content="蒙娜丽莎第7届微笑节">
	<meta name="description" content="蒙娜丽莎第7届微笑节">
	<meta name="front-end technicist" content="jinger">
	<link type="text/css" rel="stylesheet" href="css/layout.css?vid=1.2" media="all" />
	<link type="text/css" rel="stylesheet" href="css/jquery.mobile-1.4.2.min.css" media="all" />

	<!-- <link type="text/css" rel="stylesheet" href="css/swiper.min.css" media="all" /> -->
	<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="js/jquery.mobile-1.4.2.min.js"></script>
 </head>

 <body>
 	<!-- 导航等组件可以放在container之外 -->
 	<div class="nav" >
 		<a id="btn1" data-transition="slide" href="#di1" >
 			<div style="margin-left:20px"><img src="images/title1.png"  width="100%" height="100%"></div>
 		</a>
 		<a id="btn2" data-transition="slide" href="#di2">
 			<div style="margin-left:10px"><img src="images/title2.png"  width="100%" height="100%"></div>
 		</a>
 		<a id="btn3" data-transition="slide" href="#di3">
 			<div style="margin-left:265px"><img src="images/title3.png"  width="100%" height="100%"></div>
 		</a>
 		<a id="btn4" data-transition="slide" href="#di4">
 			<div style="margin-left:10px"><img src="images/title4.png"  width="100%" height="100%"></div>
 		</a>
 	</div>
 	<div class="yun1">
		<img src="images/yun1.png">
	</div> 
	<div class="yun2">
		
	</div>
	<div class="left">
		<a href="javascript:void(0);" onclick="qie('left')" id="left" data-transition="slide"><img src="images/left.png"></a>
	</div>
	<div class="right">
		<a href="javascript:void(0);" onclick="qie('right')" id="right" data-transition="slide"><img src="images/right.png"></a>
	</div>
		<div class="box1-qrcode"><img src="images/qrcode.png"></div>

	        <div class="main" zdy="1" data-role="page" id="di1">
				<div class="box1-bg">
					<div class="box1-content"><img src="images/box1-bg.png"></div>
					<a class="box1-btn"  href="#di2" data-transition="slide"><img src="images/btn1.png"></a>
				</div>
	        </div>

	        <div class="main" zdy="2" data-role="page" id="di2">
	        	<div class="box2-bg">
	        		<div class="box2-up">
	        			<div class="box2-up-left">
	        				<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html" target="_blank"><img src="images/box2-tb1.png"></a>
	        			</div>
	        			<div class="box2-up-right">
	        				<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html" target="_blank"><img src="images/box2-tb2.png"></a>
	        			</div>
	        		</div>
	        		<div class="box2-down">
	        			<div class="box2-down-left">
	        				<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html" target="_blank"><img src="images/box2-tb4.png"></a>
	        			</div>

	        			<div class="box2-down-middle">
	        				<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html" target="_blank"><img src="images/box2-tb3.png"></a>
	        			</div>
	        			<div class="box2-down-right">
	        				<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html" target="_blank"><img src="images/box2-tb5.png"></a>
	        			</div>
	        		</div>
	        	</div>

			
	        </div>
	        <div class="main" zdy="3" data-role="page" id="di3">
	        	<div class="box3-bg">
	        	<!-- 中奖名单处 -->
		        	<div class="box3-left">
		        		<div class="box3-zj" style="width:330px;height:27px">
		        			<p id="lb" ></p>
		        		</div>
		        		<div class="box3-gz font14">

		        			<div class="box3-yuan"><span style="padding-left: 10px;">1</span></div>
		        			<div style="height: 26px;">不能重复中奖</div>

		        			<div class="box3-yuan"><span style="padding-left: 10px;">2</span></div>
		        			<div style="height: 26px;">获奖者需填写有效地址、收件人等联系信息，否则无效</div>

		        			<div class="box3-yuan"><span style="padding-left: 10px;">3</span></div>
		        			<div style="height: 26px;">所有奖品于活动结束后（8月31日）15个工作日内发放</div>
		        		</div>
	        		</div>
	        		<div class="box3-right">
	        			<div class="box3-zp">
	        				<div class="box3-zd">
	        					<a id="zd"><img src="images/zd.png" id="zdpic"></a>
	        				</div>
	        			</div>
	        		</div>
	        		<div class="box3-cs">
	        			<p style="padding-left:20px;padding-top:5px">您还有</p>
	        			<p><span class="box3-s" id="cs">3</span>次机会</p>
	        		</div>
	        	</div>
	        </div>
	        <div class="main" zdy="4" data-role="page" id="di4">
	        	<div class="box4-bg">
		        	<div class="box4-cn-1">
		        		<div class="box4-content" style="padding-left: 100px;">
		        			<div class="font18 green">
		        				<a href="http://www.jia360.com/cizhuan/20150730/1438225434726.html" target="_blank">首届蒙娜丽莎瓷砖微笑节业主旅游团畅游佛山</a>
		        			</div>
		        			<div class="box4-content font14">
		        				<p>10月16至19日，来自全国各地的十余名在“</p>
		        				<p>首届蒙娜丽莎微笑节”活动中获奖的蒙娜丽莎</p>
		        				<p>瓷砖消费者齐聚南国名城...<a href="http://www.jia360.com/cizhuan/20150730/1438225434726.html" target="_blank" class="box4-btn"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
		        		<div class="box4-content" style="padding-left: 80px;">
		        			<div class="font18 green">
		        				<a href="http://www.jia360.com/cizhuan/20150730/1438226729506.html" target="_blank">第六届蒙娜丽莎微笑节激情绽放</a>
		        			</div>
		        			<div class="box4-content font14">
		        				<p>从8月8日到8月28日，蒙娜丽莎瓷砖掀起年度力</p>
		        				<p>度最大、跨度最长的促销狂欢季。一张张清凉绿</p>
		        				<p>色的海报铺天盖地铺满全国...<a href="http://www.jia360.com/cizhuan/20150730/1438226729506.html" target="_blank" class="box4-btn" style="padding-left: 10px;"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
	        		</div>
	        		<div class="box4-cn-2">
		        		<div class="box4-content" style="padding-left: 100px;">
		        			<a href="http://www.jia360.com/cizhuan/20150730/1438224785263.html" target="_blank" class="font18 green" >
		        				<p class="font18 jiacu">蒙娜丽莎第二届微笑节激情启动，</p>
								<p class="font18 jiacu">千家专卖店巡展世博会</p>
		        			</a>
		        			<div class="box4-content font14">
		        				<p>2010年8月，作为世博会特许生产商的蒙娜丽莎</p>
		        				<p>瓷砖启动“第二届蒙娜丽莎微笑节”。 作为建</p>
		        				<p>筑陶瓷行业惟一的世博特许...<a href="http://www.jia360.com/cizhuan/20150730/1438224785263.html" target="_blank" class="box4-btn" style="padding-left: 22px;"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
		        		<div class="box4-content" style="padding-left: 80px;">
		        			<div class="font18 green">
		        				<a href="http://www.jia360.com/cizhuan/20150730/1438225939175.html" target="_blank">激情八月，第五届蒙娜丽莎微笑节火热上演</a>
		        			</div>
		        			<div class="box4-content font14">
		        				<p>至8月初连续召开了微笑节活动政策传达、各项</p>
		        				<p>活动得失总结分析、优秀导购经验分享、优秀</p>
		        				<p>门市及人员表彰等。随着各项前期活动的有效</p>
		        				<p>开展，不仅充分磨练...<a href="http://www.jia360.com/cizhuan/20150730/1438225939175.html" target="_blank" class="box4-btn" style="padding-left: 50px;"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
	        		</div>
	        		<div class="box4-cn-3">
		        		<div class="box4-content" style="padding-left: 100px;">
		        			<div class="font18 green">
		        				<a href="http://www.jia360.com/cizhuan/20150730/1438225034664.html" target="_blank">二十载真情绽放，第三届蒙娜丽莎微笑节</a>
		        			</div>
		        			<div class="box4-content font14">
		        				<p>第三届蒙娜丽莎微笑节8月13日正式开启，超值</p>
		        				<p>优惠全国同步上演！在相对低迷的市场态势下</p>
		        				<p>，蒙娜丽莎促销狂潮清凉而至...<a href="http://www.jia360.com/cizhuan/20150730/1438225034664.html" target="_blank" class="box4-btn" style="padding-left: 10px;"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
		        		<div class="box4-content" style="padding-left: 80px;">
		        			<div class="font18 green">
		        				<a href="http://www.jia360.com/cizhuan/20150730/1438223544765.html" target="_blank">8.28微笑绽放 第四届蒙娜丽莎微笑节如期启动</a>
		        			</div>
		        			<div class="box4-content font14">
		        				<p>第四届蒙娜丽莎微笑节8月11日正式开启，超</p>
		        				<p>值优惠全国同步上演，购砖免单疯狂再现！市</p>
		        				<p>场冷清、行业艰难...<a href="http://www.jia360.com/cizhuan/20150730/1438223544765.html" target="_blank" class="box4-btn" style="padding-left: 65px;"><img src="images/btn4.png"></a></p>
		        			</div>
		        		</div>
	        		</div>
	        	</div>
	        </div>
	   

	<div id="bg"></div>
     <!-- 弹出窗1 Start -->
      <div class="popContent" id="popID"> 
          <div class="poptitle">
          	<p class="pink jiacu" style="float:left">
          	<font class="green" style="padding-left: 120px;">蒙娜丽莎</font>第7届微笑节促销</p>
          	<a href="javascript:void(0);" id="close">
          		<img src="images/box1-close.png" style="padding-left: 80px; padding-top: 15px;">
          	</a>
          </div>
          <div style="position: absolute;">
	          <div style="float:left">
	          	<div class="con1-t"><p style="margin-top: -8px;">1</p></div>
	          	<div class="con1-c">
		          	<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html"  target="_blank" class="pink font18 jiacu">20户疯狂免单大奖</a>
					<p class="green font14">活动期间，买砖即抽奖，赢取20户最高</p>
					<p class="green font14">价值4999元的免单大奖。</p>
	          	</div>
	          	<div class="con1-t"><p style="margin-top: -8px;">4</p></div>
	          	<div class="con1-c">
		          	<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html"  target="_blank" class="pink font18 jiacu">凭微分卡领小地砖</a>
					<p class="green font14">活动期间，微笑粉丝有福利，进店预交</p>
					<p class="green font14">诚意金即可获赠“微粉卡”，凭卡购</p>
					<p class="green font14">2015新品领小地砖，数量有限。</p>
	          	</div>
	          </div>
	          <div style="float:left;padding-top:0px">
	          	<div class="con1-t" style="margin-top: -20px;"><p style="margin-top: -8px;">2</p></div>
	          	<div class="con1-c" style="margin-top: -20px;">
		          	<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html"  target="_blank" class="pink font18 jiacu">20户免费旅游大奖</a>
					<p class="green font14">活动期间，购砖即有机会获得免费欧洲</p>
					<p class="green font14">旅游大奖，带您“装”家带您飞！</p>
	          	</div>
	          	<div class="con1-t"><p style="margin-top: -8px;">5</p></div>
	          	<div class="con1-c">
		          	<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html"  target="_blank" class="pink font18 jiacu">买得越多，返现越多</a>
					<p class="green font14">活动期间，百万返现基金，微笑传万家！</p>
					<p class="green font14">买得越多，返得越多，你还在等什么，快</p>
					<p class="green font14">来抢购吧！</p>
	          	</div>
	          </div>
	          <div style="float:left;padding-top:0px">
	          	<div class="con1-t" style="margin-top: -40px;"><p style="margin-top: -8px;">3</p></div>
	          	<div class="con1-c" style="margin-top: -40px;">
		          	<a href="http://www.jia360.com/cizhuan/20150730/1438251091838.html"  target="_blank" class="pink font18 jiacu">“刮出”iPhone6S</a>
					<p class="green font14">活动期间，凡到店用微信扫码关注“蒙</p>
					<p class="green font14">娜丽莎集团”公众号即可参与抽奖活动</p>
					<p class="green font14">，”壕礼”笑迎您光临！</p>
	          	</div>

	          	<div class="con2-t" style="margin-top: 0px;"><p style="margin-top: -8px;"></p></div>
	          	<div class="con1-c" style="margin-top: 0px;">
		          	<p class="green font14">更多优惠详情请莅临蒙娜丽莎全国专卖店，</p>
					<div><p class="green font14" style="float:left">或</p>
						<a href="http://www.monalisa.com.cn"  target="_blank"><img src="images/btn2.png"></a>
					</div>
	          	</div>
	          </div>
          </div>
      </div>

      <!-- 弹出框2 -->
      <div class="popContent2" id="popID2">
		 <div class="close2">
		 	<a href="javascript:void(0);" id="close2"><img src="images/box1-close.png" ></a>
		 </div>	
      </div>

      <!-- 弹出框无抽奖机会的 -->
      <div class="popcj1" id="cjw">
	 	<div class="poptitle"><p class="pink jiacu">提&nbsp;&nbsp;&nbsp;&nbsp;示</p></div>
	 	<div class="popcon1 pink" id="popconw">
	 		
			
	 	</div>
	 	<div>
	 		<img id="cjw-img">
	 	</div>
	 	<div class="popbtn">
	 		<p class="white" id="cjw_close">确定</p>
	 	</div>
      </div>
	
	  <!-- 弹出框抽奖未中奖 -->
      <div class="popcj" id="cj">
	 	<div class="poptitle"><p class="pink jiacu">提&nbsp;&nbsp;&nbsp;&nbsp;示</p></div>
	 	<div class="popcon pink">
	 		<p>哎呀！与大奖擦肩而过，</p>
			<p>感谢您对第七届蒙娜丽莎微笑节的支持！</p>
	 	</div>
	 	<div>
	 		<img src="images/qrcode2.jpg">
	 	</div>
	 	<div class="popbtn">
	 		<p class="white" id="cj_close">确定</p>
	 	</div>
      </div>

      <!-- 弹出框抽奖1 -->
      <div class="popcj1" id="cj1">
	 	<div class="poptitle"><p class="pink jiacu">提&nbsp;&nbsp;&nbsp;&nbsp;示</p></div>
	 	<div class="popcon1 pink" id="popcon1">
	 		
			
	 	</div>
	 	<div>
	 		<img id="cj1-img">
	 	</div>
	 	<div class="popbtn">
	 		<p class="white" id="cj1_close">确定</p>
	 	</div>
      </div>

      <!-- 弹出框抽奖2 -->
      <div class="popcj2" id="cj2">
	 	<div class="poptitle"><p class="pink jiacu">填写信息</p></div>
	 	<div class="popcon2 pink">
	 		<table  border="0" cellspacing="0" cellpadding="0">	
				<tr>
				    <td style="width:70px;height:45px">收件人</td>
				    <td><input type="text" class="text-bg" id="name"></td>
				</tr>
				<tr>
				    <td style="width:70px;height:45px">联系电话</td>
				    <td><input type="text" class="text-bg" id="phone"></td>
				</tr>
				<tr>
				    <td style="width:70px;height:45px">联系地址</td>
				    <td><input type="text" class="text-bg" id="address"></td>
				</tr>
				
			</table> 
	 	</div>
	 	<div style="visibility: hidden;" id="cj2_hid"><p style="font-size: 16px;">您已重复提交信息，不能重复中奖</p></div>
	 	<div class="popbtn2">
	 		<a class="white" id="cj2_close" href="javascript:void(0);">确定</a>
	 	</div>
      </div>

      <!-- 弹出框抽奖3 -->
      <div class="popcj3" id="cj3">
	 	<div class="poptitle"><p class="pink jiacu">提&nbsp;&nbsp;&nbsp;&nbsp;示</p></div>
	 	<div class="popcon3 pink">
	 		<p>感谢参与！</p>
			<p>我们到时候会有专人通知您的了！</p>
	 	</div>
	 	<div>
	 		<img src="images/lian1.png">
	 	</div>
	 	<div class="popbtn">
	 		<a href="javascript:void(0);" id="cj3_close" class="white">我知道了</a>
	 	</div>
  	  </div>
	
   
	 <!-- <script type="text/javascript" src="js/swiper.min.js"></script>-->
	<script type="text/javascript" src="js/awardRotate.js"></script>
	<script type="text/javascript" src="js/my.js"></script>
	<script type="text/javascript">
	$(function(){
		//$(".foot_zt").css('padding-top','918px');
		$(".foot_zt").css({"position":"absolute","top":"918px","min-width":"1500px"});

		// var s=window.location.href;
		// if(s.indexOf('#')<0){
		// 	myinit();
		// }
		setInterval(function(){ 
			var zdy=$('.ui-page-active').attr('zdy');
			jk('di'+zdy);
		},500);

		setInterval(lb,2000); 
		  var array = new Array(); 
		  var index = 0;
                           
		  var mingdan="<?php foreach($draw_rows as $k=>$v){ ?><?php  echo $v['phone'];?>  <?php  echo $v['msg'].';';?><?php } ?>";
		  //mingdan=mingdan.substring(0,mingdan.length-1);
		  var array = mingdan.split(';'); //中奖名单轮播
		  function lb() { 
		   var my=$("#lb"); 
		   if(index==array.length-1) 
		   { 
		   	index=1; 
		   }else{
		    index++;
		   } 
		  	my.text(array[index-1]); 
		 } 
	 
	});
	
	function myinit(){
		var popID=$("#popID");
		var close=$("#close");
        var _bg = $("#bg");

        	_bg.fadeIn();
        	popID.fadeIn();

        	close.click(function(){
	            _bg.fadeOut();
	            popID.fadeOut();
			});
	}
	function qie(type){
		var number=$('.ui-page-active').attr('zdy');
		if(type=='left'){
			var href=parseInt(number)-1;
			if(href<1){
				$("#left").attr('href','#di4');
			}
			else{
				$("#left").attr('href','#di'+href);
			}
		}
		else{
			var href=parseInt(number)+1;
			if(href<5){
				$("#right").attr('href','#di'+href);
			}
			else{
				$("#right").attr('href','#di1');
			}
		}
	}
	function jk(type){
		switch(type){
			case 'di1':
				$('#btn1').find('img').attr('src','images/title1-hover.png');
				$('#btn2').find('img').attr('src','images/title2.png');
				$('#btn3').find('img').attr('src','images/title3.png');
				$('#btn4').find('img').attr('src','images/title4.png');
				break;
			case 'di2':
				$('#btn1').find('img').attr('src','images/title1.png');
				$('#btn2').find('img').attr('src','images/title2-hover.png');
				$('#btn3').find('img').attr('src','images/title3.png');
				$('#btn4').find('img').attr('src','images/title4.png');
				break;
			case 'di3':
				$('#btn1').find('img').attr('src','images/title1.png');
				$('#btn2').find('img').attr('src','images/title2.png');
				$('#btn3').find('img').attr('src','images/title3-hover.png');
				$('#btn4').find('img').attr('src','images/title4.png');
				break;
			default:
				$('#btn1').find('img').attr('src','images/title1.png');
				$('#btn2').find('img').attr('src','images/title2.png');
				$('#btn3').find('img').attr('src','images/title3.png');
				$('#btn4').find('img').attr('src','images/title4-hover.png');
		}
	}
	</script>

	<!-- 转盘 -->
	<script type="text/javascript">
		$(function(){
		    var _zd = $('#zd');
		    var _zdpic=$('#zdpic');
			var count=3;
			var vv=true;
		    _zd.bind("click",function(){
		    	if(vv){
		    	if(count<1){
		    		tan1(9999,'<p>您的次数用完了，</p><p>刷新再来吧！</p>');
		    		return;
		    	}
				//此处是概率

                $.ajax({
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
								case 1: 
                                    rotateFunc(4,0,'恭喜你获得四等奖！');
                                    count=count-1;
                                    break;
                                case 2: 
                                    rotateFunc(0,45,'');
                                    count=count-1;
                                    break;
                                case 3: 
                                    rotateFunc(3,90,'恭喜你获得三等奖！');
                                    count=count-1;
                                    break;
                                case 4: 
                                    rotateFunc(0,135,'');
                                    count=count-1;
                                    break;
                                case 5: 
                                    rotateFunc(2,180,'恭喜你获得二等奖！');
                                    count=count-1;
                                    break;
                                case 6: 
                                    rotateFunc(0,225,'');
                                    count=count-1;
                                    break;
                                case 7: 
                                    rotateFunc(1,270,'恭喜你获得一等奖！');
                                    count=count-1;
                                    break;
                                default:
                                    rotateFunc(0,315,'');
                                    count=count-1;
							}
                            $("#cs").text(count);

                        }
	                }
	            });
	            


	            vv=false;
				
		       }
		        
		    });

		    setInterval(function(){ 
					vv=true;
				},3000);

		    var rotateFunc = function(awards,angle,text){  //awards:奖项，angle:奖项对应的角度
		        _zdpic.stopRotate();
		        _zdpic.rotate({
		            angle: 0,
		            duration: 5000,
		            animateTo: angle + 1440,  //angle是图片上各奖项对应的角度，1440是让指针固定旋转4圈
		            callback: function(){
		            	if(awards==0){
		            		tan();
		            	}
		            	else{
		            		tan1(awards,text);
		            	}
		            }
		        });
		    };

		    
		});
		function tan(){
			//未中奖
			var _cj=$("#cj");
        	var _bg = $("#bg");
        	var _colse=$("#cj_close");

        	_bg.fadeIn();
        	_cj.fadeIn();

        	_colse.click(function(){
	            _bg.fadeOut();
	            _cj.fadeOut();
			});
		}

		function tan1(awards,con){
        	var _bg = $("#bg");
        	if (awards==9999){//无次数
        		var _cjw=$("#cjw");
    			var _colse=$("#cjw_close");
        		var _cj1img=$("#cjw-img");
        		_cj1img.attr('src','images/lian2.png');
        		_bg.fadeIn();
	        	_cjw.fadeIn();
	        	$("#popconw").html(con);

	        	_colse.click(function(){
		            _cjw.fadeOut();
		            _bg.fadeOut();
				});

        	}
    		else{//中奖
    			var _cj1=$("#cj1");
    			var _colse=$("#cj1_close");
        		var _cj1img=$("#cj1-img");
    			_cj1img.attr('src','images/lian1.png');
    			_bg.fadeIn();
	        	_cj1.fadeIn();
	        	$("#popcon1").html(con);

	        	_colse.click(function(){
		            _cj1.fadeOut();
		            $("#cj2").fadeIn();
				});
    		}
        	
		};
		//这里是提交信息
		$("#cj2_close").click(function(){
			var _bg = $("#bg");
			if($("#cj2_hid").css('visibility')=='visible'){
				_bg.fadeOut();
				$("#cj2").fadeOut();
				return;
			}

            var name = $("#name").val();
			var phone = $("#phone").val();
			var address = $("#address").val();
            
            $.ajax({
                async:false,
                url: 'server.php',
                data:{act:'addinfo',name:name,phone:phone,address:address},
                type: "post",
                dataType:'json',
                success:function(result){
                    //数据返回后执行
                    if(result.errcode != 0){
                        alert(result.errmsg);
                        //$("#cj2_hid").css('visibility','visible');
                        return false;
                    }else{
                        alert(result.errmsg);
                        $("#cj2").fadeOut();
				        $("#cj3").fadeIn();
                        return false;
                    }
                    
                }
            });

			
		});

		$("#cj3_close").click(function(){
			var _bg = $("#bg");
			$("#cj3").fadeOut();
			_bg.fadeOut();
			
		})
	</script>


	<script type="text/javascript">
		var Width=document.body.clientWidth-360+'px';
		var Width2=document.body.clientWidth-100+'px';
		//alert(window.screen.width);
		// $(".yun2").css('left',Width);
		// $(".right").css('margin-left',Width2);

		$("#close").click(function(){
			var _bg = $("#bg");
            var _popWin = $("#popID");

            _bg.fadeOut();
            _popWin.fadeOut();
		});
		function box2tan(type){
			var _bg = $("#bg");
            var _popWin = $("#popID2");
            var _closeBtnB=$("#close2");
            switch(type){
            	case '1':
            		_popWin.css('background-image','url(images/box2-tc1.png)');
            	break;
            	case '2':
            		_popWin.css('background-image','url(images/box2-tc2.png)');
            	break;
            	case '3':
            		_popWin.css('background-image','url(images/box2-tc3.png)');
            	break;
            	case '4':
            		_popWin.css('background-image','url(images/box2-tc4.png)');
            	break;
            	case '5':
            		_popWin.css('background-image','url(images/box2-tc5.png)');
            	break;
            	default:
            		alert('未知错误');
            }
            

            _bg.fadeIn();
            _popWin.fadeIn();


            _closeBtnB
            .bind("click",function(){
                _bg.fadeOut();
            	_popWin.fadeOut();
            });
            



		}
	</script>

<!--#include virtual="/public/head.html"-->
	<!--#include virtual="/public/footer.html"-->
	<!--#include virtual="/public/tongji.html"-->
	<script type="text/javascript">
	setInterval(function(){ 
		$("#topNav").css('top','0');
	});
	</script>

	
  	
 </body>
</html>
