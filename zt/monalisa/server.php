<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');


if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == 'is_start'){
        $openid = $_SESSION['monalisa_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        $sql = "SELECT phone,prize_code,surplus_num FROM monalisa WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $info = $res->fetch_assoc();
        if(!empty($info['prize_code']) && empty($info['phone'])){
            //中奖后未填信息
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize_code'] = $info['prize_code'];
            die(json_encode($ajax_result));
        }
        if($info['surplus_num'] <= 0){
            $ajax_result['errcode'] = 1005;
            $ajax_result['errmsg'] = '您的抽奖次数不足，分享给好友或朋友圈可增加1次抽奖机会！';
            die(json_encode($ajax_result));
        } else {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            die(json_encode($ajax_result));
        }
    }
    
    if($act == 'start'){
        
        $openid = $_SESSION['monalisa_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM monalisa WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $info = $res->fetch_assoc();
        if(!empty($info['prize_code']) && !empty($info['phone'])){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = '您已经中过奖了，将机会留给别人吧！';
            die(json_encode($ajax_result));
        }
        if(!empty($info['prize_code']) && empty($info['phone'])){
            //中奖后未填信息
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize_code'] = $info['prize_code'];
            die(json_encode($ajax_result));
        }
        if($info['surplus_num'] <= 0){
            $ajax_result['errcode'] = 1005;
            $ajax_result['errmsg'] = '您的抽奖次数不足，分享给好友或朋友圈可增加1次抽奖机会！';
            die(json_encode($ajax_result));
        }
        $prize_info = array(
            0 => array('name' => '谢谢参与', 'num' => 0, 'gl' => 100),
            1 => array('name' => '盛世金兰茶具套装', 'num' => 10, 'gl' => 0),
            2 => array('name' => '蒙娜丽莎彩瓷钥匙扣', 'num' => 30, 'gl' => 0),
            3 => array('name' => '蒙娜丽莎陶瓷装饰画', 'num' => 3, 'gl' => 0),
            4 => array('name' => 'IPhone 6S', 'num' => 0, 'gl' => 0),
            5 => array('name' => '话费5元', 'num' => 200, 'gl' => 0),
            6 => array('name' => '话费10元', 'num' => 110, 'gl' => 0),
            7 => array('name' => '话费30元', 'num' => 20, 'gl' => 0),
            8 => array('name' => '话费100元', 'num' => 3, 'gl' => 0),
        );
        $start = 0;
        $type = rand(1, 100);
        foreach ($prize_info as $k => $key){
        
            $prize[$k]['start'] = $start + 1;
            $prize[$k]['end'] = $start + $key['gl'];
        
            $start = $prize[$k]['end'];
        
            if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){
                
                if($k == 0){
                    updata($db, $k, $key['name'], $info);
                } else {
                    $sql = "SELECT COUNT(*) AS num FROM monalisa WHERE prize_code='".$k."'";
                    $res = mysqli_query($db, $sql);
                    $arr = $res->fetch_assoc();
                    if($arr['num'] >= $key['num']){
                        $data = "【获奖用户】:".$_SESSION['monalisa_openid']."\n奖项名称：".$key['name']."（库存不足）\n";
                        _log($data);
                        updata($db, 0, $prize_info[0]['name'], $info);
                    } else {
                        $data = "【获奖用户】:".$_SESSION['monalisa_openid']."\n奖项名称：".$key['name']."\n";
                        _log($data);
                        updata($db, $k, $key['name'], $info);
                    }
                }
            }
        }
    }
    
    if($act == "submit"){
    
        $openid = $_SESSION['monalisa_openid'];
        $name = mysqli_real_escape_string($db, trim($_POST['name']));
        $phone = mysqli_real_escape_string($db, trim($_POST['phone']));
        $province = mysqli_real_escape_string($db, trim($_POST['province']));
        $city = mysqli_real_escape_string($db, trim($_POST['city']));
        $address = mysqli_real_escape_string($db, trim($_POST['address']));
        
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        if(empty($name)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "姓名不能为空";
            die(json_encode($ajax_result));
        }
        if(empty($phone)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "请填写手机号码";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM monalisa WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $arr = $res->fetch_assoc();
        if($arr){
            if(!empty($arr['name']) && !empty($arr['phone'])){
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "您已提交过信息了，请勿重复提交！";
                die(json_encode($ajax_result));
            } else {
                $up_sql = "UPDATE monalisa SET name='".$name."',phone='".$phone."',province='".$province."',city='".$city."',address='".$address."' WHERE openid='".$_SESSION['monalisa_openid']."'";
                mysqli_query($db, $up_sql);
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "提交成功！";
                die(json_encode($ajax_result));
            }
        } else {
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "您还未中奖哦，快去摇一摇吧！";
            die(json_encode($ajax_result));
        }
    }
    
    if($act == "share"){
        $openid = $_SESSION['monalisa_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        $up_sql = "UPDATE monalisa SET surplus_num=surplus_num+1 WHERE openid='".$_SESSION['monalisa_openid']."'";
        mysqli_query($db, $up_sql);
        
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok";
        die(json_encode($ajax_result));
    }
}

function updata($db, $k, $prize_name, $info){
    $sql = "UPDATE monalisa SET prize_code='".$k."',prize='".$prize_name."',surplus_num=surplus_num-1,num=num+1,last_time='".date('Y-m-d H:i:s')."' WHERE openid='".$_SESSION['monalisa_openid']."'";
    mysqli_query($db, $sql);
    $ajax_result['errcode'] = 0;
    $ajax_result['errmsg'] = 'ok';
    $ajax_result['prize_code'] = $k;
    $ajax_result['num'] = $info['surplus_num'] - 1;
    die(json_encode($ajax_result));
}

function _log($data){
    $log_name = "monalisa_log.txt";	//log文件路径
    $fp = fopen($log_name, "a");
    flock($fp, LOCK_EX);
    fwrite($fp, "执行日期：".date('Y-m-d H:i:s')."\n".$data."\n\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}
?>