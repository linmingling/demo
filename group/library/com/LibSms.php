<?php
/**
 * 短信接口类
 */
namespace Library\Com;

class LibSms{
	/**
	 * 发送短信内部接口
	 * 
	 * @param $apiUrl string 内部短信网关地址，如http://sms.yoju360.net/api/send.do
	 * @param $appName string 发送短信的应用名，如crm
	 * @param $apiKey string 短信后台颁发的接口密钥
	 * @param $projectName string 发送短信的项目，如'全民家居购'，用于统计项目的短信消费
	 * @param $phone string 手机号码
	 * @param $content string 短信内容
	 * @param $stime int 定时发送时间，可选参数  时间戳格式
	 * @param $isPromo int 是否营销短信，营销短信需要带"回T退订"，可选参数，默认为非营销短信，如验证码
	 * @return 
	 * 		false: 发送失败，
	 * 		array: 发送成功，如果是定时短信，则会有一个smsRecordId返回：$result['result']['smsRecordId']，可用于取消定时短信发送，见cancelTimedSms方法
	 */
	public static function sendSms($apiUrl, $appName, $apiKey, $projectName, $phone, $content, $stime = 0, $isPromo = 0) {
		$params=''; //要post的数据
		$tosign=''; //要签名的内容
		$argv = array(
				'appName' => $appName,//必填参数
				'apiKey' => $apiKey,//必填参数。
				'projectName' => $projectName,//必填参数。
				'mobile' => $phone,//必填参数。手机号码。多个以英文逗号隔开
				'content' => $content, //必填参数。发送内容
				'timestamp' => date("Y-m-d H:i:s"),
				'isPromo' => $isPromo,
		);
		if ($stime) {
			$argv['time'] = date("Y-m-d H:i:s", $stime); 
		}
		
		ksort($argv);
		
		//构造要post的字符串
		foreach ($argv as $key => $value) {
			$params.= $key."="; 
			$params.= urlencode($value);
			$params.= "&";
			$tosign.= $value;
		}
		$apiSign = hash_hmac('md5',$tosign, $apiKey);
		$params.='sign='. $apiSign;
		
		$resp = file_get_contents($apiUrl . '?' . $params);
		$result = json_decode($resp,true);
		if ($result['code']!=0) {
			return false;
		} else {
			return $result;
		}
	}
	
	/**
	 * 取消定时短信发送
	 * 
	 * @param string $apiUrl  内部短信网关地址，如http://sms.yoju360.net/api/cancelTimedSms.do
	 * @param $appName string 发送短信的应用名，如crm
	 * @param $apiKey string 短信后台颁发的接口密钥
	 * @param $smsRecordId int 发送定时短信时返回的回执smsRecordId
	 */
	public static function cancelTimedSms($apiUrl, $appName, $apiKey, $smsRecordId) {
		$params=''; //要post的数据
		$tosign=''; //要签名的内容
		$argv = array(
				'appName' => $appName,//必填参数
				'apiKey' => $apiKey,//必填参数。
				'smsRecordId' => $smsRecordId,//必填参数。
				'timestamp' => date("Y-m-d H:i:s")
		);
		ksort($argv);
		//构造要post的字符串
		foreach ($argv as $key => $value) {
			$params.= $key."=";
			$params.= urlencode($value);
			$params.= "&";
			$tosign.= $value;
		}
		$apiSign = hash_hmac('md5',$tosign, $apiKey);
		$params.='sign='. $apiSign;
		
		$resp = file_get_contents($apiUrl . '?' . $params);
		$result = json_decode($resp,true);
		if ($result['code']!=0) {
			return false;
		} else {
			return $result;
		}
	}
}

