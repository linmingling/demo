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
			$ajax_result['errmsg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, trim($_POST['phone']));
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}
		$address = mysqli_real_escape_string($db, trim($_POST['address']));
		if(empty($address)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请填写地址";
			die(json_encode($ajax_result));
		}
		$acreage = mysqli_real_escape_string($db, trim($_POST['acreage']));
		if(empty($acreage)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请输入装修面积";
		    die(json_encode($ajax_result));
		}
		
		$age = mysqli_real_escape_string($db, trim($_POST['age']));
		if(empty($age)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请输入房龄";
		    die(json_encode($ajax_result));
		}
		
    	$sql = "SELECT id from hx101 WHERE phone='".$phone."'";
    	$res = mysqli_query($db, $sql);
    	$arr = array();
    	while($row = $res->fetch_array()){
    	    $arr = $row;
    	}
		if($arr){
	        $ajax_result['errcode'] = 1000;
	        $ajax_result['errmsg'] = "对不起，您已报过名了！";
	        die(json_encode($ajax_result));
		} else {
		    $sql = "INSERT INTO hx101(name, phone, address, acreage, age, add_time) VALUES('".$name."','".$phone."','".$address."','".$acreage."','".$age."','".date('Y-m-d H:i:s')."')";
		    $url = mysqli_query($db, $sql);
		    if(!$url){
		        echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
		    }
		    $ajax_result['errcode'] = 0;
		    $ajax_result['errmsg'] = "ok";
    		die(json_encode($ajax_result));
		}
    }
}
?>