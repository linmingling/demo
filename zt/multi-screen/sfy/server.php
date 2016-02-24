<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');


if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
    	$name = trim($_POST['name']);
    	$phone = trim($_POST['tel']);
    	$address = trim($_POST['address']);
    	
    	$prize_code = $_SESSION['prize_code'];
    	$prize = $_SESSION['prize'];
    	
    	if(empty($name)){
    		$ajax_result['errcode'] = 1001;
    		$ajax_result['errmsg'] = "姓名不能为空";
    		die(json_encode($ajax_result));
    	}
    	if(empty($phone)){
    	    $ajax_result['errcode'] = 1001;
    	    $ajax_result['errmsg'] = "手机号码不能为空";
    	    die(json_encode($ajax_result));
    	}
    	if(empty($address)){
    	    $ajax_result['errcode'] = 1001;
    	    $ajax_result['errmsg'] = "地址不能为空";
    	    die(json_encode($ajax_result));
    	}
    	
    	if(empty($prize_code) || empty($prize)){
    	    $ajax_result['errcode'] = 1001;
    	    $ajax_result['errmsg'] = "非法操作！";
    	    die(json_encode($ajax_result));
    	}
    	
    	$sql = "SELECT id from sfy WHERE phone='".$phone."'";
    	$res = mysqli_query($db, $sql);
    	$arr = array();
    	while($row = $res->fetch_array()){
    	    $arr = $row;
    	}
		if($arr){
    		$ajax_result['errcode'] = 1001;
    		$ajax_result['errmsg'] = "您已中过奖！";
    		die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO sfy (name, phone, address, prize_code, prize, add_time) VALUES('".$name."','".$phone."','".$address."','".$prize_code."','".$prize."','".date('Y-m-d H:i:s')."')";
			$res = mysqli_query($db, $sql);

			if($res){
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "信息提交成功！";
				die(json_encode($ajax_result));
			} else {
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = "系统繁忙，请退出重试";
				die(json_encode($ajax_result));
			}
		}
    }
    
    if($act == 'start' ){
        
        $prize_info = array(
            1 => array('name' => '索菲亚雨伞', 'num' => 5, 'gl' => 2),
            3 => array('name' => '索菲亚U盘', 'num' => 8, 'gl' => 2),
            5 => array('name' => '索菲亚LED灯', 'num' => 5, 'gl' => 2),
            4 => array('name' => '谢谢参与', 'num' => 0, 'gl' => 94),
        );
        $start = 0;
        $type = rand(1, 100);
        foreach ($prize_info as $k => $key){
        
            $prize[$k]['start'] = $start + 1;
            $prize[$k]['end'] = $start + $key['gl'];
        
            $start = $prize[$k]['end'];
        
            if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){
                
                $data = "【获奖记录】:\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
                _log($data);
                
                if($k != 4){
                    $sql = "SELECT COUNT(*) from sfy WHERE prize_code='".$k."'";
                    $res = mysqli_query($db, $sql);
                    $arr = array();
                    while($row = $res->fetch_array()){
                        $arr = $row;
                    }
                    if($arr[0] >= $key['num']){
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = 'ok';
                        $ajax_result['star'] = 4;
                        $ajax_result['prize_name'] = '谢谢参与';
                        die(json_encode($ajax_result));
                    } else {
                        $_SESSION['prize_code'] = $k;
                        $_SESSION['prize'] = $key['name'];
                        
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = 'ok';
                        $ajax_result['star'] = $k;
                        $ajax_result['prize_name'] = '中奖了';
                        die(json_encode($ajax_result));
                    }
                } else {
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = 'ok';
                    $ajax_result['star'] = 4;
                    $ajax_result['prize_name'] = '谢谢参与';
                    die(json_encode($ajax_result));
                }
            }
        }
    }
}
function _log($data){
    $log_name = "log.txt";	//log文件路径
    $fp = fopen($log_name, "a");
    flock($fp, LOCK_EX);
    fwrite($fp, "执行日期：".date('Y-m-d H:i:s')."\n".$data."\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}
?>