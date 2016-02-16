function nav(i){
	var hoverSpan = $(".r_l .hoverSpan");
	var navLi = $(".r_l ul li");
	var j=0,hoverX=0,hoverX2=0,hoverW=0;
	for(j=0;j<i;j++){
		hoverX = hoverX + navLi.eq(j).width();
	}
	hoverSpan.css({"width":navLi.eq(i).width()-20,"left":hoverX+10});  //鍒濆鍖�
	$(navLi).eq(i).find("a").addClass("hover");
	
	$(navLi).mouseover(function(){
		$(this).addClass("on");
		hoverX2 = 0;
		for(j=0;!($(navLi).eq(j).hasClass("on"));j++){
			hoverX2 = hoverX2 + navLi.eq(j).width();
		}
		$(hoverSpan).stop().animate({width:$(this).width()-20,left:hoverX2+10},300);
	});
	$(navLi).mouseout(function(){
		$(this).removeClass("on");
		$(hoverSpan).stop().animate({width:navLi.eq(i).width()-20,left:hoverX+10},300);
	});
}
$(function(){
	nav(1);
})