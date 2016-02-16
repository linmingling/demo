<?php
namespace Library\Com;

class Funs{
	
	public static function setString($k){
		return $k ? (string)$k : "";
	}
	
	public static function setInt($k){
		return $k ? (int)$k : 0;
	}
	
	public static function setFloat($k){
		return $k ? (float)$k : 0;
	}
	
	/**
	 * 二维数组排序
	 * @param unknown $arr     数组
	 * @param unknown $keys    要排序的键值
	 * @param string $type     排序类型
	 * @return multitype:unknown
	 */
	public static function array_sort($arr, $keys, $type = 'asc') {
	    $keysvalue = $new_array = array();
	    foreach ($arr as $k => $v) {
	        $keysvalue[$k] = $v[$keys];
	    }
	    if ($type == 'asc') {
	        asort($keysvalue);
	    } else {
	        arsort($keysvalue);
	    }
	    reset($keysvalue);
	    foreach ($keysvalue as $k => $v) {
	        $new_array[$k] = $arr[$k];
	    }
	    return $new_array;
	}
	
	/**
	 * 导出XLS
	 * @param unknown $filename
	 * @param unknown $content
	 */
	public static function exportExcel($filename, $content){
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    header("Content-Type: application/vnd.ms-execl");
	    header("Content-Type: application/force-download");
	    header("Content-Type: application/download");
	    header("Content-Disposition: attachment; filename=".$filename);
	    header("Content-Transfer-Encoding: binary");
	    header("Pragma: no-cache");
	    header("Expires: 0");
	    echo $content;
	}
	
	/**
	 * 屏蔽电话号码中间四位
	 * @param unknown $phone
	 * @return mixed
	 */
	public static function hidtel($phone){
	    $IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
	    if($IsWhat == 1){
	        return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);
	    }else{
	        return  preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
	    }
	}
	
	public static function curlGet($url){
		$ch = curl_init();
		$header[] = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		curl_close($ch);
		return $temp;
	}

	public static function curlPOST($url, $data){
		$ch = curl_init();
		$header[] = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
        curl_close($ch);
		return $temp;
	}
	
	public static function sign($data){
		$config = include APP_PATH."/data/config/config.php";
		$key = file_get_contents($config->application->apiEncodeKey);
		openssl_sign($data, $sign, $key, OPENSSL_ALGO_SHA256);
		return base64_encode($sign);
	}
	
	public static function verify($data, $sign){
		$key = file_get_contents(APP_PATH."/data/pem/public_key.pem");
		return openssl_verify($data, base64_decode($sign), $key, "sha256WithRSAEncryption");
	}
	
	public static function phoneLocation($phone){
		if($phone){
			$url = "http://apis.juhe.cn/mobile/get?phone=".$phone."&key=f558cffaf40e02cf0de15ff9a477c53a";
			
			$ch = curl_init();
			$header[] = "Accept-Charset: utf-8";
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$info = curl_exec($ch);
			curl_close($ch);			
			
			
			$tmp = json_decode($info,true);
			if($info && $tmp['resultcode'] == "200" && $tmp['result']){
				return array(
					'province' => isset($tmp['result']['province']) ? $tmp['result']['province'] : "",
					'city' => isset($tmp['result']['city']) ? $tmp['result']['city'] : "",
					'areacode' => isset($tmp['result']['areacode']) ? $tmp['result']['areacode'] : "",
					'zip' => isset($tmp['result']['zip']) ? $tmp['result']['zip'] : "",
					'company' => isset($tmp['result']['company']) ? $tmp['result']['company'] : "",
					'card' => isset($tmp['result']['card']) ? $tmp['result']['card'] : ""
				);
			}
		}
		return false;
	}
	
}

