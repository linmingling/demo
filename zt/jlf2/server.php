<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$type = 'pc';
if($_POST)
{
    $act = $_POST['act'];
	// 问卷提交
	if($act == 'submitAns')
	{
		$baseStr = $_POST['base'];		
		$arr =explode(",",$baseStr); 
        //$type = $_POST['type'];
        $sex = $arr[0];
		$marital = $arr[1];
        $income = $arr[2];        
		$age = $arr[3];
        $ansStr = $_POST['ans'];

		$sub = submitInfo($sex,$marital,$income,$age,$type,$db);
		$upd = updateQuest($type,$ansStr,$db);
		
		$ajax_result['errcode'] = 0;
		$ajax_result['resType'] = 'ok';
		die(json_encode($ajax_result));
	}

    if($act == 'start')
    {
        $phone = $_POST['phone'];
        $check_sql = "select * from jlf where phone='$phone' and disting = '1'";
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
		$p0 = array_fill(0,100,0);  
		$p1 = array_fill(0,1,1);	//扫地机
		$p2 = array_fill(0,100, 2);  
		$p3 = array_fill(0,5, 3);  //运动手环
		$p4 = array_fill(0,100,4);		
		$p5 = array_fill(0,1, 5);	//空气净化器
		$p6 = array_fill(0,100, 6);     
		$p7 = array_fill(0,5, 7);	//运动手环
		$p8 = array_fill(0,100, 8);     
		$p9 = array_fill(0,1, 9);	//除螨机		

        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);
		$p_list = array(1,5,9);
		
		if(in_array($arr_m[$pn],$p_list))
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 0;
			mysqli_query($db,"update jlf set is_prize=is_prize-1 where phone='$phone' and disting = '1'");
			$ajax_result['prize'] = 4;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = $arr_m[$pn];
			
		
			mysqli_query($db,"begin");
			switch ($arr_m[$pn]) {
				case 1:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='扫地机',prize=0 where phone='$phone' and disting = '1'");
					break;
				case 3:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='智能运动手环',prize=6 where phone='$phone' and disting = '1'");
					break;
				case 5:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='空气净化器',prize=2 where phone='$phone' and disting = '1'");
					break;
				case 7:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='智能运动手环',prize=6 where phone='$phone' and disting = '1'");
					break;
				case 9:
					mysqli_query($db,"update jlf set is_prize=is_prize-1,prize_name='除螨机',prize=4 where phone='$phone' and disting = '1'");
					break;
				default:
					mysqli_query($db,"update jlf set is_prize=is_prize-1 where phone='$phone' and disting = '1'");
					break;
			}
			mysqli_query($db,"commit");
		
			die(json_encode($ajax_result));
        }
    }

    if($act == 'add')
    {
		
		$name = $_POST['name'];
        $phone = $_POST['mobile'];
		
        if((isset($name) && empty($name)) || empty($phone))
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

        $check_sql = "select phone from jlf where phone='{$phone}' and disting = '1'";
//        echo $check_sql;
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();

        //第一次填手机和姓名
        if(empty($check_row) && isset($name)) 
        {
            $sql = "insert into jlf (name,phone,add_time,disting) values ('{$name}','{$phone}','" . date('Y-m-d H:i:s') . "','1')";
            mysqli_query($db,$sql);

            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "您的信息已提交！";
            die(json_encode($ajax_result));
        }

        //第二次填手机姓名
        if(!empty($check_row) && isset($name)) 
        {
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
function submitInfo($sex='',$marital='',$income='',$age='',$type='',$db)
{
	// 信息完整
	if(empty($sex) || empty($marital) || empty($income) || empty($age))
	{
		$ajax_result['errcode'] = 1001;
		$ajax_result['errmsg'] = '信息填写不完整';
		die(json_encode($ajax_result));
	}
    

    $jlf_info = 'jlf_info';
	$sql = "insert into $jlf_info (sex,marital,income,age,type,disting) values ('{$sex}','{$marital}','{$income}','{$age}','{$type}','1')";
	mysqli_query($db,$sql);
	return true;
	

}

// 问卷
function updateQuest($type='',$ansStr='',$db)
{
    /*
	传入json字符串
	$ansStr = '{"1":"发顺丰到付","2":"发送到","3":"上的","4":"水电费"}';
	$score = json_decode($scoreStr,true);
	$ans = json_decode($ansStr,true);
    */
	$ans =explode(",",$ansStr); 
	
    $jlf_ans = 'jlf_ans';
	$sql = "insert into $jlf_ans (q1,q2,q3,q4,q5,q6,q7,q8,q9,q10,type,disting) values ('{$ans[0]}','{$ans[1]}','{$ans[2]}','{$ans[3]}','{$ans[4]}','{$ans[5]}','{$ans[6]}','{$ans[7]}','{$ans[8]}','{$ans[9]}','{$type}','1')";
	mysqli_query($db,$sql);
	return true;
}
?>