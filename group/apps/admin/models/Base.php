<?php
namespace Apps\Admin\Models;

class Base extends \Phalcon\Mvc\Model{
	
	public function setString($k){
		return $k ? (string)$k : "";
	}
	
	public function setInt($k){
		return $k ? (int)$k : 0;
	}
	
	public function setFloat($k){
		return $k ? (float)$k : 0;
	}
	
}

?>