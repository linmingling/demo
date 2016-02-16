<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');

$fest_weixin = 'festival2016_ld';
$fest_user = 'festival2016_ld_user';
$fest_draw = 'festival2016_draw';
$fest_jilu = 'festival2016_jilu';
       
$redis = new Redis();
$redis->connect('localhost', 6379);
$key = 'r_userinsert';   

if($_POST)
{
	$act = trim($_POST['act']);	
	
	//抽取候选人
	if($act == 'charge'){
		//清空摇一摇数据
		$redis->delete('r_userinsert');
		$redis->set('group_1',0);
		$redis->set('group_2',0);
		$redis->set('group_3',0);
		$redis->set('add_switch', 0);
		
		$renArr = array();
		for($i=1;$i<=3;$i++){
			$mem_sql = "select * from $fest_user where is_prize=0 and company='{$i}' order by rand() limit 1";		
			$mem_res = mysqli_query($db, $mem_sql);
			$res_user = $mem_res->fetch_assoc();
						
			$sql = "insert into $fest_draw (user_id,company,company_nm,name,addtime) values ('{$res_user['user_id']}','{$res_user['company']}','{$res_user['company_nm']}','{$res_user['name']}','" . date('Y-m-d H:i:s') . "')";
			mysqli_query($db, $sql);
			$renArr[$i-1] = $res_user['name'];
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['renArr'] = $renArr;
		
		die(json_encode($ajax_result));
	}
	
	//计时标识 1家居 2优居 3我买家
	if($act == 'start'){		
		if($_POST['sign_num']=='0'){
			//时间结束
			$redis->set('add_switch', 0);
			//$sig_sql = "update festival2016_switch set sign='0' where id='1'";
			//mysqli_query($db, $sig_sql);
			
		}elseif($_POST['sign_num']=='1'){
			// 点击开始按钮
			$redis->set('add_switch', 1);
			//$sig_sql = "update festival2016_switch set sign='1' where id='1'";
			//mysqli_query($db, $sig_sql);
		}
	}
	
	//选择分数最高的人is_prize设1
	if($act == 'changePri'){
		// 获取所有队列
		$key = 'r_userinsert';
		$rdata = $redis->lrange($key,0,-1);	
		if(is_array($rdata)) {
			foreach($rdata as $val) {
				$bval = null;
				$bval = json_decode($val,true);
				// 入库
				$sql = "insert into $fest_jilu (company,times) values ('{$bval['sig']}','{$bval['num']}')";
				mysqli_query($db, $sql);		
				//echo $sql;
			}
		}
		
		$arr = array();
		for($i=1;$i<=3;$i++){
			$sql = "select sum(times) as sumTimes,company from $fest_jilu where company='{$i}'";
			$res = mysqli_query($db, $sql);
			$tmp = $res->fetch_assoc();
			$arr[$i] = $tmp['sumTimes'];
		}
		$maxKey = array_search(max($arr),$arr);
		//获取最高分数的user_id
		$mem_sql = "select * from $fest_draw where company='{$maxKey}'";		
		$mem_res = mysqli_query($db, $mem_sql);
		$res_user = $mem_res->fetch_assoc();
		//获奖者设1
		$sql = "update $fest_user set is_prize='1',rank_num='特等奖' where user_id='{$res_user['user_id']}'";
		mysqli_query($db, $sql);
	}
	
	//查询数据库 1家居 2优居 3我买家
	if($act == 'search'){	
		$arr = array();
		
		$jj_data = $redis->get("group_1");	// 家居			
		$yj_data = $redis->get("group_2");	// 优居	
		$wmj_data = $redis->get("group_3");	// 我买家	
		
		$arr['1'] = $jj_data*1;
		$arr['2'] = $yj_data*1;
		$arr['3'] = $wmj_data*1;
		
		$ajax_result['errcode'] = 0;
		$ajax_result['res'] = $arr;
		die(json_encode($ajax_result));		
	}
	
	//插数据
	if($act == 'sub'){
		$addSwitch = $redis->get('add_switch');
		//$mem_sql = "select * from festival2016_switch where id='1' limit 1";
		//$mem_res = mysqli_query($db, $mem_sql);
		//$sig_res = $mem_res->fetch_assoc();
		$addSwitch*=1;
		
		if($addSwitch==1){	
			// 插入		
			$key = 'r_userinsert';
			$data['num'] = $_POST['num'];
			$data['sig'] = $_POST['sig'];
			//$data['addtime'] = date('Y-m-d H:i:s');
			$value = json_encode( $data );
			$redis->lpush($key,$value); 

			// 公司统计数据列表，
			$company_name = 'group_'.$data['sig'];
			$gnum = $redis->get($company_name);
			$gnum *=1;
			$gnum +=$data['num'];
			
			$redis->set($company_name, $gnum);
			//$redis->lpush($company_name,$data['num']); 	
		}
	}
}
?>