<?php
/**
 * 大自然6.13万人疯抢大转盘活动
 * @var unknown
 */
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == 'start' ){

		$prize_info = array(
			0 => array('name' => '自拍神器', 'probability' => 1),
			1 => array('name' => '筷子', 'probability' => 1),
			2 => array('name' => '手机贴', 'probability' => 1),
			3 => array('name' => '谢谢参与', 'probability' => 97),
		);
		$start = 0;
		$type = rand(1, 100);
		foreach ($prize_info as $k => $key){

			$prize[$k]['start'] = $start + 1;
			$prize[$k]['end'] = $start + $key['probability'];

			$start = $prize[$k]['end'];

			if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){

				$sql = "SELECT COUNT(*) from dzr_wheel WHERE prize_name='".$key['name']."'";
				$res = mysqli_query($db, $sql);
				$arr = array();
				while($row = $res->fetch_array()){
					$arr = $row;
				}
				if($key['name'] == '自拍神器'){
					if($arr[0] >= 2){
						$data = "【奖品库存不足】:\n已中数量:".$arr[0]."\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
						_log($data);
						$ajax_result['errcode'] = 0;
						$ajax_result['errmsg'] = 'ok';
						$ajax_result['prize'] = 2;
						$ajax_result['prize_name'] = '谢谢参与';
						die(json_encode($ajax_result));
					}
				} else if($key['name'] == '筷子'){
					if($arr[0] >= 2){
						$data = "【奖品库存不足】:\n已中数量:".$arr[0]."\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
						_log($data);
						$ajax_result['errcode'] = 0;
						$ajax_result['errmsg'] = 'ok';
						$ajax_result['prize'] = 2;
						$ajax_result['prize_name'] = '谢谢参与';
						die(json_encode($ajax_result));
					}
				} else if($key['name'] == '手机贴'){
					if($arr[0] >= 200){
						$data = "【奖品库存不足】:\n已中数量:".$arr[0]."\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
						_log($data);
						$ajax_result['errcode'] = 0;
						$ajax_result['errmsg'] = 'ok';
						$ajax_result['prize'] = 2;
						$ajax_result['prize_name'] = '谢谢参与';
						die(json_encode($ajax_result));
					}
				}

				$data = "【获奖记录】:\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
				_log($data);

				$_SESSION['is_winning'] = 1;
				$_SESSION['prize_name'] = $key['name'];
				$_SESSION['prize_pro'] = $type;

				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = 'ok';
				$ajax_result['prize_name'] = $key['name'];
				if($key['name'] == '手机贴'){
					$ajax_result['prize'] = 1;
				} else if($key['name'] == '筷子'){
					$ajax_result['prize'] = 5;
				} else if($key['name'] == '自拍神器'){
					$ajax_result['prize'] = 3;
				} else {
					$ajax_result['prize'] = 2;
				}
				die(json_encode($ajax_result));
			}
		}
	}


	if($act == "submit"){

		$is_winning = $_SESSION['is_winning'];
		if(empty($is_winning)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "数据异常！";
			die(json_encode($ajax_result));
		}

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}
		$province = mysqli_real_escape_string($db, $_POST['sheng']);
		if(empty($province)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请输入省份";
			die(json_encode($ajax_result));
		}
		$city = mysqli_real_escape_string($db, $_POST['shi']);
		if(empty($city)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请输入城市";
			die(json_encode($ajax_result));
		}
		$area = mysqli_real_escape_string($db, $_POST['qu']);
		$address = mysqli_real_escape_string($db, $_POST['detail']);
		if(empty($address)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请输入详细地址";
			die(json_encode($ajax_result));
		}


		$prize_name = $_SESSION['prize_name'];
		$prize_pro = $_SESSION['prize_pro'];
		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM dzr_wheel WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已中过奖！";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO dzr_wheel(name, phone, province, city, area, address, prize_name, prize_pro, add_time, add_strtotime) VALUES('".$name."','".$phone."','".$province."','".$city."','".$area."','".$address."','".$prize_name."','".$prize_pro."','".$add_time."','".$add_strtotime."')";
			$res = mysqli_query($db, $sql);

			if($res){
				$_SESSION['is_winning'] = 0;
				$ajax_result['errcode'] = 0;
				$ajax_result['id'] = mysqli_insert_id($db);
				$ajax_result['errmsg'] = "ok";
				die(json_encode($ajax_result));
			} else {
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = "系统繁忙，请退出重试";
				die(json_encode($ajax_result));
			}
		}
	}

	if($act == 'list'){
		$sql = "SELECT * FROM dzr_wheel WHERE phone <> '' ORDER BY add_strtotime DESC LIMIT 10";
		$res = mysqli_query($db, $sql);
		$arr = array();
		while($row = $res->fetch_array()){
			$arr[] = $row;
		}
		if($arr){
			foreach ($arr as $k => $key){
				$list[$k]['phone'] = substr($key['phone'], 0, 3).'****'.substr($key['phone'], 7, 4);
				$list[$k]['prize'] = $key['prize_name'];
			}
		}
		$list = empty($list) ? '' : $list;
		die(json_encode($list));
	}
}
function _log($data){
	$log_name = "log.txt";	//log文件路径
	$fp = fopen($log_name, "a");
	flock($fp, LOCK_EX);
	fwrite($fp, "执行日期：".date('Y-m-d H:i:s')."\n".$data."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}
?>