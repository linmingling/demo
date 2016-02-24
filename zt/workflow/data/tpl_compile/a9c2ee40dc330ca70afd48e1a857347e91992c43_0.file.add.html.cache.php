<?php /* Smarty version 3.1.27, created on 2015-12-01 08:41:17
         compiled from "E:\wamp\www\workflow\template\user\org\add.html" */ ?>
<?php
/*%%SmartyHeaderCode:8800565d4f1df39d74_40084604%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a9c2ee40dc330ca70afd48e1a857347e91992c43' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\user\\org\\add.html',
      1 => 1448955675,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8800565d4f1df39d74_40084604',
  'variables' => 
  array (
    'config' => 0,
    'currentUrl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_565d4f1e032304_99340982',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_565d4f1e032304_99340982')) {
function content_565d4f1e032304_99340982 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '8800565d4f1df39d74_40084604';
echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('title'=>'foo'), 0);
?>

<form name="input" action="<?php echo $_smarty_tpl->tpl_vars['currentUrl']->value;?>
" method="POST">
    Username:
    <input type="text" name="org_name" />
    <input type="submit" value="Submit" />
</form>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>