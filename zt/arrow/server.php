<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){

	$act = trim($_POST['act']);
    if(empty($_SESSION['arrow_openid'])){
        $ajax_result['errcode'] = 1001;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }
	if($act == 'start' ){

       $check_sql = "select prize_name,times,is_times from arrow where openid='{$_SESSION['arrow_openid']}'";
//         $check_sql = "select prize_name,times,is_times from arrow where openid='abc123123'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if(!empty($check_row['prize_name']))
        {
            $ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已中过奖！";
			die(json_encode($ajax_result));
        }
        elseif($check_row['is_times'] >= 10)
        {
            $ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已抽奖超过10次，机会已经用光啦！";
			die(json_encode($ajax_result));
        }
        elseif($check_row['times'] == 0)
        {
            $ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "您已没有抽奖次数啦，赶快分享给朋友获取抽奖次数吧！";
			die(json_encode($ajax_result));
        }
        
        //     参数说明:忽略/概率/编号      
        $p0 = array_fill(0,24, 0);
        $p1 = array_fill(0,5, 1);  //饭盒
        $p2 = array_fill(0,24, 2);
        $p3 = array_fill(0,24, 3);
        $p4 = array_fill(0,1, 4);  //旅行箱
        $p5 = array_fill(0,24, 5);
        $p6 = array_fill(0,24, 6);
        $p7 = array_fill(0,5, 7);  //小夜灯
        $p8 = array_fill(0,24, 8);
        $p9 = array_fill(0,24, 9);
        $p10 = array_fill(0,60, 10); //卷尺
        $p11 = array_fill(0,24, 11); 
        
        $arr_m = array_merge($p0,$p1,$p2,$p3,$p4,$p5,$p6,$p7,$p8,$p9,$p10,$p11);
        
        //概率相加总和填入第二个参数
        $pn = mt_rand(0,count($arr_m) - 1);
        //echo $arr_m[$pn];  
        $p_list = array(1,4,7,10);

        $check_quantity_sql = "select quantity from arrow_prize where prize_num={$arr_m[$pn]}";
        $check_quantity_res = mysqli_query($db,$check_quantity_sql);
        $check_quantity_row = $check_quantity_res->fetch_assoc();
        if($check_quantity_row['quantity'] == 0 && in_array($arr_m[$pn],$p_list))
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize'] = 5;
            $ajax_result['prize_name'] = '谢谢参与';
           mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1 where openid='{$_SESSION['arrow_openid']}'");
//             mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1 where openid='abc123123'");
            die(json_encode($ajax_result));
        }
        else
        {
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = 'ok';
            $ajax_result['prize_name'] = '';
            $ajax_result['prize'] = $arr_m[$pn];
            switch ($arr_m[$pn]) {
                case 1:
                    mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1,prize_name='饭盒',prize=1 where openid='{$_SESSION['arrow_openid']}'");
                    break;
                case 4:
                    mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1,prize_name='旅行箱',prize=4 where openid='{$_SESSION['arrow_openid']}'");
                    break;
                case 7:
                    mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1,prize_name='小夜灯',prize=7 where openid='{$_SESSION['arrow_openid']}'");
                    break;
                case 10:
                    mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1,prize_name='卷尺',prize=10 where openid='{$_SESSION['arrow_openid']}'");
                    break;
                default:
                    mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1 where openid='{$_SESSION['arrow_openid']}'");
                    break;
            }

            mysqli_query($db,"begin");
            mysqli_query($db,"update arrow_prize set quantity=quantity-1 where prize_num={$arr_m[$pn]}");
            mysqli_query($db,"commit");
           //mysqli_query($db,"update arrow set times=times-1,is_times=is_times+1 where openid='{$_SESSION['arrow_openid']}'");
            
            die(json_encode($ajax_result));
        }

	}

    if($act == 'add' )
    {
       mysqli_query($db,"update arrow set times=times+1 where openid='{$_SESSION['arrow_openid']}'");
//         mysqli_query($db,"update arrow set times=times+1 where openid='abc123123'");
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = 'ok';
        die(json_encode($ajax_result));
    }


}



?>