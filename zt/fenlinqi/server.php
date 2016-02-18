<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');


if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == 'score'){
        $openid = $_SESSION['flq_openid'];
        $score = intval($_POST['score']);
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        $sql = "SELECT score FROM fenlinqi WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $info = $res->fetch_assoc();
        
        if($info['score'] < $score){
            
            $sql = "UPDATE fenlinqi SET score='".$score."' WHERE openid='".$_SESSION['flq_openid']."'";
            mysqli_query($db, $sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            die(json_encode($ajax_result));
            
        } else {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            die(json_encode($ajax_result));
        }
    }
    
    if($act == 'start'){
        
        $openid = $_SESSION['flq_openid'];
        if(empty($openid)){
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
            die(json_encode($ajax_result));
        }
        
        $sql = "SELECT * FROM fenlinqi WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $info = $res->fetch_assoc();
        if(!empty($info['prize_id']) && !empty($info['phone'])){
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = '您已经中过奖了，将机会留给别人吧！';
            die(json_encode($ajax_result));
        }
        if(!empty($info['prize_id']) && empty($info['phone'])){
            //中奖后未填信息
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize_id'] = $info['prize_id'];
            $ajax_result['sn'] = $info['sn'];
            die(json_encode($ajax_result));
        }
        if($info['surplus_num'] <= 0){
            $ajax_result['errcode'] = 1005;
            $ajax_result['errmsg'] = '您的抽奖次数不足，分享给好友或朋友圈可增加1次抽奖机会！';
            die(json_encode($ajax_result));
        }
        $prize_arr = array(
            '0' => array('id'=>0, 'prize'=>'谢谢参与', 'num'=>0, 'v'=>40),
            '1' => array('id'=>1, 'prize'=>'免单大奖', 'num'=>10, 'v'=>1), 
            '2' => array('id'=>2, 'prize'=>'苹果minipaid', 'num'=>10, 'v'=>1), 
            '3' => array('id'=>3, 'prize'=>'皇冠约克内墙漆一桶2.7L', 'num'=>10, 'v'=>1), 
            '4' => array('id'=>4, 'prize'=>'迷你蓝牙音箱', 'num'=>10, 'v'=>1), 
            '5' => array('id'=>5, 'prize'=>'精美零钱包', 'num'=>10, 'v'=>26),
            '6' => array('id'=>6, 'prize'=>'精美卡套', 'num'=>10, 'v'=>10),
            '7' => array('id'=>7, 'prize'=>'公仔', 'num'=>10, 'v'=>10),
            '8' => array('id'=>8, 'prize'=>'芬琳漆200元代金券', 'num'=>10, 'v'=>10),
        );
        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $rid = get_rand($arr); //根据概率获取奖项id
       
        $sql = "SELECT COUNT(*) AS num FROM fenlinqi WHERE prize_id='".$rid."'";
        $res = mysqli_query($db, $sql);
        $num = $res->fetch_assoc();
        
        if($num['num'] >= $prize_arr[$rid]['num']){
            updata($db, 0, $prize_arr[0]['prize'], $info, '');
        } else {
            $sn = uniqid();
            updata($db, $rid, $prize_arr[$rid]['prize'], $info, $sn);
        }
        
    }
    
    if($act == "submit"){
    
        $openid = $_SESSION['flq_openid'];
        $name = mysqli_real_escape_string($db, trim($_POST['name']));
        $phone = mysqli_real_escape_string($db, trim($_POST['tel']));
        $city = mysqli_real_escape_string($db, trim($_POST['city']));
        
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
        
        $sql = "SELECT * FROM fenlinqi WHERE openid='".$openid."'";
        $res = mysqli_query($db, $sql);
        $arr = $res->fetch_assoc();
        if($arr){
            if(!empty($arr['name']) && !empty($arr['phone'])){
                $ajax_result['errcode'] = 1000;
                $ajax_result['errmsg'] = "您已提交过信息了，请勿重复提交！";
                die(json_encode($ajax_result));
            } else {
                $up_sql = "UPDATE fenlinqi SET name='".$name."',phone='".$phone."',city='".$city."' WHERE openid='".$_SESSION['flq_openid']."'";
                mysqli_query($db, $up_sql);
                $ajax_result['errcode'] = 0;
                $ajax_result['errmsg'] = "提交成功！";
                die(json_encode($ajax_result));
            }
        } else {
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "您还未中奖哦，快去抽奖吧！";
            die(json_encode($ajax_result));
        }
    }
    
    //排行榜
    if($act == "ranking"){
        
        $list_sql = "SELECT id,wechaname,headimgurl,score FROM fenlinqi ORDER BY score DESC,last_time ASC LIMIT 10";
        $res = mysqli_query($db, $list_sql);
        $arr = array();
        while($row = $res->fetch_array()){
            $arr[] = $row;
        }
        if($arr){
            foreach ($arr as $k => $key){
                $list[$k]['ranking'] = $k + 1;
                $list[$k]['score'] = $key['score'];
                $list[$k]['wechaname'] = $key['wechaname'];
                $list[$k]['headimgurl'] = $key['headimgurl'] ? $key['headimgurl'] : "images/logo.png";
            }
        } else {
            $list[0] = '';
        }
        die(json_encode($list));
    }
}

function get_rand($proArr) {
    $result = '';

    //概率数组的总概率精度
    $proSum = array_sum($proArr);

    //概率数组循环
    foreach ($proArr as $key => $proCur) {
        $randNum = mt_rand(1, $proSum);
        if ($randNum <= $proCur) {
            $result = $key;
            break;
        } else {
            $proSum -= $proCur;
        }
    }
    unset ($proArr);

    return $result;
}


function updata($db, $k, $prize_name, $info, $sn){
    $sql = "UPDATE fenlinqi SET prize_id='".$k."',prize='".$prize_name."',sn='".$sn."',surplus_num=surplus_num-1,num=num+1,last_time='".date('Y-m-d H:i:s')."' WHERE openid='".$_SESSION['flq_openid']."'";
    mysqli_query($db, $sql);
    $ajax_result['errcode'] = 0;
    $ajax_result['errmsg'] = 'ok';
    $ajax_result['prize_id'] = $k;
    $ajax_result['sn'] = $sn;
    $ajax_result['num'] = $info['surplus_num'] - 1;
    die(json_encode($ajax_result));
}
?>