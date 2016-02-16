<?php
namespace Library\Com;

class Session implements \Phalcon\Session\AdapterInterface {
	
	private $options = array('lifetime'=>3600);
	private $timebeg = 0;
	
	public function __construct(){
		
	}
	
    public function start(){
		$this->timebeg = time();
		$key = $this->options['cookiename'];
		if(!isset($_COOKIE[$key]) || !$_COOKIE[$key]){
			$this->options['sessionId'] = md5(uniqid(mt_rand(), true));
			$this->options['dbs']->execute("INSERT INTO ecs_sessions(sesskey, expiry, ip, data) VALUES ('".$this->options['sessionId']."','".time()."','', 'a:0:{}')");
			$value = $this->options['sessionId'].$this->randStr($this->options['sessionId']);
			setcookie($key, $value, time()+$this->options['lifetime'], $this->options['path'], $this->options['domain']);
			setcookie('SESS_ID', $value, time()+$this->options['lifetime'], $this->options['path'], $this->options['domain']);
			setcookie($key, $value, time()+$this->options['lifetime'], '/', 'yoju360.net');
			setcookie('SESS_ID', $value, time()+$this->options['lifetime'], '/', 'yoju360.net');
		}else{
			$ecs_id = substr($_COOKIE[$key],0,32);
			$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$ecs_id."'",\Phalcon\Db::FETCH_ASSOC);
			if($data && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
				$this->options['sessionId'] = $ecs_id;
			}else{
				$this->options['sessionId'] = md5(uniqid(mt_rand(), true));
				$this->options['dbs']->execute("INSERT INTO ecs_sessions(sesskey, expiry, ip, data) VALUES ('".$this->options['sessionId']."','".time()."','', 'a:0:{}')");
				$value = $this->options['sessionId'].$this->randStr($this->options['sessionId']);
				setcookie($key, $value, time()+$this->options['lifetime'], $this->options['path'], $this->options['domain']);
				setcookie('SESS_ID', $value, time()+$this->options['lifetime'], '/', 'yoju360.net');
				setcookie($key, $value, time()+$this->options['lifetime'], '/', 'yoju360.net');
			}
		}
    }
	
	private function updateCookieExprie(){
		$key = $this->options['cookiename'];
		$value = $this->options['sessionId'].$this->randStr($this->options['sessionId']);
		setcookie($key, $value, time()+$this->options['lifetime'], $this->options['path'], $this->options['domain']);
	}
	
	private function randStr($sessionId){
		return sprintf('%08x', crc32("yoju360" . $sessionId));
	}

    public function setOptions(array $options){
		$this->options = $options;
    } 


    public function getOptions(){
		return $this->options;
    }


    public function get($index,$defaultValue = null){
		$this->updateCookieExprie();
	
		$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$this->options['sessionId']."'",\Phalcon\Db::FETCH_ASSOC);
		$sql = "update ecs_sessions set expiry = ".time()." where sesskey = '".$this->options['sessionId']."'";
		$this->options['dbs']->execute($sql);
		if($index == "user_id") return $data['userid'];
		if($index == "user_name") return $data['user_name'];
		if($data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$info = unserialize($data['data']);
			return isset($info[$index]) ? $info[$index] : false;
		}elseif(!$data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$data = $this->options['dbs']->fetchColumn("select data from ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
			$info = unserialize($data);
			return ($data && isset($info[$index])) ? $info[$index] : false;
		}
		return false;
    }
	
    public function set($index, $value){
		$this->updateCookieExprie();
		
		$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$this->options['sessionId']."'",\Phalcon\Db::FETCH_ASSOC);
		if($this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$expiry = time();
		}else{
			$expiry = $data['expiry'];
		}
		$str = "";
		if($data['data']){
			$info = unserialize($data['data']);
			$info[$index] = $value;
			if($index == 'user_id') $info['userid'] = $value;
			$tmp = serialize($info);
			$str = strlen($tmp) >= 255 ? "" : $tmp;
			$this->options['dbs']->execute("replace into ecs_sessions_data(`sesskey`,`expiry`,`data`) values('".$this->options['sessionId']."','".$expiry."','".serialize($info)."')");
		}else{
			$data = $this->options['dbs']->fetchColumn("select data from ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
			$info = unserialize($data);
			$info[$index] = $value;
			if($index == 'user_id') $info['userid'] = $value;
			$this->options['dbs']->execute("update ecs_sessions_data set data = '".serialize($info)."' where sesskey = '".$this->options['sessionId']."'");
		}
		$sql = "update ecs_sessions set data = '".$str."',expiry = $expiry";
		if($index == 'user_id' && $value){
			$sql .= ",userid = '".$value."'";
		}elseif($index == 'user_name' && $value){
			$sql .= ",user_name = '".$value."'";
		}
		$this->options['dbs']->execute($sql." where sesskey = '".$this->options['sessionId']."'");
    }


    public function has($index){
		$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$this->options['sessionId']."'",\Phalcon\Db::FETCH_ASSOC);
		if(($index == 'user_id' || $index == 'userid') && $data['userid']) return true;
		if($index == 'user_name' && $data['user_name']) return true;
		
		$info = unserialize($data['data']);
		if($data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime'] && isset($info[$index]) && $info[$index]){
			return true;
		}elseif(!$data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$data = $this->options['dbs']->fetchColumn("select data from ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
			$info = unserialize($data);
			return ($data && isset($info[$index])) ? true : false;
		}
		return false;
    }


    public function remove($index){
		$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$this->options['sessionId']."'",\Phalcon\Db::FETCH_ASSOC);
		$info = unserialize($data['data']);
		$expiry = time();
		if($data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			if(isset($info[$index]) && $info[$index]){
				unset($info[$index]);
				$this->options['dbs']->execute("update ecs_sessions set data = '".serialize($info)."', expiry = $expiry where sesskey = '".$this->options['sessionId']."'");
			}
		}elseif(!$data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$data = $this->options['dbs']->fetchColumn("select data from ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
			$info = unserialize($data);
			if(isset($info[$index]) && $info[$index]){
				unset($info[$index]);
				$this->options['dbs']->execute("update ecs_sessions_data set data = '".serialize($info)."', expiry = $expiry where sesskey = '".$this->options['sessionId']."'");
			}
		}
    }

	public function getData(){
		$data = $this->options['dbs']->fetchOne("select * from ecs_sessions where sesskey = '".$this->options['sessionId']."'",\Phalcon\Db::FETCH_ASSOC);
		$info = unserialize($data['data']);	
		if($data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			return $info;
		}elseif(!$data['data'] && $this->timebeg - $data['expiry'] < $this->options['lifetime']){
			$data = $this->options['dbs']->fetchColumn("select data from ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
			return unserialize($data);
		}
	}

    public function getId(){
		return $this->options['sessionId'];
    }

    public function isStarted(){
		if($this->options['sessionId']){
			return true;
		}
		return false;
    }

    public function destroy($removeData = NULL){
		$this->options['dbs']->execute("delete from  ecs_sessions where sesskey = '".$this->options['sessionId']."'");
		$this->options['dbs']->execute("delete from  ecs_sessions_data where sesskey = '".$this->options['sessionId']."'");
		
		$this->options['dbs']->execute("delete from  ecs_sessions where expiry + 3600 < ".time());
		$this->options['dbs']->execute("delete from  ecs_sessions_data where expiry + 3600 < ".time());
		
		setcookie("ECS_ID", "", time()-3600);
		return true;
    }
	
    public function regenerateId($deleteOldSession = NULL) {
    	
    }
    
    public function setName($name=NULL) {
    	
    }
    
    public function getName($name) {
    	
    }
    
}

?>
