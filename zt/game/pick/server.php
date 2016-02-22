<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');
$lj_weixin = 'langjing_info';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['lj_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
		//die(json_encode($ajax_result));
	}

	// 时间判断得到期数
	$nowPer = '';
	
	$nowDate = date('Y-m-d H:i:s');
	//$timeQua = array("2015-11-08 00:00:00","2015-11-21 23:59:59","2015-12-01 23:59:59","2015-12-11 23:59:59","2015-12-21 23:59:59");
	// 测试用
	$timeQua = array("2015-11-06 00:00:00","2015-11-21 23:59:59","2015-12-01 23:59:59","2015-12-11 23:59:59");
	if (strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) >= strtotime($nowDate)) {
		$nowPer = 1;
	} else if(strtotime($timeQua[1]) < strtotime($nowDate) && strtotime($timeQua[2]) >= strtotime($nowDate)) {
		$nowPer = 2;
	} else if(strtotime($timeQua[2]) < strtotime($nowDate) && strtotime($timeQua[3]) >= strtotime($nowDate)) {
		$nowPer = 3;
	} else {
		$nowPer = 0;
	}
	
	//分数提交
	if($act == 'subScore')
	{
		
		if(empty($_SESSION['lj_openid'])){
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = 'session异常';
			die(json_encode($ajax_result));
		}
        
		$score = intval(decrypt(trim($_POST['score'])));
		
		/* if (!is_int($score)) {
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = '非法操作';
			die(json_encode($ajax_result));
		} */
		
		$check_sql = "select * from $lj_weixin where openid = '{$_SESSION['lj_openid']}' and periods = '{$nowPer}'";
		$check_res = mysqli_query($db, $check_sql);
		$check_row = $check_res->fetch_assoc();
		
		// 时间交接点
		if(empty($check_row)){
			$sql = "insert into $lj_weixin (openid,wechaname,headimgurl,add_time,periods) values ('{$_SESSION['lj_openid']}','{$_SESSION['lj_wechaname']}','{$_SESSION['lj_headurl']}','" . date('Y-m-d H:i:s') . "','{$nowPer}')";
			mysqli_query($db, $sql);
		}
					
		// 判断分数
		if ($check_row['score'] < $score) {
			$sql = "update $lj_weixin set score='{$score}' where openid = '{$_SESSION['lj_openid']}' and periods = '{$nowPer}'";
			mysqli_query($db, $sql);
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = 'ok';
		die(json_encode($ajax_result));
	}
	
	// 查询排行榜
	if ($act == 'search') {
		
		$nowPer = 1;
		
		if (isset($_POST['per'])) {
			$nowPer = trim($_POST['per']);
		}
		
		$sql = "select wechaname,headimgurl,score from $lj_weixin where score>0 and periods='{$nowPer}' order by score desc limit 30";
		$res = mysqli_query($db, $sql);
		
		$tmp = array();
		$i = 0;
		while($row = $res->fetch_assoc()) {
			$tmp[$i]['wechaname'] = $row['wechaname'];
			$tmp[$i]['headimgurl'] = $row['headimgurl'];		
			$tmp[$i]['score'] = $row['score'];
			$tmp[$i]['mingci'] = $i + 1;
			
			$i++;
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['paihang'] = $tmp;
		die(json_encode($ajax_result));
	}
	
}
?>