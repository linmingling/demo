<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

//$check_captcha_sql = "select name from nyhs where captcha='1' and city='1'";
//            $check_captcha_res = mysqli_query($db,$check_captcha_sql);
//            $check_captcha_row = $check_captcha_res->fetch_assoc();
//            
//        $ajax_result['errcode'] = 1001;
//            $ajax_result['errmsg'] = $check_captcha_row['name'];
//            die(json_encode($ajax_result));
if($_POST)
{
    
    $act = trim($_REQUEST['act']);
    if($act == 'add' )  //报名
    {
        $table1 = "nyhs";
        $table2 = "nyhs_city_captcha";
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $city = trim($_REQUEST['city']);//城市名
        $othercity = trim($_REQUEST['othercity']);//其他城市名
        $shopname = trim($_REQUEST['shopname']);//店铺名
        $ordersn = trim($_REQUEST['ordersn']);//店铺名
        $captcha = strtoupper(trim($_REQUEST['captcha']));//验证码

        if(empty($name) || empty($phone) || empty($city) || empty($shopname) || empty($captcha) || empty($ordersn))
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

        //重复姓名或电话注册检查
        $check_sql = "select name from {$table1} where phone='{$phone}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if($check_row['name'])
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "您已报名，请不要重复提交！";
            die(json_encode($ajax_result));
        }
        

        if($captcha == "HOOS0225")      //通用验证码
        {
            //$othercity = '广州';
            $sql = "insert into {$table1} (name,phone,city,shopname,captcha,order_sn,add_time,add_strtotime,is_draw) values ('{$name}','{$phone}','{$othercity}','{$shopname}','{$captcha}','{$ordersn}','".date('Y-m-d H:i:s', time())."','".time()."',0)";
            mysqli_query($db, $sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "报名成功！";
            die(json_encode($ajax_result));
        }   
        else        //特定城市验证码
        {

            $check_captcha_sql = "select city from {$table2} where captcha='{$captcha}' and city='{$city}'";
            $check_captcha_res = mysqli_query($db,$check_captcha_sql);
            $check_captcha_row = $check_captcha_res->fetch_assoc();
            if(!$check_captcha_row)
            {
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "您输入的验证码或城市错误！";
                die(json_encode($ajax_result));
            }

            $sql = "insert into {$table1} (name,phone,city,shopname,captcha,order_sn,add_time,add_strtotime,is_draw) values ('{$name}','{$phone}','{$city}','{$shopname}','{$captcha}','{$ordersn}','".date('Y-m-d H:i:s', time())."','".time()."',0)";
            mysqli_query($db, $sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "报名成功！";
            die(json_encode($ajax_result));
        }
    }


}



?>