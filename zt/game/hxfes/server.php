<?php

define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
// require(ROOT_PATH . '../../../data/secre.php');

if($_POST){

	$act = trim($_POST['act']);

	if($act == 'score' ){
	    
	    if(time() > strtotime('2015-11-02')){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，活动已结束！";
	        die(json_encode($ajax_result));
	    }
	    
	    $openid = $_SESSION['fes_openid'];
	    if(empty($openid)){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
	        die(json_encode($ajax_result));
	    }
// 	    $score = intval(decrypt(mysqli_real_escape_string($db, $_POST['score'])));
	    $score = intval(mysqli_real_escape_string($db, $_POST['score']));
	    
	    if(time() > strtotime('2015-10-13') && time() < strtotime('2015-10-25 23:59:59')){
	        $score_type = "score1";
	        $last_time = "last_time1";
	        $strtotime = "strtotime1";
	    } else if(time() > strtotime('2015-10-26') && time() < strtotime('2015-11-01 23:59:59')){
	        $score_type = "score2";
	        $last_time = "last_time2";
	        $strtotime = "strtotime2";
	    }
	    
	    $sql = "SELECT * from game_hxfes WHERE openid='".$_SESSION['fes_openid']."'";
	    $res = mysqli_query($db, $sql);
	    $info = $res->fetch_assoc();
	    if($info['is_share']){
    	    if(intval($info[$score_type]) < intval($score)){
    	        $sql = "UPDATE game_hxfes SET ".$score_type."='".$score."',".$last_time."='".date('Y-m-d H:i:s')."',".$strtotime."='".time()."' WHERE openid='".$_SESSION['fes_openid']."'";
    	        $result = mysqli_query($db, $sql);
    	        if($result !== false){
    	            $ajax_result['errcode'] = 0;
    	            $ajax_result['errmsg'] = 'ok';
    	            $ajax_result['max_score'] = $score;
    	            die(json_encode($ajax_result));
    	        } else {
    	            $ajax_result['errcode'] = 1000;
    	            $ajax_result['errmsg'] = '服务器繁忙，请关闭此页面后重新进入，谢谢！';
    	            die(json_encode($ajax_result));
    	        }
    	    } else {
    	        $ajax_result['errcode'] = 0;
    	        $ajax_result['errmsg'] = 'ok';
    	        $ajax_result['max_score'] = $info[$score_type];
    	        die(json_encode($ajax_result));
    	    }
	    } else {
	        $ajax_result['errcode'] = 1000;
	        $ajax_result['errmsg'] = 'please share';
	        die(json_encode($ajax_result));
	    }
	}


	if($act == "share"){
	    $openid = $_SESSION['fes_openid'];
	    if(empty($openid)){
	        $ajax_result['errcode'] = 1001;
	        $ajax_result['errmsg'] = "对不起，由于网络波动您的登录信息已失效，请关闭此页面后重新进入，谢谢！";
	        die(json_encode($ajax_result));
	    }
// 	    $score = intval(decrypt(mysqli_real_escape_string($db, $_POST['score'])));
	    $score = intval(mysqli_real_escape_string($db, $_POST['score']));
	    
	    if(time() > strtotime('2015-10-13') && time() < strtotime('2015-10-25 23:59:59')){
	        $score_type = "score1";
	        $last_time = "last_time1";
	        $strtotime = "strtotime1";
	    } else if(time() > strtotime('2015-10-26') && time() < strtotime('2015-11-01 23:59:59')){
	        $score_type = "score2";
	        $last_time = "last_time2";
	        $strtotime = "strtotime2";
	    }
	    
	    $sql = "SELECT is_share from game_hxfes WHERE openid='".$_SESSION['fes_openid']."'";
	    $res = mysqli_query($db, $sql);
	    $info = $res->fetch_assoc();
	    if(!$info['is_share']){
	        $sql = "UPDATE game_hxfes SET is_share=1,".$score_type."='".$score."',".$last_time."='".date('Y-m-d H:i:s')."',".$strtotime."='".time()."' WHERE openid='".$_SESSION['fes_openid']."'";
	        $result = mysqli_query($db, $sql);
	        if($result !== false){
	            $ajax_result['errcode'] = 0;
	            $ajax_result['errmsg'] = 'ok';
	            $ajax_result['max_score'] = $score;
	            die(json_encode($ajax_result));
	        } else {
	            $ajax_result['errcode'] = 1000;
	            $ajax_result['errmsg'] = '服务器繁忙，请关闭此页面后重新进入，谢谢！';
	            die(json_encode($ajax_result));
	        }
	    } else {
	        $ajax_result['errcode'] = 0;
	        $ajax_result['errmsg'] = 'ok';
	        die(json_encode($ajax_result));
	    }
	}

	if($act == 'rank'){
	    
	    $qishu = $_POST['qishu'];
	    if($qishu == 0){
	        if(time() > strtotime('2015-10-13') && time() < strtotime('2015-10-25 23:59:59') || time() > strtotime('2015-11-01 23:59:59')){
	            $sort = 1;
	            $score_type = "score1";
	            $where = "WHERE score1 <> 0 ORDER BY score1 DESC, strtotime1 ASC";
	        } else if(time() > strtotime('2015-10-26') && time() < strtotime('2015-11-01 23:59:59')){
	            $sort = 2;
	            $score_type = "score2";
	            $where = "WHERE score2 <> 0 ORDER BY score2 DESC, strtotime2 ASC";
	        } 
	    } else if($qishu == 1){
	        $sort = 1;
	        $score_type = "score1";
	        $where = "WHERE score1 <> 0 ORDER BY score1 DESC, strtotime1 ASC";
	    } else if($qishu == 2){
	        $sort = 2;
	        $score_type = "score2";
	        $where = "WHERE score2 <> 0 ORDER BY score2 DESC, strtotime2 ASC";
	    }
	    
		$sql = "SELECT * FROM game_hxfes ".$where." LIMIT 16";
		$res = mysqli_query($db, $sql);
		$arr = array();
		while($row = $res->fetch_array()){
			$arr[] = $row;
		}
		if($arr){
			foreach ($arr as $k => $key){
				$list[$k]['rank'] = $k + 1;
				$list[$k]['wechaname'] = substr_cut($key['wechaname'],2);
				$list[$k]['score'] = $key[$score_type];
			}
		} else {
		    $list[0]['rank'] = '';
		    $list[0]['wechaname'] = '';
		    $list[0]['score'] = '';
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