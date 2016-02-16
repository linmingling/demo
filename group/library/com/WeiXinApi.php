<?php
namespace Library\Com;

/**
 * 微信类
 * @author weilong
 *
 */

class WeiXinApi {
	private $token;
	private $appId;
	private $appSecret;
	private $api_url;
	private $session;
	
	public function __construct($session, $token, $appId, $appSecret) {
	    $this->session = $session;
		$this->token = $token;
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->api_url = "http://tao.jia360.com";
	}

	/**
	 * 获取基础access_token
	 *
	 */
	public function get_access_token(){
		$url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=access_token&token='.$this->token.'&appid='.$this->appId.'&appsecret='.$this->appSecret;
		$access_token = json_decode($this->curlGet($url));
		return $access_token;
	}

	/**
	 * 微信分享配置
	 *
	 */
	public function get_share(){
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    	$redirect_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=share&token='.$this->token.'&url='.urlencode($redirect_url);
		$signPackage = json_decode($this->curlGet($url), true);
		return $signPackage;
	}

	/**
	 * 微信现金红包
	 * @param unknown $hongbao_id 	红包ID
	 * @param unknown $openid		用户openid
	 * @param unknown $wechaname 	用户微信昵称
	 * @param unknown $type 	              参数返回格式  type=0  返回0=支付失败1=支付成功    type=1  返回json格式
	 * @return mixed
	 */
	public function get_hongbao($hongbao_id, $openid, $wechaname, $type){
		$hongbao_key = md5($this->token.$hongbao_id.$openid.'yatai_20150417');//请求密钥
		$hongbao_url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=hongbao&token='.$this->token.'&type='.$type.'&id='.$hongbao_id.'&openid='.$openid.'&key='.$hongbao_key.'&wechaname='.$wechaname;
		$is_hongbao = $this->curlGet($hongbao_url);
		return $is_hongbao;
	}

	/**
	 *	判断用户是否扫过带参数的二维码
	 * @param unknown $scene_id 二维码的场景ID
	 * @param unknown $openid   用户openid
	 * @return mixed
	 */
	public function get_is_qrcode($scene_id, $openid){
		$url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=is_qrcode&token='.$this->token.'&id='.$scene_id.'&openid='.$openid;
		$is_qrcode = $this->curlGet($url);
		return $is_qrcode;
	}

	/**
	 * 模板消息
	 * @param unknown $access_token    access_token（基础）
	 * @param unknown $data            发送的内容
	 * @return Ambigous <string, mixed>
	 */
	public function template_send($access_token, $data){
	    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$access_token;
	    $result = $this->curlPost($url, $data);
	    return $result;
	}
	
	/**
	 *	处理微信名称含emoji表情
	 * @param unknown $name 微信名称
	 */
	public function handle_emoji($name){

		$tmpStr = json_encode($name);
		$tmpStr = preg_replace("#\\\u(e|d)([0-9a-f]{3})#ie","",$tmpStr);
		$wechaname = json_decode($tmpStr);

		return $wechaname;
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

	function curlPost($url, $data){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		if (curl_errno($curl)) {
			return 'Errno'.curl_error($curl);
		}
		curl_close($curl);
		return $result;
	}

}

?>