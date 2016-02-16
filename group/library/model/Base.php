<?php
namespace Library\Model;

class Base extends \Phalcon\Mvc\Model{
	
    public function initialize(){
		
    }
	
	public function loadCfg(){
		$config = $this->api("Ext.loadConfig");
		if($config['state'] != 1000){
			exit('全站配置载入失败');
		}
		return $config['data'];
	}
	
	public function setString($k){
		return $k ? (string)$k : "";
	}
	
	public function setInt($k){
		return $k ? (int)$k : 0;
	}
	
	public function setFloat($k){
		return $k ? (float)$k : 0;
	}
	
	public function api($method,$params = ''){
		$config = include APP_PATH."/data/config/config.php";
		$apiHost = $config->application->apiHost;
		$apiPort = $config->application->apiPort;
		$apiEncodeKey = $config->application->apiEncodeKey;
		
		$body = array('method'=>$method,'params'=>$params);
		$location = array('country'=>'中国','province'=>'广东','city'=>'广州');
		$platform = array(
			'device' => '',		//设备类型 如: phone,  pad,   pc	
			'os' => '',			//操作系统类型 如: android,  ios, window
			'version' => '',	//操作系统版本号
			'software' => ''
		);
		$data = array(
			'isSign' => 'Y',						//是否签名验证
			'location' => json_encode($location),	//地理位置信息(可为空)
			'platform' => json_encode($platform),	//设备信息(可为空)
			'version' => '0.1',						//接口版本号
			'project' => '0ec1ff9cbf825b47451e90932bfb6993', //项目id
			'ip' => '127.0.0.1',
			'time' => date('Y-m-d H:i:s'),
			'body' => json_encode($body)
		);
		
		$obj = new \Library\Request\Handle(file_get_contents($apiEncodeKey),$data);
		if(!$obj->check()){
			return json_encode(array('state'=>1001,'data'=>'签名验证失败'));
		}
		$in = $obj->encode();
		
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$result = socket_connect($socket, $apiHost, $apiPort);
		socket_write($socket, $in, strlen($in));
		$tmp = socket_read($socket, 4);
		$tmp1 = unpack('N1len',$tmp);
		$tmp2 = socket_read($socket,$tmp1['len'],PHP_NORMAL_READ);
		unset($tmp);unset($tmp1);
		socket_close($socket);
		return json_decode($tmp2,true);
	}
	
}


