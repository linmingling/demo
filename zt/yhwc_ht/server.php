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
		$text = $_POST['text'];
		$text = strip_tags($text, "");
		if(empty($text)){
			$ajax_result['code'] = 1001;
			$ajax_result['msg'] = "内容不能为空";
			die(json_encode($ajax_result));
		}

		$name = $_POST['name'];
		$name = strip_tags($name, "");
		if(empty($name)){
			$ajax_result['code'] = 1001;
			$ajax_result['msg'] = "昵称不能为空";
			die(json_encode($ajax_result));
		}
		$phone = $_POST['tel'];
		$type = intval($_POST['type']);
		$add_time = date('Y-m-d H:i:s',time());
		$strtotime = time();

		$sql = "INSERT INTO yhwc(name, phone, text, faction, nice, add_time, strtotime) VALUES('".$name."','".$phone."','".$text."','".$type."','0','".$add_time."','".$strtotime."')";
		$url = mysqli_query($db, $sql);

		if($url){
			$ajax_result['code'] = 2001;
			$ajax_result['id'] = mysqli_insert_id($db);
			$ajax_result['msg'] = "发表成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 1002;
			$ajax_result['msg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}

	} else if($act == "nice"){
		//点赞
		$id = intval($_POST['id']);
		$sql = "UPDATE yhwc SET nice = nice+1 WHERE id = ".$id;
		$url = mysqli_query($db, $sql);
		if($url){
			setcookie('nice_'.$id, time(), time()+24*3600);
			$ajax_result['code'] = 2001;
			$ajax_result['msg'] = "点赞成功";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['code'] = 1002;
			$ajax_result['msg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}
	} else if($act == "ajax_list"){

		//获取评论列表
		$sql = "SELECT * FROM yhwc a WHERE 3>(SELECT COUNT(faction) FROM yhwc b WHERE a.strtotime <b.strtotime  AND a.faction=b.faction) ORDER BY id ASC";
		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}
		if(!empty($arr)){
			foreach ($arr as $k => $key){
				$list_arr[$k]['id'] = $key['id'];
				$list_arr[$k]['name'] = $key['name'];
				$list_arr[$k]['text'] = $key['text'];
				$list_arr[$k]['faction'] = $key['faction'];
				$list_arr[$k]['nice'] = $key['nice'];
				if(time() - $key['strtotime'] < 1800){
					$list_arr[$k]['time'] = ceil((time() - $key['strtotime'])/60).'分钟前';
				} else {
					$list_arr[$k]['time'] = date('m-d H:i:s', $key['strtotime']);
				}
				//cookie处理
				$cookie = !empty($_COOKIE['nice_'.$key['id']]) ? $_COOKIE['nice_'.$key['id']] : '';
				if($cookie){
					$old_time = strtotime(date('Y-m-d', $cookie));	//取得最近一次点赞的0点时间戳
					$new_time = strtotime(date('Y-m-d', time())); //取得当前时间的0点时间戳
					$res_time = ($new_time - $old_time)/86400;
					if($res_time >= 1){
						setcookie('nice_'.$key['id']);
					}
				}
				$list_arr[$k]['cookie'] = $cookie;
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die(json_encode($list_arr));

	} else if($act == "more"){
		//拉取更多消息
		$type = intval($_POST['type']);
		$limit = intval($_POST['limit']);
		$sql = 'SELECT * FROM yhwc WHERE faction='.$type.' ORDER BY strtotime DESC LIMIT '.$limit.',3';
		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}
		if(!empty($arr)){
			foreach ($arr as $k => $key){
				$list_arr[$k]['id'] = $key['id'];
				$list_arr[$k]['name'] = $key['name'];
				$list_arr[$k]['text'] = $key['text'];
				$list_arr[$k]['faction'] = $key['faction'];
				$list_arr[$k]['nice'] = $key['nice'];
				if(time() - $key['strtotime'] < 1800){
					$list_arr[$k]['time'] = ceil((time() - $key['strtotime'])/60).'分钟前';
				} else {
					$list_arr[$k]['time'] = date('m-d H:i:s', $key['strtotime']);
				}
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die(json_encode($list_arr));
	} else {
		$ajax_result['code'] = 1001;
		$ajax_result['msg'] = "非法操作";
		die(json_encode($ajax_result));
	}
}

?>