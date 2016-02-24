<?php /* Smarty version 3.1.27, created on 2015-12-07 17:38:55
         compiled from "E:\wamp\www\workflow\template\admin\user\mage\list.html" */ ?>
<?php
/*%%SmartyHeaderCode:18405566553af8689c6_83134223%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac02e5e2c0b7169e79cfd5487ffefabc3be036ff' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\admin\\user\\mage\\list.html',
      1 => 1449481128,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18405566553af8689c6_83134223',
  'variables' => 
  array (
    'config' => 0,
    'data' => 0,
    'list' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_566553af94f171_47627287',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_566553af94f171_47627287')) {
function content_566553af94f171_47627287 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'E:\\wamp\\www\\workflow\\libs\\smarty\\plugins\\modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '18405566553af8689c6_83134223';
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
            <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/breadCrumbs.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array('title'=>'foo'), 0);
?>


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
                <div class="col-xs-12">
                <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th class="center">
                        <label>
                            <input type="checkbox" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </th>
                    <th>用户名</th>
                    <th>手机号</th>
                    <th class="hidden-480">部门</th>
                    <th>
                        <i class="icon-time bigger-110 hidden-480"></i>
                        创建时间
                    </th>
                    <th class="hidden-480">状态</th>

                    <th>用户类型</th>
                </tr>
                </thead>

                <tbody>
                <?php if ($_smarty_tpl->tpl_vars['data']->value) {?>
                    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['list'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['list']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
$foreach_list_Sav = $_smarty_tpl->tpl_vars['list'];
?>
                    <tr>
                        <td class="center">
                            <label>
                                <input type="checkbox" class="ace">
                                <span class="lbl"></span>
                            </label>
                        </td>

                        <td>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['config']->value['sUrl'];?>
&a=edit&uid=<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['list']->value['name'];?>
</a>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['list']->value['phone'];?>
</td>
                        <td class="hidden-480"><?php echo $_smarty_tpl->tpl_vars['list']->value['org_name'];?>
</td>
                        <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['list']->value['add_time'],"%Y, %m %d");?>
</td>

                        <td class="hidden-480">
                            <span class="label label-sm label-success">
                                <?php if ($_smarty_tpl->tpl_vars['list']->value['user_type']) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['list']->value['user_type'] == 1) {?>管理员<?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['list']->value['user_type'] == 2) {?>普通用户<?php }?>
                                <?php }?>
                            </span>
                        </td>

                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                <button class="btn btn-xs btn-success">
                                    <i class="icon-ok bigger-120"></i>
                                </button>

                                <button class="btn btn-xs btn-info">
                                    <i class="icon-edit bigger-120"></i>
                                </button>

                                <button class="btn btn-xs btn-danger">
                                    <i class="icon-trash bigger-120"></i>
                                </button>

                                <button class="btn btn-xs btn-warning">
                                    <i class="icon-flag bigger-120"></i>
                                </button>
                            </div>

                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                <div class="inline position-relative">
                                    <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <i class="icon-cog icon-only bigger-110"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                        <li>
                                            <a href="#" class="tooltip-info" data-rel="tooltip" title="" data-original-title="View">
                                                                                    <span class="blue">
                                                                                        <i class="icon-zoom-in bigger-120"></i>
                                                                                    </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="" data-original-title="Edit">
                                                                                    <span class="green">
                                                                                        <i class="icon-edit bigger-120"></i>
                                                                                    </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="" data-original-title="Delete">
                                                                                    <span class="red">
                                                                                        <i class="icon-trash bigger-120"></i>
                                                                                    </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
$_smarty_tpl->tpl_vars['list'] = $foreach_list_Sav;
}
if (!$_smarty_tpl->tpl_vars['list']->_loop) {
?>
                    没有数据!
                <?php
}
?>
                <?php }?>
                </tbody>
                </table>
                    <div class="row"><div class="col-sm-6">
                        <div class="dataTables_info" id="sample-table-2_info">Showing <?php echo $_smarty_tpl->tpl_vars['pager']->value['currentPage'];?>
 to <?php echo $_smarty_tpl->tpl_vars['pager']->value['limit'];?>
 of <?php echo $_smarty_tpl->tpl_vars['pager']->value['count'];?>
 entries</div></div>
                        <div class="col-sm-6"><div class="dataTables_paginate paging_bootstrap">
                            <ul class="pagination">
                                <?php echo $_smarty_tpl->tpl_vars['pager']->value['page'];?>

                            </ul>
                    </div>
                        </div>
                    </div>
                </div><!-- /.table-responsive -->
                </div>
                <!-- /.row -->
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