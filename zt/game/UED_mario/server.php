<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');
$table = 'ued_game_lf_info';
if($_POST) 
{
    
	$act = trim($_POST['act']);
    if(empty($_SESSION['hegii_lf_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }
    
    // 时间判断得到期数
    /*
	$nowPer = '';
    $timeQua = array("2015-11-26 00:00:00","2015-12-09 23:59:59","2015-12-10 23:59:59","");
    $nowDate = date('Y-m-d H:i:s');
    if (strtotime($timeQua[0]) <= strtotime($nowDate) && strtotime($timeQua[1]) >= strtotime($nowDate)) {
    	$nowPer = 1;
    } else if(strtotime($timeQua[1]) < strtotime($nowDate) && strtotime($timeQua[2]) >= strtotime($nowDate)) {
    	$nowPer = 2;
    } else {
    	$nowPer = 0;
    }
	*/
	$nowDate = date('Y-m-d H:i:s');
	$nowPer = '';
	if(strtotime('2015-12-21 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-23 23:59:59')) {
		$nowPer = 1;
	} else 	if(strtotime('2015-12-24 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-27 23:59:59')) {
		$nowPer = 2;
	} else 	if(strtotime('2015-12-28 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2015-12-31 23:59:59')) {
		$nowPer = 3;
	} else 	if(strtotime('2016-1-1 00:00:00') <= strtotime($nowDate) && strtotime($nowDate) <= strtotime('2016-1-3 23:59:59')) {
		$nowPer = 4;
	} else {
		$nowPer = 0;
	}	
	
    if($act == "add")   //提交分数
    {
        $score = intval(decrypt(trim($_POST['score'])));
        
        $check_sql = "select * from {$table} where openid='{$_SESSION['hegii_lf_openid']}' and periods = '{$nowPer}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        
		$save = true;
		// 查询是否上一期已中奖
		if($nowPer > 1) {
			$bnowPer = $nowPer-1;
			// 排除以前中过奖的用户id
			$check_sql_record = "select openid,score from {$table} where periods = '{$bnowPer}' ORDER BY score DESC LIMIT 10";
			$check_res_record = mysqli_query($db,$check_sql_record);
			while($record = $check_res_record->fetch_assoc()) {
				if($record['openid'] == $_SESSION['hegii_lf_openid'])
				{
					$save = false;
					break;
				}
			}
		}
		
	
        // 时间交接点
        if(empty($check_row)){
        	$sql = "insert into $table (openid,wechaname,headimgurl,add_time,periods) values ('{$openId}','{$wechaname}','{$headurl}','" . date('Y-m-d H:i:s') . "','{$nowPer}')";
        	mysqli_query($db, $sql);
        }

		if($save) {
			if($check_row['score'] < $score)
			{
				$sql = "update {$table} set score={$score},last_play_time='" . date('Y-m-d H:i:s') . "',play_times=play_times+1,high_score_time='" . date('Y-m-d H:i:s') . "' where score<{$score} and openid='" . $_SESSION['hegii_lf_openid'] . "' and periods = '{$nowPer}'";
				mysqli_query($db, $sql);
			}else{
				$sql = "update {$table} set last_play_time='" . date('Y-m-d H:i:s') . "',play_times=play_times+1 where openid='" . $_SESSION['hegii_lf_openid'] . "' and periods = '{$nowPer}'";
				mysqli_query($db, $sql);
			}
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
		} else {
			$ajax_result['errcode'] = 1007;
			$ajax_result['errmsg'] = '你已经中过奖了，机会留给别人吧!';			
		}
        die(json_encode($ajax_result));
    }
	
	if($act == 'rank')  //排行榜
    {
    	$postPer = trim($_POST['per']);
    	if ($postPer == '1' && strtotime($nowDate) < strtotime("2015-12-21 00:00:00")) {
    		$postPer = '0';
    	}

		$sql = "select wechaname,headimgurl,score from {$table} where score>0 and periods='{$postPer}' order by score desc, high_score_time asc limit 15";
        $res = mysqli_query($db,$sql);
        
        $tmp = array();
		$i = 0;
		$wechaname = "";
		while($row = $res->fetch_assoc()) {
			$wechaname = substr_cut($row['wechaname'],2);
			$tmp[$i]['wechaname'] = $wechaname;	
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

//匿名处理
function substr_cut($str_cut, $length){
	if (strlen($str_cut) > $length){
		for($i=0; $i < $length; $i++){
			if (ord($str_cut[$i]) > 128){
				$i++;
			}
		}
		$str_cut = mb_substr($str_cut, 0, $i, 'utf-8').'**';
	}
	return $str_cut;
}
?>