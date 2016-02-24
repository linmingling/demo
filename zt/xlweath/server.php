<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
    	$openid = $_SESSION['yyys_openid'];
    	$wechaname = $_SESSION['yyys_wechaname'];
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
		$address = mysqli_real_escape_string($db, trim($_POST['address']));
		if(empty($address)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请选择城市";
			die(json_encode($ajax_result));
		}
		$goods_name = mysqli_real_escape_string($db, trim($_POST['goods_name']));
		if(empty($goods_name)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择套餐";
		    die(json_encode($ajax_result));
		}
		
		$num_sql = "SELECT COUNT(*) from order_list WHERE is_pay=1 AND goods_name='".$goods_name."'";
		$res = mysqli_query($db, $num_sql);
		$num_arr = array();
		while($num_row = $res->fetch_array()){
		    $num_arr = $num_row;
		}
		if(intval($num_arr[0]) >= 500){
		    $ajax_result['errcode'] = 1000;
		    $ajax_result['errmsg'] = "对不起，该套餐申购人数已达上限,您可以尝试选择其他套餐！";
		    die(json_encode($ajax_result));
		}
		
		$mch_billno = date('Ymdhis').rand(10000, 99999);
    	$sql = "SELECT id,is_pay from order_list WHERE openid='".$openid."'";
    	$res = mysqli_query($db, $sql);
    	$arr = array();
    	while($row = $res->fetch_array()){
    	    $arr = $row;
    	}
		if($arr){
		    if(!empty($arr['is_pay'])){
		        $ajax_result['errcode'] = 1000;
		        $ajax_result['errmsg'] = "对不起，您已经申购过了！";
		        die(json_encode($ajax_result));
		    } else {
		        $up_sql = "UPDATE order_list SET openid='".$openid."',wechaname='".$wechaname."',goods_name='".$goods_name."',address='".$address."',phone='".$phone."',consignee='".$name."',add_time='".date('Y-m-d H:i:s')."' WHERE openid='".$openid."'";
		        mysqli_query($db, $up_sql);
		        $ajax_result['errcode'] = 0;
		        $ajax_result['errmsg'] = "ok";
		        $ajax_result['id'] = intval($arr['id']);
		        die(json_encode($ajax_result));
		    }
		} else {
		    $sql = "INSERT INTO order_list(openid, wechaname, mch_billno, goods_name, total_amount, address, phone, consignee, is_pay, add_time) VALUES('".$openid."','".$wechaname."','".$mch_billno."','".$goods_name."','1.00','".$address."','".$phone."','".$name."','0','".date('Y-m-d H:i:s')."')";
		    $url = mysqli_query($db, $sql);
		    if(!$url){
		       $ajax_result['errcode'] = 1001;
		       $ajax_result['errmsg'] = "服务器繁忙，请稍后重试！";
		       die(json_encode($ajax_result));
		    }
		    $ajax_result['errcode'] = 0;
		    $ajax_result['errmsg'] = "ok";
		    
		    $last_id = mysqli_insert_id($db);
		    $strlen = strlen($last_id);
		    $a = '';
		    if($strlen < 4){
		        for ($i=0;$i<(4-$strlen);$i++){
		            $a = $a.'0';
		        }
		        $sn = "2015".$a.$last_id;
		    } else {
		        $sn = "2015".$last_id;
		    }
		    $up_sql = "UPDATE order_list SET sn='".$sn."' WHERE openid='".$openid."'";
		    mysqli_query($db, $up_sql);
    		$ajax_result['id'] = intval($last_id);
    		die(json_encode($ajax_result));
		}
    }
    
    if($act == "find"){
        $openid = $_SESSION['yyys_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        $sql = "SELECT sn,is_pay from order_list WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $arr = array();
        while($row = $res->fetch_array()){
            $arr = $row;
        }
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        $ajax_result['sn'] = $arr['sn'];
        $ajax_result['pay'] = intval($arr['is_pay']);
        die(json_encode($ajax_result));
    }
}
?>