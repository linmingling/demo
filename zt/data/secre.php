<?php
/**
 * js加密、PHP解密类
 * @author Administrator
 *
 */
    if($_GET){
        $act = trim($_GET['act']);
        if($act){
    	   //加密换取密钥
    		$g = "20150313162800";
    		$p = "106025087133488299239129351247929016326438167258746469805890028339770628303789813787064911279666129";
    		$b = time().rand(1,9999);
    
    		$A = $_REQUEST['A'];
    		$B = bcpowmod($g, $b, $p);
    
    		$secret = md5(bcpowmod($A, $b, $p));//生成加密、解密密钥
    		session_start();
    		$_SESSION['secret'] = $secret;
    // 		file_put_contents('secret_log.txt',$A."---".$b."---".$secret);
    
    		echo '{"B":"' . $B .'"}';exit;
        }
    }
	//解密
	function decrypt($data){

		$iv='2015031358452691';	//16位字符串
		$key = $_SESSION['secret'];	//密钥

		$data = base64_decode($data);
		$ttt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);

// 		file_put_contents('decrypt_log.txt',$data."---".$key."---".$ttt);

		return $ttt;
	}

?>
