<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
date_default_timezone_set("Asia/Shanghai");   //设置时区
if($_POST){

	$act = trim($_POST['act']);
    if(empty($_SESSION['nature20_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }
    if($act == "addinfo")
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//电话
        $content = trim($_REQUEST['content']);//地址
        $from_id = trim($_REQUEST['fromId']) > 0 ? trim($_REQUEST['fromId']) : 0;

        if(empty($name) || empty($content) || empty($phone))
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

        $check_sql1 = "select phone from nature20 where phone='{$phone}'";
        $check_res1 = mysqli_query($db,$check_sql1);
        $check_row1 = $check_res1->fetch_assoc();
        if(!empty($check_row1['phone']))
        {
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "该电话已经被使用过啦！";
            die(json_encode($ajax_result));
        }

        $check_sql = "select phone from nature20 where openid='{$_SESSION['nature20_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if(!empty($check_row['phone']))
        {
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "您已提交过祝福啦！";
            die(json_encode($ajax_result));
        }

        $sql = "update nature20 set name='{$name}',phone='{$phone}',content='{$content}',from_id={$from_id} where openid='" . $_SESSION['nature20_openid'] . "'";
        mysqli_query($db, $sql);

        if($from_id > 0)
        {
            $sql = "update nature20 set share_count=share_count+1 where id={$from_id}";
            mysqli_query($db, $sql);
        }

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的祝福已提交！";
        die(json_encode($ajax_result));
    }

}



?>