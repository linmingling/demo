<?php
namespace Apps\Admin\Controllers;

class StationController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}
	
	public function advertAction(){
		$local = $this->session->get('admin_regions');
		
		if($this->request->isPost() == true){
			$input = file_get_contents('php://input','r'); $input = json_decode($input,true);
			if(!in_array($input['region'],$local)) die(json_encode(array('state'=>0,'msg'=>'您没有权限添加该地区的广告')));
			
			$sql = "insert into advert_source(`type`,`region`,`url`) values('".$input['type']."','".$input['region']."','".$input['url']."')";
			$res = $this->group->execute($sql);
			if($res){
				die(json_encode(array('state'=>1,'msg'=>'添加成功')));
			}
			die(json_encode(array('state'=>0,'msg'=>'添加失败')));
		}
		
		$E = new \Library\Model\Ext();
		
		$province = $E->regions(array('pid'=>1));
		$local_all = $E->regions();
		foreach($local as $k) $regions[$k] = $local_all['list'][$k];
		
		$list = $this->group->fetchAll("select * from advert_source where region in (".implode(",",$local).")",\Phalcon\Db::FETCH_ASSOC);
		
		$this->view->setVars(array('province'=>$province['list'],'regions'=>$regions,'list'=>$list));
	}
	
	public function advertdelAction(){
		$id = $this->dispatcher->getParam(0,'int');
		
		$local = $this->session->get('admin_regions');
		
		$region = $this->group->fetchColumn("select region from advert_source where id = $id");
		if(!in_array($region,$local)) die(json_encode(array('state'=>0,'msg'=>'您没有权限删除该地区的广告')));
		
		$res = $this->group->execute("delete from advert_source where id = $id");
		if($res){
			die(json_encode(array('state'=>1,'msg'=>'删除成功')));
		}
		die(json_encode(array('state'=>0,'msg'=>'删除失败')));
	}
	
	public function testAction(){
		$page = new \Library\Com\Page(32,10);
		$p = $page->show();
		print_r($p);
	}
}

?>