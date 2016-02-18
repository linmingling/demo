<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "trial"){

		$firm = mysqli_real_escape_string($db, $_POST['firm']);
		if(empty($firm)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "公司名称不能为空";
			die(json_encode($ajax_result));
		}
		
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
		$position = mysqli_real_escape_string($db, $_POST['post']);
		if(empty($position)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "职位不能为空";
			die(json_encode($ajax_result));
		}
		
		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM dzr520 WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['code'] = 1;
			$ajax_result['msg'] = "您已报名！";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO dzr520(firm, name, position, phone, add_time, add_strtotime) VALUES('".$firm."','".$name."','".$position."','".$phone."','".$add_time."','".$add_strtotime."')";
			$url = mysqli_query($db, $sql);

			if($url){
				$ajax_result['code'] = 2001;
				$ajax_result['id'] = mysqli_insert_id($db);
				$ajax_result['msg'] = "恭喜您，报名成功！";
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