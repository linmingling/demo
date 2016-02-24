<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_REQUEST){

	$callback = $_REQUEST['callback'];

	$act = trim($_REQUEST['act']);

	if($act == "submit"){
		//提交
		$user_id = intval($_REQUEST['id']);

		if(empty($user_id)){
			$ajax_result['code'] = 1001;
			$ajax_result['msg'] = "数据异常，请刷新页面重试";
			die(json_encode($ajax_result));
		}

		$info_sql = "SELECT * FROM vote WHERE user_id=".$user_id;
		$info_url = mysqli_query($db, $info_sql);
		while($info_row = $info_url->fetch_array()){
			$info_arr[]= $info_row;
		}

		if(empty($info_arr)){
			$user_list = array(1 => "王旭峰", 2 => "刘永宾", 3 => "张洪庚", 4 => "曹彦玲", 5 => "史晓洁", 6 => "杨天鹏");
			$user_name = $user_list[$user_id];

			$sql = "INSERT INTO vote(user_id, user_name, votes) VALUES('".$user_id."','".$user_name."','1')";
			$url = mysqli_query($db, $sql);
			if($url){
				setcookie('vote_'.$user_id, time(), time()+30*24*3600);
				$ajax_result['code'] = 2001;
				$ajax_result['id'] = mysqli_insert_id($db);
				$ajax_result['msg'] = "投票成功";
				die($callback . "(". json_encode($ajax_result) . ")");
			} else {
				$ajax_result['code'] = 1002;
				$ajax_result['msg'] = "系统繁忙，请刷新页面重试";
				die($callback . "(". json_encode($ajax_result) . ")");
			}

		} else {
			$sql = "UPDATE vote SET votes = votes+1 WHERE user_id = ".$user_id;
			$url = mysqli_query($db, $sql);
			if($url){
				setcookie('vote_'.$user_id, time(), time()+30*24*3600);
				$ajax_result['code'] = 2001;
				$ajax_result['msg'] = "投票成功";
				die($callback . "(". json_encode($ajax_result) . ")");
			} else {
				$ajax_result['code'] = 1002;
				$ajax_result['msg'] = "系统繁忙，请刷新页面重试";
				die($callback . "(". json_encode($ajax_result) . ")");
			}
		}

	} else if($act == "vote_list"){

		//获取评论列表
		$sql = "SELECT * FROM vote ORDER BY user_id ASC";
		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}
		if(!empty($arr)){
			foreach ($arr as $k => $key){
				$list_arr[$k]['user_id'] = $key['user_id'];
				$list_arr[$k]['user_name'] = $key['user_name'];
				$list_arr[$k]['votes'] = $key['votes'];

				//cookie处理
				$cookie = !empty($_COOKIE['vote_'.$key['user_id']]) ? $_COOKIE['vote_'.$key['user_id']] : '';
				$list_arr[$k]['cookie'] = $cookie;
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die($callback . "(". json_encode($list_arr) . ")");

	} else {
		$ajax_result['code'] = 1001;
		$ajax_result['msg'] = "非法操作";
		die(json_encode($ajax_result));
	}

}

function name_list(){
	$user_list = array(1 => "王旭峰", 2 => "刘永宾", 3 => "张洪庚", 4 => "曹彦玲", 5 => "史晓洁", 6 => "杨天鹏");
	return $user_list;
}
?>