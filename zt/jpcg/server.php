<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
require(ROOT_PATH . '../../data/secre.php');
$userInfo = 'arrow_user_info';
$resultList = 'arrow_answer';
if($_POST) 
{
    
	$act = trim($_POST['act']);
    if(empty($_SESSION['arrow_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }

    if($act == "sub")   //提交答案
    {
	   
        $result = $_POST['res'];
        
        $check_sql = "select * from {$userInfo} where openid='{$_SESSION['arrow_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();

		$sql = "insert into {$resultList} (user_id,result,subtime) values ('{$check_row['user_id']}','{$result}','" . date('Y-m-d H:i:s') . "')";
        mysqli_query($db, $sql);
        
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
        
    }
}
?>