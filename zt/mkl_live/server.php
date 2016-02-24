<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "submit"){
		//提交评论
		$text = str_ireplace('pre>', 'p>', $_POST['info']);
		if(empty($text)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "内容不能为空";
			die(json_encode($ajax_result));
		}

		$name = $_POST['name'];
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "标题不能为空";
			die(json_encode($ajax_result));
		}
		$add_time = time();

		$sql = "INSERT INTO mkl_live(title, info, add_time) VALUES('".$name."','".$text."','".$add_time."')";
		$url = mysqli_query($db, $sql);

		if($url){
			$ajax_result['code'] = 2001;
			$ajax_result['id'] = mysqli_insert_id($db);
			$ajax_result['time'] = date('m月d日H:i', time());
			$ajax_result['msg'] = "发表成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}

	} else if($act == "ajax_list"){
		//获取列表
		$type = !empty($_POST['type']) ? $_POST['type'] : '';
		if(empty($type)){
			$sql = "SELECT * FROM mkl_live ORDER BY add_time DESC";
		} else {
			$sql = "SELECT * FROM mkl_live ORDER BY add_time DESC LIMIT 10";
		}
		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}
		if(!empty($arr)){
			foreach ($arr as $k => $key){
				$list_arr[$k]['id'] = $key['id'];
				$list_arr[$k]['title'] = $key['title'];
				$list_arr[$k]['text'] = $key['info'];
				$list_arr[$k]['md_time'] = date('m月d日', $key['add_time']);
				$list_arr[$k]['hi_time'] = date('H:i', $key['add_time']);
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die(json_encode($list_arr));

	} else if($act == "ajax_del"){
		//删除
		$id = $_POST['id'];
		$sql = "DELETE FROM mkl_live WHERE id=".$id;
		$url = mysqli_query($db, $sql);
		if($url){
			$ajax_result['code'] = 1;
			$ajax_result['msg'] = "删除成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "删除失败";
			die(json_encode($ajax_result));
		}
	}
}

?>