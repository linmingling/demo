<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/1
 * Time: 10:55
 */
$this->table ='tc_organization';

if(isGet() === true) {
    $request['org_id']  *=1;

    if(!$request['org_id']) {
        $json['error_code'] = 1000;
        $json['message'] = '请输入组织id';
        die(json_encode( $json ));
    }

    // 查询组织
    $this->db->where ("id", $request['org_id']);
    $rsData = $this->db->getOne ($this->table);
    if($rsData) {
        $this->view->assign('orgs', $rsData);
    }
    else {
        $json['error_code'] = 1001;
        $json['message'] = '没有查询到数据集';
        die(json_encode( $json ));
    }
}
else {
    $json['error_code'] = 1002;
    $json['message'] = '错误的请求!';
    die(json_encode( $json ));
}