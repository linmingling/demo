<?php
header("Content-Type: text/html; charset=UTF-8");
$redis = new Redis();
$redis->connect('localhost', 6379);
$act = $_GET;

// 清空缓存
if( $act['clean']==1) {
	$redis->delete('r_userinsert');
	$redis->set('group_1',0);
	$redis->set('group_2',0);
	$redis->set('group_3',0);
	$redis->set('add_switch', 0);
	echo 'OK';
}

?>

<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="gbk" />
<meta name="robots" content="all" />
<meta name="author" content="w3school.com.cn" />
<link rel="stylesheet" type="text/css" href="/c5.css" />

<title>工具</title>

</head>

<body class="serverscripting">

<a href="http://zt.jia360.com/2016/festival2/zt_tool.php?clean=1">清空缓存，重置状态</a>
</body>
</html>