<?php
/**
 * Created by PhpStorm.
 * User: tc
 * Date: 2015/12/3
 * Time: 10:00
 */
require(ROOT_PATH . DS . 'libs' . DS . 'user.func.php');
require(ROOT_PATH . DS . 'libs' . DS . 'Role.class.php');
require(ROOT_PATH . DS . 'libs' . DS . 'privilegedUser.class.php');

//die(json_encode(array('m'=>'user','s'=>'add')));

//$aa = new PrivilegedUser;
//$bb = $aa->getByUsername('张1');

// 验证登录
if(checkIsLogin() == 0 && $request['s']!=='login') {
    header('Location:' . $app->C['baseUrl'] . '/admin/index.php?m=user&s=login');
} else
{
	$userInfo = array();
	$userInfo['name'] = isset($_SESSION['adminUser'])?$_SESSION['adminUser']:'';
	$config['user_id'] = isset($_SESSION['userId'])?$_SESSION['userId']:'';
	$app->view->assign('user', $userInfo);
}
$app->view->assign('breadCrumbs', getBreadCrumbs( $app->C['baseUrl'] ));


// 验证权限
// 获取菜单
function getBreadCrumbs( $baseUrl )
{
    $i = 1;
    $urls = array();
    $urlParam = convertUrlQuery('http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    if(is_array($urlParam)) {
        $url = null;
        $cur_url = null;
        $urls[] = '<a href="'. $baseUrl .'">index</a>';
        foreach($urlParam as $k=>$param) {
            $url .= $k . '=' . $param . '&';
            $cur_url = $baseUrl . '/admin/index.php?' . substr($url, 0, -1);
            $urls[] = '<a href="'. $cur_url .'">' . $param . '</a>';
            $i++;
        }
    }
    return $urls;
}

