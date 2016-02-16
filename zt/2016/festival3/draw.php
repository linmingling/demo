<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';

if($_POST)
{
	$act = trim($_POST['act']);
 
	//抽奖2
	if($act == 'draw2')
	{
		// 传入抽奖数和名次
		$arrJson = $_POST['arrInfo'];
		$priNum = $_POST['priNum'];
		$priRank = $_POST['priRank'];
		
		$tmp = array();
		$str = '';
		$tmp = json_decode($arrJson,true);
		if(is_array($tmp)) {
			$extractKey = array_rand($tmp,$priNum);
			foreach($extractKey as $key) {
				$user40_sql = "update $fest_user set rank_num='{$priRank}',add_time='" . date('Y-m-d H:i:s') . "',is_prize=1 where user_id='{$tmp[$key]['user_id']}'";
				mysqli_query($db, $user40_sql);
				$str .= '{"name":"'.$tmp[$key]['name'].'","src":"'.$tmp[$key]['head_icon'].'","id":"'.$tmp[$key]['user_id'].'","com_nm":"'.$tmp[$key]['company_nm'].'"},';
			}
		}
		
		//json字符串
		$str = substr($str,0,strlen($str)-1); 
		$str = '['.$str.']';	

		// 返回json字符串
		$ajax_result['errcode'] = 0;
		$ajax_result['str'] = $str;
		die(json_encode($ajax_result));
    
	}
}
?>