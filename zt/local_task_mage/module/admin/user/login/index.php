<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/1
 * Time: 17:08
 */
$this->table = 'tc_user_admin';

if(isPost())
{
    // 是否已登录
	if(checkIsLogin()) {
		$json['error_code'] = 0;
		$json['rUrl'] = $app->C['baseUrl'] . '/admin/index.php?m=dashboard';
		$json['message'] = '登录成功，正在跳转...';
		die(json_encode( $json ));		
	}
    else {
        // 登录流程
        if(!isset($request['userName'])) {
            $json['error_code'] = 1000;
            $json['message'] = '请输入用户名!';
            die(json_encode( $json ));
        }

        if(!isset($request['passWord'])) {
            $json['error_code'] = 1000;
            $json['message'] = '请输入密码!';
            die(json_encode( $json ));
        }

        // 过滤用户名和密码
        $request['userName'] = addslashes($request['userName']);
        $request['passWord'] = addslashes($request['passWord']);

        // 登录验证
        $this->db->where ("username", $request['userName']);
        $this->db->where ("password", md5($request['passWord']));
        $this->db->where ("state", 1);
        $rsData = $this->db->getOne ($this->table, 'id,user_id');

        // 登录成功
        if($rsData['id']) {
            $_SESSION['adminUser'] = $request['userName'];

            // 查询user 表中id 和姓名
            $this->db->where ("id", $rsData['user_id']);
            $userData = $this->db->getOne ('tc_user', 'id,name');

            if($userData) {
               // $_SESSION['userId'] = $userData['id'];
                $_SESSION['userId'] = $rsData['user_id'];
                $_SESSION['userName'] = $userData['name'];
            }

            addSessionTime(3600);
			$json['error_code'] = 0;
			$json['rUrl'] = $app->C['baseUrl'] . '/admin/index.php?m=dashboard';
            $json['message'] = '登录成功，正在跳转...';
			die(json_encode( $json ));
        }
        else {
            $json['error_code'] = 1001;
            $json['message'] = '用户名或密码错误!';
            die(json_encode( $json ));
        }
    }
}
else {
	if(checkIsLogin()) {
		//header('Location:' . $app->C['baseUrl'] . '/admin/index.php?m=dashboard');
	}
    $this->view->display('index.html');
}