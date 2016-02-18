<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');


if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
    	$openid = $_SESSION['com_openid'];
    	
    	if(empty($openid)){
    		$ajax_result['errcode'] = 1001;
    		$ajax_result['errmsg'] = "由于网络波动，你的登录信息已失效，请关闭此页面，重新打开！";
    		die(json_encode($ajax_result));
    	}
    	
    	$sql = "SELECT id,is_receive from com_share WHERE openid='".$openid."'";
    	$res = mysqli_query($db, $sql);
    	$arr = array();
    	while($row = $res->fetch_array()){
    	    $arr = $row;
    	}
		if($arr){
		    if(!empty($arr['is_receive'])){
		        $ajax_result['errcode'] = 1000;
		        $ajax_result['errmsg'] = "对不起，你已领取过奖品了！";
		        die(json_encode($ajax_result));
		    } else {
	            $up_sql = "UPDATE com_share SET is_receive=1 WHERE openid='".$_SESSION['com_openid']."'";
	            mysqli_query($db, $up_sql);
	            $ajax_result['errcode'] = 0;
	            $ajax_result['errmsg'] = "领取成功！";
	            die(json_encode($ajax_result));
		    }
		} else {
    		$ajax_result['errcode'] = 1000;
    		$ajax_result['errmsg'] = "请先摇一摇，再来领奖吧！";
    		die(json_encode($ajax_result));
		}
    }
    
    if($act == 'start' ){
        
        $openid = $_SESSION['com_openid'];
        $sql = "SELECT id,prize_code from com_share WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $arr = array();
        while($row = $res->fetch_array()){
            $arr = $row;
        }
        if(!empty($arr['prize_code'])){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = '你已经中过奖了，快去领取奖品吧！';
            die(json_encode($ajax_result));
        }
        
        $prize_info = array(
            1 => array('name' => '智能扫地机', 'num' => 28, 'gl' => 20),
            2 => array('name' => '七夕公仔', 'num' => 70, 'gl' => 80),
        );
        $start = 0;
        $type = rand(1, 100);
        foreach ($prize_info as $k => $key){
        
            $prize[$k]['start'] = $start + 1;
            $prize[$k]['end'] = $start + $key['gl'];
        
            $start = $prize[$k]['end'];
        
            if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){
                
                $sql = "SELECT COUNT(*) from com_share WHERE prize_code='".$k."'";
                $res = mysqli_query($db, $sql);
                $arr = array();
                while($row = $res->fetch_array()){
                    $arr = $row;
                }
                if($arr[0] >= $key['num']){
                    if($k == 1){
                        $prize_code = 2;
                    } else {
                        $prize_code = 1;
                    }
                    $sql = "SELECT COUNT(*) from com_share WHERE prize_code='".$prize_code."'";
                    $res = mysqli_query($db, $sql);
                    $arr = array();
                    while($row = $res->fetch_array()){
                        $arr = $row;
                    }
                    if($arr[0] >= $prize_info[$prize_code]['num']){
                        $ajax_result['errcode'] = 1002;
                        $ajax_result['errmsg'] = '你来慢了，所有的奖品都被领光了！';
                        die(json_encode($ajax_result));
                    } else {
                        $data = "【获奖用户】:".$_SESSION['com_openid']."\n奖项名称：".$prize_info[$prize_code]['name']."\n";
                        _log($data);
                        
                        $sql = "UPDATE com_share SET prize_code='".$prize_code."',prize='".$prize_info[$prize_code]['name']."' WHERE openid='".$_SESSION['com_openid']."'";
                        mysqli_query($db, $sql);
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = 'ok';
                        $ajax_result['prize_code'] = $prize_code + 1;
                        die(json_encode($ajax_result));
                    }
                } else {
                    $data = "【获奖用户】:".$_SESSION['com_openid']."\n奖项名称：".$key['name']."\n";
                    _log($data);
                    
                    $sql = "UPDATE com_share SET prize_code='".$k."',prize='".$key['name']."' WHERE openid='".$_SESSION['com_openid']."'";
                    mysqli_query($db, $sql);
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = 'ok';
                    $ajax_result['prize_code'] = $k + 1;
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