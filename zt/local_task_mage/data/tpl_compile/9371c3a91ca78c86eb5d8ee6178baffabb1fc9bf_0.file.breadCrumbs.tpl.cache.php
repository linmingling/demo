<?php /* Smarty version 3.1.27, created on 2015-12-07 17:45:00
         compiled from "E:\wamp\www\workflow\template\admin\layout\breadCrumbs.tpl" */ ?>
<?php
/*%%SmartyHeaderCode:109985665551cf2ab21_01047720%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9371c3a91ca78c86eb5d8ee6178baffabb1fc9bf' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\admin\\layout\\breadCrumbs.tpl',
      1 => 1449481497,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109985665551cf2ab21_01047720',
  'variables' => 
  array (
    'breadCrumbs' => 0,
    'list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5665551d036935_43950340',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5665551d036935_43950340')) {
function content_5665551d036935_43950340 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '109985665551cf2ab21_01047720';
?>
<div class="breadcrumbs" id="breadcrumbs">
    <?php echo '<script'; ?>
 type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed')
        } catch (e) {
        }
    <?php echo '</script'; ?>
>

    <ul class="breadcrumb" style="padding: 8px 15px;">
        <?php if ($_smarty_tpl->tpl_vars['breadCrumbs']->value) {?>
            <?php
$_from = $_smarty_tpl->tpl_vars['breadCrumbs']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['list'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['list']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
$foreach_list_Sav = $_smarty_tpl->tpl_vars['list'];
?>
                <?php if ((isset($_smarty_tpl->tpl_vars['__foreach_loop']->value['first']) ? $_smarty_tpl->tpl_vars['__foreach_loop']->value['first'] : null) == true) {?>
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>
                <?php } else { ?>
                <li>
                    <?php echo $_smarty_tpl->tpl_vars['list']->value;?>

                </li>
                <?php }?>
            <?php
$_smarty_tpl->tpl_vars['list'] = $foreach_list_Sav;
}
?>
        <?php }?>
    </ul>
    <!-- .breadcrumb -->

    <div class="nav-search" id="nav-search">
        <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input"
                                           id="nav-search-input" autocomplete="off">
									<i class="icon-search nav-search-icon"></i>
								</span>
        </form>
    </div>
    <!-- #nav-search -->
</div><?php }
}
?>