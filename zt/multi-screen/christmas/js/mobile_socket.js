
$(function(){
	//服务器断开连接
	$.wsclose(function( data ){
		
	});
	//服务器连接成功
	$.wsopen( function( data ) {
		//匹配key
		if(key){
			$.wssend('name=' +key);
		}
	});
	
	//已有用户，提示用户扫码慢了
	$.wsmessage( 'msg', function( data ){
		$("#tips").show();
	});
	
	//响应成功，显示开始制作按钮
	$.wsmessage( 'key', function( data ){
		if(data){
			$("#sceneBtn").show();
		}
	});
	
	//放飞祝福
	$("#but").click(function(){
		var text = $("#chrismas_text").val();	//祝福语
//		alert(witch);
		$.wssend($.param( { operation : witch + 1, text : text, code : key} ) );
	});

});