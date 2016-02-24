<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$jlf_weixin = 'jlf_weixin_info';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['jlf_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		//die(json_encode($ajax_result));
	}

	
	//问卷提交
	if($act == 'mobSubmit')
	{
        
		$type = $_POST['type'];
		$marital = $_POST['marital'];
		$income = $_POST['income'];
		$sex = $_POST['sex'];
		$scoreStr = $_POST['scoreStr'];
		$ansStr = $_POST['ansStr'];
		
		// 信息完整
		if(empty($sex) || empty($marital) || empty($income))
		{
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = '信息填写不完整';
			die(json_encode($ajax_result));
		}
		$scoretoStr = implode(',',$scoreStr);
		
		
		$sum = array_sum($scoreStr);
		if ($sum >= 0 && $sum <= 5) {
			$resType = 1;
		} else if ($sum > 5 && $sum <= 10) {
			$resType = 2;
		} else if ($sum > 10 && $sum <= 15) {
			$resType = 3;
		} else if ($sum > 15) {
			$resType = 4;
		}
        //var_dump($scoreStr);die('aaa');
		
		$sql = "update $jlf_weixin set sex='{$sex}',marital='{$marital}',income='{$income}',type='{$type}',q1='{$ansStr[1]}',q2='{$ansStr[2]}',q3='{$ansStr[3]}',q4='{$ansStr[4]}',q5='{$ansStr[5]}',q6='{$ansStr[6]}',q7='{$ansStr[7]}',q8='{$ansStr[8]}',q9='{$ansStr[9]}',q10='{$ansStr[10]}',score='{$scoretoStr}' where openid='{$_SESSION['jlf_openid']}'";
//        die($sql);
		mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['resType'] = $resType;
        die(json_encode($ajax_result));
	}

    if($act == 'start')
    {
        $check_sql = "select * from $jlf_weixin where openid='{$_SESSION['jlf_openid']}'";
//        die($check_sql);
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if($check_row['is_prize'] <= 0)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"您的抽奖次数已用完！",
					'prize'=>'1099'
			)));
		}

		if(!empty($check_row['prize_name']))
		{
			die(json_encode(array(
					'errcode'=>1005,
					'errmsg'=>"您已中过奖！",
					'prize'=>'1099'
			)));
		}
		
		//     参数说明:忽略/概率/编号
		$p0 = array_fill(0,1,0);  //扫地机
		$p1 = array_fill(0,745,1);	
		$p2 = array_fill(0,2, 2);  //空气净化器
		$p3 = array_fill(0,745, 3);  
		$p4 = array_fill(0,3,4);		//除螨机
		$p5 = array_fill(0,745, 5);
		$p6 = array_fill(0,12, 6);     //智能手环
		$p7 = array_fill(0,745, 7);		

        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);
		$p_list = array(0,2,4,6);
		
		$check_quantity_sql = "select quantity from jlf_prize where prize_num={$arr_m[$pn]}";
		$check_quantity_res = mysqli_query($db,$check_quantity_sql);
		$check_quantity_row = $check_quantity_res->fetch_assoc();
		
		if($check_quantity_row['quantity'] == 0 && in_array($arr_m[$pn],$p_list))
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 0;
			mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1 where openid='{$_SESSION['jlf_openid']}'");
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = $arr_m[$pn];
			
		
			mysqli_query($db,"begin");
			switch ($arr_m[$pn]) {
				case 0:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='扫地机',prize=99 where openid='{$_SESSION['jlf_openid']}'");
					break;
				case 2:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='空气净化器',prize=2 where openid='{$_SESSION['jlf_openid']}'");
					break;
				case 4:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='除螨机',prize=4 where openid='{$_SESSION['jlf_openid']}'");
					break;
				case 6:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='智能手环',prize=6 where openid='{$_SESSION['jlf_openid']}'");
					break;
				default:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1 where openid='{$_SESSION['jlf_openid']}'");
					break;
			}
			mysqli_query($db,"commit");
		
			mysqli_query($db,"begin");
			mysqli_query($db,"update jlf_prize set quantity=quantity-1 where prize_num={$arr_m[$pn]}");
			mysqli_query($db,"commit");
		
			die(json_encode($ajax_result));
        }
    }

    if($act == 'add')
    {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        if(empty($name) || empty($address) || empty($phone))
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

        
        $sql = "update $jlf_weixin set name='$name',phone='$phone',address='$address' where openid='{$_SESSION['jlf_openid']}'";
        mysqli_query($db,$sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    

    }

    if($act == 'share')
    {
        $sql = "update $jlf_weixin set is_prize=is_prize+1 where openid='{$_SESSION['jlf_openid']}'";
        mysqli_query($db,$sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));
        
    }
	
}
?>