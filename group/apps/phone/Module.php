<?php
namespace Apps\Phone;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface{
	
    public function registerAutoloaders(DiInterface $di = null){
        $loader = new Loader();
        $loader->registerNamespaces(array(
			'Library\Com'				=> APP_PATH.'/library/com/',
			'Library\Request'			=> APP_PATH.'/library/request/',
			'Library\Model'				=> APP_PATH.'/library/model/',
            'Apps\Phone\Controllers' 	=> APP_PATH.'/apps/phone/controllers/',
            'Apps\Phone\Models' 		=> APP_PATH.'/apps/phone/models/',
        ));
        $loader->register();
    }

    public function registerServices(DiInterface $di){
        $di['view'] = function() {
            $view = new View();
            $view->setViewsDir(APP_PATH.'/apps/phone/views/');
			$view->registerEngines(array(
				".phtml" => function($view, $di) {
					$volt = new VoltEngine($view, $di);
 					$volt->setOptions(array(
						"compiledPath" => APP_PATH."/data/cache/",
						"compiledExtension" => ".cpd",
						"compiledSeparator" => "_",
					));
					return $volt;
				}
			));
            return $view;
        };
    }
}
