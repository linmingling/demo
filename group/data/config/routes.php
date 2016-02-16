<?php

$di->set('router', function() use($application) {
    $router = new Phalcon\Mvc\Router();
	
	foreach($application->getModules() as $key => $module) {
		$namespace = str_replace('Module','Controllers', $module["className"]);
		$router->add('/'.$key.'/:params', array(
			'namespace' => $namespace,
			'module' => $key,
			'controller' => 'index',
			'action' => 'index',
			'params' => 1
		))->setName($key);
		$router->add('/'.$key.'/:controller/:params', array(
			'namespace' => $namespace,
			'module' => $key,
			'controller' => 1,
			'action' => 'index',
			'params' => 2
		));
		$router->add('/'.$key.'/:controller/:action/:params', array(
			'namespace' => $namespace,
			'module' => $key,
			'controller' => 1,
			'action' => 2,
			'params' => 3
		));
	}
	$router->setDefaultModule('pc');
	$router->setDefaultNamespace('Apps\Pc\Controllers');	
	
	
	$action_arr = array('qxzj');//将活动加入该数组，将去除移动端访问PC端时自动跳转到移动端的设置
	$path_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	foreach ($action_arr as $k => $key){
    	if(!strstr($path_url, $key)){
        	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        	$uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
        	if(($ua == '' || preg_match($uachar, $ua))){
        		$router->setDefaultModule('phone');
        		$router->setDefaultNamespace('Apps\Phone\Controllers');
        	}
    	}
	}
	
    return $router;
});

