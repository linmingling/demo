$(function(){
	$('.x-top').height($('.x-t-bg').height());
	// 品牌
	var mySwiper = new Swiper('#swiper',{
		loop:true,
		grabCursor: true,
		paginationClickable: true,
		autoplay:2500
	});
	$('.arrowLeft').on('click', function(e){
		e.preventDefault();
		mySwiper.swipePrev();
	});
	$('.arrowRight').on('click', function(e){
		e.preventDefault();
		mySwiper.swipeNext();
	});
  	// swiper 图片放大
	var imgWid = 0 ,imgHei = 0,imgWid2 = 0;imgHei2 =0,big = 1.5;
	$(".item img").hover(function(){
		$(this).stop();
		imgWid = $(this).width();
		imgHei = $(this).height();
		imgWid2 = imgWid * big;
		imgHei2 = imgHei * big;
		$(this).animate({"width":imgWid2,"height":imgHei2,"margin-left":-imgWid2/2+80,"margin-top":-10,"z-index":10});
		},function(){
			$(this).stop().animate({"width":imgWid,"height":imgHei,"margin-left":-imgWid/2+100,"margin-top":0,"z-index":0});
	})
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
