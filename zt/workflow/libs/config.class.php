<?php
class Conf
{
    private $__files;
	private $__defaultFile;
	private  $__pathList;
	public  $config = array();
	public $configDir;
	
	public function __construct()
	{
		$this->configDir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'config' . DIRECTORY_SEPARATOR;
		$this->__defaultFile = $this->configDir . 'config.php';
	}
	
	public function __set($name, $val)
	{
		if(isset( $this->config[$name] )) {
			$this->config[$name] = $val;
		}
	}
	
	public function __get($name)
	{
		if(isset( $this->config[$name] )) {
			return $this->config[$name];
		}		
	}
	
	public function load($path = null)
	{
		if(is_file($path)) {//1: 用户设置是否文件
			$this->__pathList[] = $path;
		}
		elseif(is_dir($path)) {//2: 没有则用户设置是否目录
			$fileList = $this->showDir( $path );
			if(is_array($fileList)) {
				foreach($fileList as $file) {
					$this->__pathList[] =  $file;
				}
			}
		}
		elseif(is_dir($this->configDir)) {//3: 没有则默认配置文件目录
			$fileList = $this->showDir( $this->configDir );
			if(is_array($fileList)) {
				foreach($fileList as $file) {
					$this->__pathList[] =  $file;
				}
			}
		}
		elseif(is_file($this->__defaultFile)) {//4: 没有则默认配置文件
			$this->__pathList[] = $this->__defaultFile;
		}
		else {//5: 没有读取到任何配置文件
			return false;
		}

		if(is_array( $this->__pathList )) {
			foreach($this->__pathList as $path) {
				$configArr = @include($path);
				$this->config = array_merge( $this->config ,$configArr);
			}
		}
	}
	
	public function showDir( $filedir, $filter = 'config') 
	{
		$files = array();
		$dir = @ dir($filedir);
		while (($file = $dir->read())!==false)  
		{  
			if(is_dir($filedir."/".$file) AND ($file!=".") AND ($file!="..")) {  
			   $this->showDir($filedir."/".$file);  
			} 
			else {  
				if(($file!=".") AND ($file!="..")) {
					if($filter) {
						if(strpos($file, $filter)!== FALSE) {
							$files[] = $filedir . DIRECTORY_SEPARATOR . $file;
						}
					}else {
						$files[] = $filedir . DIRECTORY_SEPARATOR . $file;
					}
				}
			}  
		}  
		$dir->close(); 
		return $files;
	}
}