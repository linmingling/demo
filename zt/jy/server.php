<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST)
{
	$act = trim($_POST['act']);
	// $act = $_GET['as'];
	
	if($act == 'add' )  //报名
    {
        $table1 = "jy_reg";
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $nicname = trim($_REQUEST['nicname']);//昵称
        $age = intval(trim($_REQUEST['age']));//年龄
        $contents = trim($_REQUEST['content1']) . "\r\n" . trim($_REQUEST['content2']) . "\r\n" . trim($_REQUEST['content3']);//内容


        if(empty($name) || empty($phone))
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
        if($check_row)
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "您已报名，请不要重复提交！";
            die(json_encode($ajax_result));
        }
        

        $sql = "insert into {$table1} (name,phone,nicname,age,contents,add_time,add_strtotime,is_handle) values('{$name}','{$phone}','{$nicname}','{$age}','{$contents}','".date('Y-m-d H:i:s', time())."','".time()."',0)";
        mysqli_query($db,$sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "投递成功！";
        die(json_encode($ajax_result));


    }
	else
	{
		$ajax_result['errcode'] = 1001;
		$ajax_result['errmsg'] = "非法操作！";
		die(json_encode($ajax_result));
	}

}



 ?>