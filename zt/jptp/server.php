<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../data/config.php');
$table = 'jptp';
if($_POST) 
{

	$act = trim($_POST['act']);
    if(empty($_SESSION['jptp_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }

    if($act == "addinfo")   //报名表单
    {
        if(date('Y-m-d H:i:s') > '2015-09-25 00:00:00')
        {
            $ajax_result['errcode'] = 1003;
            $ajax_result['errmsg'] = "报名已结束！";
            die(json_encode($ajax_result));
        }

        $name = trim($_REQUEST['name']);//姓名
        $gender = trim($_REQUEST['gender']);//性别
        $shop = trim($_REQUEST['shop']);//门店
        $type = trim($_REQUEST['type']);//类型
        $content = trim($_REQUEST['content']);//宣言
        

        if(empty($name) || empty($content) || empty($shop) || empty($content))
        {
            $ajax_result['errcode'] = 1001;
            $ajax_result['errmsg'] = "输入信息不完整，请重新输入！";
            die(json_encode($ajax_result));
        }

        $check_sql = "select name from {$table} where openid='{$_SESSION['jptp_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if(!empty($check_row['name']))
        {
            $ajax_result['errcode'] = 1002;
            $ajax_result['errmsg'] = "您已参与过报名啦！";
            die(json_encode($ajax_result));
        }

        $sql = "update {$table} set name='{$name}',gender='{$gender}',content='{$content}',type={$type},shop='{$shop}' where openid='" . $_SESSION['jptp_openid'] . "'";
        mysqli_query($db, $sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的信息已提交！";
        die(json_encode($ajax_result));
        
    }

    if($act == "list")  //搜索和三种类型切换
    {

        $type = isset($_REQUEST['type'])?trim($_REQUEST['type']):0;
        $search = isset($_REQUEST['search'])?trim($_REQUEST['search']):'';

        if(empty($search) && $type>0)
        {
            $sql = "select id,name,imgurl from {$table} where type={$type} order by id asc limit 20";
        }
        else
        {
            $sql = "select id,name,imgurl from {$table} where (id='{$search}' or name='{$search}')";
        }

        $res = mysqli_query($db,$sql);
        $rows = array();
        while($row = $res->fetch_assoc())
        {
            $rows[] = $row;
        }

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = $rows;
        die(json_encode($ajax_result));
    }

    if($act == "detail")    //资料详情
    {
        $id = trim($_REQUEST['id']);

        $sql1 = "select id,name,content,vote,imgurl from {$table} where id={$id}";
        $res1 = mysqli_query($db,$sql1);
        $row1 = $res1->fetch_assoc();

        //当前排名
        $sql2 = "select count(*) as c from {$table} where vote>={$row1['vote']}";
        $res2 = mysqli_query($db,$sql2);
        $row2 = $res2->fetch_assoc();

        $row1['vote_rank'] = $row2['c'];
        
        //与上一名差距
        $sql3 = "select vote from {$table} where vote>{$row1['vote']} order by vote desc limit 1";
        $res3 = mysqli_query($db,$sql3);
        $row3 = $res3->fetch_assoc();

        $row1['bvote'] = empty($row3['vote'])?'-':$row3['vote'];

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = $row1;
        die(json_encode($ajax_result));
    }

    if($act == 'vote')  //投票
    {
        if(date('Y-m-d H:i:s') > date('2015-10-21 00:00:00'))
        {
            $ajax_result['errcode'] = 1005;
            $ajax_result['errmsg'] = "投票已截止";
            die(json_encode($ajax_result));
        }
        $id = trim($_REQUEST['id']);

        $check_sql = "select is_vote from {$table} where openid='{$_SESSION['jptp_openid']}'";
        $check_res = mysqli_query($db,$check_sql);
        $check_row = $check_res->fetch_assoc();
        if($check_row['is_vote'] >= 3)
        {
            $ajax_result['errcode'] = 1004;
            $ajax_result['errmsg'] = "您已超过投票次数限制啦，明天再来吧！";
            die(json_encode($ajax_result));
        }

        $vote_sql = "update {$table} set vote=vote+1 where id={$id}";
        mysqli_query($db,$vote_sql);

        $is_vote_sql = "update {$table} set is_vote=is_vote+1,vote_time='".time()."' where openid='{$_SESSION['jptp_openid']}'";
        mysqli_query($db,$is_vote_sql);

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "投票成功！";
        die(json_encode($ajax_result));

    }

    if($act == 'rank')  //排行榜(3个)
    {
        $type = trim($_REQUEST['type']);

        $sql = "select id,name,vote from {$table} where type={$type} and vote>0 order by vote desc limit 10";

        $res = mysqli_query($db,$sql);
        
        $rows = array();
        $j = 0;
        $i = 1;
        while($row = $res->fetch_assoc())
        {
            $rows[$j] = $row;
            $rows[$j]['num'] = $i;
            $i++;
            $j++;
        }

        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = $rows;
        die(json_encode($ajax_result));
    }
}

?>