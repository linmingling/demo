<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "submit"){

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		if(empty($phone)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}
		$address = mysqli_real_escape_string($db, $_POST['address']);
		if(empty($address)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "地址不能为空";
			die(json_encode($ajax_result));
		}
		
		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM huamei_expo WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已报名！";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO huamei_expo(name, phone, address, add_time, add_strtotime) VALUES('".$name."','".$phone."','".$address."','".$add_time."','".$add_strtotime."')";
			$url = mysqli_query($db, $sql);

			if($url){
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "恭喜您，报名成功！";
				die(json_encode($ajax_result));
			} else {
				$ajax_result['errcode'] = 1002;
				$ajax_result['errmsg'] = "系统繁忙，请退出重试";
				die(json_encode($ajax_result));
			}
		}
	}
}

?>