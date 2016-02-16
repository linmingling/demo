<?php

use Phalcon\Db\Adapter\Pdo\Mysql;

$di = new Phalcon\Di\FactoryDefault();

$di->set('url', function() use($config){
    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    return $url;
});

$di->set('upin', function() use($config){
    return new Mysql($config->db->upin->toArray());
});

$di->set('group', function() use($config){
    return new Mysql($config->db->group->toArray());
});

$di->set('lanrain', function() use($config){
    return new Mysql($config->db->lanrain->toArray());
});
    
$di->set('modelsMetadata', function(){
    return new \Phalcon\Mvc\Model\Metadata\Memory();
});

$di->setShared('session', function() use($di,$config){
    //$session = new \Phalcon\Session\Adapter\Files();
	$session = new \Library\Com\Session();
	$session->setOptions(array(
		'dbs' => $di->get('upin'),
		'domain' => $config->session->domain,
		'path' => $config->session->path,
		'cookiename' => $config->session->cookiename,
		'lifetime' => $config->session->lifetime,
	));
    $session->start();
    return $session;
});

$di->setShared('cookies',function() {
	$cookies =new \Phalcon\Http\Response\Cookies();
	$cookies->useEncryption(false);
	return $cookies;
});

$di->set('cache', function() use ($config) {
	$frontCache = new \Phalcon\Cache\Frontend\Data(array(
		"lifetime" => 172800
	));
	return new \Phalcon\Cache\Backend\Redis($frontCache, array(
		'prefix' => $config->redis->prefix,
		'host' => $config->redis->host,
		'port' => $config->redis->port,
		'auth' => $config->redis->auth,
		'persistent' => $config->redis->persistent
	));
});
$di->set('redis', function() use ($config) {
	$redis = new \Redis();
	$redis->connect($config->redis->host, $config->redis->port);
	$redis->auth($config->redis->auth);
	return $redis;
});
$di->setShared('dispatcher', function(){
	$dispatcher = new \Phalcon\Mvc\Dispatcher();
	$dispatcher->setDefaultNamespace('Apps\Pc\Controllers');
	return $dispatcher;
});

$di->set('flash', function() {
    return new \Phalcon\Flash\Direct();
});


$di->set('config', $config, true);