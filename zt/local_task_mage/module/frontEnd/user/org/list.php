<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/1
 * Time: 10:57
 */

$this->table ='tc_organization';

if(isGet() === true) {
    $countSql = 1;
    if(isset( $request['org_id']))
        $request['org_id']  *=1;

    if(isset( $request['name']))
         $request['name']  = mysqli_real_escape_string($this->db, $request['name']);

    if(isset($request['name'])) {
        $countSql = " AND A.name LIKE ?";
        $countParams = Array("'% ". $request['name'] ."%'");
    }
    else {
        $countParams = "?";
    }

    //1: 统计总页数 开始分页
    $count = 0;
    $q = '(
    SELECT count(id) as count FROM '. $this->table .' A
        WHERE ' . $countSql . '
    )';

    $couResutls = $app->db->rawQueryOne ($q, $countParams);
    if($couResutls['count']) {
        $count = $couResutls['count'];
    }

    //2:分页参数
    $pageLimit = 20;
    if(!isset($request['page']) || !$request['page'])
        $request['page'] = 1;

    $page = $request['page'] * 1;
    $offset = $pageLimit * ($page - 1);

    $limit = ' LIMIT ' . $offset  . ',' . $pageLimit;
    //2: 执行查询语句获取结果
    $rsQ = '(
    SELECT id,name FROM '. $this->table .' A
        WHERE ? ' . $limit . '
    )';

    $rsParams = Array(1);
    $rsData = $app->db->rawQuery ($rsQ, $rsParams);

    // 分页到此结束
    if($rsData) {
        $this->view->assign('orgs', $rsData);
        $this->view->display($this->_templateName);
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