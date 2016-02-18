<?php
// error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$db = mysqli_connect("localhost","root","") or die("database connection failed");
//$db = mysqli_connect("112.124.16.103","zhuanti","yatai3.14159") or die("database connection failed");
mysqli_select_db($db, "zt");
mysqli_query($db, 'set names "utf8"');
define('site_url', 'http://local.zt');
session_start();
date_default_timezone_set('PRC'); //设置本地时区
?>