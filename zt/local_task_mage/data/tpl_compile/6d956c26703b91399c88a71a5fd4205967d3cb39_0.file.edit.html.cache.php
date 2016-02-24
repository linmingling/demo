<?php /* Smarty version 3.1.27, created on 2015-12-06 00:12:38
         compiled from "D:\phpEnv\www\workflow\template\admin\task\mage\edit.html" */ ?>
<?php
/*%%SmartyHeaderCode:2443356630cf6df7b69_18475088%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d956c26703b91399c88a71a5fd4205967d3cb39' => 
    array (
      0 => 'D:\\phpEnv\\www\\workflow\\template\\admin\\task\\mage\\edit.html',
      1 => 1449331957,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2443356630cf6df7b69_18475088',
  'variables' => 
  array (
    'config' => 0,
    'data' => 0,
    'taskStatus' => 0,
    'statu' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_56630cf6e74b81_70737142',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_56630cf6e74b81_70737142')) {
function content_56630cf6e74b81_70737142 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'D:\\phpEnv\\www\\workflow\\libs\\smarty\\plugins\\modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '2443356630cf6df7b69_18475088';
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

                <form class="form-horizontal" id="form-horizontal" role="form" action="<?php echo $_smarty_tpl->tpl_vars['config']->value['currentUrl'];?>
" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 任务名称 </label>
                        <div class="col-sm-9">
                            <input type="text" disabled="disabled" id="form-field-1" name="taskName" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['task_name'];?>
" placeholder="任务名称" class="col-xs-10 col-sm-5">
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-2">  任务详细介绍</label>

                        <div class="col-sm-9">
                            <textarea  cols="30"  type="text" id="form-field-2" name="taskDetail"  placeholder="任务详细介绍" class="col-xs-10 col-sm-5 form-field-2" style="height:75px"><?php echo $_smarty_tpl->tpl_vars['data']->value['description'];?>
</textarea>
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right" for="form-field-3">  达成目标/最终目标</label>

                        <div class="col-sm-9">
                            <textarea cols="30" type="text" id="form-field-3" name="taskTarget"  placeholder="达成目标/最终目标" class="col-xs-10 col-sm-5 form-field-3" style="height:75px"><?php echo $_smarty_tpl->tpl_vars['data']->value['target'];?>
</textarea>
						</div>
                    </div>
					<!--时间选择插件开始-->
					<div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right"  for="id-date-range-picker-1">任务开始时间</label>

                        <div class="col-sm-3">
						<div class="row">
							<div class="col-xs-8 col-sm-11">
								<div class="input-group">
									<input class="form-control date-picker" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value["start_time"],"%Y-%m-%d");?>
' name="taskStartTime" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd">
									<span class="input-group-addon">
										<i class="icon-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						</div>
                    </div>	
					<div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right" for="id-date-range-picker-1">任务结束时间</label>

                        <div class="col-sm-3">
						<div class="row">
							<div class="col-xs-8 col-sm-11">
								<div class="input-group">
									<input class="form-control date-picker"  name="taskEndTime" value='<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['data']->value["end_time"],"%Y-%m-%d");?>
' id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd">
									<span class="input-group-addon">
										<i class="icon-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						</div>
                    </div>	
					<div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right" for="id-date-range-picker-1">任务状态</label>

                        <div class="col-sm-3">
						<div class="row">
							<div class="col-xs-8 col-sm-11">
								<div class="input-group">
									<select name="taskStatu">	
										<?php if ($_smarty_tpl->tpl_vars['taskStatus']->value) {?>
											<?php
$_from = $_smarty_tpl->tpl_vars['taskStatus']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['statu'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['statu']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['statu']->value) {
$_smarty_tpl->tpl_vars['statu']->_loop = true;
$foreach_statu_Sav = $_smarty_tpl->tpl_vars['statu'];
?>
												<option value="<?php echo $_smarty_tpl->tpl_vars['statu']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['statu']->value['id'] == $_smarty_tpl->tpl_vars['data']->value['statu']) {?>selected = "selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['statu']->value['name'];?>
</option>
											<?php
$_smarty_tpl->tpl_vars['statu'] = $foreach_statu_Sav;
}
if (!$_smarty_tpl->tpl_vars['statu']->_loop) {
?>
												没有数据!
											<?php
}
?>	
										<?php }?>										
									</select>	
								</div>
							</div>
						</div>
						</div>
                    </div>						
					
					<!--时间选择插件结束-->
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


<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-ui-1.10.3.custom.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.ui.touch-punch.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/chosen.jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/fuelux/fuelux.spinner.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/date-time/bootstrap-datepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/date-time/bootstrap-timepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/date-time/moment.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/date-time/daterangepicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/bootstrap-colorpicker.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.knob.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.autosize.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.inputlimiter.1.3.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery.maskedinput.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/bootstrap-tag.min.js"><?php echo '</script'; ?>
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
                alert("任务名称必填");
                validateStatu.push(1);
				return false;
            }
            if(field2=='') {
                alert("任务介绍必填");
                validateStatu.push(1);
				return false;
            }
            if(field3=='') {
                alert("请填写达成目标");
                validateStatu.push(1);
				return false;
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
		
		///\
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
		
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});		
		
    });
	
	
<?php echo '</script'; ?>
>
<!-- end scripts-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>