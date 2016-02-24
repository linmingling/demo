<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */

$this->table = 'tc_task_execute';
$this->title = '';
$this->breadCrumbs = '';

if(!isset($request['tid'])) {
    $json['error_code'] = 1002;
    $json['rUrl'] = '';
    $json['message'] = '错误的请求,请填写详情ID!';
    die(json_encode( $json ));
}

if(isGet() == true) {
    $request['tid']*=1;

    // 获取任务详情
    $this->db->where('id', $request['tid']);
    $tskInfo = $this->db->getOne('tc_task', 'id,task_name');

    if(!$tskInfo['id']) { // 没有找到任务
        $json['error_code'] = 1000;
        $json['message'] = '没有找到该任务!';
        die(json_encode( $json ));
    }
    //echo 111;exit;
    // 判断是执行者还是接受者
    if(isset($request['to']) && $request['to']==1) { // 接受者
       // $this->db->where('id', $request['tid']);
        //$tskInfo = $this->db->getOne($this->table);
        $this->db->join("tc_user B", "B.id = A.created_id", "LEFT");
        $this->db->join("tc_task C", "C.id = A.task_id", "LEFT");
        $this->db->where("A.task_id", $request['tid']);
        $taskInfo = $this->db->getOne ("tc_task_execute A", 'B.name,A.*,C.task_name,C.description,C.target,C.start_time AS sstart_time,C.end_time AS send_time,C.statu');
        $app->view->assign('data', $taskInfo);
        $app->view->assign('taskStatus', taskStatus());
        $this->_templateName = 'my_task_detail.html';
    }
    else if(isset($request['from']) && $request['from']==1) { // 执行者
        $this->db->join("tc_user B", "B.id = A.exec_id", "LEFT");
        $this->db->where("A.task_id", $request['tid']);
        $tasks = $this->db->get ("tc_task_execute A", null);
        $app->view->assign('data', $tasks);
    }
    else {

    }
    // 部门
    $this->view->display($this->_templateName);
}
else {
    //user_type
}




