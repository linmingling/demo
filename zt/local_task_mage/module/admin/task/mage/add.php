<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */
$this->table = 'tc_task';

if(isPost() == true) {
    // 入库 过滤
	if(!isset($request['taskName'])) {
		$json['error_code'] = 1001;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务名称!';
		die(json_encode( $json ));
	}
	if(!isset($request['taskDetail'])) {
		$json['error_code'] = 1002;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务说明!';		
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
		$json['error_code'] = 1006;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务开始时间!';	
		die(json_encode( $json ));		
	}
	if(!isset($request['taskEndTime'])) {
		$json['error_code'] = 1007;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务结束时间!';	
		die(json_encode( $json ));		
	}	
	
	$insertData = array();
	$insertData['task_name'] = addslashes($request['taskName']);
	$insertData['description'] = addslashes($request['taskDetail']);
	$insertData['target'] = addslashes($request['taskTarget']);
	$insertData['created_id'] = $config['user_id']*1;
	$insertData['creat_time'] = time();
	$insertData['start_time'] = strtotime($request['taskStartTime'] . ' 0:0:0');
	$insertData['end_time'] = strtotime($request['taskEndTime'] .' 23:59:59');

	//print_R($request);
	//print_R($insertData);
	//exit;
    
	$id = $app->db->insert($this->table, $insertData);
    if($id > 0) {
        $json['error_code'] = 0;
        $json['message'] = '添加成功!';
        $json['rUrl'] = '';
        //die(json_encode( $json ));
        header('Location:'. $config['sUrl'].'&a=list');
    }
    else {
        $json['error_code'] = 1000;
        $json['rUrl'] = '';
        $json['message'] = '添加失败!';
        header('Location:'. $config['sUrl'].'&a=add');
       //die(json_encode( $json ));
    }
}
else if(isGet() == true) {
    $this->view->display($this->_templateName);
}
else {
    //user_type
}

