<?php
namespace Apps\Phone\Controllers;

class LoginController extends ControllerBase {
	/**
	 * 根据pay.yoju360.com回传数据作本地登录。
	 * 如果当前域名是yoju360.net。XXX 
	 */
	public function loginAction(){
		if ($_SERVER['SERVER_NAME']!='group.yoju360.net')
			die();
		
		header('Content-Type: text/javascript; charset=utf8');
		header('Access-Control-Allow-Origin: '. $this->config->payDomain);
		header('Access-Control-Max-Age: 3628800');
		header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
			
		if($this->request->isPost() == true){
			$post = $this->request->getPost();
			$data = json_decode($post['data'], true);
			$callback = $data['callback'];
			$backurl = $data['backurl'];
		} else {
			$data = json_decode($_GET['data'], true);
			$callback = $_GET['callback'];
			$backurl = $_GET['backurl'];
		}
		
		$this->session->set('userid',$data['user_id']);
		$this->session->set('user_id',$data['user_id']);
		$this->session->set('user_name',$data['user_name']);
		$this->session->set('user_phone',$data['user_phone']);
		$this->session->set('user_email',$data['user_email']);
		$this->session->set('user_headpic',$data['user_headpic']);
		echo $callback.'("'. $backurl .'");';
		die();
	}
	
	public function logoutAction(){
		$this->session->destroy();
		$backUrl = $_GET['backurl']?$_GET['backurl']:'http://'.$_SERVER['HTTP_HOST'];
		header("Location:".$backUrl);
		die();
	}
}

?>