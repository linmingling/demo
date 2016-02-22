$("#mydh1").hover(
	function () {
		var jtdiv=$("#jt div");
		var con=$("#con");
		var content1='<div id="con" class="cn1"><p>活动期间，凡进店客户扫描关注梦天官方活动转发活动软文到朋友圈</p><p>即可获得<font class="jiacu">刘德华主演《解救吾先生》电影票一张</font></p><p style="font-size:18px;">（仅限每天前十名进店客户）</p></div>';
	    jtdiv.eq(0).css('visibility','visible');
		jtdiv.eq(1).css('visibility','hidden');
		jtdiv.eq(2).css('visibility','hidden');
		jtdiv.eq(3).css('visibility','hidden');
		con.replaceWith(content1); 	
	},function(){
	
	}
);
$("#mydh2").hover(
	function () {
		var jtdiv=$("#jt div");
		var con=$("#con");
		var content2='<div id="con" class="cn2"><p>活动期间，签单客户均赠送<font class="jiacu">梦天大礼包</font>一份;</p></div>';
	    jtdiv.eq(0).css('visibility','hidden');
		jtdiv.eq(1).css('visibility','visible');
		jtdiv.eq(2).css('visibility','hidden');
		jtdiv.eq(3).css('visibility','hidden');
		con.replaceWith(content2); 	
	},function(){
	
	}
);
$("#mydh3").hover(
	function () {
		var jtdiv=$("#jt div");
		var con=$("#con");
		var content3='<div id="con" class="cn3"><p>预交定金2000元即可获得抽奖机会，中奖即可获得去北京参加<font class="jiacu">“刘德华见面会”</font></p><p class="jiacu">注：每个抽奖码有三次抽奖机会</p></div>';
	    jtdiv.eq(0).css('visibility','hidden');
		jtdiv.eq(1).css('visibility','hidden');
		jtdiv.eq(2).css('visibility','visible');
		jtdiv.eq(3).css('visibility','hidden');
		con.replaceWith(content3); 	
	},function(){
	
	}
);
$("#mydh4").hover(
	function () {
		var jtdiv=$("#jt div");
		var con=$("#con");
		var content4='<div id="con" class="cn4"><table  border="0" cellspacing="0" cellpadding="0" width="95%" height="100%"><tr><td colspan=2 style="font-size:30px" class="jiacu">活动期间</td></tr><tr><td colspan=2>-------------------------------------------------------------------------------------------------------------</td></tr><tr><td width="55%">预交货款5000元即可<font class="jiacu">返现200元现金红包</font>；</td><td>预交货款10000元即可<font class="jiacu">返现500元现金红包</font>；</td></tr><tr><td>预交货款20000元即可<font class="jiacu">返现1000元现金红包</font>；</td><td>预交货款50000元即可<font class="jiacu">返现2500元现金红包</font>；</td></tr><tr><td colspan=2>预交货款100000元即可<font class="jiacu">返现6000元现金红包</font>；</td></tr></table></div>';
	    jtdiv.eq(0).css('visibility','hidden');
		jtdiv.eq(1).css('visibility','hidden');
		jtdiv.eq(2).css('visibility','hidden');
		jtdiv.eq(3).css('visibility','visible');
		con.replaceWith(content4); 	
	},function(){
	
	}
);

$("#prd1").hover(
	function () {
		$("#prd").attr('src','images/prd1.png');
		$(this).addClass('table-bg');	
		$("#prd2").removeClass('table-bg');	
		$("#prd3").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');
		$("#jiantou img").eq(0).css('visibility','visible');
		$("#jiantou img").not("[zdy='z1']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd2").hover(
	function () {
		$("#prd").attr('src','images/prd2.png');
		$(this).addClass('table-bg');
		$("#prd1").removeClass('table-bg');	
		$("#prd3").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');
		$("#jiantou img").eq(1).css('visibility','visible');
		$("#jiantou img").not("[zdy='z2']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd3").hover(
	function () {
		$("#prd").attr('src','images/prd3.png');
		$(this).addClass('table-bg');	
		$("#prd1").removeClass('table-bg');	
		$("#prd2").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');
		$("#jiantou img").eq(2).css('visibility','visible');
		$("#jiantou img").not("[zdy='z3']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd4").hover(
	function () {
		$("#prd").attr('src','images/prd4.png');
		$(this).addClass('table-bg');
		$("#prd1").removeClass('table-bg');	
		$("#prd2").removeClass('table-bg');
		$("#prd3").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');	
		$("#jiantou img").eq(3).css('visibility','visible');
		$("#jiantou img").not("[zdy='z4']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd5").hover(
	function () {
		$("#prd").attr('src','images/prd5.png');
		$(this).addClass('table-bg');	
		$("#prd1").removeClass('table-bg');	
		$("#prd2").removeClass('table-bg');
		$("#prd3").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');
		$("#jiantou img").eq(4).css('visibility','visible');
		$("#jiantou img").not("[zdy='z5']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd6").hover(
	function () {
		$("#prd").attr('src','images/prd6.png');
		$(this).addClass('table-bg');	
		$("#prd1").removeClass('table-bg');	
		$("#prd2").removeClass('table-bg');
		$("#prd3").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd7").removeClass('table-bg');
		$("#jiantou img").eq(5).css('visibility','visible');
		$("#jiantou img").not("[zdy='z6']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);
$("#prd7").hover(
	function () {
		$("#prd").attr('src','images/prd7.png');
		$(this).addClass('table-bg');	
		$("#prd1").removeClass('table-bg');	
		$("#prd2").removeClass('table-bg');
		$("#prd3").removeClass('table-bg');
		$("#prd4").removeClass('table-bg');
		$("#prd5").removeClass('table-bg');
		$("#prd6").removeClass('table-bg');
		$("#jiantou img").eq(6).css('visibility','visible');
		$("#jiantou img").not("[zdy='z7']").css('visibility','hidden');
	},function(){
		//$(this).removeClass('table-bg');
	}
);



