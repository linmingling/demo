<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST)
{

	$act = trim($_POST['act']);
	if($act = "vote")
	{
		$vote_data = intval($_POST['vote_data']);
		$sql = "update ayrs_vote set vote_count=vote_count+1 where vote_id={$vote_data}";
		mysqli_query($db,$sql);
		
		$ajax_result['errcode'] = 0;
		$ajax_result['msg'] = "投票成功！";
		die(json_encode($ajax_result));
		
	}
	else
	{
		$ajax_result['errcode'] = 1001;
		$ajax_result['msg'] = "非法操作！";
		die(json_encode($ajax_result));
	}

}





 ?>