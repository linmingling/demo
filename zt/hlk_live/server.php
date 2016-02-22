<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$act = $_REQUEST['act'];
$id = $_REQUEST['id'];
if($act == "ajax_list"){
		$info_sql = "SELECT * FROM live WHERE id=".$id;
		$info = mysqli_query($db, $info_sql);
		while($info_row = $info->fetch_array()){
			$info_arr = $info_row;
		}

		$sql = "SELECT * FROM live_list WHERE is_blocked=0 AND action_id=".$id." ORDER BY add_time DESC";
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

}

?>