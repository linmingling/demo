<?php
namespace Apps\Admin\Controllers;

class UserController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
		
		$this->view->ActionName = $this->dispatcher->getActionName();
		$this->view->ControllerName = $this->dispatcher->getControllerName();
	}
	
	public function listAction(){
		$res = $this->group->fetchAll("select * from admin_priv_list",\Phalcon\Db::FETCH_ASSOC);
		$this->view->setVars(array('list'=>$res));
	}
	
	public function modifyAction(){
		$id = $this->dispatcher->getParam(0,"int");
		
		if($this->request->isPost() == true){
			$username = $this->request->get("username");
			$desc = $this->request->get("desc");
			$checkedPrivs = $this->request->get("optionsCheck");
			$checkedPrivs = json_encode($checkedPrivs);
			$sql = "update admin_priv_list set `username` = '".$username."',`privs` = '".$checkedPrivs."',`desc` = '".$desc."' where id=" .$id;
			$this->group->execute($sql);
			$this->response->redirect('/admin/user/list');
			$this->view->disable();
		} else {
			$data = $this->group->fetchOne("select * from admin_priv_list where id = $id",\Phalcon\Db::FETCH_ASSOC);
			$data['privs'] = json_decode($data['privs'], true);
			$this->view->data = $data;
			$this->view->uid = $id;
			$priv = new \Apps\Admin\Models\Privilege();
			$this->view->allPrivs = $priv->lists();
			$this->view->pick("user/add");
		}
	}
	
	public function addAction(){
		
		if($this->request->isPost() == true){
			$username = $this->request->get("username");
			$desc = $this->request->get("desc");
			$checkedPrivs = $this->request->get("optionsCheck");
			$checkedPrivs = json_encode($checkedPrivs);
			
			$sql = "insert into admin_priv_list(`username`,`privs`,`desc`) values('".$username."','".$checkedPrivs."','".$desc."')";
			$this->group->execute($sql);
			$this->response->redirect('/admin/user/list');
			$this->view->disable();
		} else {
			$priv = new \Apps\Admin\Models\Privilege();
			$this->view->allPrivs = $priv->lists();
		}
	}
	
	public function deleteAction(){
		$id = $this->dispatcher->getParam(0,"int");
		$sql = "delete from admin_priv_list where id = ".$id;
		$this->group->execute($sql);
		$this->response->redirect('/admin/user/list');
		$this->view->disable();
	}
	
	public function addPrivAction()
	{
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			$name = $post['name'];
			$value = $post['value'];
			$desc = $post['desc'];
			$group_name = $post['group_name'];
// 			var_dump($post);die;
			
			if(empty($name) || empty($value) || empty($desc))
			{
				$ajax_result['errcode'] = 1001;
				$ajax_result['errmsg'] = "请填写完整信息";
				die(json_encode($ajax_result));
			}
				
			$sql = "insert into admin_priv_detail(`group_name`,`name`,`value`,`desc`) values('".$group_name."','".$name."','".$value."','".$desc."')";
			$this->group->execute($sql);
			
			$ajax_result['errcode'] = 0;
			$ajax_result['errmsg'] = "ok";
			die(json_encode($ajax_result));
		} else {
			$ajax_result['errcode'] = 1002;
			$ajax_result['errmsg'] = "非法操作";
			die(json_encode($ajax_result));
		}
	}
	
	public function delPrivAction()
	{
		$id = $this->dispatcher->getParam(0,"int");
		
		if($this->request->isPost() == true)
		{
			$checkedPrivs = $this->request->get("optionsCheck");
			$count = count($checkedPrivs);
			if(empty($checkedPrivs))
			{
				header("Location:/admin/user/modify/" . $id);
			}
			$privStr = implode(',', $checkedPrivs);
			$sql = "delete from  admin_priv_detail where id in (" . $privStr . ") limit " . $count;
			$this->group->execute($sql);
			header("Location:/admin/user/modify/" . $id);
			$this->view->disable();
		} 
		
		
	}
}

?>