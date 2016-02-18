<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
/*
* 状态码: 1000 参数异常，
*		  1001 
*/
$jlf_weixin = 'christmas';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['christmas_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		die(json_encode($ajax_result));
	}

	// 时间判断得到期数
	$nowDate = date('Y-m-d H:i:s');
	$timeArr = array('2015-12-24 0:0:0','2015-12-24 23:59:59',
					 '2015-12-25 0:0:0','2015-12-25 23:59:59',
					 '2015-12-26 0:0:0','2015-12-26 23:59:59'); // 时间段函数
	$nowPer = '';
	if(strtotime($timeArr['0']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['1'])) {
		$nowPer = 1;
	} else 	if(strtotime($timeArr['2']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['3'])) {
		$nowPer = 2;
	} else 	if(strtotime($timeArr['4']) <= strtotime($nowDate) && strtotime($nowDate) <= strtotime($timeArr['5'])) {
		$nowPer = 3;
	} else {
		$nowPer = 0;
	}
	
    if($act == 'start')
    {
        $check_sql = "select * from $jlf_weixin where openid='{$_SESSION['christmas_openid']}' and disting='1'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		// 判断活动是否过期
		if($nowPer=='' || $nowPer == 0)
		{
			die(json_encode(array(
					'errcode'=>1001,
					'errmsg'=>"不在抽奖活动时间段!",
					'prize'=>'1099'
			)));
		}			

		// 判断抽奖次数是否已用完
		if($check_row['is_prize'] <= 0)
		{
			die(json_encode(array(
					'errcode'=>1002,
					'errmsg'=>"您的抽奖次数已用完！",
					'prize'=>'1099'
			)));
		}

		// 判断是否已中过奖
		if(!empty($check_row['prize_name']))
		{
			die(json_encode(array(
					'errcode'=>1003,
					'errmsg'=>"您已中过奖！",
					'prize'=>'1099'
			)));
		}
		
		// 每天增加抽奖机会
		if($check_row['per'] < $nowPer)	{
			mysqli_query($db,"update $jlf_weixin set is_prize=100,per='".$nowPer."' where openid='{$_SESSION['christmas_openid']}'  and disting='1'");
		}			
		
		// 奖品id和数量设置
		$prizeArr = array('1'=>1,'2'=>40,'3'=>100);
		
		// 奖品编号数组
		$prizeNum = array(1,2,3);
	
		//     参数说明:忽略/概率/编号
		$p0 = array_fill(0,1,$prizeNum[0]);  //扫地机
		$p1 = array_fill(0,40,$prizeNum[1]);	//100M流量
		$p2 = array_fill(0,100, $prizeNum[2]);  //50M流量
		$p3 = array_fill(0,3000,4);// 100 为测试数据			

        $arr_m = array_merge($p0,$p1,$p2,$p3);
		shuffle($arr_m);
		
		//概率相加总和填入第二个参数
		$pn = mt_rand(0,count($arr_m) - 1);
		$p_list = $prizeNum;
		
		if(in_array($arr_m[$pn],$p_list))
		{
			// 判断当期奖品是否被领完
			$bb = $arr_m[$pn];
			$check1_sql = "select count(id) as count from $jlf_weixin where disting='1' and prize=".$arr_m[$pn]." and per=".$nowPer;
			$check1_res = mysqli_query($db,$check1_sql);
			$check1_row = null;
			$check1_row = $check1_res->fetch_assoc();		
			if(isset($check1_row['count']) && $check1_row['count'] >= $prizeArr[$bb]){
				// 本奖品已被领完
				mysqli_query($db,"update $jlf_weixin set per='".$nowPer."',is_prize=is_prize-1 where openid='{$_SESSION['christmas_openid']}' and disting='1'");
				$ajax_result['errcode'] = 1005;
				$ajax_result['errmsg'] = '今天奖品已经<br/>全部抽完，欢迎明天继续';
				$ajax_result['prize'] = 4;
				die(json_encode($ajax_result));
			}				
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
		
			mysqli_query($db,"begin");
			switch ($arr_m[$pn]) {
				case 1:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='扫地机',per='".$nowPer."',prize=1,last_time='".date('Y-m-d H:i:s')."' where openid='{$_SESSION['christmas_openid']}'  and disting='1'");
					$ajax_result['priJso'] = '一等奖:扫地机';
					break;
				case 2:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='100M流量',per='".$nowPer."',prize=2,last_time='".date('Y-m-d H:i:s')."' where openid='{$_SESSION['christmas_openid']}' and disting='1'");
					$ajax_result['priJso'] = '二等奖:100M流量';
					break;
				case 3:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,prize_name='50M流量',per='".$nowPer."',prize=3,last_time='".date('Y-m-d H:i:s')."' where openid='{$_SESSION['christmas_openid']}' and disting='1'");
					$ajax_result['priJso'] = '三等奖:50M流量';
					break;
				default:
					mysqli_query($db,"update $jlf_weixin set is_prize=is_prize-1,per='".$nowPer."' where openid='{$_SESSION['christmas_openid']}' and disting='1'");
					$ajax_result['priJso'] = '谢谢参与';
					break;
			}
			
			mysqli_query($db,"commit");
			
			$ajax_result['prize'] = $arr_m[$pn];			
			$ajax_result['is_win'] = true;
			die(json_encode($ajax_result));
        } else {
			// 没有抽到奖
			mysqli_query($db,"update $jlf_weixin set per='".$nowPer."',is_prize=is_prize-1 where openid='{$_SESSION['christmas_openid']}' and disting='1'");		
			$ajax_result['errcode'] = 1005;
			$ajax_result['errmsg'] = '谢谢参与';
			$ajax_result['prize'] = 4;
			die(json_encode($ajax_result));			
		}
	}
	
	// 接口说明
	//errcode  错误代码 0 表示没有错误
	//errmsg 错误信息
	//prize  奖品编号
	//priJso 只有中奖才有

    if($act == 'share')
    {
		$sql = "update $jlf_weixin set per='".$nowPer."',is_prize=is_prize+1 where openid='{$_SESSION['christmas_openid']}' and disting='1'";
		mysqli_query($db,$sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));
    }
	
	// 报名
	if($act == 'reg') {		
		$_POST['name'] = isset($_POST['name'])?$_POST['name']:'';
		$_POST['phone'] = isset($_POST['phone'])?$_POST['phone']:'';
		$_POST['address'] = isset($_POST['address'])?$_POST['address']:'';
		
		$sql = "update $jlf_weixin set name='".$_POST['name']."',phone='".$_POST['phone']."',address='".$_POST['address']."',per='".$nowPer."' where openid='{$_SESSION['christmas_openid']}' and disting='1'";
		$statu = mysqli_query($db,$sql);
		if($statu) {
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "报名成功";
		} else {
			$ajax_result['errcode'] = 1000;
			$ajax_result['errmsg'] = "报名失败!";
		}

        die(json_encode($ajax_result));		
	}
	
	// 检查剩余抽奖次数
	if($act == 'surplus') {
		// 判断活动是否过期
		if($nowPer=='' || $nowPer == 0)
		{
			$ajax_result['errcode'] = 1011;
			$ajax_result['errmsg'] = "不在抽奖活动时间段!";			
			$ajax_result['statu'] = false;		
			die(json_encode($ajax_result));			
		}
		
		$check_sql = "select prize_name from $jlf_weixin where openid='{$_SESSION['christmas_openid']}' and disting='1'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		// 判断是否已中过奖
		if(!empty($check_row['prize_name']))
		{
			die(json_encode(array(
					'errcode'=>10003,
					'errmsg'=>"您已中过奖！",
					'statu'=>false
			)));
		}		
		
		$check1_sql = "select is_prize from $jlf_weixin where openid='{$_SESSION['christmas_openid']}' and disting='1' and per=".$nowPer;
		$check1_res = mysqli_query($db,$check1_sql);
		$check1_row = null;
		$check1_row = $check1_res->fetch_assoc();	
		
		
		if(isset($check1_row['is_prize']) && $check1_row['is_prize'] > 0) {
			$ajax_result['errcode'] = 0;
			$ajax_result['statu'] = true;			
		} else {
			$ajax_result['errcode'] = 1000;
			$ajax_result['errmsg'] = "今天您的抽奖次数<br/>已抽完，欢迎明天继续参与";	
			$ajax_result['statu'] = false;					
		}
		
        die(json_encode($ajax_result));				
	}
}
?>