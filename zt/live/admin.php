<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$live_user = !empty($_SESSION['live_user']) ? $_SESSION['live_user'] : 0;
if(!$live_user){
	$url = 'http://'.$_SERVER['HTTP_HOST']."/live/login.php";
	header("Location: $url");
}
$id = !empty($_GET['id']) ? $_GET['id'] : 0;
$arr = array();
if($id){
	$sql = "SELECT * FROM live WHERE id=".$id;
	$url = mysqli_query($db, $sql);
	while($row = $url->fetch_array()){
		$arr = $row;
	}
}
if(empty($arr)){
	$arr['title'] = '';
	$arr['info'] = '';
	$arr['share_img'] = '';
	$arr['share_title'] = '';
	$arr['share_desc'] = '';
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="viewport" content=" initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<title>微信现场直播发布端 </title>
<link rel="stylesheet" type="text/css" href="css/com.css?v=1.1" />
<link rel="stylesheet" type="text/css" href="../public/kindeditor/themes/default/default.css?v=1.1" />
<script src="../public/kindeditor/kindeditor.js" type="text/javascript"></script>
<script src="../public/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
<script>
KindEditor.ready(function(K){
	var editor = K.editor({
		allowFileManager:false
	});
	K('#share_upload').click(function() {
		editor.loadPlugin('image', function() {
			editor.plugin.imageDialog({
				fileUrl : K('#share_imgurl').val(),
				clickFn : function(url, title) {
					if(url.indexOf("http") > -1){
						K('#share_imgurl').val(url);
					}else{
						K('#share_imgurl').val("<?php echo site_url?>"+url);
					}
					editor.hideDialog();
				}
			});
		});
	});
})
</script>
</head>

</body>
<div class="warp" id="warp">
	<div class="main">
		<div class="mainBox baoming" id="box1">

			<p class="title">
				<?php if($id){
					echo $arr['title'];
				} else { ?>
						微信现场直播发布端
				<?php } ?>
			</p>
			<div class="hx"></div>

			<div class="clearfix">
				<span class="tx">直播标题：</span>
				<input type="text" class="text live_title" placeholder=" 请输入此次直播标题" value="<?php echo $arr['title']?>" />
			</div>
			<div class="clearfix">
				<span class="tx">直播说明：</span>
				<input type="text" class="text info" placeholder=" 直播说明，可为空" value="<?php echo $arr['info']?>" />
			</div>
			<div class="clearfix">
				<span class="tx">分享图片：</span>
				<input type="text" class="text_img share_img" placeholder=" 请输入此次分享图片" id="share_imgurl" value="<?php echo $arr['share_img']?>" />&nbsp;<span class="btnGrayS" id="share_upload">选择</span>&nbsp;&nbsp;尺寸不宜过大，建议使用146px * 146px
			</div>
			<div class="clearfix">
				<span class="tx">分享标题：</span>
				<input type="text" class="text share_title" placeholder=" 请输入此次分享标题" value="<?php echo $arr['share_title']?>" />
			</div>
			<div class="clearfix">
				<span class="tx">分享描述：</span>
				<input type="text" class="text share_desc" placeholder=" 请输入此次分享描述" value="<?php echo $arr['share_desc']?>" />
			</div>
			<p class="bmBtn">
			<?php if($id){ ?>
					保存
			<?php } else { ?>
					创建直播
			<?php } ?>
			</p>
			<?php if(!$id){ ?>
				<p class="time grey">最近直播</p>
			<?php } ?>
				<div class="news_list"></div>
			<?php if($id){ ?>
				<p class="bmBtn_fh">返回</p>
			<?php } ?>
		</div>
	</div>
</div>
<div id="floatPanel"> 
    <div class="ctrolPanel" style="right:20px;"> 
        <a class="arrow" href="javascript:void(0)"><span>顶部</span></a> 
        <a class="contact" href="/live/notice.php" target="_blank"><span>公告</span></a> 
        <a class="qrcode" href="javascript:void(0)"><span>二维码</span></a> 
        <a class="arrow" href="javascript:void(0)"><span>底部</span></a> 
    </div>
     
    <div class="popPanel" style="right:66px;"> 
        <div class="popPanel-inner"> 
            <div class="qrcodePanel"><img src="images/qrcode.png" /><p>如有疑问请用<font color="red">微信</font>扫描二维码<br/>或发邮件到<br/>zouweilong@asia-media.cn<br/>反馈时请注明事件缘由</p></div> 
            <div class="arrowPanel"> 
                <div class="arrow01"></div> 
                <div class="arrow02"></div> 
            </div> 
        </div> 
    </div> 
</div> 

<!--提示层-->
<div id="tips" class="tips hide"></div>
<div id="success_tips" class="success_tips hide"></div>

<div id="test" style="background:#000;color:#fff;position:fixed;top:50px;left:50px"></div>

<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(function(){ 
    $("#floatPanel a.arrow").eq(0).click(function(){ 
        $("html,body").animate({scrollTop :0}, 300); 
        return false; 
    }); 
    $("#floatPanel a.arrow").eq(1).click(function(){ 
        $("html,body").animate({scrollTop : $(document).height()}, 300); 
        return false; 
    }); 
 
    var panel = $(".popPanel");     
    var w = panel.outerWidth(); 
    
    $(".qrcode").hover(function(){ 
        panel.css("width","0px").show(); 
        panel.animate({"width" : w + "px"},300); 
    },function(){ 
        panel.animate({"width" : "0px"},300); 
    }); 
     
}); 
				
var sto;
function tips(text){
	$("#tips").html(text);
	$("#tips").fadeIn();
	clearTimeout(sto);
	sto = setTimeout(function(){
		$("#tips").stop().fadeOut();
	},2000);
}
function success_tips(text){
	$("#success_tips").html(text);
	$("#success_tips").fadeIn();
	clearTimeout(sto);
	sto = setTimeout(function(){
		$("#success_tips").stop().fadeOut();
	},2000);
}
var id = <?php echo $id?>;
$(function(){
	<?php if(!$id){?>
	  $.ajax({
			async:false,
		 	url: 'server.php',
		 	data: {act:'ajax_list', type:2},
		 	type: 'post',
		 	dataType:'json',
		 	success:function(result){
		 		var info_list = result;
		 		if(info_list){
		 			$(".live-list").empty();
					for(var j=0;j<info_list.length;j++){
						$(".news_list").append(
							'<p class="grey"><span class="list_time">直播时间：'+info_list[j]['time']+'</span>'+
							'<span class="list_title">标题：'+info_list[j]['title']+'</span>'+
							'<span class="list_jinru del" id="'+info_list[j]['id']+'"><a>进入直播间</a></span>'+
							'<span class="list_edit edit" id="'+info_list[j]['id']+'"><a>编辑</a></span>'+
				         	'</p>'
				         );
					}
				}
		 	}
		});
	  <?php }?>

	  $('.news_list .del').each(function(index){
		  $(this).click(function(){
			  var id = $(this).attr('id');
			  location.href = "/live/add.php?id="+id;
			});
		});

	  $('.news_list .edit').each(function(index){
		  $(this).click(function(){
			  var id = $(this).attr('id');
			  location.href = "/live/admin.php?id="+id;
			});
		});

	$("#box1 .bmBtn").click(function(){
		var title = $("#box1 .live_title").val();
		var info = $("#box1 .info").val();
		var share_img = $("#box1 .share_img").val();
		var share_title = $("#box1 .share_title").val();
		var share_desc = $("#box1 .share_desc").val();
		if(title == ""){
			tips("标题不能为空");
		} else if(share_img == ""){
			tips("分享图片不能为空");
		} else if(share_title == ""){
			tips("分享标题不能为空");
		} else if(share_desc == ""){
			tips("分享描述不能为空");
		} else {
			$(this).attr('disabled',false);
			//存数据
				$.ajax({
					async:false,
				 	url: 'server.php',
				 	data: {act:'add_title', id:id, title:title, info:info, share_img:share_img, share_title:share_title, share_desc:share_desc},
				 	type: 'post',
				 	dataType:'json',
				 	success:function(result){
				 		if(!parseInt(result.code)){
				 			tips(result.msg);return;
				 		}
				 		if(id){
				 			success_tips("编辑成功");
					 	} else {
					 		success_tips("正在进入直播间...");
					 		$(".bmBtn").html("正在进入直播间...");
					 		location.href = "/live/add.php?id="+result.id;
					 	}
				 	}
				});
		}
	});
	$("#box1 .bmBtn_fh").click(function(){
		location.href = "/live/admin.php";
	});
});
</script>
<?php include '../public/head.html' ?>
<?php include '../public/footer.html' ?>
<?php include '../public/tongji.html' ?>
</body>
</html>