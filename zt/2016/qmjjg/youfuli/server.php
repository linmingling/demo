<?php
define('ROOT_PATH', dirname(__FILE__));
define('LOCK_FILE_PATH', ROOT_PATH . '../../../../data/lockFile');
require(ROOT_PATH . '../../../../data/config.php');
$prize = 'qmfl_prize';
$qmfl_weixin = 'qmfl_weixin_info';

$surplus = 0; //奖品剩余数
$nowDate = date('y-m-d h:i:s',time());
$timeQua = array("2016-02-06 00:00:00","2016-02-07 00:00:00","2016-02-08 00:00:00","2016-02-09 00:00:00");
$day = ''; // 几号

// 判断日期
if(strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) > strtotime($nowDate)){
	$day = 6;
}elseif(strtotime($timeQua[1]) <= strtotime($nowDate) && strtotime($timeQua[2]) > strtotime($nowDate)){
	$day = 7;
}elseif(strtotime($timeQua[2]) <= strtotime($nowDate) && strtotime($timeQua[3]) > strtotime($nowDate)){
	$day = 8;
}

if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['qmfl_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		die(json_encode($ajax_result));
	}

	// 抽奖
    if($act == 'draw')
    {	

		$check_sql = "select * from $qmfl_weixin where openid='{$_SESSION['qmfl_openid']}'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		// 判断是否已中奖
		if($check_row['is_prize']==1)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"您已中过奖！",
					'prize'=>'1098'
			)));
		}
		
		// 判断抽奖次数
		if($check_row['times'] <= 0)
		{
			die(json_encode(array(
					'errcode'=>1002,
					'errmsg'=>"您今天的抽奖次数已用完！",
					'prize'=>'1099'
			)));
		}
		
		//     参数说明:忽略/概率/编号
		$p0 = array_fill(0,100,0);  //1G流量
		$p1 = array_fill(0,100,1);	//50M流量
		$p2 = array_fill(0,200,2);  //未中
		$p3 = array_fill(0,100,3);  //QQ公仔
		$p4 = array_fill(0,100,4);	//100M流量	
		$p5 = array_fill(0,100,5);	//500M流量
		$p7 = array_fill(0,100,7);	//扫地机

        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p7);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);

		//文件写入，不存在就创建
		$fp = fopen( LOCK_FILE_PATH . '/lock_youfili.txt', "a" );
		if (!$fp) {			
			echo "Failed to create the lock file!";
			exit(1);//异常处理
		}
		
		// 上锁
		flock($fp,LOCK_EX);

		//此处添加原子操作代码
		//查询奖品剩余数量
		$check_quantity_sql = "select * from $prize where prize_id={$arr_m[$pn]}";
		$check_quantity_res = mysqli_query($db,$check_quantity_sql);
		$check_quantity_row = $check_quantity_res->fetch_assoc();
		
		if(!empty($check_quantity_row)){
			// 取当天对应的奖品剩余数
			if($day == 6){
				$surplus = $check_quantity_row["surplus6"];
			}elseif($day == 7){
				$surplus = $check_quantity_row["surplus7"];
			}elseif($day == 8){
				$surplus = $check_quantity_row["surplus8"];
			}
			
			if($surplus == 0)
			{
				//解锁
				flock($fp,LOCK_UN);
				fclose($fp);
				
				//奖品数量为0
				mysqli_query($db,"update $qmfl_weixin set times=times-1 where openid='{$_SESSION['qmfl_openid']}'");
				//返回未中状态
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = 'ok';
				$ajax_result['prize'] = 2;
				die(json_encode($ajax_result));
			}
			else
			{			
				switch ($arr_m[$pn]) {
					case 0:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=0,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//1G流量
						mysqli_query($db,"begin");
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=0");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					case 1:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=1,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//50M流量
						mysqli_query($db,"begin");
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=1");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					case 3:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=3,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//QQ公仔
						mysqli_query($db,"begin");
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=3");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					case 4:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=4,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//100M流量
						mysqli_query($db,"begin");					
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=4");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					case 5:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=5,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//500M流量
						mysqli_query($db,"begin");
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=5");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					case 7:
						mysqli_query($db,"update $qmfl_weixin set is_prize=1,prize_id=7,times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//扫地机
						mysqli_query($db,"begin");
						mysqli_query($db,"update $prize set surplus{$day}=surplus{$day}-1 where prize_id=7");//奖品数量减一
						mysqli_query($db,"commit");
						break;
					default:
						mysqli_query($db,"update $qmfl_weixin set times=times-1 where openid='{$_SESSION['qmfl_openid']}'");//未中
						break;
				}	
				//fwrite($fp,$_SESSION['qmfl_openid']."---".date('Y-m-d H:i:s')."\r\n"); 
				//sleep(5);	
				//解锁
				flock($fp,LOCK_UN);
				fclose($fp);
				
				//返回数据
				$ajax_result['errcode'] = 0;
				$ajax_result['prize'] = $arr_m[$pn];			
				die(json_encode($ajax_result));
			}
			
		}else{
			//解锁
			flock($fp,LOCK_UN);
			fclose($fp);
			
			//次数减1
			mysqli_query($db,"update $qmfl_weixin set times=times-1 where openid='{$_SESSION['qmfl_openid']}'");
			
			//抽到编号为2，返回未中状态
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 2;
			die(json_encode($ajax_result));
		}

    }

	
	//登记手机号
	if($act == 'dengji')
	{
        // 手机号登记对应微信号，不能重复登记		
		$phone = trim($_POST['phone']);
		
		// 信息完整
		if(empty($phone))
		{
			$ajax_result['errcode'] = 1005;
			$ajax_result['errmsg'] = '手机号不能为空';
			die(json_encode($ajax_result));
		}
		
		//验证手机号格式
		if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
		{
			$ajax_result['errcode'] = 1007;
			$ajax_result['errmsg'] = '手机号格式不正确';
			die(json_encode($ajax_result));
		}
		
		// 查找手机号是否存在表中
		$check_sql = "select phone from $qmfl_weixin where phone={$phone}";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if(!empty($check_row))
		{
			$ajax_result['errcode'] = 1006;
			$ajax_result['errmsg'] = '该手机号已登记';
			die(json_encode($ajax_result));
		}
		
		$sql = "update $qmfl_weixin set phone='{$phone}' where openid='{$_SESSION['qmfl_openid']}'";
		mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        die(json_encode($ajax_result)); 
	}
}
?>