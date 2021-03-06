<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/2
 * Time: 9:22
 */

$this->table ='tc_task';
// tc_task_execute
// tc_user
// tc_organization

$userSjson = getUsers( $app );
if($userSjson) {
    $userSjson = json_encode( $userSjson );
}

// 获取本周星期一
$cur = getmonsun();
$monDay = date('Y-m-d',$cur['mon']);
$monDay2 = date('Y-m-d H:i:s',$cur['mon']);
$this->view->assign('monDay', $monDay);

if(isGet() === true) {

    if(!(isset($request['stime'])) || !(isset($request['etime']))) {
        $json['error_code'] = 1000;
        $json['message'] = '请输入开始时间或结束时间!';
        die(json_encode( $json ));
    }

    //开始时间
    $startTime = $request['stime'];

    // 结束时间
    $endTime   = $request['etime'];

    // 处理默认值
    if(!is_numeric ($startTime)) {
        $startTime = strtotime($startTime);
    }

    if(!is_numeric ($endTime)) {
        $endTime = strtotime($endTime);
    }

    //1: 统计总页数 开始分页
   $gtime = get_days($startTime, $endTime);
   // $restDate = implode(',', $gtime['rest']);// 本时间段内的星期日

    // 时间段获取数据
    $rsParams = array($startTime, $endTime);
    $rsq = 'SELECT a.task_id,a.start_time,a.end_time,a.bush_statu FROM tc_task_execute a WHERE a.start_time >= ? AND a.end_time <= ?
ORDER BY a.bush_statu ASC
    ';
    // 任务id，开始时间，结束时间，忙碌状态
    // 获取时间段

    $couResutls = $app->db->rawQuery($rsq, $rsParams);
    /*
    $rsData = array();
    if(isset($gtime['work'])) {
        foreach($gtime['work'] as $time) {
            if()
        }
    }
    */

    $newData = array();
    if(is_array($couResutls)) {
        foreach($couResutls as $k=>$data) {
           // $newData[] = ggtimes($data['start_time'], $data['end_time'], $data);
            if(is_array($data)) {
                $newData[] = array_values($data);
            }
        }
        $val = json_encode( $newData );
    }
    /*
    $nnData = array();
    foreach($newData as $k=>$data) {
        foreach($data as $k=>$d) {
            $nnData[] = $d;
        }
    }
	
    if(is_array($nnData)) {
        $nnnData = array();
        foreach($nnData as$k=>$data) {
            $nnnData[$k][] = $data['id'];
            $dates = getdate(strtotime($data['time']));
            $nnnData[$k][] = ($dates['mon'].'1'.$dates['mday'])*1;
            $nnnData[$k][] = $data['bush_statu'];
        }

       // print_R($nnnData);exit;
        $val = json_encode( $nnnData );

        //echo $val;exit;
    }*/
    else {
        $json['error_code'] = 1001;
        $json['message'] = '没有查询到数据!';
        $val = json_encode( $json );
    }

    // 1
    $orgDatas = array();
    $orgs = getOrgJson( $app );
    if(is_array($orgs)) {
        foreach($orgs as $k=>$org) {
            $orgDatas[$k][] = $org['name'];
            $orgDatas[$k][] = $org['count'];
        }
    }
    $orgDatas = json_encode( $orgDatas );

    // 2
    $userDatas = array();
    $users = getUserJson( $app );
    if(is_array($users)) {
        foreach($users as $k=>$user) {
            $userDatas[$k][] = $user['name'];
            $userDatas[$k][] = $user['id'];
        }
    }
    $userDatas = json_encode( $userDatas );

    $this->view->assign('orgJson', $orgDatas);
    $this->view->assign('userJson',$userDatas);
    $this->view->assign('bushJson',$val);
    $this->view->display($this->_templateName);
    //任务id，开始时间，结束时间，忙碌状态
    /*
    $count = 0;
    $q = 'SELECT count(a.id) as count FROM tc_task_execute a
    WHERE a.start_time >= ? AND a.end_time <= ?
    AND a.task_statu = ?';

    $countParams = array($startTime, $endTime, 1);
    $couResutls = $app->db->rawQueryOne($q, $countParams);
    if($couResutls['count']) {
        $count = $couResutls['count'];
    }
    */

    /*查询数据*/
    /*
    $rsParams = array($startTime, $endTime, 1);
    $rsq = 'SELECT a.task_id,a.exec_id,a.task_statu,a.progress,a.add_time,a.start_time,a.end_time,a.bush_statu,
   b.task_name,b.target,b.created_id,b.end_time as t_end_time FROM tc_task_execute a
    LEFT JOIN tc_task b ON a.task_id = b.id AND a.start_time >= ? AND a.end_time <= ?
    AND a.task_statu = ?
    ';

    $couResutls = $app->db->rawQuery($rsq, $rsParams);
    if(is_array($couResutls)) {
        foreach($couResutls as $rs) {


        }
    }
    */
}
else {
    $json['error_code'] = 1002;
    $json['message'] = '错误的请求!';
    die(json_encode( $json ));
}

// 传入时间戳，返回天为单位的时间戳段
function ggtimes($satrtTime, $endTime, $data) {
    $now = $satrtTime;
    $contDays = floor(($endTime - $satrtTime) / (3600*24));
    $days = array();
    $timer = 0;

    for($i=1;$i<= $contDays;$i++)
    {
        $days[$i]['id'] = $data['exec_id'];
        $days[$i]['time'] = date("Y-m-d",$now+3600*24*$i);//$now+3600*24*$i;
        $days[$i]['bush_statu'] = $data['bush_statu'];
    }

    return $days;
}

//
function getUsers( $app )
{
    $userData = array();
    $orgCols = Array ("id", "name");
    $userCols = Array ("id", "name");
    $orgs =$app->db->get ("tc_organization", null, $orgCols);
    if(is_array($orgs)) {
        foreach($orgs as $org) {
            //获取部门下的用户
            $app->db->where ("org_id", $org['id']);
            $rsData = $app->db->get ('tc_user', null, $userCols);
            if(is_array( $rsData )) {
                $userData[$org['name']] = $rsData;
            }
        }
    }
    return $userData;
}

// 一段时间内的休息日和上班日
function get_days ($satrtTime, $endTime)
{
    $satrtTime *= 1;
    $endTime *= 1;
    $now = $satrtTime;
    $exclude = array(6,7);//要排除的日期
    $contDays = floor(($endTime - $satrtTime) / (3600*24));
    $days = array();
    $timer = 0;

   for($i=1;($now+3600*24*$i) <= $endTime;$i++)
    {
        $timer = $now+3600*24*$i;
        $num= date("N",$timer);
        //echo $num .'---'.date("Y-m-d",$now+3600*24*$i) .'<br/>';
       if(in_array($num, $exclude) === false) {
            $days['work'][] = date("Y-m-d",$now+3600*24*$i);
        }
        else {
            $days['rest'][] = date("Y-m-d",$now+3600*24*$i);
        }
    }

    return $days;
}

getUserJson( $app );
// 获取机构名称和用户个数
function getOrgJson( $app )
{
    $rsq = 'select a.*,count(b.id) as count FROM tc_organization a LEFT JOIN tc_user b
ON a.id = b.org_id GROUP BY a.id';
    return  $app->db->rawQuery($rsq);
}

// 获取用户名称和id
function getUserJson( $app )
{
    $rsq = 'select a.id,a.name FROM tc_user a WHERE 1';
    return $app->db->rawQuery($rsq);
}

