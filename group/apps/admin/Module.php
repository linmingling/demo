<?php
namespace Apps\Admin;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

class Module implements ModuleDefinitionInterface{
	
    public function registerAutoloaders(DiInterface $di = null){
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Library\Com'         => APP_PATH.'/library/com/',
			'Library\Request'			=> APP_PATH.'/library/request/',
			'Library\Model'         => APP_PATH.'/library/model/',
        	'dflydev\util\antPathMatcher'      => APP_PATH.'/library/dflydev/util/antPathMatcher',
            'Apps\Admin\Controllers' => APP_PATH.'/apps/admin/controllers/',
            'Apps\Admin\Models'      => APP_PATH.'/apps/admin/models/',
        ));
        $loader->register();
    }

    public function registerServices(DiInterface $di){
        $di['view'] = function() {
            $view = new View();
            $view->setViewsDir(APP_PATH.'/apps/admin/views/');
			$view->registerEngines(array(
				".phtml" => function($view, $di) {
					$volt = new VoltEngine($view, $di);
					$volt->setOptions(array(
						"compiledPath" => APP_PATH."/data/cache/",
						"compiledExtension" => ".cpd",
						"compiledSeparator" => "_",
					));
					$compiler = $volt->getCompiler();
					
					$compiler->addFunction('strtotime', 'strtotime');
					$compiler->addFunction('hasPermission', function($tag){
						return \Library\Com\SecurityContext::hasPermission($tag);
					});
					
					return $volt;
				}
			));
			
            return $view;
        };
        
        $di->setShared('dispatcher', function() use($di) {
			
			$eventsManager = new EventsManager();
			
			// 访问不存在的页面则跳转到首页
			$eventsManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception){
				switch ($exception->getCode()) {
		            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
		            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
		            	echo "<script type='text/javascript'> alert('页面不存在，将跳转至管理后台首页'); window.location.href = '/admin/index'; </script>";
						die();
		        }
			});
			
			$dispatcher = new Dispatcher();
			$dispatcher->setEventsManager($eventsManager);
			return $dispatcher;
        });
    }
}
