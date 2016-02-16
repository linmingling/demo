<?php
namespace Library\Request;

class Handle{
	
	private $data;
	private $key;
	
	function __construct($key,$data){
		$this->key = $key;
		$this->data = $data;
	}
	
	public function check(){
		$data = $this->data;
		if(!is_array($data) || empty($data)){
			return false;
		}
		if(!isset($data['project']) || !$data['project']){
			return false;
		}
		if(strlen($data['project']) != 32){
			return false;
		}
		if(!isset($data['ip']) || !$data['ip']){
			return false;
		}
		if(strlen($data['ip']) > 15 || strlen($data['ip']) < 7){
			return false;
		}
		if(!isset($data['time']) || !$data['time']){
			return false;
		}
		if(strlen($data['time']) != 19){
			return false;
		}
		if(!isset($data['body']) || !$data['body']){
			return false;
		}
		return true;
	}
	
	public function encode(){
		$data = $this->data;
		$body = json_encode($data['body']);
		$location = json_encode($data['location']);
		$data['isLocation'] = (isset($data['location']) && strlen($location) > 0) ? strlen($location) : 0;
		$platform = json_encode($data['platform']);
		$data['isPlatform'] = (isset($data['platform']) && strlen($platform) > 0) ? strlen($platform) : 0;
		
		$result = pack("a1N1N1a4a32a15a19N1a".strlen($body),$data['isSign'],$data['isLocation'],$data['isPlatform'],$data['version'],$data['project'],$data['ip'],$data['time'],strlen($body),$body);
		
		//地理位置
		if($data['isLocation'] > 0){
			$result .= pack("a".$data['isLocation'],$location);
		}
		
		//设备信息
		if($data['isPlatform'] > 0){
			$result .= pack("a".$data['isPlatform'],$platform);
		}
		
		//签名
		if($data['isSign'] == 'Y'){
			openssl_sign($data['ip'].$data['time'].$body, $sign, $this->key, OPENSSL_ALGO_SHA256);
			$result .= pack("N1a".strlen($sign),strlen($sign),$sign);
		}
		$result = pack("N1",strlen($result)).$result;
		return $result;
	}
	
	public function decode(){
		$data = $this->data;

		$result = unpack("N1length/a1isSign/N1isLocation/N1isPlatform/a4version/a32project/a15ip/a19time/N1len",$data);
		if($result['length']+4 != strlen($data)) return false;
		
		$len = $result['len'];
		$tmp = unpack("a".$len."body",substr($data,87));
		$result['body'] = $tmp['body'];
		unset($result['length']); unset($result['len']); unset($tmp);
		
		$len = 87 + $len;
		if($result['isLocation'] > 0){
			$tmp = unpack("a".$result['isLocation']."location",substr($data,$len));
			$len = $len + $result['isLocation'];
			$result['location'] = $tmp['location'];
			unset($tmp); unset($result['isLocation']);
			$result['location'] = json_decode($result['location'],true);
		}
		
		if($result['isPlatform'] > 0){
			$tmp = unpack("a".$result['isPlatform']."platform",substr($data,$len));
			$len = $len + $result['isPlatform'];
			$result['platform'] = $tmp['platform'];
			unset($tmp); unset($result['isPlatform']);
			$result['platform'] = json_decode($result['platform'],true);
		}
		
		if($result['isSign'] == 'Y'){
			$tmp1 = unpack("N1len",substr($data,$len));
			$len = $len + 4;
			$tmp2 = unpack("a".$tmp1['len']."sign",substr($data,$len));
			$len = $len + $tmp1['len'];
			$result['sign'] = $tmp2['sign'];
			unset($tmp1); unset($tmp2);
		}
		
		$result['body'] = json_decode($result['body'],true);
		
		return $result;
	}
	
	public function verify($result){
		if($result['isSign'] == 0){
			return true;
		}
		
		$res = openssl_verify($result['ip'].$result['time'].json_encode($result['body']), $result['sign'], $this->key, "sha256WithRSAEncryption");
		
		return $res ? true : false;
	}
}

?>