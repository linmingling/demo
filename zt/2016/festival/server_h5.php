<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';
$fest_pond = 'festival2016_ld_pond';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['fest_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		//die(json_encode($ajax_result));
	}

	//登记
	if($act == 'sub')
	{
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		
		// 信息完整
		if(empty($name) || empty($phone))
		{
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = '请填写姓名或手机号';
			die(json_encode($ajax_result));
		}
		
		$mem_sql = "select * from $fest_user where name='{$name}' and phone='{$phone}' and phone <> ''";
		$mem_res = mysqli_query($db, $mem_sql);
		$mem_row = $mem_res->fetch_assoc();
		
		if(empty($mem_row)) //用户信息不存在
		{
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = '用户信息不正确';
			die(json_encode($ajax_result));
		}
		
		$oid_sql = "select * from $fest_weixin where openid='{$_SESSION['fest_openid']}'";
		
		$ajax_result['errcode'] = 1006;
			$ajax_result['errmsg'] = $sql;
			die(json_encode($ajax_result));
		

		$oid_res = mysqli_query($db, $oid_sql);
		$oid_row = $oid_res->fetch_assoc();
		
		//user_id存在该微信号
		if(!empty($oid_row['user_id']))
		{
			$ajax_result['errcode'] = 1004;
			$ajax_result['errmsg'] = '您已登记';
			die(json_encode($ajax_result));
		}
		
		// 判断用户是否登记
		$mems_sql = "select * from $fest_weixin where user_id='{$mem_row['user_id']}'";
		$mems_res = mysqli_query($db, $mems_sql);
		$mems_row = $mems_res->fetch_assoc();
		
		//user_id存在festival2016_ld表
		if(!empty($mems_row))
		{
			$ajax_result['errcode'] = 1003;
			$ajax_result['errmsg'] = '该用户信息已登记';
			die(json_encode($ajax_result));
		}
		
		// 关联Festival2016_ld_user和Festival2016_ld
		$sql = "update $fest_weixin set user_id='{$mem_row['user_id']}' where openid='{$_SESSION['fest_openid']}'";		
		mysqli_query($db, $sql);
		
        $ajax_result['errcode'] = 0;
        die(json_encode($ajax_result));
	}
	
}
?>