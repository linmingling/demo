<?php /* Smarty version 3.1.27, created on 2015-12-05 21:45:33
         compiled from "D:\phpEnv\www\workflow\template\admin\layout\topNav.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:317035662ea7dca0e05_02499669%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3a543edbe4d994c867df622d838724780da420f' => 
    array (
      0 => 'D:\\phpEnv\\www\\workflow\\template\\admin\\layout\\topNav.tpl',
      1 => 1449323132,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317035662ea7dca0e05_02499669',
  'variables' => 
  array (
    'config' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5662ea7dccfc17_28114669',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5662ea7dccfc17_28114669')) {
function content_5662ea7dccfc17_28114669 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '317035662ea7dca0e05_02499669';
?>
<div class="navbar navbar-default" id="navbar">
<?php echo '<script'; ?>
 type="text/javascript">
    try{ace.settings.check('navbar' , 'fixed')}catch(e){}
<?php echo '</script'; ?>
>

<div class="navbar-container" id="navbar-container">
<div class="navbar-header pull-left">
    <a href="#" class="navbar-brand">
        <small>
            <i class="icon-leaf"></i>
            任务管理后台
        </small>
    </a><!-- /.brand -->
</div><!-- /.navbar-header -->

<div class="navbar-header pull-right" role="navigation">
    <ul class="nav ace-nav" style="height: auto">
        <li class="light-blue">
            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<?php echo $_smarty_tpl->tpl_vars['config']->value['imageUrl'];?>
/user.jpg" alt="Jason's Photo">
			<span class="user-info">
				<small>欢饮您,</small>
				<?php if ($_smarty_tpl->tpl_vars['user']->value['name']) {?>
					<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>

				<?php }?>
			</span>

                <i class="icon-caret-down"></i>
            </a>

            <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                <!--
                <li>
                    <a href="#">
                        <i class="icon-cog"></i>
                        Settings
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="icon-user"></i>
                        Profile
                    </a>
                </li>

                <li class="divider"></li>
                -->
                <li>
                    <a href="#">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
/index.php?m=user&s=login&a=loginout">退出登录</a>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</div><!-- /.navbar-header -->
</div><!-- /.container -->
</div><?php }
}
?>