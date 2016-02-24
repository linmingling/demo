<?php /* Smarty version 3.1.27, created on 2015-12-05 21:23:48
         compiled from "D:\phpEnv\www\workflow\template\admin\layout\header.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:11625662e5640fda37_92637212%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e569be19a36258e1736c0d6babb73c123fe82b7' => 
    array (
      0 => 'D:\\phpEnv\\www\\workflow\\template\\admin\\layout\\header.tpl',
      1 => 1449223700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11625662e5640fda37_92637212',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5662e56410d430_28955831',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5662e56410d430_28955831')) {
function content_5662e56410d430_28955831 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '11625662e5640fda37_92637212';
?>
<HTML>
<head>
		<meta charset="utf-8" />
		<title>Bootstrap表格插件 - Bootstrap后台管理系统模版Ace下载</title>
		<meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
		<meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<!--<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />-->

		<!-- ace styles -->

        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/css.css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/ace-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/js/ace-extra.min.js"><?php echo '</script'; ?>
>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/js/html5shiv.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['publicUrl'];?>
/js/respond.min.js"><?php echo '</script'; ?>
>
		<![endif]-->
	</head>

<BODY bgcolor="#ffffff">
<?php }
}
?>