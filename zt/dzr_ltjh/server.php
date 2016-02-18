<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
    	$openid = $_SESSION['dzr_ltjh_openid'];
    	if(empty($openid)){
    		$ajax_result['errcode'] = 1001;
    		$ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
    		die(json_encode($ajax_result));
    	}
    	
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
 
        $up_sql = "UPDATE dzr_ltjh SET name='".$name."',phone='".$phone."' WHERE openid='".$openid."'";
        mysqli_query($db, $up_sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));

    }
    
    if($act == "winning"){
        $openid = $_SESSION['dzr_ltjh_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        $sql = "UPDATE dzr_ltjh SET is_winning=1 WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
       
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));
    }
}
?>