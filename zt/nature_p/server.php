<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('PRC'); //设置本地时区

// $db = mysqli_connect("localhost","root","") or die("database connection failed");
// mysqli_select_db($db, "jia360");

$db = mysqli_connect("115.29.233.98", "tao360", "yatai3.14159") or die("database connection failed");
mysqli_select_db($db, "tao360");
mysqli_query($db, 'set names "utf8"');


if($_POST){

	$act = trim($_POST['act']);

	if($act == "ajax_list"){
		//获取列表

		$count_sql = "SELECT count(*) as num FROM lanrain_dzr_record WHERE action_id=1";
		$count_url = mysqli_query($db, $count_sql);
		$num = mysqli_fetch_array($count_url);


		$count_sql_l = "SELECT count(*) as num FROM lanrain_dzr_share";
		$count_url_l = mysqli_query($db, $count_sql_l);
		$num_l = mysqli_fetch_array($count_url_l);

		$sql = "SELECT * FROM lanrain_dzr_record WHERE action_id=1 AND tzs<>0 ORDER BY share_num DESC,tzs ASC,add_time ASC LIMIT 422";

		$url = mysqli_query($db, $sql);
		while($row = $url->fetch_array()){
			$arr[]= $row;
		}

		if(!empty($arr)){
			foreach ($arr as $k => $key){
				$list_arr[$k]['id'] = $key['id'];
				$list_arr[$k]['rank'] = $k + 1;
				$list_arr[$k]['wechaname'] = substr_cut($key['wechaname'], 2).'**';
				$list_arr[$k]['tzs'] = $key['tzs'];
				$list_arr[$k]['share_num'] = $key['share_num'];
				$list_arr[$k]['num'] = $num['num'] + $num_l['num'] + 1600;
			}
		}
		$list_arr = !empty($list_arr) ? $list_arr : '';
		die(json_encode($list_arr));
	}
}

//匿名处理
function substr_cut($str_cut, $length){
	if (strlen($str_cut) > $length){
		for($i=0; $i < $length; $i++){
			if (ord($str_cut[$i]) > 128){
				$i++;
			}
		}
		$str_cut = mb_substr($str_cut, 0, $i, 'utf-8');
	}
	return $str_cut;
}
?>