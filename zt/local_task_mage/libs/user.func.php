<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/3
 * Time: 10:11
 */

function checkIsLogin()
{
    if(isset($_SESSION['expiretime'])) {
        if($_SESSION['expiretime'] < time()) {
            unset($_SESSION['expiretime']);
			unset($_SESSION['adminUser']);
			unset($_SESSION['userName']);
			unset($_SESSION['userId']);						
            //header('Location: logout.php?TIMEOUT'); // 登出
            return -1;
        } else {
            // 最后十分钟增加时间
            if(time() - $_SESSION['expiretime'] <= 600) {
				$time = 2400;
				addSessionTime($time);
            }
            return 1;
        }
    }
    else {
        return 0;
    }
}

function addSessionTime($time = 3600)
{
    setcookie(session_name(),session_id(),time()+$time,"/");
    $_SESSION['expiretime'] = time() + $time;
}

function listGroup()
{
    return  $GLOBALS['db']->get ("tc_organization",null,'id,name');
}