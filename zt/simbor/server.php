<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
    	
		$name = mysqli_real_escape_string($db, trim($_POST['name']));
		if(empty($name)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请填写姓名！";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, trim($_POST['phone']));
		if(empty($phone)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请填写手机号！";
		    die(json_encode($ajax_result));
		}
		$province = mysqli_real_escape_string($db, trim($_POST['province']));
		if(empty($province)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择省份！";
		    die(json_encode($ajax_result));
		}
		$city = mysqli_real_escape_string($db, trim($_POST['city']));
		if(empty($city)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择城市！";
		    die(json_encode($ajax_result));
		}
		$need = mysqli_real_escape_string($db, trim($_POST['need']));
		if(empty($need)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择需求！";
		    die(json_encode($ajax_result));
		}
		
		$sql = "SELECT id from simbor WHERE phone='".$phone."'";
		$res = mysqli_query($db, $sql);
		$arr = array();
		while($row = $res->fetch_array()){
		    $arr = $row;
		}
		if($arr){
		    $ajax_result['errcode'] = 1000;
		    $ajax_result['errmsg'] = "对不起，您已经报过名了！";
		    die(json_encode($ajax_result));
		} else {
    	    $sql = "INSERT INTO simbor(name, phone, province, city, need, add_time) VALUES('".$name."','".$phone."','".$province."','".$city."','".$need."','".date('Y-m-d H:i:s')."')";
    	    $url = mysqli_query($db, $sql);
    	    if(!$url){
    	       $ajax_result['errcode'] = 1000;
    	       $ajax_result['errmsg'] = "服务器繁忙，请稍后重试！";
    	    } else {
    	        $ajax_result['errcode'] = 0;
    	        $ajax_result['errmsg'] = "报名成功！";
    	    }
    		die(json_encode($ajax_result));
		}
	}
}
?>