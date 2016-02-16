<?php
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

use Phalcon\Mvc\Application;

error_reporting(E_ALL);

define('APP_PATH', realpath('..'));

if(file_exists(APP_PATH."/data/config/config.php")){
	$config = include APP_PATH."/data/config/config.php";
}else{
	exit("配置文件丢失");
}


try {
    require APP_PATH.'/data/config/services.php';

    $application = new Application($di);

    require APP_PATH.'/data/config/modules.php';

    require APP_PATH.'/data/config/routes.php';

    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo $e->getMessage();
}
