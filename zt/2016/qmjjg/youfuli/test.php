<?php
define('ROOT_PATH', dirname(__FILE__));
define('LOCK_FILE_PATH', ROOT_PATH . '../../../../data/lockFile');


//�ļ�д�룬�����ھʹ���
$fp = fopen( LOCK_FILE_PATH . '/lock_youfili.txt', "a" );	

if (!$fp) {			
	echo "Failed to create the lock file!";
	exit(1);//�쳣����
}

flock($fp,LOCK_EX);
fwrite($fp,"\r\n1111------".date('Y-m-d H:i:s')."------");
sleep(5);	
fwrite($fp,date('Y-m-d H:i:s'));

flock($fp,LOCK_UN);
fclose($fp);
?>