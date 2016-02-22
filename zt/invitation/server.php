<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "submit"){

	    $gs_name = mysqli_real_escape_string($db, $_POST['company']);
	    if(empty($gs_name)){
	        $ajax_result['errcode'] = 0;
	        $ajax_result['errmsg'] = "请填写您的公司名";
	        die(json_encode($ajax_result));
	    }
		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		if(empty($phone)){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "联系方式不能为空";
			die(json_encode($ajax_result));
		}
		
		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM invitation WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "您已经报过名了";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO invitation(gs_name, name, phone, add_time, add_strtotime) VALUES('".$gs_name."','".$name."','".$phone."','".$add_time."','".$add_strtotime."')";
			$url = mysqli_query($db, $sql);

			if($url){
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "ok";
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