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

		// key已存在
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
					$class->send( array('key' => 'true' ), $accept);//匹配成功，mobile显示“我要帮忙”按钮
					$class->send( array('show' => 'true' ), $class->accept[$k]);//匹配成功，pc执行下一页
				}
			}

		} else {
			$class->send( array('qrcode' => 'true' ), $accept);//pc连接上服务器，显示二维码
		}

		$class->bind[$index]['name'] = $name;//加入用户组

	}


	//场景确认后，切换至场景布局页
	if ( !empty($data['operation']) &&  !empty($data['code'])) {

		$chat = $data['operation'];
		$code = $data['code'];

		return operation( array('operation'=> $chat), $class, $code);
	}

	//返回场景布局页的状态
	if ( !empty($data['mb_operation']) &&  !empty($data['code'])) {

		$chat = $data['mb_operation'];
		$code = $data['code'];

		return operation( array('mb_operation'=> $chat), $class, $code);
	}


	//接收选场景交互指令
	if ( !empty($data['scene']) && !empty($data['code'])) {

		$chat = $data['scene'];//场景id
		$code = $data['code'];

		return operation( array( 'scene' => $chat), $class, $code);
	}

	//控制显示摆放物品
	if ( !empty($data['select']) && !empty($data['scene_type']) && !empty($data['code'])) {

		$chat = $data['select'];//选中物品的id
		$type = $data['scene_type'];//场景
		$code = $data['code'];

		return operation( array( 'select' => array('0' => $chat, '1' => $type)), $class, $code);
	}

	//选择确认后返回结果，控制对话内容
	if ( !empty($data['result']) && !empty($data['scene_type']) && !empty($data['select_id']) && !empty($data['code'])) {

		$chat = $data['result'];//结果 false
		$type = $data['scene_type'];//场景
		$select_id = $data['select_id'];//选择物品id
		$code = $data['code'];

		return operation( array( 'result' => array('0' => $chat, '1' => $select_id, '2' => $type)), $class, $code);
	}

	//启动转盘
	if ( !empty($data['dzp']) && !empty($data['code'])) {

		$chat = $data['dzp'];
		$code = $data['code'];
		return operation( array( 'dzp' => $chat), $class, $code);
	}

	//转盘结束后，向mb发送切屏指令
	if ( !empty($data['dzp_end']) && !empty($data['code'])) {

		$chat = $data['dzp_end'];
		$code = $data['code'];
		
		return operation( array( 'dzp_end' => $chat), $class, $code);
	}

	//转盘结束后，并且手机端以下一页，向PC发送下一页切屏指令
	if ( !empty($data['mb_dzp']) && !empty($data['code'])) {

		$chat = $data['mb_dzp'];
		$code = $data['code'];

		return operation( array( 'mb_dzp' => $chat), $class, $code);
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

