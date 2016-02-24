<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
    	
        $textarea = mysqli_real_escape_string($db, trim($_POST['textarea']));
		if(empty($textarea)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请填写告白内容！";
			die(json_encode($ajax_result));
		}
		$name = mysqli_real_escape_string($db, trim($_POST['name']));
		if(empty($name)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请填写TA的称呼！";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, trim($_POST['phone']));
		if(empty($phone)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请填写联系电话！";
		    die(json_encode($ajax_result));
		}
	    $sql = "INSERT INTO jomoo(textarea, name, phone, add_time) VALUES('".$textarea."','".$name."','".$phone."','".date('Y-m-d H:i:s')."')";
	    $url = mysqli_query($db, $sql);
	    if(!$url){
	       $ajax_result['errcode'] = 1000;
	       $ajax_result['errmsg'] = "服务器繁忙，请稍后重试！";
	    } else {
	        $ajax_result['errcode'] = 0;
	        $ajax_result['errmsg'] = "ok";
	    }
		die(json_encode($ajax_result));
		
	}
}
?>