<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);
    if(empty($_SESSION['znwy_openid'])){
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }
	if($act == 'start' ){

        $check_sql = "select prize_name,times,is_times,last_time from znwy where openid='{$_SESSION['znwy_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        $update_tag = false;
        
        if(!empty($check_row['prize_name']))
        {
            $ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已中过奖！";
			die(json_encode($ajax_result));
        }
        
        //更新时间和次数
        if((strtotime(date('Y-m-d',$check_row['last_time']))) < strtotime('today'))
        {
            $update_sql = "update znwy set times=times+1,is_times=0,share_times=0,last_time=" . time() . " where openid='{$_SESSION['znwy_openid']}'";
            mysqli_query($db,$update_sql);
            $update_tag = true;
        }

        if(($check_row['is_times'] >= 3) && (!$update_tag))
        {
            $ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = "您今天的抽奖次数已经用光啦！";
			die(json_encode($ajax_result));
        }
        
        if($check_row['times'] == 0  && (!$update_tag))
        {
            $ajax_result['errcode'] = 1003;
			$ajax_result['errmsg'] = "您已没有抽奖次数啦，赶快分享给朋友获取抽奖次数吧！";
			die(json_encode($ajax_result));
        }

        if($update_tag)
        {
            $ajax_result['times'] = $check_row['times'];
        }
        else
        {
            $ajax_result['times'] = $check_row['times'] - 1;
        }
        //     参数说明:忽略/概率/编号      
        $p1 = array_fill(0,1,1);//特等
        $p2 = array_fill(0,1, 3);  //优秀
        $p3 = array_fill(0,5, 5);  //参与
        $p4 = array_fill(0,35, 2);
        $p5 = array_fill(0,35, 4);
        $p6 = array_fill(0,35, 6);
        
        $arr_m = array_merge($p1,$p2,$p3,$p4,$p5,$p6);
        
        //概率相加总和填入第二个参数
        $pn = mt_rand(0,count($arr_m) - 1);
        $p_list = array(1,3,5);

        $check_quantity_sql = "select quantity from znwy_prize where prize_num={$arr_m[$pn]}";
        $check_quantity_res = mysqli_query($db,$check_quantity_sql);
        $check_quantity_row = $check_quantity_res->fetch_assoc();
        if($check_quantity_row['quantity'] == 0 && in_array($arr_m[$pn],$p_list))
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = 0;
            mysqli_query($db,"update znwy set times=times-1,is_times=is_times+1 where openid='{$_SESSION['znwy_openid']}'");
            die(json_encode($ajax_result));
        }
        else
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = $arr_m[$pn];
            

            mysqli_query($db,"begin");
            switch ($arr_m[$pn]) {
                case 1:
                    mysqli_query($db,"update znwy set times=times-1,is_times=is_times+1,prize_name='马桶',prize=1 where openid='{$_SESSION['znwy_openid']}'");
                    break;
                case 3:
                    mysqli_query($db,"update znwy set times=times-1,is_times=is_times+1,prize_name='马桶盖',prize=3 where openid='{$_SESSION['znwy_openid']}'");
                    break;
                case 5:
                    mysqli_query($db,"update znwy set times=times-1,is_times=is_times+1,prize_name='毛巾',prize=5 where openid='{$_SESSION['znwy_openid']}'");
                    break;
                default:
                    mysqli_query($db,"update znwy set times=times-1,is_times=is_times+1 where openid='{$_SESSION['znwy_openid']}'");
                    break;
            }
            mysqli_query($db,"commit");

            mysqli_query($db,"begin");
            mysqli_query($db,"update znwy_prize set quantity=quantity-1 where prize_num={$arr_m[$pn]}");
            mysqli_query($db,"commit");
            
            die(json_encode($ajax_result));
        }

	}

    if($act == 'addtimes' )
    {
        //可抽奖次数
        $times_sql = "select share_times from znwy where openid='{$_SESSION['znwy_openid']}'";
        $times_res = mysqli_query($db, $times_sql);
        $times_row = $times_res->fetch_assoc();
        if($times_row['share_times'] < 2)
        {
            mysqli_query($db,"begin");
            mysqli_query($db,"update znwy set times=times+1,share_times=share_times+1 where openid='{$_SESSION['znwy_openid']}'");
            mysqli_query($db,"commit");
        }

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
    }
    
    if($act == "addinfo")
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $address = trim($_REQUEST['address']);//地址

        if(empty($name) || empty($phone) || empty($address))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
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

        

        $sql = "update znwy set name='{$name}',phone='{$phone}',address='{$address}' where openid='{$_SESSION['znwy_openid']}'";
        mysqli_query($db, $sql);
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    }

}



?>