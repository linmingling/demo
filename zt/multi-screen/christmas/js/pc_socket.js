
$(function(){
	//生成二维码
	jQuery('#chrismasEWM').qrcode({
		render:"table",
		text:mobile_url,
		width:110,
		height:110
	});
	//定位
	var _w;
	var chrismasCard =  $("#chrismasCard");
	function chrismasPosition(){
		_w = $(window).width();
		$("#leftEnter").css({"left":(_w-1000)/2-140});
		$("#rightEnter").css({"left":_w-(_w-1000)/2+20});
		chrismasCard.css({"left":_w/2-196});
	}
	chrismasPosition();
	$(window).resize(function(){
		chrismasPosition();
	});
	//贺卡出现
	function chrismasOpen(text, card){
		$("#chrismasAnim").addClass("plane");
		chrismasCard.find("p").html(text);
		chrismasCard.find(".cardImg img").hide().eq(card).show();
		setTimeout(function(){
			$("#leftEnter .chrismasImg").addClass("fadeOut");
			chrismasCard.fadeIn();
		},2000);
		setTimeout(function(){
			$("#chrismasAnim").removeClass("plane");
		},3000);
	}
	//贺卡消失

	$("#chrismasCard .cardClose").click(function(){
		chrismasCard.fadeOut();
		$("#leftEnter .chrismasImg").removeClass("fadeOut").addClass("fadeIn");
	});
	
	
	
	//key响应成功后滑屏
	$.wsmessage( 'show', function( data ){
		$("#tips").html('');
		$("#tips").html('响应成功');
	});
	
	//用户主动退出后，刷新页面
	$.wsmessage( 'out', function( data ){
		if(data){
			location.replace(location.href);
		}
	});
	
	//接收到放飞祝福指令后，播放动画
	$.wsmessage( 'operation', function( data ){
	 	chrismasOpen(data[0],parseInt(data[1]) - 1);
	});

	//服务器断开
	$.wsclose(function( data ){
		$('#chrismasEWM').hide();
		$('.chrismasTips').hide();
		$("#tips").html('断开连接');
	});

	//与服务器建立连接
	$.wsopen( function( data ) {
		$.wssend('name=pc_'+ key);
		return false;
	});
	
	//PC端连接成功后，显示二维码
	$.wsmessage( 'qrcode', function( data ) {
		if(data){
			$('#chrismasEWM').show();
			$('.chrismasTips').show();
			$("#tips").html('PC端连接成功');
		}
	});
	
});