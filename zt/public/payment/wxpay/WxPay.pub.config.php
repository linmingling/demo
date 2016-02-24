<?php
/**
* 	配置账号信息
*/

class WxPayConf_pub
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
	const APPID = 'wxd43f7b5d8539e718';
	//受理商ID，身份标识
	const MCHID = '1274481501';
	//商户支付密钥Key。审核通过后，在微信发送的邮件中查看
	const KEY = 'godlbkdakhl5tf87r76oxriie3vy7pm7';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	const APPSECRET = 'a42b85c54c3e79b709023df894f42778';

	//=======【证书路径设置】=====================================
	//证书路径,注意应该填写绝对路径(微信支持过程不需要证书)
// 	const SSLCERT_PATH = '/includes/modules/payment/wxpay/cacert/apiclient_cert.pem';
// 	const SSLKEY_PATH = '/includes/modules/payment/wxpay/cacert/apiclient_key.pem';

	//=======【异步通知url设置】===================================
	//异步通知url，商户根据实际开发过程设定
	const NOTIFY_URL = 'http://zt.jia360.com/public/payment/wxpay/notify_url.php';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
}

?>