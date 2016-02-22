<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');
$info_table = 'game_claw_info';
$prize_table = 'game_claw_prize';
if($_POST)
{
	$act = trim($_POST['act']);
	if(empty($_SESSION['claw_openid']))
	{
		$ajax_result['errcode'] = 1000;
		$ajax_result['errmsg'] = "参数异常，请退出重试！";
// 		die(json_encode($ajax_result));
	}
	
	if($act == 'submitscore')
	{
		$score = intval(decrypt(trim($_POST['score'])));
		
		$check_sql = "select score from {$info_table} where openid='{$_SESSION['claw_openid']}'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		if(empty($check_row))
		{
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = "非法用户";
			die(json_encode($ajax_result));
		}
		
		if($score>0)
		{
			$sql = "update $info_table set score=score+{$score},sum_score=sum_score+{$score},play_times=play_times+1 where openid='{$_SESSION['claw_openid']}'";
			mysqli_query($db,$sql);
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = $sql;
		die(json_encode($ajax_result));
		
	}
	
	if($act == 'rank')
	{
		//排行榜
		$rank_sql = "select wechaname,sum_score from $info_table where sum_score>0 order by sum_score desc limit 10";
		$rank_res = mysqli_query($db, $rank_sql);
		$num = 1;
		$i = 0;
		while ($rank_row = $rank_res->fetch_assoc())
		{
			$rank_rows['list'][$i]['rank'] = $num;
			$rank_rows['list'][$i]['nickname'] = mb_substr($rank_row['wechaname'],0,1,'utf-8') . '**';
			$rank_rows['list'][$i]['score'] = $rank_row['sum_score'];
			$num++;
			$i++;
		}

        $self_sql = "select wechaname,sum_score,openid from $info_table where openid='{$_SESSION['claw_openid']}'";
		$self_res = mysqli_query($db, $self_sql);
        $self_row = $self_res->fetch_assoc();

        $self_rank_sql = "select count(*) as c from $info_table where sum_score>(select sum_score from $info_table where openid='{$_SESSION['claw_openid']}')";
		$self_rank_res = mysqli_query($db, $self_rank_sql);
        $self_rank_row = $self_rank_res->fetch_assoc();

        $rank_rows['self'] = array(
            'rank'=>$self_rank_row['c'] + 1,
            'nickname'=>mb_substr($self_row['wechaname'],0,1,'utf-8') . '**',
            'score'=>$self_row['sum_score']
        );
		
		$ajax_result['errcode'] = 0;
		$ajax_result['ranklist'] = $rank_rows;
		die(json_encode($ajax_result));
	}
	
	if($act == 'share')
	{
		$check_sql = "select share_tag from $info_table where openid='{$_SESSION['claw_openid']}'";
		$check_res = mysqli_query($db, $check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if($check_row['share_tag'] == 0)
		{
			mysqli_query($db, "update $info_table set share_tag=1,score=score+100,sum_score=sum_score+100 where openid='{$_SESSION['claw_openid']}'");
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = 'ok';
		die(json_encode($ajax_result));
	}
	
	if($act == 'register')
	{
		$check_sql = "select register_tag from $info_table where openid='{$_SESSION['claw_openid']}'";
		$check_res = mysqli_query($db, $check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if($check_row['register_tag'] == 0)
		{
			mysqli_query($db, "update $info_table set register_tag=1,score=score+100,sum_score=sum_score+100 where openid='{$_SESSION['claw_openid']}'");
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = 'ok';
		die(json_encode($ajax_result));
	}
	
	if($act == 'reward')
	{
		$name = trim($_POST['name']);
		$prizeId = trim($_POST['prizeId']);
		$phone = trim($_POST['phone']);
		$address = trim($_POST['address']);
		
		$check_sql = "select prize_id,score from $info_table where openid='{$_SESSION['claw_openid']}'";
		$check_res = mysqli_query($db, $check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if(empty($check_row))
		{
			$ajax_result['errcode'] = 1004;
			$ajax_result['errmsg'] = '您还没进行过游戏呢，赶快去体验一下吧！';
			die(json_encode($ajax_result));
		}
		elseif ($check_row['prize_id']>0)
		{
			$ajax_result['errcode'] = 1005;
			$ajax_result['errmsg'] = '您已兑换过奖励了！';
			die(json_encode($ajax_result));
		}
		
		if(empty($name) || empty($phone) || empty($address))
		{
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = '信息填写不完整';
			die(json_encode($ajax_result));
		}
			
		if(strlen($phone) != "11")
		{
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
			die(json_encode($ajax_result));
		}
			
		if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
		{
			$ajax_result['errcode'] = 1003;
			$ajax_result['errmsg'] = "非法手机号码，请重新输入！";
			die(json_encode($ajax_result));
		}
		
		switch ($prizeId)
		{
			case 1:
				$prize = 'QQ公仔一对';
				$score = 60000;
				break;
			case 2:
				$prize = '20元现金奖';
				$score = 70000;
				break;
			case 3:
				$prize = '30元现金奖';
				$score = 80000;
				break;
			case 4:
				$prize = '美的扫地机一台';
				$score = 110000;
				break;
			case 5:
				$prize = '100M流量包';
				$score = 60000;
				break;
			case 6:
				$prize = '150M流量包';
				$score = 70000;
				break;
			case 7:
				$prize = '500M流量包';
				$score = 80000;
				break;
			case 8:
				$prize = '1G流量包';
				$score = 110000;
				break;
		}
			
		if($check_row['score'] < $score)
		{
			$ajax_result['errcode'] = 1006;
			$ajax_result['errmsg'] = '您的积分不足兑换该礼品！';
			die(json_encode($ajax_result));
		}
			
		$gift_sql = "select quantity from $prize_table where prize_num='{$prizeId}'";
		$gift_res = mysqli_query($db,$gift_sql);
		$gift_row = $gift_res->fetch_assoc();
		if($gift_row['quantity'] <= 0)
		{
			$ajax_result['errcode'] = 1007;
			$ajax_result['errmsg'] = '该礼品已经兑换完啦！';
			die(json_encode($ajax_result));
		}
			
		mysqli_query($db,"begin");
		mysqli_query($db,"update $info_table set name='{$name}',phone='{$phone}',address='{$address}',prize='{$prize}',prize_id='{$prizeId}',score=score-{$score} where openid='{$_SESSION['claw_openid']}'");
		mysqli_query($db,"commit");
			
		mysqli_query($db,"begin");
		mysqli_query($db,"update $prize_table set quantity=quantity-1 where prize_num='{$prizeId}'");
		mysqli_query($db,"commit");
			
		$ajax_result['errcode'] = 0;
		$ajax_result['errmsg'] = '恭喜您已经成功兑换,实物我们将于11月8日后10个工作日内快递寄出,现金红包将由工作人员3天内发送';
		die(json_encode($ajax_result));
		
	}
}




?>