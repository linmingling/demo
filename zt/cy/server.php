<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
date_default_timezone_set("Asia/Shanghai");   //设置时区
if($_POST){

	$act = trim($_POST['act']);
    
    if($act == "addinfo")
    {
        $name = trim($_REQUEST['name']);//姓名
        $content = trim($_REQUEST['content']);//地址

        if(empty($name) || empty($content))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
            die(json_encode($ajax_result));
        }

        $sql = "insert into cy(name,content,add_time,add_strtotime) values('{$name}','{$content}','". date('Y-m-d H:i:s',time()) ."','". time() ."')";
        mysqli_query($db, $sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的评论已提交！";
        die(json_encode($ajax_result));
    }

}



?>