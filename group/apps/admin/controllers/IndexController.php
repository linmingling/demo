<?php
namespace Apps\Admin\Controllers;

class IndexController extends ControllerBase {
	
	public function initialize(){
		parent::initialize();
	}

    public function indexAction(){
        
        $gd = '不支持';
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        }
        $hostport = $_SERVER['SERVER_NAME']."($_SERVER[SERVER_ADDR]:$_SERVER[SERVER_PORT])";
        $mysql = function_exists('mysql_close') ? mysql_get_server_info() : '不支持';
        $info = array(
            'system' => PHP_OS,
            'hostport' => $hostport,
            'server' => $_SERVER['SERVER_SOFTWARE'],
            'php_env' => php_sapi_name(),
            'app_dir' => dirname(__FILE__),
            'mysql' => $mysql,
            'gd' => $gd,
            'upload_size' => ini_get('upload_max_filesize'),
            'exec_time' => ini_get('max_execution_time') . '秒',
            'disk_free' => round((@disk_free_space(".")/(1024 * 1024)),2).'M',
            'server_time' => date("Y-m-d H:i:s"),
            'beijing_time' => gmdate("Y-m-d H:i:s", time() + 8 * 3600),
            'reg_gbl' => get_cfg_var("register_globals") == '1'? 'ON' : 'OFF',
            'quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'quotes_runtime' => (1===get_magic_quotes_runtime()) ?'YES' : 'NO',
            'fopen' => ini_get('allow_url_fopen') ? '支持' : '不支持'
        );
        $this->view->setVar("info", $info);
    }
	
	public function regionsAction(){
		$this->view->disable();
		header('Content-type:application/json;charset=utf-8;');
		
		$pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if(!$pid && !$id) die(json_encode(array('state'=>0,'data'=>'参数错误')));
		
		$E = new \Library\Model\Ext();
		$info = $E->regions(array('id'=>$id,'pid'=>$pid));
		if($info){
			die(json_encode(array('state'=>1,'data'=>$info)));
		}
		die(json_encode(array('state'=>0,'data'=>'获取省市区信息失败')));
	}
    
    public function remove_cacheAction(){
        $dir = '../data/cache';
        $tips = $this->delFileUnderDir($dir);
        if($tips){
            $ajax_result['errcode'] = 0;
            $ajax_result['errmsg'] = $tips;
        } else {
            $ajax_result['errcode'] = 1000;
            $ajax_result['errmsg'] = "系统没有产生缓存文件，无需清除";
        }
        die(json_encode($ajax_result));
    }
    public function testAction(){
    
    }
    
    //循环目录下的所有文件
    function delFileUnderDir( $dirName ){
        $handle = opendir( "$dirName" );
        $tips = '';
        if ( $handle ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$dirName/$item" ) ) {
                        $this->delFileUnderDir( "$dirName/$item" );
                    } else {
                        if( unlink( "$dirName/$item" ) ){
                            $tips = "成功删除缓存文件";
                        } else {
                            $tips = '删除缓存文件失败';
                        }
                    }
                }
            }
        closedir( $handle );
        }
        return $tips;
    }
	
	
	//商品列表 模态框
	public function goodsAction(){
		$this->view->disable(); header('Content-type:application/json;charset=utf-8;');
		
		$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
		
		$catId = isset($_GET['catId']) ? $_GET['catId'] : 0;
		$keywords = isset($_GET['keyWords']) ? $_GET['keyWords'] : '';
		$goodsId = isset($_GET['goodsId']) ? $_GET['goodsId'] : 0;
		$allowAddress = isset($_GET['allowAddress']) ? $_GET['allowAddress'] : '';
		
		$M = new \Library\Model\Goods();
		
		$list = $M->lists(array('catId'=>$catId,'keyWords'=>$keywords,'goodsId'=>$goodsId,'allowAddress'=>$allowAddress,'page'=>($offset/$limit)+1,'limit'=>$limit));
		
		die(json_encode(array('total'=> $list['num'],'rows'=>$list['list'])));
	}
	
	/**
	 * 得到操作系统信息
	 * @return string
	 */
	function get_system() {
	    $sys = $_SERVER['HTTP_USER_AGENT'];
	
	    if (stripos($sys, "NT 6.1")) {
	        $os = "Windows 7";
	    } else if (stripos($sys, "NT 6.0")) {
	        $os = "Windows Vista";
	    }  else if (stripos($sys, "NT 5.1")) {
	        $os = "Windows XP";
	    } else if (stripos($sys, "NT 5.2")) {
	        $os = "Windows Server 2003";
	    } else if (stripos($sys, "NT 5")) {
	        $os = "Windows 2000";
	    } else if (stripos($sys, "NT 4.9")) {
	        $os = "Windows ME";
	    } else if (stripos($sys, "NT 4")) {
	        $os = "Windows NT 4.0";
	    } else if (stripos($sys, "98")) {
	        $os = "Windows 98";
	    } else if (stripos($sys, "95")) {
	        $os = "Windows 95";
	    } else if (stripos($sys, "Mac")) {
	        $os = "Mac";
	    } else if (stripos($sys, "Linux")) {
	        $os = "Linux";
	    } else if (stripos($sys, "Unix")) {
	        $os = "Unix";
	    } else if (stripos($sys, "FreeBSD")) {
	        $os = "FreeBSD";
	    } else if (stripos($sys, "SunOS")) {
	        $os = "SunOS";
	    } else if (stripos($sys, "BeOS")) {
	        $os = "BeOS";
	    } else if (stripos($sys, "OS/2")) {
	        $os = "OS/2";
	    } else if (stripos($sys, "PC")) {
	        $os = "Macintosh";
	    } else if(stripos($sys, "AIX")) {
	        $os = "AIX";
	    } else {
	        $os = "未知操作系统";
	    }
	
	    return $os;
	}
}
?>