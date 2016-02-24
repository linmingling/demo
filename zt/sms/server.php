<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');

if($_POST){
	$act = trim($_POST['act']);
	
	if($act == "submit"){
		$phone = mysqli_real_escape_string($db, $_POST['phone']);
		if(empty($phone)){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "手机号码不能为空";
			die(json_encode($ajax_result));
		}
		$verify = mysqli_real_escape_string($db, $_POST['verify']);
		if(empty($verify)){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "验证码不能为空";
			die(json_encode($ajax_result));
		}
		$time = date('Y-m-d H:i:s', time());
		$strtotime = time();
		
		$sql = "SELECT * FROM sms WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
	    if($arr){
	        if($arr['state'] == 1){
	            $ajax_result['errcode'] = 1002;
	            $ajax_result['errmsg'] = "该号码已验证！";
	        } else if($arr['verify'] == $verify){
    	        if(time() - $arr['get_verify_strtotime'] > 60){
    		        $ajax_result['errcode'] = 1001;
    		        $ajax_result['errmsg'] = "验证码已失效，请重新获取！";
    		    } else {
    	            $sql = "UPDATE sms SET state=1,state_strtotime='".$strtotime."',state_time='".$time."' WHERE phone='".$phone."'";
    	            $url = mysqli_query($db, $sql);
    	            if($url){
    	                $ajax_result['errcode'] = 0;
    	                $ajax_result['errmsg'] = "验证成功";
    	            } else {
    	                $ajax_result['errcode'] = 1003;
    	                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
    	            }
    		    }
	        } else {
	            $ajax_result['errcode'] = 1004;
	            $ajax_result['errmsg'] = "验证码错误！";
	        }
	        die(json_encode($ajax_result));
		} else {
			$ajax_result['errcode'] = 1001;
			$ajax_result['errmsg'] = "验证的手机号码不存在！";
			die(json_encode($ajax_result));
		}
	}

	if($act == "getVerify"){

		$phone = mysqli_real_escape_string($db, $_POST['tel']);
		if(empty($phone)){
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "手机号码不能为空";
			die(json_encode($ajax_result));
		}
		$verify = rand(1000, 9999);//获取随机验证码
		$time = date('Y-m-d H:i:s', time());
		$strtotime = time();
		
		$sql = "SELECT * FROM sms WHERE phone='".$phone."'";
		$url = mysqli_query($db, $sql);
		$arr = array();
		while($row = $url->fetch_array()){
			$arr = $row;
		}
		if($arr){
		    if($arr['state'] == 1){
		        $ajax_result['errcode'] = 1002;
		        $ajax_result['errmsg'] = "该号码已验证！";
		    } else if(time() - $arr['get_verify_strtotime'] < 60){
		        $ajax_result['errcode'] = 1001;
		        $ajax_result['errmsg'] = "60秒内无法重新获取验证码！";
		    } else {
		        $sql = "UPDATE sms SET verify='".$verify."',get_verify_strtotime='".$strtotime."',get_verify_time='".$time."' WHERE phone='".$phone."'";
		        $url = mysqli_query($db, $sql);
		        if($url){
	                $ajax_result['errcode'] = 0;
	                $ajax_result['errmsg'] = "验证码已发送！";
	                $ajax_result['sendmsg'] = send_sms($phone, $verify);
	            } else {
	                $ajax_result['errcode'] = 1003;
	                $ajax_result['errmsg'] = "系统繁忙，请退出重试";
	            }
		    }
		    die(json_encode($ajax_result));
		} else {
			$sql = "INSERT INTO sms(phone, verify, state, get_verify_strtotime, get_verify_time, state_strtotime, state_time) VALUES('".$phone."','".$verify."','0','".$strtotime."','".$time."','','')";
			$url = mysqli_query($db, $sql);
			if($url){
				$ajax_result['errcode'] = 0;
				$ajax_result['errmsg'] = "验证码已发送！";
				$ajax_result['sendmsg'] = send_sms($phone, $verify);
			} else {
				$ajax_result['errcode'] = 1003;
				$ajax_result['errmsg'] = "系统繁忙，请退出重试";
			}
			die(json_encode($ajax_result));
		}
	}
}

function send_sms($phone, $verify){
    header("Content-Type: text/html; charset=UTF-8");
    $flag = 0;
    $params='';//要post的数据
    //以下信息自己填以下
    $argv = array(
        'name' => '3086533498@qq.com',     //必填参数。用户账号
        'pwd' => '966E0BD8F94BCED72E1052474E7C',     //必填参数。（web平台：基本资料中的接口密码）
        'content' => '【腾讯家居·优居网】您的短信验证码为：'.$verify.'（60秒内有效）',   //必填参数。发送内容（1-500 个汉字）UTF-8编码
        'mobile' => $phone,   //必填参数。手机号码。多个以英文逗号隔开
        'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
        'sign'=>'',    //必填参数。用户签名。
        'type'=>'pt',  //必填参数。固定值 pt
        'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
    );
    //print_r($argv);exit;
    //构造要post的字符串
    //echo $argv['content'];
    foreach ($argv as $key => $value) {
        if ($flag!=0) {
            $params .= "&";
            $flag = 1;
        }
        $params.= $key."="; $params.= urlencode($value);// urlencode($value);
        $flag = 1;
    }
    $url = "http://web.1xinxi.cn/asmx/smsservice.aspx?".$params; //提交的url地址
    $con= substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
    if($con == '0'){
       return "发送成功";
    } else {
       return "发送失败";
    }
}
?>