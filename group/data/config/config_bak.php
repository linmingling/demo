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
    ),
    'application' => array(
		'apiHost' => '218.244.145.61',
		'apiPort' => '9050',
		//'apiHost' => '120.24.175.158',
		//'apiPort' => '9050',
		'apiEncodeKey' => APP_PATH . '/data/pem/private_key.pem',
        'compiledPath' => APP_PATH . '/data/cache/',
        'baseUri'      => '/'
    ),
	'session' => array(
		'lifetime' => 3600,
		'domain' => 'yoju360.com',
		//'domain' => '127.0.0.1',
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
));
