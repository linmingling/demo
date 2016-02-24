<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == "add_title"){

		$title = mysqli_real_escape_string($db, $_POST['title']);
		if(empty($title)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "标题不能为空";
			die(json_encode($ajax_result));
		}
		$share_img = mysqli_real_escape_string($db, $_POST['share_img']);
		if(empty($share_img)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "分享图片不能为空";
			die(json_encode($ajax_result));
		}
		$share_title = mysqli_real_escape_string($db, $_POST['share_title']);
		if(empty($share_title)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "分享标题不能为空";
			die(json_encode($ajax_result));
		}
		$share_desc = mysqli_real_escape_string($db, $_POST['share_desc']);
		if(empty($share_desc)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "分享描述不能为空";
			die(json_encode($ajax_result));
		}
		$info = mysqli_real_escape_string($db, $_POST['info']);
		$add_time = time();
		$id = intval($_POST['id']);

		if(!empty($id)){

			$sql = "UPDATE live SET title='".$title."',info='".$info."',share_img='".$share_img."',share_title='".$share_title."',share_desc='".$share_desc."' WHERE id=".$id;
			$url = mysqli_query($db, $sql);

		} else {

			$sql = "INSERT INTO live(title, info, share_img, share_title, share_desc, add_time,user_id) VALUES('".$title."','".$info."','".$share_img."','".$share_title."','".$share_desc."','".$add_time."','')";
			$url = mysqli_query($db, $sql);

		}
		if($url){
			$ajax_result['code'] = 2001;
			$ajax_result['id'] = mysqli_insert_id($db);
			$ajax_result['msg'] = "发表成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}

	} else if($act == "submit"){
		//提交数据
		$text = str_ireplace('pre>', 'p>', mysqli_real_escape_string($db, $_POST['info']));
		if(empty($text)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "内容不能为空";
			die(json_encode($ajax_result));
		}

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "标题不能为空";
			die(json_encode($ajax_result));
		}

		$id = intval($_POST['id']);
		if(empty($id)){
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "参数错误，请退出重试";
			die(json_encode($ajax_result));
		}

		$edit_id = intval($_POST['edit_id']);

		$add_time = time();

		if(empty($edit_id)){
			$sql = "INSERT INTO live_list(action_id, title, info, add_time) VALUES('".$id."','".$name."','".$text."','".$add_time."')";
			$url = mysqli_query($db, $sql);
		} else {
			$time = strtotime($_POST['time']);
			$sql = "UPDATE live_list SET title='".$name."',info='".$text."',add_time='".$time."' WHERE id=".$edit_id;
			$url = mysqli_query($db, $sql);
		}

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
		$type = !empty($_POST['type']) ? intval($_POST['type']) : '';
		$id = !empty($_POST['id']) ? intval($_POST['id']) : '';

		if(empty($type)){
			$sql = "SELECT * FROM live_list WHERE action_id=".$id." ORDER BY add_time DESC";
		} elseif($type == 1) {
			$sql = "SELECT * FROM live_list WHERE action_id=".$id." ORDER BY add_time DESC";
		} elseif($type == 2) {
			$sql = "SELECT * FROM live ORDER BY add_time DESC";
		}

		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}

		if($type == 2){
			if(!empty($arr)){
				foreach ($arr as $k => $key){
					$list_arr[$k]['id'] = $key['id'];
					$list_arr[$k]['title'] = mb_substr($key['title'], 0, 15, 'utf-8').'...';
					$list_arr[$k]['time'] = date('Y-m-d H:i', $key['add_time']);
				}
			}
		} else {
			if(!empty($arr)){
				foreach ($arr as $k => $key){
					$list_arr[$k]['id'] = $key['id'];
					$list_arr[$k]['title'] = $key['title'];
					$list_arr[$k]['text'] = $key['info'];
					$list_arr[$k]['is_blocked'] = $key['is_blocked'];
					$list_arr[$k]['blocked_img'] = $key['is_blocked'] ? 'images/no.gif' : 'images/yes.gif';
					$list_arr[$k]['blocked_tips'] = $key['is_blocked'] ? '已屏蔽' : '已显示';
					$list_arr[$k]['md_time'] = date('m月d日 ', $key['add_time']);
					$list_arr[$k]['hi_time'] = date('H:i', $key['add_time']);
				}
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die(json_encode($list_arr));

	} else if($act == "ajax_del"){
		//删除
		$id = intval($_POST['id']);
		$is_blocked = intval($_POST['is_blocked']) ? 0 : 1;
// 		$sql = "DELETE FROM live_list WHERE id=".$id;
		$sql = "UPDATE live_list SET is_blocked='".$is_blocked."' WHERE id=".$id;
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
	} else if($act = 'verify'){
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);
		$sql = "SELECT * FROM live_user WHERE username='".$username."' AND password='".$password."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$_SESSION['live_user'] = $arr;
			$ajax_result['code'] = 1;
			$ajax_result['msg'] = "验证通过";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 0;
			$ajax_result['msg'] = "用户名或密码错误，请重新输入";
			die(json_encode($ajax_result));
		}
	}
}

?>