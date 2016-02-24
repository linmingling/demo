<?php
/**
 * 	配置账号信息
 */

define('ROOT_PATH', dirname(__FILE__));
define('SITE_URL', 'http://zt.jia360.com');
header("Content-Type: text/html;charset=utf-8");
class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wx7b10ec8e83af10e8';
	//受理商ID，身份标识
	const MCHID = '1309904601';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'a054ec9b6c59e8fefc0cf6a3e526b152';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = 'c0ab851f12b4f7fc32a4ea883edae24a';

	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
	const JS_API_CALL_URL = 'http://zt.jia360.com/demo/js_api_call.php';

	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径

	//const SSLCERT_PATH =   'E:wamp/www/yao/pem/apiclient_cert.pem';
	//const SSLKEY_PATH =   'E:wamp/www/yao/pem/apiclient_key.pem';
	//const SSLCA_PATH =  'E:wamp/www/yao/pem/rootca.pem';
	const SSLCERT_PATH =   '/data/zt_produce/yao/pem/apiclient_cert.pem';
	const SSLKEY_PATH =   '/data/zt_produce/yao/pem/apiclient_key.pem';
	const SSLCA_PATH =  '/data/zt_produce/yao/pem/rootca.pem';	
	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://zt.jia360.com/demo/notify_url.php';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}

	function curlGet($url){
		$ch = curl_init();
		//$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}
	
	function getAccessToken($appid,$appsecret){ 
		$url_get='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
		$json=json_decode(curlGet($url_get));
		if( isset($json->access_token)) {
			return $json->access_token;
		} else {
			return false;
		}
	}	
?>