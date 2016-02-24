<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$jlf_weixin = 'jlf_weixin_info';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['jlf2_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		//die(json_encode($ajax_result));
	}

	//登记
	if($act == 'dengji')
	{
        
		$type = 'mobile';
		$marital = $_POST['marital'];
		$income = $_POST['income'];
		$sex = $_POST['sex'];
		$age = $_POST['age'];
		
		// 信息完整
		if(empty($sex) || empty($marital) || empty($income) || empty($age))
		{
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = '信息填写不完整';
			die(json_encode($ajax_result));
		}
		
		$sql = "update $jlf_weixin set sex='{$sex}',marital='{$marital}',income='{$income}',age='{$age}',type='{$type}' where openid='{$_SESSION['jlf2_openid']}' and disting='1'";
		mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        die(json_encode($ajax_result));
	}
	
	
	//问卷提交
	if($act == 'mobSubmit')
	{
		//$ansStr = explode(",",$_POST['ans']); 
		$ansStr = $_POST['ans'];
		$person = $_POST['person'];
		$perNum = $_POST['perNum'];
		
		$sql = "update $jlf_weixin set q1='{$ansStr[0]}',q2='{$ansStr[1]}',q3='{$ansStr[2]}',q4='{$ansStr[3]}',q5='{$ansStr[4]}',q6='{$ansStr[5]}',q7='{$ansStr[6]}',q8='{$ansStr[7]}',q9='{$ansStr[8]}',q10='{$ansStr[9]}',person='{$person}',perNum='{$perNum}' where openid='{$_SESSION['jlf2_openid']}' and disting='1'";
		mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        die(json_encode($ajax_result));
	}

    if($act == 'start')
    {
        $check_sql = "select * from $jlf_weixin where openid='{$_SESSION['jlf2_openid']}' and disting='1'";
//        die($check_sql);
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if(!empty($check_row['prize_name']))
		{
			die(json_encode(array(
					'errcode'=>1005,
					'errmsg'=>"您已中过奖！",
					'prize'=>'1099'
			)));
		}
		
		if($check_row['is_prize'] <= 0)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"您的抽奖次数已用完！",
					'prize'=>'1099'
			)));
		}
		
		//     参数说明:忽略/概率/编号
		$p0 = array_fill(0,1,0);  //扫地机
		$p1 = array_fill(0,1,1);	//空气净化器
		$p2 = array_fill(0,1, 2);  //除螨机
		$p3 = array_fill(0,10, 3);  //智能手环
		$p4 = array_fill(0,5000,7);			

        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);
		$p_list = array(0,1,2);
		
		if(in_array($arr_m[$pn],$p_list))
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 0;
			mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
			$ajax_result['prize'] = 7;
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			
			
		
			mysqli_query($db,"begin");
			switch ($arr_m[$pn]) {
				case 0:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='扫地机',prize=99 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
					$ajax_result['priJso'] = '"lv":"一","name":"扫地机"';
					break;
				case 1:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='空气净化器',prize=2 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
					$ajax_result['priJso'] = '"lv":"二","name":"空气净化器"';
					break;
				case 2:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='除螨机',prize=4 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
					$ajax_result['priJso'] = '"lv":"三","name":"除螨机"';
					break;
				case 3:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='智能手环',prize=6 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
					$ajax_result['priJso'] = '"lv":"四","name":"智能手环"';
					break;
				default:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1 where openid='{$_SESSION['jlf2_openid']}' and disting='1'");
					$ajax_result['priJso'] = '"lv":"","name":""';
					break;
			}
			mysqli_query($db,"commit");
			
			$ajax_result['prize'] = $arr_m[$pn];			
		
			die(json_encode($ajax_result));
        }
    }

    if($act == 'share')
    {
		$sql = "update $jlf_weixin set is_prize=is_prize+1 where openid='{$_SESSION['jlf2_openid']}' and disting='1'";
		mysqli_query($db,$sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));
        
    }
	
}
?>