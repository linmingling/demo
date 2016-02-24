<?php

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == 'start' ){

		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请先填写领奖信息，再进行抽奖~";
			die(json_encode($ajax_result));
		}
		$sql = "SELECT * from jmjj WHERE phone='".$phone."'";
		$res = mysqli_query($db, $sql);
		$arr = array();
		while($row = $res->fetch_array()){
			$arr = $row;
		}
		if($arr){
			if($arr['prize_name'] != ''){
				$data = "【您已中过奖】:".$phone."\n";
				_log($data);
				$ajax_result['errcode'] = 1002;
				$ajax_result['errmsg'] = '您已中过奖';
				$ajax_result['prize'] = 2;
				$ajax_result['prize_name'] = '谢谢参与';
				die(json_encode($ajax_result));
			} else  if($arr['number'] >= 2){
				//抽奖次数达到上限
				$data = "【抽奖次数已达上限或已中过奖】:".$phone."\n";
				_log($data);
				$ajax_result['errcode'] = 1003;
				$ajax_result['errmsg'] = '您的抽奖次数已用完';
				$ajax_result['prize'] = 2;
				$ajax_result['prize_name'] = '谢谢参与';
				die(json_encode($ajax_result));
			} else {
				$sql = "UPDATE jmjj SET number='".($arr['number']+1)."' WHERE phone='".$phone."'";
				$res = mysqli_query($db, $sql);
				if(empty($res)){
					$data = "【系统繁忙】\n";
					_log($data);
					$ajax_result['errcode'] = 0;
					$ajax_result['errmsg'] = 'ok';
					$ajax_result['prize'] = 2;
					$ajax_result['prize_name'] = '谢谢参与';
					die(json_encode($ajax_result));
				}
				//获取手机号码归属地
				$url = 'http://appyun.sinaapp.com/index.php?app=mobile&controller=index&action=api&outfmt=json&mobile='.$phone;
				$jsons = file_get_contents($url);
				$cellPhoneInfo = json_decode($jsons);
				$province = $cellPhoneInfo->Province;
				if($province != '北京'){
					$data = "【该号码不是北京地区】:".$phone."【".$province."】\n";
					_log($data);
					$ajax_result['errcode'] = 0;
					$ajax_result['errmsg'] = 'ok';
					$ajax_result['prize'] = 2;
					$ajax_result['prize_name'] = '谢谢参与';
					die(json_encode($ajax_result));
				}
				$prize_info = array(
						0 => array('name' => '音乐节门票', 'probability' => 70),
						1 => array('name' => '谢谢参与', 'probability' => 30),
				);
				$start = 0;
				$type = rand(1, 100);
				foreach ($prize_info as $k => $key){

					$prize[$k]['start'] = $start + 1;
					$prize[$k]['end'] = $start + $key['probability'];

					$start = $prize[$k]['end'];

					if($type >= $prize[$k]['start'] && $type <= $prize[$k]['end']){

						$sql = "SELECT COUNT(*) from jmjj WHERE prize_name='".$key['name']."'";
						$res = mysqli_query($db, $sql);
						$arr = array();
						while($row = $res->fetch_array()){
							$arr = $row;
						}
						if($key['name'] == '谢谢参与'){
							$data = "【获奖记录】:".$phone."【".$province."】\n奖项名称：".$key['name']."\n";
							_log($data);
							$ajax_result['errcode'] = 0;
							$ajax_result['errmsg'] = 'ok';
							$ajax_result['prize'] = 2;
							$ajax_result['prize_name'] = '谢谢参与';
							die(json_encode($ajax_result));
						} else if($key['name'] == '音乐节门票'){
							if($arr[0] >= 45){
								$data = "【奖品库存不足】:".$phone."【".$province."】\n已中数量:".$arr[0]."\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
								_log($data);
								$ajax_result['errcode'] = 0;
								$ajax_result['errmsg'] = 'ok';
								$ajax_result['prize'] = 2;
								$ajax_result['prize_name'] = '谢谢参与';
								die(json_encode($ajax_result));
							} else {
								$data = "【获奖记录】:\n中得概率:".$type."\n概率区间：".$prize[$k]['start']."-".$prize[$k]['end']."\n奖项名称：".$key['name']."\n";
								_log($data);

								$sql = "UPDATE jmjj SET prize_name='".$key['name']."',prize_pro='".$type."' WHERE phone='".$phone."'";
								$res = mysqli_query($db, $sql);
								if($res){
									//发送短信通知
									$send['send_content'] = '摇滚盛宴，火热来袭，倾听时代的声音，唤醒内心的狂热！恭喜您中奖，成功获得集美家居消夏狂欢音乐季门票一张！将会有客服与您联系！   相约集美家居，不见不散！';
									$send['phone'] = $phone;
									$send_url = 'http://www.yoju360.com/api/message.php';
									curlPOST($send_url, $send);

									$ajax_result['errcode'] = 0;
									$ajax_result['errmsg'] = 'ok';
									$ajax_result['prize'] = 4;
									die(json_encode($ajax_result));
								} else {
									$ajax_result['errcode'] = 0;
									$ajax_result['errmsg'] = 'ok';
									$ajax_result['prize'] = 2;
									$ajax_result['prize_name'] = '谢谢参与';
									die(json_encode($ajax_result));
								}
							}
						}
					}
				}
			}
		} else {
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			$ajax_result['prize'] = 2;
			$ajax_result['prize_name'] = '谢谢参与';
			die(json_encode($ajax_result));
		}

	}

	if($act == "submit"){

		$name = mysqli_real_escape_string($db, $_POST['name']);
		if(empty($name)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}

		$add_time = date('Y-m-d H:i:s', time());
		$add_strtotime = time();

		$sql = "SELECT * FROM jmjj WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "ok";
			die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO jmjj(name, phone, number, prize_name, prize_pro, add_time, add_strtotime) VALUES('".$name."','".$phone."','0','','','".$add_time."','".$add_strtotime."')";
			$res = mysqli_query($db, $sql);
			if($res){
				$ajax_result['errcode'] = 0;
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
function curlPOST($url, $data){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
        curl_close($ch);
		return $temp;
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