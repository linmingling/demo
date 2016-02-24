<?php
	require_once "../data/jssdk.php";
	$jssdk = new JSSDK();
	$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	    <meta charset="UTF-8">
	    <!-- <meta name="viewport" content="target-densitydpi=device-dpi,width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" /> -->
	    <meta content="target-densitydpi=device-dpi,width=640,user-scalable=no" name="viewport">
	    <title>红星美凯龙大牌之夜活动</title>
	    <meta name="author" content="腾讯亚太家居">
	    <meta name="Copyright" content="腾讯亚太家居">
	    <meta name="format-detection" content="email=no,address=no,telephone=no">
	    <link rel="stylesheet" type="text/css" href="css/css.css">
  </head>
  <body ontouchstart="" style="visibility: visible; opacity: 1;">
    <section class="bd">
      <header class="live-header">
      	<section class="header title">红星美凯龙大牌之夜活动<span>直播</span></section>
      </header>
      <!--
	      <div style="text-align: right;font-size: 24px;  margin-right: 5%;color:#5291d2">
	      	<span class="tip">直播</span>
	      	<span class="time">60</span> 秒后自动刷新
	      </div>
      -->
      <section class="live-warp">
        <section class="live-bd">
          <!-- 事件列表 -->
          <section class="live-list">
	          <!-- <article class="live-list-item">
	          	<div class="list-item-time">
	          		<div class="item-time-date">3月16日</div>
	          		<div class="item-time-time">
		          		<div class="time-detail">15:03</div>
		          		<div class="time-dot"></div>
	          		</div>
	          	</div>
	          	<div class="list-item-bd">
	          		<div class="list-item-content fix-break-word">
	          		    <p class="c-blue">[直播员]网易直播员</p>
	          		                      发布会环节到此结束，小编祝大家睡得好，天天喜临门！附上2015喜临门中国睡眠指数在网易的下载地址：http://file.ws.126.net/home/2015/shuimian.pdf
	          		</div>
	          	</div>
	         </article> -->
         </section>
      	</section>
    </section>
    </section>
	<script src="js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript">
      $(function(){
/*     	  var times = 60,i = 1;
		  setInterval(function(){
	 			if (i < times) {
	 				$('.time').html(times - i);
	 				i++;
	 			} else {
	 				$('.time').html(times);
	 				i= 1;
	 			}
			},1000); */
    	  ajax();
    	 /*  setInterval(ajax,10000); */
    	  function ajax(){
    		  $.ajax({
    	  			async:false,
    	  		 	url: 'server.php',
    	  		 	data: {act:'ajax_list'},
    	  		 	type: 'post',
    	  		 	dataType:'json',
    	  		 	success:function(result){
    	  		 		var info_list = result;
    	  		 		if(info_list){
    	  		 			$(".live-list").empty();
    	  					for(var j=0;j<info_list.length;j++){
    							$(".live-list").append(
    								'<article class="live-list-item">'+
    						          	'<div class="list-item-time">'+
    						          		'<div class="item-time-date">'+info_list[j]['md_time']+'</div>'+
    						          		'<div class="item-time-time">'+
    							          		'<div class="time-detail">'+info_list[j]['hi_time']+'</div>'+
    							          		'<div class="time-dot"></div>'+
    						          		'</div>'+
    					          		'</div>'+
    					          		'<div class="list-item-bd">'+
    					          			'<div class="list-item-content fix-break-word">'+
    					          		    	'<p class="c-blue">'+info_list[j]['title']+'</p>'+
    					          		    		info_list[j]['text']
    					          			+'</div>'+
    					          		'</div>'+
    					         	'</article>'
    					         );
    	  					}
    	  				}
    	  		 	}
    	  		});
    	  }
  	})
    </script>
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
	        'checkJsApi',
	        'onMenuShareTimeline',
	        'onMenuShareAppMessage',
	        'onMenuShareQQ',
	        'onMenuShareWeibo'
	      ]
	  });
	wx.ready(function () {
		var wxData = {
			"imgUrl":'http://zt.jia360.com/mkl_live/images/logo.png',
			"link":'http://zt.jia360.com/mkl_live/index.php',
			"desc":"百大品牌，击穿低价，红星美凯龙“两天来了”大牌之夜",
			"title":"腾讯亚太家居微直播：红星美凯龙大牌之夜活动 "
		};
		wx.onMenuShareAppMessage(wxData);
		wx.onMenuShareTimeline(wxData);
	});
	</script>
    <!--#include virtual="/public/tongji.html"-->
</body>
</html>