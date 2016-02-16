<?php
namespace Library\Model;

class User extends Base{
	
    public function initialize(){
        parent::initialize();
    }
	
	public function info($params){
		$info = $this->api("User.info",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function address($params){
		$info = $this->api("User.address",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function register($params){
		$info = $this->api("User.register",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function login($params){
		$info = $this->api("User.login",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
}

?>