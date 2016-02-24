<?php
// $db = mysqli_connect("localhost","root","") or die("Error");
$db = mysqli_connect("121.40.146.108","test_user","test!@#") or die("Error");
mysqli_select_db($db, "qm");

$sql = "SELECT id,img_url,filename,clicks FROM qm_list ORDER BY id DESC";
$url = mysqli_query($db, $sql);

while($list = mysqli_fetch_array($url)){
	$url_arr[] = $list;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>曲美家居-我的圣诞我做主&gt;&gt;腾讯网亚太家居_腾讯家居</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css"  href="css/style.css"  />
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://mat1.gtimg.com/app/vt/js/read/import.js" charset="utf-8"></script>
<link rel="stylesheet" href="./kindeditor/themes/default/default.css" />
<!-- <script src="./kindeditor/kindeditor.js"></script>
<script src="./kindeditor/lang/zh_CN.js"></script> -->
<script src="./kindeditor/kindeditor-min.js"></script>
<script type="text/javascript">
window.onload = function () {
	var oBtnLeft = document.getElementById("goleft");
	var oBtnRight = document.getElementById("goright");
	var oDiv = document.getElementById("indexmaindiv");
	var oDiv1 = document.getElementById("maindiv1");
	var oUl = oDiv.getElementsByTagName("ul")[0];
	var aLi = oUl.getElementsByTagName("li");
	var now = -5 * (aLi[0].offsetWidth + 13);
	oUl.style.width = aLi.length * (aLi[0].offsetWidth + 13) + 'px';
	oBtnRight.onclick = function () {
		var n = Math.floor((aLi.length * (aLi[0].offsetWidth + 13) + oUl.offsetLeft) / aLi[0].offsetWidth);

		if (n <= 5) {
			move(oUl, 'left', 0);
		}
		else {
			move(oUl, 'left', oUl.offsetLeft + now);
		}
	}
	oBtnLeft.onclick = function () {
		var now1 = -Math.floor((aLi.length / 5)) * 5 * (aLi[0].offsetWidth + 13);

		if (oUl.offsetLeft >= 0) {
			move(oUl, 'left', now1);
		}
		else {
			move(oUl, 'left', oUl.offsetLeft - now);
		}
	}
	var timer = setInterval(oBtnRight.onclick, 5000);
	oDiv.onmouseover = function () {
		clearInterval(timer);
	}
	oDiv.onmouseout = function () {
		timer = setInterval(oBtnRight.onclick, 5000);
	}

};

function getStyle(obj, name) {
	if (obj.currentStyle) {
		return obj.currentStyle[name];
	}
	else {
		return getComputedStyle(obj, false)[name];
	}
}

function move(obj, attr, iTarget) {
	clearInterval(obj.timer)
	obj.timer = setInterval(function () {
		var cur = 0;
		if (attr == 'opacity') {
			cur = Math.round(parseFloat(getStyle(obj, attr)) * 100);
		}
		else {
			cur = parseInt(getStyle(obj, attr));
		}
		var speed = (iTarget - cur) / 6;
		speed = speed > 0 ? Math.ceil(speed) : Math.floor(speed);
		if (iTarget == cur) {
			clearInterval(obj.timer);
		}
		else if (attr == 'opacity') {
			obj.style.filter = 'alpha(opacity:' + (cur + speed) + ')';
			obj.style.opacity = (cur + speed) / 100;
		}
		else {
			obj.style[attr] = cur + speed + 'px';
		}
	}, 30);
}
</script>

<script type="text/javascript" src="js/manhuaDialog.1.0.js"></script>
<script>
KindEditor.ready(function(K) {
	var uploadbutton = K.uploadbutton({
		button : K('#uploadButton')[0],
		fieldName : 'imgFile',
		url : './kindeditor/php/upload_json.php?dir=image',
		afterUpload : function(data) {
			if (data.error === 0) {
				var url = K.formatUrl(data.url, 'absolute');
				K('#url').val("."+url);
			} else {
				alert(data.message);
			}
		},
		afterError : function(str) {
			alert('自定义错误信息: ' + str);
		}
	});
	uploadbutton.fileBox.change(function(e) {
		uploadbutton.submit();
	});
});

</script>

</head>
<body>

    <div class="header topnav" id="topNav">
        <div class="mininav">
            <a href="http://www.jia360.com/" target="_blank" class="logo" title="腾讯网亚太家居·腾讯家居<">腾讯网亚太家居_腾讯家居</a>
            <div class="mr">
                <!--<span id="morecity" class="cm">
                    <p>城市站</p>
                    <div class="tabcity" id="tabcity"></div>
                </span>
                <span class="l">|</span>-->
                <span id="hychannel" class="hychannel">
                    <p>产品中心</p>
                    <ul>
                        <a href="http://www.jia360.com/jiaju/" target="_blank">家具</a>
                        <a href="http://www.jia360.com/weiyu/" target="_blank">卫浴</a>
                        <a href="http://www.jia360.com/cizhuan/" target="_blank">瓷砖</a>
                        <a href="http://www.jia360.com/yigui/" target="_blank">衣柜</a>
                        <a href="http://www.jia360.com/chufang/" target="_blank">厨房</a>
                        <a href="http://www.jia360.com/huwai/" target="_blank">户外</a>
                        <a href="http://www.jia360.com/muwu/" target="_blank">木屋</a>
                        <a href="http://www.jia360.com/diaoding/" target="_blank">吊顶</a>
                        <a href="http://www.jia360.com/shicai/" target="_blank">石材</a>
                        <a href="http://www.jia360.com/zhujiaju/" target="_blank">竹家居</a>
                        <a href="http://www.jia360.com/diban/" target="_blank">地板</a>
                        <a href="http://www.jia360.com/menchuang/" target="_blank">门窗</a>
                        <a href="http://www.jia360.com/zhengmu/" target="_blank">整木</a>
                        <a href="http://www.jia360.com/hongmu/" target="_blank">红木</a>
                        <a href="http://www.jia360.com/jiashi/" target="_blank">家饰</a>
                        <a href="http://www.jia360.com/louti/" target="_blank">楼梯</a>
                        <a href="http://www.jia360.com/shuimian/" target="_blank">睡眠</a>
                        <a href="http://www.jia360.com/qiangzhi/" target="_blank">墙纸</a>
                        <a href="http://www.jia360.com/zhaoming/" target="_blank">照明</a>
                        <a href="http://www.jia360.com/gangmumen/" target="_blank">钢木门</a>
                        <a href="http://www.jia360.com/cainuo/" target="_blank">采暖</a>
                        <a href="http://www.jia360.com/shafa/" target="_blank">沙发</a>
                        <a href="http://www.jia360.com/jiafang/" target="_blank">家纺</a>
                        <a href="http://www.jia360.com/ditan/" target="_blank">地毯</a>
                        <a href="http://www.jia360.com/yuanyi/" target="_blank">园艺</a>
                        <a href="http://www.jia360.com/tuliao/" target="_blank">涂料</a>
                        <a href="http://www.jia360.com/wujin/" target="_blank">五金</a>
                        <a href="http://www.jia360.com/ertong/" target="_blank">儿童家具</a>
                    </ul>
                </span>
                <span class="l">|</span>
                <a href="http://www.jia360.com/product/picture/" target="_blank" class="nt">图库</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/product/evaluation/" target="_blank" class="nt">评测</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/zhuanti/qgbcqc" target="_blank" class="nt">导购</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/product/fresh/" target="_blank" class="nt">新品</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/homelife/geomantic/" target="_blank" class="nt">风水</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/fitment/idea/" target="_blank" class="nt">配饰</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/fitment/college/" target="_blank" class="nt">案例库</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com:80/shejishi/index.html" target="_blank" class="nt">设计师</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/news/video/" target="_blank" class="nt">视频</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/zhuanti/" target="_blank" class="nt">专题</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/news/person/" target="_blank" class="nt">人物</a>
                <span class="l">|</span>
                <a href="http://news.jia360.com/" target="_blank" class="nt">新闻</a>
                <span class="l">|</span>
                <a href="http://www.jia360.com/" target="_blank" class="nt">首页</a>

            </div>
        </div>
    </div>

<div class="mian1"></div>
<div class="mian2"></div>
<div class="mian3"></div>
<div class="mian4">
   <div class="box">
     <div class="rsp">
       <div class="s1"><embed src="http://player.youku.com/player.php/sid/XODUxNDY3NTE2/v.swf" allowFullScreen="true" quality="high" width="210" height="118" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed></div>
       <div class="s1" style="margin-top:27px;"><embed src="http://player.youku.com/player.php/sid/XODUxNDY0ODg0/v.swf" allowFullScreen="true" quality="high" width="210" height="118" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed></div>
     </div>
   </div>
</div>
<div class="mian5">
   <div class="box">
      <p>1.我的圣诞我做主，谁的圣诞树够创意 <a href="http://www.jia360.com/jiaju/20141216/1418710070987.html">【详细】</a></p>
      <p>2.【疑惑】鲁道夫，他们的圣诞树呢？？<a href="http://www.jia360.com/jiaju/20141216/1418709559317.html">【详细】</a></p>
      <p>3.绿色风暴再次来袭：和戴军一起创意圣诞树<a href="http://www.jia360.com/jiaju/20141216/1418710704873.html">【详细】</a></p>
   </div>
</div>
<div class="mian6">
   <div class="sp"><embed src="http://player.youku.com/player.php/sid/XODUxNDYwMjcy/v.swf" allowFullScreen="true" quality="high" width="460" height="300" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed></div><!--放视频位置-->
</div>
<div class="mian7">
   <div class="box">
      <div class="bnt"><center style="font-size:24px;margin:0px 0 0 0;">
		<a href="javascript:void(0)" id="test"><img src="images/bnt1.jpg" width="192" height="67" /></a></center>

	 </div>
      <div class="show">
         <div class="indexmaindiv" id="indexmaindiv">
	<div class="indexmaindiv1 clearfix" >
		<div class="stylesgoleft" id="goleft"></div>
		<div class="maindiv1 " id="maindiv1">
		<ul id="count1">
		<?php
		if (!empty($url_arr)) {
			foreach ($url_arr as $k => $key){
		?>
			<li>
				<div class="playerdetail">
					<div class="detailimg"><img src="<?php echo $key['img_url']?>" /><div class="icon"><?php echo $key['clicks']?></div></div>
					<div class="teanames"><?php echo $key['filename']?></div>
					<a class="checkdetail" href="javascript:void(0)" id="<?php echo $key['id']?>"></a>
				</div>
			</li>
		<?php
			}}
		?>
		</ul>
		</div>
		<div class="stylesgoright" id="goright"></div>
	</div>
</div>

      </div>
   </div>
</div>

<div class="mian8">
   <div class="wbox">
		<iframe width="100%" height="350" frameborder="0" allowtransparency="true" src="about:blank" id="txwbydq_01" srcolling="no"></iframe>  <script type="text/javascript">window.showTxWbYDQ(document.getElementById("txwbydq_01"), {"width":"100%","height":"350","appkey":"801554968","theme":0,"nobg":0,"ModuleConfigure":{"TitleModule":0,"PubModule":1,"TabModule":0,"TimelineModule":1},"TimelineDetail":{"HeadStyle":1,"PageStyle":0,"PicStyle":0,"TwitterNum":20},"PubModuleConfigure":{"InitialContent":"#曲美绿色圣诞创意活动# 说点什么吧","InsertFunction":[0,1,2],"SourceUrl":"http://dev.t.qq.com/websites/read/","position":0},"TitleModuleConfigure":{"OfficialAccount":"api_weibo"},"TimelineModuleConfigure":[{"Condition":["曲美绿色圣诞创意活动"],"ConditionType":1,"ContentType":0,"Famous":0,"MessageType":1,"Name":"曲美绿色圣诞创意","SortType":1}],"filter":{"updateTime":1418887608663,"userIds":[""],"keyWords":[""],"topTwitterIds":[""]}} , function(d){/*回调函数,d的值格式为：{"action":"发表","ret":0,"errcode":0,"msg":"ok","data":{"id":231174038614579,"time":1371544700}},其中action的值可能为“发表、转播、评论”*/} );</script>

      <!-- <div class="sr"><input name="" type="text" /></div>
      <div class="showw">
      微博内容列表
      </div> -->
   </div>
</div>
        <script src="js/my.js"></script>
        <div class="footer" style="display:none;">
        <p id="babout">
            <a href="http://www.jia360.com/about.html" target="_blank" title="关于亚太家居网" rel="nofollow">关于我们</a> |
            <a href="http://www.jia360.com/contact.html" target="_blank" title="联系亚太家居网" rel="nofollow">联系我们</a> |
            <a href="http://www.jia360.com/zhaoshang/2012-08-17/" target="_blank" title="招商加盟" rel="nofollow">招商加盟</a> |
            <a href="http://www.jia360.com/zhaopin/20130112/" target="_blank" title="招贤纳士" rel="nofollow">招贤纳士</a> |    <a href="http://www.jia360.com/adnav/" target="_blank" title="广告咨询" rel="nofollow">广告咨询</a> |
            <a href="http://www.jia360.com/maps.html" target="_blank" title="网站地图" rel="nofollow">网站地图</a> |
            <a href="http://www.jia360.com/links.html" target="_blank" title="友情链接" rel="nofollow">友情链接</a> |
            <a href="http://www.jia360.com/announce.html" target="_blank" title="免责声明" rel="nofollow">免责声明</a>
        </p>
        <p>Copyright 2009-2012, 版权所有www.jia360.com </p>
        <p>咨询热线：400-668-3836 传真：0755-36908830 </p>
        <p>
            <a href="http://www.miibeian.gov.cn/" rel="nofollow" target="_blank">粤ICP备10217827号</a> 增值电信业务经营许可证
            <a href="http://www.jia360.com/license.html" rel="nofollow" target="_blank">粤B2-20110100</a>
        </p>

        <div style="display:none;">
            <script src="http://exp.jiankongbao.com/loadtrace.php?host_id=770&amp;style=1&amp;type=0" type="text/javascript"></script>
            <script type="text/javascript">
                var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2ab3201bee62fa474ed923dba01a8720' type='text/javascript'%3E%3C/script%3E"));
            </script>
            <script src=" http://hm.baidu.com/h.js?2ab3201bee62fa474ed923dba01a8720" type="text/javascript"></script>
            <a href="http://tongji.baidu.com/hm-web/welcome/ico?s=2ab3201bee62fa474ed923dba01a8720" target="_blank"></a>

        </div>
    </div>
    <div id="detail">
				<a href="javascript:void(0)" onclick='$("#detail").css("top","20000px");' style="float:right;margin-top:-15px; font-size:18px; margin-right:10px;">X</a>
				<div class="nns" style="padding-top:10px; padding-left:20px;"><span>作品上传: </span>
					<input class="ke-input-text" type="text" id="url" value="" readonly="readonly" />&nbsp;<input type="button" id="uploadButton" value="选择"/>
			    </div>
			    <div class="nns" style="padding-top:10px; padding-left:20px;"><span>作品名称: </span><input name="" type="text" id="filename" class="input_text"/></div>
			    <div class="nns" style="padding-top:10px; padding-left:20px;clear:both;"><span>手机号码: </span><input name="" type="text" id="phone" class="input_text"/></div>
			    <div class="nns" style="padding-top:10px; padding-left:75px;"><input name="提交" type="button" value="提交" onclick="ajax_but()" class="btn btn_input btn_primary"/></div>
			</div>
</body>
<script type="text/javascript">
$(function (){
	$("#test").click(function(){
		$("#detail").css("top","200px");
	});
});

function ajax(p_url, p_data, p_type) {
	var results;
	$.ajax({
		async:false,
	 	url:p_url,
	 	data:p_data,
	 	type: p_type,
	 	dataType:'json',

	 	success:function(result){
	 		results = result;
	 	}
	});
	return results;
}
function ajax_but(){
	var img_url = $("#url").val();
	var filename = $("#filename").val();
	var phone = $("#phone").val();
	reg=/^0{0,1}(13[0-9]|14[57]|15[0-9]|17[678]|18[0-9])[0-9]{8}$/i;
	if(!img_url){
		$("#url").css('background', '#FFDFDD');
		return false;
	}
	if(!filename){
		$("#filename").css('background', '#FFDFDD');
		return false;
	}
	if (!reg.test(phone)) {
		$("#phone").css('background', '#FFDFDD');
		return false;
	}
	var result = ajax("./data.php",{img_url:img_url, filename:filename, phone:phone},'get');
	if(result == 2){
		alert("图片不能为空");
	}
	if(result == 0){
		alert("提交失败，请稍后再试！");
	}
	if(result == 1){
		$("#detail").hide();
	}
}
 $(".checkdetail").click(function(){
	var id = $(this).attr('id');
	var result = ajax("./data.php",{id:id},'get');
	if(result == 1){
		var clicks = $(this).parent(".playerdetail").find(".icon").html();
		$(this).parent(".playerdetail").find(".icon").html(parseInt(clicks)+1);
	}
})

</script>


</html>