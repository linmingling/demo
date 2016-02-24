<?php
function  Directory( $dir ){    
     return   is_dir ( $dir )  or  (Directory(dirname( $dir ))  and   mkdir ( $dir , 0777));
} 

/**
 * 是否是AJAX提交的
 */
function isAjax(){
  if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    return true;
  }else{
    return false;
  }
}

/**
 * 是否是GET提交的
 */
function isGet(){
  return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

/**
 * 是否是POST提交
 * @return int
 */
// && checkurlHash($GLOBALS['verify'])
function isPost() {
  return ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? 1 : 0;
}