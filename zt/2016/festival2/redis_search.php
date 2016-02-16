<?php
date_default_timezone_set('Asia/Shanghai'); 
header("Content-type: text/html; charset=utf-8"); 
set_time_limit(0) ;
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

$redis = new Redis();
$redis->connect('localhost', 6379);
$key = 'r_userinsert';   

if($_GET['ggg']) {
	$key = $_GET['ggg'];
	$data = $redis->lrange($key,0,-1);    
	print_r($data);	
}

// 查询总数 
if($_GET['search']) {
	$data = $redis->lrange($key,0,-1);    
	print_r($data);
} 

// 清除缓存
if($_GET['clean']) {
	$redis->delete('r_userinsert');
	$redis->delete('group_1');
	$redis->delete('group_2');
	$redis->delete('group_3');
}

if($_GET['test']=='push') {
	
	$num = $_GET['num'];// 数量
	$key = 'r_userinsert';	
	$data['sig'] ='DDD';	
	for($i=0;$i<=100000;$i++) {
		$data['num'] = mt_rand(1,3);		
		$data['addtime'] = date('Y-m-d H:i:s');
		$value = json_encode( $data );
		$redis->lpush($key,$value); 
	}
	
	$t2 = microtime(true);
	echo '耗时'.round($t2-$t1,3).'秒';
}

if($_GET['get'] == 'sredis'){
	$key = 'r_userinsert';   
	$data['num'] = mt_rand(1,3);		
	$data['sig'] = 55;//md5(date('Y-m-d H:i:s'));		
	$data['addtime'] = date('Y-m-d H:i:s');
	$value = json_encode( $data );
	$redis->lpush($key,$value); 		
}



