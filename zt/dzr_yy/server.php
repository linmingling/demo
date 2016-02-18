<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');


if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
    	$name = $_POST['name'];
    	$phone = $_POST['tel'];
    	$province = trim($_POST['prov']);
    	$city = $_POST['city'];
    	
    	if(empty($name)){
    		$ajax_result['code'] = 1001;
    		$ajax_result['msg'] = "姓名不能为空";
    		die(json_encode($ajax_result));
    	}
    	if(empty($phone)){
    	    $ajax_result['code'] = 1001;
    	    $ajax_result['msg'] = "手机号码不能为空";
    	    die(json_encode($ajax_result));
    	}
    	if(empty($province)){
    	    $ajax_result['code'] = 1001;
    	    $ajax_result['msg'] = "省份不能为空";
    	    die(json_encode($ajax_result));
    	}
    	if(empty($city)){
    	    $ajax_result['code'] = 1001;
    	    $ajax_result['msg'] = "城市不能为空";
    	    die(json_encode($ajax_result));
    	}
    
    	$sql = "UPDATE dzr_yy SET name='".$name."',phone='".$phone."',province='".$province."',city='".$city."' WHERE openid='".$_SESSION['dzr_openid']."'";
        $url = mysqli_query($db, $sql);
    	if($url){
    		$ajax_result['code'] = 0;
    		$ajax_result['id'] = mysqli_insert_id($db);
    		$ajax_result['msg'] = "提交成功";
    		die(json_encode($ajax_result));
    	} else {
    		$ajax_result['code'] = 1002;
    		$ajax_result['msg'] = "系统繁忙，请退出重试";
    		die(json_encode($ajax_result));
    	}
    }
    
    if($act == 'start' ){
        
        $sql = "SELECT * from dzr_yy WHERE openid='".$_SESSION['dzr_openid']."'";
        $res = mysqli_query($db, $sql);
        $result = array();
        while($row = $res->fetch_array()){
            $result = $row;
        }
        if($result['prize_name'] == '亲子游'){
            $ajax_result['errcode'] = 2001;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize_name'] = '您已中奖';
            die(json_encode($ajax_result));
        }
        if($result['num'] == 0){
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = 2;
            $ajax_result['num'] = 0;
            $ajax_result['prize_name'] = '次数已用完';
            die(json_encode($ajax_result));
        }
        $prize_info = array(
            0 => array('name' => '亲子游', 'num' => 1, 'gl' => 0),
            1 => array('name' => '谢谢参与', 'num' => 0, 'gl' => 100),
        );
        $start = 0;
        $type = rand(1, 100);
        foreach ($prize_info as $k => $key){
    
            $prize[$k]['start'] = $start + 1;
            $prize[$k]['end'] = $start + $key['gl'];
    
            $start = $prize[$k]['end'];
    
            if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){
                if($key['name'] == '亲子游'){
                    $sql = "SELECT COUNT(*) from dzr_yy WHERE prize_name='".$key['name']."'";
                    $res = mysqli_query($db, $sql);
                    $arr = array();
                    while($row = $res->fetch_array()){
                        $arr = $row;
                    }
                    if($arr[0] >= $key['num']){
                        $sql = "UPDATE dzr_yy SET prize_name='谢谢参与',num=num-1,draw_time='".time()."' WHERE openid='".$_SESSION['dzr_openid']."'";
                        mysqli_query($db, $sql);
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = 'ok';
                        $ajax_result['prize'] = 2;
                        $ajax_result['num'] = $result['num'] - 1;
                        $ajax_result['prize_name'] = '谢谢参与';
                        die(json_encode($ajax_result));
                    } else {
                        $sql = "UPDATE dzr_yy SET prize_name='".$key['name']."',num=num-1,draw_time='".time()."' WHERE openid='".$_SESSION['dzr_openid']."'";
                        mysqli_query($db, $sql);
                        $ajax_result['errcode'] = 0;
                        $ajax_result['errmsg'] = 'ok';
                        $ajax_result['prize'] = 1;
                        $ajax_result['num'] = $result['num'] - 1;
                        $ajax_result['prize_name'] = '中奖了';
                        die(json_encode($ajax_result));
                    }
                } else {
                    $sql = "UPDATE dzr_yy SET prize_name='谢谢参与',num=num-1,draw_time='".time()."' WHERE openid='".$_SESSION['dzr_openid']."'";
                    mysqli_query($db, $sql);
                    $ajax_result['errcode'] = 0;
                    $ajax_result['errmsg'] = 'ok';
                    $ajax_result['prize'] = 2;
                    $ajax_result['num'] = $result['num'] - 1;
                    $ajax_result['prize_name'] = '谢谢参与';
                    die(json_encode($ajax_result));
                }
            }
        }
    }
}

?>