KISSY.use("node,anim,event", function(S, Node, Anim, Event) {
	S.all("#sp_sel_ul li").on("mousemove", function() {
		var perindex = null;
		S.all("#sp_sel_ul li").each(function(e) {
			var offsrc = "img/off" + S.one(this).index() + ".png";
			if (S.one(this).one("img").attr("src") != offsrc) {
				S.one(this).one("img").attr("src", offsrc);
				perindex = S.one(this).index();
				return false;
			}
		});
		var nowsrc = "img/on" + S.one(this).index() + ".png";
		S.one(this).one("img").attr("src", nowsrc);
		if (perindex == S.one(this).index()) {
			return false;
		}
		S.all("#sp_player div").item(perindex).stop(true)
		S.all("#sp_player div").item(perindex).hide();
		S.all("#sp_player div").item(S.one(this).index()).fadeIn(0.5);
	});
});