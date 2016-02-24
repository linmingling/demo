<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	//提交数据
    $act = trim($_POST['act']);
    
    if($act == "submit"){
        
        $name = mysqli_real_escape_string($db, trim($_POST['name']));
		if(empty($name)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "姓名不能为空";
			die(json_encode($ajax_result));
		}
		$phone = mysqli_real_escape_string($db, trim($_POST['phone']));
		if(empty($phone)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "电话不能为空";
			die(json_encode($ajax_result));
		}
		$province = mysqli_real_escape_string($db, trim($_POST['province']));
		if(empty($province)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择省份";
		    die(json_encode($ajax_result));
		}
		$city = mysqli_real_escape_string($db, trim($_POST['city']));
		if(empty($city)){
		    $ajax_result['errcode'] = 1001;
		    $ajax_result['errmsg'] = "请选择城市";
		    die(json_encode($ajax_result));
		}
		$address = mysqli_real_escape_string($db, trim($_POST['address']));
		if(empty($address)){
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "请输入地址";
			die(json_encode($ajax_result));
		}
		
		$num_sql = "SELECT COUNT(*) from mnls_gq";
		$res = mysqli_query($db, $num_sql);
		$num_arr = array();
		while($num_row = $res->fetch_array()){
		    $num_arr = $num_row;
		}
		if(intval($num_arr[0]) >= 1649){
		    $ajax_result['errcode'] = 1000;
		    $ajax_result['errmsg'] = "对不起，报名人数已达上限！";
		    die(json_encode($ajax_result));
		}
		
    	$sql = "SELECT id from mnls_gq WHERE phone='".$phone."'";
    	$res = mysqli_query($db, $sql);
    	$arr = array();
    	while($row = $res->fetch_array()){
    	    $arr = $row;
    	}
		if($arr){
	        $ajax_result['errcode'] = 1000;
	        $ajax_result['errmsg'] = "对不起，您已经报过名了！";
	        die(json_encode($ajax_result));
		} else {
		    $sql = "INSERT INTO mnls_gq(name, phone, province, city, address, add_time) VALUES('".$name."','".$phone."','".$province."','".$city."','".$address."','".date('Y-m-d H:i:s')."')";
		    $url = mysqli_query($db, $sql);
		    if(!$url){
		        echo "<script>alert('系统繁忙，请退出重试！')</script>";exit;
		    }
		    $ajax_result['errcode'] = 0;
		    $ajax_result['errmsg'] = "恭喜你，报名成功！";
		    $ajax_result['num'] = 200 - intval($num_arr[0]) - 1;
    		die(json_encode($ajax_result));
		}
    }
    
    if($act == "list"){
        $num_sql = "SELECT COUNT(*) from mnls_gq";
        $res = mysqli_query($db, $num_sql);
        $num_arr = array();
        while($num_row = $res->fetch_array()){
            $num_arr = $num_row;
        }
        $num = 1649 - intval($num_arr[0]);
        $list_arr[0]['num'] = $num;
        
        $sql = "SELECT * from mnls_gq ORDER BY add_time DESC";
        $res = mysqli_query($db, $sql);
        $arr = array();
        while($row = $res->fetch_array()){
            $arr[] = $row;
        }
        if(!empty($arr)){
            foreach ($arr as $k => $key){
                $list_arr[$k]['id'] = $key['id'];
                $list_arr[$k]['name'] = substr_cut($key['name'], 1)."**";
                $list_arr[$k]['phone'] = substr($key['phone'], 0,5)."蒙娜丽莎".substr($key['phone'], -2);
            }
        } else {
            $list_arr[0]['id'] = '';
            $list_arr[0]['name'] = '';
            $list_arr[0]['phone'] ='';
        }
        $list_arr = !empty($list_arr) ? $list_arr : '';
        die(json_encode($list_arr));
    }
}

//匿名处理
function substr_cut($str_cut, $length){
    if (strlen($str_cut) > $length){
        for($i=0; $i < $length; $i++){
            if (ord($str_cut[$i]) > 128){
                $i;
            }
        }
        $str_cut = mb_substr($str_cut, 0, $i, 'utf-8');
    }
    return $str_cut;
}
?>