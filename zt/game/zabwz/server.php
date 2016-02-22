<?php

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == 'score' ){
	    
	    if(date('Y-m-d H:i:s') > '2015-10-07 24:00:00'){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，活动已结束！";
	        die(json_encode($ajax_result));
	    }
	    
	    $openid = $_SESSION['zabwz_openid'];
	    if(empty($openid)){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
	        die(json_encode($ajax_result));
	    }
	    $score = intval(decrypt(mysqli_real_escape_string($db, $_POST['score'])));
	    
	    $sql = "SELECT score,phone from game_zabwz WHERE openid='".$_SESSION['zabwz_openid']."'";
	    $res = mysqli_query($db, $sql);
	    $max_score = $res->fetch_assoc();
	    
	    if(intval($max_score['score']) < intval($score)){
	        $sql = "UPDATE game_zabwz SET score='".$score."',update_time='".date('Y-m-d H:i:s')."' WHERE openid='".$_SESSION['zabwz_openid']."'";
	        $result = mysqli_query($db, $sql);
	        if($result !== false){
	            $ajax_result['errcode'] = 0;
	            $ajax_result['errmsg'] = 'ok';
	            $ajax_result['phone'] = $max_score['phone'];
	            die(json_encode($ajax_result));
	        } else {
	            $ajax_result['errcode'] = 1000;
	            $ajax_result['errmsg'] = '服务器繁忙，请退出重试！fail:003';
	            die(json_encode($ajax_result));
	        }
	    } else {
	        $ajax_result['errcode'] = 0;
	        $ajax_result['errmsg'] = 'ok';
	        $ajax_result['phone'] = $max_score['phone'];
	        die(json_encode($ajax_result));
	    }
	}


	if($act == "submit"){
	    $openid = $_SESSION['zabwz_openid'];
	    if(empty($openid)){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
	        die(json_encode($ajax_result));
	    }
		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "手机号码不能为空";
			die(json_encode($ajax_result));
		}
		
		$sql = "UPDATE game_zabwz SET phone='".$phone."' WHERE openid='".$_SESSION['zabwz_openid']."'";
	    $result = mysqli_query($db, $sql);
		if($result){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "ok";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "系统繁忙，请退出重试";
			die(json_encode($ajax_result));
		}
	}

	if($act == 'rank'){
		$sql = "SELECT * FROM game_zabwz WHERE score <> '' ORDER BY score DESC, update_time ASC LIMIT 10";
		$res = mysqli_query($db, $sql);
		$arr = array();
		while($row = $res->fetch_array()){
			$arr[] = $row;
		}
		if($arr){
			foreach ($arr as $k => $key){
				$list['list'][$k]['rank'] = $k + 1;
				$list['list'][$k]['nickname'] = substr_cut($key['wechaname'],2);
				$list['list'][$k]['score'] = $key['score'];
			}
		} else {
		    $list['list'][0]['rank'] = '';
		    $list['list'][0]['nickname'] = '';
		    $list['list'][0]['score'] = '';
		}
		$list = empty($list) ? '' : $list;
		die(json_encode($list));
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
		$str_cut = mb_substr($str_cut, 0, $i, 'utf-8').'**';
	}
	return $str_cut;
}
?>