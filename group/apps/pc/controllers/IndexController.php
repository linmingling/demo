<?php
namespace Apps\Pc\Controllers;

use Library\Com\Funs;

class IndexController extends ControllerBase {
	
	private $params = array();
	
	public function initialize(){
		$this->params =  $this->dispatcher->getParams();
	}

    public function indexAction(){
        header("location: http://" . $_SERVER['SERVER_NAME'] . "/exposition3/index");exit;
    }
	
	

}

?>