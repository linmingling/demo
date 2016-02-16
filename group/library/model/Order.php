<?php
namespace Library\Model;

class Order extends Base{
	
    public function initialize(){
        parent::initialize();
    }
	
	public function info($params){
		$info = $this->api("Order.info",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function channel($params = null){
		$info = $this->api("Order.channel",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
	public function cancel($params){
		$info = $this->api("Order.cancel",$params);
		if($info['state'] == 1000) return $info['data'];
		return false;
	}
	
}

?>