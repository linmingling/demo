<?php

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

$table = 'mnls_11';
if($_POST) 
{
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $province = trim($_POST['province']);
    $city = trim($_POST['city']);
    $area = trim($_POST['area']);
    $address = trim($_POST['address']);

    if(empty($name) || empty($phone) || empty($province) || empty($city) || empty($area) || empty($address))
    {
        $ajax_result['errcode'] = 1001;
        $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
        die(json_encode($ajax_result));
    }

    if(strlen($phone) != "11")
    {
        $ajax_result['errcode'] = 1002;
        $ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
        die(json_encode($ajax_result));
    }

    if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
    {
        $ajax_result['errcode'] = 1003;
        $ajax_result['errmsg'] = "非法手机号码，请重新输入！";
        die(json_encode($ajax_result));
    }
    
    $check_sql = "select count(*) as c from $table";
    $check_res = mysqli_query($db,$check_sql);
    $check_row = $check_res->fetch_assoc();
    if($check_row['c'] >= 1644)
    {
        $ajax_result['errcode'] = 1004;
        $ajax_result['errmsg'] = "已超过报名名额！";
        die(json_encode($ajax_result));
    }

    $sql = "insert into $table (name,phone,province,city,area,address,add_time) values ('{$name}','{$phone}','{$province}','{$city}','{$area}','{$address}','" . date('Y-m-d H:i:s') . "')";

    $res = mysqli_query($db,$sql);
    if($res)
    {
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "报名成功！";
        die(json_encode($ajax_result));
    }
    else
    {
        $ajax_result['errcode'] = 1005;
        $ajax_result['errmsg'] = '该手机号码已报名';
        die(json_encode($ajax_result));
    }

}



?>