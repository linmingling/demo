<?php 
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST)
{
	$act = trim($_POST['act']);
	// $act = $_GET['as'];
	if($act == "check")	//检查中奖人数是否已满
	{
		$sql = "select count(*) as c from nyhs where is_draw=1";
		$rs = mysqli_query($db,$sql);
		$rows = $rs->fetch_assoc();
		// var_dump($rows);die;
		if($rows['c'] >= 8)
		{
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "抽奖已结束！";
			die(json_encode($ajax_result));
		}
		else
		{
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "ok！";
			die(json_encode($ajax_result));
		}
		
	}
	elseif($act == "draw") 	//开始抽奖
	{
		$cut_time = strtotime('2015-08-18 11:00:00');
		$draw = array();
		//天津4个验证码(特殊)
		$check_tj_sql1 = "select count(*) as c from nyhs where captcha='TJ0221' and is_draw=1";
		$check_tj_sql2 = "select count(*) as c from nyhs where captcha='TJ0222' and is_draw=1";
		$check_tj_sql3 = "select count(*) as c from nyhs where captcha='TJ0223' and is_draw=1";
		$check_tj_sql4 = "select count(*) as c from nyhs where captcha='TJ0224' and is_draw=1";
		$check_tj_rs1 = mysqli_query($db,$check_tj_sql1);
		$check_tj_rs2 = mysqli_query($db,$check_tj_sql2);
		$check_tj_rs3 = mysqli_query($db,$check_tj_sql3);
		$check_tj_rs4 = mysqli_query($db,$check_tj_sql4);

		$check_tj_row1 = $check_tj_rs1->fetch_assoc();
		if($check_tj_row1['c'] > 0)
		{
			$check_tj_row2 = $check_tj_rs2->fetch_assoc();
			if($check_tj_row2['c'] > 0)
			{
				$check_tj_row3 = $check_tj_rs3->fetch_assoc();
				if($check_tj_row3['c'] > 0)
				{
					$check_tj_row4 = $check_tj_rs4->fetch_assoc();
					if($check_tj_row4['c'] > 0)
					{
						$captcha = '';
					}
					else
					{
						$captcha = 'TJ0224';
					}
				}
				else
				{
					$captcha = 'TJ0223';
				}
			}
			else
			{
				$captcha = 'TJ0222';
			}
		}
		else
		{
			$captcha = 'TJ0221';
		}

		if(!empty($captcha))
		{//die($captcha);
			$tj_sql = "select name,phone,captcha from nyhs where add_strtotime<{$cut_time} and captcha='{$captcha}' and is_draw=0";
			$tj_rs = mysqli_query($db,$tj_sql);
			$tj_rows = array();
			while($tj_row = $tj_rs->fetch_assoc())
			{
			    $tj_rows[] = $tj_row;
			}
			
			$pn = mt_rand(0,count($tj_rows) - 1);

			$draw = $tj_rows[$pn];//print_r($tj_rows);die('tj');
		}
		else
		{//die('222');
			//正常流程
			$sql = "select name,phone,captcha from nyhs where captcha not in(select captcha from nyhs where add_strtotime<{$cut_time} and is_draw=1)";
			$draw_rs = mysqli_query($db,$sql);
			$draw_rows = array();
			while($draw_row = $draw_rs->fetch_assoc())
			{
			    $draw_rows[] = $draw_row;
			}
			
			$pn = mt_rand(0,count($draw_rows) - 1);

			$draw = $draw_rows[$pn];//print_r($draw);die('nm');
		}

		$draw_sql = "update nyhs set is_draw=1 where phone='{$draw['phone']}' and name='{$draw['name']}' and captcha='{$draw['captcha']}'";
		mysqli_query($db,$draw_sql);

		$ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "ok！";
        $ajax_result['name'] = $draw['name'];
        $ajax_result['phone'] = $draw['phone'];
        die(json_encode($ajax_result));

	}
	elseif($act == 'add' )  //报名
    {
        $table1 = "nyhs";
        $table2 = "nyhs_city_captcha";
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $city = trim($_REQUEST['city']);//城市名
        $othercity = trim($_REQUEST['othercity']);//其他城市名
        $shopname = trim($_REQUEST['shopname']);//店铺名
        $ordersn = trim($_REQUEST['ordersn']);//店铺名
        $captcha = strtoupper(trim($_REQUEST['captcha']));//验证码

        if(empty($name) || empty($phone) || empty($city) || empty($shopname) || empty($captcha) || empty($ordersn))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(strlen($phone) != "11")
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "该手机号码格式不正确，请重新输入！";
            die(json_encode($ajax_result));
        }

        if(!preg_match("/^0{0,1}(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])[0-9]{8}$/",$phone))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "非法手机号码，请重新输入！";
            die(json_encode($ajax_result));
        }

        //重复姓名或电话注册检查
        $check_sql = "select name from {$table1} where phone='{$phone}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if($check_row)
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "您已报名，请不要重复提交！";
            die(json_encode($ajax_result));
        }
        

        if($captcha == "HOOS0225")      //通用验证码
        {
            //$othercity = '广州';
            $sql = "insert into {$table1} (name,phone,city,shopname,captcha,order_sn,add_time,add_strtotime,is_draw) values ('{$name}','{$phone}','{$othercity}','{$shopname}','{$captcha}','{$ordersn}','".date('Y-m-d H:i:s', time())."','".time()."',0)";
            mysqli_query($db, $sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "报名成功！";
            die(json_encode($ajax_result));
        }   
        else        //特定城市验证码
        {

            $check_captcha_sql = "select city from {$table2} where captcha='{$captcha}' and city='{$city}'";
            $check_captcha_res = mysqli_query($db,$check_captcha_sql);
            $check_captcha_row = $check_captcha_res->fetch_assoc();
            if(!$check_captcha_row)
            {
                $ajax_result['errcode'] = 1001;
                $ajax_result['errmsg'] = "您输入的验证码或城市错误！";
                die(json_encode($ajax_result));
            }

            $sql = "insert into {$table1} (name,phone,city,shopname,captcha,order_sn,add_time,add_strtotime,is_draw) values ('{$name}','{$phone}','{$city}','{$shopname}','{$captcha}','{$ordersn}','".date('Y-m-d H:i:s', time())."','".time()."',0)";
            mysqli_query($db, $sql);
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = "报名成功！";
            die(json_encode($ajax_result));
        }
    }
	else
	{
		$ajax_result['errcode'] = 1001;
		$ajax_result['msg'] = "非法操作！";
		die(json_encode($ajax_result));
	}

}



 ?>