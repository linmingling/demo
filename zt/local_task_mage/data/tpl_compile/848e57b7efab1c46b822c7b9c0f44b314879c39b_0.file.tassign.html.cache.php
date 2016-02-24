<?php /* Smarty version 3.1.27, created on 2015-12-07 09:37:15
         compiled from "E:\wamp\www\workflow\template\admin\task\mage\tassign.html" */ ?>
<?php
/*%%SmartyHeaderCode:49165664e2cb3b5797_86030763%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '848e57b7efab1c46b822c7b9c0f44b314879c39b' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\admin\\task\\mage\\tassign.html',
      1 => 1449374628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49165664e2cb3b5797_86030763',
  'variables' => 
  array (
    'config' => 0,
    'tasks' => 0,
    'list' => 0,
    'users' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_5664e2cb501863_20668607',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_5664e2cb501863_20668607')) {
function content_5664e2cb501863_20668607 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '49165664e2cb3b5797_86030763';
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
&a=tassign" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 选择任务 </label>
                        <div class="col-sm-9">
                            <select class="form-control col-sm-9" id="form-field-1" size="10" name="taskId" style="height:85px">
								<?php if ($_smarty_tpl->tpl_vars['tasks']->value) {?>
									<option value="0">&nbsp;</option>
									<?php
$_from = $_smarty_tpl->tpl_vars['tasks']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['list'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['list']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
$foreach_list_Sav = $_smarty_tpl->tpl_vars['list'];
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['list']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['list']->value['task_name'];?>
</option>
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
							</select>
                        </div>
					</div>	
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right" for="form-field-3">  达成目标/最终目标</label>

                        <div class="col-sm-9">
                            <textarea cols="30" type="text" id="form-field-3" name="taskTarget" placeholder="达成目标/最终目标" class="col-xs-10 col-sm-5 form-field-3" style="height:75px"></textarea>
						</div>
                    </div>

				<div class="form-group">
					 <label class="col-sm-3  control-label no-padding-right" for="form-field-3">  指派给</label>
						<div class="col-sm-9">
							<select name="taskExecId" multiple="" class="width-80 chosen-select tag-input-style" id="form-field-select-4" data-placeholder="指派给" style="display: none;">
								<?php if ($_smarty_tpl->tpl_vars['users']->value) {?>
									<option value="0">&nbsp;</option>
									<?php
$_from = $_smarty_tpl->tpl_vars['users']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['user']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['user']->value) {
$_smarty_tpl->tpl_vars['user']->_loop = true;
$foreach_user_Sav = $_smarty_tpl->tpl_vars['user'];
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
</option>
									<?php
$_smarty_tpl->tpl_vars['user'] = $foreach_user_Sav;
}
if (!$_smarty_tpl->tpl_vars['user']->_loop) {
?>
										没有数据!
									<?php
}
?>	
								<?php }?>
							</select>
				
						</div>
				</div>

				<div class="form-group">
					 <label class="col-sm-3  control-label no-padding-right" for="form-field-3">  任务级别/紧急程度</label>
						<div class="col-sm-9">
							<select name="taskLevel" size="1">
								<option value="1">一般</option>
								<option value="2">紧急</option>
								<option value="3">非常紧急</option>
								<option value="4">不急</option>
							</select>
				
						</div>
				</div>


										
					<!--时间选择插件开始-->
					<div class="form-group">
                        <label class="col-sm-3  control-label no-padding-right" for="id-date-range-picker-1">任务开始时间</label>

                        <div class="col-sm-3">
						<div class="row">
							<div class="col-xs-8 col-sm-11">
								<div class="input-group">
									<input class="form-control date-picker" name="taskStartTime" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd">
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
									<input class="form-control date-picker"  name="taskEndTime" id="id-date-picker-2" type="text" data-date-format="yyyy-mm-dd">
									<span class="input-group-addon">
										<i class="icon-calendar bigger-110"></i>
									</span>
								</div>
							</div>
						</div>
						</div>
                    </div>		
					<input type="hidden" value="" class="uids" name="uids"/>					
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
			field1*=1;
            var field2 = $("#form-field-2").val();
            var field3 = $("#form-field-3").val();
            var select1 = $("#form-field-select-1").val();
            var validateStatu = new Array();
			var uids = new Array();;

            if(field1<1) {
                alert("请选择任务!");
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
			  $(".chosen-choices .search-choice .search-choice-close").each(function(){
			  var current_uid = $(this).attr('data-option-array-index');
			  current_uid*=1;
			  if(current_uid >0) {
					uids.push(current_uid);
				}
				
				var tids = JSON.stringify(uids);
				if(uids.length<1) {
					alett("请指派执行这个任务的人!");
					validateStatu.push(1);
					return false;
				}
				$('.uids').val(tids);
			  });
				document.getElementById('form-horizontal').submit();
            }
        });

		//
		
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
      //
	  
		$(".chosen-select").chosen(); 

    });
<?php echo '</script'; ?>
>
<!-- end scripts-->
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['config']->value['layout'])."/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0);

}
}
?>