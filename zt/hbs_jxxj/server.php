<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST)
{
    
    $act = trim($_REQUEST['act']);
    if($act == "addinfo")   //预约
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $province = trim($_REQUEST['province']);//省
        $city = trim($_REQUEST['city']);//市
        $address = trim($_REQUEST['address']);//地址
        $is_new = trim($_REQUEST['isNew']);//是否新装

        if(empty($name) || empty($phone) || empty($province) || empty($city) || empty($address) || empty($is_new))
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

        //重复姓名或电话注册检查
        $check_sql = "select name from hbs_yy where phone='{$phone}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if($check_row)
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "您已报名，请不要重复提交！";
            die(json_encode($ajax_result));
        }

        

        $sql = "insert into hbs_yy (name,phone,province,city,address,is_new,add_time,add_strtotime) values ('{$name}','{$phone}','{$province}','{$city}','{$address}','{$is_new}'," . time() . ",'" . date('Y-m-d H:m:s',time()) . "')";
        mysqli_query($db, $sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    }

    if($act == "addsurvey")//调查表
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $province = trim($_REQUEST['province']);//省
        $city = trim($_REQUEST['city']);//市
        $address = trim($_REQUEST['address']);//地址
        $is_new = trim($_REQUEST['isNew']);//是否新装
        $family = $_REQUEST['family'];//家庭
        $smoke = trim($_REQUEST['smoke']);//二手烟
        $sick = trim($_REQUEST['sick']);//病人
        $allergy = trim($_REQUEST['allergy']);//过敏
        $pet = trim($_REQUEST['pet']);//宠物
        $air = trim($_REQUEST['air']);//使用空气净化器
        $buy = trim($_REQUEST['buy']);//想买
        $gender = trim($_REQUEST['gender']);//性别
        $age = intval($_REQUEST['age']);//年龄

        if(empty($address))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "详细地址不能为空！";
            die(json_encode($ajax_result));
        }

        if(empty($name) || empty($phone) || empty($province) || empty($city) || empty($address) || empty($is_new) || empty($family) || empty($smoke) || empty($sick) || empty($allergy) || empty($pet) || empty($air) || empty($buy) || empty($gender) || empty($age))
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

        //重复姓名或电话注册检查
        $check_sql = "select name from hbs_tc where phone='{$phone}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if($check_row)
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "您已提交过，请不要重复提交！";
            die(json_encode($ajax_result));
        }

        $sql = "insert into hbs_tc (name,phone,province,city,address,is_new,add_time,add_strtotime,family,smoke,sick,allergy,pet,air,buy,gender,age) values ('{$name}','{$phone}','{$province}','{$city}','{$address}','{$is_new}'," . time() . ",'" . date('Y-m-d H:m:s',time()) . "','{$family}','{$smoke}','{$sick}','{$allergy}','{$pet}','{$air}','{$buy}','{$gender}','{$age}')";
        mysqli_query($db, $sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));




    }

}



?>