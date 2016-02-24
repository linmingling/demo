<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
<?php
header("Content-Type: text/html;charset=utf-8");
$rootPath = dirname(dirname(__FILE__));
require($rootPath.'/data/jssdk.php');
	
$jssdk = new JSSDK();
$signPackage = $jssdk->GetSignPackage();

$agent = $_SERVER['HTTP_USER_AGENT'];
    if(!strpos($agent,"MicroMessenger")){
        echo "<script>alert('请在微信浏览器中打开！')</script>";exit;
    }

	$openId = $_SESSION['openid'];
	if(empty($openId)){
		$userinfo = $jssdk->getOauth();
		$_SESSION['openid']		= $userinfo['openid'];
		$_SESSION['nickname']	= $userinfo['wechaname'];
		$_SESSION['headimgurl'] = $userinfo['headimgurl'];
	}

function curl_post($url,$data)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);//发送一个常规的Post请求
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Post提交的数据包
	$rv = curl_exec($curl);//输出内容
	curl_close($curl);
	return $rv;
}

$data['id'] = 12;
$data['token'] = 'otelzf1453168233';
$data['openid'] = $userinfo['openid'];
$data['wechaname'] = $userinfo['wechaname'];
$data['key'] = '5b4e5c7421f67bb103019c058b7a42e3';
$result = curl_post('http://tao.jia360.com/index.php?g=API&m=WeixinApi&a=hongbao',$data);
$result = json_decode($result);
$result = (array)$result; 

echo '[';
var_dump( $data );
echo ']';
print_r($result);

/* echo '<br/>-'.$data['openid'];
echo '<br/>-'.$data['wechaname'];	
echo '<br/>-';
print_r($userinfo); */
	