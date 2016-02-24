<?php
// 是否post 提交
// 定义表名
$this->table ='tc_organization';

if(isGet() == true) {
    $request['org_id']  *=1;

    if(!$request['org_id']) {
        $json['error_code'] = 1000;
        $json['message'] = '请输入组织id';
        die(json_encode( $json ));
    }

    //删除
    $this->db->where('id', $request['org_id']);
    if( $this->db->delete($this->table))
    {
        $json['error_code'] = 0;
        $json['message'] = '删除成功!';
        die(json_encode( $json ));
    }
    else
    {
        $json['error_code'] = 1001;
        $json['message'] = '删除失败!';
        die(json_encode( $json ));
    }
}
else {
    $json['error_code'] = 1002;
    $json['message'] = '错误的请求!';
    die(json_encode( $json ));
}