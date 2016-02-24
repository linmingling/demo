<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/1
 * Time: 17:08
 */
$this->table = 'tc_user_admin';

// get 请求
if(isGet())
{
    // 已登录
	if(checkIsLogin()) {
		unset($_SESSION['expiretime']);
		header('Location:' . $app->C['baseUrl'] . '/admin/index.php?m=dashboard');
	}
    else {
        // 尚未登录
        
    }
}
else {// post 或其他请求 
	if(checkIsLogin()) {
		
	}
    $this->view->display('index.html');
}