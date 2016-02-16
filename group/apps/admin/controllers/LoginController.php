<?php
namespace Apps\Admin\Controllers;

class LoginController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}
	
	/**
	 * 退出登录,
	 * 退出登录由单点登录CAS完成：/admin/login/logout?logout=
	 * 带上参数?logout表示要退出登录，见ControllerBase.php
	 */
	public function logoutAction(){
	    $this->session->destroy();
	}
}

?>