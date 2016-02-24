<?php
// 是否post 提交
// 定义表名
$this->table ='tc_organization';

if(isPost() === true) {
    if(!$request['name']) {
        $json['error_code'] = 1000;
        $json['message'] = '请填写名称!';
        die(json_encode( $json ));
    }

    // 入库 过滤
    $request['name'] = mysqli_real_escape_string($app->db, $request['name']);
    $inputData = array('name'=> $request['name']);
    $id = $app->db->insert($this->table, $inputData);
    if($id > 0) {
        $json['error_code'] = 0;
        $json['message'] = '添加成功!';
        die(json_encode( $json ));
    }
}
else {
    $json['error_code'] = 1002;
    $json['message'] = '错误的请求!';
    die(json_encode( $json ));
}