<?php
define('ROOT_PATH', dirname(__FILE__));
require(ROOT_PATH . '../../../data/config.php');
require(ROOT_PATH . '../../../data/secre.php');
$table = 'game_oumei_ddp';
if($_POST) 
{
    

	$act = trim($_POST['act']);
    if(empty($_SESSION['oumei_ddp_openid']))
    {
        $ajax_result['errcode'] = 1000;
        $ajax_result['errmsg'] = "参数异常，请退出重试！";
        die(json_encode($ajax_result));
    }

    if($act == "add")   //提交分数
    {
        if(date('Y-m-d H:i:s') < '2015-11-10 23:59:59')
        {
            $score = intval(decrypt(trim($_REQUEST['score'])));
            
            $check_sql = "select score from {$table} where openid='{$_SESSION['oumei_ddp_openid']}'";
            $check_res = mysqli_query($db,$check_sql);
            $check_row = $check_res->fetch_assoc();
            if(empty($check_row))
            {
                $ajax_result['errcode'] = 1002;
                $ajax_result['errmsg'] = "非法用户";
                die(json_encode($ajax_result));
            }

            if($check_row['score'] < $score)
            {
                $sql = "update {$table} set score={$score},last_time='" . date('Y-m-d H:i:s') . "' where score<{$score} and openid='" . $_SESSION['oumei_ddp_openid'] . "'";
                mysqli_query($db, $sql);
            }
        }
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = "您的分数已提交！";
        die(json_encode($ajax_result));
        
    }

    if($act == 'rank')  //排行榜
    {
        $sql = "select id,nickname,score from {$table} where score>0 and is_close=0 order by score desc limit 15";

        $res = mysqli_query($db,$sql);
        
        $tmp = array();
        $j = 0;
        $i = 1;
        while($row = $res->fetch_assoc())
        {
            if($i == 1)
            {
                $tmp[$j]['nickname'] = mb_substr($row['nickname'],0,2,'utf-8') . "**";
                $tmp[$j]['score'] = $row['score'];
                $tmp[$j]['rank'] = '一等奖';
            }
            elseif($i == 2)
            {
                $tmp[$j]['nickname'] = mb_substr($row['nickname'],0,2,'utf-8') . "**";
                $tmp[$j]['score'] = $row['score'];
                $tmp[$j]['rank'] = '二等奖';
            }
            elseif($i == 3)
            {
                $tmp[$j]['nickname'] = mb_substr($row['nickname'],0,2,'utf-8') . "**";
                $tmp[$j]['score'] = $row['score'];
                $tmp[$j]['rank'] = '三等奖';
            }
            else
            {
                $tmp[$j]['nickname'] = mb_substr($row['nickname'],0,2,'utf-8') . "**";
                $tmp[$j]['score'] = $row['score'];
                $tmp[$j]['rank'] = '四等奖';
            }

            $i++;
            $j++;

        }
        
        $rows['list'] = $tmp;
        $ajax_result['errcode'] = 0;
        $ajax_result['errmsg'] = $rows;
        die(json_encode($ajax_result));
    }
}

?>