KISSY.use("node,anim,event", function(S, Node, Anim, Event) {
	var $ = KISSY.all;
$("#totop").addClass(".off_totop")
	$(window).on("scroll", function() {
		show();
	});
	$("#totop").on("mousedown",function(e){
		e.preventDefault();
		window.scrollTo(0,0)
	})
	if(KISSY.Features.isTransitionSupported()==false){
		$("#totop").hide();
	}
	function show() {
		
		if ($(window).scrollTop() > 0) {
			if($("#totop").hasClass(".on_totop")){return false;}
			$("#totop").removeClass(".off_totop");
			$("#totop").addClass(".on_totop");
			if(KISSY.Features.isTransitionSupported()==false){
				$("#totop").fadeIn();
			}
		} else {
			if($("#totop").hasClass(".off_totop")){return false;}
			$("#totop").removeClass(".on_totop");
			$("#totop").addClass(".off_totop");		
			if(KISSY.Features.isTransitionSupported()==false){
				$("#totop").fadeOut();
			}
		}

	}

});