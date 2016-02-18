<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST)
{

	$act = trim($_POST['act']);
    if(empty($_SESSION['dp_cx_openid']))
    {
        $ajax_result['errcode'] = 1001;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        //die(json_encode($ajax_result));
    }

    if($act == "check_times")
    {
        $ajax_result['errcode'] = 1022;
        $ajax_result['errmsg'] = '谢谢参与，竞猜已经结束，东鹏代言人是影视巨星刘涛！';
        die(json_encode($ajax_result));  

        //检查可回答次数
//        $sql = "select times,last_time from dp_cx where openid='{$_SESSION['dp_cx_openid']}'";
//        $res = mysqli_query($db,$sql);
//        $row = $res->fetch_assoc();

        //初始化次数
//        if((strtotime(date('Y-m-d',$row['last_time']))) < strtotime('today'))
//        {
//            $update_sql = "update dp_cx set times=0,last_time=" . time() . " where openid='{$_SESSION['dp_cx_openid']}'";
//            mysqli_query($db,$update_sql);
//        }

//        if($row['times'] >= 3 && ($row['last_time']+24*60*60) >= strtotime('today'))
//        {
//            $ajax_result['errcode'] = 1001;
//            $ajax_result['errmsg'] = '您今天答过题了！';
//            die(json_encode($ajax_result)); 
//        }
//        else
//        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = '您的答案已提交！';
            die(json_encode($ajax_result));        
//        }

    }
    elseif($act == "add")
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $answer = trim($_REQUEST['answer']);//所选答案

        if(empty($name) || empty($phone) || empty($answer))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(strlen($phone) != "11")
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "非法手机号码，请重新输入！";
            die(json_encode($ajax_result));
        }
        
        $check_answer_sql = "select answer from dp_cx where openid='{$_SESSION['dp_cx_openid']}'";
        $check_answer_res = mysqli_query($db,$check_answer_sql);
        $check_answer_row = $check_answer_res->fetch_assoc();
        if(empty($check_answer_row['answer']) || ($check_answer_row['answer'] !== '刘涛'))
        {
            $sql = "update dp_cx set name='{$name}',phone='{$phone}',answer='{$answer}',times=times+1 where openid='{$_SESSION['dp_cx_openid']}'";
        }
        else
        {
            $sql = "update dp_cx set name='{$name}',phone='{$phone}',times=times+1 where openid='{$_SESSION['dp_cx_openid']}'";
        }
        mysqli_query($db, $sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    }

}




?>