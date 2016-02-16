<?php
define('ROOT_PATH', dirname(__FILE__));
define('LOCK_FILE_PATH', ROOT_PATH . '../../../../data/lockFile');


//文件写入，不存在就创建
$fp = fopen( LOCK_FILE_PATH . '/lock_youfili.txt', "a" );	

if (!$fp) {			
	echo "Failed to create the lock file!";
	exit(1);//异常处理
}

flock($fp,LOCK_EX);
fwrite($fp,"\r\n1111------".date('Y-m-d H:i:s')."------");
sleep(5);	
fwrite($fp,date('Y-m-d H:i:s'));

flock($fp,LOCK_UN);
fclose($fp);
?>