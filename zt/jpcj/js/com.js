$(function(){
	$('.x-top').height($('.x-t-bg').height());
	//goToTop
	$(window).scroll(function(){
		if($(window).scrollTop()>1000){
			$("#goToTop").show(100);
		}else{
			$("#goToTop").hide(100);
		}
	});
	$("#goToTop").click(function(){
		if(scroll=="off") return;
		$("html,body").animate({scrollTop: 0}, 300);
	})
})
