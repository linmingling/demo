
$(function(){
	
	//key响应成功后滑屏
	$.wsmessage( 'show', function( data ){
		if(data){
			mySwiper.swipeTo(1);
		}
	});
	
	//用户主动退出后，刷新页面
	$.wsmessage( 'out', function( data ){
		if(data){
			location.replace(location.href);
		}
	});
	
	//场景确认后，切换至场景布局页
	$.wsmessage( 'operation', function( data ){
		mySwiper.swipeTo(parseInt(data)+1);
		//切换成功后，返回状态给moblie
//		$.wssend($.param( { mb_operation : data ,code : key} ) );
	});
	
	//接收来自mobile选场景指令
	$.wsmessage( 'scene', function( data ){
		
		mySwiper2.swipeTo(parseInt(data) - 1);
		//场景切换后，选择对应的人物
		$("#zp_person img").hide().eq(parseInt(data) - 1).show();
		$("#lj_person img").hide().eq(parseInt(data) - 1).show();
		
	});
	
	//接收来自mobile的物品选择
	$.wsmessage( 'select', function( data ){
		chose("#"+data[1], data[0]);
	});

	//对话
	$.wsmessage( 'result', function( data ){
		if(data[0]){
			dialog("#"+data[2], data[1]);
		}
	});
	
	//转盘启动
	$.wsmessage( 'dzp', function( data ){
		if(data){
			star();
			//转盘停止后切换下一页
			setTimeout(function(){
//				$.wssend($.param( { dzp_end : 6, code : key} ) );
				mySwiper.swipeNext();
				close();
			},4000);
		}
	});
	
	//转盘结束后，并且手机端以下一页，PC也下一页
	$.wsmessage( 'mb_dzp', function( data ){
		if(data){
			mySwiper.swipeNext();
		}
	});
	
	//服务器断开
	$.wsclose(function( data ){
		$('#qrcode').remove();
//		$('#message').append( '<div class="tips" style="color:red;">服务器已断开, 5秒后自动重试</div>' );
	});

	//与服务器建立连接
	$.wsopen( function( data ) {
		$.wssend('name=pc_'+ key);
		return false;
	});
	
	//PC端连接成功后，显示二维码
	$.wsmessage( 'qrcode', function( data ) {
		if(data){
			$('#qrcode').show();
		}
	});
	
});