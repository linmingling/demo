<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$user_table = 'nature_117_user';
$prize_table = 'nature_117_prize';

if($_POST)
{

	$act = trim($_POST['act']);
	if(empty($_SESSION['nature_117_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		die(json_encode($ajax_result));
	}
	
	if($act == 'addinfo')
	{
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		$province = trim($_POST['province']);
		$city = trim($_POST['city']);
		$address = trim($_POST['address']);
		
		if(empty($name) || empty($phone) || empty($province) || empty($city) || empty($address))
		{
			die(json_encode(array(
					'errcode'=>1003,
					'errmsg'=>"请填写完整的信息！",
			)));
		}	
			
		if(strlen($phone) != "11")
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"该手机号码格式不正确，请重新输入！",
			)));
		}
		
		if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
		{
			die(json_encode(array(
					'errcode'=>1002,
					'errmsg'=>"非法手机号码，请重新输入！",
			)));
		}
		
		$sql = "update $user_table set name='$name',phone='$phone',province='$province',city='$city',address='$address' where openid='{$_SESSION['nature_117_openid']}'";
		mysqli_query($db, $sql);
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = $sql;
		die(json_encode($ajax_result));
		
	}
	
	if($act == 'start')
	{
		$check_sql = "select * from $user_table where openid='{$_SESSION['nature_117_openid']}'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if($check_row['is_prize'] > 0)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"您购买1元礼包的抽奖资格已使用，请返回首页前去免费领取代金券！",
					'prize'=>'1099'
			)));
		}
		
		//     参数说明:忽略/概率/编号
		$p0 = array_fill(0,139,0);
		$p1 = array_fill(0,10,1);	//一
		$p2 = array_fill(0,139, 2);  
		$p3 = array_fill(0,139, 3);  
		$p4 = array_fill(0,20,4);		//二
		$p5 = array_fill(0,139, 5);
		$p6 = array_fill(0,139, 6);
		$p7 = array_fill(0,50, 7);		//三
		$p8 = array_fill(0,139, 8);
		$p9 = array_fill(0,139, 9);
		$p10 = array_fill(0,1, 10);		//特
		$p11 = array_fill(0,139, 11);
		
		$arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);
		$p_list = array(1,4,7,10);
		
		$check_quantity_sql = "select quantity from $prize_table where prize_num={$arr_m[$pn]}";
		$check_quantity_res = mysqli_query($db,$check_quantity_sql);
		$check_quantity_row = $check_quantity_res->fetch_assoc();
		
		if($check_quantity_row['quantity'] == 0 && in_array($arr_m[$pn],$p_list))
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 0;
			mysqli_query($db,"update $user_table set is_prize=1 where openid='{$_SESSION['nature_117_openid']}'");
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = $arr_m[$pn];
			
			$code = substr((string)time(),2); 	//兑换码
			
			$ajax_result['errcode'] = $code;
		
			mysqli_query($db,"begin");
			switch ($arr_m[$pn]) {
				case 1:
					mysqli_query($db,"update $user_table set is_prize=1,prize_name='吸尘器',prize=1,prize_code=$code where openid='{$_SESSION['nature_117_openid']}'");
					break;
				case 4:
					mysqli_query($db,"update $user_table set is_prize=1,prize_name='四件套',prize=4,prize_code=$code where openid='{$_SESSION['nature_117_openid']}'");
					break;
				case 7:
					mysqli_query($db,"update $user_table set is_prize=1,prize_name='豆芽机',prize=7,prize_code=$code where openid='{$_SESSION['nature_117_openid']}'");
					break;
				case 10:
					mysqli_query($db,"update $user_table set is_prize=1,prize_name='门票',prize=10,prize_code=$code where openid='{$_SESSION['nature_117_openid']}'");
					break;
				default:
					mysqli_query($db,"update $user_table set is_prize=1 where openid='{$_SESSION['nature_117_openid']}'");
					break;
			}
			mysqli_query($db,"commit");
		
			mysqli_query($db,"begin");
			mysqli_query($db,"update $prize_table set quantity=quantity-1 where prize_num={$arr_m[$pn]}");
			mysqli_query($db,"commit");
		
			die(json_encode($ajax_result));
		}
	}
	
	if($act == 'shake')
	{
		$check_sql = "select * from $user_table where openid='{$_SESSION['nature_117_openid']}'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if($check_row['times'] <= 0)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"今日摇奖次数已用完，转发再抽1次！",
			)));
		}
		
		$arr = array();
		for($i=1;$i<=6;)
		{
			if($check_row['q_' . $i] == 0)
			{
				array_push($arr, $i);
			}
			
			$i++;
		}
		
		if(count($arr) == 0)
		{
			die(json_encode(array(
					'errcode'=>1009,
					'errmsg'=>'您已获得所有券了',
			)));
		}
		
		shuffle($arr);
		
		$pn = mt_rand(0,count($arr)-1);
// 		print_r($pn);die;
		$code = $arr[$pn];
		
		$sql = "update $user_table set q_$code=1,times=times-1 where openid='{$_SESSION['nature_117_openid']}'";
		mysqli_query($db, $sql);
		
		die(json_encode(array(
				'errcode'=>0,
				'errmsg'=>$code,
		)));
	}
	
	if($act == 'check')
	{
		$check_sql = "select * from $user_table where openid='{$_SESSION['nature_117_openid']}' and phone>0";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if(!empty($check_row)) //已填资料
		{
			die(json_encode(array(
					'errcode'=>1,
					'errmsg'=>'ok',
			)));
		}
		else  //未填
		{
			die(json_encode(array(
					'errcode'=>0,
					'errmsg'=>'empty',
			)));
		}
	}
	
	if($act == 'addtimes')
	{
		$sql = "update $user_table set times=times+1 where openid='{$_SESSION['nature_117_openid']}'";
		mysqli_query($db,"begin");
		mysqli_query($db,$sql);
		mysqli_query($db,"commit");
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = 'ok';
		die(json_encode($ajax_result));
	}
	
	
}

?>