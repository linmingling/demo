<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "submit"){
		//提交信息
		$name = $_POST['name'];
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}

		$phone = $_POST['phone'];
		if(empty($phone)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}
		$company = $_POST['company'];
		if(empty($company)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "公司不能为空";
			die(json_encode($ajax_result));
		}
		$title = $_POST['title'];
		if(empty($title)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "职称不能为空";
			die(json_encode($ajax_result));
		}
		$add_time = date('Y-m-d H:i:s',time());
		$time = time();

		$sql = "INSERT INTO dzr_invite(name, phone, company, title, add_time, time) VALUES('".$name."','".$phone."','".$company."','".$title."','".$add_time."','".$time."')";
		$url = mysqli_query($db, $sql);

		if($url){
			$ajax_result['code'] = 2001;
			$ajax_result['msg'] = "报名成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}
	}
}

?>