<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';

if($_POST)
{
	$act = trim($_POST['act']);
	
	//抽奖
	if($act == 'draw')
	{
		// 传入抽奖数和名次
		$priNum = $_POST['priNum'];
		$priRank = $_POST['priRank'];
		
		// 获取未中奖的人员
		$mem_sql = "select wxInfo.head_icon,usInfo.user_id,usInfo.name,usInfo.row_num,usInfo.column_num,usInfo.company_nm from $fest_user as usInfo,$fest_weixin as wxInfo where wxInfo.user_id = usInfo.user_id and usInfo.is_prize=0";
		$mem_res = mysqli_query($db, $mem_sql);
		
		$tmp = array();
		$i = 0;
		while($row = $mem_res->fetch_assoc()) {
			$tmp[$i]['id'] = $row['user_id'];
			$tmp[$i]['name'] = $row['name'];
			$tmp[$i]['src'] = $row['head_icon'];
			$tmp[$i]['row'] = $row['row_num'];
			$tmp[$i]['column'] = $row['column_num'];
			$tmp[$i]['company_nm'] = $row['company_nm'];			
			$i++;
		}
				
		// 抽取获奖人员
		$str = '';
		$extract = array_rand($tmp,$priNum);
		if(is_array($extract) && !empty($extract)){ 
			foreach($extract as $value){
				
				$user_sql = "update $fest_user set rank_num='{$priRank}',add_time='" . date('Y-m-d H:i:s') . "',is_prize=1 where user_id='{$tmp[$value]['id']}'";
				mysqli_query($db, $user_sql);
				
				$str .= '{"wxname":"'.$tmp[$value]['name'].'","src":"'.$tmp[$value]['src'].'","index":"'.$tmp[$value]['id'].'","com_nm":"'.$tmp[$value]['company_nm'].'"},';
			}
		
			//json字符串
			$str = substr($str,0,strlen($str)-1); 
			$str = '['.$str.']';
		}else{
			$str = '[{"wxname":"'.$tmp[$extract]['name'].'","src":"'.$tmp[$extract]['src'].'","index":"'.$tmp[$value]['id'].'","com_nm":"'.$tmp[$value]['company_nm'].'"}]';
		}
		
		
		// 返回json字符串
		$ajax_result['errcode'] = 0;
		$ajax_result['result'] = $str;
		die(json_encode($ajax_result));
	}

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
				$str .= '{"wxname":"'.$tmp[$key]['name'].'","src":"'.$tmp[$key]['head_icon'].'","id":"'.$tmp[$key]['user_id'].'","com_nm":"'.$tmp[$key]['company_nm'].'"},';
			}
		}
		
		//json字符串
		$str = substr($str,0,strlen($str)-1); 
		$str = '['.$str.']';	

		// 返回json字符串
		$ajax_result['errcode'] = 0;
		$ajax_result['result'] = $str;
		die(json_encode($ajax_result));
		
	}
}
?>