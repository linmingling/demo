<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
if($_POST)
{
    $act = $_POST['act'];
	// 问卷提交
	if($act == 'submitAns')
	{
        $type = $_POST['type'];
        $marital = $_POST['marital'];
        $income = $_POST['income'];
        $sex = $_POST['sex'];
        $scoreStr = $_POST['scoreStr'];
        $ansStr = $_POST['ansStr'];

		$sub = submitInfo($sex,$marital,$income,$type,$db);
		$upd = updateQuest($type,$scoreStr,$ansStr,$db);
		
		$ajax_result['errcode'] = 0;
		$ajax_result['resType'] = $upd;
		die(json_encode($ajax_result));
	}

    if($act == 'start')
    {
        $phone = $_POST['phone'];
        $check_sql = "select * from jlf where phone='$phone'";
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
			mysqli_query($db,"update jlf set is_prize=is_prize-1 where phone='$phone'");
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
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='扫地机',prize=99 where phone='$phone'");
					break;
				case 2:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='空气净化器',prize=2 where phone='$phone'");
					break;
				case 4:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='除螨机',prize=4 where phone='$phone'");
					break;
				case 6:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='智能手环',prize=6 where phone='$phone'");
					break;
				default:
					mysqli_query($db,"update jlf set is_prize=is_prize-1 where phone='$phone'");
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
        if(isset($_GET['check']) && $_GET['check'] == 1)
        {
            $name = $_POST['name'];
        }
        else
        {
            $address = $_POST['address'];
        }

        $phone = $_POST['phone'];
        if((isset($name) && empty($name)) || (isset($address) && empty($address)) || empty($phone))
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

        $check_sql = "select phone from jlf where phone='{$phone}'";
//        echo $check_sql;
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();

        //第一次填手机和姓名
        if(empty($check_row) && isset($name) && (isset($_GET['check']) && $_GET['check'] == 1)) 
        {
            $sql = "insert into jlf (name,phone,add_time) values ('{$name}','{$phone}','" . date('Y-m-d H:i:s') . "')";
            mysqli_query($db,$sql);

            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "您的信息已提交！";
            die(json_encode($ajax_result));
        }

        //第二次填手机姓名
        if(!empty($check_row) && isset($name) && (isset($_GET['check']) && $_GET['check'] == 1)) 
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "您的信息已提交！";
            die(json_encode($ajax_result));
        }

        //抽奖后信息填写
        if(!empty($check_row) && isset($address)) 
        {
            $sql = "update jlf set address='{$address}' where phone='$phone'";
            mysqli_query($db,$sql);

            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "您的信息已提交！";
            die(json_encode($ajax_result));
        }

        $ajax_result['errcode'] = 1004;
        $ajax_result['errmsg'] = "非法操作！";
        die(json_encode($ajax_result));

    }
}

// 填写信息
function submitInfo($sex='',$marital='',$income='',$type='',$db)
{
	// 信息完整
	if(empty($sex) || empty($marital) || empty($income))
	{
		$ajax_result['errcode'] = 1001;
		$ajax_result['errmsg'] = '信息填写不完整';
		die(json_encode($ajax_result));
	}
    

    $jlf_info = 'jlf_info';
	$sql = "insert into $jlf_info (sex,marital,income,type) values ('{$sex}','{$marital}','{$income}','{$type}')";
	mysqli_query($db,$sql);
	return true;
	

}

// 问卷
function updateQuest($type='',$scoreStr=array(),$ansStr=array(),$db)
{
    /*
	传入json字符串
	$scoreStr = '{"1":"1","2":"2","3":"3","4":"4"}';
	$ansStr = '{"1":"发顺丰到付","2":"发送到","3":"上的","4":"水电费"}';
	$score = json_decode($scoreStr,true);
	$ans = json_decode($ansStr,true);
    */

    $score = $scoreStr;
    $ans = $ansStr;
    $scoretoStr = implode(',',$scoreStr);
	
	// 计算分数
//	$sum = $score[1] + $score[2] + $score[3] + $score[4] + $score[5] + $score[6] + $score[7] + $score[8] + $score[9] + $score[10];

    $sum = array_sum($score);
	if ($sum >= 0 && $sum <= 5) {
		$resType = 1;
	} else if ($sum > 5 && $sum <= 10) {
		$resType = 2;
	} else if ($sum > 10 && $sum <= 15) {
		$resType = 3;
	} else if ($sum > 15) {
		$resType = 4;
	}
	
    $jlf_ans = 'jlf_ans';
	$sql = "insert into $jlf_ans (q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,score,type) values ('{$ans[1]}','{$ans[2]}','{$ans[3]}','{$ans[4]}','{$ans[5]}','{$ans[6]}','{$ans[7]}','{$ans[8]}','{$ans[9]}','{$ans[10]}','{$scoretoStr}','{$type}')";
	mysqli_query($db,$sql);
	
	return $resType;
	
}
?>