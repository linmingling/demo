<?php
// 声明  include 目录常量
define( 'DIR_WEBSOCKET', dirname(__FILE__) );

require( DIR_WEBSOCKET. '/config.php' );
require( DIR_WEBSOCKET. '/function.php' );
require( DIR_WEBSOCKET. '/class/class_websocket.php' );

if ( !add_lock( 'lock' ) ) {
	//服务已开启
	die('Running');
}

// 屏蔽错误代码
// error_reporting(0);

// 设置超时时间
ignore_user_abort( true );
set_time_limit( 0 );

// 修改内存
ini_set( 'memory_limit', WEBSOCKET_MEMORY );


$class_websocket = new class_websocket( WEBSOCKET_HOST, WEBSOCKET_PORT );	//地址、端口
$class_websocket->key = WEBSOCKET_KEY;
$class_websocket->domain = WEBSOCKET_DOMAIN;

$class_websocket->function['add'] = 'add_socket_call';
$class_websocket->function['get'] = 'get_socket_call';
$class_websocket->function['close'] = 'close_socket_call';

$class_websocket->run();
echo socket_strerror( $class_websocket->error() );


/**
*	添加的时候
*
*	回调函数请勿直接使用
**/
function add_socket_call( $accept, $index, $class ) {

	// 自动关闭 90 秒没有动作的
	$class->time[$index] = time();
	$class->bind[$index]['ip'] = $class->ip( $accept );

	// 关闭过久没响应的
	if ( rand( 0,1000 ) ) {
		//return false;
	}
	foreach ( $class->accept as $k => $v ) {
		if ( $class->type[$k] !=  WEBSOCKET_TYPE_API ) {
			if ( empty( $class->time[$k] ) || ( time() - $class->time[$k] ) > 100 ) {
				$class->close( $v );
			}
		}
	}
}


/**
*	读取数据的时候
*
*	回调函数请勿直接使用
**/
function get_socket_call( $data, $accept, $index, $class ) {

	// 超过 1024 字节就结束
	if ( strlen( $data ) > 1024 ) {
		return false;
	}

	$data = string_turn_array( $data );


	// time 包
	if ( !empty( $data['time'] ) ) {
		$time = time();
		$class->time[$index] = $time;
		return $class->send( array( 'time' => $time ), $accept );
	}

	//建立通信
	if ( !empty( $data['name'])) {

		$name = htmlspecialchars( (string) $data['name'], ENT_QUOTES );

		// key已存在,请重新扫码
		foreach ( $class->bind as $k => $v ) {
			if ( !empty( $v['name'] ) && $v['name'] == $name ) {
				return  $class->send( array( 'msg' => 'true' ), $accept );
			}
		}

		if(substr($name, 0, 3) !== 'pc_'){
			//mobile连接上服务器
			foreach ( $class->bind as $k => $v ) {
				//mobile与pc匹配链接
				if ( !empty( $v['name'] ) && $v['name'] == 'pc_'.$name ) {
					$class->send( array('key' => 'true' ), $accept);//匹配成功，mobile显示“开始制作”按钮
					$class->send( array('show' => 'true' ), $class->accept[$k]);//匹配成功，PC响应
				}
			}

		} else {
			$class->send( array('qrcode' => 'true' ), $accept);	//pc连接上服务器，显示二维码
		}

		$class->bind[$index]['name'] = $name;//加入用户组

	}


	//放飞祝福
	if ( !empty($data['operation']) &&  !empty($data['code'])) {

		$chat = $data['operation'];//场景
		$text = $data['text'];//祝福语
		$code = $data['code'];//用户key

		return operation( array('operation'=> array('0' => $text, '1' => $chat)), $class, $code);
	}
}

/**
*	读取数据的时候
*
*	回调函数请勿直接使用
**/
function close_socket_call( $bind, $class) {

	//用户退出，$bind['name']当前用户
	if ( empty( $bind['name'] ) ) {
		return false;
	}
// 	$mobile_name = substr($bind['name'], 0, 3) !== 'pc_' ? $bind['name'] : substr($bind['name'], 3);

	//用户退出时，删除锁定文件
// 	$file_name = $mobile_name . '.txt';
// 	$file = DIR_WEBSOCKET.'/lock/'.$file_name;
// 	if (file_exists($file)) {
// 		unlink($file);
// 	}
// var_dump($class->bind);
// 	$class->pc_index = array_search('pc_'.$mobile_name, $class->name);

// 	if(!empty($class->accept[$class->pc_index])){
// 		$class->send( array(  'out' => 'true' ), $class->accept[$class->pc_index] );
// 	}
	//从用户组中删除
// 	unset($class->name[array_search($bind['name'], $class->name)]);
// 	unset($class->bind[array_search($bind['name'], $class->name)]);

}

/**
 * 操作交互
 * @param unknown $data		//指令
 * @param unknown $class	//
 * @param unknown $code		//用户key
 */
function operation( $data, $class, $code) {

	foreach ( $class->bind as $k => $v ) {
		if ( empty( $v['name'] ) || $class->type[$k] == WEBSOCKET_TYPE_API ) {
			continue;
		}
		if(substr($code, 0, 3) !== 'pc_' && $v['name'] == 'pc_'.$code){
			$class->send( $data, $class->accept[$k] );//向PC端发送指令
		}
		if(substr($code, 0, 3) == 'pc_' && $v['name'] == $code){
			$class->send( $data, $class->accept[$k] );//向mobile发送指令
		}
	}

}

?>

