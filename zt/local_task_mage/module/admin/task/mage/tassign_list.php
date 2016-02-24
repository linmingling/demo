<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/4
 * Time: 11:19
 */

$this->table = 'tc_task_execute';

// 目前只接受get 类型的请求
if(isGet() == true) {

    $countParams = array();
    $rsParams = array();
    $rsSql = null;
    // 指派给我的任务
    $countSql = "";

    // 我执行的任务
    if(isset($request['to']) && $request['to']==1) {
       $countSql = " A.exec_id = ? ";
        $rsSql = ' AND ' . $countSql;
            //array_push($countParams, );
        $rsParams = $countParams = Array($config['user_id']);
        $this->_templateName = 'tassign_list_to.html';
    }
    // 我指派的任务
    if(isset($request['from']) && $request['from']==1) {
        $countSql = " A.created_id = ? ";
        $rsSql = ' AND ' . $countSql;
        $rsParams = $countParams = Array($config['user_id']);
        $this->_templateName = 'tassign_list_from.html';
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
    $pageLimit = 2;
    if(!isset($request['page']) || !$request['page'])
        $request['page'] = 1;

    $page = $request['page'] * 1;
    $offset = $pageLimit * ($page - 1);

    $limit = ' LIMIT ' . $offset  . ',' . $pageLimit;
    //2: 执行查询语句获取结果

    // 处理列表资源查询
    if(isset($request['name'])) {
        $rsSql .= " AND B.task_name LiKE ?";
        //$rsParams = array("'%" . $request['name'] . "%'");
        array_push($rsParams, "%".$request['name']."%");
    }

    $rsQ = '(
    SELECT B.task_name,B.target,B.creat_time,B.start_time,B.statu,B.end_time,B.statu,B.creat_time,A.id,A.task_statu,A.progress,A.created_id,A.exec_id,A.level,A.task_id FROM '. $this->table .' A INNER JOIN tc_task B
        ON A.task_id = B.id ' . $rsSql . $limit . '
    )';

    //echo $rsQ;exit;
    $pager = array();// 保存分页信息的函数
    if($rsSql) {
        $rsData = $app->db->rawQuery ($rsQ, $rsParams);
    } else {
        $rsData = $app->db->rawQuery ($rsQ);
    }

    if(is_array($rsData)) {
        foreach($rsData as $k=>$data) {
            $tuser = null;
            if( isset($request['from']) && $request['from']==1) { // 我执行的
                $this->db->where('id', $data['exec_id']);
            } elseif(isset($request['to']) && $request['to']==1) {
                $this->db->where('id', $data['created_id']);
            }
            $tuser =  $this->db->getOne('tc_user','name');
            if($tuser) {
                $rsData[$k]['uName'] = $tuser['name'];
            }
        }
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