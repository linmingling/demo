<?php
header("Content-Type: text/html;charset=utf-8");
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
require($rootPath.'/data/config.php');
// table 
$tableName = 'hl_red_packet';

// user info 
$openId = $_SESSION['openid'];
$nickname = $_SESSION['nickname'];
$distingArr = array('2016-02-15','2016-02-16','2016-02-17');

// active config 
$activeId = 17;// 红包活动id
$secrityKey = '5b4e5c7421f67bb103019c058b7a42e3'; // 商户密钥
$interfaceUrl = 'http://tao.jia360.com/index.php?g=API&m=WeixinApi&a=hongbao'; // 发红包接口链接
$activeToken = 'otelzf1453168233'; // 商户token

// 返回值说明
// 1001：不在活动范围内 
// 1002：用户数据异常
// 1003: 你已经摇到兑换码,请到全民家居购公众号领取红包
// 1004: 本期活动您已领过一个口令红包。不可重复领取。
// 1005：您的抽奖次数已用完，分享可增加抽奖次数
// 1006: 缺少百分比参数
// 1007：抽奖次数已用完
// 1008：未达到抽奖条件，继续摇
// 1009: 您已参与活动，请关注全民家居购官微发布的其他互动性活动。谢谢！
// 1010: 未能成功保存
// 1011：你已经兑换过红包了
// 1012：没有兑换码
// 1013:错误的兑换码！

// 当前活动天数
$curDisting = isActive( $distingArr );

// script action
$act = trim( $_POST['act'] );

// 微信分享
if( $act == 'share' ) {
	// 判断是否在活动范围内
	
	//  查询抽奖机会
	$sql = 'SELECT share_count,lottery_num FROM ' . $tableName . ' WHERE openid=\'' . $openId . '\' LIMIT 1';
	$query_res = mysqli_query($db, $sql);
	if($query_res) {	
		$result = $query_res->fetch_assoc();
		$result['lottery_num'] *=1;
		$result['share_count'] *=1;
		
		// 释放资源
		if( $query_res )
		mysqli_free_result( $query_res );
		
		// 增加抽奖次数 分享次数超过五次不累加
		if( $result['share_count'] < 5 ) {
			$result['lottery_num'] = $result['lottery_num'] + 1;
			echo json_encode( array('errCode'=>0, 'errMsg'=>'OK' ,'return'=> $result['lottery_num']) );
			
			// 增加抽奖次数
			$sql = 'UPDATE ' . $tableName . ' SET lottery_num=lottery_num+1,disting=\'' . $curDisting . '\',share_count = share_count+1 WHERE openid = \'' . $openId . '\'';
			mysqli_query($db, $sql);	
			exit;
		} else {
			echo json_encode( array('errCode'=>0, 'errMsg'=>'OK' ,'return'=> $result['lottery_num']) );	
			// 增加分享次数
			$sql = 'UPDATE ' . $tableName . ' SET disting=\'' . $curDisting . '\',share_count = share_count+1 WHERE openid = \'' . $openId . '\' ';
			mysqli_query($db, $sql);	
			exit;			
		}
		
	} else {
		echo json_encode( array('errCode'=>1002, 'errMsg'=>'用户数据异常' ,'return'=> 0 ) );
	}
	
}

/* 检查是否有摇号码的条件
*
*/
if( $act == 'check' ) {
	// 检测是否在活动期内
	if( !$curDisting ) {
		die( json_encode( array('errCode'=>1001, 'errMsg'=>'不在活动范围内' ,'return'=> '') ) );
	}		
	// 检测账号是否异常
	$sql = 'SELECT percent,lottery_num,openid,red_packet_code,is_exchange FROM ' . $tableName . ' WHERE openid=\'' . $openId . '\' LIMIT 1';
	$query_res = mysqli_query($db, $sql);
	if($query_res) {
		$result = $query_res->fetch_assoc();
		
		// 释放资源
		if( $query_res )
		mysqli_free_result( $query_res );
		
		// 没有找到 openid
		if( !$result['openid'] ) {
			die( json_encode( array('errCode'=>1002, 'errMsg'=>'用户数据异常' ,'return'=> '0') ) );
		}		

		// 检测是否已经兑换过红包
		if( $result['is_exchange']  == 1) {
			die( json_encode( array('errCode'=>1004, 'errMsg'=>'本期活动您已领过一个口令红包。不可重复领取。' ,'return'=> '0') ) );
		}				
		
		// 检测是否已经领过号码
		if( $result['red_packet_code'] ) {
			die( json_encode( array('errCode'=>1003, 'errMsg'=>'你已经摇到兑换码,请到全民家居购公众号领取红包！' ,'return'=> '0') ) );
		}				

		// 检测是否还有抽奖次数
		$result['lottery_num'] *= 1;
		if( $result['lottery_num'] < 1 ) {
			die( json_encode( array('errCode'=>1005, 'errMsg'=>'您的抽奖次数已用完，分享可增加抽奖次数' ,'return'=> '0') ) );
		}
		
		// 正常情况
			die( json_encode( array('errCode'=>0, 'errMsg'=>'OK' ,'return'=> $result['lottery_num'],'percent'=>$result['percent'] ) ) );
		// 其他异常检测
	} else {
		die( json_encode( array('errCode'=>1002, 'errMsg'=>'用户数据异常' ,'return'=> '0') ) );
	}		
}

/* 生成用户红包兑换代码
*  返回值说明 0：成功，1001 :入库失败, 1002 ：已经中过奖, 1003 请求错误
*
*/
if( $act == 'get_code' ) {
	if( !$curDisting ) {
		die( json_encode( array('errCode'=>1001, 'errMsg'=>'不在活动范围内' ,'return'=> '') ) );
	}
	
	if( !isset( $_POST['percent'] ) ) {
		die( json_encode( array('errCode'=>1006, 'errMsg'=>'缺少百分比参数!' ,'return'=> '') ) );
	}
	
	$_POST['percent'] *=1;
	
	// 检查是否已经生成红包兑换码
	$sql = 'SELECT lottery_num,percent,openid,red_packet_code FROM ' . $tableName . ' WHERE openid=\'' . $openId . '\' LIMIT 1';
	$query_res = mysqli_query($db, $sql);
	if($query_res) {
		$result = $query_res->fetch_assoc();
		$result['percent'] *=1;
		$result['lottery_num'] *=1;
		
		// 释放资源
		if( $query_res )
		mysqli_free_result( $query_res );		
		
		$percent = $result['percent'] + $_POST['percent']; // 最终的百分比
		$percent*=1;
		if($percent > 100 ) {
			$percent = 100;
		}
		
		// 判断百分比
		if( $percent < 100 ) {
			if( $result['lottery_num'] == 1 ) {
				// 抽奖次数已用完 提示分享
				echo  json_encode( array('errCode'=>1007, 'errMsg'=>'抽奖次数已用完，分享可增加抽奖次数' ,'percent'=>$percent) );
				
				// 更新百分比		
				$sql = 'UPDATE ' . $tableName . ' SET lottery_num = 0, percent = \'' . $percent . '\',modify_time=\'' . date('Y-m-d H:i:s') . '\' WHERE openid = \'' . $openId . '\'';
				mysqli_query($db, $sql);	
				exit;				
			} 
			else if( $result['lottery_num'] > 1 )
			{
				// 抽奖次数剩余 提示继续摇
				echo json_encode( array('errCode'=>1008, 'errMsg'=>'未达到抽奖条件，请继续摇' , 'percent'=>$percent ) );
				
				// 更新百分比		
				$sql = 'UPDATE ' . $tableName . ' SET lottery_num = lottery_num-1, percent = \'' . $percent . '\',modify_time=\'' . date('Y-m-d H:i:s') . '\' WHERE openid = \'' . $openId . '\'';
				mysqli_query($db, $sql);	
				exit;
			}
		}
		
		// 是否已经生成红包兑换码
		if( !$result['red_packet_code'] ) {
			// 达到抽奖条件
			$code = 'HB201602';//getRandChar( 8 );	// 生成红包兑换码
			$code_sql = 'UPDATE ' . $tableName . ' SET red_packet_code = \'' . $code . '\',modify_time=\'' . date('Y-m-d H:i:s') . '\',lottery_num = lottery_num-1, percent = 100 WHERE openid = \'' . $openId . '\'';
			$code_query_res = mysqli_query($db, $code_sql);
			
			// 返回值
			if( $code_query_res ) {			
				echo json_encode( array('errCode'=>0, 'errMsg'=>'OK' ,'return'=> $code, 'percent'=>100) );			
				exit;
			} else {
				die( json_encode( array('errCode'=>1010, 'errMsg'=>'未能成功保存' ,'return'=> '') ) );
			}
		} else {
			// 已中过奖，处理
			die( json_encode( array('errCode'=>1009, 'errMsg'=>'您已参与活动，请关注全民家居购官微发布的其他互动性活动。谢谢！' ,'return'=> '') ) );
		}
	} else {
		// 未查询到用户数据
		die( json_encode( array('errCode'=>1002, 'errMsg'=>'用户数据异常' ,'return'=> '') ) );
	}
}

/*
* 发钱，哈哈
*/
if( $act == 'get_money' ) {
	
	if( !$curDisting ) {
		die( json_encode( array('errCode'=>1001, 'errMsg'=>'不在活动范围内' ,'return'=> '', 'money'=>'0') ) );
	}
		
	// 是否兑换过,兑换码是否有效	
	$sql = 'SELECT openid,red_packet_code,is_exchange FROM ' . $tableName . ' WHERE openid=\'' . $openId . '\' LIMIT 1';
	$query_res = mysqli_query($db, $sql);
	if($query_res) {	
		$result = $query_res->fetch_assoc();
	
		// 释放资源
		if( $query_res )
		mysqli_free_result( $query_res );		
		
		if( !$result['openid'] ) {
			// 未查询到用户数据						
			die( json_encode( array('errCode'=>1002, 'errMsg'=>'用户信息异常' ,'return'=> '', 'money'=>'0') ) );		
		}
		if( $result['is_exchange'] == 1 ) {
			// 已经兑换过了						
			die( json_encode( array('errCode'=>1011, 'errMsg'=>'已经兑换过红包了' ,'return'=> '', 'money'=>'0') ) );					
		}
		if( !$result['red_packet_code'] ) {
			// 用户信息没有红包兑换码						
			die( json_encode( array('errCode'=>1012, 'errMsg'=>'没有兑换码' ,'return'=> '', 'money'=>'0') ) );					
		}

		// 正常情况
		$data['id'] = $activeId;
		$data['token'] = $activeToken;
		$data['openid'] = $openId;
		$data['wechaname'] = $nickname;
		$data['key'] = $secrityKey;
		$result = curl_post($interfaceUrl, $data);
		$result = json_decode($result);
		$result = (array)$result; 
		if( $result['errcode'] == 0 ) {
			// 修改状态
			$sql = 'UPDATE ' . $tableName . ' SET is_exchange = \'1\',disting=\'' . $curDisting . '\',modify_time=\'' . date('Y-m-d H:i:s') . '\' WHERE openid = \'' . $openId . '\'';
			$statu = mysqli_query($db, $sql);
			if( $statu ) {
				// 成功
				die( json_encode( array('errCode'=>0, 'errMsg'=>'红包发放成功！' ,'money'=> $result['total'],'return'=> '') ) );
			} else {
				// 接口请求了红包，数据库未改状态
				die( json_encode( array('errCode'=>0, 'errMsg'=>'红包发放异常' ,'money'=> $result['total'],'return'=> '') ) );
			}
			
		} else {
			die( json_encode( array('errCode'=>1005, 'errMsg'=>$result['errmsg'] ,'return'=> '', 'money'=>'0') ) );
		}
		
	} else {
		die( json_encode( array('errCode'=>1006, 'errMsg'=>'请求错误,未查询到用户数据' ,'return'=> '', 'money'=>'0') ) );
		// 未查询到用户数据
	}
}

if ( $db ) 
mysqli_close( $db );

/* 方法类函数
*  处理要入库的数据
*  传入带索引的数组
*  返回数据库字段和对应的值
*/
function processData( $data = '' )
{
	$fields = null;
	$values = null;
	
	if( !$data ) {
		return false;
	}
	
	foreach($insertData as $field=>$value)
	{
		$fields .= "`" . $field . "`,";
		$values .= "'" . $value . "',";
	}
	
	// 检查，入库操作
	if( $fields && $values) {
		$fields = substr($fields, 0,-1);
		$values = substr($values, 0,-1);
		
		return array( 'fields'=> $fields, 'values'=>$values );
	} else{
		return false;
	}
}

/* 检查是否在活动期内
*  数组格式 array('2015-03-01','2016-03-03')
*/
function isActive( $distingArr = '' )
{
	if( !$distingArr ) {
		return 0;
	}

	$disting = array_search(date('Y-m-d'), $distingArr);
	$disting = $disting!==false?$disting+1:0;
	return $disting;
}

/* 生成随机字符串
*  指定长度 $length
*/
function getRandChar( $length = 8 ){
   $str = null;
   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }
  
/* curl post
*  
*/  
function curl_post($url,$data)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POST, 1);//发送一个常规的Post请求
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Post提交的数据包
	$rv = curl_exec($curl);//输出内容
	curl_close($curl);
	return $rv;
}