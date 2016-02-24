<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */
$this->table = 'tc_user';

if(isPost() == true) {
    // 入库 过滤
    $request['userName'] = addslashes($request['userName']);
    $request['phone'] = addslashes($request['phone']);
    $request['email'] = addslashes($request['email']);
    $request['group_id'] = $request['group_id'] * 1;
    $request['add_time'] = time();

    $inputData = array('name'=>$request['userName'], 'phone'=> $request['phone'], 'email'=> $request['email'], 'org_id'=> $request['group_id'], 'add_time'=>$request['add_time']);
    $id = $app->db->insert($this->table, $inputData);
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
    // 部门
    $this->view->assign('groups', listGroup());
    $this->view->assign('aa',333);
    $this->view->display($this->_templateName);
}
else {
    //user_type
}

