<?php
defined('DIR_WEBSOCKET') || die( 'Error' );

// 一次性最大处理数据 10M,最大接收缓冲区
define( 'WEBSOCKET_MAX', 1024 * 1024 * 10 );

// 最大使用内存
define( 'WEBSOCKET_MEMORY', '1024M' );

// 发送最大字节数 5M
define( 'WEBSOCKET_SNDBUF', 1024 * 1024 * 5 );

// 最大同时在线数
define( 'WEBSOCKET_ONLINE', 1024 * 1000 );

// HOST
define( 'WEBSOCKET_HOST', '115.29.187.235' );

// PORT
define( 'WEBSOCKET_PORT', 8087 );

// 允许的域名
define( 'WEBSOCKET_DOMAIN', '' );

// api 的key
define( 'WEBSOCKET_KEY', 'Q#WHJGIOU*(&_}{:?PO-78SE#$%^&*()O' );

//域名
define( 'SITE_URL', 'http://zt.jia360.com' );

//PC端WS_STATIC_URL
define( 'PC_URL', SITE_URL.'/multi-screen/flq/static' );

//二维码URL
define( 'QRCODE_URL', SITE_URL.'/multi-screen/flq/mobile/index.php?key=' );

// 管理员密码
define( 'ADMIN_PASS', '123456' );

?>