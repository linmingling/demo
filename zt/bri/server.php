<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "trial"){

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		if(empty($phone)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "联系方式不能为空";
			die(json_encode($ajax_result));
		}
		$city = mysqli_real_escape_string($db, $_POST['city']);
		if(empty($city)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "请选择城市";
			die(json_encode($ajax_result));
		}
		$select = mysqli_real_escape_string($db, $_POST['select']);
		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM bri_sign_trial WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['code'] = 1;
			$ajax_result['msg'] = "该号码已申请过试用了，快去报名成为社会监察员吧！";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO bri_sign_trial(name, phone, city, choose, add_time, add_strtotime) VALUES('".$name."','".$phone."','".$city."','".$select."','".$add_time."','".$add_strtotime."')";
			$url = mysqli_query($db, $sql);

			if($url){
				$ajax_result['code'] = 2001;
				$ajax_result['id'] = mysqli_insert_id($db);
				$ajax_result['msg'] = "报名成功";
				die(json_encode($ajax_result));
			} else {
				$ajax_result['code'] = 0;
				$ajax_result['msg'] = "系统繁忙，请退出重试";
				die(json_encode($ajax_result));
			}
		}
	}

	if($act == "apply"){

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		if(empty($phone)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "联系方式不能为空";
			die(json_encode($ajax_result));
		}
		$city = mysqli_real_escape_string($db, $_POST['city']);
		if(empty($city)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "请选择城市";
			die(json_encode($ajax_result));
		}
		$address = mysqli_real_escape_string($db, $_POST['address']);
		if(empty($address)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "请填写详细地址";
			die(json_encode($ajax_result));
		}
		$type = $_POST['type'];
		$type_str = '';
		foreach ($type as $k => $key){
			$type_str .= $key.' ';
		}
		$sex = mysqli_real_escape_string($db, $_POST['sex']);
		$types = mysqli_real_escape_string($db, $type_str);
		$ishealth = mysqli_real_escape_string($db, $_POST['ishealth']);
		$isanimal = mysqli_real_escape_string($db, $_POST['isanimal']);
		$issmoking = mysqli_real_escape_string($db, $_POST['issmoking']);
		$isdec = mysqli_real_escape_string($db, $_POST['isdec']);
		$isclean = mysqli_real_escape_string($db, $_POST['isclean']);
		$xy = mysqli_real_escape_string($db, $_POST['xy']);

		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM bri_sign_apply WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['code'] = 1;
			$ajax_result['msg'] = "该号码已登记";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO bri_sign_apply(name, phone, sex, city, address, type, ishealth, issmoking, isdec, isanimal, isclean, xy, add_time, add_strtotime) VALUES('".$name."','".$phone."','".$sex."','".$city."','".$address."','".$types."','".$ishealth."','".$issmoking."','".$isdec."','".$isanimal."','".$isclean."','".$xy."','".$add_time."','".$add_strtotime."')";
			$url = mysqli_query($db, $sql);

			if($url){
				$ajax_result['code'] = 2001;
				$ajax_result['id'] = mysqli_insert_id($db);
				$ajax_result['msg'] = "登记成功";
				die(json_encode($ajax_result));
			} else {
				$ajax_result['code'] = 0;
				$ajax_result['msg'] = "系统繁忙，请退出重试";
				die(json_encode($ajax_result));
			}
		}
	}
}

?>