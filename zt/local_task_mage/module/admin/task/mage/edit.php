<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */

$this->table = 'tc_task';
$this->title = '';
$this->breadCrumbs = '';

if(!isset($request['tid'])) {
	$json['error_code'] = 1000;
	$json['rUrl'] = '';
	$json['message'] = '错误的请求,请填写任务id!';		
	die(json_encode( $json ));
}	

if(isPost() == true) {
    // 入库 过滤
    // 入库 过滤
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
        $json['message'] = '请输入任务开始时间!';	
		die(json_encode( $json ));		
	}	
	if(!isset($request['taskStatu'])) {
		$json['error_code'] = 1008;
        $json['rUrl'] = '';
        $json['message'] = '请输入任务结束时间!';	
		die(json_encode( $json ));		
	}		
	
	$updateData = array();
	$updateData['description'] = addslashes($request['taskDetail']);
	$updateData['target'] = addslashes($request['taskTarget']);
	$updateData['created_id'] = $config['user_id']*1;
	$updateData['modification_date'] = time();
	$updateData['statu'] = date($request['taskStatu']);		
	$updateData['start_time'] = strtotime($request['taskStartTime'] . ' 0:0:0');
	$updateData['end_time'] = strtotime($request['taskEndTime'] .' 23:59:59');		

    $app->db->where ('id',  $request['tid']);
    $app->db->update ($this->table, $updateData);
	//$app->db->getLastError();

    if($app->db->count > 0) {
        $json['error_code'] = 0;
        $json['message'] = '修改成功!';
        $json['rUrl'] = '';
        //die(json_encode( $json ));
        header('Location:'. $config['sUrl'].'&a=list');
    }
    else {
        $json['error_code'] = 1000;
        $json['rUrl'] = '';
        $json['message'] = '修改失败!';
        header('Location:'. $config['sUrl'].'&a=add');
        //die(json_encode( $json ));
    }
}
else if(isGet() == true) {

    // 部门
	$app->view->assign('taskStatus', taskStatus());
	$app->db->where('id',$request['tid']);
    $userData = $app->db->getOne ($this->table, null);
    $this->view->assign('data',$userData);
    $this->view->display($this->_templateName);
}
else {
    //user_type
}




