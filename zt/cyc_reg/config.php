<?php
// error_reporting(0);
header("Content-type: text/html; charset=utf-8");
$db = mysqli_connect("113.106.48.114","zhuanti","yatai3.14159") or die("database connection failed");
mysqli_select_db($db, "zhuanti");
mysqli_query($db, 'set names "utf8"');
define('site_url', 'http://local.zt');
session_start();
date_default_timezone_set('PRC'); //设置本地时区
?>