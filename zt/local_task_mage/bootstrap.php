<?php
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ALL);
ini_set("display_errors", "On");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__));
define('DEVELOP', true);//开发模式
require(ROOT_PATH . DS . 'libs' . DS . 'config.class.php');
require(ROOT_PATH . DS . 'libs' . DS . 'smarty' . DS . 'Smarty.class.php');
date_default_timezone_set("Asia/Shanghai");

class Bootstrap
{
	// config 对象
	protected $__conf;
	
	public $C;

    public $templateName;

	public $db;

    private $_tmp;

    public $table;

	// 模型名称
	protected $_module;
	
	// 控制器名称
	protected $_controller;
	
	// 动作名称
	protected $_action;
	
	// 控制器路径
	protected $_controllerPath;
	
	// 模板路径
	protected $_template_dir;
	
	// 当前请求对应的模板
	protected $_template;
	
	// 魔板名称
	protected $_templateName;
	
	public $view;
	
	//初始值
	public function __construct()
	{

	}

    public function  __get( $name )
    {
         if(isset($this->_tmp[$name])) {
             return $this->_tmp[$name];
         }
        return false;
    }

    public function __set($name, $value)
    {
        $this->_tmp[$name] = $value;
    }

	//初始化框架
	public function start()
	{
        $config = null;
		$request = $_REQUEST;
        $templateSuffix = '.html';
        $layoutSuffix = '.tpl';
        // 添加前端和后端控制
        $controllerName = 'frontEnd' . DS;//默认为前端控制器
        $adminName = 'admin';
        $requestUrl = strtolower($_SERVER['REQUEST_URI']);
        if(stripos($requestUrl, $adminName)!==FALSE) {
            $controllerName = $adminName . DS;
        }

		$this->_module = isset($request['m'])?$request['m']:'default';//模块名称
		$this->_controller = isset($request['s'])?$request['s']:'index';//请求控制器文件
		$this->_action = isset($request['a'])?$request['a']:'index';//请求动作
		$this->_controllerPath = ROOT_PATH . DS . 'module' . DS . $controllerName .  $this->_module  . DS . $this->_controller . DS;

		//定义魔板路径
		$this->_template_dir = ROOT_PATH . DS . 'template' . DS . $controllerName . $this->_module  . DS . $this->_controller . DS;//魔板目录
		$this->_template = (isset($request['ajax']) || isset($request['callback']))?$this->_template_dir . $this->_action .'.json.'. $templateSuffix
                                                                                          :$this->_template_dir . $this->_action  . $templateSuffix;//魔板文件绝对路径
        $config ['template'] = $this->_templateName = (isset($request['ajax']) || isset($request['callback']))? $this->_action .'.json.'. $templateSuffix
                                                                                            :  $this->_action . $templateSuffix;//魔板文件名称
		//ajax 请求处理
		$file = (isset($request['ajax']) || isset($request['callback']))?$this->_controllerPath . $this->_action . '_ajax.php':$this->_controllerPath . $this->_action . '.php';

		//非ajax 请求处理
		if(is_dir($this->_controllerPath)) {
			$this->__conf = new Conf;
			$this->__conf->load();

			$this->C = & $this->__conf->config;
			//载入本模块公共父类 后期实现
			//载入公用控制器 后期实现
			//载入config     后期实现
			if(file_exists($file)){
				$this->loadCommonClass();

				/*初始化数据库*/
				$this->db = new MysqliDb(
								$this->C['dbHost'],
								$this->C['dbUser'],
								$this->C['dbPassWord'],
								$this->C['dbName'],
								$this->C['dbPort']
				);

                /*
                 * lyout 管理
                 */
                if(is_dir(ROOT_PATH . DS . 'template' . DS . $controllerName . 'layout')) {
                    $this->C['layout'] = ROOT_PATH . DS . 'template' . DS . $controllerName .'layout';
                }

				/*初始化魔板*/
                $this->view = new Smarty;
                $config ['template_dir'] = $this->view->template_dir = $this->_template_dir;
				$config ['cache_dir'] = $this->view->cache_dir = ROOT_PATH . DS . 'data/tpl_cache';
				$config ['compile_dir'] = $this->view->compile_dir = ROOT_PATH . DS . 'data/tpl_compile';
                $config ['config_dir'] = $this->view->config_dir = ROOT_PATH . DS . 'config/';
                $config ['baseUrl'] = $this->C['baseUrl'];
                $config ['controllerUrl'] = $this->C['baseUrl'] .'/'. substr($controllerName, 0,-1);
                $config ['mUrl'] = $this->C['baseUrl'] .'/'. $controllerName . 'index.php?m=' . $this->_module;
                $config ['sUrl'] = $this->C['baseUrl'] .'/'. $controllerName . 'index.php?m=' . $this->_module .'&s='. $this->_controller;

				$config ['publicUrl'] = $this->C['publicUrl'] . substr($controllerName, 0,-1);
				$config ['caching'] = $this->view->caching = ROOT_PATH . DS . 'data/tpl_cache';
                $config ['imageUrl'] = $this->C['publicUrl'] . $controllerName . 'images';
                $config ['cssUrl'] = $this->C['publicUrl'] . $controllerName . 'css' . DS;
				$config ['jsUrl'] = $this->C['publicUrl'] . $controllerName . 'js';
                $config['currentUrl'] = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$this->view->left_delimiter="<{";
				$this->view->right_delimiter="}>";
                $config ['layout'] = $this->C['layout'];
                $config ['imageUrl'] = str_replace('\\','/', $config ['imageUrl']);
				$basepath=$_SERVER['PHP_SELF'];

                $request = $_REQUEST;
				$app = & $this;

                $GLOBALS['db'] = $this->db;

                //登录通用页面
                if(stripos($requestUrl, $adminName)!==FALSE) {
                    $adminCommonFile = ROOT_PATH . DS . 'module' . DS . $controllerName . DS . 'common' . DS . 'common.php';
                    if (file_exists($adminCommonFile)) {
                        include($adminCommonFile);
                    }
                }

                $this->view->assign('config', $config );
                $this->view->assign('currentUrl', 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

                include($file);
			}
			else { // 目录不存在下一步操作
				die('<br/>'. $file .' 文件不存在,请检查!');
			}
		}
		else { // 没有PHP文件的请求
			if(DEVELOP === true && isset($_GET['auto_creat'])) {// 调试模式，自动创建目录和文件
				Directory($this->_controllerPath);
				echo '<br/>请求文件路径已创建成功!';
				
				// 处理魔板文件
				if(!is_dir($template_dir)) {
					Directory($template_dir);
					die('<br/>魔板路径已创建成功!');			
				}
				else {
					echo '<br/>请求的文件:' . $this->_controllerPath . '不存在' . '! --- 已有魔板文件夹:' . $template_dir;
				}
			}
			else {
				die('<br/>您请求的文件:' . $file . '不存在!' );
			}
		}
		
	}
	
	// 动态加载框架必须的类文件,后期可以考虑读取缓存
	public function loadCommonClass()
	{
		$files = $this->__conf->showDir( ROOT_PATH . DS . 'libs' . DS . 'core' . DS, $filter = false);
		if(is_array($files)) {
			foreach($files as $file) {
				include($file);
			}
		}
	}
	
	//结束
	public function end()
	{}
}