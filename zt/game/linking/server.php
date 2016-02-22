<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');
$table = 'hx_llk_info';
if($_POST) 
{
    

	$act = trim($_POST['act']);
    if(empty($_SESSION['hx_llk_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }

    if($act == "add")   //提交分数
    {
       if(strtotime(date('Y-m-d H:i:s')) >= strtotime("2015-11-23 00:00:00")) // 时间判断
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "活动结束";
            die(json_encode($ajax_result));
        }
	   
        $score = intval(decrypt(trim($_POST['score'])));
        
        $check_sql = "select score from {$table} where openid='{$_SESSION['hx_llk_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if(empty($check_row))
        {
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "非法用户";
            die(json_encode($ajax_result));
        }

        if($check_row['score'] < $score)
        {
            $sql = "update {$table} set score={$score},last_play_time='" . date('Y-m-d H:i:s') . "',play_times=play_times+1 where score<{$score} and openid='" . $_SESSION['hx_llk_openid'] . "'";
            mysqli_query($db, $sql);
        }
        
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
        
    }
	
	if($act == "subInfo") // 提交信息
	{
		$name = trim($_POST['name']);
		$phone = trim($_POST['phone']);
		
		// 信息完整
		if(empty($name) || empty($phone))
		{
			$ajax_result['errcode'] = 1003;
			$ajax_result['errmsg'] = '信息填写不完整';
			die(json_encode($ajax_result));
		}
		
		if(strlen($phone) != "11")
		{
			$ajax_result['errcode'] = 1004;
			$ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
			die(json_encode($ajax_result));
		}
			
		if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
		{
			$ajax_result['errcode'] = 1005;
			$ajax_result['errmsg'] = "非法手机号码，请重新输入！";
			die(json_encode($ajax_result));
		}
		
		$check_sql = "select name,phone from {$table} where openid='{$_SESSION['hx_llk_openid']}'";
		$check_res = mysqli_query($db,$check_sql);
		$check_row = $check_res->fetch_assoc();
		
		if(empty($check_row['name']) || empty($check_row['phone']))
		{
			$sql = "update {$table} set name='{$name}',phone='{$phone}' where openid='" . $_SESSION['hx_llk_openid'] . "'";
			mysqli_query($db, $sql);
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = 'ok';
			die(json_encode($ajax_result));
		} else {
			$ajax_result['errcode'] = 1006;
			$ajax_result['errmsg'] = '感谢您的提交，信息已经提交成功！';
			die(json_encode($ajax_result));
		}
			
	}
	
	if($act == 'rank')  //排行榜
    {
        $sql = "select wechaname,score from {$table} where score>0 order by score desc, last_play_time asc limit 80";

        $res = mysqli_query($db,$sql);
        
        $tmp = array();
		$i = 0;
		while($row = $res->fetch_assoc()) {
			$tmp[$i]['wechaname'] = $row['wechaname'];	
			$tmp[$i]['score'] = $row['score'];
			$tmp[$i]['mingci'] = $i + 1;
			
			$i++;
		}
		
		$ajax_result['errcode'] = 0;
		$ajax_result['paihang'] = $tmp;
		die(json_encode($ajax_result));
    }

    if($act == 'award')  //获奖名单
    {
        $sql = "select wechaname from {$table} where score>0 order by score desc, last_play_time asc limit 80";

        $res = mysqli_query($db,$sql);
        
        $tmp = array();
        $j = 0;
        $i = 1;
        while($row = $res->fetch_assoc())
        {
            if($i == 1)
            {
                $tmp[$j]['wechaname'] = $row['wechaname'];
                $tmp[$j]['prize'] = 'iphone6S';
            }
            elseif($i >= 2 && $i <=5)
            {
                $tmp[$j]['wechaname'] = $row['wechaname'];
                $tmp[$j]['prize'] = '左右定制真皮钱包';
            }
            elseif($i >= 6 && $i <=20)
            {
                $tmp[$j]['wechaname'] = $row['wechaname'];
                $tmp[$j]['prize'] = '定制卡通U盘';
            }
            elseif($i >= 21 && $i <=80)
            {
                $tmp[$j]['wechaname'] = $row['wechaname'];
                $tmp[$j]['prize'] = '左右定制卡通抱枕';
            }

            $i++;
            $j++;

        }
        
        $ajax_result['errcode'] = 0;
        $ajax_result['prizeList'] = $tmp;
        die(json_encode($ajax_result));
    }
}

?>