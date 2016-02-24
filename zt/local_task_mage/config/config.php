<?php
return array(
    'baseUrl'=>'http://'.$_SERVER['HTTP_HOST'] . '/' . 'workflow',
	'publicUrl'=>'http://'.$_SERVER['HTTP_HOST'] . DIRECTORY_SEPARATOR . 'workflow' . DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR,
	'rootPath'=>dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'template' . DIRECTORY_SEPARATOR,
	'publicDir'=>dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR
);