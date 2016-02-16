<?php
define('ROOT_PATH', dirname(__FILE__));
header("Content-type: text/html; charset=utf-8");
$db = mysqli_connect("121.40.132.34","zhuanti","yatai3.14159") or die("database connection failed");
//$db = mysqli_connect("localhost","root","") or die("database connection failed");
mysqli_select_db($db, "zhuanti");
mysqli_query($db, 'set names "utf8"');
define('site_url', 'http://zt.jia360.com');
date_default_timezone_set('PRC'); //设置本地时区
require('rediusClass.php');

$key = 'r_userinsert';   
$redis = new RedisCluster();
$redis->connect(array('host'=>'localhost','port'=>6379));

$act = $_GET['act'];
if($act == 'sub'){
	$sig = 'AAA';
	$num = 1;
		$sql = "insert into festival2016_ab_test (company,times,addtime) values ('{$sig}','{$num}','" . date('Y-m-d H:i:s') . "')";
		mysqli_query($db, $sql);
		echo $sql.'<br/>';
}
if($act == 'sredis'){
	$key = 'r_userinsert';   
	$data['num'] = $_GET['num'];
	$data['sig'] = $_GET['sig'];
	if(!$data['num']) {
		$data['num'] = mt_rand(1,3);
	}
	if(!$data['sig']) {
		$data['sig'] = md5(mt_rand(1,9));
	}	
	$data['addtime'] = date('Y-m-d H:i:s');	
	$value = json_encode( $data );
	$redis->lpush($key,$value); 		
}
?>