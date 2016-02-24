<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$live_user = !empty($_SESSION['live_user']) ? $_SESSION['live_user'] : 0;
if(!$live_user){
	$url = 'http://'.$_SERVER['HTTP_HOST']."/live/login.php";
	header("Location: $url");
}

$id = !empty($_GET['id']) ? $_GET['id'] : 0;
$edit_id = !empty($_GET['edit_id']) ? $_GET['edit_id'] : 0;
$arr = array();
$arr_info = array();

if($edit_id && $id){
	$sql = "SELECT * FROM live_list WHERE action_id=".$id." AND id=".$edit_id;
	$url = mysqli_query($db, $sql);
	while($row = $url->fetch_array()){
		$arr_info = $row;
	}
	$arr['title'] = $arr_info['title'];
} else {
	if($id){
		$sql = "SELECT * FROM live WHERE id=".$id;
		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr = $row;
		}
	}
	if(empty($arr)){
		header("location: /live/admin.php");exit;
	} else {
		$arr_info['title'] = '';
		$arr_info['info'] = '';
	}
}
// var_dump($arr);exit;
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
<title><?php echo $arr['title']?>微信现场直播发布端 </title>
<link rel="stylesheet" type="text/css" href="css/com.css?v=1.1" />
<link rel="stylesheet" type="text/css" href="../public/kindeditor/themes/default/default.css?v=1.1" />
<script src="../public/kindeditor/kindeditor.js" type="text/javascript"></script>
<script src="../public/kindeditor/plugins/autoheight/autoheight.js" type="text/javascript"></script>
<script src="../public/kindeditor/lang/zh_CN.js" type="text/javascript"></script>
<script src="../public/js/date/WdatePicker.js" type="text/javascript"></script>
<script>
var editor;
KindEditor.ready(function(K) {
editor = K.create('#info', {
autoHeightMode : true,
allowMediaUpload : false,
allowFlashUpload : false,
items : [
'source','|','undo','redo','|','hr','fontsize','formatblock','forecolor','hilitecolor','removeformat', '|',
'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist','insertunorderedlist', 'indent','outdent','lineheight','clearhtml','|',
'emoticons', 'image','media','flash','link', 'unlink','baidumap','table','template','code','|','cut','wordpaste','|','preview','print','quickformat','fullscreen']
});
});
</script>
</head>

</body>
<div class="warp" id="warp">
	<div class="main">
		<div class="mainBox baoming" id="box1">
			<p class="title">
				<?php if($edit_id){
					echo $arr_info['title'];
				} else {
					echo $arr['title']."<br/>微信现场直播发布端";
				}?>
			</p>
			<p class="place grey">直播地址：<a href="./index.php?id=<?php echo $id?>" target="_blank" style="color:#FF6325;">点击进入（建议在手机上观看）</a></p>
			<div class="hx"></div>
			<div class="clearfix">
				<input type="text" class="name l" placeholder="请输入直播员" value="<?php echo $arr_info['title'];?>"/><br/><br/><br/>
				<textarea id="info" class="desc r"><?php echo $arr_info['info']?></textarea><br/>
				<?php if($edit_id){?>
				<input type="text" class="name l add_time time" value="<?php echo date('Y-m-d H:i:s', $arr_info['add_time'])?>" onClick="WdatePicker()"/><br/><br/>
				<?php }?>
			</div>
			<div class="px">
				<p class="bmBtn">
					<?php if($edit_id){
						echo '保存';
					} else {
						echo '发布';
					}?>
				</p>
				<p class="bmBtn_fh">返回</p>
				<?php if(!$edit_id){
					echo "<p class='time grey'>最近发布的直播信息</p>";
				}?>
				<div class="news_list"></div>
			</div>
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
$(function(){
	var id = <?php echo $id?>;
	var edit_id = <?php echo $edit_id?>;
	<?php if(!$edit_id){?>
	  $.ajax({
			async:false,
		 	url: 'server.php',
		 	data: {act:'ajax_list', type:1, id:id},
		 	type: 'post',
		 	dataType:'json',
		 	success:function(result){
		 		var info_list = result;
		 		if(info_list){
		 			$(".live-list").empty();
					for(var j=0;j<info_list.length;j++){
						$(".news_list").append(
							'<p class="grey"><span class="list_time">发布时间：'+info_list[j]['md_time']+info_list[j]['hi_time']+
							'</span><span class="list_title">直播员：'+info_list[j]['title']+'</span>'+
							'<span class="list_jinru del" id="'+info_list[j]['id']+'" is_blocked="'+info_list[j]['is_blocked']+'"><img src="'+info_list[j]['blocked_img']+'" title="'+info_list[j]['blocked_tips']+'"></span>'+
							'<span class="list_edit edit" id="'+info_list[j]['id']+'"><a>编辑</a></span>'+
				         	'</p>'
				         );
					}
				}
		 	}
		});
	<?php }?>
	  del();
	  edit();
	  function del(){
		  $('.news_list .del').each(function(index){
			  $(this).click(function(){
				  var act_id = $(this).attr('id');
				  var is_blocked = $(this).attr('is_blocked');
				   $.ajax({
						async:false,
					 	url: 'server.php',
					 	data: {act:'ajax_del', id:act_id, is_blocked:is_blocked},
					 	type: 'post',
					 	dataType:'json',
					 	success:function(result){
					 		if(!parseInt(result.code)){
					 			tips(result.msg);return;
					 		}
					 		//$('.news_list p').eq(index).remove();
							location.href = "/live/add.php?id="+id;
					 	}
					});
				});
			});
	  }
	  function edit(){
		  $('.news_list .edit').each(function(index){
			  $(this).click(function(){
				  var edit_id = $(this).attr('id');
				  location.href = "/live/add.php?id="+id+"&edit_id="+edit_id;
				});
			});
	  }
	$("#box1 .bmBtn").click(function(){
		var name = $("#box1 .name").val();
		var desc = editor.html();
		var time = $(".add_time").val();
		if(name == ""){
			tips("请输入直播员");
		}else if(editor.isEmpty()){
			tips("内容不能为空");
		}else{
			$(this).attr('disabled',false);
			//存数据
				$.ajax({
					async:true,
				 	url: 'server.php',
				 	data: {act:'submit', name:name, info:desc, time:time, id:id, edit_id:edit_id},
				 	type: 'post',
				 	dataType:'json',
				 	success:function(result){
				 		if(!parseInt(result.code)){
				 			tips(result.msg);return;
				 		}
				 		if(edit_id){
				 			success_tips("编辑成功");
					 	} else {
					 		$(".news_list").prepend(
									'<p class="grey"><span class="list_time">发布时间：'+result['time']+
									'</span><span class="list_title">直播员：'+name+'</span>'+
									'<span class="list_jinru del" id="'+result['id']+'" is_blocked="0"><img src="images/yes.gif" title="已显示"></span>'+
									'<span class="list_edit edit" id="'+result['id']+'">编辑</span>'+
						         	'</p>'
							);
					 		del();
					 		edit();
					 		success_tips("发布成功");
					 		$(this).attr('disabled',true);
					 	}
				 	}
				});
		}
	});
	$("#box1 .bmBtn_fh").click(function(){
		<?php if($edit_id){
			echo 'location.href = "/live/add.php?id='.$id.'"';
		} else {
			echo 'location.href = "/live/admin.php"';
		}?>
	});
});
</script>
<?php include '../public/head.html' ?>
<?php include '../public/footer.html' ?>
<?php include '../public/tongji.html' ?>
</body>
</html>