<?php
namespace Apps\Admin\Controllers;

require_once APP_PATH . "/library/jasig/phpcas/CAS.php";

use Phalcon\Mvc\Controller;
use phpCAS;
use Library\Com\SecurityContext;
use dflydev\util\antPathMatcher\AntPathMatcher;

class ControllerBase extends Controller {
    
    public function initialize() {
    	// Full Hostname of your CAS Server
    	$cas_host = $this->config->cas['casHost'];
    	// Context of the CAS Server
    	$cas_context = $this->config->cas['casContext'];
    	// Port of your CAS server. Normally for a https server it's 443
    	$cas_port = $this->config->cas['casPort'];
    	
    	// Enable debugging
    	if (isset($this->config->cas['casDebugLog']))
    		phpCAS::setDebug($this->config->cas['casDebugLog']);
    	// Initialize phpCAS
    	phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, true);
    	
    	if (isset($this->config->cas['casCertPath']))
    		phpCAS::setCasServerCACert($this->config->cas['casCertPath']);
    	else 
    		phpCAS::setNoCasServerValidation();
    	
    	// handle incoming logout requests
    	if (isset($this->config->cas['casLogout']))
    		phpCAS::handleLogoutRequests(true);//phpCAS::handleLogoutRequests(true,array('sso.yoju360.net'));
    	
    	// force CAS authentication
    	phpCAS::forceAuthentication();
    	
    	// at this step, the user has been authenticated by the CAS server
    	// and the user's login name can be read with phpCAS::getUser().
    	// logout if desired
    	if (isset($_REQUEST['logout'])) {
    		phpCAS::logout(array('service'=>$_SERVER["HTTP_REFERER"]));
    	}
    	
    	$this->checkAccessPrivilege();
    }
	
    // Executed after every found action
    // public function afterExecuteRoute($dispatcher)
    private function checkAccessPrivilege() {
    	if (!SecurityContext::getCurrentUser()) // 未登录，不处理请求，交给ControllerBase处理
			return;
		
		$auth = SecurityContext::getAuthorizationData();
		
		// if no match, is public
		$matched_roles = NULL;
		$request_uri = $this->router->getRewriteUri();
		foreach ($auth as $url => $roles) {
			$test_uri = $request_uri;
			$antPathMatcher = new AntPathMatcher();
			if (substr($url,0, 4)==='http' || substr($url,0, 4)==='HTTP')
				$test_uri = "http://$_SERVER[HTTP_HOST]" . $request_uri; //补全地址用来匹配
			if ($url && strlen($url)>0 && $antPathMatcher->match($url, $test_uri)) {
				$matched_roles = $roles;
				break;
			}
		}
		
		if (isset($matched_roles)) {
			// get roles of the login user
		
			$roles = SecurityContext::getCurrentRoles();
			// login timeout
			if (!isset($roles))
				$this->accessDenied("http://$_SERVER[HTTP_HOST]" . $request_uri);
			
			$granted = false;
			foreach ($matched_roles as $needed_role) {
				foreach ($roles as $user_role) {
					if ($user_role === $needed_role['attribute']) {
						$granted = true;
						break;
					}
				}
				if ($granted==true)
					break;
			}
				
			if ($granted==false)
				$this->accessDenied("http://$_SERVER[HTTP_HOST]" . $request_uri);
		}
    }
    
    /**
     * 用户没有权限访问该URL
     */
    private function accessDenied($url) {
    	if ($this->request->isAjax()) {
    		die('您没有权限访问: '. $url);
    	} else {
    		$this->alertMsg('您没有权限访问: '. $url);
    	}
    }
    
	public function alertMsg($msg,$type = true){
		if($type == true){
			$str = "<script type='text/javascript'> alert('".$msg."'); window.location.href = history.go(-1); </script>";
		}elseif($type == false){
			$str = "<script type='text/javascript'> alert('".$msg."'); </script>";
		}
		echo $str;
		exit();
	}
	
    /**
     * 信息提示
     *
     * @access  public
     * @param   string
     * @param   string
     * @param   bool
     * @param   string
     * @return  void
     */
    public function _message($msg, $goto = '', $auto = TRUE, $fix = '')
    {
        if($goto == '')
        {
            $goto = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['HTTP_HOST'].'/admin/index';
        }
        else
        {
            $goto = strpos($goto, 'http') !== false ? $goto : '/admin/'.$goto;
        }
        $goto .= $fix;
        $this->view->setVar('sys_message', array('msg' => $msg, 'goto' => $goto, 'auto' => $auto));
        echo $this->view->render('index', 'sys_message');
        exit();
    }
}
