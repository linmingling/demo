<?php
namespace Library\Com;
class JSSDK {
  private $token;
  private $api_url;

  public function __construct() {
  	//优居生活服务号
  	$this->token = 'ubtaeo1422330200';
  	$this->api_url = 'http://tao.jia360.com';
  }

  //微信自定义分享
  public function getSignPackage() {
    	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    	$redirect_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=share&token='.$this->token.'&url='.urlencode($redirect_url);
		$signPackage = json_decode($this->curlGet($url));
		return (array)$signPackage;
  }

  function curlGet($url){
  	$ch = curl_init();
  	curl_setopt($ch, CURLOPT_URL, $url);
  	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	$temp = curl_exec($ch);
  	curl_close($ch);
  	return $temp;
  }
}

