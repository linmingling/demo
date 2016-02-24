KISSY.use("node,anim,event", function(S, Node, Anim, Event) {
	var pro_listArr=[13,172,332,493,654,827];
	var pro_actindex=0;
	var pro_actleft=13;
	var pro_preindex=0;
	var pro_click=true;
	S.all("#pro_list li").on("mousemove",function(){
		if(!pro_click){return false;}
		var that=S.one(this);
		pro_actindex=S.one(this).index();
		if(pro_preindex==pro_actindex){return false;}
		S.all("#pro_player li").item(pro_preindex).stop(true)
		S.all("#pro_player li").item(pro_preindex).hide();
		S.all("#pro_player li").item(pro_actindex).fadeIn(0.7);
		pro_actleft=pro_listArr[pro_actindex];
		pro_click=false;
		S.all("#pro_list li").item(pro_preindex).animate({
			"color":"#00000"
		},{
			easing: "linear",
			duration:0.3,
			
		});
		S.one(this).animate({
			"color":"#FFFFFF"
		},{
			easing: "easeOut",
			duration:0.3,
			complete: function(){
				pro_click=true;
			}
		});
		S.one("#pro_slide").animate({
			"left":pro_actleft
		},{
			easing: "swing",
			duration:0.3,
		});
		pro_preindex=S.one(this).index();
	});
});