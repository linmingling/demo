<?php /* Smarty version 3.1.27, created on 2015-12-07 09:37:11
         compiled from "E:\wamp\www\workflow\template\admin\layout\topNav.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:30655664e2c787f361_49948737%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '222cfaa6d2db5152da4494368ccf8fc89004fad5' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\admin\\layout\\topNav.tpl',
      1 => 1449323132,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30655664e2c787f361_49948737',
  'variables' => 
  array (
    'config' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5664e2c78cd576_01697537',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5664e2c78cd576_01697537')) {
function content_5664e2c78cd576_01697537 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '30655664e2c787f361_49948737';
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