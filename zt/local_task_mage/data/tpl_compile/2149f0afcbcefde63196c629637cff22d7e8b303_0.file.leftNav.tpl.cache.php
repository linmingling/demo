<?php /* Smarty version 3.1.27, created on 2015-12-07 13:57:59
         compiled from "E:\wamp\www\workflow\template\admin\layout\leftNav.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:2459856651fe7969a82_74003294%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2149f0afcbcefde63196c629637cff22d7e8b303' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\admin\\layout\\leftNav.tpl',
      1 => 1449467877,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2459856651fe7969a82_74003294',
  'variables' => 
  array (
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_56651fe79aff98_98293393',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56651fe79aff98_98293393')) {
function content_56651fe79aff98_98293393 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '2459856651fe7969a82_74003294';
?>
<div class="sidebar" id="sidebar">
<?php echo '<script'; ?>
 type="text/javascript">
    try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
<?php echo '</script'; ?>
>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="icon-signal"></i>
        </button>

        <button class="btn btn-info">
            <i class="icon-pencil"></i>
        </button>

        <button class="btn btn-warning">
            <i class="icon-group"></i>
        </button>

        <button class="btn btn-danger">
            <i class="icon-cogs"></i>
        </button>
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
    </div>
</div><!-- #sidebar-shortcuts -->
<ul class="nav nav-list">
<li class="active">
    <a href="">
        <i class="icon-dashboard"></i>
        <span class="menu-text"> 控制台 </span>
    </a>
</li>

<li>
    <a href="" class="dropdown-toggle">
        <i class="icon-edit"></i>
        <span class="menu-text"> 用户 </span>
        <b class="arrow icon-angle-down"></b>
    </a>

    <ul class="submenu">
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=user&s=mage&a=list">
                <i class="icon-double-angle-right"></i>
                用户列表
            </a>
        </li>
		
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=user&s=mage&a=add">
                <i class="icon-double-angle-right"></i>
                添加用户
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="" class="dropdown-toggle">
        <i class="icon-edit"></i>
        <span class="menu-text"> 任务 </span>
        <b class="arrow icon-angle-down"></b>
    </a>

    <ul class="submenu">
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=task&s=mage&a=list">
                <i class="icon-double-angle-right"></i>
                任务列表
            </a>
        </li>
		
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=task&s=mage&a=add">
                <i class="icon-double-angle-right"></i>
                添加任务
            </a>
        </li>
		
        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=task&s=mage&a=tassign">
                <i class="icon-double-angle-right"></i>
                指派任务
            </a>
        </li>

        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=task&s=mage&a=my_task&to=1">
                <i class="icon-double-angle-right"></i>
                指派给我的任务
            </a>
        </li>

        <li>
            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=task&s=mage&a=my_task&from=1">
                <i class="icon-double-angle-right"></i>
                我指派的任务
            </a>
        </li>
    </ul>
</li>


</ul><!-- /.nav-list -->

<div class="sidebar-collapse" id="sidebar-collapse">
    <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
</div>

<?php echo '<script'; ?>
 type="text/javascript">
    try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
<?php echo '</script'; ?>
>
</div>
<?php }
}
?>