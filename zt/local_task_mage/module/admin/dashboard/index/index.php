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

// 默认本周内找星期一
$cur = getmonsun();
//$monDay = date('md',$cur['mon']);
//$startDate = date('Y-m-d H:i:s',$cur['mon']);

//$day =  floor((time() - strtotime($enddate))/86400)+1;

if(isGet() === true) {
	if(!(isset($request['stime'])) && !(isset($request['etime']))) {
		$startTime = strtotime(date('Y-m-d H:i:s',$cur['mon']));
		$endTime = ($startTime + (3600 * 24 * 14)); // 两周后的时间戳 
	}
    if(!(isset($request['stime'])) || !(isset($request['etime']))) {
		if(!(isset($request['stime'])) && isset($request['stime'])) {
			$startTime = strtotime(date('Y-m-d H:i:s',$cur['mon']));
			$endTime   = $request['etime'];	
			if(!is_numeric ($endTime)) {
				$endTime = strtotime($endTime);
			}				
		}
		if(!(isset($request['etime'])) && isset($request['stime'])) {
			$startTime = $request['stime'];
			if(!is_numeric ($startTime)) {
				$startTime = strtotime($startTime);
			}			
			$endTime = ($startTime + (3600 * 24 * 14)); // 两周后的时间戳 			
		}		
    }
	else
	{
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
	}

    //1: 统计总页数 开始分页
   $gtime = get_days($startTime, $endTime);
   $totalDays = timeAddTo($startTime, 14);
	$this->view->assign('totalDays',$totalDays);
   // $restDate = implode(',', $gtime['rest']);// 本时间段内的星期日
   
    // 时间段获取数据
    $rsParams = array($startTime, $endTime);

    $rsq = 'SELECT a.exec_id,a.start_time,a.end_time,a.bush_statu FROM tc_task_execute a WHERE a.start_time >= ? AND a.end_time <= ?
    ';

    $couResutls = $app->db->rawQuery($rsq, $rsParams);

    $newData = array();
    if(is_array($couResutls)) {
        foreach($couResutls as $k=>$data) {
            $newData[] = ggtimes($data['start_time'], $data['end_time'], $data);
        }
    }

    $nnData = array();
    foreach($newData as $k=>$data) {
        foreach($data as $k=>$d) {
            $nnData[] = $d;
        }
    }

    if(is_array($nnData)) {
        $json['error_code'] = 0;
        $json['data'] = $nnData;
        $val = json_encode( $json );
    }
    else {
        $json['error_code'] = 1001;
        $json['message'] = '没有查询到数据!';
        $val = json_encode( $json );
    }

    $this->view->assign('orgJson',getOrgJson( $app ));
    $this->view->assign('userJson',getUserJson( $app ));
    $this->view->assign('bushJson',$val);
    $this->view->display($this->_templateName);
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
	if(in_array(date("N",$satrtTime), $exclude) === false) {
		$days['work'][] = date("Y-m-d",$satrtTime);
	}
	else {
		$days['rest'][] = date("Y-m-d",$satrtTime);
	}
	
   for($i=1;($now+3600*24*$i) <= $endTime;$i++)
    {
        $timer = $now+3600*24*$i;
        $num= date("N",$timer);
       if(in_array($num, $exclude) === false) {
            $days['work'][] = date("Y-m-d",$now+3600*24*$i);
        }
        else {
            $days['rest'][] = date("Y-m-d",$now+3600*24*$i);
        }
    }

    return $days;
}

// 累加到指定数量的工作日
function timeAddTo($startTime, $dayNum)
{
	$arr = array();
	$i = 1;
	$exclude = array(6,7);//要排除的日期

	if(in_array(date("N",$startTime), $exclude) === false) {
		$arr[] = date("Y-m-d",$startTime);
	}
	
	while(count($arr) < $dayNum) {
        $timer = $startTime+3600*24*$i;
        $num= date("N",$timer);		
		if(in_array($num, $exclude) === false) {
			$arr[] = date("Y-m-d",$startTime+3600*24*$i);
		}
		$i++;	
	}
	return $arr;
}


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

