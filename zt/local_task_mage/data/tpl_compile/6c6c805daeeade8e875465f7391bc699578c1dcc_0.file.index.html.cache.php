<?php /* Smarty version 3.1.27, created on 2015-12-07 16:26:19
         compiled from "E:\wamp\www\workflow\template\frontEnd\dashboard\index\index.html" */ ?>
<?php
/*%%SmartyHeaderCode:15068566542ab6aab18_98754131%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c6c805daeeade8e875465f7391bc699578c1dcc' => 
    array (
      0 => 'E:\\wamp\\www\\workflow\\template\\frontEnd\\dashboard\\index\\index.html',
      1 => 1449476680,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15068566542ab6aab18_98754131',
  'variables' => 
  array (
    'config' => 0,
    'userJson' => 0,
    'orgJson' => 0,
    'monDay' => 0,
    'bushJson' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_566542ab70c5a5_87480015',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_566542ab70c5a5_87480015')) {
function content_566542ab70c5a5_87480015 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '15068566542ab6aab18_98754131';
?>
<style>
body{
	margin:0 auto;
	height:100%;
}
.content{
	text-align:center;
	width:1000px;
	height:100%;
	position:position;
	margin:0 auto;
}
.tab{
	text-align:center;
	position:relative;
	margin:0px auto;
	width:675px;
	height:110px;
	border:1px solid #bcd4e5;
	margin-top:20px;
}
.bm{
	height:50px;
	width:80px;
	position:absolute;
	top:60px;
	color:black;
}
.name{
	height:50px;
	width:80px;
	background:white;
	position:absolute;
	top:60px;
	left:80px;
	color:black;
	background-image:url(<?php echo $_smarty_tpl->tpl_vars['config']->value['imageUrl'];?>
/5.png);
}

.header{
	height:30px;
	width:515px;
	position:absolute;
	left:160px;
	background:#ecf2f7;
	border-bottom:1px solid #bcd4e5;
}
.wdate{
	height:50px;
	width:515px;
	position:absolute;
	background:white;
	left:160px;
	top:60px;
}
.wdate div{
	border-top:1px solid grey;
	border-right:1px solid;
	border-radius:8px;
}
.day{
	height:31px;
	width:516px;
	position:absolute;
	left:160px;
	top:30px;
}
.sq{
	float:left;
	width:50px;
	height:30px;
	text-align:center;
	color:black;
	padding-top:5px;
}
.test{
	width:160px;
	height:60px;
	position:absolute;
	background:url(<?php echo $_smarty_tpl->tpl_vars['config']->value['imageUrl'];?>
/9.png);
}
.pop{
	width:200px;
	height:150px;
	background:white;
	border:1px solid grey;
	border-radius:0px 8px 8px 8px;
	box-shadow:0px 0px 30px #888888;
	position:absolute;
	z-index:5;
	display:none;
	padding:10px 20px;
}
.edit{
	width:425px;
	height:220px;
	border:1px solid grey;
	border-radius:8px;
	background:white;
	box-shadow:0px 0px 30px #888888;
	position:absolute;
	left:50%;
	top:50%;
	margin-top:-110px;
	margin-left:-212px;
	padding-top:10px;
	padding-left:20px;
	display:none;
}

.button {
	display: inline-block;
	zoom: 1; /* zoom and *display = ie7 hack for display:inline-block */
	*display: inline;
	vertical-align: baseline;
	outline: none;
	cursor: pointer;
	text-align: center;
	text-decoration: none;
	font: 14px/100% Arial, Helvetica, sans-serif;
	padding: .4em .5em .55em;
	text-shadow: 0 1px 1px rgba(0,0,0,.3);
	-webkit-border-radius: .5em; 
	-moz-border-radius: .5em;
	border-radius: .5em;
	-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
	box-shadow: 0 1px 2px rgba(0,0,0,.2);
	color: #606060;
	border: solid 1px #b7b7b7;
	background: #fff;
	background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ededed));
	background: -moz-linear-gradient(top,  #fff,  #ededed);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');
	-webkit-tap-highlight-color: rgba(0,0,0,0);
}
.button:hover {
	text-decoration: none;
	background: #ededed;
	background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#dcdcdc));
	background: -moz-linear-gradient(top,  #fff,  #dcdcdc);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#dcdcdc');
}
.button:active {
	position: relative;
	top: 1px;
	color: #999;
	background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#fff));
	background: -moz-linear-gradient(top,  #ededed,  #fff);
	filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#ffffff');
}	



/******/
.smart_menu_box{display:none; width:140px; position:absolute; z-index:201105;}
.smart_menu_body{padding:1px; border:1px solid #B8CBCB; background-color:#fff; -moz-box-shadow:2px 2px 5px #666; -webkit-box-shadow:2px 2px 5px #666; box-shadow:2px 2px 5px #666;}
.smart_menu_ul{margin:0; padding:0; list-style-type:none;}
.smart_menu_li{position:relative;}
.smart_menu_a{display:block; height:25px; line-height:24px; padding:0 5px 0 25px; color:#000; font-size:12px; text-decoration:none; overflow:hidden;}
.smart_menu_a:hover, .smart_menu_a_hover{background-color:#348CCC; color:#fff; text-decoration:none;}
.smart_menu_li_separate{line-height:0; margin:3px; border-bottom:1px solid #B8CBCB; font-size:0;}
.smart_menu_triangle{width:0; height:0; border:5px dashed transparent; border-left:5px solid #666; overflow:hidden; position:absolute; top:7px; right:5px;}
.smart_menu_a:hover .smart_menu_triangle, .smart_menu_a_hover .smart_menu_triangle{border-left-color:#fff;}
.smart_menu_li_hover .smart_menu_box{top:-1px; left:130px;}
/**/

	</style>
<body>
	<div class="content">
		<div class="tab" id="tab">
			<div class="test">
			</div>
			<div class="header">
				<div style="width:220px;margin-left:140px;">
					<a href="#" style="float:left" class="button" onclick="l_click()"><</a>
					<a href="#" style="float:right" class="button" onclick="r_click()">></a>
				</div>
				<div style="text-align:center;font-size:20px;color:black;margin-top:3px;"><span id="time">time here</span></div>
			</div>
			<div class="bm" id="bm"></div>
			<div class="name" id="name"></div>
			<div class="day">
				<div class="sq"><span>一</span></div>
				<div class="sq"><span>二</span></div>
				<div class="sq"><span>三</span></div>
				<div class="sq"><span>四</span></div>
				<div class="sq" style="border-right:1px solid #bcd4e5;border-radius:10px 0;"><span>五</span></div>
				<div class="sq" style="border-left:1px solid #bcd4e5;border-radius:0 10px; margin-left:14px;"><span>一</span></div>
				<div class="sq"><span>二</span></div>
				<div class="sq"><span>三</span></div>
				<div class="sq"><span>四</span></div>
				<div class="sq"><span>五</span></div>
			</div>
			<div class="wdate" id="wdate"></div>
		</div>
	</div>
	<div class="pop">
	</div>
	<div class="edit">
		<div>id:<span id="ed_id"></span></div>
		<div style="margin-left:20px;margin-top:30px;">
			<span>专题情况：</span>
			<input type="radio" value="type1" name="type">一般
			<input type="radio" value="type2" name="type">很急
			<input type="radio" value="type3" name="type">非常急
		</div>
		<div style="margin-top:20px;margin-left:20px;">
			<textarea id="ta" cols="50" rows="5" style="resize:none;"></textarea>
		</div>
		<div style="margin-left:120px;margin-top:10px;">
			<a class="button" style="padding:.4em .8em .55em;">提交</a>
			<a class="button" style="margin-left:50px;padding:.4em .8em .55em;" href="javascript:clear_edit()">取消</a>
		</div>
		<div style="top:-1px;right:-3px;width:30px;height:30px;position:absolute;"><a class="button" style="padding:.4em .7em .55em;border-radius:0px 8px 0px 8px;background:red;color:white;" href="javascript:close_edit()">x</a></div>
	</div>
</body>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/jquery-1.7.2.min.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['config']->value['jsUrl'];?>
/smartMenu.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
w=50;
h=50;

var member= eval('(' + '<?php echo $_smarty_tpl->tpl_vars['userJson']->value;?>
' + ')');//[["张三","1"],["李四","1"],["王五","1"],["赵一","2"],["李二","1"],["钱六","2"],["周七","2"],["孙八","1"]];//职员名称，部门编号
var bb=eval('(' + '<?php echo $_smarty_tpl->tpl_vars['orgJson']->value;?>
' + ')');      //[['设计部',5],['技术部',3]];//部门名称（根据编号排序由小到大），部门人数
var s_time="<?php echo $_smarty_tpl->tpl_vars['monDay']->value;?>
";
var task=[[21124,"哈哈哈专题"],[61125,"呵呵呵专题"],[31125,"嘿嘿嘿专题"],[51123,"嘻嘻嘻专题"],[81128,"哼哼哼专题"]];
var testdate=eval('(' + '<?php echo $_smarty_tpl->tpl_vars['bushJson']->value;?>
' + ')');//[[6,1448208000,1448294400,2],[2,1448294400,1448553600,3],[2,1448380800,1448812800,2]]; // 任务id，开始时间，结束时间，忙碌状态

var aa=1;//不同功能

function bm_sort(){
	var temp=[];
	for(var i=0;i<member.length;i++){
		for(var j=i;j<member.length;j++){
			if(member[i][1]>member[j][1]){
				temp=member[j];
				member[j]=member[i];
				member[i]=temp;
			}
		}
	}
}
function drawTable(){
	var tab=document.getElementById("tab");	
	var name=document.getElementById("name");	
	var bm=document.getElementById("bm");
	var wdate=document.getElementById("wdate");
	var high=member.length;
	tab.style.height=(high*50)+60;
	name.style.height=high*50;
	bm.style.height=high*50;
	wdate.style.height=high*50;
}
function ten_day(){
	var y=s_time.substr(0,4);
	var m=parseInt(s_time.substr(5,2));
	var d=parseInt(s_time.substr(8,2));
	var day = new Date(y,m,0); 
  var daycount = day.getDate();
  var t_d=new Array();
  if(m<10){
  	m="0"+m;
  }
  for(var i=0;i<5;i++){
		if(d==daycount){
			t_d[i]=m+""+d;
			m++;
			if(m<10){
		  	m="0"+m;
		  }
			d=1;
		}else{
			if(d<10){
				t_d[i]=m+"0"+d;
				d++;
			}else{
				t_d[i]=m+""+d;
				d++;
			}
		}
  }
  d=d+2;
  for(var i=5;i<10;i++){
  	if(d==daycount){
			t_d[i]=m+""+d;
			m++;
			if(m<10){
		  	m="0"+m;
		  }
			d=1;
		}else{
			if(d<10){
				t_d[i]=m+"0"+d;
				d++;
			}else{
				t_d[i]=m+""+d;
				d++;
			}
		}
  }
  return t_d;
}
function createTask(){
	var wdate=document.getElementById("wdate");	
	var t_d=ten_day();
	//console.log(t_d);
	for(var i=0;i<10;i++){
		for(var j=1;j<member.length+1;j++){
			div=document.createElement("div");
			div.style.width=w;
			div.style.height=h;
			//div.style.backgroundImage=bg;
			div.style.position="absolute";
			div.style.marginLeft=i*w;
			div.style.marginTop=(j-1)*h;
			div.setAttribute("id",j+""+t_d[i]);
			div.className="unwork";
			if(i>=5){
				div.style.marginLeft=(i*w)+15;
			}
			if(i==9){
				div.style.borderRight="1px solid grey";
			}
			if(i!=9){
				div.style.borderRight="1px solid grey";
			}
			if(i==5){
				div.style.borderLeft="1px solid grey";			
			}
			wdate.appendChild(div);
		}
	}
}
function changeTask(){
	for(var i=0;i<testdate.length;i++){
		var con_day=(testdate[i][2]-testdate[i][1])/86400;
		var time_s=new Date(testdate[i][1]*1000).Format("MMdd");
		var time_e=new Date(testdate[i][2]*1000).Format("MMdd");
		var t_d=ten_day();
		var s_num=0;
		var e_num=0;
		for(var k=0;k<t_d.length;k++){
			if(t_d[k]==time_s){
				s_num=k;
				break;
			}
		}
		for(var l=0;l<t_d.length;l++){
			if(t_d[l]==time_e){
				e_num=l;
				break;
			}
		}
		var task_date=t_d.slice(s_num,e_num+1);
		for(var j=0;j<task_date.length;j++){
			var temp=testdate[i][0]+""+task_date[j];
			var task=document.getElementById(temp);
			var isbusy="";
			var col=task.style.background;
			if(testdate[i][3]==2){
				if(col!="rgb(255,102,102)"&&col!="rgb(255, 153, 102)"){
					isbusy="#99cc66";//153,204,102
				}else{
					isbusy=col;
				}
			}else if(testdate[i][3]==3){
				if(col!="rgb(255,102,102)"){
					isbusy="#ff9966";//255,153,102
				}else{
					isbusy=col;
				}
			}else if(testdate[i][3]==4){
				isbusy="#ff6666";//255,102,102
			}
			task.style.background=isbusy;
			task.className="inwork";
		}
	}
}

Date.prototype.Format = function (fmt) { 
    var o = {
        "M+": this.getMonth() + 1, //月份 
        "d+": this.getDate(), //日 
        "h+": this.getHours(), //小时 
        "m+": this.getMinutes(), //分 
        "s+": this.getSeconds(), //秒 
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度 
        "S": this.getMilliseconds() //毫秒 
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

function clearTask(){
	$('#wdate').html("");
	createTask();
}
function createBm(){
	var bm=document.getElementById("bm");
	var n=0;	
	for(var i=0;i<bb.length;i++){
		div=document.createElement("div");
		div.style.width=80;
		if(Math.round(i/2)==1){
			div.style.background="url(<?php echo $_smarty_tpl->tpl_vars['config']->value['imageUrl'];?>
/6.png) no-repeat #ccffff";
		}else{
			div.style.background="url(<?php echo $_smarty_tpl->tpl_vars['config']->value['imageUrl'];?>
/6.png) no-repeat #ccffcc";
		}
		div.style.height=(h*bb[i][1])-((h*bb[i][1])/2-8);
		div.style.paddingTop=(h*bb[i][1])/2-8;
		div.setAttribute("name","bm");
		div.innerHTML=bb[i][0];
		bm.appendChild(div);
		n++;
		if(n==3)n=0;
	}
}
function createPerson(){
	var name=document.getElementById("name");
	for(var i=0;i<member.length;i++){
		div=document.createElement("div");
		div.style.width=80;
		div.style.height=h;
		div.style.position="absolute";
		div.style.marginTop=(i*h)+15;
		div.setAttribute("name","name");
		div.innerHTML=member[i][0];
		name.appendChild(div);
	}
}

function l_click(){
	var dataObj = {
       method:"GET",
       url:"<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
",
       data:{"type":"r_click", "stime":"", "etime":""},   
       success:function(){
       		clearTask();
					set_time();
					changeTask();
     	 },
       error:function(){
       	  alert("data error");
     	 }
    }
	$.ajax(dataObj);
}
function r_click(){
	var dataObj = {
       method:"GET",
       url:"<?php echo $_smarty_tpl->tpl_vars['config']->value['controllerUrl'];?>
",
       data:{"type":"r_click", "stime":"", "etime":""},   
       success:function(){
       		clearTask();
					set_time();
					changeTask();
     	 },
       error:function(){
       	  alert("data error");
     	 }
    }
	$.ajax(dataObj);
}
function set_time(){
	var time=document.getElementById("time");
	var t_d=ten_day();
	var s_t=t_d[0].substring(0,2)+"."+t_d[0].substring(2,4);
	var e_t=t_d[9].substring(0,2)+"."+t_d[9].substring(2,4);
	txt=s_t+"-"+e_t;
	time.innerHTML=txt;
}

var taskMenuData = [
    [{
        text: "修改任务",
        func: function() {
        		var id=$(this).attr("id");
            $("#ed_id").text(id);
            $(".edit").fadeIn();
            var dataObj = {
				       method:"POST",
				       url:"index.php",
				       data:{"id":id,"type":"edit"},   
				       success:function(){
				       		clearTask();
									set_time();
									changeTask();
				     	 },
				       error:function(){
				       	  alert("data error");
				     	 }
   					}
						$.ajax(dataObj);
        }
    }],[{text: "刷新" ,
    		 func: function(){
    		 		clearTask();
						set_time();
						changeTask();
    		 }
    	}]
];
var bodyMenuData = [
		[{ text: "刷新" ,
			 func: function(){
    		 		clearTask();
						set_time();
						changeTask();
    	 }
		}]];
var blankMenuData = [[{ text: "增加任务" ,
						func: function() {
            //alert($(this).attr("id"));
            $("#ed_id").text($(this).attr("id"));
            $(".edit").fadeIn();
            var dataObj = {
				       method:"POST",
				       url:"index.php",
				       data:{"id":id,"type":"add"},   
				       success:function(){
				       		clearTask();
									set_time();
									changeTask();
				     	 },
				       error:function(){
				       	  alert("data error");
				     	 }
   					}
						$.ajax(dataObj);
        }}],[{text: "刷新" }]];

function onlisten(){
	$(".inwork").smartMenu(taskMenuData, {
	    name: "inwork"    
	});
	$(".unwork").smartMenu(blankMenuData, {
	    name: "unwork"    
	});
	$("body").smartMenu(bodyMenuData, {
	    name: "body"    
	});
}

function normal(){
	$('.inwork').mousemove(function(e) { 
		var xx = e.pageX 
		var yy = e.pageY; 
		var id=$(this).attr("id");
		var txt="";
		for(var i=0;i<task.length;i++){
			if(task[i][0]==id){
				txt=task[i][1];
				break;
			}
		}
		$(".pop").css("display","block");
		$(".pop").css("left",xx);
		$(".pop").css("top",yy);
		$(".pop").text("id:"+id+"\n"+txt);
		//$(this).text(xx + '---' + yy); 
		console.log(xx+"---"+yy);
	}); 
	$('.inwork').mouseout(function(e) { 
		$(".pop").css("display","none");
	}); 
}

function start(){
	drawTable();
	bm_sort();
	createPerson()
	createBm();
	createTask();
	set_time();
	changeTask();
	if(aa==1){
		normal();
	}else{
		onlisten();
	}
}
start();

function close_edit(){
	$(".edit").fadeOut();
}
function clear_edit(){
	$(".edit").fadeOut();
	$("input[type=radio]").attr("checked",false);
	$("#ta").val("");
}
function sub_edit(){
	var type=$('input[type=radio]:checked').val();
	var text=$('#ta').val();
	var id=$('#ed_id').val();
	var configObj = {
       method:"POST",
       url:"index.php",
       data:{"id":id,"type":type,"text":text},   
       success:function(){
       		clearTask();
					set_time();
					changeTask();
     	 },
       error:function(){
       	  alert("data error");
     	 }
    }
	$.ajax(configObj);
}
<?php echo '</script'; ?>
>
<?php }
}
?>