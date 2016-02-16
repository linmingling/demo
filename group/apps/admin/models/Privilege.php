<?php
namespace Apps\Admin\Models;

class Privilege extends Base{
	
	
	public function lists(){
		$data = $this->di->get('group')->fetchAll("select * from admin_priv_detail",\Phalcon\Db::FETCH_ASSOC);
		foreach($data as $k){
			$list[$k['id']] = $k;
		}
		return $list ? $list : false;
	}
	
	
}

?>