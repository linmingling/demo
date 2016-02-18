<?php
/**
* 提交信息
* 
*/
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '/config.php');
date_default_timezone_set("Asia/Shanghai");   //设置时区
if($_POST){
	if(!isset($_POST['act']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "非法请求";
		die(json_encode($ajax_result));		
	}
	
	$act = trim($_POST['act']);
    if($act == "addinfo")
    {
        $name = trim($_REQUEST['name']);//姓名
		$name = mysqli_real_escape_string($db,$name);//入库前过滤
        $phone = trim($_REQUEST['phone']);//电话

        if(empty($name) || empty($phone))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(strlen($phone) != "11")
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "非法手机号码，请重新输入！";
            die(json_encode($ajax_result));
        }

		//是否已经提交过
        $check_sql = "select id from cyc_reg where phone='{$phone}' and name ='{$name}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if(!empty($check_row['id']))
        {
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "你已经报过名啦！";
            die(json_encode($ajax_result));
        }		
		
        $check_sql1 = "select phone from cyc_reg where phone='{$phone}'";
        $check_res1 = mysqli_query($db,$check_sql1);
        $check_row1 = $check_res1->fetch_assoc();
        if(!empty($check_row1['phone']))
        {
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "该手机号码已经被使用过啦！";
            die(json_encode($ajax_result));
        }

		//提交报名信息
		$sql = "INSERT INTO cyc_reg(name, phone) VALUES('".$name."', '".$phone."')";
        mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    }
	else//请求错误
	{
        $ajax_result['errcode'] = 1004;
        $ajax_result['errmsg'] = "请求错误";
        die(json_encode($ajax_result));		
	}
}