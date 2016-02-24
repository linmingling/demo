<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */
$this->table = 'tc_task_execute';

if(isPost() == true) {
    // 入库 过滤
	if(!isset($request['taskId'])) {
		$json['error_code'] = 1001;
        $json['rUrl'] = '';
        $json['message'] = '请选择任务!';
		die(json_encode( $json ));
	}

	if(!isset($request['taskTarget'])) {
		$json['error_code'] = 1003;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务目标!';	
		die(json_encode( $json ));		
	}
	if(!isset($config['user_id'])) {
		$json['error_code'] = 1004;
        $json['rUrl'] = '';
        $json['message'] = '异常登录!';		
		die(json_encode( $json ));
	}
	
	if(!isset($request['taskStartTime'])) {
		//$json['error_code'] = 1006;
        //$json['rUrl'] = '';
        //$json['message'] = '请输入任务开始时间!';	
		//die(json_encode( $json ));	
		$request['taskStartTime'] = date("Y-m-d");// 默认为今天
  	}
	
	if(!isset($request['taskEndTime'])) {
		//$json['error_code'] = 1007;
        //$json['rUrl'] = '';
        //$json['message'] = '请输入任务结束时间!';	
		//die(json_encode( $json ));
		$request['taskEndTime'] = date("Y-m-d");// 默认为今天
	}	
	
	if(!isset($request['uids'])) {
		$json['error_code'] = 1008;
        $json['rUrl'] = '';
        $json['message'] = '请指派执行这个任务的人!';		
		die(json_encode( $json ));
	}	
	

	$sqlExecResult = array('success'=>0, 'failure'=>0); // sql 执行结果
	// 公用数据处理
	$insertData = array();
	$request['taskId']*=1;	
	$insertData['assign_target'] = addslashes($request['taskTarget']);
	$insertData['level'] = $request['taskLevel'];
	$insertData['task_id'] = $request['taskId']*1;
	$insertData['created_id'] = $config['user_id']*1;
	$insertData['add_time'] = time();
	$insertData['start_time'] = strtotime($request['taskStartTime'] . ' 0:0:0');
	$insertData['end_time'] = strtotime($request['taskEndTime'] .' 23:59:59');	
	
	$request['uids'] = json_decode($request['uids']);
	if(is_array($request['uids'])) {
		foreach($request['uids'] as $userId) {
			$checkRs = array();
			$checkRs = checkTaskIsAssign($request['taskId'], $userId);
			
			if(!$checkRs['id']) {
				$insertData['exec_id'] = $userId*1;
				
				$id = $app->db->insert($this->table, $insertData);
				if($id > 0) {
					$sqlExecResult['success'] +=1;
				}
				else {
					$sqlExecResult['success'] +=1;
				}	
			}
			else {
				$sqlExecResult['failure'] +=1;
			}
		}
		
		// 最终执行状态
		$json['error_code'] = 0;
		//$json['message'] = '添加成功!';
		$json['rUrl'] = '';
		//die(json_encode( $json ));
		header('Location:'. $config['sUrl'].'&a=list');		
	}
	else {//没有指派
		$json['error_code'] = 1008;
        $json['rUrl'] = '';
        $json['message'] = '请指派执行这个任务的人!';		
		die(json_encode( $json ));
	}
}
else if(isGet() == true) {
	$this->view->assign('tasks', getTask());
	$this->view->assign('users', getAllUser());
    $this->view->display($this->_templateName);
}
else {
    //user_type
}

// 检测这个任务是否已经指派给这个人
function checkTaskIsAssign($taskId, $user_id)
{
	$GLOBALS['db']->where('task_id', $taskId);
	$GLOBALS['db']->where('exec_id', $user_id);
	return $GLOBALS['db']->getOne("tc_task_execute",null,'id');
}


