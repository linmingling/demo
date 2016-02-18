<?php
class JSSDK {
  private $token;
  private $api_url;
  private $appId;
  private $appSecret;
  
  public function __construct() {
  	//聚业美家 服务号
  	$this->token = 'otelzf1453168233';
  	$this->api_url = 'http://tao.jia360.com';
  	$this->appId = 'wx7b10ec8e83af10e8';
  	$this->appSecret = 'c0ab851f12b4f7fc32a4ea883edae24a';
  }

  //微信自定义分享
  public function getSignPackage() {
    	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    	$redirect_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url = $this->api_url.'/index.php?g=API&m=WeixinApi&a=share&token='.$this->token.'&url='.urlencode($redirect_url);
		$signPackage = json_decode($this->curlGet($url));
		return (array)$signPackage;
  }
  
  /**
   * 网页授权拉取用户信息
   */
  public function getOauth($scope_type){
      if($scope_type == 1){
          $scope = 'snsapi_base';//静默授权，用户无感知，只能获取openid
      } else {
          $scope = 'snsapi_userinfo';
      }
      $url = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
      $codeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appId.'&redirect_uri='.$url.'&response_type=code&scope='.$scope.'&state=123#wechat_redirect';
      if (empty($_GET['code'])){
          echo "<script language=\"javascript\">location.href=\"$codeUrl\"</script>";exit;
      }
      $code = $_GET['code'];
      if($code){
			$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appId.'&secret='.$this->appSecret.'&code='.$code.'&grant_type=authorization_code';
			$json = json_decode($this->curlGet($url));
			$access_token  = $json->access_token;	//网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
			$refresh_token = $json->refresh_token;	//用户刷新access_token
			$openid = $json->openid;
			if($scope_type == 1){
				return $openid;
			} else {
				if($access_token){
					//获取用户基本信息
                    $user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
                    $user_info = json_decode($this->curlGet($user_url));
                    if($user_info){
                    	$user['openid'] 	= $user_info->openid;		//用户唯一id
                    	$user['wechaname'] 	= $user_info->nickname;		//微信名(昵称)
                    	$user['sex'] 		= $user_info->sex;			//性别
                    	$user['country'] 	= $user_info->country;		//用户所在国家
                    	$user['province'] 	= $user_info->province;		//用户所在省份
                    	$user['city'] 		= $user_info->city;			//用户所在城市
                    	$user['headimgurl'] = $user_info->headimgurl;	//用户头像
                    	$user['unionid']    = $user_info->unionid;
                    }
                    return $user;
				}
			}
	  }
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

