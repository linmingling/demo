//WS_STATIC_URL = 'http://local.weixin/data/html/multiScreen/aqgy/static';
//// WS_STATIC_URL = 'http://zwl.nat123.net/static';
//WS_HOST = '127.0.0.1';
//WS_PORT = 8080;

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
	
	$.wsmessage( 'key', function( data ){
		if(data != 'false'){
			$("#sceneBtn").show();
		}
	});
	
	//我要帮忙
	$("#sceneBtn").click(function(){
		//场景选择确认后，切换至场景布局页
		$.wssend($.param( { operation : mySwiper2.activeIndex + 1} ) );
		return false;
	});

	//接收来自PC场景布局页的状态
	$.wsmessage( 'mb_operation', function( data ){
		mySwiper.swipeTo(data);
	});
	
	//发送选场景指令-右移
	$('.arrow-right').click(function(){
		if(mySwiper2.activeIndex + 1 < 4){
			$.wssend($.param( { scene : mySwiper2.activeIndex + 1, direction : 'right'} ) );
		}
	});
	
	//发送选场景指令-左移
	$('.arrow-left').click(function(){
		if(mySwiper2.activeIndex > 0){
			$.wssend($.param( { scene : mySwiper2.activeIndex, direction : 'left'} ) );
		}
	});
	
	//接收服务器返回的选场景指令
	$.wsmessage( 'mb_scene', function( data ){
		if(data[1] == 'right'){
			mySwiper2.swipeNext(data[0]);
		} else {
			mySwiper2.swipePrev(parseInt(data[0]) - 1);
		}
		
	});
	
	//选择摆放物品
	$(".swiper-slide .able").click(function(){
	
		sel = $(this).attr("s");
		type = $(this).attr("scene_type");
		
		$.wssend($.param( { select : sel, scene_type : type} ) );
		
		$(this).siblings().removeClass("true");
		$(this).removeClass("able").addClass("true");
	});
	
	//我选好了
	$(".btn").click(function(){
		var id = $(this).parent().attr("id");
		if(sel!=3){
			$("#"+id+" .true").removeClass("true able").addClass("false");
			$.wssend($.param( { result : 'false', select_id : sel, scene_type : type} ) );
		} else {
			//选择正确后，向pc发送切屏指令
			$.wssend($.param( { operation : 5} ) );
		}
	});
	
	//启动转盘
	$("#start").click(function(){
		$.wssend($.param( { dzp : 'start'} ) );
	});
});