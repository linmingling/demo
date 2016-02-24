<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');


if($_POST){
	//提交数据

	$name = $_POST['name'];
	$name = strip_tags($name, "");
	if(empty($name)){
		$ajax_result['code'] = 1001;
		$ajax_result['msg'] = "姓名不能为空";
		die(json_encode($ajax_result));
	}
	$phone = trim($_POST['tel']);
	$province = trim($_POST['prov']);
	$city = trim($_POST['city']);

	$add_time = date('Y-m-d H:i:s',time());
	$strtotime = time();

	$sql = "INSERT INTO ltle(name, phone, province, city, add_time, strtotime) VALUES('".$name."','".$phone."','".$province."','".$city."','".$add_time."','".$strtotime."')";
	$url = mysqli_query($db, $sql);

	if($url){
		$ajax_result['code'] = 2001;
		$ajax_result['id'] = mysqli_insert_id($db);
		$ajax_result['msg'] = "登记成功";
		die(json_encode($ajax_result));
	} else {
		$ajax_result['code'] = 1002;
		$ajax_result['msg'] = "系统繁忙，请退出重试";
		die(json_encode($ajax_result));
	}
}

?>