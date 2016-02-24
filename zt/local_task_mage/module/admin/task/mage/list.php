<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */

$this->table = 'tc_task';

// 目前只接受get 类型的请求
if(isGet() == true) {
    // 处理查询字段
    if(isset( $request['name']))
        $request['name']  = mysqli_real_escape_string($this->db, $request['name']);

    if(isset($request['name'])) {
        $countSql = " AND A.task_name LIKE ? ";
        $rsParams = $countParams = Array("'% ". $request['name'] ."%'");
    }
    else {
        $countSql = "? ";
        $rsParams = $countParams = Array(1);
    }

    //1: 统计总页数 开始分页
    $count = 0;
    $rsSql = null;
    $q = '(
    SELECT count(id) as count FROM '. $this->table .' A
        WHERE ' . $countSql . '
    )';

    $couResutls = $app->db->rawQueryOne ($q, $countParams);
    if($couResutls['count']) {
        $count = $couResutls['count'];
    }

    //2:分页参数
    $pageLimit = 5;
    if(!isset($request['page']) || !$request['page'])
        $request['page'] = 1;

    $page = $request['page'] * 1;
    $offset = $pageLimit * ($page - 1);

    $limit = ' LIMIT ' . $offset  . ',' . $pageLimit;
    //2: 执行查询语句获取结果

    $rsQ = '(
    SELECT A.id,A.task_name,A.target,A.created_id,A.creat_time,A.start_time,A.statu,A.end_time,A.statu,A.creat_time,B.name as user_name FROM '. $this->table .' A LEFT JOIN tc_user B
        ON A.created_id = B.id ' . $rsSql . $limit . '
    )';

    $pager = array();// 保存分页信息的函数
    if($rsSql) {
        $rsData = $app->db->rawQuery ($rsQ, $rsParams);
    } else {
        $rsData = $app->db->rawQuery ($rsQ);
    }

    $pager['page'] = pages($count, $page = 1, $pagesize = $pageLimit, $offset = 2, $config['currentUrl']);
    // 分页到此结束

    $pager['limit'] = $pageLimit;
    $pager['count'] = $count;
    $pager['currentPage'] = $page;

	$app->view->assign('taskStatus', taskStatus());
    $this->view->assign('pager', $pager);
    $this->view->assign('data', $rsData);
    $this->view->display($this->_templateName);
}