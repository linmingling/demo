<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require(ROOT_PATH . '/page.php');

header("Content-type: text/html; charset=utf8");
 date_default_timezone_set("Asia/Shanghai");   //设置时区

function time_tran($the_time) 
{
    $now_time = date("Y-m-d H:i:s", time());
	//echo $now_time;
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    if ($dur < 0) 
    {
        return $the_time;
    } 
    else 
    {
        if ($dur < 60) 
        {
            return $dur . '秒前';
        } 
        else 
        {
            if ($dur < 3600) 
            {
                return floor($dur / 60) . '分钟前';
            } 
            else 
            {
                if ($dur < 86400) 
                {
                    return floor($dur / 3600) . '小时前';
                } 
                else 
                {
                    if ($dur < 172800) //2天内
                    {
                        return floor($dur / 86400) . '天前';
                    } 
                    else 
                    {
                        return $the_time;
                    }
                }
            }
        }
    }
}

//查询一共多少条
$sql="select * from cy";
$res = mysqli_query($db, $sql);
$total_rows=$res->num_rows;
$per_page_rows=2;

$page=new Page($total_rows,$per_page_rows,'');

//要显示的内容
$sql="select * from cy order by add_strtotime desc {$page->limit}";
$rs=mysqli_query($db,$sql);

//多少人评论

$c_sql="select * from cy group by name";
$c_rs=mysqli_query($db,$c_sql);
$c_row = $c_rs->num_rows;


//echo '<tr><td colspan="5" align="right">'.$page->out_page(array(2,3,4,5,6,7,8)).'</td></tr>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>commet</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
	<div class="main">
		<!-- 头部数据 -->
		<p class="nav">
			<span class="c-num"><?php echo $total_rows;?></span>条评论，<span class="p-num"><?php echo $c_row;?></span>人参与
		</p>
		<!-- 内容 -->
		<div class="postbox">
			<div class="textwrap">
				<textarea id="textmsg" class="textmsg" name="textmsg" value="" onfocus="clearDefault(this);" onblur="check();" style="color: rgb(170, 178, 184)">我有话说...</textarea>
			</div>
		</div>
		<!-- 分享 -->
		<div class="social">
			<div class="socialbox">
				<h6>分享至社交平台:</h6>
				<span>
					<a id="loginqq" href="javascript:;" onclick="javascript:window.open('http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://zt.jia360.com/cy/index.html&desc=晨阳水漆互联网+服务&title=晨阳水漆')" class="qq" title="使用QQ帐号登录"></a>
					<a id="loginsina" href="javascript:;" onclick="javascript:window.open('http://service.weibo.com/share/share.php?count=1&url=http://zt.jia360.com/cy/index.html&desc=晨阳水漆互联网+服务&title=晨阳水漆')" class="sina" title="使用新浪微博帐号登录"></a>
					<a id="loginrenren" href="javascript:;" onclick="javascript:window.open('http://widget.renren.com/dialog/share?resourceUrl=http://zt.jia360.com/cy/index.html&desc=晨阳水漆互联网+服务&title=晨阳水漆')"class="renren" title="使用人人网帐号登录"></a>
					<a id="loginkaixin" href="javascript:;" onclick="javascript:window.open('http://www.kaixin001.com/login/open_login.php?flag=1&url=http://zt.jia360.com/cy/index.html&content=晨阳水漆&desc=晨阳水漆互联网+服务')" class="kaixin" title="使用开心网帐号登录"></a>
				</span>
			</div>
		<!-- 发布 -->
		<div class="sendbox">
				<input type="text" name="nickname" value="输入昵称" class="nickname" id="name" onfocus="clearDefault(this);" onblur="check();" style="color: rgb(170, 178, 184)"/>
				<div class="send" id="send">发布</div>
			</div>
		</div>

		<!-- 评论区 -->
		<div class="com-nav">最新评论</div>
		<div class="combox">
			<div class="comb"></div>
			<div class="comarea">
				<div class="comhead">
					<div class="tn">共<span class="total-num"><?php echo $total_rows;?></span>条</div>
					<div class="page">
						<?php echo $page->page_list();?>
						<?php echo $page->go_prev();?>
						<?php echo $page->go_next();?>
					</div>
					<div class="post-list">
                        <?php while($row = $rs->fetch_assoc()) { ?>
						<div class="post-body" id="user1">
							<div class="u-name"><?php echo $row['name'];?></div>
							<div class="post-msg"><p><?php echo $row['content'];?></p></div>
							<div class="post-time"><?php echo time_tran($row['add_time']);?></div>
						</div>
                        <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="js/jquery-1.8.3.min.js"></script>	
<script>
	$('#send').click(function(){
		var textcon = $('#textmsg').val();
		var nicname = $('#name').val();

		if(textcon == ""){
			alert("请输入评论内容！");
			return false;
		}
		if(nicname == "" || nicname =="输入昵称"){
			alert("请输入昵称！");
			return false;
		}

        $.ajax({
            async:false,
            url: 'server.php',
            data:{act:'addinfo',name:nicname,content:textcon},
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
        location.reload();
		return true;

	})

	function clearDefault(el) {         
        if (el.defaultValue==el.value) el.value = "" ;
        $('#textmsg').css("color", "rgb(64, 64, 64)");
        $('#name').css("color", "rgb(64, 64, 64)");
    return true;
   } 




	
   function check(){
   	 var tvalue = $('#textmsg').val();
   	 var nvalue = $('#name').val();

        if(tvalue == ""){
            $('#textmsg').val("我有话说...");
            $('#textmsg').css("color", "rgb(170, 178, 184)");
        }

        if(nvalue == ""){
            $('#name').val("输入昵称");
            $('#name').css("color", "rgb(170, 178, 184)");
        } 
   }
</script>	
</body>
</html>
