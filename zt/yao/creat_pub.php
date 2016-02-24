<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
<?php
$rootPath = dirname(dirname(__FILE__));
require($rootPath . '/data/config.php');
/**
* 创建发红包活动
* 
*/
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

 require('yaoyiyao.php');
 require('fileupload.class.php');
 $table = 'creat_pub';
 
   if( isset($_GET['d']) ) {
	 echo dirname(__FILE__);
 }

 // 处理 POST 请求
  if( $_POST ){
	$title = $_POST['title'];
	$up = new fileupload;
    //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
	$up_path = dirname(__FILE__).'/Upload/';
	if(!is_dir( $up_path)) {
		mkdir($up_path,0777,true);
	}
    $up->set("path", $up_path);
    $up->set("maxsize", 2000000);
    $up->set("allowtype", array("gif", "png", "jpg","jpeg"));
    $up->set("israndname", false);
   
	// 得到文件名
	$fileName = 'default.jpg';
	$logo_url = '/yao/Upload/'.$fileName;
	if($up->upload("img")) 
	{
		$fileName = $up->getFileName();
		$logo_url = '/yao/Upload/'.$fileName;
	}
	
	$description = $_POST['description'];
	$total = $_POST['total'];
	$jump_url = $_POST['jump_url'];
	$token = getAccessToken(WxPayConf_pub::APPID, WxPayConf_pub::APPSECRET);  //这里是我封装的一个获取 token的 方法 做了时间限制 防止超出调用次数
	$Redpack = new addlotteryinfo_pub($token,SITE_URL.$logo_url);
	$time = time();
    $end = time()+60*24*60*60;//两个月 这里的开始和结束时间我固定了 
	$key = $Redpack->createNoncestr(); //key
	$Redpack->setParameter('title', $title);
	//活动标题
	$Redpack->setParameter('desc', $description);
	//活动描述
	$Redpack->setParameter('begin_time', $time);
	//开始时间
	$Redpack->setParameter('expire_time', $end); 
	//结束时间
	$Redpack->setParameter('total', $total);
	//红包总数
	$Redpack->setParameter('jump_url', $jump_url);
	//key
	
	$Redpack->setParameter('key', $key);
	$result = $Redpack->hbpreorder();
	$result = (array)$result; 

	if( isset($result['errcode'] )) {
		if( $result['errcode'] == 0) {
			$lottery_id = $result['lottery_id'] = isset($result['lottery_id'])?$result['lottery_id']:null;
			$page_id = $result['page_id'] = isset($result['page_id'])?$result['page_id']:null;
			
			$add_time = date('Y-m-d H:i:s');
			$sql = "insert into ".$table." (pub_title,img,description,total,jump_url,add_time,lottery_id,page_id) values ('{$title}','{$logo_url}','{$description}','{$total}','{$jump_url}','{$add_time}','{$lottery_id}','{$page_id}')";
			mysqli_query($db, $sql);
			echo '申请活动成功！:<br/>-';
			echo '活动ID:' . $lottery_id .'<br/>';
			echo '页面ID:' . $page_id .'<br/>';
		} else { // 抛出错误
			echo '错误信息:<br/>-';
			echo $result['errmsg'];
		}
	} else {
		echo '错误信息:<br/>-';
		echo '没有请求到微信创建发红包活动接口<br/>';
	}
 }
 ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="gbk" />
<meta name="robots" content="all" />
<meta name="author" content="w3school.com.cn" />

<title>创建红包活动</title>

</head>
<body class="html" id="tags">
 <form action="creat_pub.php?debug=1" method="post" enctype="multipart/form-data">
  <p>抽奖活动名称: <input type="text" name="title" /></p>
  <p>图片: <input type="file" name="img" /></p>
  <p>活动描述: <input type="text" name="description" /></p>  
  <p>红包总数: <input type="text" name="total" /></p>
  <p>跳转连接: <input type="text" name="jump_url" /></p>  
  <input type="submit" value="提交" />
</form>
</body>
</html>