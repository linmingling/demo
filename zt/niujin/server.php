<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$table = 'niujin_toupiao';
if($_POST) 
{
    
	$act = trim($_POST['act']);

	if($act == 'left')  //左边点击
    {
		$sql = "update {$table} set num=num+1 where id=1";
		mysqli_query($db, $sql);
      
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
    }
	
    if($act == "right")   //右边点击
    {

		$sql = "update {$table} set num=num+1 where id=2";
		mysqli_query($db, $sql);
      
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
        
    }	

	if($act == "search")   //获得投票数
    {

		$mem_sql = "select * from $table";
		$mem_res = mysqli_query($db, $mem_sql);
		
		$tmp = array();
		$i = 1;
		while($row = $mem_res->fetch_assoc()) {
			$tmp[$i] = $row['num'];			
			$i++;
		}
		
		$ajax_result['errcode'] = 0;
        $ajax_result['num'] = $tmp;
        die(json_encode($ajax_result));
        
    }
	
}
?>