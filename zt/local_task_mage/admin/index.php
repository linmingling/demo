<?php
// 初始化框架
session_start();
require('../bootstrap.php');
$controller = new Bootstrap;
$controller->start();

// 验证登录
// 验证权限