// JavaScript Document
$(function(){

	//语音通知手风琴效果
	$(".voice_2 ul li").each(function(){
		var fold = $(this).find(".fold");
		var unfold = $(this).find(".unfold");
		if(fold.is(":hidden")){
			$(this).width(908);
		}else{
			$(this).width(92);
		}
	})

	$(".voice_2 ul li").click(function(){
		var li_index = $(this).index();
		$(this).animate({width:908},200);
		$(this).find(".unfold").show();
		$(this).find(".fold").hide();
		$(this).siblings().animate({width:92},200);
		$(this).siblings().find(".unfold").hide();
		$(this).siblings().find(".fold").show();
	})

})
