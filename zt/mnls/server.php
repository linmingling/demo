<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);
    
	if($act == 'start' ){

        
        //     参数说明:忽略/概率/编号      
        $p0 = array_fill(0,25, 0);
        $p1 = array_fill(0,1, 7);  //背景墙
        $p2 = array_fill(0,25, 2);  
        $p3 = array_fill(0,1, 5); //装饰画
        $p4 = array_fill(0,25, 4);  
        $p5 = array_fill(0,3, 3);  //茶具
        $p6 = array_fill(0,25, 6);  
        $p7 = array_fill(0,1, 1);  //钥匙扣
        
        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7);
        
        //概率相加总和填入第二个参数
        $pn = mt_rand(0,count($arr_m) - 1);
        //echo $arr_m[$pn];  
        $p_list = array(1,3,5,7);

        $check_quantity_sql = "select quantity from mnls_prize where prize_num={$arr_m[$pn]}";
        $check_quantity_res = mysqli_query($db,$check_quantity_sql);
        $check_quantity_row = $check_quantity_res->fetch_assoc();
        if($check_quantity_row['quantity'] == 0 && in_array($arr_m[$pn],$p_list))
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = 0;
            die(json_encode($ajax_result));
        }
        else
        {
            if(in_array($arr_m[$pn],$p_list))
            {
                switch($arr_m[$pn])
                {
                    case 7:
                        $_SESSION['mnls_prize_name'] = '背景墙';
                        break;
                    case 5:
                        $_SESSION['mnls_prize_name'] = '装饰画';
                        break;
                    case 3:
                        $_SESSION['mnls_prize_name'] = '茶具';
                        break;
                    case 1:
                        $_SESSION['mnls_prize_name'] = '钥匙扣';
                        break;
                }
                $_SESSION['mnls_prize'] = $arr_m[$pn];
            }
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = $arr_m[$pn];
            
            die(json_encode($ajax_result));
        }

	}

    
    if($act == "addinfo")
    {
        $name = trim($_REQUEST['name']);//姓名
        $phone = trim($_REQUEST['phone']);//手机号
        $address = trim($_REQUEST['address']);//所选答案

        if(empty($name) || empty($phone) || empty($address))
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

        //检测是否重复中奖
        $check_sql = "select prize_name from mnls where phone='{$phone}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();

        if(!empty($check_row['prize_name']))
        {
            $ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已重复提交信息，不能重复中奖！";
			die(json_encode($ajax_result));
        }

        mysqli_query($db,"begin");
        mysqli_query($db,"update mnls_prize set quantity=quantity-1 where prize_num=" . $_SESSION['mnls_prize']);
        mysqli_query($db,"commit");

        $sql = "insert into mnls (name,phone,address,prize_name,prize,add_time,add_strtotime) values ('{$name}','{$phone}','{$address}','" . $_SESSION['mnls_prize_name'] . "','" . $_SESSION['mnls_prize'] . "','".date('Y-m-d H:i:s', time())."','".time()."')";
        mysqli_query($db, $sql);

        

        $_SESSION['mnls_prize_name'] = '';
        $_SESSION['mnls_prize'] = '';

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
    }

}



?>