<?php /* Smarty version 3.1.27, created on 2015-12-05 21:46:18
         compiled from "D:\phpEnv\www\workflow\template\admin\user\mage\add.html" */ ?>
<?php
/*%%SmartyHeaderCode:48615662eaaab62c99_56570177%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '794eff39b4b5be9e0a0a4eba2f790c9794c04f23' => 
    array (
      0 => 'D:\\phpEnv\\www\\workflow\\template\\admin\\user\\mage\\add.html',
      1 => 1449211055,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '48615662eaaab62c99_56570177',
  'variables' => 
  array (
    'config' => 0,
    'groups' => 0,
    'group' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5662eaaabbca27_91430967',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5662eaaabbca27_91430967')) {
function content_5662eaaabbca27_91430967 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '48615662eaaab62c99_56570177';
echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('title'=>'foo'), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/topNav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('title'=>'foo'), 0);
?>

<!-- container begin-->
<div class="main-container" id="main-container">
    <?php echo '<script'; ?>
 type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    <?php echo '</script'; ?>
>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <!--left nav begin-->
        <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/leftNav.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('title'=>'foo'), 0);
?>

        <!-- left nav end-->

        <div class="main-content">
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
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="#">Home</a>
                    </li>

                    <li>
                        <a href="#">Tables</a>
                    </li>
                    <li class="active">Simple &amp; Dynamic</li>
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
            </div>

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        Tables
                        <small>
                            <i class="icon-double-angle-right"></i>
                            Static &amp; Dynamic Tables
                        </small>
                    </h1>
                </div>
                <!-- /.page-header -->
                <div class="row">
                <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                <form class="form-horizontal" id="form-horizontal" role="form" action="<?php echo $_smarty_tpl->tpl_vars['config']->value['sUrl'];?>
&a=add" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 用户名 </label>
                        <div class="col-sm-9">
                            <input type="text" id="form-field-1" name="userName" placeholder="用户名" class="col-xs-10 form-field-username col-sm-5">
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-2">  手机号码</label>

                        <div class="col-sm-9">
                            <input type="text" id="form-field-2" name="phone" placeholder="手机号码" class="col-xs-10 col-sm-5 form-field-2">
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-3">  邮箱</label>

                        <div class="col-sm-9">
                            <input type="text" id="form-field-3" name="email" placeholder="邮箱" class="col-xs-10 col-sm-5 form-field-3">
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right " for="form-field-select1"> 部门 </label>

                        <div class="col-sm-9">
                            <select class="form-control input-medium form-field-select-1" name="group_id" id="form-field-select1">
                                <?php if ($_smarty_tpl->tpl_vars['groups']->value) {?>
                                    <?php
$_from = $_smarty_tpl->tpl_vars['groups']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['group'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['group']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['group']->value) {
$_smarty_tpl->tpl_vars['group']->_loop = true;
$foreach_group_Sav = $_smarty_tpl->tpl_vars['group'];
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['group']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</option>
                                     <?php
$_smarty_tpl->tpl_vars['group'] = $foreach_group_Sav;
}
if (!$_smarty_tpl->tpl_vars['group']->_loop) {
?>
                                        <option value="0">无</option>
                                    <?php
}
?>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-info btn_submit" type="button">
                                <i class="icon-ok bigger-110"></i>
                                提交
                            </button>
                        </div>
                    </div>
                </form>
                </div><!-- /span -->
                </div><!-- /row -->
            </div>
            <!-- /.page-content -->
        </div>
        <!-- /.main-content -->
    </div>
    <!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div>
<!-- container end-->
 <!--start scripts-->
<!-- basic scripts -->

<!--[if !IE]> -->

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-2.0.3.min.js"><?php echo '</script'; ?>
>

<!-- <![endif]-->

<!--[if IE]>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-1.10.2.min.js"><?php echo '</script'; ?>
>
<![endif]-->

<!--[if !IE]> -->

<?php echo '<script'; ?>
 type="text/javascript">
    window.jQuery || document.write("<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-2.0.3.min.js'>"+"<"+"/script>");
<?php echo '</script'; ?>
>

<!-- <![endif]-->

<!--[if IE]>
<?php echo '<script'; ?>
 type="text/javascript">
    window.jQuery || document.write("<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-1.10.2.min.js'>"+"<"+"/script>");
<?php echo '</script'; ?>
>
<![endif]-->

<?php echo '<script'; ?>
 type="text/javascript">
    if("ontouchend" in document) document.write("<?php echo '<script'; ?>
 src='<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.mobile.custom.min.js'>"+"<"+"/script>");
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/typeahead-bs2.min.js"><?php echo '</script'; ?>
>

<!-- page specific plugin scripts -->

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.dataTables.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.dataTables.bootstrap.js"><?php echo '</script'; ?>
>

<!-- ace scripts -->

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/ace-elements.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/ace.min.js"><?php echo '</script'; ?>
>

<!-- inline scripts related to this page -->

<?php echo '<script'; ?>
 type="text/javascript">
    jQuery(function($) {
        var oTable1 = $('#sample-table-2').dataTable( {
            "aoColumns": [
                { "bSortable": false },
                null, null,null, null, null,
                { "bSortable": false }
            ] } );


        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function(){
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });

        });

        $(".btn_submit").click(function(){
            var field1 = $("#form-field-1").val();
            var field2 = $("#form-field-2").val();
            var field3 = $("#form-field-3").val();
            var select1 = $("#form-field-select-1").val();
            var validateStatu = new Array();

            if(field1=='') {
                alert("姓名为必填");
                validateStatu.push(1);
            }

            if(validateStatu.length>=1) {
                return false;
            }
            else {
                document.getElementById('form-horizontal').submit();
            }
        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }
    })
<?php echo '</script'; ?>
>
<!-- end scripts-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>