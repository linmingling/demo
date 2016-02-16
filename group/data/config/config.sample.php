<?php

return new \Phalcon\Config(array(
    'db' => array(
		'upin'	=>	array(
			'adapter'  => 'Mysql',
			'host'     => '121.40.146.108',
			'username' => 'test_user',
			'password' => 'test!@#',
			'dbname'   => 'upin',
			'charset'  => 'utf8',
		),
 		'group'	=>	array(
			'adapter'  => 'Mysql',
			'host'     => '121.40.146.108',
			'username' => 'test_user',
			'password' => 'test!@#',
			'dbname'   => 'group',
			'charset'  => 'utf8',
		),
/*
 		'group'	=>	array(
			'adapter'  => 'Mysql',
			'host'     => '115.29.163.48',
			'username' => 'group',
			'password' => 'qixi_0822!@#',
			'dbname'   => 'group',
			'charset'  => 'utf8',
		),
*/
    ),
    'application' => array(
		'apiHost' => '115.29.202.95',
		'apiPort' => '9050',
		'apiEncodeKey' => APP_PATH . '/data/pem/private_key.pem',
        'compiledPath' => APP_PATH . '/data/cache/',
        'baseUri'      => '/'
    ),
	'session' => array(
		'lifetime' => 3600,
		'domain' => 'yoju360.com',
		'cookiename' => 'ECS_ID',
		'path' => '/',
	),
	'cas' => array(
		'casHost'		=> 'sso.yoju360.net',
		'casContext'	=> '',
		'casPort'		=> 443,
		//'casDebugLog'	=> './cas.log',
		'casLogout'		=> true,
	),
	'crm_host' => 'http://crm-test.yoju360.com',
	'redis' => array(
		'prefix' => 'group_',
		'host' => 'localhost',
		'port' => 6379,
		'auth' => 'crm!@#',
		'persistent' => false
	),
	'pcHome' => 'http://www.yoju360.com', // pc商城地址
	'zxHome' => 'http://zx.yoju360.com', // 案例地址
	'payDomain' => 'http://pay.yoju360.com', // 支付地址
));
