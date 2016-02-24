<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */

$this->table = 'tc_user';
$this->title = '';
$this->breadCrumbs = '';

if(isPost() == true) {
    $request['userName'] = addslashes($request['userName']);
    $request['phone'] = addslashes($request['phone']);
    $request['email'] = addslashes($request['email']);
    $request['group_id'] = $request['group_id'] * 1;
    $request['modify_time'] = time();
    $request['uid'] *= 1;

    $updateData = array('name'=>$request['userName'], 'phone'=> $request['phone'], 'email'=> $request['email'], 'org_id'=> $request['group_id'], 'modify_time'=>$request['modify_time']);
    $app->db->where ('id',  $request['uid']);
    $app->db->update ($this->table, $updateData);

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
    if(!isset($request['uid'])) {
        $json['error_code'] = 1000;
        $json['rUrl'] = '';
        $json['message'] = '请输入用户id!';
        die(json_encode($json));
    }

    // 部门
    $userData = $app->db->getOne ($this->table, null);
    $this->view->assign('groups', listGroup());
    $this->view->assign('userData',$userData);
    $this->view->display($this->_templateName);
}
else {
    //user_type
}
